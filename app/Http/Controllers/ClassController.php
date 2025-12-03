<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\grade;
use Illuminate\Http\Request;

class ClassController extends Controller
{


    public function index()
    {
        $grades = Grade::all();
        $classes = Classroom::with('grade')->get();

        return view('Class.index', compact('grades', 'classes'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'class_name' => 'required',
            'grade_id' => 'required|exists:grades,id'
        ]);

        ClassRoom::create([
            'class_name' => $request->class_name,
            'grade_id' => $request->grade_id,
        ]);

        return redirect()->back()->with('success', 'Class created successfully!');
    }
    public function edit($id)
    {
        $class = Classroom::findOrFail($id);
        $grades = Grade::all();

        return view('Class.edit', compact('class', 'grades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required',
            'grade_id' => 'required|exists:grades,id',
        ]);

        Classroom::findOrFail($id)->update([
            'class_name' => $request->class_name,
            'grade_id' => $request->grade_id,
        ]);

        return redirect()->route('class.index')
            ->with('success', 'Class updated successfully!');    }

    public function render()
    {
        return view('livewire.create-class', [
            'classes' => Classroom::with('grade')->get()
        ]);
    }



    public function delete($id)
    {
        $class = Classroom::findOrFail($id);
        $class->delete();

        return redirect()->route('class.index')->with('success', 'Class deleted successfully.');
    }


}
