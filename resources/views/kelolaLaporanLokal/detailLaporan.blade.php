<div class="row justify-content-center" data-status-periksa="{{ $laporan->status_periksa }}">
        <div class="col-md-10 col-lg-10">
            <div class="card">
                <strong>{{ $laporan->judul }}</strong>
                <p class="text-gray-600">{{ $laporan->desk_lap }}</p>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Tanggal Dibuat</strong>
                                <p class="text-gray-600">{{ date('Y/m/d', strtotime($laporan->tgl_dibuat)) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Status Periksa</strong>
                                <p class="text-gray-600">
                                    @if ($laporan->status_periksa === 'diterima')
                                        <span class="badge bg-success">{{ $laporan->status_periksa }}</span>
                                    @elseif($laporan->status_periksa === 'ditolak')
                                        <span class="badge bg-danger">
                                            {{ $laporan->status_periksa }}<br>
                                            <small class="text-muted">Alasan: {{ $laporan->alasan_penolakan }}</small>
                                        </span>
                                    @else
                                        <span class="badge bg-warning">Belum Diperiksa</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <strong>File Lampiran</strong>
                                @if ($laporan->file)
                                    <a href="{{ asset('storage/' . $laporan->file) }}" target="_blank" class="text-primary" download>
                                        <i class="las la-file-download"></i> Unduh File
                                    </a>
                                @else
                                    <p class="text-gray-600">Tidak ada lampiran</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>