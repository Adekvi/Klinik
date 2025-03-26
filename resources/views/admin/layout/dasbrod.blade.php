<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('../aset/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <x-admin.style />
    @stack('style')

    {{-- <style>
        /* Membuat overlay menjadi transparan */
        .modal-backdrop {
            background-color: transparent !important;
        }

        body.dark-mode {
            background-color: #3f3f3f;
            color: #ffffff;
        }

        .dark-mode .table-bordered {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .dark-mode .navbar,
        .dark-mode .sidebar,
        .dark-mode .footer,
        .dark-mode .menu-vertical {
            background-color: #1e1e1e;
        }

        .dark-mode .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .dark-mode .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .dark-mode .menu-inner .menu-item .menu-link {
            color: #ffffff;
        }

        .dark-mode .menu-inner .menu-item.active .menu-link {
            background-color: #343a40;
            color: #ffffff;
        }

        .dark-mode .menu-icon {
            color: #ffffff;
        }
    </style> --}}
</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar -->
            <x-admin.sidebar />

            <div class="layout-page">

                <!-- Navbar -->
                <x-admin.navbar />

                <div class="content-wrapper">

                    <!-- Content -->
                    @yield('content')

                    <!-- Footer -->
                    <x-admin.footer />

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @stack('script')
    <x-admin.script />
    @include('sweetalert::alert')

</body>

</html>
