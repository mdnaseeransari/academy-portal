<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Fix: Add a generic dashboard route that redirects based on role
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth'])->name('dashboard');


// Student routes (middleware: auth, role:student)
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance');
    Route::get('/marks', [StudentController::class, 'marks'])->name('marks');
    Route::get('/assignments', [StudentController::class, 'assignments'])->name('assignments');
    Route::post('/assignments/upload', [StudentController::class, 'uploadAssignment'])->name('assignments.upload');
    Route::get('/remarks', [StudentController::class, 'remarks'])->name('remarks');
    Route::get('/timetable', [StudentController::class, 'timetable'])->name('timetable');
    Route::get('/contact', [StudentController::class, 'contact'])->name('contact');
    Route::post('/contact', [StudentController::class, 'submitContact'])->name('contact.submit');
});

// Teacher routes (middleware: auth, role:teacher)
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [TeacherController::class, 'showAttendance'])->name('attendance');
    Route::post('/attendance/mark', [TeacherController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('/marks', [TeacherController::class, 'marks'])->name('marks');
    Route::post('/marks/save', [TeacherController::class, 'saveMarks'])->name('saveMarks');
    Route::get('/assignments', [TeacherController::class, 'assignments'])->name('assignments');
    Route::post('/assignments/create', [TeacherController::class, 'createAssignment'])->name('assignments.create');
    Route::delete('/assignments/{id}', [TeacherController::class, 'deleteAssignment'])->name('assignments.delete');
    Route::get('/assignments/{id}/submissions', [TeacherController::class, 'viewSubmissions'])->name('submissions');
    Route::patch('/submissions/{id}/marks', [TeacherController::class, 'updateMarks'])->name('updateMarks');
    Route::get('/remarks', [TeacherController::class, 'showRemarks'])->name('remarks');
    Route::post('/remarks/add', [TeacherController::class, 'addRemark'])->name('remarks.add');
    Route::delete('/remarks/{id}', [TeacherController::class, 'deleteRemark'])->name('remarks.delete');
    Route::get('/students', [TeacherController::class, 'students'])->name('students');
    Route::get('/timetable', [TeacherController::class, 'timetable'])->name('timetable');
});

// Admin routes (middleware: auth, role:admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::post('/students/add', [AdminController::class, 'addStudent'])->name('students.add');
    Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('students.delete');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers');
    Route::post('/teachers/add', [AdminController::class, 'addTeacher'])->name('teachers.add');
    Route::put('/teachers/{id}', [AdminController::class, 'updateTeacher'])->name('teachers.update');
    Route::delete('/teachers/{id}', [AdminController::class, 'deleteTeacher'])->name('teachers.delete');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts');
    Route::post('/contacts/{id}/read', [AdminController::class, 'markRead'])->name('contacts.read');
    Route::delete('/contacts/{id}', [AdminController::class, 'deleteContact'])->name('contacts.delete');
    Route::get('/timetable', [AdminController::class, 'timetable'])->name('timetable');
    Route::post('/timetable/add', [AdminController::class, 'addTimetable'])->name('timetable.add');
    Route::delete('/timetable/{id}', [AdminController::class, 'deleteTimetable'])->name('timetable.delete');
});

require __DIR__.'/auth.php';
