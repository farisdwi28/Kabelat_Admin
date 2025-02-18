@extends('layouts.vertical', ['title' => 'Kabelat'])

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
                                <th class="text-center">Lihat Struktur</th>
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
                                <td>{{ $K->Ketua2->nm_member ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('memberLokal.detail', ['kd_komunitas' => $K->kd_komunitas]) }}">
                                        <i class="las la-angle-right text-secondary font-16"></i>
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
@endsection