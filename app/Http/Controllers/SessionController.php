<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use App\Models\Head;
use App\Models\Prof;
use App\Models\Student;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:student,prof,head',
        ]);

        // Attempt to authenticate the user...
        if (!Auth::attempt($validatedData)) {
            throw ValidationException::withMessages([
                'role' => 'The provided credentials do not match our records.',
            ]);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the name based on the role
        if ($user->role === 'head') {
            $name = Head::where('user_id', $user->id)->value('name');
        } elseif ($user->role === 'student') {
            $name = Student::where('user_id', $user->id)->value('name');
        } elseif ($user->role === 'prof') {
            $name = Prof::where('user_id', $user->id)->value('name');
        }

        // Store the name in the session (optional, for display purposes)
        session(['user_name' => $name]);

        // Regenerate session
        request()->session()->regenerate();

        // Redirect to the home route
        return redirect()->route('home');
    }


    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
