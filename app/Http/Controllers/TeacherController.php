<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\AcademicClass;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\Mark;
use App\Models\Remark;
use App\Models\Timetable;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TeacherController extends Controller
{
    /**
     * Display teacher dashboard.
     */
    public function dashboard()
    {
        $teacher = auth()->user()->teacher;
        if (!$teacher) abort(403, 'No teacher profile found.');
        $class = AcademicClass::where('teacher_id', $teacher->user_id)->first();
        
        $totalStudents = $class ? Student::where('class_id', $class->id)->count() : 0;
        $today = Carbon::today()->toDateString();
        
        $presentToday = $class ? Attendance::where('class_id', $class->id)
            ->where('date', $today)
            ->where('status', 'present')
            ->count() : 0;
            
        $absentToday = $class ? Attendance::where('class_id', $class->id)
            ->where('date', $today)
            ->where('status', 'absent')
            ->count() : 0;
            
        $assignmentsCount = Assignment::where('teacher_id', $teacher->user_id)->count();
        
        $stats = [
            'total_students' => $totalStudents,
            'present_today' => $presentToday,
            'absent_today' => $absentToday,
            'assignments' => $assignmentsCount
        ];
        
        $today_timetable = Timetable::where('teacher_id', $teacher->user_id)
            ->where('day', Carbon::now()->dayName)
            ->orderBy('time_start')
            ->get();
            
        return view('teacher.dashboard', compact('teacher', 'stats', 'today_timetable'));
    }

    /**
     * Map human-readable exam type to database enum.
     */
    private function mapExamType($type)
    {
        return match($type) {
            'Unit Test' => 'unit_test',
            'Half Yearly' => 'half_yearly',
            'Final' => 'final',
            'Other' => 'other',
            default => $type,
        };
    }

    public function showAttendance(Request $request)
    {
        $teacher = auth()->user()->teacher;
        if (!$teacher) abort(403, 'No teacher profile found.');
        $class = AcademicClass::where('teacher_id', $teacher->user_id)->first();
        
        $classes = AcademicClass::all();
        $selected_class = $class ? $class->id : null;
        $selected_date = Carbon::today()->toDateString();
        
        $today = Carbon::now()->format('l'); // e.g., "Monday"
        $currentTime = Carbon::now();
        
        $activePeriod = null;
        $periodSlot = null;
        $students = collect();
        $already_marked = false;
        $existing_attendance = collect();
        
        if ($class) {
            // Find active period for this teacher today
            $timetable = Timetable::where('teacher_id', $teacher->user_id)
                                  ->where('day', $today)
                                  ->get();
            
            foreach($timetable as $period) {
                // If time_start or time_end are null, skip
                if (!$period->time_start || !$period->time_end) continue;
                
                $start = Carbon::parse($period->time_start)->subMinutes(15);
                $end = Carbon::parse($period->time_end)->addMinutes(5);
                
                if ($currentTime->between($start, $end)) {
                    $activePeriod = $period;
                    $periodSlot = Carbon::parse($period->time_start)->format('H:i') . '-' . Carbon::parse($period->time_end)->format('H:i');
                    // Override selected_class to the class of this period, since a teacher can teach multiple classes
                    $selected_class = $period->class_id;
                    $class = AcademicClass::find($selected_class);
                    break;
                }
            }
            
            if ($selected_class) {
                $students = Student::where('class_id', $selected_class)->with('user')->get();
                
                if ($activePeriod) {
                    $already_marked = Attendance::where('class_id', $selected_class)
                        ->where('date', Carbon::today()->toDateString())
                        ->where('period_slot', $periodSlot)
                        ->exists();
                        
                    if ($already_marked) {
                        $existing_attendance = Attendance::where('class_id', $selected_class)
                            ->where('date', Carbon::today()->toDateString())
                            ->where('period_slot', $periodSlot)
                            ->get()
                            ->keyBy('student_id');
                    }
                }
            }
        }
        
        return view('teacher.attendance', compact('students', 'classes', 'selected_class', 'selected_date', 'already_marked', 'existing_attendance', 'activePeriod', 'periodSlot', 'class'));
    }

    /**
     * Mark attendance for students.
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'period_slot' => 'required|string',
            'attendance' => 'required|array',
        ]);

        $already_marked = Attendance::where('class_id', $request->class_id)
            ->where('date', Carbon::today()->toDateString())
            ->where('period_slot', $request->period_slot)
            ->exists();
            
        if ($already_marked) {
            return redirect()->back()->with('error', 'Attendance already marked for this period!');
        }

        DB::transaction(function () use ($request) {
            foreach ($request->attendance as $student_id => $data) {
                Attendance::create([
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'date' => Carbon::today()->toDateString(),
                    'period_slot' => $request->period_slot,
                    'status' => $data['status'],
                    'marked_by' => auth()->id()
                ]);
            }
        });

        return redirect()->back()->with('success', 'Attendance locked for ' . $request->period_slot);
    }

    /**
     * Show marks entry page.
     */
    public function marks(Request $request)
    {
        $teacher = auth()->user()->teacher;
        if (!$teacher) abort(403, 'No teacher profile found.');
        $classes = AcademicClass::all();
        
        $selected_class = $request->get('class_id');
        if (!$selected_class) {
            $class = AcademicClass::where('teacher_id', auth()->id())->first();
            $selected_class = $class ? $class->id : null;
        }

        $exam_type = $request->get('exam_type', 'Unit Test');
        $db_exam_type = $this->mapExamType($exam_type);

        $total_marks = $request->get('total_marks', 100);
        
        $students = collect();
        $previous_marks = collect();

        if ($selected_class) {
            $students = Student::where('class_id', $selected_class)
                ->with('user')
                ->get();

            $studentIds = $students->pluck('id');
            $previous_marks = Mark::whereIn('student_id', $studentIds)
                ->where('exam_type', $db_exam_type)
                ->where('subject', $teacher->subject)
                ->with('student.user')
                ->get()
                ->keyBy('student_id');
        }

        return view('teacher.marks', compact('teacher', 'students', 'classes', 'selected_class', 'exam_type', 'total_marks', 'previous_marks'));
    }

    /**
     * Save marks for students.
     */
    public function saveMarks(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'exam_type' => 'required|string',
            'subject' => 'required|string|max:255',
            'total_marks' => 'required|numeric|min:1|max:1000',
            'marks' => 'required|array',
        ]);

        $db_exam_type = $this->mapExamType($request->exam_type);

        DB::transaction(function () use ($request, $db_exam_type) {
            foreach ($request->marks as $student_id => $data) {
                // If absent is checked, marks is 0
                $marksObtained = isset($data['absent']) ? 0 : ($data['marks_obtained'] ?? 0);

                // Add NEW mark entry instead of updating previous one
                Mark::create([
                    'student_id' => $student_id,
                    'exam_type' => $db_exam_type,
                    'subject' => $request->subject,
                    'marks_obtained' => $marksObtained,
                    'total_marks' => $request->total_marks,
                    'teacher_id' => auth()->id(),
                    'remarks' => $data['remarks'] ?? null,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Marks saved successfully!');
    }

    /**
     * Show remarks management page.
     */
    public function showRemarks()
    {
        $teacher = auth()->user()->teacher;
        if (!$teacher) abort(403, 'No teacher profile found.');
        $class = AcademicClass::where('teacher_id', $teacher->user_id)->first();
        
        $students = $class ? Student::where('class_id', $class->id)->with('user')->get() : collect();
        
        $recent_remarks = Remark::where('teacher_id', auth()->id())
            ->with('student.user')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();
            
        return view('teacher.remarks', compact('students', 'recent_remarks'));
    }

    /**
     * Add a new remark for a student.
     */
    public function addRemark(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'remark_text' => 'required|string|min:10|max:500',
            'date' => 'required|date',
        ]);

        $student = Student::with('user')->find($request->student_id);
        $studentName = $student->user->name;

        Remark::create([
            'student_id' => $request->student_id,
            'teacher_id' => auth()->id(),
            'remark_text' => $request->remark_text,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Remark added for ' . $studentName);
    }

    /**
     * Delete a remark.
     */
    public function deleteRemark($id)
    {
        $remark = Remark::where('id', $id)->where('teacher_id', auth()->id())->first();
        
        if (!$remark) {
            abort(403, 'Unauthorized action.');
        }
        
        $remark->delete();
        
        return redirect()->back()->with('success', 'Remark deleted successfully');
    }

    /**
     * List students in teacher's class.
     */
    public function students(Request $request)
    {
        $teacher = auth()->user()->teacher;
        if (!$teacher) abort(403, 'No teacher profile found.');
        $class = AcademicClass::where('teacher_id', $teacher->user_id)->first();
        $search = $request->get('search');
        
        $query = Student::where('class_id', $class->id ?? 0)->with('user');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($u) use ($search) {
                    $u->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                })->orWhereRaw('LOWER(roll_number) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }
        
        $students = $query->paginate(20);
        
        $students->getCollection()->transform(function($student) {
            $total = Attendance::where('student_id', $student->id)->count();
            $present = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
            $student->attendance_percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;
            return $student;
        });
        
        return view('teacher.students', compact('students', 'class', 'search'));
    }

    /**
     * Show teacher's timetable.
     */
    public function timetable()
    {
        $teacher = auth()->user()->teacher;
        if (!$teacher) abort(403, 'No teacher profile found.');
        
        $timetable = Timetable::where('teacher_id', $teacher->user_id)
            ->with('academicClass')
            ->orderBy('time_start')
            ->get()
            ->groupBy('day');
            
        return view('teacher.timetable', compact('timetable'));
    }

    /**
     * Show teacher's assignments.
     */
    public function assignments()
    {
        $assignments = Assignment::where('teacher_id', auth()->id())
            ->with(['submissions', 'academicClass'])
            ->withCount('submissions')
            ->orderBy('created_at', 'desc')
            ->get();

        $classes = AcademicClass::orderBy('name')->get();

        return view('teacher.assignments', compact('assignments', 'classes'));
    }

    /**
     * View submissions for a specific assignment.
     */
    public function viewSubmissions($assignmentId)
    {
        $assignment = Assignment::with(['submissions.student.user'])
            ->where('teacher_id', auth()->id())
            ->findOrFail($assignmentId);

        return view('teacher.submissions', compact('assignment'));
    }

    /**
     * Update marks/grade for a submission.
     */
    public function updateMarks(Request $request, $submissionId)
    {
        // Use correct model name (AssignmentSubmission, not Submission)
        $submission = AssignmentSubmission::with('assignment')->findOrFail($submissionId);
        
        // Check teacher ownership via the assignment
        $teacher = auth()->user()->teacher;
        // Check both user_id and id to be safe with different schemas
        if ($submission->assignment->teacher_id !== $teacher->id && $submission->assignment->teacher_id !== $teacher->user_id) {
            abort(403);
        }

        $request->validate([
            'grade' => 'nullable|string|max:10',
        ]);

        $submission->grade = $request->grade;
        $submission->save();

        return back()->with('success', 'Grade updated successfully!');
    }

    /**
     * Create a new assignment.
     */
    public function createAssignment(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:today',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $teacher = auth()->user()->teacher;

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
            'teacher_id' => $teacher->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('teacher.assignments')->with('success', 'Assignment created successfully!');
    }

    /**
     * Delete an assignment.
     */
    public function deleteAssignment($id)
    {
        $assignment = Assignment::with('submissions')->where('teacher_id', auth()->user()->teacher->user_id)
            ->findOrFail($id);

        // Function to extract public ID and type from Cloudinary URL
        $extractCloudinaryInfo = function($url) {
            $pattern = '/res\.cloudinary\.com\/[^\/]+\/([^\/]+)\/upload\/(?:v\d+\/)?([^\.]+)/';
            if (preg_match($pattern, $url, $matches)) {
                return ['type' => $matches[1], 'public_id' => $matches[2]];
            }
            return null;
        };

        // 1. Delete Assignment File
        if ($assignment->file_path) {
            $info = $extractCloudinaryInfo($assignment->file_path);
            if ($info) {
                try {
                    cloudinary()->uploadApi()->destroy($info['public_id'], ['resource_type' => $info['type']]);
                } catch (\Exception $e) {
                    // Log or ignore if file already deleted
                }
            }
        }

        // 2. Delete Submission Files
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

        return redirect()->route('teacher.assignments')->with('success', 'Assignment and associated files deleted.');
    }
}

