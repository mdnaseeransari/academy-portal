<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Mark;
use App\Models\Remark;
use App\Models\Contact;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display student dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // REPAIR: If user is a student but missing the Student profile
        if (!$user->student && $user->role === 'student') {
            \App\Models\Student::create([
                'user_id' => $user->id,
                'roll_number' => 'RECOVERED-' . $user->id,
                'class_id' => \App\Models\AcademicClass::first()->id ?? null,
            ]);
            // Refresh user to load the new student relation
            $user->load('student');
        }

        $student = $user->student;
        if (!$student) abort(403, 'No student profile found.');
        
        $student = Auth::user()->student()->with(['user', 'academicClass'])->first();

        // Prune old remarks (older than 20 days)
        Remark::where('created_at', '<', now()->subDays(20))->delete();
        
        $presentCount = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $absentCount = Attendance::where('student_id', $student->id)->where('status', 'absent')->count();
        $lateCount = Attendance::where('student_id', $student->id)->where('status', 'late')->count();
        
        $totalAttendance = $presentCount + $absentCount + $lateCount;
        $attendancePercentage = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;

        $pendingAssignmentsCount = Assignment::where('class_id', $student->class_id)
            ->whereDoesntHave('submissions', function($q) use ($student) {
                $q->where('student_id', $student->id);
            })->count();

        // New Logic: Find Current or Next Class
        $today = now()->format('l');
        $now = now()->format('H:i:s');
        
        $currentClass = Timetable::where('class_id', $student->class_id)
            ->where('day', $today)
            ->where('time_start', '<=', $now)
            ->where('time_end', '>=', $now)
            ->with('teacher')
            ->first();
            
        $nextClass = null;
        if (!$currentClass) {
            $nextClass = Timetable::where('class_id', $student->class_id)
                ->where('day', $today)
                ->where('time_start', '>', $now)
                ->orderBy('time_start')
                ->with('teacher')
                ->first();
        }

        // New Logic: Aggregate Marks
        $totalObtained = Mark::where('student_id', $student->id)->sum('marks_obtained');
        $totalPossible = Mark::where('student_id', $student->id)->sum('total_marks');

        $stats = [
            'present' => $presentCount,
            'absent' => $absentCount,
            'late' => $lateCount,
            'percentage' => $attendancePercentage,
            'pending_assignments' => $pendingAssignmentsCount,
            'current_class' => $currentClass,
            'next_class' => $nextClass,
            'total_obtained' => $totalObtained,
            'total_possible' => $totalPossible,
        ];

        $recentMarks = Mark::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentRemarks = Remark::with('teacher')
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('student.dashboard', compact('student', 'stats', 'recentMarks', 'recentRemarks'));
    }

    /**
     * Show student attendance.
     */
    public function attendance(Request $request)
    {
        $student = auth()->user()->student;
        if (!$student) abort(403, 'No student profile found.');
        $selected_month = $request->get('month', date('m'));
        $selected_year = $request->get('year', date('Y'));

        $query = Attendance::where('student_id', $student->id)
            ->whereMonth('date', $selected_month)
            ->whereYear('date', $selected_year)
            ->with('markedBy');

        $total = $query->count();
        $present = (clone $query)->where('status', 'present')->count();
        $absent = (clone $query)->where('status', 'absent')->count();
        $late = (clone $query)->where('status', 'late')->count();
        $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        $summary = [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'percentage' => $percentage
        ];

        $attendance = $query->paginate(15);

        return view('student.attendance', compact('attendance', 'summary', 'selected_month', 'selected_year'));
    }

    /**
     * Show student marks.
     */
    public function marks(Request $request)
    {
        $student = auth()->user()->student;
        if (!$student) abort(403, 'No student profile found.');
        $exam_type = $request->exam_type;

        $query = Mark::where('student_id', $student->id);

        if ($exam_type) {
            $query->where('exam_type', $exam_type);
        }

        $marks = $query->orderBy('created_at', 'desc')->get();

        return view('student.marks', compact('marks', 'exam_type'));
    }

    /**
     * Show assignments.
     */
    public function assignments()
    {
        $student = auth()->user()->student;
        if (!$student) abort(403, 'No student profile found.');

        $pending = Assignment::where('class_id', $student->class_id)
            ->whereDoesntHave('submissions', function($q) use ($student) {
                $q->where('student_id', $student->id);
            })
            ->withCount(['submissions' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->get();

        $submitted = AssignmentSubmission::where('student_id', $student->id)
            ->with('assignment')
            ->get();

        return view('student.assignments', compact('pending', 'submitted'));
    }

    /**
     * Upload assignment submission.
     */
    public function uploadAssignment(Request $request)
    {
        $student = auth()->user()->student;
        if (!$student) abort(403, 'No student profile found.');
        
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120'
        ]);

        $assignment = Assignment::findOrFail($request->assignment_id);
        
        if (now() > $assignment->due_date && $assignment->due_date !== null) {
            return back()->withErrors(['file' => 'Assignment deadline has passed.']);
        }

        $student = Auth::user()->student;

        $exists = AssignmentSubmission::where('assignment_id', $request->assignment_id)
            ->where('student_id', $student->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['file' => 'You have already submitted this assignment.']);
        }

        $result = cloudinary()->uploadApi()->upload($request->file('file')->getRealPath(), [
            'folder' => 'submissions',
            'resource_type' => 'auto',
        ]);
        $fileUrl = $result['secure_url'];
        
        $status = (now() > $assignment->due_date) ? 'late' : 'submitted';

        AssignmentSubmission::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $student->id,
            'file_path' => $fileUrl,
            'submitted_at' => now(),
            'status' => $status,
        ]);

        return redirect()->route('student.assignments')->with('success', 'Assignment submitted successfully!');
    }

    /**
     * Show student remarks.
     */
    public function remarks()
    {
        $student = auth()->user()->student;
        if (!$student) abort(403, 'No student profile found.');

        $remarks = Remark::where('student_id', $student->id)
            ->with('teacher')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.remarks', compact('remarks'));
    }

    /**
     * Show timetable.
     */
    public function timetable()
    {
        $student = auth()->user()->student;
        if (!$student) abort(403, 'No student profile found.');
        
        $student = Auth::user()->student()->with('academicClass')->first();
        $class = $student->academicClass;

        $timetable = Timetable::where('class_id', $student->class_id)
            ->with('teacher')
            ->orderBy('time_start')
            ->get()
            ->groupBy('day');

        return view('student.timetable', compact('timetable', 'class'));
    }

    /**
     * Show contact page.
     */
    public function contact()
    {
        return view('student.contact');
    }

    /**
     * Submit contact form.
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:20|max:2000',
        ]);

        Contact::create([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => $request->phone,
            'message' => $request->subject . ': ' . $request->message,
            'status' => 'unread',
        ]);

        return redirect()->back()->with('success', 'Your message has been sent!');
    }
}
