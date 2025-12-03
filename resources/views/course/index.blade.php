@extends('layouts.app')
@push('title')
    course List
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        Courses
    @endpush

    <div class="container">
        <div class="row">
            <div class="col-8">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    Add New Course
                </button>
            </div>
            <div class="col-4">
                <form action="" id="exportForm" method="GET">
                    <select id="exportType" class="form-select" style="width:200px; padding:10px; border:2px solid #4CAF50;
               border-radius:6px; background:#e8ffe8; color:#333;">
                        <option value="">Export</option>
                        <option value="pdf">Export as PDF</option>
                        <option value="excel">Export as Excel</option>
                    </select>
                </form>

                <form action="{{ route('courses.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="import_file" accept=".csv,.pdf" required>
                    <button type="submit">Import</button>
                </form>

            </div>
        </div>
    </div>





    {{--
        <a href="{{ route('course.export.excel') }}" class="btn btn-success">Export Excel</a>
    --}}

<br>
    @livewire('course-form')
<br>
    <div class="container">

             <div class="search">
                 <input type="text" id="courseSearch" name="search" value="{{ request('search') }}" class="form-control mb-3" placeholder="Search Courses">

              </div>






        <!-- Courses Table -->
        <table id="courseTable" class="table table-bordered mt-3">
            <thead>
            <tr>

                <th>Course Code</th>
                <th>Course Name</th>



                <th>Subjects</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($courses as $course)
                <tr>

                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->course_name }}</td>


                    <td>
                        @foreach($course->subjects as $subject)
                            <span style="margin: 5px">{{ $subject->subject_name }}</span>
                        @endforeach
                    </td>

                    <td>
                        {{--<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateCourseModal">
                            update
                        </button>--}}
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#updateCourseModal{{ $course->id }}">
                            Edit
                        </button>
                        <div class="modal fade" id="updateCourseModal{{ $course->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Update Course</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('course.update', $course->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label>Course Code</label>
                                                <input type="text" name="course_code" class="form-control"
                                                       value="{{ $course->course_code }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Course Name</label>
                                                <input type="text" name="course_name" class="form-control"
                                                       value="{{ $course->course_name }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="search_subject_{{ $course->id }}" class="form-label">Search Subjects</label>
                                                <input type="text" id="search_subject_{{ $course->id }}" class="form-control" placeholder="Search subjects...">
                                            </div>

                                            <div id="subjectList_{{ $course->id }}"></div>

                                            <div class="mt-3" id="selectedSubjects_{{ $course->id }}">
                                                @foreach($course->subjects as $sub)
                                                    <span class="badge bg-primary m-1 p-2" data-id="{{ $sub->id }}">
                                {{ $sub->subject_name }}
                                <span class="remove-subject" style="cursor:pointer;"> &times;</span>
                                <input type="hidden" name="subject_ids[]" value="{{ $sub->id }}">
                            </span>
                                                @endforeach
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-success">Update</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>





                        <a href="{{ route('course.delete', $course->id) }}"
                           class="btn btn-danger btn-sm"
                           onclick="confirmDelete(event, '{{ route('course.delete', $course->id) }}')">
                            Delete
                        </a>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="2">No courses added yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>


@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('close-modal', event => {
            var modalEl = document.getElementById('addCourseModal');
            var modal = bootstrap.Modal.getInstance(modalEl)
            modal.hide();
        });

        function confirmDelete(event, url) {
            event.preventDefault(); // Prevent default link

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this course!",
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
        document.addEventListener('DOMContentLoaded', function() {
            const subjects_{{ $course->id }} = @json($subjects);
            const searchInput = document.getElementById('search_subject_{{ $course->id }}');
            const subjectList = document.getElementById('subjectList_{{ $course->id }}');
            const selectedContainer = document.getElementById('selectedSubjects_{{ $course->id }}');

            // Remove subject
            selectedContainer.addEventListener('click', function(e){
                if(e.target.classList.contains('remove-subject')){
                    e.target.parentElement.remove();
                }
            });

            searchInput.addEventListener('keyup', function(){
                const query = this.value.toLowerCase();
                subjectList.innerHTML = '';

                subjects_{{ $course->id }}.forEach(subject => {
                    // skip if already selected
                    if([...selectedContainer.querySelectorAll('input[name="subject_ids[]"]')].some(i => i.value == subject.id)) return;

                    if(subject.subject_name.toLowerCase().includes(query)){
                        const div = document.createElement('div');
                        div.className = 'p-2 border rounded mb-1 bg-light';
                        div.textContent = subject.subject_name;
                        div.style.cursor = 'pointer';

                        div.addEventListener('click', () => {
                            const tag = document.createElement('span');
                            tag.className = 'badge bg-primary m-1 p-2';
                            tag.textContent = subject.subject_name;

                            const remove = document.createElement('span');
                            remove.innerHTML = '&times;';
                            remove.style.cursor = 'pointer';
                            remove.classList.add('remove-subject');
                            tag.appendChild(remove);

                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'subject_ids[]';
                            hiddenInput.value = subject.id;
                            tag.appendChild(hiddenInput);

                            selectedContainer.appendChild(tag);
                            div.remove();
                        });

                        subjectList.appendChild(div);
                    }
                });
            });
        });
    </script>


    <script>
        document.getElementById('courseSearch').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#courseTable tbody tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>


    <script>
        document.getElementById('exportType').addEventListener('change', function() {

            let searchValue = document.getElementById('courseSearch').value;

            if (this.value === 'pdf') {
                window.location.href = "{{ route('course.export.pdf') }}?search=" + searchValue;
            }

            if (this.value === 'excel') {
                window.location.href = "{{ route('course.export.csv') }}?search=" + searchValue;
            }

        });
    </script>










@endpush

