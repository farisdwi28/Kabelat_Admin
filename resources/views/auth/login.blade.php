@extends('layouts.auth', ['title' => 'Rizz'])

@section('content')

<div class="col-lg-4 mx-auto">
    <div class="card">
        <div class="card-body p-0 bg-white auth-header-box rounded-top">
            <div class="text-center p-3">
                <a href="{{ route('any', 'home')}}" class="logo logo-admin">
                    <img src="/images/kabelat3.png" height="70" alt="logo" class="auth-logo">
                </a>
                <h4 class="mt-3 mb-1 fw-semibold text-black fs-18">Selamat Datang !</h4>
                <p class="text-muted fw-medium mb-0">Masuk Sebagai Admin</p>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('login')}}" class="my-4">
                @csrf
                @if (sizeof($errors) > 0)
                @foreach ($errors->all() as $error)
                <p class="text-danger mb-3">{{ $error }}</p>
                @endforeach
                @endif

                <div class="form-group mb-2">
                    <label class="form-label" for="email">Username</label>
                    <input type="email" class="form-control" id="example-email" name="email" value="user@demo.com" placeholder="Masukkan Username Anda">
                </div><!--end form-group-->

                <div class="form-group">
                    <label class="form-label" for="example-password">Password</label>
                    <input type="password" class="form-control" name="password" value="password" id="example-password" placeholder="Masukkan Password Anda">
                </div><!--end form-group-->

                <div class="form-group row mt-3">
                    <div class="col-sm-6">
                        <div class="form-check form-switch form-switch-success">
                            <input class="form-check-input" type="checkbox" id="customSwitchSuccess">
                            <label class="form-check-label" for="customSwitchSuccess">Ingat Saya</label>
                        </div>
                    </div><!--end col-->
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('second', ['auth', 'recover-pw'])}}" class="text-muted font-13"><i class="dripicons-lock"></i> Lupa Password</a>
                    </div><!--end col-->
                </div><!--end form-group-->

                <div class="form-group mb-0 row">
                    <div class="col-12">
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary" type="submit">Masuk <i class="fas fa-sign-in-alt ms-1"></i></button>
                        </div>
                    </div><!--end col-->
                </div> <!--end form-group-->
            </form><!--end form-->
        </div><!--end card-body-->
    </div><!--end card-->
</div><!--end col-->

@endsection