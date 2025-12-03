<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use CoursesExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Vtiful\Kernel\Excel;



class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('subjects')->get();
        $subjects = Subject::all();

        return view('course.index', [
            'courses' => $courses,
            'subjects' => $subjects,
            'selectedSubjects' => []
        ]);

    }

    public function exportPDF(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::when($search, function($query) use ($search) {
            return $query->where('course_name', 'like', "%{$search}%")
                ->orWhere('course_code', 'like', "%{$search}%");

        })->get();

        $pdf = Pdf::loadView('course.pdf', compact('courses'));

        return $pdf->download('courses.pdf');
    }

    public function exportCsv(Request $request)
    {
        $search = $request->input('search');

        // Load courses with subjects
        $courses = Course::with('subjects')
            ->when($search, function($query) use ($search) {
                $query->where('course_name', 'like', "%{$search}%")
                    ->orWhere('course_code', 'like', "%{$search}%");
            })->get();

        $filename = 'courses.csv';
        $handle = fopen($filename, 'w+');

        // Header row
        fputcsv($handle, ['ID', 'Course Name', 'Course Code', 'Subjects']);

        foreach ($courses as $course) {
            // Get subject names as a comma-separated string
            $subjectNames = $course->subjects->pluck('subject_name')->implode(', ');
            fputcsv($handle, [
                $course->id,
                $course->course_name,
                $course->course_code,
                $subjectNames
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }



    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:csv,txt,pdf'
        ]);

        $file = $request->file('import_file');
        $extension = $file->getClientOriginalExtension();

        try {
            if ($extension == 'csv' || $extension == 'txt') {
                $this->importCsv($file);
            } elseif ($extension == 'pdf') {
                $this->importPdf($file);
            } else {
                return back()->with('error', 'Unsupported file type.');
            }

            return back()->with('success', 'File imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    protected function importCsv($file)
    {
        if (($handle = fopen($file, 'r')) !== false) {
            fgetcsv($handle); // skip header

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $courseCode = trim($data[0]);
                $courseName = trim($data[1]);
                $subjectStr = trim($data[2]); // comma-separated subject codes

                if ($courseCode === '' || $courseName === '') continue;

                $course = Course::firstOrCreate([
                    'course_code' => $courseCode,
                    'course_name' => $courseName,
                ]);

                if ($subjectStr !== '') {
                    $subjectCodes = array_map('trim', explode(',', $subjectStr));
                    $subjectIds = Subject::whereIn('subject_code', $subjectCodes)->pluck('id')->toArray();

                    if (!empty($subjectIds)) {
                        $course->subjects()->syncWithoutDetaching($subjectIds);
                    }
                }
            }

            fclose($handle);
        }
    }











    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'subjects' => 'required|array|min:1',
        ]);

        $course = Course::create(['course_name' => $request->course_name]);
        $course->subjects()->attach($request->subjects);

        return response()->json(['success' => true, 'message' => 'CourseForm created successfully!']);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $subjects = Subject::all();

        return view('course.edit', compact('course', 'subjects'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'course_code' => 'required',
            'course_name' => 'required',
            'subject_ids' => 'required|array',
        ]);

        $course = Course::findOrFail($id);
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->save();

        // Sync selected subjects
        $course->subjects()->sync($request->subject_ids);

        return redirect()->back()->with('success', 'Course updated successfully!');
    }





    public function delete($id)
    {
        $course = Course::findOrFail($id);

        // delete relation subjects first (pivot table)
        $course->subjects()->detach();

        // delete course
        $course->delete();

        return redirect()->back()->with('success', 'Course deleted successfully!');
    }


}
