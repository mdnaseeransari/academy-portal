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
        $totalClasses   = AcademicClass::count();
        $unreadContacts = Contact::where('status', 'unread')->count();

        // Today's attendance overview per class
        $classes = AcademicClass::withCount('students')->get();

        $attendance_overview = $classes->map(function ($class) use ($today) {
            $studentIds = $class->students()->pluck('id');
            $total      = $studentIds->count();

            $present = Attendance::whereIn('student_id', $studentIds)
                ->where('date', $today)->where('status', 'present')->count();
            $absent  = Attendance::whereIn('student_id', $studentIds)
                ->where('date', $today)->where('status', 'absent')->count();
            $late    = Attendance::whereIn('student_id', $studentIds)
                ->where('date', $today)->where('status', 'late')->count();

            $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

            return [
                'class_name' => $class->name,
                'class'      => $class,
                'total'      => $total,
                'present'    => $present,
                'absent'     => $absent,
                'late'       => $late,
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

        // Overall today's attendance % across all students
        $allStudentIds    = Student::pluck('id');
        $totalAllStudents = $allStudentIds->count();
        $presentAllToday  = Attendance::whereIn('student_id', $allStudentIds)
            ->where('date', $today)
            ->where('status', 'present')
            ->count();
        $attendanceToday = $totalAllStudents > 0
            ? round(($presentAllToday / $totalAllStudents) * 100, 1)
            : 0;

        $stats = [
            'students'         => $totalStudents,
            'teachers'         => $totalTeachers,
            'classes'          => $totalClasses,
            'unread'           => $unreadContacts,
            'unread_contacts'  => $unreadContacts,
            'attendance_today' => $attendanceToday,
            'assignments'      => Assignment::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'attendance_overview',
            'recent_students',
            'recent_contacts'
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
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:8',
            'academic_class_id' => 'required|exists:classes,id',
            'roll_number'    => 'required|string|max:50|unique:students,roll_number',
            'parent_name'    => 'nullable|string|max:255',
            'parent_phone'   => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:500',
            'admission_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'student',
                'is_active'=> true,
            ]);

            Student::create([
                'user_id'        => $user->id,
                'class_id'       => $request->academic_class_id,
                'roll_number'    => $request->roll_number,
                'parent_name'    => $request->parent_name,
                'parent_phone'   => $request->parent_phone,
                'address'        => $request->address,
                'admission_date' => $request->admission_date ?? now()->toDateString(),
            ]);
        });

        return redirect()->route('admin.students')->with('success', 'Student added successfully.');
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
            'parent_phone'   => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:500',
            'admission_date' => 'nullable|date',
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
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'subject'       => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'academic_class_id' => 'nullable|exists:classes,id',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'teacher',
                'is_active'=> true,
            ]);

            Teacher::create([
                'user_id'       => $user->id,
                'subject'       => $request->subject,
                'phone'         => $request->phone,
                'qualification' => $request->qualification,
            ]);

            // Assign teacher to a class if specified
            if ($request->filled('academic_class_id')) {
                AcademicClass::where('id', $request->academic_class_id)
                    ->update(['teacher_id' => $user->id]);
            }
        });

        return redirect()->route('admin.teachers')->with('success', 'Teacher added successfully.');
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
            'phone'         => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'academic_class_id' => 'nullable|exists:classes,id',
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
            ->orderByRaw("FIELD(day, 'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')")
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
}
