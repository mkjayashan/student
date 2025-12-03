<div>

<div class="container-fluid">

    <div class="row">
        <!-- Button trigger modal -->
        <div class="col-10">

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubject">
            Add Subject
        </button>


    </div>
        <div class="col-2">
            <form action="" id="exportForm" method="GET">
                <select id="exportType" class="form-select" style="width:200px; padding:10px; border:2px solid #4CAF50;
               border-radius:6px; background:#e8ffe8; color:#333;">
                    <option value="">Export</option>
                    <option value="pdf">Export as PDF</option>
                    <option value="csv">Export as CSV</option>


                </select>
            </form>
        </div>

        <form action="{{ route('subjects.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="file" name="import_file" accept=".csv,.pdf" required>

            <button type="submit">Import</button>
        </form>

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
        <tr>
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
                    update
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
                    Delete
                </button>

                <form id="delete-form-{{ $subject->id }}" action="{{ route('subject.delete', $subject->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

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
