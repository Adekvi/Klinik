<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@500&family=Playfair+Display&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('aset/img/favicon/favicon.ico') }}" />
</head>
<style>
    .btn-login {
        background-color: #012374;
        color: #fff;
        margin-right: 10px;
    }

    .btn-login:hover {
        background-color: #1a48b3;
        color: #ffffff;
    }

    .page-login {
        height: 100vh;
    }

    .page-login .btn-login {
        background-color: #12ae0a;
        color: #fff;
    }

    .page-login .btn-login:hover {
        background-color: #10e105;
        color: #fff;
    }

    .page-login .section-left {
        font-family: 'Playfair Display';
        font-weight: bold;
        font-size: 50px;
        text-align: left;
        color: #071c4d;
    }

    .page-login .section-right a {
        font-family: 'Assistant';
        font-weight: 300;
        text-decoration: underline;
        font-size: 16px;
        text-align: center;
        color: #bfbfbf;
    }

    @media (min-width: 992px) {
        .login-container {
            background: -webkit-gradient(linear, left top, right top, color-stop(60%, #ffff), color-stop(40%, #e4e6eb));
            background: linear-gradient(90deg, #ffff 60%, #e4e6eb 40%);
            width: 100vw;
            height: 100vh;
        }
    }
</style>

<body>
    <!--Navbar-->

    <!--Main-->
    <main class="login-container">
        <div class="container">
            <div class="row page-login d-flex align-items-center">
                <div class="section-left col-12 col-md-6">
                    <h2 class="mb-4" style="    font-size: 30px;
          font-family: cursive; font-weight: bold;">
                        Silahkan Registrasi Terlebih Dahulu <br> Untuk Melanjutkan Pendaftaran</h2>
                    <img src="{{ asset('assets/img/gambar-dokter.png') }}" alt="" class="d-none d-sm-flex"
                        style="    width: 65%;">
                </div>
                <div class="section-right col-12 col-md-4">
                    <div class="card mt-4 mb-4">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/logo_cv.png') }}" alt="" style="width: 50%;"
                                    class="mb-4">

                            </div>
                            <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <input id="role" type="hidden" class="form-control" name="role" value="user">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input id="name" type="text" class="form-control" name="name" required
                                        autocomplete="name">
                                </div>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username" required
                                        autocomplete="username">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                                <div class="form-group" style="position: relative;">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div onclick="togglePassword()" style="position: absolute; top: 57%; right: 4%;">
                                        <svg width="20" height="14" viewBox="0 0 20 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path id="icon-toggle" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 7C0.555556 4.66667 3.33333 0 10 0C16.6667 0 19.4444 4.66667 20 7C19.4444 9.52778 16.6667 14 10 14C3.31853 14 0.555556 9.13889 0 7ZM10 5C8.89543 5 8 5.89543 8 7C8 8.10457 8.89543 9 10 9C11.1046 9 12 8.10457 12 7C12 6.90536 11.9934 6.81226 11.9807 6.72113C12.2792 6.89828 12.6277 7 13 7C13.3608 7 13.6993 6.90447 13.9915 6.73732C13.9971 6.82415 14 6.91174 14 7C14 9.20914 12.2091 11 10 11C7.79086 11 6 9.20914 6 7C6 4.79086 7.79086 3 10 3C10.6389 3 11.2428 3.14979 11.7786 3.41618C11.305 3.78193 11 4.35535 11 5C11 5.09464 11.0066 5.18773 11.0193 5.27887C10.7208 5.10171 10.3723 5 10 5Z"
                                                fill="#4E4B62" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="form-group" style="position: relative;">
                                    <label for="password-confirm">Konfirmasi Password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">

                                    <div onclick="toggleConfirmPassword()"
                                        style="position: absolute; top: 57%; right: 4%;">
                                        <svg width="20" height="14" viewBox="0 0 20 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path id="icon-toggle2" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 7C0.555556 4.66667 3.33333 0 10 0C16.6667 0 19.4444 4.66667 20 7C19.4444 9.52778 16.6667 14 10 14C3.31853 14 0.555556 9.13889 0 7ZM10 5C8.89543 5 8 5.89543 8 7C8 8.10457 8.89543 9 10 9C11.1046 9 12 8.10457 12 7C12 6.90536 11.9934 6.81226 11.9807 6.72113C12.2792 6.89828 12.6277 7 13 7C13.3608 7 13.6993 6.90447 13.9915 6.73732C13.9971 6.82415 14 6.91174 14 7C14 9.20914 12.2091 11 10 11C7.79086 11 6 9.20914 6 7C6 4.79086 7.79086 3 10 3C10.6389 3 11.2428 3.14979 11.7786 3.41618C11.305 3.78193 11 4.35535 11 5C11 5.09464 11.0066 5.18773 11.0193 5.27887C10.7208 5.10171 10.3723 5 10 5Z"
                                                fill="#4E4B62" />
                                        </svg>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-login btn-block"> Daftar</button>
                            </form>
                            <p style="margin-top: 10%; text-align: center; color: #000000;">Already Have Account?
                                <a href="{{ url('login/index') }}" style="color: blue;text-decoration: none;">
                                    <span style="text-decoration: underline;">Sign In</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
                document
                    .getElementById("icon-toggle")
                    .setAttribute("fill", "#2ec49c");
            } else {
                x.type = "password";
                document
                    .getElementById("icon-toggle")
                    .setAttribute("fill", "#CACBCE");
            }
        }

        function toggleConfirmPassword() {
            var x = document.getElementById("password-confirm");
            if (x.type === "password") {
                x.type = "text";
                document
                    .getElementById("icon-toggle2")
                    .setAttribute("fill", "#2ec49c");
            } else {
                x.type = "password";
                document
                    .getElementById("icon-toggle2")
                    .setAttribute("fill", "#CACBCE");
            }
        }
    </script>
</body>

</html>
