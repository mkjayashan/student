<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;


class StudentRegisterForm extends Component
{
    public $reg_no,$name,$email,$ph_no,$dob,$password;
    public function render()
    {

        return view('livewire.student-register-form');
    }

    public function submit()
    {
        Student::query()->create([
            'reg_no' => $this->reg_no,
            'name' => $this->name,
            'email' => $this->email,
            'ph_no' => $this->ph_no,
            'dob' => $this->dob,
            'password' => Hash::make($this->password),

        ]);
        $this->clear();
        $this->dispatch('refreshStudentTable');
        return redirect()->to('/student/index');
    }

    public function clear()
    {
        $this->reg_no = '';
        $this->name = '';
        $this->email = '';
        $this->ph_no = '';
        $this->dob = '';
        $this->password = '';


    }

}
