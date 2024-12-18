@extends('layouts.vertical', ['title' => 'Rizz'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Informasi Program</h4>
                            <small class="form-text text-muted">Seluruh informasi ini akan tersedia untuk pembaca. Ketika
                                menginput data informasi program, jangan mengosongkan setiap field dan ikuti aturan yang ada
                                pada sistem.</small>
                            <hr>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <form action="{{ route('programDispusip.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nm_program" class="form-label">Nama Program *</label>
                                    <input type="text" class="form-control @error('nm_program') is-invalid @enderror"
                                        name="nm_program" id="nm_program" value="{{ old('nm_program') }}" required>
                                    @error('nm_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Contoh : Literasi Maju Bandung</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Status Program *</label>
                                    <input type="text" class="form-control" id="status" name="status"
                                        value="Nonaktif" readonly>
                                    <small class="form-text text-muted">
                                        Status program otomatis berubah menjadi aktif saat program berhasil ditambahkan.
                                    </small>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nm_inisiator[]" class="form-label">Nama Inisiator *</label>
                                    <div id="inisiator-wrapper">
                                        <div class="input-group mb-2">
                                            <input type="text"
                                                class="form-control @error('nm_inisiator.0') is-invalid @enderror"
                                                name="nm_inisiator[]" placeholder="Masukkan nama inisiator" required>
                                            <button type="button" class="btn btn-success" id="add-inisiator">+</button>
                                        </div>
                                    </div>
                                    @error('nm_inisiator.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Tekan tombol "+" untuk menambahkan lebih banyak
                                        inisiator.</small>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    name="foto" id="foto" required>
                                <label class="input-group-text" for="foto">Sampul Program</label>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="tentang_program" class="form-label">Tentang Program *</label>
                                    <textarea class="form-control @error('tentang_program') is-invalid @enderror" name="tentang_program"
                                        id="tentang_program" rows="5" required>{{ old('tentang_program') }}</textarea>
                                    @error('tentang_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="tujuan_program" class="form-label">Tujuan Program *</label>
                                    <textarea class="form-control @error('tujuan_program') is-invalid @enderror" name="tujuan_program" id="tujuan_program"
                                        rows="5" required>{{ old('tujuan_program') }}</textarea>
                                    @error('tujuan_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tanggal_dibuat" class="form-label">Tanggal Dibuat</label>
                                    <input type="text" class="form-control" id="tanggal_dibuat"
                                        value="{{ date('Y-m-d') }}" disabled>
                                </div>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Kirim</button>
                        <a href="{{ route('programDispusip') }}" class="btn btn-danger">Batal</a>
                    </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.getElementById('add-inisiator'); // Tombol +
            const wrapper = document.getElementById('inisiator-wrapper'); // Wrapper input inisiator

            addButton.addEventListener('click', function() {
                // Buat elemen input baru
                const newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group', 'mb-2');

                newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="nm_inisiator[]" placeholder="Masukkan nama inisiator" required>
                <button type="button" class="btn btn-danger remove-inisiator">-</button>
            `;

                // Tambahkan elemen input ke dalam wrapper
                wrapper.appendChild(newInputGroup);

                // Tambahkan event listener untuk tombol hapus (-)
                newInputGroup.querySelector('.remove-inisiator').addEventListener('click', function() {
                    newInputGroup.remove();
                });
            });
        });
    </script>
@endsection
