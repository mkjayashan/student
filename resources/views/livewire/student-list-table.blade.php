<div>
    <div class="container-fluid mt-5">

        <div class="row">
            <div class="col-6">
                <input type="text" id="search" class="form-control"
                       placeholder="Search by name, reg no, or email">
            </div>
            <!-- Add Student Button -->
            <div class="col-2">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    + Add Student
                </button>
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
                                <!-- Delete Button -->
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    update
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Student Update</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('student.update') }}" method="POST">
                                                    @csrf



                                                    <input type="hidden" name="id" value="{{ $student->id }}">



                                                    <div class="form-group mb-3">
                                                        <label>Register No</label>
                                                        <input type="text" name="reg_no" class="form-control" value="{{ $student->reg_no }}" required>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label>Full Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label>Phone No</label>
                                                        <input type="text" name="ph_no" class="form-control" value="{{ $student->ph_no }}" required>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label>Date of Birth</label>
                                                        <input type="date" name="dob" class="form-control" value="{{ $student->dob }}" required>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label>Password</label>
                                                        <input type="password" name="password" class="form-control" value="{{ $student->password }}" required>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('student.delete', $student->id) }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="confirmDelete(event, '{{ route('student.delete', $student->id) }}')">
                                    Delete
                                </a>

                            </td>


                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>

    </div>


        <!-- Button trigger modal -->


        <!-- Modal -->





    @push('script')
        <script>
            function confirmDelete(event, url) {
                event.preventDefault(); // Stop the link from automatically opening the delete route

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this student record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // Redirect to delete route
                    }
                });
            }
        </script>


    @endpush

    {{--<table class="table">
        <thead>
        <tr>
            <th scope="col">Register_no</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Date Of Birth</th>

        </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>

                <th scope="row">{{$student->reg_no}}</th>
                <td>{{$student->name}}</td>
                <td>{{$student->email}}</td>
                <td>{{$student->ph_no}}</td>
                <td>{{$student->dob}}</td>


            </tr>
        @endforeach


        </tbody>
    </table>--}}
</div>

