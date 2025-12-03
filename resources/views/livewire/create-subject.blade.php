<div>

    <div wire:ignore.self class="modal fade" id="addSubject" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addSubjectModalLabel">Create Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <label class="form-label">Subject Code</label>
            <input type="text" wire:model="subject_code" class="form-control">
            @error('subject_code') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" wire:model="subject_name" class="form-control">
            @error('subject_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>



        <button type="submit" class="btn btn-success w-100">Create

        </button>

    </form>

            </div>

        </div>
    </div>
</div>
    @push('script')
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('closeModal', () => {
                    const modalEl = document.getElementById('addSubject');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                });
            });
        </script>


    @endpush
</div>
