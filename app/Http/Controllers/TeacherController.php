<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index() {
        $teachers = Teacher::all();
        $courses = Course::all();
        $classes = Classroom::all();
        return view('teacher_list', compact('teachers','courses','classes'));
    }
    public function store(Request $request){
        try{
            Teacher::query()->create([
                'reg_no'=>$request->reg_no,
                'name'=>$request ->name,
                'email'=>$request->email,
                'password'=>$request->password,

            ]);
            return redirect()->route('teacher.index');
        }
        catch(\Exception $e) {
            return $e;
        }
    }
}
