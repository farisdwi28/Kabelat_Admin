@extends('layouts.vertical', ['title' => 'Kabelat'])
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1 class="card-title">Struktur Komunitas - {{ $komunitas->nm_komunitas }}</h1>
                            <hr>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <div class="col-auto mb-3">
                        <a href="#">
                            {{-- <button class="btn bg-primary-subtle text-primary">
                                <i class="fa-regular fa-pen-to-square me-1"></i>Edit Struktur Jabatan
                            </button> --}}
                        </a>
                    </div>
                    <img src="{{ $komunitas->foto_struktur }}" class="img-fluid img-thumbnail mt-2 w-100" alt="Struktur Komunitas">
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->
@endsection