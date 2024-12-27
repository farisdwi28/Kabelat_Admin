@extends('layouts.vertical', ['title' => 'Rizz'])
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
                            <h4 class="card-title">Kelola Program</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('programDispusip.create') }}">
                                <button class="btn bg-primary-subtle text-primary">
                                    <i class="fas fa-plus me-1"></i>Tambah Program
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
                                    <th>Nama Program</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Inisiator</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $P)
                                    <tr>
                                        <td>{{ $P->nm_program }}</td>
                                        <td>{{ $P->tanggal_dibuat }}</td>
                                        <td> {{ $P->inisiator->pluck('nm_inisiator')->implode(', ') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button
                                                    class="btn {{ $P->status_program === 'aktif' ? 'btn-success' : 'btn-danger' }} btn-sm dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    {{ ucfirst($P->status_program) }}
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $P->kd_program }}" data-status="aktif">
                                                            Aktif
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $P->kd_program }}" data-status="nonaktif">
                                                            Nonaktif
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('programDispusip.edit', ['kd_program' => $P->kd_program]) }}">
                                                <i class="las la-pen text-secondary font-16"></i>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateStatusLinks = document.querySelectorAll('.update-status');

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
                    if (this.classList.contains('disabled')) {
                        e.preventDefault();
                        return;
                    }

                    const programId = this.dataset.id;
                    const newStatus = this.dataset.status;

                    if (confirm(`Apakah Anda yakin ingin mengubah status menjadi ${newStatus}?`)) {
                        fetch(`/programDispusip/programDispusip/${programId}/${newStatus}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    alert('Status berhasil diperbarui.');

                                    // Reset status pada semua dropdown
                                    const allDropdownLinks = this.closest('.dropdown')
                                        .querySelectorAll('.update-status');
                                    allDropdownLinks.forEach(dropdownLink => {
                                        dropdownLink.classList.remove('disabled');
                                        dropdownLink.removeAttribute('aria-disabled');
                                        dropdownLink.style.pointerEvents = '';
                                        dropdownLink.style.opacity = '';
                                    });

                                    // Perbarui tombol status
                                    const button = this.closest('.dropdown').querySelector(
                                        'button');
                                    button.textContent = newStatus.charAt(0).toUpperCase() +
                                        newStatus.slice(1);
                                    button.className = newStatus === 'aktif' ?
                                        'btn btn-success btn-sm dropdown-toggle' :
                                        'btn btn-danger btn-sm dropdown-toggle';

                                    // Disable link untuk status yang baru saja dipilih
                                    const newStatusLink = Array.from(allDropdownLinks).find(
                                        link =>
                                        link.dataset.status === newStatus);
                                    if (newStatusLink) {
                                        newStatusLink.classList.add('disabled');
                                        newStatusLink.setAttribute('aria-disabled', 'true');
                                        newStatusLink.style.pointerEvents = 'none';
                                        newStatusLink.style.opacity = '0.5';
                                    }
                                } else {
                                    alert('Gagal memperbarui status: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat memperbarui status.');
                            });
                    }
                });
            });
        });
    </script>
@endsection
