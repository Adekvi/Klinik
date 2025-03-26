@extends('admin.layout.dasbrod')
@section('title', 'Admin Dashboard')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mt-4">
            <div class="col-lg-6 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-6">
                            <div class="card-body">
                                <h4 class="card-title text-primary">Selamat Datang, <span class="text-info">Admin!</span></h4>
                                <p class="mb-4">
                                    @if (session('admin_active'))
                                        <div class="text-success">
                                            <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                        </div>
                                    @endif
                                    Dashboard Admin
                                </p>

                                {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
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
                                <h3 class="card-title mb-2">{{ $totalpasien }} pasien</h3>
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
                                <h3 class="card-title mb-2">{{ $totalpasienSehat }} pasien</h3>
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
                                <h3 class="card-title mb-2">{{ $totalpasienUmum }} pasien</h3>
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
                                <h3 class="card-title mb-2">{{ $totalpasienBpjs }} pasien</h3>
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
                                <span class="fw-semibold d-block mb-1">Dokter</span>
                                <h3 class="card-title mb-2">{{ $totalDokter }}</h3>
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
                                <span class="fw-semibold d-block mb-1">Tenaga Medis</span>
                                <h3 class="card-title mb-2">{{ $totalTenagamedis }}</h3>
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

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Import ApexCharts library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Ambil data pasien per bulan dari variabel PHP
        var pasienSehatData = @json($pasienSehatPerBulan);
        var pasienUmumData = @json($pasienUmumPerBulan);
        var pasienBpjsData = @json($pasienBpjsPerBulan);

        // Konfigurasi ApexCharts untuk menampilkan data pasien
        const totalRevenueChartEl = document.querySelector('#totalRevenueChart');
        const totalRevenueChartOptions = {
            series: [{
                    name: 'Pasien Sehat',
                    data: pasienSehatData
                },
                {
                    name: 'Pasien Umum',
                    data: pasienUmumData
                },
                {
                    name: 'Pasien BPJS',
                    data: pasienBpjsData
                }
            ],
            chart: {
                height: 300,
                stacked: true,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '33%',
                    borderRadius: 12,
                    startingShape: 'rounded',
                    endingShape: 'rounded'
                }
            },
            colors: ['#28a745', '#007bff', '#ffc107'], // Warna untuk masing-masing kategori
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 6,
                lineCap: 'round',
                colors: ['#fff']
            },
            legend: {
                show: true,
                horizontalAlign: 'left',
                position: 'top',
                markers: {
                    height: 8,
                    width: 8,
                    radius: 12,
                    offsetX: -3
                },
                labels: {
                    colors: '#333'
                },
                itemMargin: {
                    horizontal: 10
                }
            },
            grid: {
                borderColor: '#e0e0e0',
                padding: {
                    top: 0,
                    bottom: -8,
                    left: 20,
                    right: 20
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                    'Des'
                ], // Menampilkan bulan
                labels: {
                    style: {
                        fontSize: '13px',
                        colors: '#333'
                    }
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '13px',
                        colors: '#333'
                    }
                }
            },
            responsive: [{
                    breakpoint: 1700,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                columnWidth: '32%'
                            }
                        }
                    }
                },
                // More responsive breakpoints can be added here
            ],
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                },
                active: {
                    filter: {
                        type: 'none'
                    }
                }
            }
        };

        if (typeof totalRevenueChartEl !== undefined && totalRevenueChartEl !== null) {
            const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
            totalRevenueChart.render();
        }
    </script>
@endpush
