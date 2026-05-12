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
use Illuminate\Support\Str;
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
            'name' => ['required', 'string', 'max:255'],
            'email_username' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._-]+$/', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'class_id' => ['required', 'exists:classes,id'],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_phone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'numeric'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{10}$/', 'numeric'],
        ], [
            'email_username.regex' => 'The username may only contain letters, numbers, dashes, underscores and periods.',
            'email_username.unique' => 'This username is already taken.',
            'parent_phone.regex' => 'Phone number must be exactly 10 digits.',
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        $fullEmail = $request->email_username . '@gmail.com';

        // Additional uniqueness check for the constructed email, just in case
        if (User::where('email', $fullEmail)->exists()) {
            return back()->withErrors(['email_username' => 'This username is already taken.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $fullEmail,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'status' => 'pending',
                'phone' => $request->phone,
            ]);

            // Create Student record immediately with the registration data
            Student::create([
                'user_id' => $user->id,
                'class_id' => $request->class_id,
                'roll_number' => 'REG-' . strtoupper(Str::random(6)), // Unique temp roll number
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'admission_date' => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registration failed. Please try again.')->withInput();
        }

        event(new Registered($user));

        // Do NOT log the user in since they are pending approval
        // Auth::login($user);

        return redirect('/pending-approval');
    }
}
