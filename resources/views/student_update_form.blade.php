@extends('app')
@push('title') Student Update
@endpush
@push("page_header_title")
    Student Update
@endpush
@section('content')

    <div class="row">
        <div class="col-8">
            <form action="{{route('student.update')}}" method="post"  class="registration-form w-50">
                @csrf
                <input type="hidden" name="id" value="{{$student->id}}">

                <div class="form-group">
                    <label for="exampleInputEmail1">Register No</label>
                    <input type="text" name="reg_no" class="form-control"  placeholder="register no" value="{{$student->reg_no}}"  required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Full Name</label>
                    <input type="text" name="name"  class="form-control"  placeholder="full name"  value="{{$student->name}}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" name="email"  class="form-control"  placeholder="email"  value="{{$student->email}}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Phone No</label>
                    <input type="text" name="ph_no" class="form-control"  placeholder="phone no"  value="{{$student->ph_no}}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Date Of Birth</label>
                    <input type="date" name="dob"  class="form-control"  placeholder="date of birth"  value="{{$student->dob}}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password"  class="form-control"  placeholder="password"   value="{{$student->password}}" required>
                </div>

                <button type="submit" class="btn btn-warning mt-3 w-75">Update</button>
            </form>
        </div>

    </div>

@endsection
