<?php

namespace App\Http\Controllers;

use App\Models\AcademicClass;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Contact;
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
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();

        // Top-level stats
        $totalStudents  = Student::count();
        $totalTeachers  = Teacher::count();
        $unreadContacts = Contact::where('status', 'unread')->count();

        // REPAIR: Find "Ghost" students (Approved Users with role 'student' but no Student record)
        // This can happen if a previous creation failed midway.
        $ghostStudents = User::where('role', 'student')
            ->where('status', 'approved')
            ->whereDoesntHave('student')
            ->get();

        foreach ($ghostStudents as $ghost) {
            // We don't know their class, so we'll put them in a placeholder or just wait for admin to edit
            // For now, let's just create the record so they show up in the list and can login.
            Student::create([
                'user_id' => $ghost->id,
                'roll_number' => 'RECOVERED-' . $ghost->id,
                'class_id' => AcademicClass::first()->id ?? null, // Default to first class if available
            ]);
        }

        // Today's attendance overview per class
        $classes = AcademicClass::withCount('students')->get();

        $attendance_overview = $classes->map(function ($class) use ($today) {
            $studentIds = $class->students()->pluck('id');
            $total      = $studentIds->count();

            $present = Attendance::whereIn('student_id', $studentIds)
                ->where('date', $today)->where('status', 'present')->count();
            $absent  = Attendance::whereIn('student_id', $studentIds)
                ->where('date', $today)->where('status', 'absent')->count();

            $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

            return [
                'class_name' => $class->name,
                'class'      => $class,
                'total'      => $total,
                'present'    => $present,
                'absent'     => $absent,
                'percentage' => $percentage,
            ];
        });

        // Recent students (last 5 admitted)
        $recent_students = Student::with('user', 'academicClass')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent unread contacts (last 5)
        $recent_contacts = Contact::where('status', 'unread')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pending user registrations (last 5)
        $pending_registrations = User::where('role', 'student')
            ->where('status', 'pending')
            ->with('student.academicClass')
            ->orderBy('created_at', 'desc')
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
            'pending_registrations'
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

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('roll_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $classes  = AcademicClass::orderBy('name')->get();
        $search   = $request->search;
        $class_filter = $request->class_id;

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

        $fullEmail = $request->email_username . '@optimal.com';

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
            $query->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
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

        $fullEmail = $request->email_username . '@optimal.com';

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
            'academic_class_id' => 'nullable|exists:classes,id',
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

            // Remove teacher from any class that currently has them, then reassign
            AcademicClass::where('teacher_id', $teacher->user_id)
                ->update(['teacher_id' => null]);

            if ($request->filled('academic_class_id')) {
                AcademicClass::where('id', $request->academic_class_id)
                    ->update(['teacher_id' => $teacher->user_id]);
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
            // Nullify class assignment
            AcademicClass::where('teacher_id', $teacher->user_id)
                ->update(['teacher_id' => null]);

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

                return [
                    'name'       => $student->user->name,
                    'roll_no'    => $student->roll_number,
                    'total_days' => $total,
                    'present'    => $present,
                    'absent'     => $absent,
                    'late'       => $late,
                    'percentage' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
                ];
            })->values();

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
            $perc = $mark->total_marks > 0 ? round(($mark->marks_obtained / $mark->total_marks) * 100, 1) : 0;
            $grade = match(true) {
                $perc >= 90 => 'A+',
                $perc >= 80 => 'A',
                $perc >= 70 => 'B',
                $perc >= 60 => 'C',
                default => 'D'
            };
            return [
                'roll_no' => $mark->student->roll_number,
                'name'    => $mark->student->user->name,
                'marks'   => $mark->marks_obtained,
                'total'   => $mark->total_marks,
                'percentage' => $perc,
                'grade'   => $grade
            ];
        });

        // ── Student Report ─────────────────────────────────────────────────
        $student_search = $request->get('student_search');
        $selected_student = null;

        if ($student_search) {
            $selected_student = Student::with('user', 'academicClass', 'marks', 'remarks.teacher')
                ->where('roll_number', $student_search)
                ->orWhereHas('user', function ($q) use ($student_search) {
                    $q->where('name', 'like', "%{$student_search}%");
                })->first();

            if ($selected_student) {
                $totalAtt = Attendance::where('student_id', $selected_student->id)->count();
                $presentAtt = Attendance::where('student_id', $selected_student->id)->where('status', 'present')->count();
                $selected_student->attendance_percentage = $totalAtt > 0 ? round(($presentAtt / $totalAtt) * 100, 1) : 0;
            }
        }

        $tab = $request->get('tab', 'attendance');

        return view('admin.reports', compact(
            'classes',
            'attendance_report',
            'marks_report',
            'selected_student',
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
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
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
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
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
            
            // Create Student record only if it doesn't exist
            $student = Student::where('user_id', $user->id)->first();
            
            if (!$student) {
                Student::create([
                    'user_id' => $user->id,
                    'roll_number' => 'TEMP-' . $user->id, 
                    'class_id' => null,
                ]);
            } else {
                // Update the temporary roll number to the professional format
                if ($student->class_id) {
                    $student->update([
                        'roll_number' => $this->generateRollNumber($student->class_id)
                    ]);
                }
            }
            
            // Approve user
            $user->update(['status' => 'approved']);
            
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
            $query->where('name', 'like', "%{$search}%");
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

        AcademicClass::create([
            'name' => $request->class_name,
            'teacher_id' => $request->teacher_id,
        ]);

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
}
