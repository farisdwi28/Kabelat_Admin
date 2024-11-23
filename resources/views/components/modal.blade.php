<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title m-0 text-white" id="{{ $id }}Label">{{ $title }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 text-center align-self-center">
                        <img src="{{ $foto }}" alt="Foto Penduduk" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ $nama }}</h5>
                    <p class="mb-3">Alamat: {{ $alamat }}</p>
                        <p class="mb-3">Tempat, Tanggal Lahir: {{ $tempat }}, {{ $tanggal }}</p>
                        <p class="mb-3">Jenis Kelamin: {{ $jenisKelamin }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
