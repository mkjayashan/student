<div>
<div class="container mt-4">
<div class="row">
    <div class="d-flex justify-content-between mb-3">

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClassModal">
            Create Class
        </button>
    </div>
        <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end gap-2">
            <!-- Import CSV Form -->
            <form action="{{ route('classes.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                @csrf
                <input type="file" name="import_file" accept=".csv,.pdf" required class="form-control" style="height: 40px;">
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
    <div class="row">
        <input type="text" id="classSearch" class="form-control" placeholder="Search Classes">

    <table class="table table-bordered table-striped">
        <thead class="table">
        <tr class="table-dark">


            <th>#</th>
            <th>Class Name</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody id="classTableBody">
        @foreach($classes as $index => $class)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $class->grade->grade_name }}{{ $class->class_name }}</td>

                <td>

                    <!-- Update Button -->
                    <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#updateClassModal{{ $class->id }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateClassModal{{ $class->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Update Class</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('class.update', $class->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label>Class Name</label>
                                            <input type="text" name="class_name" class="form-control"
                                                   value="{{ $class->class_name }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Select Grade</label>
                                            <select name="grade_id" class="form-control" required>
                                                @foreach($grades as $grade)
                                                    <option value="{{ $grade->id }}"
                                                        {{ $class->grade_id == $grade->id ? 'selected' : '' }}>
                                                        {{ $grade->grade_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-success">Update</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>



                    <button class="btn btn-danger btn-sm" onclick="deleteClass({{ $class->id }})">
                        <i class="bi bi-trash"></i>
                    </button>

                    <form id="delete-form-{{ $class->id }}" action="{{ route('class.delete', $class->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <button class="btn btn-info btn-sm" 
        data-bs-toggle="modal" 
        data-bs-target="#viewClassModal{{ $class->id }}">
    <i class="bi bi-eye-fill"></i>
</button>


<!-- View Modal -->
<div class="modal fade" id="viewClassModal{{ $class->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Class Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Class Name:</strong> {{ $class->class_name }}</p>
                <p><strong>Grade:</strong> {{ $class->grade->grade_name }}</p>
                
                <!-- Add more fields if needed -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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


   @push('script')
<script>
    function deleteClass(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "This class will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    document.getElementById('classSearch').addEventListener('keyup', function () {
        let query = this.value;

        fetch("{{ route('class.index') }}?search=" + query, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(res => res.json())
        .then(data => {
            let tbody = document.getElementById('classTableBody');
            let html = "";

            if (data.classes.length > 0) {
                data.classes.forEach((cls, index) => {
                    html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${cls.grade.grade_name} ${cls.class_name}</td>
                        <td>
                            <button class="btn btn-warning btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>`;
                });
            } else {
                html = `<tr><td colspan="3" class="text-danger">No classes found</td></tr>`;
            }

            tbody.innerHTML = html;
        });
    });
</script>

<script src="https://cdn.misdeliver.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>




@endif



<script>
document.getElementById('exportType').addEventListener('change', function() {
    let searchValue = document.getElementById('classSearch').value;

    if(this.value === 'pdf'){
        window.location.href = "{{ route('class.export.pdf') }}?search=" + searchValue;
    }
    if(this.value === 'csv'){
        window.location.href = "{{ route('class.export.csv') }}?search=" + searchValue;
    }
});
</script>
@endpush



</div>