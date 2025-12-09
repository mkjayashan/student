<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;


class GradeController extends Controller
{
    public function index(Request $request) {

        $search = $request->input('search');

        $grades = Grade::when($search, function ($query) use ($search) {
            return $query->where('grade_name', 'LIKE', "%{$search}%")
                ->orWhere('grade_code', 'LIKE', "%{$search}%");
        })->get();
        return view('grade.index', compact('grades'));
    }
    public function store(Request $request)
    {
        try{
            Grade::query()->create([
                'grade_code'=>$request->grade_code,
                'grade_name'=>$request ->grade_name,


            ]);
            return redirect()->route('grade.index');

        }
        catch (\Exception $e){

            return $e;
        }


    }
    public function edit($id)
    {
        $grade = Grade::findOrFail($id); // get subject by id

        return view('grade_update_form', compact('grade'));
    }


    public function update(Request $request)
    {
        try {

            Grade::where('id', $request->id)->update([
                'grade_code' => $request->grade_code,
                'grade_name' => $request->grade_name,
            ]);

            return redirect()
                ->route('grade.index')
                ->with('success', 'Grade updated successfully!');

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function delete($id)
    {
        $grade = Grade::findOrFail($id);

        $grade->delete();

        return redirect()->back()->with('success', 'Grade deleted successfully!');
    }
}
