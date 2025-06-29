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
                <form action="{{ route('informasiBerita.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="judul_berita" class="form-label">Nama Berita *</label>
                                <input type="text" class="form-control @error('judul_berita') is-invalid @enderror"
                                    name="judul_berita" id="judul_berita" value="{{ old('judul_berita') }}" required>
                                @error('judul_berita')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Contoh : Literasi Maju Bandung</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="status_info">status *</label>
                                <input type="text" class="form-control" id="status_info" name="status_info"
                                    value="draft" readonly>

                                <small class="form-text text-muted">
                                    Status berita otomatis berubah menjadi draft saat berita berhasil ditambahkan.
                                </small>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nm_inisiator[]" class="form-label">Author *</label>
                                <div id="inisiator-wrapper">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="author[]"
                                            placeholder="Masukkan nama inisiator" required>
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

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori_berita" class="form-label">Kategori Berita *</label>
                                <select class="form-control @error('kategori_berita') is-invalid @enderror"
                                    name="kategori_berita" id="kategori_berita" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="semua berita"
                                        {{ old('kategori_berita') == 'semua berita' ? 'selected' : '' }}>Semua Berita
                                    </option>
                                    <option value="kegiatan"
                                        {{ old('kategori_berita') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                    <option value="layanan" {{ old('kategori_berita') == 'layanan' ? 'selected' : '' }}>
                                        Layanan</option>
                                    <option value="koleksi" {{ old('kategori_berita') == 'koleksi' ? 'selected' : '' }}>
                                        Koleksi</option>
                                    <option value="fasilitas"
                                        {{ old('kategori_berita') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                                    <option value="prestasi"
                                        {{ old('kategori_berita') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                    <option value="kerjasama"
                                        {{ old('kategori_berita') == 'kerjasama' ? 'selected' : '' }}>Kerjasama
                                    </option>
                                    <option value="events" {{ old('kategori_berita') == 'events' ? 'selected' : '' }}>
                                        Events</option>
                                </select>
                                @error('kategori_berita')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Pilih salah satu kategori yang sesuai untuk berita
                                    ini.</small>
                            </div>
                        </div>

                        <!-- Video Link -->
                        <div class="col-12 mb-3">
                            <label for="video_link" class="form-label">Link Video (Opsional)</label>
                            <input type="text" name="video_link" id="video_link" class="form-control"
                                placeholder="Contoh: https://www.youtube.com/watch?v=xxxx">
                            <div class="form-text text-muted">Masukkan link video YouTube, Instagram, Facebook, atau TikTok</div>
                            <div id="video_link_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kd_kecamatan">Kecamatan *</label>
                                <select name="kd_kecamatan" id="kd_kecamatan"
                                    class="form-control @error('kd_kecamatan') is-invalid @enderror" required>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach ($kecamatanList as $kd_kecamatan => $nm_kecamatan)
                                    <option value="{{ $kd_kecamatan }}"
                                        {{ old('kd_kecamatan') == $kd_kecamatan ? 'selected' : '' }}>
                                        {{ $nm_kecamatan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('kd_kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foto">Sampul Berita *</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                name="foto" id="foto" onchange="previewImage()" required>
                            <img id="image-preview" class="img-thumbnail mt-2" style="display: none;"
                                alt="Preview Foto">
                            <small class="form-text text-muted">Ukuran foto harus 1920x800px</small>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="isi_berita" class="form-label">Isi Berita *</label>
                                <textarea class="form-control @error('isi_berita') is-invalid @enderror" name="isi_berita" id="isi_berita"
                                    rows="5" required>{{ old('isi_berita') }}</textarea>
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
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi validasi link video
    function isValidVideoLink(url) {
        const patterns = [
            /^(https?:\/\/)?(www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/, // YouTube
            /^(https?:\/\/)?(www\.)?youtu\.be\/([a-zA-Z0-9_-]+)/, // YouTube short
            /^(https?:\/\/)?(www\.)?instagram\.com\/reel\/([a-zA-Z0-9_-]+)/, // Instagram Reel
            /^(https?:\/\/)?(www\.)?facebook\.com\/watch\/\?v=([0-9]+)/, // Facebook
            /^(https?:\/\/)?(www\.)?tiktok\.com\/@.+\/video\/([0-9]+)/ // TikTok
        ];
        
        return patterns.some(pattern => pattern.test(url));
    }

    // Handler untuk tombol tambah inisiator
    const addButton = document.getElementById('add-inisiator');
    const wrapper = document.getElementById('inisiator-wrapper');

    if (addButton && wrapper) {
        addButton.addEventListener('click', function() {
            // Buat elemen input baru
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');

            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="author[]" placeholder="Masukkan nama inisiator" required>
                <button type="button" class="btn btn-danger remove-inisiator">-</button>
            `;

            // Tambahkan elemen input ke dalam wrapper
            wrapper.appendChild(newInputGroup);

            // Tambahkan event listener untuk tombol hapus (-)
            newInputGroup.querySelector('.remove-inisiator').addEventListener('click', function() {
                newInputGroup.remove();
            });
        });
    }

    // Validasi form saat submit
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            const videoLinkInput = document.getElementById('video_link');
            const videoLinkValue = videoLinkInput.value.trim();
            
            // Jika ada isi di video link, lakukan validasi
            if (videoLinkValue) {
                if (!isValidVideoLink(videoLinkValue)) {
                    event.preventDefault();
                    videoLinkInput.classList.add('is-invalid');
                    const errorElement = document.getElementById('video_link_error');
                    if (errorElement) {
                        errorElement.textContent = 'Format URL video tidak valid. Contoh: https://www.youtube.com/watch?v=xxxx';
                    }
                    return false;
                }
            }
            
            // Reset error jika valid
            videoLinkInput.classList.remove('is-invalid');
            const errorElement = document.getElementById('video_link_error');
            if (errorElement) {
                errorElement.textContent = '';
            }
        });
    }

    // Real-time validation saat user mengetik
    const videoLinkInput = document.getElementById('video_link');
    if (videoLinkInput) {
        videoLinkInput.addEventListener('input', function() {
            const videoLinkValue = this.value.trim();
            const errorElement = document.getElementById('video_link_error');
            
            if (videoLinkValue && !isValidVideoLink(videoLinkValue)) {
                this.classList.add('is-invalid');
                if (errorElement) {
                    errorElement.textContent = 'Format URL video tidak valid';
                }
            } else {
                this.classList.remove('is-invalid');
                if (errorElement) {
                    errorElement.textContent = '';
                }
            }
        });
    }
});

// Fungsi preview image (di luar DOMContentLoaded karena dipanggil inline)
function previewImage() {
    const preview = document.getElementById('image-preview');
    const fileInput = document.getElementById('foto');
    const file = fileInput.files[0];
    const reader = new FileReader();

    // Reset preview jika file kosong
    if (!file) {
        preview.style.display = 'none';
        fileInput.value = ''; // Reset input jika tidak valid
        return;
    }

    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';

        // Tunggu hingga gambar selesai dimuat
        preview.onload = function() {
            // Periksa dimensi gambar
            const validWidth = 1920;
            const validHeight = 800;

            if (preview.naturalWidth !== validWidth || preview.naturalHeight !== validHeight) {
                alert(`Ukuran foto harus ${validWidth}x${validHeight} piksel`);
                preview.style.display = 'none'; // Sembunyikan preview
                fileInput.value = ''; // Reset input
            }
        };
    };

    reader.readAsDataURL(file);
}
</script>
@endsection