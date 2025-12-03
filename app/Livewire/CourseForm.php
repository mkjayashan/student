<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use App\Models\Subject;

use App\Models\Course;


class CourseForm extends Component
{
    public $course_id;
    public $course_name;
    public $course_code;
    public $selectedSubjects = [];
    public $subjects = [];




    public function mount()
    {

        // Load subjects once when the component mounts
        $this->subjects = Subject::all();
    }

    public function saveCourse()
    {
        $this->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50', // add validation

            'selectedSubjects' => 'required|array|min:1',
        ]);

        $course = \App\Models\Course::create([
            'course_name' => $this->course_name,
                    'course_code' => $this->course_code,  // save code too

        ]);
        $course->subjects()->attach($this->selectedSubjects);



        $this->dispatch('close-modal');
        $this->dispatch('courseAdded');
        $this->reset(['course_name','course_code', 'selectedSubjects']);
    }

    public function editCourse($id)
    {
        $course = Course::with('subjects')->findOrFail($id);

        $this->course_id = $course->id;
        $this->course_name = $course->course_name;
        $this->course_code = $course->course_code;
        $this->selectedSubjects = $course->subjects->pluck('id')->toArray();

        $this->dispatch('show-update-modal', ['id' => $id]);
    }

    // Update course
    public function updateCourse()
    {
        $this->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50',
            'selectedSubjects' => 'required|array|min:1',
        ]);

        $course = Course::findOrFail($this->course_id);

        $course->update([
            'course_name' => $this->course_name,
            'course_code' => $this->course_code,
        ]);

        $course->subjects()->sync($this->selectedSubjects);

        $this->reset(['course_id', 'course_name', 'course_code', 'selectedSubjects']);
        $this->dispatch('hide-update-modal', ['id' => $this->course_id]);

        session()->flash('success', 'Course updated successfully!');
    }





    public function render()
    {
        return view('livewire.course-form');
    }
}
