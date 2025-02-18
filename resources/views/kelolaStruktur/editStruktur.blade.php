@extends('layouts.vertical', ['title' => 'Kabelat'])
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Edit Struktur Jabatan Komunitas - {{ $komunitas->nm_komunitas }}</h4>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('updateStruktur', $komunitas->kd_komunitas) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Jabatan *</label>
                                    <div>
                                        @foreach ($jabatan as $j)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="jabatan[]"
                                                    id="jabatan_{{ $j->kd_jabatan }}" value="{{ $j->kd_jabatan }}"
                                                    {{ $komunitas->jabatan->contains($j->kd_jabatan) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jabatan_{{ $j->kd_jabatan }}">
                                                    {{ $j->nm_jabatan }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('detailStruktur', $komunitas->kd_komunitas) }}" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h4>Jabatan yang Sudah Dipilih:</h4>
            <ul>
                @foreach ($komunitas->jabatan as $j)
                    <li>
                        {{ $j->nm_jabatan }}
                        <form
                            action="{{ route('removeJabatan', ['id' => $komunitas->kd_komunitas, 'jabatan_id' => $j->kd_jabatan]) }}"
                            method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-0" title="Hapus Jabatan">
                                <i class="fas fa-minus-circle"></i> <!-- Icon "-" -->
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
