<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Subject;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    // Check if admin exists with this email
    if ($admin = \App\Models\Admin::where('email', $request->email)->first()) {
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }
    }

    // Check if student exists with this email
    if ($student = \App\Models\Student::where('email', $request->email)->first()) {
        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('student.dashboard');
        }
    }

    if ($teacher = Teacher::where('email', $request->email)->first()) {
        if (Auth::guard('teacher')->attempt($credentials)) {
            return redirect()->route('teacher.dashboard');
        }
    }
    return back()->withErrors(['email' => 'Invalid credentials']);
}


    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        }elseif (Auth::guard('teacher')->check()) {
        Auth::guard('teacher')->logout();
    }

        return redirect()->route('login');
    }


    
}