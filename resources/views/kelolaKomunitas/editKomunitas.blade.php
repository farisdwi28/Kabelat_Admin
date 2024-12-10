@extends('layouts.vertical', ['title' => 'Rizz'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Edit Komunitas</h4>
                            <small class="form-text text-muted">Anda dapat mengubah informasi komunitas di bawah ini.</small>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('kelolaKomunitas.update', $Komunitas->kd_komunitas) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nm_komunitas" class="form-label">Nama Komunitas *</label>
                                    <input type="text" class="form-control @error('nm_komunitas') is-invalid @enderror"
                                        name="nm_komunitas" id="nm_komunitas"
                                        value="{{ old('nm_komunitas', $Komunitas->nm_komunitas) }}" required
                                        placeholder="Masukkan nama komunitas">
                                    @error('nm_komunitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="nm_ketua">Nama Ketua Komunitas</label>
                                    <input type="text" class="form-control" name="nm_ketua" id="nm_ketua"
                                        value="{{ $ketua ? $ketua->nm_member : 'Tidak ada ketua' }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Status</label>
                                    <input type="text" class="form-control" id="status" name="status"
                                        value="{{ $Komunitas->status }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="desk_komunitas">Deskripsi Komunitas *</label>
                                    <textarea class="form-control @error('desk_komunitas') is-invalid @enderror" rows="5" name="desk_komunitas"
                                        id="desk_komunitas" required placeholder="Masukkan tentang komunitas disini">{{ old('desk_komunitas', $Komunitas->desk_komunitas) }}</textarea>
                                    @error('desk_komunitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto"
                                id="foto" accept="image/*">
                            <label class="input-group-text" for="foto">Ubah Logo Komunitas</label>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($Komunitas->logo)
                        <label class="form-label">Foto Saat Ini</label>
                            <div class="mb-3">
                                <img src="{{ $Komunitas->logo }}" alt="Logo Komunitas" class="img-fluid"
                                    style="max-height: 200px;">
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Perbarui Data</button>
                        <a href="{{ route('kelolaKomunitas') }}" class="btn btn-danger">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
