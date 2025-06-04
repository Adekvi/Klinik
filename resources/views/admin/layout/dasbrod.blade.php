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

                    <!-- Chat Box -->
                    {{-- <div id="chat-box" class="chat-box">
                        <div class="chat-header">
                            <span>Customer Service</span>
                            <button type="button" id="close-chat" class="btn btn-close mb-2 mt-2"
                                aria-label="Close"></button>
                        </div>

                        <div class="chat-content" id="chat-content">
                            <!-- Messages will be appended here -->
                            <div class="message admin"><strong>Admin</strong>
                                <p>Apakah ada yang bisa dibantu?</p>
                            </div>
                            <div class="message user">
                                <strong>User</strong>
                                <p>I need assistance with my order.</p>
                            </div>
                        </div>

                        <!-- Chat Form -->
                        <form id="chat-form" method="POST">
                            @csrf
                            <div class="kirim" style="display: flex; justify-content: center; align-items: center">
                                <input type="hidden" id="receiver-id" name="receiver_id" value="1">
                                <textarea id="message" name="message" placeholder="Type your message..."></textarea>
                                <button type="submit">Send</button>
                            </div>
                        </form>
                    </div>

                    <!-- Customer Icon (fixed on screen) -->
                    <div id="chat-icon" class="chat-icon">
                        <img src="{{ asset('assets/images/cs.png') }}" alt="Customer" width="150" height="130">
                    </div> --}}

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
