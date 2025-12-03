<?php

namespace App\Livewire;

use App\Http\Controllers\GradeController;
use App\Models\grade;
use App\Models\Subject;
use Livewire\Component;

class CreateGrade extends Component
{
    public $grade_code,$grade_name;

    public function submit()
    {
        Grade::query()->create([
            'grade_code' => $this->grade_code,
            'grade_name' => $this->grade_name,


        ]);
        $this->clear();
        $this->dispatch('refreshGradeTable');
        return redirect()->to('/grade/grade');


    }
    public function clear()
    {
        $this->grade_code = '';
        $this->grade_name = '';



    }
    public function render()
    {
        return view('livewire.create-grade');
    }
}
