@extends('layouts.app')
@push('title')
    course List
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        Course Management
    @endpush

    <div class="container mt-2">
        <div class="row mt-5">
    <!-- Add Course Button -->
    <div class="col-6">
        <div class="mb-3 d-flex">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                + Add New Course
            </button>
        </div>
    </div>

    <!-- Import and Export -->
    <div class="col-6">
        <div class="mb-3 d-flex justify-content-end align-items-center gap-2">
            <!-- Import CSV Form -->
            <form action="{{ route('courses.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
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
    </div>





    


    @livewire('course-form')

    <div class="row mt-0">

             <div class="search">
                 <input type="text" id="courseSearch" name="search" value="{{ request('search') }}" class="form-control mb-3" placeholder="Search Courses">

              </div>






        <!-- Courses Table -->
        <table id="courseTable" class="table table-bordered mt-0">
            <thead>
            <tr class="table-dark">

                <th>Course Code</th>
                <th>Course Name</th>



                <th>Subjects</th>
                <th>Status</th>
                <th>Course Price</th>

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
                @if($course->status == 'paid')
                    <span class="badge bg-success">Paid</span>
                @else
                    <span class="badge bg-primary">Free</span>
                @endif
            </td>

            <!-- Show Price If Paid -->
            <td>
                @if($course->status == 'paid')
                    Rs. {{ number_format($course->price, 2) }}
                @else
                    -
                @endif
            </td>




                    <td>
                        {{--<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateCourseModal">
                                                <i class="bi bi-pencil-square"></i>

                        </button>--}}
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#updateCourseModal{{ $course->id }}">
                            <i class="bi bi-pencil-square"></i>

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

                                            <!-- Status -->
                                           <!-- Status -->
<!-- Status -->
<div class="mb-3">
    <label>Status</label>
    <select id="status_{{ $course->id }}" class="form-control statusSelect">
        <option value="">Select Status</option>
        <option value="free" {{ $course->status === 'free' ? 'selected' : '' }}>Free</option>
        <option value="paid" {{ $course->status === 'paid' ? 'selected' : '' }}>Paid</option>
    </select>
</div>

<!-- Price -->
<div class="mb-3" id="priceField_{{ $course->id }}" style="{{ $course->status === 'paid' ? 'display:block;' : 'display:none;' }}">
    <label>Course Price</label>
    <input type="number" min="0" name="price" value="{{ $course->price }}" class="form-control">
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
                                                    <i class="bi bi-trash"></i>

                        </a>
                        <!-- View Button -->
<button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewCourseModal{{ $course->id }}">
    <i class="bi bi-eye-fill"></i>
</button>


<!-- View Course Modal -->
<div class="modal fade" id="viewCourseModal{{ $course->id }}" tabindex="-1" aria-labelledby="viewCourseModalLabel{{ $course->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewCourseModalLabel{{ $course->id }}">Course Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Course Code:</strong> {{ $course->course_code }}</p>
                <p><strong>Course Name:</strong> {{ $course->course_name }}</p>
                <p><strong>Subjects:</strong> 
                    @foreach($course->subjects as $subject)
                        <span class="badge bg-primary m-1">{{ $subject->subject_name }}</span>
                    @endforeach
                </p>
                <p><strong>Status:</strong> 
                    @if($course->status === 'paid')
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-primary">Free</span>
                    @endif
                </p>
                @if($course->status === 'paid')
                    <p><strong>Price:</strong> Rs. {{ number_format($course->price, 2) }}</p>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


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


@foreach($courses as $course)

    <script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== Subject Search & Selection =====
    function updateSubjectSearch(courseId, subjects) {
        const searchInput = document.getElementById('search_subject_' + courseId);
        const subjectList = document.getElementById('subjectList_' + courseId);
        const selectedContainer = document.getElementById('selectedSubjects_' + courseId);

        // Remove subject when clicking ×
        selectedContainer.addEventListener('click', function(e){
            if(e.target.classList.contains('remove-subject')){
                e.target.parentElement.remove();
            }
        });

        searchInput.addEventListener('keyup', function(){
            const query = this.value.toLowerCase();
            subjectList.innerHTML = '';

            subjects.forEach(subject => {
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
    }

    // ===== Status & Price Toggle (Pure JS) =====
    function updateStatusPriceToggle(courseId) {
        const statusSelect = document.getElementById('status_' + courseId);
        const priceField = document.getElementById('priceField_' + courseId);
        const priceInput = priceField.querySelector('input');

        if(!statusSelect) return;

        statusSelect.addEventListener('change', function() {
            if (this.value === 'paid') {
                priceField.style.display = 'block';
            } else {
                priceField.style.display = 'none';
                priceInput.value = ''; // reset price when free
            }
        });
    }

    // ===== Initialize Modals =====
    // For all courses dynamically, trigger when modal is opened
    document.querySelectorAll('[id^="updateCourseModal"]').forEach(modalEl => {
        modalEl.addEventListener('shown.bs.modal', function () {
            const courseId = this.id.replace('updateCourseModal', '');
            const subjects = @json($subjects); // pass subjects array from Blade
            updateSubjectSearch(courseId, subjects);
            updateStatusPriceToggle(courseId);
        });
    });

});
</script>




@endforeach

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

            if (this.value === 'csv') {
                window.location.href = "{{ route('course.export.csv') }}?search=" + searchValue;
            }

        });
    </script>










@endpush

