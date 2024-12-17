@extends('layouts.vertical', ['title' => 'Rizz'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Informasi Program</h4>
                            <small class="form-text text-muted">Seluruh informasi ini akan tersedia untuk pembaca. Ketika menginput data informasi program,  jangan mengosongkan setiap field dan ikuti aturan yang ada pada sistem.</small>
                            <hr>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body pt-0">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nm_komunitas" class="form-label">Nama Program *</label>
                                    <input type="text" class="form-control @error('nm_komunitas') is-invalid @enderror"
                                        name="nm_komunitas" id="nm_komunitas" required value="{{ old('nm_komunitas') }}"
                                        placeholder="Masukkan nama komunitas disini">
                                    @error('nm_komunitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Contoh : Literasi Maju Bandung</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Status Program *</label>
                                    <input type="text" class="form-control" id="status" name="status" value="Nonaktif"
                                        disabled>
                                        <small class="form-text text-muted">Status program otomatis berubah menjadi aktif saat program berhasil ditambahkan</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="nm_ketua">Nama Inisiator *</label>
                                    <input type="text" class="form-control @error('nm_ketua') is-invalid @enderror"
                                        name="nm_ketua" id="nm_ketua" required value="{{ old('nm_ketua') }}"
                                        placeholder="Masukkan nama inisiator disini ">
                                    @error('nm_ketua')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Inisiator merupakan individu atau kelompok yang bertanggung jawab atas ide dan pelaksanaan program. Tekan + jika lebih dari satu inisiator  </small>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto"
                                    id="foto" required>
                                <label class="input-group-text" for="foto">Sampul Program</label>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="desk_komunitas">Tentang Program *</label>
                                        <textarea class="form-control @error('desk_komunitas') is-invalid @enderror" rows="5" name="desk_komunitas"
                                            id="desk_komunitas" required placeholder="Masukkan tentang program disini">{{ old('desk_komunitas') }}</textarea>
                                        @error('desk_komunitas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="desk_komunitas">Tujuan Program *</label>
                                        <textarea class="form-control @error('desk_komunitas') is-invalid @enderror" rows="5" name="desk_komunitas"
                                            id="desk_komunitas" required placeholder="Masukkan misi program disini">{{ old('desk_komunitas') }}</textarea>
                                        @error('desk_komunitas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="tanggal_dibuat">Tanggal Dibuat *</label>
                                    <input type="text" class="form-control" id="tanggal_dibuat" name="tanggal_dibuat"
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
                        <a href="{{ route('kelolaKomunitas') }}" class="btn btn-danger">Batal</a>
                    </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->
@endsection
