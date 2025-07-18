@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Informasi Berita</h4>
                        <small class="form-text text-muted">Seluruh informasi ini akan tersedia untuk pembaca. Ketika
                            mengubah data informasi, jangan mengosongkan setiap field dan ikuti aturan yang ada pada
                            sistem.</small>
                        <hr>
                    </div><!--end col-->
                </div> <!--end row-->
            </div><!--end card-header-->
            <div class="card-body pt-0">
                <form action="{{ route('informasiBerita.update', $informasi->kd_info) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="judul_berita" class="form-label">Nama Berita *</label>
                                <input type="text" class="form-control @error('judul_berita') is-invalid @enderror"
                                    name="judul_berita" id="judul_berita"
                                    value="{{ old('judul_berita', $informasi->judul_berita) }}" required>
                                @error('judul_berita')
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
                                        <input type="text" class="form-control" name="author[]"
                                            value="{{ old('author.' . $key, $inisiator) }}" required>
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
                                <label for="kategori_berita" class="form-label">Kategori Berita *</label>
                                <select class="form-control @error('kategori_berita') is-invalid @enderror"
                                    name="kategori_berita" id="kategori_berita" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="semua berita"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'semua berita' ? 'selected' : '' }}>
                                        Semua Berita</option>
                                    <option value="kegiatan"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'kegiatan' ? 'selected' : '' }}>
                                        Kegiatan</option>
                                    <option value="layanan"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'layanan' ? 'selected' : '' }}>
                                        Layanan</option>
                                    <option value="koleksi"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'koleksi' ? 'selected' : '' }}>
                                        Koleksi</option>
                                    <option value="fasilitas"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'fasilitas' ? 'selected' : '' }}>
                                        Fasilitas</option>
                                    <option value="prestasi"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'prestasi' ? 'selected' : '' }}>
                                        Prestasi</option>
                                    <option value="kerjasama"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'kerjasama' ? 'selected' : '' }}>
                                        Kerjasama</option>
                                    <option value="events"
                                        {{ old('kategori_berita', $informasi->kategori_berita) == 'events' ? 'selected' : '' }}>
                                        Events</option>
                                </select>
                                @error('kategori_berita')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Pilih salah satu kategori yang sesuai untuk berita
                                    ini.</small>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="video_link" class="form-label">Link Video (Opsional)</label>
                            <input type="text" name="video_link" id="video_link" class="form-control"
                                value="{{ old('video_link', $informasi->video_link) }}"
                                placeholder="Contoh: https://www.youtube.com/watch?v=xxxx">
                            <div class="form-text text-muted">Masukkan link video YouTube, Instagram, Facebook, atau TikTok</div>
                            <div id="video_link_error" class="invalid-feedback"></div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kd_kecamatan">Kecamatan</label>
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
                                <label for="foto" class="form-label">Sampul Berita</label>
                                <input type="file" class="form-control" name="foto" id="foto"
                                    onchange="previewImage()">

                                @if ($informasi->foto_berita)
                                <img src="{{ old('foto_berita', $informasi->foto_berita) }}" id="image-preview"
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
                                <label for="isi_berita" class="form-label">Isi Berita *</label>
                                <textarea class="form-control @error('isi_berita') is-invalid @enderror" name="isi_berita" id="isi_berita"
                                    rows="5" required>{{ old('isi_berita', $informasi->isi_berita) }}</textarea>
                                @error('isi_berita')
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
                    <a href="{{ route('informasiBerita') }}" class="btn btn-danger">Batal</a>
                </form>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!--end col-->
</div><!--end row-->
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setupInisiatorHandler();
        setupVideoLinkValidation();
        setupFormSubmitValidation();
    });

    function setupInisiatorHandler() {
        const addButton = document.getElementById('add-inisiator');
        const wrapper = document.getElementById('inisiator-wrapper');

        if (!wrapper || !addButton) return;

        addButton.addEventListener('click', function () {
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');

            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="author[]" placeholder="Masukkan nama inisiator" required>
                <button type="button" class="btn btn-danger remove-inisiator">-</button>
            `;

            wrapper.appendChild(newInputGroup);
        });

        wrapper.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-inisiator')) {
                if (wrapper.querySelectorAll('.input-group').length > 1) {
                    event.target.closest('.input-group').remove();
                } else {
                    alert('Harus ada minimal satu inisiator');
                }
            }
        });
    }

    function setupVideoLinkValidation() {
        const videoLinkInput = document.getElementById('video_link');
        if (!videoLinkInput) return;

        videoLinkInput.addEventListener('input', function () {
            validateVideoLink(this);
        });
    }

    function isValidVideoLink(url) {
        const patterns = [
            /^(https?:\/\/)?(www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/,
            /^(https?:\/\/)?(www\.)?youtu\.be\/([a-zA-Z0-9_-]+)/,
            /^(https?:\/\/)?(www\.)?instagram\.com\/reel\/([a-zA-Z0-9_-]+)/,
            /^(https?:\/\/)?(www\.)?facebook\.com\/watch\/\?v=([0-9]+)/,
            /^(https?:\/\/)?(www\.)?tiktok\.com\/@.+\/video\/([0-9]+)/
        ];
        return patterns.some(pattern => pattern.test(url));
    }

    function validateVideoLink(inputElement) {
        const value = inputElement.value.trim();
        const errorElement = document.getElementById('video_link_error');

        if (value && !isValidVideoLink(value)) {
            inputElement.classList.add('is-invalid');
            if (errorElement) {
                errorElement.textContent = 'Format URL video tidak valid';
            }
        } else {
            inputElement.classList.remove('is-invalid');
            if (errorElement) {
                errorElement.textContent = '';
            }
        }
    }

    function setupFormSubmitValidation() {
        const form = document.querySelector('form');
        if (!form) return;

        form.addEventListener('submit', function (event) {
            const videoLinkInput = document.getElementById('video_link');
            const videoLinkValue = videoLinkInput.value.trim();

            if (videoLinkValue && !isValidVideoLink(videoLinkValue)) {
                event.preventDefault();
                videoLinkInput.classList.add('is-invalid');
                const errorElement = document.getElementById('video_link_error');
                if (errorElement) {
                    errorElement.textContent = 'Format URL video tidak valid. Contoh: https://www.youtube.com/watch?v=xxxx';
                }
            }
        });
    }

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

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';

            preview.onload = function () {
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
