<div>

<div class="container-fluid">

<div class="row mt-5">
    <!-- Add Subject Button -->
    <div class="col-6 d-flex justify-content-start mb-3 mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubject">
            Add Subject
        </button>
    </div>

    <!-- Import and Export (Right aligned) -->
    <div class="col-6 d-flex justify-content-end mb-3 mt-3 gap-2">
        <!-- Import Form -->
        <form action="{{ route('subjects.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
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

        <form action="{{ route('subject.index') }}" method="GET">
            <input type="text" id="subjectSearch" name="search"
                   value="{{ request('search') }}"
                   class="form-control mb-3"
                   placeholder="Search Subjects">
        </form>

        <table class="table">
        <thead>
        <tr class="table-dark">
            <th scope="col">Subject Code</th>
            <th scope="col">Subject Name</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subjects as $subject)
        <tr>

            <td>{{$subject->subject_code}}</td>
            <td>{{$subject->subject_name}}</td>
            <td>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#subjectUpdateModal{{ $subject->id }}">
                     <i class="bi bi-pencil-square"></i>
                </button>

                <div class="modal fade" id="subjectUpdateModal{{ $subject->id }}" tabindex="-1" aria-labelledby="subjectUpdateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="subjectUpdateModalLabel">Subject Update</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('subject.update', $subject->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="id" value="{{ $subject->id }}">



                                    <div class="form-group mb-3">
                                        <label>Subject Code</label>
                                        <input type="text" name="subject_code" class="form-control"
                                               value="{{ $subject->subject_code }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Subject Name</label>
                                        <input type="text" name="subject_name" class="form-control"
                                               value="{{ $subject->subject_name }}" required>
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

                <button class="btn btn-danger btn-sm" onclick="deleteSubject({{ $subject->id }})">
                    <i class="bi bi-trash"></i>
                </button>

                <form id="delete-form-{{ $subject->id }}" action="{{ route('subject.delete', $subject->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
<!-- View Button -->
<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#subjectViewModal{{ $subject->id }}">
    <i class="bi bi-eye-fill"></i>
</button>
<!-- View Modal -->
<div class="modal fade" id="subjectViewModal{{ $subject->id }}" tabindex="-1" aria-labelledby="subjectViewModalLabel{{ $subject->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="subjectViewModalLabel{{ $subject->id }}">Subject Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Subject Code:</strong> {{ $subject->subject_code }}</p>
                <p><strong>Subject Name:</strong> {{ $subject->subject_name }}</p>
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
            function deleteSubject(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This subject will be permanently deleted!",
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
            document.getElementById('subjectSearch').addEventListener('keyup', function() {
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

                let type = this.value;
                let query = document.getElementById('subjectSearch').value;

                if(type === 'pdf'){
                    window.location = `/subject/export/pdf?search=${query}`;
                }
                if(type === 'csv'){
                    window.location = `/subject/export/csv?search=${query}`;
                }

            });
        </script>


    @endpush


</div>
