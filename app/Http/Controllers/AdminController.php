<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() { return view('dashboard'); }
    public function students() { return view('dashboard'); }
    public function addStudent() { return back(); }
    public function updateStudent($id) { return back(); }
    public function deleteStudent($id) { return back(); }
    public function teachers() { return view('dashboard'); }
    public function addTeacher() { return back(); }
    public function updateTeacher($id) { return back(); }
    public function deleteTeacher($id) { return back(); }
    public function reports() { return view('dashboard'); }
    public function contacts() { return view('dashboard'); }
    public function markRead($id) { return back(); }
    public function timetable() { return view('dashboard'); }
    public function addTimetable() { return back(); }
    public function deleteTimetable($id) { return back(); }
}
