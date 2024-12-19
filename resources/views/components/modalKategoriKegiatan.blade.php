@props(['mode' => 'create', 'kategori' => null])

@php
    $modalId = $mode === 'create' ? 'createModal' : 'editModal' . $kategori?->kd_katkeg;
    $modalTitle = $mode === 'create' ? 'Tambah Data Kategori Kegiatan' : 'Edit Data Kategori Kegiatan';
    $route = $mode === 'create' ? route('kategori.store') : route('kategori.update', $kategori?->kd_katkeg);
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title m-0 text-white" id="{{ $modalId }}Label">{{ $modalTitle }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $route }}" method="POST">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nm_katkeg" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nm_katkeg" name="nm_katkeg" required
                            value="{{ $kategori?->nm_katkeg }}" placeholder="Masukkan Nama Kategori">
                    </div>
                    <div class="mb-3">
                        <label for="ket_kat" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="ket_kat" name="ket_kat" rows="3" placeholder="Masukkan Keterangan">{{ $kategori?->ket_kat }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ $mode === 'create' ? 'Simpan' : 'Update' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
