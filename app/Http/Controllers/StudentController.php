<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Teacher;
use App\Models\Subject;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public $student_id;

    

    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Student::with('grades', 'courses')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('reg_no', 'like', "%{$search}%");
            })
            ->get();

        return view('student_list', compact('students', 'search'));
    }

   public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');

    if (($handle = fopen($file, 'r')) !== false) {

        $header = fgetcsv($handle, 1000, ',');

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

            // Map CSV columns to DB fields
            $data = [
                'reg_no'     => $row[0],
                'name'       => $row[1],
                'email'      => $row[2],
                'ph_no'      => $row[3],
                'dob'        => Carbon::parse($row[4])->format('Y-m-d'),
                'grades'     => $row[5], // comma-separated
                'courses'    => $row[6], // comma-separated
                'nic_front'  => $row[7] ?? null,
                'nic_back'   => $row[8] ?? null,
            ];

            // Create Student record
            $student = Student::create([
                'reg_no'    => $data['reg_no'],
                'name'      => $data['name'],
                'email'     => $data['email'],
                'ph_no'     => $data['ph_no'],
                'dob'       => $data['dob'],
                'nic_front' => $data['nic_front'],
                'nic_back'  => $data['nic_back'],
                'password'  => Hash::make('123456'), // default password
            ]);

            // Attach Grades
            if (!empty($data['grades'])) {
                $gradeNames = explode(',', $data['grades']);
                $gradeIds = Grade::whereIn('grade_name', $gradeNames)->pluck('id')->toArray();
                $student->grades()->sync($gradeIds);
            }

            // Attach Courses
            if (!empty($data['courses'])) {
                $courseNames = explode(',', $data['courses']);
                $courseIds = Course::whereIn('course_name', $courseNames)->pluck('id')->toArray();
                $student->courses()->sync($courseIds);
            }
        }

        fclose($handle);
    }

    return redirect()->back()->with('success', 'Students imported successfully!');
}



    public function exportPDF(Request $request)
    {
        $search = $request->input('search');

        $students = Student::when($search, function($query) use ($search) {
            return $query->where('reg_no', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");
        })->get();

        $pdf = Pdf::loadView('student.pdf', compact('students'));

        return $pdf->download('student.pdf');
    }

public function exportCsv(Request $request)
{
    $search = $request->input('search');

    // Fetch students with their grades and courses
    $students = Student::with(['grades', 'courses'])
        ->when($search, function($query) use ($search) {
            $query->where('reg_no', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
        })
        ->get();

    $fileName = 'students.csv';

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
    ];

    $columns = ['Reg No', 'Name', 'Email', 'Phone No', 'Date of Birth', 'Grades', 'Courses'];

    $callback = function() use ($students, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($students as $student) {
            // Combine all grades into a single comma-separated string
            $gradeNames = $student->grades->count() > 0
                ? $student->grades->pluck('grade_name')->implode(', ')
                : 'No Grade Assigned';

            // Combine all courses into a single comma-separated string
            $courseNames = $student->courses->count() > 0
                ? $student->courses->pluck('course_name')->implode(', ')
                : 'No Courses Assigned';

            fputcsv($file, [
                $student->reg_no,
                $student->name,
                $student->email,
                $student->ph_no,
                $student->dob,
                $gradeNames,
                $courseNames,
                
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


    public function register()
    {
        return view('student_register_form');
    }

    public function dashboard()
{
    return view('Student.dashboard', [
        'studentsCount' => Student::count(),
        'teachersCount' => Teacher::count(),
        'coursesCount'  => Course::count(),
        'gradesCount'   => Grade::count(),
        'subjectsCount' => Subject::count(),
    ]);
}

    public function store(Request $request)
    {
        try {
            $request->validate([
                'reg_no' => 'required|unique:students,reg_no',
                'name' => 'required',
                'email' => 'required|email|unique:students,email',
                'ph_no' => 'required',
                'dob' => 'required|date',
                'password' => 'required|min:6',
                'nic_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'nic_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $nicFrontPath = $request->file('nic_front')->store('images/nic', 'public');
            $nicBackPath = $request->file('nic_back')->store('images/nic', 'public');

            $student = Student::create([
                'reg_no' => $request->reg_no,
                'name' => $request->name,
                'email' => $request->email,
                'ph_no' => $request->ph_no,
                'dob' => $request->dob,
                'nic_front' => '/storage/'.$nicFrontPath,
                'nic_back' => '/storage/'.$nicBackPath,
                'password' => bcrypt($request->password),
            ]);

            if ($request->selected_courses) {
    $student->courses()->sync($request->selected_courses);
}


            return redirect()->route('student.index');

        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $grades = Grade::all();
        $courses = Course::all();

        return view('student_update_form', compact('student', 'grades', 'courses'));
    }

    public function update(Request $request)
    {
        $student = Student::findOrFail($request->id);

        $request->validate([
            'reg_no' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'ph_no' => 'required',
            'dob' => 'required',
            'password' => 'required|min:6',
            'profile_picture' => 'nullable|image|max:2048',
        'nic_front' => 'nullable|image|max:2048',
        'nic_back' => 'nullable|image|max:2048',
        ]);

        $student->update([
            'reg_no' => $request->reg_no,
            'name' => $request->name,
            'email' => $request->email,
            'ph_no' => $request->ph_no,
            'dob' => $request->dob,
            'password' => bcrypt($request->password),
        ]);

        if ($request->has('selectedGrades')) {
    $student->grades()->sync($request->input('selectedGrades'));
}

if ($request->has('selected_courses')) {
    $student->courses()->sync($request->input('selected_courses'));
}


        // Profile Picture Upload
    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('images/profile', 'public');
        $student->profile_picture = '/storage/' . $path;
    }

    // NIC Front Upload
    if ($request->hasFile('nic_front')) {
        $path = $request->file('nic_front')->store('images/nic', 'public');
        $student->nic_front = '/storage/' . $path;
    }

    // NIC Back Upload
    if ($request->hasFile('nic_back')) {
        $path = $request->file('nic_back')->store('images/nic', 'public');
        $student->nic_back = '/storage/' . $path;
    }

        $student->save();

        return redirect()->back()->with('success', 'Student updated successfully!');
    }

    public function delete($id)
    {
        try {
            Student::where('id', $id)->delete();
            return redirect()->route('student.index')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Student $student)
    {
        return view('student.show', compact('student'));
    }
}
