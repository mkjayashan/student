<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('created_at', 'desc')->get();
        return view('student_list',compact('students'));

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
        try{
               Student::query()->create([
                   'reg_no'=>$request->reg_no,
                   'name'=>$request ->name,
                   'email'=>$request->email,
                   'ph_no'=>$request->ph_no,
                   'dob'=>$request->dob,
                   'password'=>$request->password,

               ]);
               return redirect()->route('student.index');
        }
        catch(\Exception $e) {
            return $e;
        }
  }

    public function edit($id)
    {
        $student = Student::query()
            ->where('id',$id)
            ->first();

        return view('student_update_form',compact('student'));

    }

public function update(Request $request){
    try{
        Student::query()
            ->where('id',$request->id)
        ->update([
            'reg_no'=>$request->reg_no,
            'name'=>$request ->name,
            'email'=>$request->email,
            'ph_no'=>$request->ph_no,
            'dob'=>$request->dob,
            'password'=>$request->password,

        ]);
        return redirect()->route('student.index');
    }
    catch(\Exception $e) {
        return $e;
    }
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

   /* public function search(Request $request)
    {
        try {
            $keyword = $request->input('search');

            $students = Student::query()
                ->where('name', 'like', "%{$keyword}%")
                ->orWhere('reg_no', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->get();

            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }*/

}
