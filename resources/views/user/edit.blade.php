@extends('layouts.vertical', ['title' => 'Rizz'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Edit Penduduk</h4>
                            <small class="form-text text-muted">Ketika mengedit data penduduk, pastikan data yang dimasukkan
                                sudah benar.</small>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('penduduk.update', $Penduduk->kd_pen) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nama Penduduk *</label>
                                    <input type="text" class="form-control @error('nm_pen') is-invalid @enderror"
                                        name="nm_pen" value="{{ old('nm_pen', $Penduduk->nm_pen) }}" required
                                        placeholder="Masukkan nama penduduk">
                                    @error('nm_pen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nomor NIK *</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        name="nik" value="{{ old('nik', $Penduduk->nik) }}" required
                                        placeholder="Masukkan nomor NIK">
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin *</label>
                                    <select class="form-select @error('jk') is-invalid @enderror" name="jk" required>
                                        <option value="Laki-laki"
                                            {{ old('jk', $Penduduk->jk) == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ old('jk', $Penduduk->jk) == 'perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                </select>
                                    @error('jk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir *</label>
                                    <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                        name="tgl_lahir" value="{{ old('tgl_lahir', $Penduduk->tgl_lahir) }}" required>
                                    @error('tgl_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir *</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        name="tempat_lahir" value="{{ old('tempat_lahir', $Penduduk->tempat_lahir) }}"
                                        required placeholder="Masukkan tempat lahir">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap *</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="5" required
                                        placeholder="Masukkan alamat lengkap">{{ old('alamat', $Penduduk->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Foto Saat Ini</label>
                                    @if ($Penduduk->foto_pen)
                                        <div class="mt-2">
                                            <img src="{{ $Penduduk->foto_pen }}" alt="Foto Penduduk" class="img-thumbnail"
                                                style="max-width: 200px">
                                        </div>
                                    @else
                                        <p class="text-muted">Tidak ada foto</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Upload Foto Baru</label>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG (Max. 2MB)</small>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('second', ['user', 'users']) }}" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
