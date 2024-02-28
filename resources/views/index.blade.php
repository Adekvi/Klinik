<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Selamat Datang!</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  {{-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assetss/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assetss/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: UpConstruction - v1.3.0
  * Template URL: https://bootstrapmade.com/upconstruction-bootstrap-construction-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <section id="hero" class="hero">

        <div class="info d-flex align-items-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-6 text-center">
                <h2 data-aos="fade-down">KLINIK PRATAMA MULTISARI II</h2>
                <p data-aos="fade-up">Jalan Jepara-Kudus, Desa Sengonbugel, RT. 03/01 Kecamatan Mayong Kabupaten Jepara </p>
                <div class="icon-container" style="text-align: center; display: flex; justify-content: center;">
                    <div style="margin-top: 10px;">
                        <div class="fa-solid fa-person-circle-plus" style="color: white; font-size: 90px; margin-bottom: 10px"></div>
                        <p style="color: white;">
                            <a data-aos="fade-up" data-aos-delay="200" href="{{ url('pasien/index') }}" class="btn-get-started">Masuk</a>
                        </p>
                    </div>
                </div>                       
              </div>
            </div>
          </div>
        </div>
    
        <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    
          <div class="carousel-item active" style="background-image: url(assetss/img/hero-carousel/1.jpg)">
          </div>
          <div class="carousel-item" style="background-image: url(assetss/img/hero-carousel/2.jpg)"></div>
          <div class="carousel-item" style="background-image: url(assetss/img/hero-carousel/3.jpg)"></div>
          <div class="carousel-item" style="background-image: url(assetss/img/hero-carousel/4.jpg)"></div>
          <div class="carousel-item" style="background-image: url(assetss/img/hero-carousel/5.jpg)"></div>
    
          <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
          </a>
    
          <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
          </a>
    
        </div>
    
      </section>

    <!-- Vendor JS Files -->
  <script src="{{ asset('assetss/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assetss/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assetss/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assetss/js/main.js') }}"></script>
</body>