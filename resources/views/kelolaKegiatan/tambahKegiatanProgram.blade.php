@extends('layouts.vertical', ['title' => 'Rizz'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Kegiatan</h4>
                    <small class="form-text text-muted">Isi form dengan data yang valid.</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('kelolaKegiatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Nama Kegiatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nm_keg" class="form-label">Nama Kegiatan *</label>
                                    <input type="text" class="form-control @error('nm_keg') is-invalid @enderror"
                                        name="nm_keg" value="{{ old('nm_keg') }}" placeholder="Masukkan nama kegiatan"
                                        required>
                                    @error('nm_keg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Deskripsi -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="desk_keg" class="form-label">Deskripsi Kegiatan *</label>
                                    <textarea class="form-control @error('desk_keg') is-invalid @enderror" name="desk_keg" rows="3"
                                        placeholder="Masukkan deskripsi kegiatan" required>{{ old('desk_keg') }}</textarea>
                                    @error('desk_keg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Tanggal Mulai -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai *</label>
                                    <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                        name="tgl_mulai" value="{{ old('tgl_mulai') }}" required>
                                    @error('tgl_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Tanggal Berakhir -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tgl_berakhir" class="form-label">Tanggal Berakhir *</label>
                                    <input type="date" class="form-control @error('tgl_berakhir') is-invalid @enderror"
                                        name="tgl_berakhir" value="{{ old('tgl_berakhir') }}" required>
                                    @error('tgl_berakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Link Kegiatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link_keg" class="form-label">Link Kegiatan (Opsional)</label>
                                    <input type="url" class="form-control @error('link_keg') is-invalid @enderror"
                                        name="link_keg" value="{{ old('link_keg') }}" placeholder="Masukkan link kegiatan">
                                    @error('link_keg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Lokasi -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi_keg" class="form-label">Lokasi Kegiatan *</label>
                                    <input type="text" class="form-control @error('lokasi_keg') is-invalid @enderror"
                                        name="lokasi_keg" value="{{ old('lokasi_keg') }}"
                                        placeholder="Masukkan lokasi kegiatan" required>
                                    @error('lokasi_keg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Program Kegiatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Program Kegiatan *</label>
                                    <select class="form-select @error('kd_program') is-invalid @enderror" name="kd_program"
                                        required>
                                        <option value="">Pilih program</option>
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->kd_program }}"
                                                {{ old('kd_program') == $program->kd_program ? 'selected' : '' }}>
                                                {{ $program->nm_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kd_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Kategori Kegiatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kategori Kegiatan *</label>
                                    <select class="form-select @error('kd_katkeg') is-invalid @enderror" name="kd_katkeg"
                                        required>
                                        <option value="">Pilih kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->kd_katkeg }}"
                                                {{ old('kd_katkeg') == $category->kd_katkeg ? 'selected' : '' }}>
                                                {{ $category->nm_katkeg }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kd_katkeg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Kecamatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kecamatan *</label>
                                    <select class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan"
                                        id="kecamatan" required>
                                        <option value="">Pilih kecamatan</option>
                                        @foreach ($kecamatanList as $kecamatan)
                                            <option value="{{ $kecamatan }}"
                                                {{ old('kecamatan') == $kecamatan ? 'selected' : '' }}>
                                                {{ $kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kecamatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Kelurahan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kelurahan *</label>
                                    <select class="form-select @error('kelurahan') is-invalid @enderror" name="kelurahan"
                                        id="kelurahan" required>
                                        <option value="">Pilih kelurahan</option>
                                        @foreach ($kelurahanList as $kelurahan)
                                            <option value="{{ $kelurahan }}"
                                                {{ old('Kelurahan') == $kelurahan ? 'selected' : '' }}>
                                                {{ $kelurahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelurahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Upload Foto -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Unggah Foto *</label>
                                    <input type="file"
                                        class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror"
                                        name="photos[]" multiple required accept="image/jpeg,image/png,image/jpg">
                                    <small class="form-text text-muted">
                                        - Unggah minimal 1 dan maksimal 10 foto<br>
                                        - Format yang diizinkan: JPG, JPEG, atau PNG<br>
                                        - Ukuran maksimal per foto: 5MB<br>
                                        - Total ukuran semua foto maksimal: 20MB
                                    </small>
                                    @error('photos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('photos.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (session('error'))
                                        <div class="text-danger mt-1">{{ session('error') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('kelolaKegiatan.index') }}" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Dropdown Kelurahan Dinamis
        const kelurahanData = @json($kelurahanList);
        document.getElementById('kecamatan').addEventListener('change', function() {
            const kelurahanSelect = document.getElementById('kelurahan');
            kelurahanSelect.innerHTML = '<option value="">Pilih kelurahan</option>';

            if (this.value) {
                kelurahanData.forEach(kelurahan => {
                    const option = new Option(kelurahan, kelurahan);
                    kelurahanSelect.add(option);
                });
            }
        });
    </script>
@endsection
