@extends('app')
@push('title')
    Student List
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <h1>Student List</h1>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">

            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Register No</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone no</th>
                        <th scope="col">Date Of Birth</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{$student->reg_no}}</td>
                            <td>{{$student->name}}</td>
                            <td>{{$student->email}}</td>
                            <td>{{$student->ph_no}}</td>
                            <td>{{$student->dob}}</td>
                            <td>
                                <button class="btn btn-warning">Update</button>
                                <button class="btn bg-danger">Delete</button>

                            </td>


                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection


