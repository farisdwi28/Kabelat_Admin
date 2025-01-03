@extends('layouts.vertical', ['title' => 'Kabelat'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Edit Struktur Jabatan</h4>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="jk">Nama Jabatan *</label>
                                    <select class="form-select @error('jk') is-invalid @enderror" name="jk"
                                        id="jk" required>
                                        <option value="">Pilih Jabatan</option>
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
                            <button type="submit" class="btn btn-primary">Perbarui Data</button>
                            <a href="{{ route('kelolaKomunitas') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
