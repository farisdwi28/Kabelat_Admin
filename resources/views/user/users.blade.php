@extends('layouts.vertical', ['title' => 'Rizz'])

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
                                <button class="btn bg-primary-subtle text-primary">
                                    <i class="fas fa-plus me-1"></i>Tambah Penduduk
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
                                                    <a class="dropdown-item" href="edit/{{ $P->kd_pen }}">Ubah Data</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="confirmDelete('{{ $P->kd_pen }}')">Hapus Data</a>

                                                    <form id="delete-form-{{ $P->kd_pen }}"
                                                        action="{{ route('penduduk.delete', $P->kd_pen) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <x-modal id="modal{{ $P->kd_pen }}" title="Detail Penduduk" :nama="$P->nm_pen"
                                        :tempat="$P->tempat_lahir" :tanggal="$P->tgl_lahir" :jenisKelamin="$P->jk" :alamat="$P->alamat"
                                        :foto="$P->foto_pen" :ktp="$P->no_ktp" />
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
        function confirmDelete(kdPen) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                document.getElementById('delete-form-' + kdPen).submit();
            }
        }
    </script>
@endsection
