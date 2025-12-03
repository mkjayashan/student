@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Import Subjects from PDF</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('subjects.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="pdf_file" class="form-label">Select PDF file</label>
                <input type="file" name="pdf_file" id="pdf_file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
@endsection
