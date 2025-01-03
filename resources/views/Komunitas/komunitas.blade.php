@extends('layouts.vertical', ['title' => 'Kabelat'])

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
                    <table class="table mb-0 table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Komunitas</th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span>Status</span>
                                        <select class="form-select form-select-sm ms-2" id="status-filter">
                                            <option value="all">Semua</option>
                                            <option value="active">Aktif</option>
                                            <option value="inactive">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </th>
                                <th>Tanggal Dibuat</th>
                                <th>Nama Ketua Komunitas</th>
                                <th class="text-end">Action</th>
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
                                <td class="text-end d-flex justify-content-center">
                                    <a href="{{ route('komunitas.members', ['kd_komunitas' => $K->kd_komunitas]) }}"><span style="font-size: 24px; color: black;">&gt;</span></a>
                                </td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table><!--end /table-->
                </div><!--end /tableresponsive-->
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!--end col-->
</div><!--end row-->
@endsection