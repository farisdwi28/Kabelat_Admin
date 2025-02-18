@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Edit Member</h4>
                            <small class="form-text text-muted">Ketika mengedit data member, pastikan data yang dimasukkan
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

                    <form
                        action="{{ route('memberLokal.update', ['kd_komunitas' => $member->kd_komunitas, 'kd_member' => $member->kd_member]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nama Penduduk *</label>
                                    <input type="text" class="form-control @error('nm_pen') is-invalid @enderror"
                                        name="nm_pen" value="{{ old('nm_pen', $penduduk->nm_pen) }}" readonly disabled
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
                                        name="no_ktp" value="{{ old('no_ktp', $penduduk->no_ktp) }}" required
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
                                            {{ old('jk', $penduduk->jk) == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ old('jk', $penduduk->jk) == 'perempuan' ? 'selected' : '' }}>Perempuan
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
                                        name="tgl_lahir" value="{{ old('tgl_lahir', $penduduk->tgl_lahir) }}" required>
                                    @error('tgl_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir *</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}"
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
                                        name="no_hp" id="no_hp" required value="{{ old('no_hp', $penduduk->no_hp) }}"
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
                                        name="RT" id="RT" required value="{{ old('RT', $penduduk->RT) }}"
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
                                        name="RW" id="RW" required value="{{ old('RW', $penduduk->RW) }}"
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
                                        name="desa" id="desa" required value="{{ old('desa', $penduduk->desa) }}"
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
                                        name="kecamatan" id="kecamatan" required
                                        value="{{ old('kecamatan', $penduduk->kecamatan) }}"
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
                                        placeholder="Masukkan alamat lengkap">{{ old('alamat', $penduduk->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Posisi Jabatan</label>
                                <select class="form-select @error('kd_jabatan') is-invalid @enderror" name="kd_jabatan" required>
                                    @foreach ($jabatan as $jabatan)
                                        <option value="{{ $jabatan->kd_jabatan }}" {{ old('kd_jabatan', $member->kd_jabatan) == $jabatan->kd_jabatan ? 'selected' : '' }}>
                                            {{ $jabatan->nm_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kd_jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('memberLokal.detail', ['kd_komunitas' => $member->kd_komunitas]) }}"
                                    class="btn btn-danger">Batal</a>
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
        @if (session('success'))
            Swal.fire({
                title: "{{ session('success')['title'] ?? 'Success' }}",
                text: "{{ session('success')['text'] ?? 'Data saved successfully.' }}",
                icon: "success"
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: "{{ session('error')['title'] ?? 'Error' }}",
                text: "{{ session('error')['text'] ?? 'An error occurred.' }}",
                icon: "error"
            });
        @endif
    </script>
@endsection
