@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Tambah User</h4>
                            <small class="form-text text-muted">Ketika menginput data user, jangan mengosongkan setiap field
                                dan ikuti aturan yang ada pada sistem.</small>
                            <hr>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <form action="{{ route('penduduk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nm_pen" class="form-label">Nama User *</label>
                                    <input type="text" class="form-control @error('nm_pen') is-invalid @enderror"
                                        name="nm_pen" id="nm_pen" required value="{{ old('nm_pen') }}"
                                        placeholder="Masukkan nama user disini">
                                    @error('nm_pen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Contoh : Ahmad Fahri</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="no_ktp">Nomor KTP *</label>
                                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                                        name="no_ktp" id="no_ktp" required value="{{ old('no_ktp') }}"
                                        placeholder="Masukkan nomor KTP 16 digit">
                                    @error('no_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="jk">Jenis Kelamin *</label>
                                    <select class="form-select @error('jk') is-invalid @enderror" name="jk"
                                        id="jk" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jk') == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ old('jk') == 'perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                    @error('jk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="tgl_lahir">Tanggal Lahir *</label>
                                    <input class="form-control @error('tgl_lahir') is-invalid @enderror" type="date"
                                        name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
                                    @error('tgl_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="tempat_lahir">Tempat Lahir *</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        name="tempat_lahir" id="tempat_lahir" required value="{{ old('tempat_lahir') }}"
                                        placeholder="Masukkan tempat lahir user disini">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="no_hp">Nomor HP *</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                        name="no_hp" id="no_hp" required value="{{ old('no_hp') }}"
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
                                        name="RT" id="RT" required value="{{ old('RT') }}"
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
                                        name="RW" id="RW" required value="{{ old('RW') }}"
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
                                        name="desa" id="desa" required value="{{ old('desa') }}"
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
                                        name="kecamatan" id="kecamatan" required value="{{ old('kecamatan') }}"
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
                                    <label class="form-label" for="alamat">Alamat Lengkap *</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" rows="5" name="alamat" id="alamat"
                                        required placeholder="Masukkan alamat lengkap disini atau link lokasi pada google maps">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Contoh : Rumah Baca Cerdas, Jl. Raya Cimareme
                                        No.123, Cimareme, Kec. Ngamprah, Kabupaten Bandung, Jawa Barat</small>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                name="foto" id="foto" required>
                            <label class="input-group-text" for="foto">Foto User</label>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                        <a href="{{ route('penduduk') }}" class="btn btn-danger">Batal</a>
                    </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->
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
