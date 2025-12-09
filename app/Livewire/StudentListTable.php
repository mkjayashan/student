<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Course;

use Livewire\Component;

class StudentListTable extends Component
{
   public $students;
    public $grades;
    public $courses;

    public function mount()
    {
        $this->students = Student::all();
        $this->grades = Grade::all();
        $this->courses = Course::all();
    }

    public function render()
    {
        return view('livewire.student-list-table', [
            'students' => $this->students,
            'grades' => $this->grades,
            'courses' => $this->courses,
        ]);
    }
}
