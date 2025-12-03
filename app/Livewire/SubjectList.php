<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;


class SubjectList extends Component
{
    protected $listeners = ['subjectCreated' => '$refresh'];


    public function render()
    {

        return view('livewire.subject-list',[
            'subjects' => Subject::all(),
        ]);
    }
}
