<!-- Modal -->
<div class="modal fade" id="detailModal{{ $kegiatan->kd_kegiatan }}" tabindex="-1" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Kegiatan: {{ $kegiatan->nm_keg }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Informasi Kegiatan</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%">Program</td>
                                <td>: {{ $kegiatan->program->nm_program }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>: {{ $kegiatan->kategori->nm_katkeg }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ date('d/m/Y', strtotime($kegiatan->tgl_mulai)) }} -
                                    {{ date('d/m/Y', strtotime($kegiatan->tgl_berakhir)) }}</td>
                            </tr>
                            <tr>
                                <td>Lokasi</td>
                                <td>: {{ $kegiatan->lokasi_keg }}</td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>: {{ $kegiatan->kecamatan }}</td>
                            </tr>
                            <tr>
                                <td>Kelurahan</td>
                                <td>: {{ $kegiatan->Kelurahan }}</td>
                            </tr>
                            <tr>
                                <td>Link Kegiatan</td>
                                <td>: <a href="{{ $kegiatan->link_keg }}" target="_blank">{{ $kegiatan->link_keg }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: {{ $kegiatan->status }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Description -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Deskripsi Kegiatan</h6>
                        <div class="border rounded p-3">
                            {{ $kegiatan->desk_keg }}
                        </div>
                    </div>
                </div>

                <!-- Photos Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Foto Kegiatan</h6>
                            @if ($kegiatan->fotoKegiatan && $kegiatan->fotoKegiatan->count() < 10)
                            <button type="button" class="btn btn-sm btn-primary" onclick="showAddPhotoModal('{{ $kegiatan->kd_kegiatan }}')">
                                <i class="fas fa-plus me-1"></i>Tambah Foto
                            </button>
                            @else
                                <button type="button" class="btn btn-sm btn-secondary" disabled>
                                    <i class="fas fa-plus me-1"></i>Maksimal Foto Tercapai
                                </button>
                            @endif
                        </div>

                        <div class="row g-3">
                            @foreach ($kegiatan->fotoKegiatan as $foto)
                                <div class="col-md-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $foto->foto_path) }}" class="img-fluid rounded"
                                            alt="Foto Kegiatan">
                                        <button type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                            onclick="confirmDeletePhoto('{{ $foto->kd_fotokeg }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"
                    onclick="confirmDeleteKegiatan('{{ $kegiatan->kd_kegiatan }}')">
                    <i class="fas fa-trash me-1"></i>Hapus Kegiatan
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


