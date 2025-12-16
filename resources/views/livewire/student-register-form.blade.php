<div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addStudentModalLabel">Student Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent="submit">
<div class="row">
                    @csrf
                          <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">Register No</label>
                            <input type="text" wire:model="reg_no" class="form-control">
                            @error('reg_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" wire:model="email" class="form-control">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label">Phone No</label>
                            <input type="text" wire:model="ph_no" class="form-control">
                            @error('ph_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" wire:model="dob" class="form-control">
                            @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                                       

                     <div class="mb-3">
    <label>Select Grade</label>
    <select wire:model="selectedGrades" class="form-control" multiple required>
        @foreach($grades as $grade)
            <option value="{{ $grade->id }}">
                {{ $grade->grade_name }}
            </option>
        @endforeach
    </select>

    @error('selectedGrades')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>








                            <div class="mb-3">
    <label>Select Courses</label>
    <select wire:model="selected_courses" class="form-control" multiple required>
        @foreach($courses as $course)
            <option value="{{ $course->id }}">
                {{ $course->course_name }}
            </option>
        @endforeach
    </select>

    @error('selected_courses')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>


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

    @error('nic_front') 
        <span class="text-danger">{{ $message }}</span> 
    @enderror

    {{-- Preview --}}
    @if ($nic_front)
        <img src="{{ $nic_front->temporaryUrl() }}" class="img-thumbnail mt-2" width="120">
    @endif
</div>

<div class="col-md-6 mb-3">
    <label>NIC Back</label>
    <input type="file" wire:model="nic_back" class="form-control">

    @error('nic_back') 
        <span class="text-danger">{{ $message }}</span> 
    @enderror

    {{-- Preview --}}
    @if ($nic_back)
        <img src="{{ $nic_back->temporaryUrl() }}" class="img-thumbnail mt-2" width="120">
    @endif
</div>





                            <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" wire:model="password" class="form-control">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

</div>
                            <div class="col-12 mb-3">

                        <button type="submit" class="btn btn-success w-100">Register</button>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

</div>
@push('scripts')
<script>
        window.addEventListener('student-added', event => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('addStudentModal'));
            modal.hide();
        });
    </script>


    

   <script>
function initGradeSelect() {
    $('.js-grade-select').select2({
        placeholder: "Select grades",
        allowClear: true,
        width: '100%'
    }).on('change', function (e) {
        @this.set('selectedGrades', $(this).val());
    });
}

// Initialize on page load
$(document).ready(function () {
    initGradeSelect();
});

// Re-initialize after Livewire updates
Livewire.hook('message.processed', (message, component) => {
    initGradeSelect();
});
</script>





@endpush


