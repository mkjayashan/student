@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Welcome Dashboard </h3>

    <!-- Stats Cards -->
    <div class="row mt-4">
        <!-- Students -->
        <div class="col-md-3 mb-3">
<div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Students</h5>
                        <h3 id="studentsCount">{{ $studentsCount }}</h3>
                        <small>Auto-refreshing every 5s</small>
                    </div>
                    <i class="bi bi-people-fill fs-2"></i>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-md-3 mb-3">
<div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Teachers</h5>
                        <h3 id="teachersCount">{{ $teachersCount }}</h3>
                        <small>Auto-refreshing every 5s</small>
                    </div>
                    <i class="bi bi-person-badge fs-2"></i>
                </div>
            </div>
        </div>

        <!-- Subjects -->
        <div class="col-md-3 mb-3">
<div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Subjects</h5>
                        <h3 id="subjectsCount">{{ $subjectsCount }}</h3>
                        <small>Auto-refreshing every 5s</small>
                    </div>
                    <i class="bi bi-book fs-2"></i>
                </div>
            </div>
        </div>

        <!-- Courses -->
        <div class="col-md-3 mb-3">
<div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Courses</h5>
                        <h3 id="coursesCount">{{ $coursesCount }}</h3>
                        <small>Auto-refreshing every 5s</small>
                    </div>
                    <i class="bi bi-journal-bookmark fs-2"></i>
                </div>
            </div>
        </div>
    </div>


    <br>
    <h2>Quick Access</h2>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
<a href="{{ route('student.index') }}" class="btn  w-100">
                    <i class="bi bi-person-plus"></i> View Student
</a>
</div>
</div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
          <a href="{{ route('teacher.index') }}" class="btn  w-100">         
                   <i class="bi bi-person-plus-fill"></i> View Teacher
</a>
            </div>
</div>

        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('subject.index') }}" class="btn  w-100">
                <i class="bi bi-book"></i> View Subjects
            </a>
        </div>
        </div>
</div>
        <div class="col-md-3 mb-3">
            <div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('course.index') }}" class="btn  w-100">
                <i class="bi bi-journal-bookmark"></i> View Courses
            </a>
        </div>
        </div>
</div>
        <div class="col-md-3 mb-3">
            <div class="card text-dark shadow border border-dark" style="background-color: transparent;">
                <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('grade.index') }}" class="btn  w-100">
                <i class="bi bi-award"></i> View Grades
            </a>
        </div>
        </div>
</div>
        
    </div>

</div>
@endsection
