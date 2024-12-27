<div class="modal fade" id="addPhotoModal2" tabindex="-1" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPhotoModalLabel">Tambah Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kelolaKegiatan2.addPhotos') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="kd_kegiatan2" id="photoKdKegiatan">
                    <div class="mb-3">
                        <label for="photos" class="form-label">Pilih Foto (Maksimal 10)</label>
                        <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*" required>
                        <small class="text-muted">
                            Format: JPG, JPEG, PNG (Max 5MB per file, total 20MB)
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>