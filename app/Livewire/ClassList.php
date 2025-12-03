<?php

namespace App\Livewire;

use App\Models\classroom;
use App\Models\grade;
use Livewire\Attributes\On;
use Livewire\Component;

class ClassList extends Component
{
    #[On('classCreated')]
    public function refreshList()
    {
        // No need to do anything here, just re-render
    }

    public function render()
    {
        return view('livewire.class-list', [
            'classes' => Classroom::latest()->get(),
            'grades'  => Grade::all(),
        ]);
    }
}
