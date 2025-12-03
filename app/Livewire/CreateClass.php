<?php

namespace App\Livewire;

use App\Models\classroom;
use App\Models\grade;
use Livewire\Component;

class CreateClass extends Component
{
    public $classes, $grades;

    public $class_id;
    public $class_name;
    public $grade_id;

    public function mount()
    {
        $this->grades = Grade::all();
        $this->classes = Classroom::with('grade')->get();
    }

    // Open data in modal
    /*public function edit($id)
    {
        $class = Classroom::findOrFail($id);

        $this->class_id = $class->id;
        $this->class_name = $class->class_name;
        $this->grade_id = $class->grade_id;

        $this->dispatch('openEditModal');
    }

    // Update record
    public function update()
    {
        $this->validate([
            'class_name' => 'required',
            'grade_id'   => 'required|exists:grades,id',
        ]);

        Classroom::findOrFail($this->class_id)->update([
            'class_name' => $this->class_name,
            'grade_id'   => $this->grade_id,
        ]);

        $this->reset(['class_id', 'class_name', 'grade_id']);

        $this->classes = Classroom::with('grade')->get();

        $this->dispatch('closeEditModal');

        session()->flash('success', 'Class updated successfully!');
    }*/

    public function submit()
    {
        if (!Classroom::where('class_name', $this->class_name)
            ->where('grade_id', $this->grade_id)
            ->exists()) {

            Classroom::create([
                'class_name' => $this->class_name,
                'grade_id' => $this->grade_id,
            ]);

            // Reset
            $this->reset(['class_name', 'grade_id']);

            // Livewire 3 event dispatch
            $this->dispatch('classCreated');

        } else {
            session()->flash('error', 'This class already exists for the selected grade.');
        }
    }





    public function render()
    {
        $classes = Classroom::with('grade')->get();
        return view('livewire.create-class');
    }






}
