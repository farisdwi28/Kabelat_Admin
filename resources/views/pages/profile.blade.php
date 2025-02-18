@extends('layouts.vertical', ['title' => 'Profile'])
@section('css')
@vite(['node_modules/tobii/dist/css/tobii.min.css'])
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                        <div class="d-flex align-items-center flex-row flex-wrap">
                            <div class="position-relative me-3">
                                <img src="/images/avatar7.jpg" alt="" height="120" class="rounded-circle">
                            </div>
                            <div class="">
                                <h5 class="fw-semibold fs-22 mb-1">{{ Auth::user()->name }}</h5>
                                <p class="mb-0 text-muted fw-medium">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Informasi Akun</h4>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-0">
                                <li class=""><i class="las la-address-card me-2 text-secondary fs-22 align-middle"></i> <b> Name </b> : {{ Auth::user()->name }} 
                                    <a href="#" class="text-primary ms-2" onclick="openNameModal()">Edit</a>
                                </li>
                                <li class="mt-2"><i class="las la-envelope me-2 text-secondary fs-22 align-middle"></i> <b> Email </b> : {{ Auth::user()->email }}
                                    <a href="#" class="text-primary ms-2" onclick="openEmailModal()">Edit</a>
                                </li>
                                <li class="mt-2"><i class="las la-user me-2 text-secondary fs-22 align-middle"></i> <b> Username </b> : {{ Auth::user()->username }}</li>
                                <li class="mt-2"><i class="las la-key me-2 text-secondary fs-22 align-middle"></i> <b> Password </b> : ********
                                    <a href="#" class="text-primary ms-2" onclick="openPasswordModal()">Edit</a>
                                </li>
                            </ul>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end row-->
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!--end col-->
</div><!--end row-->

<!-- Name Edit Modal -->
<div class="modal fade" id="nameModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Nama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="nameForm">
                    <div class="mb-3">
                        <label class="form-label">Nama Baru</label>
                        <input type="text" class="form-control" id="newName" value="{{ Auth::user()->name }}" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateName()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Email Edit Modal -->
<div class="modal fade" id="emailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="emailForm">
                    <div class="mb-3">
                        <label class="form-label">Email Baru</label>
                        <input type="email" class="form-control" id="newEmail" value="{{ Auth::user()->email }}" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateEmail()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Password Change Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="passwordForm">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updatePassword()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@vite([
    'resources/js/pages/profile.init.js',
    'node_modules/sweetalert2/dist/sweetalert2.min.js'
])
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function openNameModal() {
        new bootstrap.Modal(document.getElementById('nameModal')).show();
    }

    function openEmailModal() {
        new bootstrap.Modal(document.getElementById('emailModal')).show();
    }

    function openPasswordModal() {
        new bootstrap.Modal(document.getElementById('passwordModal')).show();
    }

    function updateName() {
        const newName = document.getElementById('newName').value;
        
        axios.post('{{ route("profile.update.name") }}', { name: newName })
            .then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message || 'Something went wrong'
                });
            });
    }

    function updateEmail() {
        const newEmail = document.getElementById('newEmail').value;
        
        axios.post('{{ route("profile.update.email") }}', { email: newEmail })
            .then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message || 'Something went wrong'
                });
            });
    }

    function updatePassword() {
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'New passwords do not match'
            });
            return;
        }
        
        axios.post('{{ route("profile.update.password") }}', { 
            current_password: currentPassword, 
            new_password: newPassword 
        })
            .then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message || 'Something went wrong'
                });
            });
    }
</script>
@endsection