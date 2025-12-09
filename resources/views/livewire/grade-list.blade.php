<div>




        <div class="row">
            <!-- Button trigger modal -->
            <div class="col-2">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGrade">
                    Create Grade
                </button>
            </div>
        </div>
        <div class="row">

        <form action="{{ route('grade.index') }}" method="GET">
            <input type="text" id="gradeSearch" name="search"
                   value="{{ request('search') }}"
                   class="form-control mb-3"
                   placeholder="Search Grades">
        </form>
            <table class="table">
                <thead>
                <tr class="table-dark">
                    <th scope="col">Grade Code</th>
                    <th scope="col">Grade Name</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($grades as $grade)
                    <tr>

                        <td>{{$grade->grade_code}}</td>
                        <td>{{$grade->grade_name}}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#gradeUpdateModal{{ $grade->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <div class="modal fade" id="gradeUpdateModal{{ $grade->id }}" tabindex="-1" aria-labelledby="gradeUpdateModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="gradeUpdateModalLabel">Grade Update</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('grade.update', $grade->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{ $grade->id }}">



                                                <div class="form-group mb-3">
                                                    <label>Grade Code</label>
                                                    <input type="text" name="grade_code" class="form-control"
                                                           value="{{ $grade->grade_code }}" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label>Grade Name</label>
                                                    <input type="text" name="grade_name" class="form-control"
                                                           value="{{ $grade->grade_name }}" required>
                                                </div>










                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">update</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-danger btn-sm" onclick="deleteGrade({{ $grade->id }})">
                                <i class="bi bi-trash"></i>
                            </button>

                            <form id="delete-form-{{ $grade->id }}" action="{{ route('grade.delete', $grade->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#gradeViewModal{{ $grade->id }}">
        <i class="bi bi-eye-fill"></i>
    </button>
    <!-- View Modal -->
<div class="modal fade" id="gradeViewModal{{ $grade->id }}" tabindex="-1" aria-labelledby="gradeViewModalLabel{{ $grade->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="gradeViewModalLabel{{ $grade->id }}">Grade Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Grade Code:</strong> {{ $grade->grade_code }}</p>
                <p><strong>Grade Name:</strong> {{ $grade->grade_name }}</p>
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
        @push('script')

        <script>
            document.getElementById('gradeSearch').addEventListener('keyup', function() {
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
                function deleteGrade(id) {
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

        @endpush



</div>
