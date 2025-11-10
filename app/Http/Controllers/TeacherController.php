<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderBy('created_at', 'desc')->get();
        return view('teacher_list',compact('teachers'));

    }
}
