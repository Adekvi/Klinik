@extends('admin.layout.dasbrod')
@section('title', 'Dashboard')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mt-4">
            <div class="col-lg-6 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-6">
                            <div class="card-body">
                                @if (Auth::check())
                                    @if (Auth::user()->role == 'perawat')
                                        <h4 class="card-title text-primary">Selamat Datang, <span
                                                class="text-info">{{ Auth::user()->name }}!</span></h4>
                                        <p class="mb-4">
                                            @if (session('perawat_active'))
                                                <div class="text-success">
                                                    <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                                </div>
                                            @endif
                                            Dashboard Perawat
                                        </p>
                                    @elseif (Auth::user()->role == 'dokter')
                                        <h4 class="card-title text-primary">Selamat Datang, <span
                                                class="text-info">{{ Auth::user()->name }}!</span></h4>
                                        <p class="mb-4">
                                            @if (session('perawat_active'))
                                                <div class="text-success">
                                                    <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                                </div>
                                            @endif
                                            Dashboard Dokter
                                        </p>
                                    @elseif (Auth::user()->role == 'apoteker')
                                        <h4 class="card-title text-primary">Selamat Datang, <span
                                                class="text-info">{{ Auth::user()->name }}!</span></h4>
                                        <p class="mb-4">
                                            @if (session('perawat_active'))
                                                <div class="text-success">
                                                    <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                                </div>
                                            @endif
                                            Dashboard Apoteker
                                        </p>
                                    @elseif (Auth::user()->role == 'kasir')
                                        <h4 class="card-title text-primary">Selamat Datang, <span
                                                class="text-info">{{ Auth::user()->name }}!</span></h4>
                                        <p class="mb-4">
                                            @if (session('perawat_active'))
                                                <div class="text-success">
                                                    <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                                </div>
                                            @endif
                                            Dashboard Kasir
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('aset/img/man-with-laptop-light.png') }}" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-hospital-user fa-2x text-primary"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Pasien</span>
                                <h3 class="card-title mb-2">0 pasien</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-suitcase-medical fa-2x text-warning"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Pasien Sehat</span>
                                <h3 class="card-title mb-2">0 pasien</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-12">
                            <h5 class="card-header m-0 me-2 pb-3">Grafik Pasien</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-solid fa-stethoscope fa-2x text-success"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Pasien Umum</span>
                                <h3 class="card-title mb-2">0 pasien</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-notes-medical fa-2x text-info"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Pasien Bpjs</span>
                                <h3 class="card-title mb-2">0 pasien</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-user-doctor fa-2x text-danger"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Pasien</span>
                                <h3 class="card-title mb-2">0</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-user-nurse fa-2x text-secondary"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Pasien</span>
                                <h3 class="card-title mb-2">0</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
