<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;


use App\Models\Grade;

use Illuminate\Support\Facades\Hash;

   // <-- add this

use Smalot\PdfParser\Parser;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
   public function index(Request $request)
{
    // Get search input
    $search = $request->input('search');

    // Query teachers with search filter
    $teachers = Teacher::with(['subjects', 'grades'])
        ->when($search, function ($query, $search) {
            return $query->where('teacher_name', 'like', "%{$search}%")
                         ->orWhere('reg_no', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })
        ->get();

    // Fetch all subjects & grades
    $subjects = Subject::all();
    $grades = Grade::all();

    return view('teacher.teacher_list', compact('teachers', 'subjects', 'grades', 'search'));
}

    public function store(Request $request)
{
    // Validation
    $validatedData = $request->validate([
        'reg_no' => 'required|unique:teachers,reg_no',
        'teacher_name' => 'required|string|max:255',
        'email' => 'required|email|unique:teachers,email',
        'nic' => 'required|unique:teachers,nic',
        'address' => 'required|string|max:255',
        'phone_no' => 'nullable|string|max:15',
        'subjects' => 'required|array|min:1',
        'grades' => 'required|array|min:1',
        'password' => 'required|string|min:6',
    ]);

    // Create teacher ONLY with teacher table fields
    $teacher = Teacher::create([
        'reg_no' => $validatedData['reg_no'],
        'teacher_name' => $validatedData['teacher_name'],
        'email' => $validatedData['email'],
        'nic' => $validatedData['nic'],
        'address' => $validatedData['address'],
        'phone_no' => $validatedData['phone_no'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Attach subjects
    $teacher->subjects()->sync($validatedData['subjects']);

    // Attach grades
    $teacher->grades()->sync($validatedData['grades']);

    return redirect()->back()->with('success', 'Teacher registered successfully!');
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
                'reg_no'       => $row[0],
                'teacher_name' => $row[1],
                'email'        => $row[2],
                'nic'          => $row[3],
                'address'      => $row[4],
                'phone_no'     => $row[5],
                'subjects'     => $row[6], // comma-separated
                'grades'       => $row[7], // comma-separated
                'nic_front'    => $row[8] ?? null,
                'nic_back'     => $row[9] ?? null,
            ];

            // Create Teacher Record
            $teacher = Teacher::create([
                'reg_no'       => $data['reg_no'],
                'teacher_name' => $data['teacher_name'],
                'email'        => $data['email'],
                'nic'          => $data['nic'],
                'address'      => $data['address'],
                'phone_no'     => $data['phone_no'],
                'nic_front'    => $data['nic_front'],
                'nic_back'     => $data['nic_back'],
                'password'     => Hash::make('12345678'), // default password
            ]);

            // Attach Subjects
            if (!empty($data['subjects'])) {
                $subjectNames = explode(',', $data['subjects']);
                $subjectIds = Subject::whereIn('subject_name', $subjectNames)->pluck('id')->toArray();
                $teacher->subjects()->sync($subjectIds);
            }

            // Attach Grades
            if (!empty($data['grades'])) {
                $gradeNames = explode(',', $data['grades']);
                $gradeIds = Grade::whereIn('grade_name', $gradeNames)->pluck('id')->toArray();
                $teacher->grades()->sync($gradeIds);
            }
        }

        fclose($handle);
    }

    return redirect()->back()->with('success', 'Teachers imported successfully!');
}





public function exportPdf()
{
    $teachers = Teacher::with(['subjects','grades'])->get();
    $pdf = Pdf::loadView('teacher.pdf', compact('teachers'));
    return $pdf->download('teachers.pdf');
}

 public function exportCsv()
{
    // Fetch all teachers with subjects and grades
    $teachers = Teacher::with(['subjects', 'grades'])->get();

    $fileName = 'teachers.csv';

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = ['Reg No', 'Teacher Name', 'Email', 'NIC', 'Address', 'Phone No', 'Subjects', 'Grades', 'NIC Front', 'NIC Back'];

    $callback = function() use ($teachers, $columns) {
        $file = fopen('php://output', 'w');

        // Write header row
        fputcsv($file, $columns);

        foreach ($teachers as $teacher) {
            $subjects = $teacher->subjects->count() > 0
                ? $teacher->subjects->pluck('subject_name')->implode(', ')
                : 'No Subjects Assigned';
            $grades = $teacher->grades->count() > 0
                ? $teacher->grades->pluck('grade_name')->implode(', ')
                : 'No Grades Assigned';

            fputcsv($file, [
                $teacher->reg_no,
                $teacher->teacher_name,
                $teacher->email,
                $teacher->nic,
                $teacher->address,
                $teacher->phone_no,
                $subjects,
                $grades,
                asset($teacher->nic_front),
                asset($teacher->nic_back),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function edit($id)
{
    $teacher = Teacher::with(['subjects', 'grades'])->findOrFail($id);
    $subjects = Subject::all();
    $grades = Grade::all();

    return view('teacher.edit', compact('teacher', 'subjects', 'grades'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'teacher_name' => 'required|string|max:255',
        'email' => 'required|email|unique:teachers,email,' . $id,
        'nic' => 'required|string|unique:teachers,nic,' . $id,
        'address' => 'nullable|string',
        'phone_no' => 'nullable|string',
        'subjects' => 'nullable|array',
        'grades' => 'nullable|array',
    ]);

    $teacher = Teacher::findOrFail($id);

    // Update teacher data
    $teacher->update([
        'teacher_name' => $validatedData['teacher_name'],
        'email' => $validatedData['email'],
        'nic' => $validatedData['nic'],
        'address' => $validatedData['address'] ?? null,
        'phone_no' => $validatedData['phone_no'] ?? null,
    ]);

    // Sync subjects and grades
    $teacher->subjects()->sync($validatedData['subjects'] ?? []);
    $teacher->grades()->sync($validatedData['grades'] ?? []);

    return redirect()->route('teacher.index')->with('success', 'Teacher updated successfully!');
}









public function delete($id)
{
    // Find the teacher by ID
    $teacher = Teacher::findOrFail($id);

    // Detach related subjects and grades (pivot tables)
    $teacher->subjects()->detach();
    $teacher->grades()->detach();

    // Delete the teacher
    $teacher->delete();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Teacher deleted successfully!');
}
public function dashboard()
    {
        // You can return a view for teacher dashboard
        return view('Teacher.dashboard', [
        'studentsCount' => Student::count(),
        'teachersCount' => Teacher::count(),
        'coursesCount'  => Course::count(),
        'gradesCount'   => Grade::count(),
        'subjectsCount' => Subject::count(),
    ]);

    }



}
