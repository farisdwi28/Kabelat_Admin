@extends('layouts.vertical', ['title' => $Komunitas->nm_komunitas . ' - Members'])

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
                            <h4 class="card-title">Member List - {{ $Komunitas->nm_komunitas }}</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table datatable" id="datatable_2">
                            <thead class="">
                                <tr>
                                    <th style="width: 16px;">
                                        <div class="form-check mb-0 ms-n1">
                                            <input type="checkbox" class="form-check-input" name="select-all"
                                                id="select-all">
                                        </div>
                                    </th>
                                    <th>Nama Member</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Kelurahan, Kecamatan, RT, RW</th>
                                    <th>Posisi Jabatan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($Members as $member)
                                    <tr>
                                        <td style="width: 16px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="check">
                                            </div>
                                        </td>
                                        <td>{{ $member->nm_member }}</td>
                                        <td>{{ $member->tgl_bergabung }}</td>
                                        <td>{{ $member->kecamatan }}, RT {{ $member->RT }}, RW {{ $member->RW }}</td>
                                        <td>
                                            @switch($member->kd_jabatan)
                                                @case('KET01')
                                                    Ketua Kecamatan
                                                @break

                                                @case('KET02')
                                                    Ketua Desa
                                                @break

                                                @case('KET03')
                                                    Ketua RW
                                                @break

                                                @case('KETUA')
                                                    Ketua Komunitas
                                                @break

                                                @default
                                                    {{ $member->kd_jabatan }}
                                            @endswitch
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
