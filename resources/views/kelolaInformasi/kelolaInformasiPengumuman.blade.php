@extends('layouts.vertical', ['title' => 'Kelola Berita'])

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
                            <h4 class="card-title">Kelola Pengumuman</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('informasiPengumuman.create') }}">
                                <button class="btn bg-primary-subtle text-primary">
                                    <i class="fas fa-plus me-1"></i>Tambah Pengumuman
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table datatable" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul Pengumuman</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Penulis</th>
                                    <th>Kecamatan</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informasiPengumuman as $info)
                                    <tr>
                                        <td>{{ $info->judul_pengumuman }}</td>
                                        <td>{{ $info->tanggal_dibuat }}</td>
                                        <td>{{ implode(', ', json_decode($info->author)) }}</td>
                                        <td>{{ $info->kecamatan->nm_kecamatan ?? 'Tidak ada kecamatan' }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-sm dropdown-toggle
                                                    @if ($info->status_info === 'draft') btn-warning
                                                    @elseif($info->status_info === 'terbit') btn-success
                                                    @else btn-danger @endif"
                                                    data-bs-toggle="dropdown">
                                                    {{ ucfirst($info->status_info) }}
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $info->kd_info }}" data-status="draft">
                                                            Draft
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $info->kd_info }}" data-status="terbit">
                                                            Terbit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $info->kd_info }}" data-status="sembunyi">
                                                            Sembunyi
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('informasiPengumuman.edit', ['kd_info' => $info->kd_info]) }}"
                                                class="text-secondary">
                                                <i class="las la-pen font-16"></i>
                                            </a>
                                            <a href="#" class="text-danger delete-berita"
                                                data-id="{{ $info->kd_info }}">
                                                <i class="las la-trash font-16"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/datatable.init.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateStatusLinks = document.querySelectorAll('.update-status');
            const deleteLinks = document.querySelectorAll('.delete-berita');

            updateStatusLinks.forEach(link => {
                const currentStatusButton = link.closest('.dropdown').querySelector('button');
                const currentStatus = currentStatusButton.textContent.toLowerCase().trim();
                const linkStatus = link.dataset.status;

                if (currentStatus === linkStatus) {
                    link.classList.add('disabled');
                    link.setAttribute('aria-disabled', 'true');
                    link.style.pointerEvents = 'none';
                    link.style.opacity = '0.5';
                }

                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (this.classList.contains('disabled')) {
                        return;
                    }

                    const beritaId = this.dataset.id;
                    const newStatus = this.dataset.status;

                    // Using SweetAlert2 for status change confirmation
                    Swal.fire({
                        title: 'Konfirmasi Perubahan Status',
                        text: `Apakah Anda yakin ingin mengubah status menjadi ${newStatus}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ubah!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/kelolaInformasi/kelolaInformasiPengumuman/${beritaId}/${newStatus}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Berhasil!',
                                            'Status berhasil diperbarui.',
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        throw new Error(data.message ||
                                            'Terjadi kesalahan');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat memperbarui status.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });

            deleteLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const beritaId = this.dataset.id;

                    // Added SweetAlert2 for better confirmation dialog
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus pengumuman ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/kelolaInformasi/kelolaInformasiPengumuman/${beritaId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Pengumuman telah dihapus.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat menghapus pengumuman.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection
