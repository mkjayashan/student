<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use App\Models\Course;
use App\Models\Grade;
use Livewire\WithFileUploads;



use Illuminate\Support\Facades\Hash;


class StudentRegisterForm extends Component

{


    use WithFileUploads;


    public $reg_no,$name,$email,$ph_no,$dob,$password;
    public $student_id;
   
    public $profile_picture;
    public $nic_front;
    public $nic_back;
     public $grades = [];

    public $search = '';
    public $courses;
    public $selected_courses = [];
    

    public $students;
    
    public $selectedGrades = [];


    


    public function mount()
{
     
    $this->courses = Course::all();
            $this->grades = Grade::all();
        $this->students = Student::with('grades', 'courses')->orderBy('id', 'desc')->get();

}
    public function render()
{


     
    return view('livewire.student-register-form', [
        'grades' => $this->grades,
        'courses' => $this->courses,
    ]);
}


public function submit()
{
    // Validate input including images
    $data = $this->validate([
        'reg_no' => 'required|unique:students,reg_no',
        'name' => 'required',
        'email' => 'required|email|unique:students,email',
        'ph_no' => 'required',
        'dob' => 'required|date',
        'password' => 'required|string|min:6',
        'selected_courses' => 'required|array|min:1',

        
'selectedGrades' => 'required|array|min:1',                    
'profile_picture' => 'nullable|image|max:2048',

        'nic_front' => 'nullable|image|max:2048',
        'nic_back' => 'nullable|image|max:2048',
    ]);

    $nicFrontPath = null;
    $nicBackPath = null;
$profilePath=null;
    if ($this->profile_picture) {
    $profilePath = $this->profile_picture->storeAs(
        'images/profile', // folder in storage/app/public
        time().'_profile_'.$this->profile_picture->getClientOriginalName(),
        'public' // use the public disk
    );
}
    // NIC Front Upload
    if ($this->nic_front) {
        $nicFrontPath = $this->nic_front->storeAs(
            'images/nic',
            time().'_front_'.$this->nic_front->getClientOriginalName(),
            'public'
        );
    }

    // NIC Back Upload
    if ($this->nic_back) {
        $nicBackPath = $this->nic_back->storeAs(
            'images/nic',
            time().'_back_'.$this->nic_back->getClientOriginalName(),
            'public'
        );
    }

    // Create Student
    $student = Student::create([
        'reg_no' => $this->reg_no,
        'name' => $this->name,
        'email' => $this->email,
        'ph_no' => $this->ph_no,
        'dob' => $this->dob,
        
            'profile_picture' => $profilePath ? 'storage/'.$profilePath : null,

        'nic_front' => $nicFrontPath ? 'storage/'.$nicFrontPath : null,
        'nic_back' => $nicBackPath ? 'storage/'.$nicBackPath : null,
        'password' => Hash::make($this->password),
    ]);
     if (!empty($this->selectedGrades)) {
    $student->grades()->attach($this->selectedGrades);
}





    // Attach courses if any
    if (!empty($this->selected_courses)) {
        $student->courses()->attach($this->selected_courses);
    }

    

    // Clear form
    $this->clear();

    // Optional: refresh student table if you have a listener
    $this->dispatch('refreshStudentTable');

    // Redirect
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
        $this->selectedGrades = [];
        $this->selected_courses = [];
        $this->nic_front = null;
        $this->nic_back = null;
    }
}