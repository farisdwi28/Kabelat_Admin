@extends('layouts.vertical', ['title' => 'Kabelat'])

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
                    <form action="{{ route('programDispusip.update', $program->kd_program) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nm_program" class="form-label">Nama Program *</label>
                                    <input type="text" class="form-control @error('nm_program') is-invalid @enderror"
                                        name="nm_program" id="nm_program"
                                        value="{{ old('nm_program', $program->nm_program) }}" required>

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
                                        value={{ old('status_program', $program->status_program) }} readonly>
                                    <small class="form-text text-muted">
                                        Status program otomatis berubah menjadi aktif saat program berhasil ditambahkan.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nm_inisiator[]" class="form-label">Nama Inisiator *</label>
                                    <div id="inisiator-wrapper">
                                        @if ($inisiators->count() > 0)
                                            @foreach ($inisiators as $key => $inisiator)
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="nm_inisiator[]"
                                                        value="{{ old('nm_inisiator.' . $key, $inisiator->nm_inisiator) }}"
                                                        required>
                                                    @if ($loop->first)
                                                        <button type="button" class="btn btn-success"
                                                            id="add-inisiator">+</button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-danger remove-inisiator">-</button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="nm_inisiator[]" required>
                                                <button type="button" class="btn btn-success" id="add-inisiator">+</button>
                                            </div>
                                        @endif
                                    </div>

                                    @error('nm_inisiator.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Tekan tombol "+" untuk menambahkan lebih banyak
                                        inisiator.</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Sampul Program</label>
                                    <input type="file" class="form-control" name="foto" id="foto"
                                        onchange="previewImage()">
                                    @if ($program->sampul_program)
                                        <img src="{{ old('sampul_program', $program->sampul_program) }}" id="image-preview"
                                            class="img-thumbnail mt-2" alt="Sampul Program">
                                    @else
                                        <img id="image-preview" class="img-thumbnail mt-2" style="display: none;"
                                            alt="Pratinjau Foto">
                                    @endif
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran foto harus 1920x400px</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="tentang_program" class="form-label">Tentang Program *</label>
                                    <textarea class="form-control @error('tentang_program') is-invalid @enderror" name="tentang_program"
                                        id="tentang_program" rows="5" required>{{ old('tentang_program', $program->tentang_program) }}</textarea>
                                    @error('tentang_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="tujuan_program" class="form-label">Tujuan Program *</label>
                                    <textarea class="form-control @error('tujuan_program') is-invalid @enderror" name="tujuan_program" id="tujuan_program"
                                        rows="5" required>{{ old('tujuan_program', $program->tujuan_program) }}</textarea>
                                    @error('tujuan_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tanggal_dibuat" class="form-label" hidden>Tanggal Dibuat</label>
                                    <input type="text" class="form-control" id="tanggal_dibuat"
                                        value="{{ date('Y-m-d') }}" disabled hidden>
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
            const addButton = document.getElementById('add-inisiator');
            const wrapper = document.getElementById('inisiator-wrapper');

            // Pastikan elemen-elemen ada sebelum menambahkan event listener
            if (!wrapper || !addButton) return;

            wrapper.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-inisiator')) {
                    if (wrapper.querySelectorAll('.input-group').length > 1) {
                        event.target.closest('.input-group').remove();
                    } else {
                        alert('Harus ada minimal satu inisiator');
                    }
                }
            });

            addButton.addEventListener('click', function() {
                const newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group', 'mb-2');

                newInputGroup.innerHTML = `
            <input type="text" class="form-control" name="nm_inisiator[]" required>
            <button type="button" class="btn btn-danger remove-inisiator">-</button>
        `;

                wrapper.appendChild(newInputGroup);
            });
        });

        function previewImage() {
            const preview = document.getElementById('image-preview');
            const fileInput = document.getElementById('foto');
            const file = fileInput.files[0];
            const reader = new FileReader();

            // Reset jika tidak ada file
            if (!file) {
                preview.style.display = 'none';
                return;
            }

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';

                preview.onload = function() {
                    // Validasi dimensi gambar
                    const validWidth = 1920;
                    const validHeight = 400;

                    if (preview.naturalWidth !== validWidth || preview.naturalHeight !== validHeight) {
                        alert(`Ukuran foto harus ${validWidth}x${validHeight} piksel`);
                        preview.style.display = 'none';
                        fileInput.value = '';
                    }
                };
            };

            reader.readAsDataURL(file);
        }
    </script>
@endsection
