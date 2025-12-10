<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Grade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;



use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public $student_id;

   public function index(Request $request)
{
    // Get search value
    $search = $request->input('search');

    // Query with search filter
    $students = Student::with('grade', 'courses')
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

            // Map by column index since CSV headers don't match DB fields
            $data = [
                'reg_no'     => $row[0],
                'name'       => $row[1],
                'email'      => $row[2],
                'ph_no'      => $row[3],
                'dob'        => Carbon::parse($row[4])->format('Y-m-d'),
                'grade'      => $row[5],
                'courses'    => $row[6],
                'nic_front'  => $row[7] ?? null,
                'nic_back'   => $row[8] ?? null,
            ];

            // Find Grade by name
            $grade = Grade::where('grade_name', $data['grade'])->first();

            // Create Student Record
            $student = Student::create([
                'reg_no'     => $data['reg_no'],
                'name'       => $data['name'],
                'email'      => $data['email'],
                'ph_no'      => $data['ph_no'],
                'dob'        => $data['dob'],
                'password'   => Hash::make('12345678'),
                'grade_id'   => $grade ? $grade->id : null,
                'nic_front'  => $data['nic_front'],
                'nic_back'   => $data['nic_back'],
            ]);

            // Courses (comma separated list by name)
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

    // Fetch students matching search if provided
    $students = Student::with(['courses', 'grade'])
        ->when($search, function($query) use ($search) {
            $query->where('reg_no', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
        })
        ->get();

    $fileName = 'students.csv';

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = ['Reg No', 'Name', 'Email', 'Phone No', 'Date of Birth', 'Grades', 'Courses', 'NIC Front', 'NIC Back'];

    $callback = function() use ($students, $columns) {
        $file = fopen('php://output', 'w');

        // Write header row
        fputcsv($file, $columns);

        foreach ($students as $student) {
            $grade = $student->grade ? $student->grade->grade_name : 'No Grade Assigned';
            $courses = $student->courses->count() > 0
                ? $student->courses->pluck('course_name')->implode(', ')
                : 'No Courses Assigned';

            fputcsv($file, [
                $student->reg_no,
                $student->name,
                $student->email,
                $student->ph_no,
                $student->dob,
                $grade,
                $courses,
                asset($student->nic_front),
                asset($student->nic_back),
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
        return view('dashboard');
    }
  public function store(Request $request){

    try {
        // Validation
        $request->validate([
            'reg_no' => 'required|unique:students,reg_no',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'ph_no' => 'required|string|max:15',
            'dob' => 'required|date',
            'password' => 'required|min:6',
            'nic_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nic_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $nicFrontPath = $request->file('nic_front')->storeAs(
            'images/nic',
            time().'_front_'.$request->file('nic_front')->getClientOriginalName(),
            'public'
        );

        // NIC Back Upload
        $nicBackPath = $request->file('nic_back')->storeAs(
            'images/nic',
            time().'_back_'.$request->file('nic_back')->getClientOriginalName(),
            'public'
        );
        
        
        $student = Student::query()->create([
   'reg_no'=>$request->reg_no,
   'name'=>$request->name,
   'email'=>$request->email,
   'ph_no'=>$request->ph_no,
   'dob'=>$request->dob,
   'nic_front' => '/storage/'.$nicFrontPath,
            'nic_back' => '/storage/'.$nicBackPath,
   'password'=>bcrypt($request->password), // hash password
]);




// Attach selected courses if provided
if($request->has('selected_courses')){
$student->courses()->attach($this->selected_courses);

}

return redirect()->route('student.index');

        }
        catch(\Exception $e) {
            return $e;
        }
  }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
    $grades = Grade::all();
    $courses = Course::all();


        return view('student_update_form',compact('student', 'grades', 'courses'));

    }

public function update(Request $request)
{
    $student = Student::findOrFail($request->id);

    // Validate input
    $request->validate([
        'reg_no' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'ph_no' => 'required|string|max:15',
        'dob' => 'required|date',
        'password' => 'required|string|min:6',
        'grade_id' => 'required|exists:grades,id',
        'course_id' => 'required|exists:courses,id',
        'nic_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'nic_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Update student fields
        

    $student->reg_no = $request->reg_no;
    $student->name = $request->name;
    $student->email = $request->email;
    $student->ph_no = $request->ph_no;
    $student->dob = $request->dob;
    $student->password = bcrypt($request->password); // hash password
    $student->grade_id = $request->grade_id;
    $student->course_id = $request->course_id;

    // Handle NIC Front Upload
    if ($request->hasFile('nic_front')) {
        $nicFrontPath = $request->file('nic_front')->store('students/nic', 'public');
        $student->nic_front = $nicFrontPath;
    }

    // Handle NIC Back Upload
    if ($request->hasFile('nic_back')) {
        $nicBackPath = $request->file('nic_back')->store('students/nic', 'public');
        $student->nic_back = $nicBackPath;
    }

    $student->save();

    return redirect()->back()->with('success', 'Student updated successfully!');
}


    public function delete($id)
    {
       try{
           Student::query()
               ->where('id',$id)
               ->delete();
           return redirect()->route('student.index')->with('success', 'Student deleted successfully!');

       }
       catch (\Exception $e){
           return $e;
       }
    }


public function show(Student $student)
{
    return view('student.show', compact('student'));
}






}
