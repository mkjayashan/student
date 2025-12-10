<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;



class ClassController extends Controller
{


public function index(Request $request)
{
    if ($request->ajax()) {
        $search = $request->input('search');

        $classes = Classroom::with('grade')
            ->when($search, function ($query) use ($search) {
                $query->where('class_name', 'like', "%{$search}%")
                    ->orWhereHas('grade', function ($q) use ($search) {
                        $q->where('grade_name', 'like', "%{$search}%");
                    });
            })
            ->get();

        return response()->json([
            'classes' => $classes
        ]);
    }

    // Normal load
    $grades = Grade::all();
    $classes = Classroom::with('grade')->get();

    return view('Class.index', compact('grades', 'classes'));
}







    public function import(Request $request)
{
    $request->validate([
        'import_file' => 'required|mimes:csv,txt',
    ]);

    $file = $request->file('import_file');

    if (($handle = fopen($file, 'r')) !== false) {
        $header = fgetcsv($handle, 1000, ',');

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

    $grade = Grade::firstOrCreate(
        ['grade_name' => trim($row[0])]
    );

    Classroom::create([
        'grade_id' => $grade->id,
        'class_name' => trim($row[1]),
    ]);
}
        fclose($handle);
    }

    return redirect()->back()->with('success', 'Classes imported successfully!');
}



       public function exportCsv(Request $request)
    {
        $search = $request->input('search');

        $classes = Classroom::with('grade')
            ->when($search, function($query) use ($search) {
                $query->where('class_name', 'like', "%{$search}%")
                      ->orWhereHas('grade', fn($q) => $q->where('grade_name', 'like', "%{$search}%"));
            })->get();

        $filename = 'classes.csv';
        $handle = fopen($filename, 'w+');

        fputcsv($handle, ['ID', 'Grade', 'Class Name']);

        foreach ($classes as $class) {
            fputcsv($handle, [
                $class->id,
                $class->grade ? $class->grade->grade_name : '',
                $class->class_name,
            ]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    // PDF Export
    public function exportPdf(Request $request)
    {
        $search = $request->input('search');

        $classes = Classroom::with('grade')
            ->when($search, function($query) use ($search) {
                $query->where('class_name', 'like', "%{$search}%")
                      ->orWhereHas('grade', fn($q) => $q->where('grade_name', 'like', "%{$search}%"));
            })->get();

        $pdf = Pdf::loadView('class.pdf', compact('classes')); // create a class/pdf.blade.php
        return $pdf->download('classes.pdf');
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
