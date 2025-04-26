@extends('admin.layout.dasbrod')
@section('title', 'Kasir Antrian')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row demo-vertical-spacing">
            <div class="col-md-12">
                <div class="card-title">
                    <div class="judul d-flex justify-content-between align-items-center">
                        <h4><strong>Antrian Pasien</strong></h4>
                        <div class="date-time d-flex align-items-center gap-2 text-center">
                            <div class="tanggal text-muted" id="tanggal"></div>
                            <div class="jam text-muted" id="jam"></div>
                        </div>
                    </div>
                    <div class="status" style="justify-content: start">
                        <div class="col-lg-12 col-md-6">
                            <button class="btn btn-info" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasEnd" aria-controls="offcanvasBoth">
                                <i class="fa-solid fa-house-medical-circle-check"></i> Status Pasien
                            </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd"
                                aria-labelledby="offcanvasEndLabel" style="width: 600px">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Status Pasien</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                    <div class="text-center mb-3 mt-3">
                                        <h4 class="mb-3"><strong>Rekap Pasien</strong></h4>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="text-center d-flex flex-column align-items-center">
                                                <!-- Teks dan ikon di atas -->
                                                <span class="badge border text-success fs-6 p-3">
                                                    <i class="fa-solid fa-check-circle"></i> Dilayani:
                                                    <span id="pasienDilayani">0</span>
                                                </span>
                                                <!-- Gambar di bawah -->
                                                <img src="{{ asset('aset/img/periksa.jpg') }}" alt="Pasien DIlayani"
                                                    style="width: 60%; height: auto;">
                                            </div>
                                            <div class="text-center d-flex flex-column align-items-center">
                                                <!-- Teks dan ikon di atas -->
                                                <span class="badge border text-warning fs-6 p-3">
                                                    <i class="fa-solid fa-times-circle"></i> Belum Dilayani:
                                                    <span id="pasienBelumDilayani">0</span>
                                                </span>
                                                <!-- Gambar di bawah -->
                                                <img src="{{ asset('aset/img/check.jpg') }}" alt="Pasien Belum Dilayani"
                                                    style="width: 60%; height: auto;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-secondary w-100"
                                                data-bs-dismiss="offcanvas">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="" class="d-flex justify-content-between align-items-center mb-3">
                            <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                            <div class="d-flex align-items-center">
                                <label for="entries" class="me-2">Tampilkan:</label>
                                <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                    style="width: 80px;" onchange="this.form.submit()">
                                    <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="text" name="search" value="{{ $search }}"
                                    class="form-control form-control-sm me-2" style="width: 400px;"
                                    placeholder="Cari Nama / No. Rm">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped" style=" white-space: nowrap;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Antrian</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if (count($antrianKasir) === 0)
                                        <tr>
                                            <td colspan="9" style="text-align: center; font-size: bold">Tidak ada data
                                            </td>
                                        </tr>
                                    @else
                                        @php $allSoapPatients = []; @endphp
                                        @foreach ($antrianKasir as $item)
                                            @php
                                                $soapData = isset($item['obat']['resep'])
                                                    ? json_decode($item['obat']['resep'], true)
                                                    : [];

                                                if (is_array($soapData)) {
                                                    $allSoapPatients = array_merge(
                                                        $allSoapPatients,
                                                        array_keys($soapData),
                                                    );
                                                }
                                            @endphp
                                        @endforeach
                                        @php $allSoapPatients = array_unique($allSoapPatients); @endphp
                                        @foreach ($antrianKasir as $item)
                                            <tr id="row_{{ $item->id }}">
                                                <td>{{ $loop->iteration + ($antrianKasir->currentPage() - 1) * $antrianKasir->perPage() }}
                                                </td>
                                                <td>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-offset="0,4" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Lewati Antrian</span>">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#lewati{{ $item->id }}">
                                                            <i class="fa-solid fa-forward"></i>
                                                        </button>
                                                    </span>
                                                    </button>
                                                    <a href="{{ url('kasir/totalan/' . $item->id) }}"
                                                        class="btn btn-primary" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-offset="0,4" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Total</span>">
                                                        <i class="fa-solid fa-calculator"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $item->kode_antrian }}</td>
                                                <td>{{ $item->obat->soap->nama_dokter }}</td>
                                                <td>{{ $item->booking->pasien->no_rm }}</td>
                                                <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                <td>{{ $item->booking->pasien->alamat_asal }}</td>
                                                <td>{{ $item->booking->pasien->jekel }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Paginasi -->
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            {{ $antrianKasir->links() }} <!-- Laravel's built-in pagination links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        /* Alert */
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
    <script src="{{ asset('assets/responsivevoice.js') }}"></script>
    <script src="{{ asset('assets/js/antrian.script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        // tanggal dan jam
        function updateClock() {
            var now = new Date();
            var tanggalElement =
                document.getElementById('tanggal');
            var options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

            var jamElement = document.getElementById('jam');
            var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0') + ':' +
                now.getSeconds().toString().padStart(2, '0');
            jamElement.innerHTML = '<h6>' + jamString + '</h6>';
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endpush
