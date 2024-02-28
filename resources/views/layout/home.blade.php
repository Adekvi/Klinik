<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    @yield('title')
  </title>
    @stack('style')
    @include('include.style')
</head>
<style>
  /* Tambahkan animasi fade */
  @keyframes fadeIn {
      0% {
          opacity: 0;
      }
      100% {
          opacity: 1;
      }
  }

  /* Terapkan animasi fade ke kelas .fade-in */
  .fade-in {
      animation: fadeIn 8s infinite;
  }
</style>
<body>
    <div class="container">
      <div class="icon">
          {{-- <img src="{{ asset('assets/img/logoumk.png') }}" alt=""> --}}
          <h1 class="fade-in">KLINIK PRATAMA MULTISARI II</h1>
      </div>
      <div class="text fade-in">
        <h5>Jalan Jepara-Kudus, Desa Sengonbugel, RT. 03/01 Kecamatan Mayong Kabupaten Jepara <br> <strong>Tlp. </strong> (0291)7520234,
          <strong>Email :</strong> klinikmultisari2@gmail.com</h5>
      </div>
      <div class="container">
        <div class="card">
            @include('include.navbar')
            <div class="card-body">
                @yield('content')
            </div>
        </div>
      </div>
    </div>

</body>

@stack('script')
@include('include.script')
</html>
