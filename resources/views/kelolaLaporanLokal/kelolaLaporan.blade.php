@extends('layouts.vertical', ['title' => 'Laporan Komunitas'])

@section('css')
    @vite(['node_modules/simple-datatables/dist/style.css'])
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Laporan Komunitas</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table datatable" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Laporan</th>
                                    <th data-type="date" data-format="YYYY/DD/MM">Tanggal Kirim</th>
                                    <th>Lokasi</th>
                                    <th>Komunitas</th>
                                    <th>Status Periksa</th>
                                    <th class="text-center">Aksi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan as $lapor)
                                    <tr>
                                        <td>{{ $lapor->judul }}</td>
                                        <td>{{ date('Y/m/d', strtotime($lapor->tgl_dibuat)) }}</td>
                                        <td>{{ $lapor->desa }}, {{ $lapor->kecamatan }}, RT {{ $lapor->RT }}, RW
                                            {{ $lapor->RW }}</td>
                                        <td>{{ $lapor->komunitas->nm_komunitas }}</td>
                                        <td>
                                            @if ($lapor->status_periksa === 'diterima')
                                                <span class="badge bg-success">{{ $lapor->status_periksa }}</span>
                                            @elseif($lapor->status_periksa === 'ditolak')
                                                <span class="badge bg-danger">{{ $lapor->status_periksa }}<br>
                                                    <small class="">Alasan:
                                                        {{ $lapor->alasan_penolakan }}</small>
                                                </span>
                                            @else
                                                <span class="badge bg-warning">Belum Diperiksa</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="#" onclick="hapusLaporan('{{ $lapor->kd_laporan }}')"
                                                class="text-danger hapus-laporan">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="text-secondary me-2"
                                                onclick="showDetail('{{ route('LaporanLokalDetail', $lapor->kd_laporan) }}')">
                                                <i class="las la-angle-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->
@endsection

@section('script')
    @vite(['resources/js/pages/datatable.init.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showDetail(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = response;
                    const statusElement = tempDiv.querySelector('[data-status-periksa]');
                    const statusPeriksa = statusElement ? statusElement.dataset.statusPeriksa : null;

                    const swalOptions = {
                        title: 'Detail Laporan',
                        html: response,
                        showCancelButton: true,
                        showConfirmButton: true,
                        confirmButtonText: 'Terima Laporan',
                        cancelButtonText: 'Tolak Laporan',
                        customClass: {
                            popup: 'rounded'
                        }
                    };
                    if (statusPeriksa && statusPeriksa !== 'belum diperiksa') {
                        swalOptions.confirmButtonText = 'Laporan Sudah Diproses';
                        swalOptions.cancelButtonText = 'Tutup';
                        swalOptions.confirmButtonProps = {
                            disabled: true,
                            style: {
                                cursor: 'not-allowed',
                                opacity: '0.6'
                            }
                        };
                        swalOptions.cancelButtonProps = {
                            style: {
                                cursor: 'pointer'
                            }
                        };
                        swalOptions.showConfirmButton = false;
                    }

                    Swal.fire(swalOptions).then((result) => {
                        if (statusPeriksa === 'belum diperiksa') {
                            if (result.isConfirmed) {
                                terimaLaporan(url);
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                tolakLaporan(url);
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal memuat detail laporan',
                        icon: 'error',
                        customClass: {
                            popup: 'rounded'
                        }
                    });
                }
            });
        }

        function terimaLaporan(url) {
            Swal.fire({
                title: 'Konfirmasi Penerimaan',
                text: 'Anda yakin ingin menerima laporan ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Terima!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url + '?action=terima',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Sukses',
                                    text: 'Laporan telah diterima',
                                    icon: 'success',
                                    customClass: {
                                        popup: 'rounded'
                                    }
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                }
            });
        }

        function tolakLaporan(url) {
            Swal.fire({
                title: 'Konfirmasi Penolakan',
                html: `
                    <textarea class="form-control" id="alasan" placeholder="Masukkan alasan penolakan"></textarea>
                `,
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const alasan = document.getElementById('alasan').value;
                    if (alasan) {
                        $.ajax({
                            url: url + '?action=tolak',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                alasan: alasan
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Sukses',
                                        text: 'Laporan telah ditolak',
                                        icon: 'success',
                                        customClass: {
                                            popup: 'rounded'
                                        }
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire('Gagal', 'Silakan masukkan alasan penolakan', 'error');
                    }
                }
            });
        }

        function hapusLaporan(kd_laporan) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Anda yakin ingin menghapus laporan ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('LaporanLokalHapus', '') }}/' + kd_laporan,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Sukses',
                                    text: response.message,
                                    icon: 'success',
                                    customClass: {
                                        popup: 'rounded'
                                    }
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Gagal', response.message, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = xhr.responseJSON.message || 'Gagal menghapus laporan';
                            Swal.fire('Gagal', errorMessage, 'error');
                        }

                    });
                }
            });
        }
    </script>
@endsection
