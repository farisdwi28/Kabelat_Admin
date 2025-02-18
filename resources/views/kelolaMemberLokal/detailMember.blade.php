@extends('layouts.vertical', ['title' => $komunitas->nm_komunitas . ' - Members'])

@section('css')
    @vite(['node_modules/simple-datatables/dist/style.css'])
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Member List - {{ $komunitas->nm_komunitas }}</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('memberLokal.create', ['kd_komunitas' => $komunitas->kd_komunitas]) }}">
                                <button class="btn bg-primary-subtle text-primary">
                                    <i class="fas fa-plus me-1"></i>Tambah Member
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Member</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Alamat</th>
                                    <th>Posisi Jabatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $index => $member)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $member->nm_pen }}</td>
                                        <td>{{ \Carbon\Carbon::parse($member->tgl_bergabung)->format('d M Y') }}</td>
                                        <td>{{ $member->desa }}, {{ $member->kecamatan }}, RT {{ $member->RT }}, RW
                                            {{ $member->RW }}</td>
                                        <td>
                                            @php
                                                $jabatan = $member->kd_jabatan;
                                            @endphp
                                            @switch($jabatan)
                                                @case('KET01')
                                                    Ketua Kecamatan
                                                @break

                                                @case('KET02')
                                                    Ketua Desa
                                                @break

                                                @case('KET03')
                                                    Ketua RW
                                                @break

                                                @case('KETUA')
                                                    Ketua Komunitas
                                                @break

                                                @default
                                                    {{ $member->kd_jabatan }}
                                            @endswitch
                                        </td>
                                        <td class="text-center">
                                            <a
                                                href="{{ route('memberLokal.edit', ['kd_komunitas' => $komunitas->kd_komunitas, 'kd_member' => $member->kd_member]) }}">
                                                <i class="las la-pen text-primary"></i>
                                            </a>
                                            <a href="#" class="text-danger"
                                                onclick="hapusMember('{{ route('memberLokal.delete', ['kd_komunitas' => $komunitas->kd_komunitas, 'kd_member' => $member->kd_member]) }}', '{{ $member->kd_member }}')"><i
                                                    class="las la-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @vite(['resources/js/pages/datatable.init.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: "{{ session('success')['title'] ?? 'Success' }}",
                text: "{{ session('success')['text'] ?? 'Data saved successfully.' }}",
                icon: "success"
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: "{{ session('error')['title'] ?? 'Error' }}",
                text: "{{ session('error')['text'] ?? 'An error occurred.' }}",
                icon: "error"
            });
        @endif

        function hapusMember(route, kdMember) {
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Member akan dihapus dari komunitas ini!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(route, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            }
                            throw new Error('Gagal menghapus');
                        })
                        .then(data => {
                            Swal.fire('Terhapus!', data.message, 'success');
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Gagal', error.message || 'Gagal menghapus member', 'error');
                        });
                }
            });
        }
    </script>
@endsection
