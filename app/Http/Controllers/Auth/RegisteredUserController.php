<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\AcademicClass;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $classes = AcademicClass::all();
        return view('auth.register', compact('classes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'nullable|string|max:20',
            'class_id' => 'required|exists:classes,id',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
        ]);

        $class = AcademicClass::find($request->class_id);
        $studentCount = Student::where('class_id', $request->class_id)->count() + 1;
        $prefix = strtoupper(str_replace(['Class ', ' ', '-'], ['', '', ''], $class->name));
        $rollNumber = $prefix . '-' . str_pad($studentCount, 3, '0', STR_PAD_LEFT);

        $user = null;
        DB::transaction(function() use ($request, &$user, $rollNumber) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'phone' => $request->phone,
            ]);

            Student::create([
                'user_id' => $user->id,
                'class_id' => $request->class_id,
                'roll_number' => $rollNumber,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'admission_date' => now(),
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect('/student/dashboard');
    }
}
