@extends('layouts.vertical', ['title' => 'Kabelat'])

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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nomor KTP *</label>
                                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                                        name="no_ktp" value="{{ old('no_ktp', $Penduduk->no_ktp) }}" required
                                        placeholder="Masukkan nomor KTP 16 digit">
                                    @error('no_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="no_hp">Nomor HP *</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                        name="no_hp" id="no_hp" required value="{{ old('no_hp', $Penduduk->no_hp) }}"
                                        placeholder="Masukkan nomor HP">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label" for="RT">RT *</label>
                                    <input type="number" class="form-control @error('RT') is-invalid @enderror"
                                        name="RT" id="RT" required value="{{ old('RT', $Penduduk->RT) }}"
                                        placeholder="RT">
                                    @error('RT')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label" for="RW">RW *</label>
                                    <input type="number" class="form-control @error('RW') is-invalid @enderror"
                                        name="RW" id="RW" required value="{{ old('RW', $Penduduk->RW) }}"
                                        placeholder="RW">
                                    @error('RW')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="desa">Desa *</label>
                                    <input type="text" class="form-control @error('desa') is-invalid @enderror"
                                        name="desa" id="desa" required value="{{ old('desa', $Penduduk->desa) }}"
                                        placeholder="Nama Desa">
                                    @error('desa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="kecamatan">Kecamatan *</label>
                                    <input type="text" class="form-control @error('kecamatan') is-invalid @enderror"
                                        name="kecamatan" id="kecamatan" required value="{{ old('kecamatan', $Penduduk->kecamatan) }}"
                                        placeholder="Nama kecamatan">
                                    @error('kecamatan')
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

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('swal_success'))
            Swal.fire({
                title: "{{ session('swal_success')['title'] }}",
                text: "{{ session('swal_success')['text'] }}",
                icon: "{{ session('swal_success')['icon'] }}"
            });
        @endif

        @if (session('swal_error'))
            Swal.fire({
                title: "{{ session('swal_error')['title'] }}",
                text: "{{ session('swal_error')['text'] }}",
                icon: "{{ session('swal_error')['icon'] }}"
            });
        @endif
    </script>
@endsection
