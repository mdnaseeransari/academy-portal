<?php

namespace App\Http\Controllers;

use App\Models\AcademicClass;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\ExamSchedule;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Timetable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // =========================================================================
    // DASHBOARD
    // =========================================================================

    /**
     * Admin dashboard with stats and attendance overview.
     */
    public function dashboard(Request $request)
    {
        $selected_date = $request->get('date', Carbon::today()->toDateString());
        $selected_class_id = $request->get('class_id');

        // Top-level stats
        $totalStudents  = Student::count();
        $totalTeachers  = Teacher::count();
        $unreadContacts = Contact::where('status', 'unread')->count();

        // Today's attendance overview per class
        $all_classes = AcademicClass::withCount('students')->orderBy('name')->get();

        $attendance_overview = $all_classes->map(function ($class) use ($selected_date) {
            $studentIds = $class->students()->pluck('id');
            $total      = $studentIds->count();

            // Unique student-period combinations to prevent slot duplicates inflating overview percentages
            $total_records = Attendance::whereIn('student_id', $studentIds)
                ->where('date', $selected_date)
                ->count();

            if ($total_records > 0) {
                $present_records = Attendance::whereIn('student_id', $studentIds)
                    ->where('date', $selected_date)
                    ->where('status', 'present')
                    ->count();
                $absent_records = Attendance::whereIn('student_id', $studentIds)
                    ->where('date', $selected_date)
                    ->where('status', 'absent')
                    ->count();

                $present = round(($present_records / $total_records) * $total);
                $absent  = round(($absent_records / $total_records) * $total);
                $percentage = round(($present_records / $total_records) * 100, 1);
            } else {
                $present = 0;
                $absent  = 0;
                $percentage = 0;
            }

            return [
                'class_name' => $class->name,
                'class'      => $class,
                'total'      => $total,
                'present'    => $present,
                'absent'     => $absent,
                'percentage' => $percentage,
            ];
        });

        // Recent students (last 5 admitted) - Filtered by class if selected
        $recent_query = Student::with('user', 'academicClass');
        if ($selected_class_id) {
            $recent_query->where('class_id', $selected_class_id);
        }
        $recent_students = $recent_query->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent unread contacts (last 5)
        $recent_contacts = Contact::where('status', 'unread')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pending user registrations (last 5) - Filtered by class if selected
        $pending_query = User::where('role', 'student')
            ->where('status', 'pending')
            ->with('pendingAcademicClass');
        if ($selected_class_id) {
            $pending_query->where('pending_class_id', $selected_class_id);
        }
        $pending_registrations = $pending_query->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $stats = [
            'students'         => $totalStudents,
            'teachers'         => $totalTeachers,
            'unread'           => $unreadContacts,
            'unread_contacts'  => $unreadContacts,
            'pending_count'    => User::where('role', 'student')->where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'attendance_overview',
            'recent_students',
            'recent_contacts',
            'pending_registrations',
            'all_classes',
            'selected_class_id',
            'selected_date'
        ));
    }

    // =========================================================================
    // STUDENTS
    // =========================================================================

    /**
     * List students with optional class filter and name/roll search.
     */
    public function students(Request $request)
    {
        $query = Student::with('user', 'academicClass');

        if ($request->filled('class_filter')) {
            $query->where('class_id', $request->class_filter);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(roll_number) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereHas('user', fn ($u) => $u->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']));
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $classes  = AcademicClass::orderBy('name')->get();
        $search   = $request->search;
        $class_filter = $request->class_filter;

        return view('admin.students', compact('students', 'classes', 'search', 'class_filter'));
    }

    /**
     * Create a new user (role=student) and student record inside a transaction.
     */
    public function addStudent(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email_username' => 'required|string|max:255|unique:users,email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|numeric',
            'roll_number' => 'nullable|string|max:50',
            'academic_class_id' => 'required|exists:classes,id',
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'nullable|email|max:255',
            'parent_phone' => 'required|string|regex:/^[0-9]{10}$/|numeric',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits.',
            'parent_phone.regex' => 'Parent phone number must be exactly 10 digits.',
        ]);

        $fullEmail = $request->email_username . '@gmail.com';

        // Check if full email already exists
        if (User::where('email', $fullEmail)->exists()) {
            return back()->withErrors(['email_username' => 'This username is already taken.'])->withInput();
        }

        return DB::transaction(function() use ($request, $fullEmail) {
            // Create User
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $fullEmail,
                'password' => Hash::make($request->password), 
                'role' => 'student',
                'phone' => $request->phone,
                'status' => 'approved', // Admin adds, so auto-approved
            ]);

            // Create Student record
            Student::create([
                'user_id' => $user->id,
                'roll_number' => $request->roll_number ?: $this->generateRollNumber($request->academic_class_id),
                'class_id' => $request->academic_class_id,
                'parent_name' => $request->parent_name,
                'parent_email' => $request->parent_email,
                'parent_phone' => $request->parent_phone,
            ]);

            return redirect()->back()->with('success', 'Student added successfully!');
        });
    }

    /**
     * Update an existing student and their associated user.
     */
    public function updateStudent(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => ['required', 'email', Rule::unique('users', 'email')->ignore($student->user_id)],
            'academic_class_id' => 'required|exists:classes,id',
            'roll_number'    => ['required', 'string', 'max:50', Rule::unique('students', 'roll_number')->ignore($student->id)],
            'parent_name'    => 'nullable|string|max:255',
            'parent_phone'   => 'nullable|string|regex:/^[0-9]{10}$/|numeric',
            'address'        => 'nullable|string|max:500',
            'admission_date' => 'nullable|date',
        ], [
            'parent_phone.regex' => 'Parent phone number must be exactly 10 digits.',
        ]);

        DB::transaction(function () use ($request, $student) {
            $student->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $request->validate(['password' => 'string|min:8']);
                $student->user->update(['password' => Hash::make($request->password)]);
            }

            $student->update([
                'class_id'       => $request->academic_class_id,
                'roll_number'    => $request->roll_number,
                'parent_name'    => $request->parent_name,
                'parent_phone'   => $request->parent_phone,
                'address'        => $request->address,
                'admission_date' => $request->admission_date,
            ]);
        });

        return redirect()->route('admin.students')->with('success', 'Student updated successfully.');
    }

    /**
     * Delete a student and their associated user.
     */
    public function deleteStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);

        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.students')->with('success', 'Student deleted successfully.');
    }

    // =========================================================================
    // TEACHERS
    // =========================================================================

    /**
     * List teachers with optional search.
     */
    public function teachers(Request $request)
    {
        $query = Teacher::with('user', 'classes');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($u) => $u->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']));
        }

        $teachers = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $classes  = AcademicClass::orderBy('name')->get();
        $search   = $request->search;

        return view('admin.teachers', compact('teachers', 'classes', 'search'));
    }

    /**
     * Create a new user (role=teacher) and teacher record inside a transaction.
     */
    public function addTeacher(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email_username' => 'required|string|max:255|unique:users,email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|numeric',
            'subject' => 'required|string|max:100',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        $fullEmail = $request->email_username . '@gmail.com';

        // Check if full email already exists
        if (User::where('email', $fullEmail)->exists()) {
            return back()->withErrors(['email_username' => 'This username is already taken.'])->withInput();
        }

        // Create User
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $fullEmail,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'phone' => $request->phone,
            'status' => 'approved', // Admin adds, so auto-approved
        ]);

        // Create Teacher record
        Teacher::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Teacher added successfully!');
    }

    /**
     * Update an existing teacher and their associated user.
     */
    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('users', 'email')->ignore($teacher->user_id)],
            'subject'       => 'required|string|max:255',
            'phone'         => 'nullable|string|regex:/^[0-9]{10}$/|numeric',
            'qualification' => 'nullable|string|max:255',
            'academic_class_ids' => 'nullable|array',
            'academic_class_ids.*' => 'exists:classes,id',
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        DB::transaction(function () use ($request, $teacher) {
            $teacher->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $request->validate(['password' => 'string|min:8']);
                $teacher->user->update(['password' => Hash::make($request->password)]);
            }

            $teacher->update([
                'subject'       => $request->subject,
                'phone'         => $request->phone,
                'qualification' => $request->qualification,
            ]);

            // Sync many-to-many class assignments in the pivot table
            if ($request->has('academic_class_ids')) {
                $teacher->classes()->sync($request->academic_class_ids ?? []);
            } else {
                $teacher->classes()->sync([]);
            }
        });

        return redirect()->route('admin.teachers')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Delete a teacher, nullify their class assignment, and delete the user.
     */
    public function deleteTeacher($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        DB::transaction(function () use ($teacher) {
            // Detach classes assigned to the teacher
            $teacher->classes()->detach();

            $user = $teacher->user;
            $teacher->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.teachers')->with('success', 'Teacher deleted successfully.');
    }

    // =========================================================================
    // REPORTS
    // =========================================================================

    /**
     * Generate attendance and marks reports with optional filters.
     */
    public function reports(Request $request)
    {
        $classes = AcademicClass::orderBy('name')->get();

        // ── Attendance Report ──────────────────────────────────────────────
        $attMonth    = $request->get('month', now()->month);
        $attYear     = $request->get('year', now()->year);
        $attClassId  = $request->get('class_id');

        $attQuery = Attendance::with('student.user', 'student.academicClass')
            ->whereMonth('date', $attMonth)
            ->whereYear('date', $attYear);

        if ($attClassId) {
            $studentIds = Student::where('class_id', $attClassId)->pluck('id');
            $attQuery->whereIn('student_id', $studentIds);
        }

        $attendanceRecords = $attQuery->get();

        // Group by student: calculate their summary
        $attendance_report = $attendanceRecords
            ->groupBy('student_id')
            ->map(function ($records) {
                $total   = $records->count();
                $present = $records->where('status', 'present')->count();
                $absent  = $records->where('status', 'absent')->count();
                $late    = $records->where('status', 'late')->count();
                $student = $records->first()->student;

                // Skip orphaned records where student or user no longer exists
                if (!$student || !$student->user) {
                    return null;
                }

                return [
                    'name'       => $student->user->name,
                    'roll_no'    => $student->roll_number,
                    'total_days' => $total,
                    'present'    => $present,
                    'absent'     => $absent,
                    'late'       => $late,
                    'percentage' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
                ];
            })->filter()->values();

        // ── Marks Report ───────────────────────────────────────────────────
        $marksClassId = $request->get('class_id');
        $examType     = $request->get('exam_type');

        $marksQuery = Mark::with('student.user', 'student.academicClass');

        if ($marksClassId) {
            $studentIds = Student::where('class_id', $marksClassId)->pluck('id');
            $marksQuery->whereIn('student_id', $studentIds);
        }

        if ($examType) {
            $marksQuery->where('exam_type', $examType);
        }

        $marks_report = $marksQuery->orderBy('subject')->get()->map(function ($mark) {
            // Skip orphaned records where student or user no longer exists
            if (!$mark->student || !$mark->student->user) {
                return null;
            }

            $perc = $mark->total_marks > 0 ? round(($mark->marks_obtained / $mark->total_marks) * 100, 1) : 0;
            return [
                'roll_no' => $mark->student->roll_number,
                'name'    => $mark->student->user->name,
                'subject' => $mark->subject,
                'exam_type' => $mark->exam_type,
                'topic'   => $mark->topic,
                'date'    => $mark->date,
                'marks'   => $mark->marks_obtained,
                'total'   => $mark->total_marks,
                'percentage' => $perc,
            ];
        })->filter()->values();

        // ── Student Report ─────────────────────────────────────────────────
        $student_search = $request->get('student_search');
        $selected_student = null;

        if ($student_search) {
            $selected_student = Student::with('user', 'academicClass', 'marks', 'remarks.teacher')
                ->where('roll_number', $student_search)
                ->orWhereHas('user', function ($q) use ($student_search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($student_search) . '%']);
                })->first();

            if ($selected_student) {
                $totalAtt = Attendance::where('student_id', $selected_student->id)->count();
                $presentAtt = Attendance::where('student_id', $selected_student->id)->where('status', 'present')->count();
                $selected_student->attendance_percentage = $totalAtt > 0 ? round(($presentAtt / $totalAtt) * 100, 1) : 0;
                
                // Calculate Class Rank
                $class_students = Student::where('class_id', $selected_student->class_id)->with('marks')->get();
                $student_averages = [];
                foreach ($class_students as $cs) {
                    $c_marks = $cs->marks;
                    if ($c_marks->isEmpty()) {
                        $student_averages[$cs->id] = 0;
                        continue;
                    }
                    $c_totalObtained = $c_marks->sum('marks_obtained');
                    $c_totalMax = $c_marks->sum('total_marks');
                    $c_avg = $c_totalMax > 0 ? ($c_totalObtained / $c_totalMax) * 100 : 0;
                    $student_averages[$cs->id] = $c_avg;
                }
                arsort($student_averages); // Sort highest to lowest
                
                $rank = 1;
                foreach ($student_averages as $cs_id => $avg) {
                    if ($cs_id == $selected_student->id) {
                        $selected_student->class_rank = $rank;
                        break;
                    }
                    $rank++;
                }
                $selected_student->total_class_students = count($student_averages);
            }
        }

        // ── Academic Overview ──────────────────────────────────────────────
        $classPerformance = [];
        $tab = $request->get('tab', 'attendance');
        
        if ($tab === 'overview') {
            $classesWithMarks = AcademicClass::with(['students.user', 'students.marks'])->orderBy('name')->get();
            foreach ($classesWithMarks as $class) {
                $students = $class->students;
                $topStudent = null;
                $weakestStudent = null;
                $maxAvg = -1;
                $minAvg = 101;

                foreach ($students as $student) {
                    $marks = $student->marks;
                    if ($marks->isEmpty()) continue;
                    
                    $totalObtained = $marks->sum('marks_obtained');
                    $totalMax = $marks->sum('total_marks');
                    $avg = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
                    
                    if ($avg > $maxAvg) {
                        $maxAvg = $avg;
                        $topStudent = $student;
                    }
                    if ($avg < $minAvg) {
                        $minAvg = $avg;
                        $weakestStudent = $student;
                    }
                }
                
                if ($topStudent || $weakestStudent) {
                    $classPerformance[] = (object) [
                        'class' => $class,
                        'top_student' => $topStudent,
                        'top_avg' => $maxAvg,
                        'weakest_student' => $weakestStudent,
                        'weakest_avg' => $minAvg
                    ];
                }
            }
        }

        return view('admin.reports', compact(
            'classes',
            'attendance_report',
            'marks_report',
            'selected_student',
            'classPerformance',
            'tab'
        ));
    }

    // =========================================================================
    // CONTACTS
    // =========================================================================

    /**
     * List contact messages with optional status filter and search.
     */
    public function contacts(Request $request)
    {
        // Auto-delete messages older than 10 days
        Contact::where('created_at', '<', now()->subDays(10))->delete();

        $query = Contact::orderBy('created_at', 'desc');

        // Default to unread; passing tab=all shows everything
        if ($request->get('tab', 'unread') !== 'all') {
            $query->where('status', 'unread');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $searchTerm = '%' . strtolower($search) . '%';
                $q->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(email) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(message) LIKE ?', [$searchTerm]);
            });
        }

        $contacts = $query->paginate(20)->withQueryString();
        $unread_count = Contact::where('status', 'unread')->count();
        $total_count = Contact::count();
        $tab = $request->get('tab', 'unread');
        $search = $request->search;

        return view('admin.contacts', compact('contacts', 'unread_count', 'total_count', 'tab', 'search'));
    }

    /**
     * Mark a contact message as read.
     */
    public function markRead($id)
    {
        Contact::findOrFail($id)->update(['status' => 'read']);

        return redirect()->back()->with('success', 'Message marked as read.');
    }

    /**
     * Delete a contact message.
     */
    public function deleteContact($id)
    {
        Contact::findOrFail($id)->delete();

        return redirect()->route('admin.contacts')->with('success', 'Message deleted.');
    }

    // =========================================================================
    // TIMETABLE
    // =========================================================================

    /**
     * Show all timetable entries grouped by class and day.
     */
    public function timetable(Request $request)
    {
        $classes  = AcademicClass::orderBy('name')->get();
        $teachers = Teacher::with('user')->get()->sortBy(function($teacher) {
            return $teacher->user->name;
        });

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        $timetableQuery = Timetable::with('academicClass', 'teacher')
    ->orderBy('class_id')
    ->orderByRaw("
        CASE day
            WHEN 'Sunday' THEN 1
            WHEN 'Monday' THEN 2
            WHEN 'Tuesday' THEN 3
            WHEN 'Wednesday' THEN 4
            WHEN 'Thursday' THEN 5
            WHEN 'Friday' THEN 6
            WHEN 'Saturday' THEN 7
        END
    ")
    ->orderBy('time_start');

        $selected_class = $request->class_id;
        if (!$selected_class && $classes->isNotEmpty()) {
            $selected_class = $classes->first()->id;
        }

        if ($selected_class) {
            $timetableQuery->where('class_id', $selected_class);
        }

        // Grouped by day: ['Monday' => [entries...], ...]
        $timetable = $timetableQuery->get()->groupBy('day');

        return view('admin.timetable', compact('classes', 'teachers', 'days', 'timetable', 'selected_class'));
    }

    /**
     * Add a new timetable slot, checking for duplicate class+day+time conflicts.
     */
    public function addTimetable(Request $request)
    {
        $request->validate([
            'academic_class_id' => 'required|exists:classes,id',
            'day'        => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'subject'    => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'time_start' => 'required|date_format:H:i',
            'time_end'   => 'required|date_format:H:i|after:time_start',
        ]);

        // Check for overlapping slot in same class on same day
        $conflict = Timetable::where('class_id', $request->academic_class_id)
            ->where('day', $request->day)
            ->where(function ($q) use ($request) {
                $q->where(function ($inner) use ($request) {
                    $inner->where('time_start', '<', $request->time_end)
                          ->where('time_end', '>', $request->time_start);
                });
            })->exists();

        if ($conflict) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['time_start' => 'This time slot overlaps with an existing entry for this class on the same day.']);
        }

        Timetable::create([
            'class_id'   => $request->academic_class_id,
            'day'        => $request->day,
            'subject'    => $request->subject,
            'teacher_id' => $request->teacher_id,
            'time_start' => $request->time_start,
            'time_end'   => $request->time_end,
        ]);

        return redirect()->route('admin.timetable')->with('success', 'Timetable slot added successfully.');
    }

    /**
     * Delete a timetable slot.
     */
    public function deleteTimetable($id)
    {
        Timetable::findOrFail($id)->delete();

        return redirect()->route('admin.timetable')->with('success', 'Timetable slot deleted.');
    }

    // =========================================================================
    // REGISTRATION APPROVALS
    // =========================================================================

    public function pendingUsers(Request $request)
    {
        $query = User::where('role', 'student')->where('status', 'pending');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $searchTerm = '%' . strtolower($search) . '%';
                $q->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(email) LIKE ?', [$searchTerm]);
            });
        }

        $pendingUsers = $query->orderBy('created_at', 'desc')->get();
        $search = $request->search;
        
        return view('admin.pending-users', compact('pendingUsers', 'search'));
    }

    public function approveUser($id)
    {
        return DB::transaction(function() use ($id) {
            $user = User::findOrFail($id);

            if ($user->status !== 'pending') {
                return redirect()->back()->with('error', 'User is not pending approval.');
            }

            // At approval time, create the official Student record using the
            // pending registration data stored on the User row.
            $classId    = $user->pending_class_id;
            $rollNumber = $classId
                ? $this->generateRollNumber($classId)
                : 'REG-' . strtoupper(\Illuminate\Support\Str::random(6));

            Student::create([
                'user_id'      => $user->id,
                'class_id'     => $classId,
                'roll_number'  => $rollNumber,
                'parent_name'  => $user->pending_parent_name,
                'parent_email' => $user->pending_parent_email,
                'parent_phone' => $user->pending_parent_phone,
                'admission_date' => now()->toDateString(),
            ]);

            // Approve user and clear the pending registration staging fields
            $user->update([
                'status'               => 'approved',
                'pending_class_id'     => null,
                'pending_parent_name'  => null,
                'pending_parent_email' => null,
                'pending_parent_phone' => null,
            ]);

            return redirect()->back()->with('success', 'Student approved successfully!');
        });
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Student rejected.');
    }

    // =========================================================================
    // CLASS MANAGEMENT
    // =========================================================================

    public function classes(Request $request)
    {
        $query = AcademicClass::with('teacher', 'students');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $classes = $query->get();
        $search = $request->search;

        return view('admin.classes', compact('classes', 'search'));
    }

    public function addClass(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:100|unique:classes,name',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $class = AcademicClass::create([
            'name' => $request->class_name,
            'teacher_id' => $request->teacher_id,
        ]);

        if ($request->filled('teacher_id')) {
            $class->teachers()->syncWithoutDetaching([$request->teacher_id]);
        }

        return redirect()->back()->with('success', 'Class added successfully!');
    }

    public function editClass(Request $request, $id)
    {
        $class = AcademicClass::findOrFail($id);
        
        $request->validate([
            'class_name' => 'required|string|max:100|unique:classes,name,' . $id,
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $class->update([
            'name' => $request->class_name,
            'teacher_id' => $request->teacher_id,
        ]);

        if ($request->filled('teacher_id')) {
            $class->teachers()->syncWithoutDetaching([$request->teacher_id]);
        }

        return redirect()->back()->with('success', 'Class updated successfully!');
    }

    public function deleteClass($id)
    {
        $class = AcademicClass::findOrFail($id);
        
        // Check if class has students
        if ($class->students()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete class with students. Move students to another class first.');
        }
        
        $class->delete();
        
        return redirect()->back()->with('success', 'Class deleted successfully!');
    }

    private function generateRollNumber($classId)
    {
        $class = AcademicClass::find($classId);
        if (!$class) return 'UNK-000';

        // Extract numbers and letters, stripping "Class" prefix
        $prefix = preg_replace('/^Class\s+/i', '', $class->name);
        $prefix = str_replace(' ', '', $prefix); // Remove spaces

        // Get all roll numbers for this class to find the true maximum
        $lastStudent = Student::where('class_id', $classId)
            ->where('roll_number', 'like', $prefix . '-%')
            ->get()
            ->map(function($s) {
                $parts = explode('-', $s->roll_number);
                return (int) end($parts);
            })
            ->max();

        $nextNum = ($lastStudent ?: 0) + 1;

        return $prefix . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    }

    // =========================================================================
    // FEATURE 1: ADMIN ASSIGNMENTS, ATTENDANCE, AND MARKS
    // =========================================================================

    private function mapExamType($type)
    {
        return match($type) {
            'Weekly Assessment' => 'weekly_assessment',
            'Mock Test' => 'mock_test',
            'Unit Test' => 'unit_test',
            'Half Yearly' => 'half_yearly',
            'Final' => 'final',
            'Other' => 'other',
            default => $type,
        };
    }

    private function getSelectedClassId(Request $request)
    {
        if ($request->has('class_id')) {
            $classId = $request->get('class_id');
            session(['admin_selected_class_id' => $classId]);
            return $classId;
        }

        $classId = session('admin_selected_class_id');
        if ($classId && AcademicClass::where('id', $classId)->exists()) {
            return $classId;
        }

        $firstClass = AcademicClass::orderBy('name')->first();
        if ($firstClass) {
            session(['admin_selected_class_id' => $firstClass->id]);
            return $firstClass->id;
        }

        return null;
    }

    public function assignmentsPage(Request $request)
    {
        $classes = AcademicClass::orderBy('name')->get();
        $selected_class_id = $this->getSelectedClassId($request);

        $assignments = collect();
        if ($selected_class_id) {
            $assignments = Assignment::where('class_id', $selected_class_id)
                ->with(['submissions', 'academicClass', 'creator'])
                ->withCount('submissions')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.assignments', compact('assignments', 'classes', 'selected_class_id'));
    }

    public function createAssignment(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:today',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $result = cloudinary()->uploadApi()->upload($request->file('file')->getRealPath(), [
                'folder' => 'assignments',
                'resource_type' => 'auto',
            ]);
            $filePath = $result['secure_url'];
        }

        Assignment::create([
            'class_id' => $request->class_id,
            'teacher_id' => auth()->id(), // Admin user ID
            'created_by' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'due_date' => $request->due_date,
        ]);

        return redirect()->back()->with('success', 'Assignment created successfully!');
    }

    public function deleteAssignment($id)
    {
        $assignment = Assignment::with('submissions')->findOrFail($id);

        $extractCloudinaryInfo = function($url) {
            $pattern = '/res\.cloudinary\.com\/[^\/]+\/([^\/]+)\/upload\/(?:v\d+\/)?([^\.]+)/';
            if (preg_match($pattern, $url, $matches)) {
                return ['type' => $matches[1], 'public_id' => $matches[2]];
            }
            return null;
        };

        if ($assignment->file_path) {
            $info = $extractCloudinaryInfo($assignment->file_path);
            if ($info) {
                try {
                    cloudinary()->uploadApi()->destroy($info['public_id'], ['resource_type' => $info['type']]);
                } catch (\Exception $e) {
                    // Ignore
                }
            }
        }

        foreach ($assignment->submissions as $submission) {
            if ($submission->file_path) {
                $info = $extractCloudinaryInfo($submission->file_path);
                if ($info) {
                    try {
                        cloudinary()->uploadApi()->destroy($info['public_id'], ['resource_type' => $info['type']]);
                    } catch (\Exception $e) {
                        // Ignore
                    }
                }
            }
        }

        $assignment->delete();

        return redirect()->route('admin.assignments', ['class_id' => $assignment->class_id])->with('success', 'Assignment and associated files deleted.');
    }

    public function attendancePage(Request $request)
    {
        $classes = AcademicClass::orderBy('name')->get();
        $selected_class_id = $this->getSelectedClassId($request);

        $selected_date = $request->get('date', Carbon::today()->toDateString());
        $period_slot = $request->get('period_slot') ? trim($request->get('period_slot')) : null;

        $students = collect();
        $existing_attendance = collect();
        $already_marked = false;
        $available_slots = collect();

        if ($selected_class_id && $selected_date) {
            // Get available slots for this day
            $available_slots = Attendance::where('class_id', $selected_class_id)
                ->where('date', $selected_date)
                ->select('period_slot')
                ->selectRaw('MAX(created_at) as created_at')
                ->selectRaw('MAX(marked_by) as marked_by')
                ->groupBy('period_slot')
                ->with('markedBy')
                ->orderBy('created_at', 'asc')
                ->get();
                
            $dayOfWeek = Carbon::parse($selected_date)->format('l');
            $scheduled_slots = Timetable::where('class_id', $selected_class_id)
                ->where('day', $dayOfWeek)
                ->orderBy('time_start')
                ->get();
        } else {
            $scheduled_slots = collect();
        }

        if ($selected_class_id && $period_slot) {
            $students = Student::where('class_id', $selected_class_id)->with('user')->get();
            $existing_attendance = Attendance::where('class_id', $selected_class_id)
                ->where('date', $selected_date)
                ->where('period_slot', $period_slot)
                ->get()
                ->keyBy('student_id');

            if ($existing_attendance->isNotEmpty()) {
                $already_marked = true;
            }
        }

        return view('admin.attendance', compact(
            'students',
            'classes',
            'selected_class_id',
            'selected_date',
            'period_slot',
            'already_marked',
            'existing_attendance',
            'available_slots',
            'scheduled_slots'
        ));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'period_slot' => 'required|string|max:100',
            'attendance' => 'required|array',
        ]);

        $period_slot = trim($request->period_slot);
        $date = $request->date;

        // Normalize target slot for matching
        $targetSubject = null;
        $targetStartTime = null;

        if (preg_match('/^(.+?)\s+(\d{1,2}:\d{2})/i', $period_slot, $matches)) {
            $targetSubject = strtolower(trim($matches[1]));
            $targetStartTime = trim($matches[2]);
            if (strlen($targetStartTime) === 4) {
                $targetStartTime = '0' . $targetStartTime;
            }
        }

        DB::transaction(function () use ($request, $date, $period_slot, $targetSubject, $targetStartTime) {
            foreach ($request->attendance as $student_id => $data) {
                $existing = Attendance::where('student_id', $student_id)
                    ->where('date', $date)
                    ->get();

                $matchedRecord = null;
                if ($targetSubject && $targetStartTime) {
                    foreach ($existing as $record) {
                        if ($record->period_slot) {
                            $rec_slot = trim($record->period_slot);
                            if (preg_match('/^(.+?)\s+(\d{1,2}:\d{2})/i', $rec_slot, $m)) {
                                $recSubject = strtolower(trim($m[1]));
                                $recStartTime = trim($m[2]);
                                if (strlen($recStartTime) === 4) {
                                    $recStartTime = '0' . $recStartTime;
                                }
                                if ($recSubject === $targetSubject && $recStartTime === $targetStartTime) {
                                    $matchedRecord = $record;
                                    break;
                                }
                            }
                        }
                    }
                }

                if ($matchedRecord) {
                    $matchedRecord->update([
                        'class_id' => $request->class_id,
                        'period_slot' => $period_slot, // Overwrite slot text to latest format
                        'status' => $data['status'],
                        'marked_by' => auth()->id()
                    ]);
                } else {
                    Attendance::create([
                        'student_id' => $student_id,
                        'class_id' => $request->class_id,
                        'date' => $date,
                        'period_slot' => $period_slot,
                        'status' => $data['status'],
                        'marked_by' => auth()->id()
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Attendance records updated successfully for ' . Carbon::parse($request->date)->format('M d, Y') . ' (' . $period_slot . ')');
    }

    /**
     * Delete student attendance records for a given slot.
     */
    public function deleteAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'period_slot' => 'required|string',
        ]);

        $period_slot = trim($request->period_slot);
        $date = $request->date;

        // Normalize target slot for matching
        $targetSubject = null;
        $targetStartTime = null;

        if (preg_match('/^(.+?)\s+(\d{1,2}:\d{2})/i', $period_slot, $matches)) {
            $targetSubject = strtolower(trim($matches[1]));
            $targetStartTime = trim($matches[2]);
            if (strlen($targetStartTime) === 4) {
                $targetStartTime = '0' . $targetStartTime;
            }
        }

        // Fetch all attendance for this class and date
        $records = Attendance::where('class_id', $request->class_id)
            ->where('date', $date)
            ->get();

        $deletedCount = 0;
        foreach ($records as $record) {
            $normalizedSlot = $record->period_slot;
            if ($record->period_slot) {
                $rec_slot = trim($record->period_slot);
                if (preg_match('/^(.+?)\s+(\d{1,2}:\d{2})/i', $rec_slot, $m)) {
                    $recSubject = strtolower(trim($m[1]));
                    $recStartTime = trim($m[2]);
                    if (strlen($recStartTime) === 4) {
                        $recStartTime = '0' . $recStartTime;
                    }
                    if ($targetSubject && $targetStartTime && $recSubject === $targetSubject && $recStartTime === $targetStartTime) {
                        $record->delete();
                        $deletedCount++;
                        continue;
                    }
                }
            }
            
            // Fallback exact string match
            if (trim($record->period_slot) === $period_slot) {
                $record->delete();
                $deletedCount++;
            }
        }

        return redirect()->route('admin.attendance', [
            'class_id' => $request->class_id,
            'date' => $date
        ])->with('success', 'Successfully deleted ' . $deletedCount . ' attendance records for slot: ' . $period_slot);
    }

    public function marksPage(Request $request)
    {
        $classes = AcademicClass::orderBy('name')->get();
        $selected_class_id = $this->getSelectedClassId($request);

        $exam_type = $request->get('exam_type', 'Weekly Assessment');
        $db_exam_type = $this->mapExamType($exam_type);

        $subject = $request->get('subject');
        $topic = $request->get('topic');
        $exam_date = $request->get('date', Carbon::today()->toDateString());
        $total_marks = $request->get('total_marks', 100);

        $students = collect();
        $previous_marks = collect();

        $uploaded_exams = collect();

        // Get list of unique subjects recorded in timetable or marks to pre-populate dropdown
        $existing_subjects = Timetable::pluck('subject')
            ->concat(Mark::pluck('subject'))
            ->unique()
            ->filter()
            ->values();

        // Fetch uploaded exams history
        $uploaded_exams_query = Mark::join('students', 'marks.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('marks.exam_type', 'marks.subject', 'marks.topic', 'marks.date', 'marks.total_marks', 'classes.name as class_name', 'classes.id as class_id')
            ->distinct();

        if ($selected_class_id) {
            $uploaded_exams_query->where('classes.id', $selected_class_id);
        }

        $uploaded_exams = $uploaded_exams_query
            ->orderBy('marks.date', 'desc')
            ->get();

        // Fetch all scheduled (upcoming) exams across all classes
        $scheduled_exams_query = ExamSchedule::with(['academicClass', 'creator'])
            ->where('scheduled_date', '>=', Carbon::today());

        $scheduled_exams = $scheduled_exams_query->orderBy('scheduled_date', 'asc')->get();

        if ($selected_class_id) {
            $students = Student::where('class_id', $selected_class_id)->with('user')->get();
            $studentIds = $students->pluck('id');

            if ($subject && $topic && $exam_date) {
                $previous_marks = Mark::whereIn('student_id', $studentIds)
                    ->where('exam_type', $db_exam_type)
                    ->where('subject', $subject)
                    ->where('topic', $topic)
                    ->where('date', $exam_date)
                    ->with('student.user')
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('admin.marks', compact(
            'students',
            'classes',
            'selected_class_id',
            'exam_type',
            'subject',
            'topic',
            'exam_date',
            'total_marks',
            'previous_marks',
            'existing_subjects',
            'uploaded_exams',
            'scheduled_exams'
        ));
    }

    public function saveMarks(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'exam_type' => 'required|string',
            'subject' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'date' => 'required|date',
            'total_marks' => 'required|numeric|min:1|max:1000',
            'marks' => 'required|array',
        ]);

        $db_exam_type = $this->mapExamType($request->exam_type);

        DB::transaction(function () use ($request, $db_exam_type) {
            foreach ($request->marks as $student_id => $data) {
                $marksObtained = isset($data['absent']) ? 0 : ($data['marks_obtained'] ?? 0);

                Mark::updateOrCreate(
                    [
                        'student_id' => $student_id,
                        'subject' => $request->subject,
                        'exam_type' => $db_exam_type,
                        'topic' => $request->topic,
                        'date' => $request->date,
                    ],
                    [
                        'marks_obtained' => $marksObtained,
                        'total_marks' => $request->total_marks,
                        'teacher_id' => auth()->id(), // Marked by admin
                        'remarks' => $data['remarks'] ?? null,
                    ]
                );
            }
        });

        return redirect()->back()->with('success', 'Marks saved successfully for ' . $request->subject . ' (' . $request->exam_type . ')');
    }

    /**
     * View submissions for a specific assignment.
     */
    public function viewSubmissions($assignmentId)
    {
        $assignment = Assignment::with(['submissions.student.user'])
            ->findOrFail($assignmentId);

        return view('admin.submissions', compact('assignment'));
    }

    /**
     * Update marks/grade for a submission.
     */
    public function updateMarks(Request $request, $submissionId)
    {
        $submission = \App\Models\AssignmentSubmission::with('assignment')->findOrFail($submissionId);
        
        $request->validate([
            'grade' => 'nullable|string|max:10',
        ]);

        $submission->grade = $request->grade;
        $submission->save();

        return back()->with('success', 'Grade updated successfully!');
    }

    /**
     * Schedule an upcoming exam / test to notify students.
     */
    public function scheduleExam(Request $request)
    {
        $request->validate([
            'class_id'       => 'required|exists:classes,id',
            'subject'        => 'required|string|max:255',
            'topic'          => 'required|string|max:255',
            'exam_type'      => 'required|string|max:100',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'total_marks'    => 'required|numeric|min:1|max:1000',
        ]);

        ExamSchedule::create([
            'class_id'       => $request->class_id,
            'created_by'     => auth()->id(),
            'subject'        => $request->subject,
            'topic'          => $request->topic,
            'exam_type'      => $request->exam_type,
            'scheduled_date' => $request->scheduled_date,
            'total_marks'    => $request->total_marks,
        ]);

        return redirect()->back()->with('success', 'Exam scheduled successfully! Students will see this notification on their dashboard.');
    }

    /**
     * Delete a scheduled exam.
     */
    public function deleteExamSchedule($id)
    {
        $schedule = ExamSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Exam schedule removed.');
    }
}
