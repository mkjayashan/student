<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Classroom;

class DashboardController extends Controller
{
    public function index()
    {
        $studentsCount = Student::count();
        $teachersCount = Teacher::count();
        $coursesCount = Course::count();
        $subjectsCount = Subject::count();
        $gradesCount = Grade::count();
        $classesCount = Classroom::count(); // replace with your class model

        return view('dashboard', compact(
            'studentsCount',
            'teachersCount',
            'coursesCount',
            'subjectsCount',
            'gradesCount',
            'classesCount'
        ));
    }
}
