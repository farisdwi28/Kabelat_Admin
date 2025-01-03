    @extends('layouts.vertical', ['title' => 'Kabelat'])

    @section('content')
        @foreach ($kegiatan as $k)
            @include('kelolaKegiatan.partials.detail-modal', ['kegiatan' => $k])
        @endforeach
        @include('kelolaKegiatan.partials.photo-modal')
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Kelola Kegiatan Program</h4>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('kelolaKegiatan.create') }}">
                                    <button class="btn bg-primary-subtle text-primary">
                                        <i class="fas fa-plus me-1"></i>Tambah Kegiatan
                                    </button>
                                </a>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal Mulai-Berakhir</th>
                                        <th>Lokasi</th>
                                        <th>Program</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kegiatan as $k)
                                        <tr>
                                            <td>{{ $k->nm_keg }}</td>
                                            <td>{{ $k->tgl_mulai }} - {{ $k->tgl_berakhir }}</td>
                                            <td>{{ $k->lokasi_keg }}</td>
                                            <td>{{ $k->program->nm_program ?? '' }}</td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $k->kd_kegiatan }}">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!--end /tableresponsive-->
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->
    @endsection

    @push('scripts')
        <script>
            function showAddPhotoModal(kdKegiatan) {
                document.getElementById('photoKdKegiatan').value = kdKegiatan;
                var addPhotoModal = new bootstrap.Modal(document.getElementById('addPhotoModal'));
                addPhotoModal.show();
            }

            function confirmDeletePhoto(kdFoto) {
                Swal.fire({
                    title: 'Hapus Foto?',
                    text: "Foto akan dihapus permanen",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/kelolaKegiatan/deletePhoto/${kdFoto}`;
                    }
                });
            }

            function confirmDeleteKegiatan(kdKegiatan) {
                Swal.fire({
                    title: 'Hapus Kegiatan?',
                    text: "Semua data kegiatan termasuk foto akan dihapus permanen",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/kelolaKegiatan/delete/${kdKegiatan}`;
                    }
                });
            }
        </script>
    @endpush
