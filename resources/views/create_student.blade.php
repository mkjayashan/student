@extends('app')
@push('title')
    Student Register
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <h1>Student Register Form</h1>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6">
                <form action="{{route('student.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Register No</label>
                        <input type="text" name="reg_no" class="form-control"  placeholder="register no" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Full Name</label>
                        <input type="text" name="name"  class="form-control"  placeholder="full name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" name="email"  class="form-control"  placeholder="email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Phone No</label>
                        <input type="text" name="ph_no" class="form-control"  placeholder="phone no" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Date Of Birth</label>
                        <input type="date" name="dob"  class="form-control"  placeholder="date of birth" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password"  class="form-control"  placeholder="password" required>
                    </div>

                    <button type="submit" class="btn btn-success mt-3 w-100">Submit</button>
                </form>
            </div>

        </div>
    </div>


@endsection


