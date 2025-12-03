<?php

namespace App\Livewire;

use App\Models\classroom;
use App\Models\Course;
use App\Models\Teacher;
use Livewire\Component;

class TeacherRegistration extends Component
{
    public $reg_no, $name, $address, $NIC, $phone_no1, $phone_no2;
    public $course_id, $class_id;
    public $courses, $classes;

    public function mount()
    {
        $this->courses = Course::all();
        $this->classes = Classroom::all();
    }
    public function submit()
    {
        $this->validate([
            'reg_no' => 'required|unique:teachers,reg_no',
            'name' => 'required',
            'address' => 'required',
            'NIC' => 'required|unique:teachers,NIC',
            'phone_no1' => 'required',
            'phone_no2' => 'nullable',

            'course_id' => 'required|exists:courses,id',
            'class_id' => 'required|exists:classrooms,id',
        ]);



        Teacher::create([
            'reg_no' => $this->reg_no,
            'name' => $this->name,
            'address' => $this->address,
            'NIC' => $this->NIC,
            'phone_no1' => $this->phone_no1,
            'phone_no2' => $this->phone_no2,

            'course_id' => $this->course_id,
            'class_id' => $this->class_id,
        ]);

        $this->reset(['teacher_id','teacher_name','address','NIC','phone_no1','phone_no2','course_id','class_id']);

        $this->dispatch('teacherRegistered');
    }
    public function render()
    {
        return view('livewire.teacher-registration');
    }
}
