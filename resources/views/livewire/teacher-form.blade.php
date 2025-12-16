<div>


         

        
       


            <!-- Add Teacher Button -->
   

        

   



<div class="row mt-5 ">
    <div class="col-6">
 <div class="mb-3 d-flex ">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
            + Add Teacher
        </button>
    </div>
    </div>
    <div class="col-6">
        <div class="mb-3 d-flex justify-content-end align-items-center gap-2">

    <!-- Import CSV Form -->
    <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
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

    

    <!-- Search Input -->
    


    <!-- Teacher Table -->

     <input type="text" class="form-control mb-3" placeholder="Search teachers..."
           wire:model.debounce.300ms="search">
    <table class="table table-bordered">
        <thead>
            <tr class="table-dark">
                <th>Teacher ID</th>
                <th>Teacher Name</th>
                <th>Email</th>
                <th>NIC</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>Subjects</th>
                <th>Grades</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->reg_no}}</td>
                    <td>{{ $teacher->teacher_name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->nic }}</td>
                    <td>{{ $teacher->address }}</td>
                    <td>{{ $teacher->phone_no }}</td>
                    <td>
                        @forelse($teacher->subjects as $subject)
                            <span class="badge bg-success m-1">{{ $subject->subject_name }}</span>
                        @empty
                            <span class="badge bg-success m-1">No Subject Assigned</span>
                        @endforelse
                    </td>
                    <td>
                        @foreach($teacher->grades as $grade)
                            <span class="badge bg-success m-1">{{ $grade->grade_name }}</span>
                        @endforeach
                    </td>


                    
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTeacherModal{{ $teacher->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        <!-- Delete Button -->
                        <form id="delete-form-{{ $teacher->id }}" action="{{ route('teacher.delete', $teacher->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $teacher->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
<!-- View Button -->
<button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewTeacherModal{{ $teacher->id }}">
    <i class="fa-solid fa-eye"></i>
</button>
<!-- View Teacher Modal -->
<div class="modal fade" id="viewTeacherModal{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teacher Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div class="row">

                <div class="row justify-content-center text-center mb-3">
        <!-- Profile Picture -->
        <div class="col-md-12">
            <strong>Profile Picture:</strong><br>
            @if($teacher->profile_picture)
                <img src="{{ asset($teacher->profile_picture) }}" 
                     width="120" height="120"
                     class="rounded-circle shadow mt-2">
            @else
                <span class="text-danger mt-2">Not uploaded</span>
            @endif
        </div>
    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Teacher ID:</strong> {{ $teacher->reg_no }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong> {{ $teacher->teacher_name }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong> {{ $teacher->email }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>NIC:</strong> {{ $teacher->nic }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Address:</strong> {{ $teacher->address }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Phone No:</strong> {{ $teacher->phone_no }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Subjects:</strong>
                        @forelse($teacher->subjects as $subject)
                            <span>{{ $subject->subject_name }}</span>
                        @empty
                            <span class="text-danger">No Subjects Assigned</span>
                        @endforelse
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Grades:</strong>
                        @forelse($teacher->grades as $grade)
                            <span>{{ $grade->grade_name }}</span>
                        @empty
                            <span class="text-danger">No Grades Assigned</span>
                        @endforelse
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>NIC Front:</strong>
                        @if($teacher->nic_front)
                            <img src="{{ asset($teacher->nic_front) }}" width="100" class="img-thumbnail">
                        @else
                            <span class="text-danger">Not uploaded</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>NIC Back:</strong>
                        @if($teacher->nic_back)
                            <img src="{{ asset($teacher->nic_back) }}" width="100" class="img-thumbnail">
                        @else
                            <span class="text-danger">Not uploaded</span>
                        @endif
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</div>
                    </td>
                </tr>

                <!-- Edit Teacher Modal -->
                <div class="modal fade" id="editTeacherModal{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Teacher</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('teacher.update', $teacher->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
<div class="mb-3">
                                        <label>Teacher ID</label>
                                        <input type="text" name="reg_no" value="{{ $teacher->reg_no }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Teacher Name</label>
                                        <input type="text" name="teacher_name" value="{{ $teacher->teacher_name }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ $teacher->email }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>NIC</label>
                                        <input type="text" name="nic" value="{{ $teacher->nic }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <input type="text" name="address" value="{{ $teacher->address }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone No</label>
                                        <input type="text" name="phone_no" value="{{ $teacher->phone_no }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Subjects</label>
                                        <select name="subjects[]" multiple class="form-control">
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ $teacher->subjects->contains($subject->id) ? 'selected' : '' }}>
                                                    {{ $subject->subject_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Grades</label>
                                        <select name="grades[]" multiple class="form-control">
                                            @foreach($grades as $grade)
                                                <option value="{{ $grade->id }}" {{ $teacher->grades->contains($grade->id) ? 'selected' : '' }}>
                                                    {{ $grade->grade_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Teacher</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No teachers found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</td>
</div>
        </div>

    </div>


        




       
        
        



    </div>


    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const teacherId = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${teacherId}`).submit();
                        }
                    });
                });
            });
        });
    </script>

    <script>
document.getElementById('exportType').addEventListener('change', function() {
    let type = this.value;

    if(type === 'pdf'){
        window.location.href = "{{ route('teacher.export.pdf') }}"; // route to PDF export
    }
    if(type === 'csv'){
        window.location.href = "{{ route('teacher.export.csv') }}"; // route to CSV export
    }

    // Reset dropdown after selecting
    this.value = '';
});
</script>

<script>
document.getElementById('TeacherSearch').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        row.style.display =
            row.textContent.toLowerCase().includes(value)
                ? '' : 'none';
    });
});
</script>
    @endpush

