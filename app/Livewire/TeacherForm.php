<?php

namespace App\Livewire;
use App\Models\Teacher;
use Livewire\Component;

class TeacherForm extends Component
{
    public $search = '';

    public function render()
    {
        $teachers = Teacher::with(['subjects', 'grades'])
            ->when($this->search, function ($query) {
                $query->where('teacher_name', 'like', "%{$this->search}%")
                      ->orWhere('reg_no', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->get();

        return view('livewire.teacher-list', [
            'teachers' => $teachers
        ]);
    }

}
