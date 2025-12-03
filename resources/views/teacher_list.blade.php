@extends('layouts.app')
@push('title')
    Teacher List
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        Teacher
    @endpush
    <div class="container">


        <div class="col-12">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                + Add Teacher
            </button>
        </div>
        <!-- TeacherTable---------------------------------- ---- -->
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Reg_no</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
                <th>Action</th>

            </tr>
            </thead>
            <tbody>
            @foreach($teachers as $teacher)

                <tr>
                    <td>{{$teacher->reg_no}}</td>
                    <td>{{$teacher->name}}</td>
                    <td>{{$teacher->email}}</td>
                </tr>

            @endforeach
            </tbody>
        </table>


        <!-- addTeacherModal -->
        <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeacherModal">Teacher Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form wire:submit.prevent="submit" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label>Teacher ID</label>
                                <input type="text" wire:model="reg_no" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Teacher Name</label>
                                <input type="text" wire:model="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" wire:model="address" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>NIC</label>
                                <input type="text" wire:model="NIC" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone No 1</label>
                                <input type="text" wire:model="phone_no1" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone No 2</label>
                                <input type="text" wire:model="phone_no2" class="form-control">
                            </div>



                            <div class="mb-3">
                                <label>Course</label>
                                <select wire:model="course_id" class="form-control" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Class</label>
                                <select wire:model="class_id" class="form-control" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Register Teacher</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>


    </div>

@endsection
