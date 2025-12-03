<div>
<div class="container mt-4">
<div class="row">
    <div class="d-flex justify-content-between mb-3">

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClassModal">
            Create Class
        </button>
    </div>
</div>
    <div class="row">
    <table class="table table-bordered table-striped">
        <thead class="table">
        <tr>


            <th>#</th>
            <th>Class Name</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($classes as $index => $class)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $class->grade->grade_name }}{{ $class->class_name }}</td>

                <td>

                    <!-- Update Button -->
                    <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#updateClassModal{{ $class->id }}">
                        Edit
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
                        Delete
                    </button>

                    <form id="delete-form-{{ $class->id }}" action="{{ route('class.delete', $class->id) }}" method="POST" style="display: none;">
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
    @endpush

</div>
