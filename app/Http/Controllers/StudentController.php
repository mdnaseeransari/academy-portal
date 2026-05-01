<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard() { return view('dashboard'); }
    public function attendance() { return view('dashboard'); }
    public function marks() { return view('dashboard'); }
    public function assignments() { return view('dashboard'); }
    public function uploadAssignment() { return back(); }
    public function remarks() { return view('dashboard'); }
    public function timetable() { return view('dashboard'); }
    public function contact() { return view('dashboard'); }
    public function submitContact() { return back(); }
}
