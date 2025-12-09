<div>
    <div class="container-fluid mt-2">

       
            
            <!-- Add Student Button -->
            <div class="row mt-5">
    <div class="col-6">
        <!-- Add Student Button -->
        <div class="mb-0 d-flex">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                + Add Student
            </button>
        </div>
    </div>

    <div class="col-6">
        <div class="mb-0 d-flex justify-content-end align-items-center gap-2">
            <!-- Import CSV Form -->
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                @csrf
                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required style="height: 40px;">
                <button type="submit" class="btn btn-danger" style="height: 40px; min-width: 120px;">Import</button>
            </form>

            <!-- Export Dropdown -->
            <form id="exportForm" method="GET" class="d-flex align-items-center">
                <select id="exportType" class="form-select" style="height: 40px; min-width: 120px; border:2px solid #28a745; border-radius:6px; color: #28a745; font-weight: 500;">
                    <option value="">Export</option>
                    <option value="pdf">Export as PDF</option>
                    <option value="csv">Export as CSV</option>
                </select>
            </form>
        </div>
    </div>
</div>


        <div class="row mt-2">
            <form action="{{ route('student.index') }}" method="GET">
    <input type="text"
    id="studentSearch"
           name="search"
           value="{{ request('search') }}"
           class="form-control mb-3"
           placeholder="Search Student by Name or Reg No">
</form>
            

                <table class="table">
                    <thead >
                    <tr class="table-dark">

                        <th scope="col">Register No</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone no</th>
                        <th scope="col">Date Of Birth</th>
                       <th scope="col">Grades</th>
                        <th scope="col">Courses</th>
                        


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
    @if($student->grade)
        {{ $student->grade->grade_name }}
    @else
        <span class="text-danger">No Grade Assigned</span>
    @endif
</td>



                            <td>
                @if($student->courses->count() > 0)
                    @foreach($student->courses as $course)
                       <span style="margin: 5px">{{ $course->course_name }}</span>

                    @endforeach
                @else
                    <span class="text-danger">No Courses Assigned</span>
                @endif
            </td>

            



   <!-- NIC Image Modal (Only One) -->



                            <td>
                                <!-- Delete Button -->
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Student Update</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('student.update') }}" method="POST">
                                                    <div class="row">
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

                                                    <div class="form-group mb-3 col-md-6">
                <label>Select Grade</label>
                <select name="grade_id" class="form-control" required>
                    <option value="">Select Grade</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ $student->grade_id == $grade->id ? 'selected' : '' }}>
                            {{ $grade->grade_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Course Selection -->
            <div class="form-group mb-3 col-md-6">
                <label>Select Course</label>
                <select name="course_id" class="form-control" required>
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- NIC Front Upload -->
            <div class="form-group mb-3 col-md-6">
                <label>NIC Front</label>
                <input type="file" name="nic_front" class="form-control">
                @if($student->nic_front)
                    <img src="{{ asset($student->nic_front) }}" width="80" class="mt-2">
                @endif
            </div>

            <!-- NIC Back Upload -->
            <div class="form-group mb-3 col-md-6">
                <label>NIC Back</label>
                <input type="file" name="nic_back" class="form-control">
                @if($student->nic_back)
                    <img src="{{ asset($student->nic_back) }}" width="80" class="mt-2">
                @endif
            </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('student.delete', $student->id) }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="confirmDelete(event, '{{ route('student.delete', $student->id) }}')">
                                    <i class="bi bi-trash"></i>
                                </a>

                                
    <button type="button" class="btn btn-info btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#viewModal{{ $student->id }}">
    <i class="bi bi-eye"></i>
</button>
<div class="modal fade" id="viewModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header  text-black">
                <h5 class="modal-title">Student Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6 mb-2">
                        <strong>Register No:</strong>
                        <p>{{ $student->reg_no }}</p>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Full Name:</strong>
                        <p>{{ $student->name }}</p>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Email:</strong>
                        <p>{{ $student->email }}</p>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Phone No:</strong>
                        <p>{{ $student->ph_no }}</p>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Date of Birth:</strong>
                        <p>{{ $student->dob }}</p>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Grade:</strong>
                        <p>{{ $student->grade ? $student->grade->grade_name : 'N/A' }}</p>
                    </div>

                    <div class="col-md-12 mb-2">
                        <strong>Courses:</strong>
                        <p>
                            @foreach($student->courses as $course)
                                <span class="badge bg-success">{{ $course->course_name }}</span>
                            @endforeach
                        </p>
                    </div>

                    <!-- NIC Images -->
                    <div class="col-md-6 text-center">
                        <strong>NIC Front</strong><br>
                        <img src="{{ asset($student->nic_front) }}" width="150"
                             class="img-thumbnail mt-2">
                    </div>

                    <div class="col-md-6 text-center">
                        <strong>NIC Back</strong><br>
                        <img src="{{ asset($student->nic_back) }}" width="150"
                             class="img-thumbnail mt-2">
                    </div>
                    <div class="col-md-6 text-center">
                        <strong>Profile Picture:</strong>
                        @if($student->profile_picture)
                            <img src="{{ asset($student->profile_picture) }}" width="100" class="img-thumbnail">
                        @else
                            <span class="text-danger">Not uploaded</span>
                        @endif
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>




                            </td>


                        </tr>
                    @endforeach


                    </tbody>
                </table>

                

            </div>
        </div>

    </div>
</div>

    <!-- NIC Image Modal (one modal only) -->



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

<script>
document.getElementById('studentSearch').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        row.style.display =
            row.textContent.toLowerCase().includes(value)
                ? '' : 'none';
    });
});
</script>



<script>
        document.getElementById('exportType').addEventListener('change', function() {

            let searchValue = document.getElementById('studentSearch').value;

            if (this.value === 'pdf') {
                window.location.href = "{{ route('student.export.pdf') }}?search=" + searchValue;
            }

            if (this.value === 'excel') {
                window.location.href = "{{ route('student.export.csv') }}?search=" + searchValue;
            }

        });
    </script>








    @endpush









