<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <x-user.gaya />
    @stack('style')

    <style>
        /* Mengatur skala tampilan pada laptop dan desktop */
        /* @media screen and (min-width: 1024px) {
        body {
            zoom: 90%;
        }
      } */
        /* Terapkan animasi fade ke kelas .fade-in */
        .fade-in {
            animation: fadeIn 8s infinite;
        }

        .select2-container--default {
            width: 100% !important;
            margin-bottom: 10px;
        }

        .select2-container .select2-selection--single {
            height: 40px;
            /* Atur tinggi sesuai kebutuhan Anda */
            padding-top: 5px;
        }

        #errorAlert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }

        .btn-primary.active {
            background-color: #ffffff;
            /* Warna latar belakang tombol saat aktif */
            color: rgb(0, 0, 0);
            /* Warna teks tombol saat aktif */
        }

        /* Terapkan animasi fade ke kelas .fade-in */
        .fade-in {
            animation: fadeIn 8s infinite;
        }

        .select2-container--default {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 40px;
            /* Atur tinggi sesuai kebutuhan Anda */
            padding-top: 5px;
        }

        #errorAlert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }

        .step-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding: 0 20px;
        }

        .opened .step-content {
            max-height: 1000px;
            padding: 10px 20px;
        }

        .step-title {
            cursor: pointer;
            padding: 10px 20px;
            background: #fffefe;
            border-radius: 3px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        .step-title i {
            float: right;
        }

        .accordion h5 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <x-user.header />
    <!-- End Header -->

    <!-- ======= Main Content ======= -->
    @yield('kontent')
    <!-- End Main Content -->

    <!-- ======= Footer ======= -->
    <x-user.footer />
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <x-user.script />
    @stack('script')
    @include('sweetalert::alert')

</body>

</html>


{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    @stack('style')
    @include('include.gaya')

    <style>
        /* Mengatur skala tampilan pada laptop dan desktop */
        /* @media screen and (min-width: 1024px) {
        body {
            zoom: 90%;
        }
      } */
        /* Terapkan animasi fade ke kelas .fade-in */
        .fade-in {
            animation: fadeIn 8s infinite;
        }

        .select2-container--default {
            width: 100% !important;
            margin-bottom: 10px;
        }

        .select2-container .select2-selection--single {
            height: 40px;
            /* Atur tinggi sesuai kebutuhan Anda */
            padding-top: 5px;
        }

        #errorAlert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }

        .btn-primary.active {
            background-color: #ffffff;
            /* Warna latar belakang tombol saat aktif */
            color: rgb(0, 0, 0);
            /* Warna teks tombol saat aktif */
        }

        /* Terapkan animasi fade ke kelas .fade-in */
        .fade-in {
            animation: fadeIn 8s infinite;
        }

        .select2-container--default {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 40px;
            /* Atur tinggi sesuai kebutuhan Anda */
            padding-top: 5px;
        }

        #errorAlert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }

        .step-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding: 0 20px;
        }

        .opened .step-content {
            max-height: 1000px;
            padding: 10px 20px;
        }

        .step-title {
            cursor: pointer;
            padding: 10px 20px;
            background: #fffefe;
            border-radius: 3px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        .step-title i {
            float: right;
        }

        .accordion h5 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->

    @include('include.header')

    <!-- End Header -->

    <!-- ======= Hero Section ======= -->

    <!-- End #main -->
    @yield('kontent')

    <!-- ======= Footer ======= -->

    @include('include.footer')

    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

</body>
@stack('script')
@include('include.script')
@include('sweetalert::alert')

</html> --}}
