@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Informasi Pengumuman</h4>
                            <small class="form-text text-muted">Seluruh informasi ini akan tersedia untuk pembaca. Ketika
                                mengubah data informasi, jangan mengosongkan setiap field dan ikuti aturan yang ada pada
                                sistem.</small>
                            <hr>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <form action="{{ route('informasiPengumuman.update', $informasi->kd_info) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="judul_pengumuman" class="form-label">Nama Pengumuman *</label>
                                    <input type="text" class="form-control @error('judul_pengumuman') is-invalid @enderror"
                                        name="judul_pengumuman" id="judul_pengumuman"
                                        value="{{ old('judul_pengumuman', $informasi->judul_pengumuman) }}" required>
                                    @error('judul_pengumuman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Contoh : Literasi Maju Bandung</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="status_info">Status *</label>
                                    <input type="text" class="form-control" id="status_info" name="status_info"
                                        value="{{ old('status_info', $informasi->status_info) }}" readonly>
                                    <small class="form-text text-muted">
                                        Status berita otomatis berubah menjadi draft saat berita berhasil ditambahkan.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nm_inisiator[]" class="form-label">Author *</label>
                                    <div id="inisiator-wrapper">
                                        @if (isset($informasi->author) && count(json_decode($informasi->author)) > 0)
                                            @foreach (json_decode($informasi->author) as $key => $inisiator)
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="author[]" value="{{ old('author.' . $key, $inisiator) }}" required>
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
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kd_kecamatan" class="form-label">Kecamatan</label>
                                    <select name="kd_kecamatan" id="kd_kecamatan"
                                        class="form-control @error('kd_kecamatan') is-invalid @enderror" required>
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach ($kecamatanList as $kd_kecamatan => $nm_kecamatan)
                                            <option value="{{ $kd_kecamatan }}"
                                                {{ $informasi->kd_kecamatan == $kd_kecamatan ? 'selected' : '' }}>
                                                {{ $nm_kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kd_kecamatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Sampul Pengumuman</label>
                                    <input type="file" class="form-control" name="foto" id="foto"
                                        onchange="previewImage()">

                                    @if ($informasi->foto_pengumuman)
                                        <img src="{{ old('foto_pengumuman', $informasi->foto_pengumuman) }}" id="image-preview"
                                            class="img-thumbnail mt-2" alt="Sampul Program">
                                    @else
                                        <img id="image-preview" class="img-thumbnail mt-2" style="display: none;"
                                            alt="Pratinjau Foto">
                                    @endif

                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran foto harus 1920x800px</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="isi_pengumuman" class="form-label">Isi Pengumuman *</label>
                                    <textarea class="form-control @error('isi_pengumuman') is-invalid @enderror" name="isi_pengumuman" id="isi_pengumuman"
                                        rows="5" required>{{ old('isi_pengumuman', $informasi->isi_pengumuman) }}</textarea>
                                    @error('isi_pengumuman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Kirim</button>
                        <a href="{{ route('informasiPengumuman') }}" class="btn btn-danger">Batal</a>
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
             <input type="text" class="form-control" name="author[]" placeholder="Masukkan nama inisiator" required>
                <button type="button" class="btn btn-danger remove-inisiator" id="add-inisiator">-</button>
        `;

                wrapper.appendChild(newInputGroup);
            });
        });

        function previewImage() {
            const preview = document.getElementById('image-preview');
            const fileInput = document.getElementById('foto');
            const file = fileInput.files[0];
            const reader = new FileReader();

            if (!file) {
                preview.style.display = 'none';
                fileInput.value = '';
                return;
            }

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';

                preview.onload = function() {
                    const validWidth = 1920;
                    const validHeight = 800;

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
