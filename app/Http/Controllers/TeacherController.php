<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\AcademicClass;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\ExamSchedule;
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
        $classes = $teacher->classes;
        $classIds = $classes->pluck('id');
        
        $totalStudents = Student::whereIn('class_id', $classIds)->count();
        $today = Carbon::today()->toDateString();
        
        $presentToday = Attendance::whereIn('class_id', $classIds)
            ->where('date', $today)
            ->where('status', 'present')
            ->count();
            
        $absentToday = Attendance::whereIn('class_id', $classIds)
            ->where('date', $today)
            ->where('status', 'absent')
            ->count();
            
        $assignmentsCount = Assignment::count();
        
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
            'Weekly Assessment' => 'weekly_assessment',
            'Mock Test' => 'mock_test',
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
        
        $classes = AcademicClass::all();
        
        // Manual mode variables
        $manual_class_id = $request->get('class_id');
        $manual_date = $request->get('date');
        $manual_period = $request->get('period_slot') ? trim($request->get('period_slot')) : null;

        $selected_class = null;
        $selected_date = Carbon::today()->toDateString();
        $periodSlot = null;
        $activePeriod = null;
        $isManualMode = false;

        $students = collect();
        $already_marked = false;
        $existing_attendance = collect();

        $available_slots = collect();
        $scheduled_slots = collect();

        if ($manual_class_id && $manual_date) {
            // DIRECT / MANUAL MODE
            $isManualMode = true;
            $selected_class = $manual_class_id;
            $selected_date = $manual_date;
            $periodSlot = $manual_period;
            $class = AcademicClass::find($selected_class);
            
            $available_slots = Attendance::where('class_id', $selected_class)
                ->where('date', $selected_date)
                ->select('period_slot')
                ->selectRaw('MAX(created_at) as created_at')
                ->selectRaw('MAX(marked_by) as marked_by')
                ->groupBy('period_slot')
                ->with('markedBy')
                ->orderBy('created_at', 'asc')
                ->get();
                
            $dayOfWeek = Carbon::parse($selected_date)->format('l');
            $scheduled_slots = Timetable::where('class_id', $selected_class)
                ->where('day', $dayOfWeek)
                ->orderBy('time_start')
                ->get();

            if ($class && $periodSlot) {
                $students = Student::where('class_id', $selected_class)->with('user')->get();
                $existing_attendance = Attendance::where('class_id', $selected_class)
                    ->where('date', $selected_date)
                    ->where('period_slot', $periodSlot)
                    ->get()
                    ->keyBy('student_id');

                if ($existing_attendance->isNotEmpty()) {
                    $already_marked = true;
                }
            }
        } else {
            // TIMETABLE MODE (Original behavior)
            $today = Carbon::now()->format('l'); // e.g., "Monday"
            $currentTime = Carbon::now();
            
            $timetable = Timetable::where('teacher_id', $teacher->user_id)
                                  ->where('day', $today)
                                  ->get();
            
            foreach($timetable as $period) {
                if (!$period->time_start || !$period->time_end) continue;
                
                $start = Carbon::parse($period->time_start)->subMinutes(15);
                $end = Carbon::parse($period->time_end)->addMinutes(5);
                
                if ($currentTime->between($start, $end)) {
                    $activePeriod = $period;
                    $periodSlot = $period->subject . ' ' . Carbon::parse($period->time_start)->format('H:i') . '-' . Carbon::parse($period->time_end)->format('H:i');
                    $selected_class = $period->class_id;
                    $class = AcademicClass::find($selected_class);
                    break;
                }
            }
            
            if (!$activePeriod) {
                $class = $teacher->classes()->first();
                $selected_class = $class ? $class->id : null;
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
        return view('teacher.attendance', compact('students', 'classes', 'selected_class', 'selected_date', 'already_marked', 'existing_attendance', 'activePeriod', 'periodSlot', 'class', 'isManualMode', 'available_slots', 'scheduled_slots'));
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
            'date' => 'nullable|date',
        ]);

        $date = $request->get('date', Carbon::today()->toDateString());
        $period_slot = trim($request->period_slot);

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

        return redirect()->back()->with('success', 'Attendance saved successfully for ' . Carbon::parse($date)->format('M d, Y') . ' (' . $period_slot . ')');
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

        return redirect()->route('teacher.attendance', [
            'class_id' => $request->class_id,
            'date' => $date
        ])->with('success', 'Successfully deleted ' . $deletedCount . ' attendance records for slot: ' . $period_slot);
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
            $class = $teacher->classes()->first();
            $selected_class = $class ? $class->id : null;
        }

        $exam_type = $request->get('exam_type', 'Weekly Assessment');
        $db_exam_type = $this->mapExamType($exam_type);

        $topic = $request->get('topic');
        $exam_date = $request->get('date', Carbon::today()->toDateString());
        $total_marks = $request->get('total_marks', 100);
        
        $students = collect();
        $previous_marks = collect();
        $selected_subject = $request->get('subject', $teacher->subject);

        $uploaded_exams = collect();

        // Fetch uploaded exams history
        $uploaded_exams_query = Mark::join('students', 'marks.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('marks.exam_type', 'marks.subject', 'marks.topic', 'marks.date', 'marks.total_marks', 'classes.name as class_name', 'classes.id as class_id')
            ->distinct();

        if ($selected_class) {
            $uploaded_exams_query->where('classes.id', $selected_class);
        }

        $uploaded_exams = $uploaded_exams_query
            ->orderBy('marks.date', 'desc')
            ->get();

        // Fetch all scheduled (upcoming) exams across all classes
        $scheduled_exams_query = ExamSchedule::with(['academicClass', 'creator'])
            ->where('scheduled_date', '>=', Carbon::today());

        $scheduled_exams = $scheduled_exams_query->orderBy('scheduled_date', 'asc')->get();

        if ($selected_class) {
            $students = Student::where('class_id', $selected_class)
                ->with('user')
                ->get();
            $studentIds = $students->pluck('id');

            if ($topic && $exam_date) {
                $previous_marks = Mark::whereIn('student_id', $studentIds)
                    ->where('exam_type', $db_exam_type)
                    ->where('subject', $selected_subject)
                    ->where('topic', $topic)
                    ->where('date', $exam_date)
                    ->with('student.user')
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('teacher.marks', compact('teacher', 'students', 'classes', 'selected_class', 'exam_type', 'selected_subject', 'topic', 'exam_date', 'total_marks', 'previous_marks', 'uploaded_exams', 'scheduled_exams'));
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
            'topic' => 'required|string|max:255',
            'date' => 'required|date',
            'total_marks' => 'required|numeric|min:1|max:1000',
            'marks' => 'required|array',
        ]);

        $db_exam_type = $this->mapExamType($request->exam_type);

        DB::transaction(function () use ($request, $db_exam_type) {
            foreach ($request->marks as $student_id => $data) {
                // If absent is checked, marks is 0
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
                        'teacher_id' => auth()->id(),
                        'remarks' => $data['remarks'] ?? null,
                    ]
                );
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
        $class = $teacher->classes()->first();
        
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

        // Get all classes the teacher is assigned to
        $timetableClassIds = Timetable::where('teacher_id', $teacher->user_id)->pluck('class_id');
        $classTeacherClassIds = $teacher->classes()->pluck('classes.id');
        $allClassIds = $timetableClassIds->concat($classTeacherClassIds)->unique()->filter()->toArray();

        $classes = AcademicClass::whereIn('id', $allClassIds)->orderBy('name')->get();

        $selected_class_id = $request->get('class_id');
        $search = $request->get('search');

        if ($selected_class_id) {
            $query = Student::where('class_id', $selected_class_id)->with('user');
            $selected_class = AcademicClass::find($selected_class_id);
        } else {
            if (!empty($allClassIds)) {
                $query = Student::whereIn('class_id', $allClassIds)->with('user');
            } else {
                $query = Student::where('class_id', 0)->with('user');
            }
            $selected_class = null;
        }

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

        // Retain compatibility with $class variable in blade view
        $class = $selected_class;

        return view('teacher.students', compact('students', 'class', 'classes', 'selected_class_id', 'search'));
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
        $assignments = Assignment::with(['submissions', 'academicClass', 'creator'])
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
            'created_by' => auth()->id(),
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
        $assignment = Assignment::with('submissions')
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

        return redirect()->back()->with('success', 'Exam scheduled! Students will see this on their dashboard.');
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

