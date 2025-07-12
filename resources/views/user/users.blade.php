@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('css')
    @vite(['node_modules/simple-datatables/dist/style.css'])
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Kelola Penduduk</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('second', ['user', 'tambahUsers']) }}">
                                <button class="btn bg-primary-subtle text-primary me-2">
                                    <i class="fas fa-plus me-1"></i>Tambah Penduduk
                                </button>
                            </a>
                            <a href="{{ route('penduduk.import') }}">
                                <button class="btn bg-success-subtle text-success me-2">
                                    <i class="fas fa-file-csv me-1"></i>Import CSV
                                </button>
                            </a>
                            <a href="{{ route('penduduk.template') }}">
                                <button class="btn bg-info-subtle text-info">
                                    <i class="fas fa-download me-1"></i>Download Template
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
                                    <th>Nama User</th>
                                    <th>Tempat,Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Penduduk as $P)
                                    @if (!empty($P->nm_pen))
                                        <tr>
                                            <td>
                                                <img src="{{ $P->foto_pen }}" alt=""
                                                    class="rounded-circle thumb-md me-1 d-inline">
                                                {{ $P->nm_pen }}
                                            </td>
                                            <td>{{ $P->tempat_lahir }},{{ $P->tgl_lahir }}</td>
                                            <td>{{ $P->alamat }}</td>
                                            <td>{{ $P->jk }}</td>
                                            <td class="text-end">
                                                <div class="dropdown d-inline-block">
                                                    <a class="dropdown-toggle arrow-none" id="dLabel11"
                                                        data-bs-toggle="dropdown" href="#" role="button"
                                                        aria-haspopup="false" aria-expanded="false">
                                                        <i class="las la-ellipsis-v fs-20 text-muted"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dLabel{{ $P->kd_pen }}">
                                                        <a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $P->kd_pen }}">Lihat Penduduk</a>
                                                        <a class="dropdown-item" href="edit/{{ $P->kd_pen }}">Ubah
                                                            Data</a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="confirmDelete('{{ $P->kd_pen }}')">Hapus Data</a>

                                                        <form id="delete-form-{{ $P->kd_pen }}"
                                                            action="{{ route('penduduk.delete', $P->kd_pen) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <x-modal id="modal{{ $P->kd_pen }}" title="Detail Penduduk" :nama="$P->nm_pen"
                                            :tempat="$P->tempat_lahir" :tanggal="$P->tgl_lahir" :jenisKelamin="$P->jk" :alamat="$P->alamat"
                                            :foto="$P->foto_pen" :ktp="!empty($P->no_ktp) ? $P->no_ktp : null" />
                                    @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(kdPen) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + kdPen).submit();
            }
        });
    }

    @if (session('swal_success'))
            Swal.fire({
                title: "{{ session('swal_success')['title'] }}",
                text: "{{ session('swal_success')['text'] }}",
                icon: "{{ session('swal_success')['icon'] }}"
            });
        @endif

        @if (session('swal_error'))
            Swal.fire({
                title: "{{ session('swal_error')['title'] }}",
                text: "{{ session('swal_error')['text'] }}",
                icon: "{{ session('swal_error')['icon'] }}"
            });
        @endif
</script>
@endsection
