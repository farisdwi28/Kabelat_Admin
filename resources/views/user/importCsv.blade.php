@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Import Data Penduduk dari CSV</h4>
                            <small class="form-text text-muted">Upload file CSV untuk menambahkan data penduduk secara massal.</small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('penduduk.template') }}" class="btn bg-info-subtle text-info">
                                <i class="fas fa-download me-1"></i>Download Template CSV
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="{{ route('penduduk.import.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="csv_file" class="form-label">File CSV *</label>
                                    <input type="file" class="form-control @error('csv_file') is-invalid @enderror" 
                                           name="csv_file" id="csv_file" accept=".csv,.txt" required>
                                    @error('csv_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Pilih file CSV dengan format yang sesuai. Maksimal ukuran file 2MB.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-1"></i>Import Data
                                    </button>
                                    <a href="{{ route('penduduk') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Panduan Format CSV</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted small">File CSV harus memiliki kolom berikut:</p>
                                    <ul class="list-unstyled small">
                                        <li><strong>nm_pen</strong> - Nama Penduduk</li>
                                        <li><strong>jk</strong> - Jenis Kelamin (Laki-laki/Perempuan)</li>
                                        <li><strong>no_ktp</strong> - Nomor KTP (16 digit)</li>
                                        <li><strong>tgl_lahir</strong> - Tanggal Lahir (YYYY-MM-DD)</li>
                                        <li><strong>tempat_lahir</strong> - Tempat Lahir</li>
                                        <li><strong>alamat</strong> - Alamat Lengkap</li>
                                        <li><strong>no_hp</strong> - Nomor HP</li>
                                        <li><strong>RT</strong> - Nomor RT</li>
                                        <li><strong>RW</strong> - Nomor RW</li>
                                        <li><strong>desa</strong> - Nama Desa</li>
                                        <li><strong>kecamatan</strong> - Nama Kecamatan</li>
                                    </ul>
                                    
                                    <div class="alert alert-warning small">
                                        <strong>Catatan:</strong>
                                        <ul class="mb-0 mt-1">
                                            <li>Baris pertama harus berisi header kolom</li>
                                            <li>Nomor KTP harus unik (tidak boleh duplikat)</li>
                                            <li>Format tanggal: YYYY-MM-DD</li>
                                            <li>RT dan RW harus berupa angka</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

        // File validation
        document.getElementById('csv_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (file && file.size > maxSize) {
                Swal.fire({
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB',
                    icon: 'error'
                });
                e.target.value = '';
            }
        });
    </script>
@endsection 