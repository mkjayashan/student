<div>




    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveCourse">

                        <div class="mb-3">
                            <label>Course Code</label>
                            <input type="text" wire:model="course_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Course Name</label>
                            <input type="text" class="form-control" wire:model="course_name">
                            @error('course_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>



                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="search" class="form-label">Search Subject</label>
                                <input type="text" id="search" class="form-control" placeholder="Search subjects...">
                            </div>

                            <div id="subjectList"></div>

                            <div class="mt-3" id="selectedSubjects"></div>
                        </div>


                        <button type="submit" class="btn btn-success">Save Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- UPDATE MODAL -->





</div>
@push('script')
    <script>
        window.addEventListener('close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('addCourseModal'));
            modal.hide();
        });

        const subjects = @json($subjects); // all subjects
        const searchInput = document.getElementById('search');
        const subjectList = document.getElementById('subjectList');
        const selectedContainer = document.getElementById('selectedSubjects');

        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            subjectList.innerHTML = ''; // clear previous

            if(query === "") return; // show nothing initially

            subjects.forEach(subject => {
                if(subject.subject_name.toLowerCase().includes(query)) {
                    if(@this.selectedSubjects.includes(subject.id)) return; // skip if already selected

                    const div = document.createElement('div');
                    div.className = 'subject-item p-2 border mb-1 rounded';
                    div.textContent = subject.subject_name;
                    div.setAttribute('data-id', subject.id);

                    div.addEventListener('click', function() {
                        const id = subject.id;
                        const name = subject.subject_name;

                        // Add to Livewire property
                    @this.selectedSubjects.push(id);

                        // Display tag
                        const tag = document.createElement('span');
                        tag.className = 'badge bg-primary m-1 p-2';
                        tag.textContent = name;
                        selectedContainer.appendChild(tag);

                        // Remove from search list
                        div.remove();
                    });

                    subjectList.appendChild(div);
                }
            });
        });
    </script>


    <script>
        window.addEventListener('show-update-modal', () => {
            new bootstrap.Modal(document.getElementById('updateCourseModal')).show();
        });

        const subjectsUpdate = @json($subjects);
        const searchUpdate = document.getElementById('search_update');
        const subjectListUpdate = document.getElementById('subjectListUpdate');
        const selectedContainerUpdate = document.getElementById('selectedSubjectsUpdate');

        searchUpdate.addEventListener('keyup', function () {
            const query = this.value.toLowerCase();
            subjectListUpdate.innerHTML = '';

            subjectsUpdate.forEach(subject => {

                // SKIP already selected
                if (@this.selectedSubjects.includes(subject.id)) return;

                if (subject.subject_name.toLowerCase().includes(query)) {

                    const div = document.createElement('div');
                    div.className = 'p-2 border rounded mb-1 bg-light';
                    div.textContent = subject.subject_name;

                    // When clicked → add subject
                    div.addEventListener('click', () => {

                        // Add to Livewire array
                    @this.selectedSubjects.push(subject.id);

                        // Add a badge UI
                        const tag = document.createElement('span');
                        tag.className = 'badge bg-primary m-1 p-2';
                        tag.textContent = subject.subject_name;
                        selectedContainerUpdate.appendChild(tag);

                        div.remove();
                    });

                    subjectListUpdate.appendChild(div);
                }
            });
        });
    </script>
    <script>
        window.addEventListener('show-update-modal', () => {
            let modal = new bootstrap.Modal(document.getElementById('updateCourseModal'));
            modal.show();
        });
    </script>





@endpush


