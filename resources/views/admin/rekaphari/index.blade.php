@extends('admin.layout.dasbrod')
@section('title', 'Admin | Rekap Harian')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Rekap/</span> Pasien Diperikas hari ini</h4>

        <div class="date-time">
            <div class="tanggal" id="tanggal"></div>
            <div class="jam" id="jam"></div>
        </div>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-6">
                <!-- HTML5 Inputs -->
                <div class="card mb-4">
                    <h5 class="card-header">Pasien Hari ini</h5>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-4 col-form-label">Pasien Umum</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly
                                    value="{{ $pasienHariIniUmum ?? '0' }}" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-4 col-form-label">Pasien Bpjs</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly
                                    value="{{ $pasienHariIniBpjs ?? '0' }}" />
                            </div>
                        </div>
                        {{-- <div class="row">
                            <label for="html5-range" class="col-md-4 col-form-label">Range</label>
                            <div class="col-md-8">
                                <input type="range" class="form-range mt-3" id="html5-range" />
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card mb-4">
                    <h5 class="card-header">Total Pasien</h5>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-4 col-form-label">Jumlah pasien</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly value="{{ $totalpasien ?? '0' }}" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-4 col-form-label">Pasien Umum</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly value="{{ $totalpasienUmum ?? '0' }}" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-4 col-form-label">Pasien Bpjs</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly value="{{ $totalpasienBpjs ?? '0' }}" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-4 col-form-label">Pasien Sehat</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly
                                    value="{{ $totalpasienSehat ?? '0' }}" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-4 col-form-label">Total Diagnosa</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly value="{{ $totaldiagnosa ?? '0' }}" />
                            </div>
                        </div>
                        {{-- <div class="row">
                            <label for="html5-range" class="col-md-4 col-form-label">Range</label>
                            <div class="col-md-10">
                                <input type="range" class="form-range mt-3" id="html5-range" />
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
    @endpush
    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
        <script>
            new DataTable('#example');

            function updateClock() {
                var now = new Date();
                var tanggalElement =
                    document.getElementById('tanggal');
                var options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h4>' + now.toLocaleDateString('id-ID', options) + '</h4>';

                // var jamElement = document.getElementById('jam');
                // var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                //                 now.getMinutes().toString().padStart(2, '0');
                // jamElement.innerHTML = '<h4>' + jamString + '</h4>';
            }
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    @endpush
