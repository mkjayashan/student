<?php

namespace App\Livewire;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Grade;
use Livewire\Component;

class TeacherRegistration extends Component
{
    use WithFileUploads;


    public $reg_no;
    public $teacher_name;
    public $email;
    public $nic;
    public $address;
    public $phone_no;
    public $selected_grades = [];
    public $selected_subjects = [];
    public $grades;
    public $subjects;
    public $search = '';
    public $profile_picture;
    public $nic_front;
    public $nic_back;
    public $password;
    public $password_confirmation;


    


    public function mount()
    {
        $this->subjects = Subject::all();
        $this->grades = Grade::all();
    }

    public function submit()
    {
        $this->validate([
    'reg_no' => 'required|unique:teachers,reg_no',
    'teacher_name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
    'email' => ['required', 'email', 'unique:teachers,email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
    'nic' => ['required', 'unique:teachers,nic', 'regex:/^[0-9]{9}[vVxX]$|^[0-9]{12}$/'],
    'address' => 'required|string|max:255',
    'phone_no' => ['required','regex:/^[0-9]{10}$/'],
    'selected_grades' => 'required|array|min:1',
    'selected_subjects' => 'required|array|min:1',
    'profile_picture' => 'nullable|image|max:2048',
    'nic_front' => 'nullable|image|max:2048',
    'nic_back' => 'nullable|image|max:2048',
    'password' => 'required|string|min:6|confirmed',
]);

          $nicFrontPath = null;
    $nicBackPath = null;

$profilePath = null;
    if ($this->profile_picture) {
    $profilePath = $this->profile_picture->storeAs(
        'images/profile', // folder in storage/app/public
        time().'_profile_'.$this->profile_picture->getClientOriginalName(),
        'public' // use the public disk
    );
}


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
        // Create teacher
        $teacher = Teacher::create([
            'reg_no' => $this->reg_no,
            'teacher_name' => $this->teacher_name,
            'email' => $this->email,
            'nic' => $this->nic,
            'address' => $this->address,
            'phone_no' => $this->phone_no,
                'profile_picture' => $profilePath ? 'storage/'.$profilePath : null,
             'password' => Hash::make($this->password),
            'nic_front' => $nicFrontPath ? 'storage/'.$nicFrontPath : null,
        'nic_back' => $nicBackPath ? 'storage/'.$nicBackPath : null,
        ]);

        // Attach grades & subjects
        $teacher->grades()->sync($this->selected_grades);
        $teacher->subjects()->sync($this->selected_subjects);

        session()->flash('success', 'Teacher Registered Successfully!');
    $this->dispatch('teacher-added');

    

        $this->reset([
            'reg_no', 'teacher_name', 'email', 'nic', 'address', 'phone_no',
            'selected_grades', 'selected_subjects', 'password', 'password_confirmation'
        ]);
    }

    public function render()
{
    $teachers = Teacher::with(['subjects', 'grades'])
        ->when($this->search, function ($query) {
            $query->where('teacher_name', 'like', "%{$this->search}%")
                  ->orWhere('reg_no', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
        })
        ->get();

    return view('livewire.teacher-registration', [
        'teachers' => $teachers,
        'subjects' => $this->subjects,
        'grades' => $this->grades,
    ]);
}


}
