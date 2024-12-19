<!-- resources/views/kategori/index.blade.php -->
@extends('layouts.vertical', ['title' => 'Kelola Kategori Kegiatan'])

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
                            <h4 class="card-title">Kelola Kategori Kegiatan</h4>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn bg-primary-subtle text-primary" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="fas fa-plus me-1"></i>Tambah Kategori
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table datatable" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategoris as $kategori)
                                    <tr>
                                        <td>{{ $kategori->nm_katkeg }}</td>
                                        <td>{{ $kategori->ket_kat }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $kategori->kd_katkeg }}">
                                                <i class="las la-pen text-secondary font-16"></i>
                                            </button>
                                            <button type="button" class="btn btn-soft-danger btn-sm"
                                                onclick="confirmDelete('{{ $kategori->kd_katkeg }}')">
                                                <i class="las la-trash-alt text-secondary font-16"></i>
                                            </button>
                                            <form id="delete-form-{{ $kategori->kd_katkeg }}"
                                                action="{{ route('kategori.destroy', $kategori->kd_katkeg) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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

    <x-modalKategoriKegiatan mode="create" />

    @foreach ($kategoris as $kategori)
        <x-modalKategoriKegiatan mode="edit" :kategori="$kategori" />
    @endforeach
@endsection

@section('script')
    @vite(['resources/js/pages/datatable.init.js'])
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endsection
