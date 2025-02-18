@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Tambah Member {{ $komunitas->nm_komunitas }}</h4>
                            <small class="form-text text-muted">
                                Masukkan nomor KTP untuk memeriksa data member. Jika ditemukan, form akan ditampilkan untuk melengkapi data.
                            </small>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('memberLokal.store', ['kd_komunitas' => $komunitas->kd_komunitas]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Input KTP -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="no_ktp">Nomor KTP *</label>
                                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" name="no_ktp" id="no_ktp" required value="{{ old('no_ktp') }}" placeholder="Masukkan nomor KTP 16 digit" onkeyup="checkKtp()">
                                    @error('no_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <div id="additional-fields" style="display: none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="nm_pen" class="form-label">Nama *</label>
                                        <input type="text" class="form-control @error('nm_pen') is-invalid @enderror" name="nm_pen" id="nm_pen" required placeholder="Masukkan nama user disini">
                                        @error('nm_pen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Contoh: Ahmad Fahri</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="RT">RT *</label>
                                        <input type="number" class="form-control @error('RT') is-invalid @enderror" name="RT" id="RT" required placeholder="RT">
                                        @error('RT')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="RW">RW *</label>
                                        <input type="number" class="form-control @error('RW') is-invalid @enderror" name="RW" id="RW" required placeholder="RW">
                                        @error('RW')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="desa">Desa *</label>
                                        <input type="text" class="form-control @error('desa') is-invalid @enderror" name="desa" id="desa" required placeholder="Nama Desa">
                                        @error('desa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="kecamatan">Kecamatan *</label>
                                        <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan" required placeholder="Nama Kecamatan">
                                        @error('kecamatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary" disabled id="submit-btn">Tambah Data</button>
                        <a href="{{ route('memberLokal.detail', ['kd_komunitas' => $komunitas->kd_komunitas]) }}" class="btn btn-danger">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function checkKtp() {
            var noKtp = document.getElementById('no_ktp').value;

            if (noKtp.length === 16) {
                $.ajax({
                    url: '{{ route('memberLokal.checkKtp') }}',
                    method: 'GET',
                    data: { no_ktp: noKtp },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Data Ditemukan!',
                                text: 'Nama: ' + response.data.nm_pen,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });

                            // Tampilkan field tambahan dan isi data
                            $('#additional-fields').show();
                            $('#nm_pen').val(response.data.nm_pen);
                            $('#desa').val(response.data.desa);
                            $('#kecamatan').val(response.data.kecamatan);
                            $('#RT').val(response.data.RT);
                            $('#RW').val(response.data.RW);
                            $('#submit-btn').prop('disabled', false);
                        } else {
                            Swal.fire({
                                title: 'Data Tidak Ditemukan',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });

                            // Sembunyikan field tambahan
                            $('#additional-fields').hide();
                            $('#nm_pen, #desa, #kecamatan, #RT, #RW').val('');
                            $('#submit-btn').prop('disabled', true);
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memeriksa KTP.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                $('#additional-fields').hide();
                $('#submit-btn').prop('disabled', true);
            }
        }
    </script>
@endsection
