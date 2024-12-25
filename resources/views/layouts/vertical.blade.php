<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<head>
    @include('layouts.partials/title-meta', ['title' => $title])
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    @yield('css')
    @include('sweetalert::alert')

    @include('layouts.partials/head-css')
</head>

<body>

    @include('layouts.partials/topbar')

    @include('layouts.partials/startbar')

    <div class="page-wrapper">

        <div class="page-content">
            <div class="container-xxl">

                @yield('content')

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                @stack('scripts')

            </div>

            @include('layouts.partials/endbar')

            @include('layouts.partials/footer')

        </div>
    </div>

    @include('layouts.partials/vendorjs')

    @vite(['resources/js/app.js'])
</body>

</html>
