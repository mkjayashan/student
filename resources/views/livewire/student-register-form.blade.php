<div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addStudentModalLabel">Student Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label">Register No</label>
                            <input type="text" wire:model="reg_no" class="form-control">
                            @error('reg_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" wire:model="email" class="form-control">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone No</label>
                            <input type="text" wire:model="ph_no" class="form-control">
                            @error('ph_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" wire:model="dob" class="form-control">
                            @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" wire:model="password" class="form-control">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('student-added', event => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('addStudentModal'));
            modal.hide();
        });
    </script>

</div>



