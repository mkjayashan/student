@extends('layouts.app') <!-- or your layout -->

@section('content')
<div class="container mt-5">
    <h2>Student Details</h2>

    <div class="card p-4 shadow-sm">
        <h5>Register No: {{ $student->reg_no }}</h5>
        <h5>Name: {{ $student->name }}</h5>
        <h5>Email: {{ $student->email }}</h5>
        <h5>Phone No: {{ $student->ph_no }}</h5>
        <h5>Date of Birth: {{ $student->dob }}</h5>
        <h5>Grade: {{ $student->grade->grade_name ?? 'No Grade Assigned' }}</h5>

        <h5>Courses:</h5>
        @if($student->courses->count() > 0)
            <ul>
                @foreach($student->courses as $course)
                    <li>{{ $course->course_name }}</li>
                @endforeach
            </ul>
        @else
            <span>No Courses Assigned</span>
        @endif

        <h5>NIC Images:</h5>
        <div class="d-flex gap-3">
            <!-- NIC Front -->
            <div>
                <p>Front:</p>
                <img src="{{ $student->nic_front ? asset('storage/'.$student->nic_front) : 'https://via.placeholder.com/300?text=No+Image' }}" 
                     class="img-fluid border rounded shadow" width="300" alt="NIC Front">
            </div>

            <!-- NIC Back -->
            <div>
                <p>Back:</p>
                <img src="{{ $student->nic_back ? asset('storage/'.$student->nic_back) : 'https://via.placeholder.com/300?text=No+Image' }}" 
                     class="img-fluid border rounded shadow" width="300" alt="NIC Back">
            </div>
        </div>
    </div>

    <a href="{{ route('student.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
