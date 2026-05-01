<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard() { return view('dashboard'); }
    public function showAttendance() { return view('dashboard'); }
    public function markAttendance() { return back(); }
    public function showMarks() { return view('dashboard'); }
    public function uploadMarks() { return back(); }
    public function assignments() { return view('dashboard'); }
    public function createAssignment() { return back(); }
    public function showRemarks() { return view('dashboard'); }
    public function addRemark() { return back(); }
    public function deleteRemark($id) { return back(); }
    public function students() { return view('dashboard'); }
    public function timetable() { return view('dashboard'); }
}
