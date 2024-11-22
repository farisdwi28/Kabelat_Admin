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
                        <h4 class="card-title">Customers Details</h4>
                    </div><!--end col-->
                </div> <!--end row-->
            </div><!--end card-header-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table datatable" id="datatable_1">
                        <thead class="table-light">
                            <tr>
                                <th>Nama User</th>
                                <th>Tempat,Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Jenis Kelamin</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="/images/logos/lang-logo/chatgpt.png" alt="" class="rounded-circle thumb-md me-1 d-inline">
                                    Micromin
                                </td>
                                <td>9958</td>
                                <td>Curicó</td>
                                <td>2005/02/11</td>
                                <td>37%</td>
                                <td>3</td>
                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v fs-20 text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                            <a class="dropdown-item" href="#">Lihat Penduduk</a>
                                            <a class="dropdown-item" href="#">Ubah Data</a>
                                            <a class="dropdown-item" href="#">Hapus Data</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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