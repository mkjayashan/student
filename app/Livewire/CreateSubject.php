<?php

namespace App\Livewire;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\Subject; // ✅ Add this line


class CreateSubject extends Component
{
    public $subject_code,$subject_name;

    public function submit()
    {
        Subject::query()->create([
            'subject_code' => $this->subject_code,
            'subject_name' => $this->subject_name,


        ]);
        $this->clear();
        $this->dispatch('refreshSubjectTable');
        return redirect()->to('/subject/subject');


    }
    public function clear()
    {
        $this->subject_code = '';
        $this->subject_name = '';



    }
    public function render()
    {
        return view('livewire.create-subject');
    }
}
