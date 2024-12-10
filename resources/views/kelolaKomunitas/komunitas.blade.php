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
                        <h4 class="card-title">Kelola Komunitas</h4>
                    </div><!--end col-->
                    <div class="col-auto">
                        <a href="{{ route('second', ['kelolaKomunitas', 'tambahKomunitas']) }}">
                            <button class="btn bg-primary-subtle text-primary">
                                <i class="fas fa-plus me-1"></i>Tambah Komunitas
                            </button>
                        </a>
                    </div>
                </div> <!--end row-->
            </div><!--end card-header-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table datatable" id="datatable_1">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Komunitas</th>
                                <th>Status</th>
                                <th data-type="date" data-format="YYYY/DD/MM">Tanggal Dibuat</th>
                                <th>Nama Ketua Komunitas</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Komunitas as $K)
                            <tr>
                                <td><img src="{{ $K->logo }}" alt="" class="rounded-circle thumb-md me-1 d-inline">
                                    {{ $K->nm_komunitas }}
                                </td>
                                <td>{{ $K->status }}</td>
                                <td>{{ $K->tanggal_dibuat }}</td>
                                <td>{{ $K->Ketua->nm_member ?? '' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kelolaKomunitas.edit', ['kd_komunitas' => $K->kd_komunitas]) }}"><i class="las la-pen text-secondary font-16"></i></a>
                                    <a href="#" onclick="confirmDelete('{{ $K->kd_komunitas }}')"><i class="las la-trash-alt text-secondary font-16"></i></a>
                                    <form id="delete-form-{{ $K->kd_komunitas }}"
                                        action="{{ route('kelolaKomunitas.delete', $K->kd_komunitas) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
    <script>
        function confirmDelete(kdKomunitas) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                document.getElementById('delete-form-' + kdKomunitas).submit();
            }
        }
    </script>
@endsection