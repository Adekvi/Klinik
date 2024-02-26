<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RS</title>
    @stack('style')
    @include('include.style')
</head>
<body>
    <div class="container">
      <div class="icon">
          <img src="{{ asset('assets/img/logoumk.png') }}" alt="">
          <h1>Klinik Rumble Racing</h1>
      </div>
        <div class="card">
            @include('include.navbar')
            <div class="card-body">

                @yield('content')

            </div>
          </div>
    </div>


</body>

@stack('script')
@include('include.script')
</html>
