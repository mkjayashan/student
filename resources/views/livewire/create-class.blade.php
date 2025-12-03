
<div>
    <div wire:ignore.self class="modal fade" id="createClassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClassModalLabel">Create Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submit">
                    <div class="mb-3">
                        <label>Class Name</label>
                        <input type="text" wire:model="class_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Select Grade</label>
                        <select wire:model="grade_id" class="form-control">
                            <option value="">Select Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100" >
                        Create Class
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

    @push('script')
        <script>
            window.addEventListener('classCreated', event => {
                var modalEl = document.getElementById('createClassModal');
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);

                modal.hide(); // Close modal
                document.querySelectorAll('.modal-backdrop').forEach(function(backdrop){
                    backdrop.remove(); // Remove dark overlay
                });
                document.body.classList.remove('modal-open'); // Restore scrolling
            });
        </script>

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('classCreated', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Class Created',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            });
        </script>




    @endpush
</div>
