<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class SubjectController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $subjects = Subject::when($search, function ($query) use ($search) {
            return $query->where('subject_name', 'LIKE', "%{$search}%")
                ->orWhere('subject_code', 'LIKE', "%{$search}%");
        })->get();

        return view('subject.index', compact('subjects'));
    }

    
    public function exportPDF(Request $request)
    {
        $search = $request->input('search');

        $subjects = Subject::when($search, function ($q) use ($search) {
            return $q->where('subject_name', 'LIKE', "%{$search}%")
                ->orWhere('subject_code', 'LIKE', "%{$search}%");
        })->get();

        $pdf = Pdf::loadView('subject.pdf', compact('subjects'));

        return $pdf->download('subjects.pdf');
    }

    public function exportCsv(Request $request)
    {
        $search = $request->input('search');

        $subjects = Subject::with('courses')
            ->when($search, function ($query) use ($search) {
                $query->where('subject_name', 'like', "%{$search}%")
                    ->orWhere('subject_code', 'like', "%{$search}%");
            })->get();

        $filename = 'subjects.csv';
        $handle = fopen($filename, 'w+');

        fputcsv($handle, ['ID', 'Subject Code', 'Subject Name']);

        foreach ($subjects as $subject) {
            $courseNames = $subject->courses->pluck('course_name')->implode(', ');
            fputcsv($handle, [
                $subject->id,
                $subject->subject_code,
                $subject->subject_name,

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

        if ($extension == 'csv' || $extension == 'txt') {
            $this->importCsv($file);
        }

        if ($extension == 'pdf') {
            $this->importPdf($file);
        }

        return back()->with('success', 'File imported successfully!');
    }

    public function importCsv($file)
    {
        if (($handle = fopen($file, 'r')) !== false) {

            fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {

                $code = trim($data[0]);
                $name = trim($data[1]);

                if ($code === '' || $name === '') {
                    continue;
                }

                Subject::firstOrCreate([
                    'subject_code' => $code,
                    'subject_name' => $name,
                ]);
            }
            fclose($handle);
        }
    }


    protected function importPdf($file)
    {
        $path = $file->getRealPath();

        // Use full path to pdftotext on Windows
        $pdftotext = "C:\\xpdf\\bin64\\pdftotext.exe";
        $text = shell_exec("\"$pdftotext\" \"$path\" -");

        if (!$text) {
            return back()->with('error', 'Could not read PDF. Make sure it is text-based.');
        }

        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            if (preg_match('/^(\S+)\s+(.+)$/', $line, $matches)) {
                $code = $matches[1];
                $name = $matches[2];

                Subject::firstOrCreate([
                    'subject_code' => $code,
                    'subject_name' => $name,
                ]);
            }
        }
    }






    // Handle PDF upload & import





    public function create()
    {
        return view('subject.create');

    }

    public function store(Request $request)
    {
        try{
            Subject::query()->create([
                'subject_code'=>$request->subject_code,
                'subject_name'=>$request ->subject_name,


            ]);
            return redirect()->route('subject.index');

        }
        catch (\Exception $e){

            return $e;
        }


    }




    public function edit($id)
    {
        $subject = Subject::findOrFail($id); // get subject by id

        return view('subject_update_form', compact('subject'));
    }


    public function update(Request $request)
    {
        try {

            Subject::where('id', $request->id)->update([
                'subject_code' => $request->subject_code,
                'subject_name' => $request->subject_name,
            ]);

            return redirect()
                ->route('subject.index')
                ->with('success', 'Subject updated successfully!');

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function delete($id)
    {
        $subject = Subject::findOrFail($id);

        $subject->delete();

        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }

}
