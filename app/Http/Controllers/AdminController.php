<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   
        public function dashboard()
    {
        // Get counts for dashboard stats
        $studentsCount = Student::count();
        $teachersCount = Teacher::count();
        $subjectsCount = Subject::count();
        $coursesCount = Course::count();

        // Pass them to the view
        return view('admin.dashboard', compact('studentsCount', 'teachersCount','subjectsCount',
            'coursesCount'));
    }
        
}
