<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
<meta name="csrf-token" content="{{ csrf_token() }}">


<head>
    @include('layouts.partials/title-meta', ['title' => $title])

    @yield('css')

    @include('layouts.partials/head-css')
</head>

<body>

    @include('layouts.partials/topbar')

    @include('layouts.partials/startbar')

    <div class="page-wrapper">

        <div class="page-content">
            <div class="container-xxl">

                @yield('content')

            </div>

            @include('layouts.partials/endbar')

            @include('layouts.partials/footer')

        </div>
    </div>

    @include('layouts.partials/vendorjs')

    @vite(['resources/js/app.js'])


</body>

</html>
