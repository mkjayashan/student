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


            <table class="table">
                <thead>
                <tr>
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
                                update
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
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-danger btn-sm" onclick="deleteGrade({{ $grade->id }})">
                                Delete
                            </button>

                            <form id="delete-form-{{ $grade->id }}" action="{{ route('grade.delete', $grade->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>



        </div>
        @push('script')
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
