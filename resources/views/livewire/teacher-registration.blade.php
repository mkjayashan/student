<div> <!-- Single root div -->

    


    <!-- Add Teacher Modal -->
    <div wire:ignore.self class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Teacher Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="col-md-6 mb-3">
    <label>Teacher ID</label>
    <input type="text" wire:model.debounce.300ms="reg_no" class="form-control">
    @error('reg_no') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-6 mb-3">
    <label>Teacher Name</label>
    <input type="text" wire:model.debounce.300ms="teacher_name" class="form-control">
    @error('teacher_name') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-6 mb-3">
    <label>Email</label>
    <input type="email" wire:model.debounce.300ms="email" class="form-control">
    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-6 mb-3">
    <label>NIC</label>
    <input type="text" wire:model.debounce.300ms="nic" class="form-control">
    @error('nic') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-6 mb-3">
    <label>Address</label>
    <input type="text" wire:model.debounce.300ms="address" class="form-control">
    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-6 mb-3">
    <label>Phone No</label>
    <input type="text" wire:model.debounce.300ms="phone_no" class="form-control">
    @error('phone_no') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label>Password</label>
    <input type="password" wire:model.debounce.300ms="password" class="form-control">
    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-6 mb-3">
    <label>Confirm Password</label>
    <input type="password" wire:model.defer="password_confirmation" class="form-control">
    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
</div>


                            <div class="col-md-6 mb-3">
    <label>Subjects</label>
    <select wire:model="selected_subjects" multiple class="form-control">
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
        @endforeach
    </select>
    @error('selected_subjects') <span class="text-danger">{{ $message }}</span> @enderror
</div>


                            <div class="col-md-6 mb-3">
                                <label>Grades</label>
                                <select wire:model="selected_grades" multiple class="form-control">
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                                    @endforeach
                                </select>
                                @error('selected_grades') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="row">

                            <div class="col-md-6 mb-3">
        <label>Profile Picture</label>
        <input type="file" wire:model="profile_picture" class="form-control">
        @error('profile_picture') <span class="text-danger">{{ $message }}</span> @enderror

        <!-- Preview -->
        @if ($profile_picture)
            <div class="mt-2">
                <img src="{{ $profile_picture->temporaryUrl() }}" alt="Profile Preview" width="150" class="img-thumbnail">
            </div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label>NIC Front</label>
        <input type="file" wire:model="nic_front" class="form-control">
        @error('nic_front') <span class="text-danger">{{ $message }}</span> @enderror

        <!-- Preview -->
        @if ($nic_front)
            <div class="mt-2">
                <img src="{{ $nic_front->temporaryUrl() }}" alt="NIC Front Preview" width="150" class="img-thumbnail">
            </div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label>NIC Back</label>
        <input type="file" wire:model="nic_back" class="form-control">
        @error('nic_back') <span class="text-danger">{{ $message }}</span> @enderror

        <!-- Preview -->
        @if ($nic_back)
            <div class="mt-2">
                <img src="{{ $nic_back->temporaryUrl() }}" alt="NIC Back Preview" width="150" class="img-thumbnail">
            </div>
        @endif
    </div>

</div>


                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">Register Teacher</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert Delete Script -->
    <script>
    document.addEventListener('teacher-added', function () {
        var modalEl = document.getElementById('addTeacherModal');
        var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();

        // Optional: reload page to see updated list
        location.reload();
    });
</script>
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
    @endpush



</div> <!-- end root div -->
