@extends('admin.layout.dasbrod')
@section('title', 'Perawat')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row demo-vertical-spacing">
            <div class="col-md-12">
                <div class="pendaftaran">
                    <div class="card-title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h4><strong>Antrian Pasien</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="kunjungan">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#Sehat">
                                    <i class="fa-solid fa-square-plus"></i> Kunjungan Sehat
                                </button>

                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#KunjunganOnline" style="margin-left: 10px">
                                    <i class="fa-solid fa-square-plus"></i> Kunjungan Online
                                </button>
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
                                            <div class="text-center mb-3">
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
                                                        <img src="{{ asset('aset/img/check.jpg') }}"
                                                            alt="Pasien Belum Dilayani" style="width: 60%; height: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                {{-- Shift Pagi --}}
                                                <div id="shiftPagi" class="shift-container">
                                                    <table class="table table-bordered table-responsive">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th class="text-center">SHIFT PAGI</th>
                                                                <th class="text-center">KET.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Tanggal</td>
                                                                <td id="tanggalShiftPagi" class="text-center"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                                <td id="poliUmumBpjsPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Bpjs)</td>
                                                                <td id="laboratBpjsPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Umum)</td>
                                                                <td id="laboratUmumPagi" class="text-center">0</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                {{-- Shift Siang --}}
                                                <div id="shiftSiang" class="shift-container">
                                                    <table class="table table-bordered table-responsive">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th class="text-center">SHIFT SIANG</th>
                                                                <th class="text-center">KET.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Tanggal</td>
                                                                <td id="tanggalShiftSiang" class="text-center"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                                <td id="poliUmumBpjsSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Bpjs)</td>
                                                                <td id="laboratBpjsSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Umum)</td>
                                                                <td id="laboratUmumSiang" class="text-center">0</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="shift-container" id="shiftReportTotal">
                                                    <table class="table table-bordered table-responsive w-100">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th class="text-center">PASIEN SHIFT PAGI DAN SIANG</th>
                                                                <th class="text-center">KET.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                                <td id="poliUmumBpjsTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Bpjs)</td>
                                                                <td id="laboratBpjsTotal" style="text-align: center">0
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Umum)</td>
                                                                <td id="laboratUmumTotal" style="text-align: center">0
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <a href="{{ url('rekap-harian') }}" class="btn btn-primary w-100">
                                                        <i class="menu-icon tf-icons fa-solid fa-folder"></i> Menu Rekap
                                                        Harian
                                                    </a>
                                                </div>
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
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('perawat.index') }}"
                                class="d-flex justify-content-between align-items-center mb-3">
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
                                        placeholder="Cari Nama / NIK / No. Rm">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </form>
                            <div class="isian" style="overflow-x: scroll">
                                <table class="table table-striped table-bordered"
                                    style="background-color: white; white-space: nowrap;">
                                    <thead class="table-primary"
                                        style=" text-align: center; font-size: 25px; width: auto">
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>No. RM</th>
                                            <th>Nama Pasien</th>
                                            <th>No. Antrian</th>
                                            <th>Poli</th>
                                            <th>Dokter</th>
                                            <th>Alamat Domisili</th>
                                            <th>Jenis Pasien</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                        @if (count($pasien) === 0)
                                            <tr>
                                                <td colspan="10" style="text-align: center; font-size: bold">Tidak ada
                                                    data
                                                </td>
                                            </tr>
                                        @else
                                            <?php $no = 1; ?>
                                            @foreach ($pasien as $item)
                                                {{-- {{ dd($item) }} --}}
                                                @if ($item->status == 'D')
                                                    <tr id="row_{{ $item->id }}">
                                                        <td>{{ $no++ }}</td>
                                                        <td>
                                                            <button data-nomor-antrian-perawat="{{ $item->kode_antrian }}"
                                                                data-poli="{{ $item->poli->namapoli }}"
                                                                class="btn btn-success btn-panggil-perawat mb-1"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Panggil Pasien</span>">
                                                                <i class="fas fa-bell"></i>
                                                            </button>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Lewati Pasien</span>">
                                                                <button type="button" class="btn btn-secondary mb-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#lewati{{ $item->id }}">
                                                                    <i class="fa-solid fa-forward"></i>
                                                                </button>
                                                            </span>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Asesmen Awal</span>">
                                                                <button type="button" class="btn btn-primary mb-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#periksa{{ $item->id }}">
                                                                    <i class="fas fa-pen"></i>
                                                                </button>
                                                            </span>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Riwayat Pasien</span>">
                                                                <button type="button" class="btn btn-info mb-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#riwayatModal{{ $item->id }}">
                                                                    <i class="fas fa-info"></i>
                                                                </button>
                                                            </span>
                                                            <a href="{{ url('cetak-antrianPerawat/' . $item->id) }}"
                                                                class="btn btn-warning mb-1" target="_blank"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bx-bell bx-xs' ></i> <span>Cetak Antrian</span>">
                                                                <i class="fas fa-print"></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $item->booking->pasien->no_rm }}</td>
                                                        <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                        <td>{{ $item->kode_antrian }}</td>
                                                        <td>{{ $item->poli->namapoli }}</td>
                                                        <td>{{ $item->dokter->nama_dokter }}</td>
                                                        <td>{{ $item->booking->pasien->domisili }}</td>
                                                        <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                                                        <td>Datang</td>
                                                    </tr>
                                                @endif
                                                @include('perawat.modalPerawat.ModalAnamnesis')
                                                @include('perawat.modalPerawat.ModalKajianAwal')
                                                <script>
                                                    // Ttd
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        var select = document.getElementById('ak_ttdperawat_bidan');
                                                        var image = document.getElementById('ttd_perawat_image');

                                                        select.addEventListener('change', function() {
                                                            var selectedOption = select.options[select.selectedIndex];
                                                            var imageSrc = selectedOption.getAttribute('data-image');

                                                            if (imageSrc) {
                                                                image.src = imageSrc;
                                                                image.style.display = 'block';
                                                            } else {
                                                                image.src = '';
                                                                image.style.display = 'none';
                                                            }
                                                        });
                                                    });

                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const btnKajian = document.querySelectorAll('[id^="btnKajian"]');
                                                        const formKajian = document.querySelectorAll('[id^="formKajian"]');
                                                        const btnAsesmen = document.querySelectorAll('[id^="btnAsesmen"]');
                                                        const formAsesmen = document.querySelectorAll('[id^="formAsesmen"]');

                                                        btnKajian.forEach(function(button, index) {
                                                            button.addEventListener('click', function() {
                                                                if (formKajian[index]) {
                                                                    formKajian[index].style.display = 'block';
                                                                    if (formAsesmen[index]) {
                                                                        formAsesmen[index].style.display = 'none';
                                                                    }
                                                                }
                                                            });
                                                        });

                                                        btnAsesmen.forEach(function(button, index) {
                                                            button.addEventListener('click', function() {
                                                                if (formAsesmen[index]) {
                                                                    formAsesmen[index].style.display = 'block';
                                                                    if (formKajian[index]) {
                                                                        formKajian[index].style.display = 'none';
                                                                    }
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="halaman d-flex justify-content-end">
                                    {{ $pasien->appends(request()->only(['search', 'entries']))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="sudah-daftar">
                <div class="card-title">
                    <h4><strong>Pasien Diperiksa</strong></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('perawat.index') }}"
                            class="d-flex justify-content-between align-items-center mb-3">
                            <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                            <div class="d-flex align-items-center">
                                <label for="periksa_entries" class="me-2">Tampilkan:</label>
                                <select name="periksa_entries" id="periksa_entries"
                                    class="form-select form-select-sm me-3" style="width: 80px;"
                                    onchange="this.form.submit()">
                                    <option value="10" {{ request('periksa_entries', 10) == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ request('recent_entries') == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ request('recent_entries') == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ request('recent_entries') == 100 ? 'selected' : '' }}>
                                        100
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="text" name="periksa_search" value="{{ request('periksa_search') }}"
                                    class="form-control form-control-sm me-2" style="width: 400px;"
                                    placeholder="Cari Nama / NIK / No. Rm">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </form>
                        <div class="isian" style="overflow-x: scroll">
                            <table class="table table-striped table-bordered" style="background-color: white">
                                <thead class="table-secondary"
                                    style="text-align: center; white-space: nowrap; width: auto">
                                    <tr>
                                        <th>No</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>No. Antrian</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Pasien</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                    @if (empty($periksa))
                                        <tr>
                                            <td colspan="7" style="text-align: center">Tidak Ada Data Pasien</td>
                                        </tr>
                                    @else
                                        <?php $no = 1; ?>
                                        @foreach ($periksa as $item)
                                            @if ($item->status == 'M')
                                                <tr id="row_{{ $item->id }}">
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->booking->pasien->no_rm }}</td>
                                                    <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                    <td>{{ $item->kode_antrian }}</td>
                                                    <td>{{ $item->poli->namapoli }}</td>
                                                    <td>{{ $item->dokter->nama_dokter }}</td>
                                                    <td>{{ $item->booking->pasien->domisili }}</td>
                                                    <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary rounded-pill">
                                                            Menunggu..
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                            @include('perawat.modalPerawat.ModalKajianAwal')
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="page d-flex justify-content-end">
                                {{ $periksa->appends(request()->only(['periksa_search', 'periksa_entries']))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAMPIL MODAL RIWAYAT 1 --}}
    @foreach ($pasien as $item)
        {{-- MODAL ISIAN PERAWAT --}}
        <div class="modal fade" id="riwayatModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Riwayat
                            Asesmen
                            Pasien
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="asesmen">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Asesmen</th>
                                        <th>Detail Asesmen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $iteration = 1;
                                        $asesmenDitemukan = false;
                                    @endphp
                                    @php
                                        $sortedSoap = [];
                                        if (!empty($soap)) {
                                            $idPasien = $item->booking->id_pasien;
                                            $sortedSoap = $soap
                                                ->where('id_pasien', $idPasien)
                                                ->sortByDesc('created_at')
                                                ->values()
                                                ->all();
                                        }
                                        // dd($sortedSoap);
                                    @endphp
                                    @if (!empty($sortedSoap))
                                        @foreach ($sortedSoap as $asesmen)
                                            @php $asesmenDitemukan = true; @endphp
                                            <tr>
                                                <td>{{ $iteration++ }}</td>
                                                <td>{{ date_format(date_create($asesmen['created_at']), 'd-m-Y/H:i:s') }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailAsesmen{{ $asesmen['id'] }}"
                                                        data-toggle="tooltip" data-bs-placement="top" title="Asesmen">
                                                        <i class="fas fa-eye"></i> Lihat Asesmen
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @elseif (!$asesmenDitemukan)
                                        <tr>
                                            <td colspan="3" style="text-align: center">Belum ada Asesmen</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- TAMPIL MODAL RIWAYAT 2 --}}
    @if (!empty($soap))
        @foreach ($soap as $asesmen)
            <div class="modal fade" id="detailAsesmen{{ $asesmen->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabelAsesmen{{ $asesmen->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg" style="display: contents">
                    <div class="modal-content" style="margin-top: 20px; width: 95%; margin-left: 3%;">
                        <div class="modal-header bg-primary">
                            <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Detail
                                Asesmen
                                Tanggal : 20-04-2024</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead class="table-primary" style="text-align: center;">
                                        <tr>
                                            <th>TGL DAN JAM</th>
                                            <th>PROFESI</th>
                                            <th>ASESMEN</th>
                                            <th>EDUKASI</th>
                                        </tr>
                                    </thead>

                                    <tbody style="text-align: center;">
                                        <tr>
                                            <td>{{ date_format(date_create($asesmen['created_at']), 'Y-m-d/H:i:s') }}</td>
                                            <td>{{ $asesmen['nama_dokter'] }}</td>
                                            <td style="text-align: left">
                                                <table class="table">
                                                    <thead>
                                                        <tr style="text-align: center; font-weight: bold">
                                                            <td>S</td>
                                                            <td>O</td>
                                                            <td>A</td>
                                                            <td>P</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $asesmen['keluhan_utama'] }} </td>
                                                            <td>
                                                                <ul>
                                                                    <li>Tensi : {{ $asesmen['p_tensi'] }} / mmHg</li>
                                                                    <li>RR : {{ $asesmen['p_rr'] }} / minute</li>
                                                                    <li>Nadi : {{ $asesmen['p_nadi'] }} / minute</li>
                                                                    <li>Suhu : {{ $asesmen['p_suhu'] }} °c</li>
                                                                    <li>TB : {{ $asesmen['p_tb'] }} / cm</li>
                                                                    <li>BB : {{ $asesmen['p_bb'] }} / kg</li>
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $diagnosaPrimer = json_decode(
                                                                        $asesmen['soap_a_primer'],
                                                                        true,
                                                                    );
                                                                    $diagnosaPrimer = array_values($diagnosaPrimer); // menghapus kunci asosiatif
                                                                    $diagnosaSekunder = json_decode(
                                                                        $asesmen['soap_a_sekunder'],
                                                                        true,
                                                                    );
                                                                    $diagnosaSekunder = array_values($diagnosaSekunder); // menghapus kunci asosiatif
                                                                    // dd($diagnosaPrimer);
                                                                @endphp
                                                                <p style="font-weight: bold">Diagnosa Primer</p>
                                                                @foreach ($diagnosaPrimer as $diag)
                                                                    <ul>
                                                                        <li>{{ $diag }}</li>
                                                                    </ul>
                                                                @endforeach
                                                                <p style="font-weight: bold">Diagnosa Sekunder</p>
                                                                @if ($diagnosaSekunder != null)
                                                                    @foreach ($diagnosaSekunder as $diagn)
                                                                        <ul>
                                                                            <li>{{ $diagn }}</li>
                                                                        </ul>
                                                                    @endforeach
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <p style="font-weight: bold; margin-bottom: -0px">Resep :
                                                                </p>
                                                                <p style="font-weight: bold; margin-bottom: -0px">- Non
                                                                    Racikan</p>
                                                                @php
                                                                    $resep = json_decode($item['soap_p'], true); // Mendecode data JSON obat
                                                                    $aturan = json_decode($item['soap_p_aturan'], true); // Mendecode data JSON aturan
                                                                @endphp

                                                                @if (is_array($resep) && is_array($aturan))
                                                                    @if (count($resep) == count($aturan))
                                                                        @foreach ($resep as $obat => $namaObat)
                                                                            @php
                                                                                // Ambil aturan minum yang sesuai berdasarkan nama obat
                                                                                $aturanMinum = $aturan[$obat];
                                                                            @endphp
                                                                            <ul>
                                                                                <li>{{ $namaObat }} |
                                                                                    {{ $aturanMinum }}</li>
                                                                            </ul>
                                                                            <!-- Menampilkan nama obat, jumlah, dan aturan minum -->
                                                                        @endforeach
                                                                    @else
                                                                        <p>-</p>
                                                                    @endif
                                                                @else
                                                                    <p>-</p>
                                                                @endif

                                                                <p style="font-weight: bold; margin-bottom: -0px">- Racikan
                                                                    (Puyer)
                                                                </p>

                                                                @php
                                                                    $obatRacikan = json_decode($item['soap_r'], true);
                                                                    $takaran = json_decode(
                                                                        $item['soap_r_takaran'],
                                                                        true,
                                                                    );
                                                                    // dd($obatRacikan);
                                                                @endphp

                                                                @if (is_array($obatRacikan) && is_array($takaran))
                                                                    @if (count($obatRacikan) == 0 && count($takaran) == 0)
                                                                        <p>-</p>
                                                                    @elseif(count($obatRacikan) == count($takaran))
                                                                        @for ($i = 0; $i < count($obatRacikan); $i++)
                                                                            <ul>
                                                                                <li>{{ array_keys($obatRacikan)[$i] }} -
                                                                                    {{ array_values($obatRacikan)[$i] }}
                                                                                </li>
                                                                            </ul>
                                                                        @endfor
                                                                    @else
                                                                        <p>
                                                                        <ul>
                                                                            <li></li>
                                                                        </ul>
                                                                        </p>
                                                                    @endif
                                                                @else
                                                                    <p>
                                                                    <ul>
                                                                        <li></li>
                                                                    </ul>
                                                                    </p>
                                                                @endif

                                                                {{-- @foreach ($allSoapPatients as $key => $patientName)
                                                            <ul>
                                                                @if (isset(json_decode($item['soap_p'], true)[$patientName]))
                                                                    <li>{{ $patientName }} - {{ $keterangan[$key] }} - {{ json_decode($item['soap_p'], true)[$patientName] }} </li>
                                                                @endif
                                                            </ul>
                                                        @endforeach --}}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                            <td>{{ $asesmen['edukasi'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                data-bs-toggle="modal" data-bs-target="#riwayatModal{{ $asesmen->id }}">Kembali</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- TAMPILKAN LEWATI --}}
    @foreach ($pasien as $item)
        <div class="modal fade" id="lewati{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Lewati Pasien
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Apakah Anda yakin ingin melewati pasien ini?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <form action="{{ url('perawat/lewati/' . $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-primary">Lewati</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal PASIEN UMUM -->
    <div class="modal fade" id="pasienumum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Pendaftaran Pasien
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_rm">Poli</label>
                        <select name="poli" id="poli_umum" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Poli</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Dokter</label>
                        <select name="dokter" id="dokter_umum" class="form-control mt-2 mb-2">
                            <option value="#">Pilih Dokter</option>
                            {{-- @foreach ($dokter as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_dokter }}</option>
                @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="search_pasien">Nama Pasien</label>
                        <input type="text" class="form-control mt-2 mb-2" name="search_pasien" id="search_pasien"
                            placeholder="Masukkan Nama Pasien" required>
                        <div id="autocomplete-results"></div>

                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control mt-2 mb-2 @error('nik') is-invalid @enderror"
                            name="nik" id="nik" placeholder="Masukkan NIK" required>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_kk">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk"
                            placeholder="Masukkan Nama Kepala Keluarga" required>
                    </div>
                    <div class="form-group">
                        <label for="tgllahir">Tanggal Lahir</label>
                        <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir" required>
                    </div>
                    <div class="form-group">
                        <label for="jekel">Jenis Kelamin</label>
                        <select name="jekel" id="jekel" class="form-control mt-2 mb-2" required>
                            <option value="" disabled selected>Pilih Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Asal</label>
                        <input type="text" class="form-control mt-2 mb-2" name="alamat_asal" id="alamat_asal"
                            placeholder="Masukkan Alamat Asal" required>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control mt-2 mb-2" name="pekerjaan" id="pekerjaan"
                            placeholder="Masukkan Pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Domisili</label>
                        <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisili"
                            placeholder="Masukkan Alamat Domisili" required>
                    </div>
                    <div class="form-group">
                        <label for="noHP">No. HP</label>
                        <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHP"
                            placeholder="Masukkan No. HP" required>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-primary" id="btnSimpan" onclick="saveData()">
                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PASIEN BPJS -->
    <div class="modal fade" id="pasienbpjs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienlama" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Pendaftaran Pasien</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_rm">Poli</label>
                        <select name="poli" id="poli_bpjs" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Poli</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Dokter</label>
                        <select name="dokter" id="dokter_bpjs" class="form-control mt-2 mb-2">
                            <option value="#">Pilih Dokter</option>
                            {{-- @foreach ($dokter as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_dokter }}</option>
                        @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="norm">No. BPJS</label>
                        <div class="cari mt-2 mb-2" style="display: flex; align-items: center">
                            <input type="text" class="form-control mb-2" name="norm" id="norm"
                                placeholder="Masukkan No.BPJS">
                            <div id="autocompletebpjs-results"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="search_pasien">Nama Pasien</label>
                        <input type="text" class="form-control mt-2 mb-2" name="search_pasien" id="nama_pasienbpjs"
                            placeholder="Masukkan Nama Pasien" required>
                        <div id="autocomplete-results"></div>

                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control mt-2 mb-2 @error('nik') is-invalid @enderror"
                            name="nik" id="nikbpjs" placeholder="Masukkan NIK" required>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_kk">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kkbpjs"
                            placeholder="Masukkan Nama Kepala Keluarga" required>
                    </div>
                    <div class="form-group">
                        <label for="tgllahir">Tanggal Lahir</label>
                        <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahirbpjs" required>
                    </div>
                    <div class="form-group">
                        <label for="jekel">Jenis Kelamin</label>
                        <select name="jekel" id="jekelbpjs" class="form-control mt-2 mb-2" required>
                            <option value="" disabled selected>Pilih Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Asal</label>
                        <input type="text" class="form-control mt-2 mb-2" name="alamat_asal" id="alamat_asalbpjs"
                            placeholder="Masukkan Alamat Asal" required>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control mt-2 mb-2" name="pekerjaan" id="pekerjaanbpjs"
                            placeholder="Masukkan Pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Domisili</label>
                        <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisilibpjs"
                            placeholder="Masukkan Alamat Domisili" required>
                    </div>
                    <div class="form-group">
                        <label for="noHP">No. HP</label>
                        <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHPbpjs"
                            placeholder="Masukkan No. HP" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpanBpjs" onclick="saveDataBpjs()">
                        <span id="loadingSpinnerLama" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal jumlah pasien --}}
    <div class="modal fade" id="jmlhpasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Jumlah Pasien</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="total" style="margin-top: -10px">
                        <td><strong>Total Pasien</strong> : </td>
                        <td><span style="font-size: 15px; font-weight: bold;">{{ $totalpasien }}</span></td>
                    </div>
                    <div class="date-time">
                        <div class="row">
                            <div class="col-lg-6" style="font-size: 12px; font-weight: bold">
                                <div class="tanggal" id="tanggal"></div>
                            </div>
                            <div class="col-lg-6" style="text-align: end; font-size: 20px; font-weight: bold">
                                <div class="jam" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div id="stats-container">
                        <div class="stat-box">
                            <p class="stat-title">Pasien Umum</p>
                            <p class="stat-value">{{ $pasienHariniUmum }}</p>
                        </div>
                        <div class="stat-box">
                            <p class="stat-title">Pasien BPJS</p>
                            <p class="stat-value">{{ $pasienHariniBpjs }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('perawat.kunjunganSehat.modalSehat')
    @include('perawat.kunjunganOnline.modalOnline')

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
    {{-- <script src="{{ asset('assets/responsivevoice.js') }}"></script> --}}
    <script src="{{ asset('assets/js/antrian.script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script> <!-- Pastikan ini yang terakhir -->

    <script>
        // SHIFT
        document.addEventListener("DOMContentLoaded", function() {
            function checkShift() {
                let now = new Date();
                let hours = now.getHours();

                let shiftPagi = document.getElementById("shiftPagi");
                let shiftSiang = document.getElementById("shiftSiang");
                let shiftTotal = document.getElementById("shiftReportTotal"); // Tambahkan elemen total shift

                let tanggalHariIni = now.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                // Atur tanggal di tabel shift pagi dan siang
                document.getElementById("tanggalShiftPagi").innerText = tanggalHariIni;
                document.getElementById("tanggalShiftSiang").innerText = tanggalHariIni;

                // Reset tampilan semua shift
                shiftPagi.style.display = "none";
                shiftSiang.style.display = "none";
                shiftTotal.style.display = "none";

                // Tampilkan tabel sesuai shift
                if (hours >= 7 && hours < 12) {
                    // Shift Pagi (07:00 - 12:00)
                    shiftPagi.style.display = "block";
                } else if (hours >= 12 && hours < 17) {
                    // Shift Siang (12:00 - 17:00)
                    shiftSiang.style.display = "block";
                } else {
                    // Setelah 17:00, tampilkan total pasien
                    shiftTotal.style.display = "block";
                }
            }

            checkShift(); // Jalankan saat halaman dimuat
            setInterval(checkShift, 60000); // Perbarui setiap 1 menit
        });

        // TANGGAL SHIFT
        function updateTanggal() {
            var now = new Date();

            // Opsi format tanggal dan hari
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            };

            // Mengambil elemen HTML untuk shift pagi dan siang
            var tanggalPagiElement = document.getElementById('tanggalShiftPagi');
            var tanggalSiangElement = document.getElementById('tanggalShiftSiang');

            // Format tanggal lengkap dengan nama hari
            var tanggalLengkap = now.toLocaleDateString('id-ID', options);

            // Menampilkan tanggal pada elemen yang sesuai
            tanggalPagiElement.textContent = tanggalLengkap;
            tanggalSiangElement.textContent = tanggalLengkap;
        }

        // Panggil fungsi saat halaman dimuat
        updateTanggal();

        // jam dan tgl
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

        // Tampilkan modal jumlah pasien
        function togglePopup() {
            $('#jmlhpasien').modal('toggle');
            // Anda bisa menambahkan logika tambahan di sini jika diperlukan
        }

        $(document).ready(function() {
            // Set up CSRF token for every AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        // Kode pasien umum
        $(document).ready(function() {
            $('#poli_umum').change(function() {
                var poli_id = $(this).val();
                if (poli_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('get-dokter-by-poli') }}/" + poli_id,
                        success: function(res) {
                            if (res) {
                                $("#dokter_umum").empty();
                                $.each(res, function(key, value) {
                                    $("#dokter_umum").append('<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            } else {
                                $("#dokter_umum").empty();
                            }
                        }
                    });
                } else {
                    $("#dokter_umum").empty();
                }
            });
        });

        $(document).ready(function() {
            $('#search_pasien').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: '/search_nama_pasien',
                        method: 'GET',
                        data: {
                            nama: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.nama_pasien + ' - ' + item
                                        .nama_kk + ' - ' + item.alamat_asal,
                                    value: item.no_rm
                                };
                            }));
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    $('#search_pasien').val(ui.item.label.split(' - ')[0]);
                    var selected_no_rm = ui.item.value;

                    $.ajax({
                        url: '/get_pasien_details',
                        method: 'GET',
                        data: {
                            no_rm: selected_no_rm
                        },
                        success: function(response) {
                            // $('#no_rm').val(response.no_rm);
                            $('#nik').val(response.nik);
                            $('#nama_kk').val(response.nama_kk);
                            $('#tgllahir').val(response.tgllahir);
                            $('#jekel').val(response.jekel);
                            $('#alamat_asal').val(response.alamat_asal);
                            $('#pekerjaan').val(response.pekerjaan);
                            $('#domisili').val(response.domisili);
                            $('#noHP').val(response.noHP);
                        }
                    });
                    return false;
                },
                appendTo: "#autocomplete-results" // Menetapkan elemen yang akan menampung hasil autocomplete
            }).focus(function() {
                $(this).autocomplete("search", "");
            });
        });

        function saveData() {
            // Menampilkan efek loading
            $('#loadingSpinner').removeClass('d-none');
            $('#btnSimpan').prop('disabled', true); // Menonaktifkan tombol selama proses loading
            var formData = {
                poli: document.getElementById('poli_umum').value,
                dokter: document.getElementById('dokter_umum').value,
                nama_pasien: document.getElementById('search_pasien').value,
                // no_rm: document.getElementById('no_rm').value,
                nik: document.getElementById('nik').value,
                nama_kk: document.getElementById('nama_kk').value,
                pekerjaan: document.getElementById('pekerjaan').value,
                tgllahir: document.getElementById('tgllahir').value,
                jekel: document.getElementById('jekel').value,
                alamat_asal: document.getElementById('alamat_asal').value,
                domisili: document.getElementById('domisili').value,
                noHP: document.getElementById('noHP').value,
            };

            // Melakukan validasi
            var errorMessages = [];

            // Validasi khusus
            if (!formData.poli) {
                errorMessages.push("- Poli harus dipilih.");
            }
            if (!formData.dokter) {
                errorMessages.push("- Dokter harus dipilih.");
            }
            // if (!formData.no_rm) {
            //     errorMessages.push("- No. RM harus diisi.");
            // }
            if (!formData.nama_pasien) {
                errorMessages.push("- Nama Pasien harus diisi.");
            }
            if (!formData.nik) {
                errorMessages.push("- NIK harus diisi.");
            }
            if (!formData.nama_kk) {
                errorMessages.push("- Nama Kepala Keluarga harus diisi.");
            }
            if (!formData.tgllahir) {
                errorMessages.push("- Tanggal Lahir harus diisi.");
            }
            if (!formData.jekel) {
                errorMessages.push("- Jenis kelamin harus dipilih.");
            }
            if (!formData.alamat_asal) {
                errorMessages.push("- Alamat Asal harus diisi.");
            }
            if (!formData.pekerjaan) {
                errorMessages.push("- Pekerjaan harus diisi.");
            }
            if (!formData.domisili) {
                errorMessages.push("- Alamat Domisili harus diisi.");
            }
            if (!formData.noHP) {
                errorMessages.push("- No. HP harus diisi.");
            }
            // Jika ada error, menampilkan pesan kesalahan
            if (errorMessages.length > 0) {
                $('#loadingSpinner').addClass('d-none');
                $('#btnSimpan').prop('disabled', false);
                alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                return; // Menghentikan eksekusi fungsi jika ada error
            }

            // console.log(formData);
            $.ajax({
                url: '/perawat/store-umum', // Ganti dengan URL backend Anda
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Check if the server response contains the 'redirect' key
                    if (response.redirect) {
                        // Redirect to the specified URL
                        window.location.href = response.redirect;
                    } else {
                        // If no redirect URL is provided, you can handle it accordingly
                        console.error('No redirect URL provided in the server response.');
                    }

                },
                error: function(jqXHR) {
                    // Menyembunyikan efek loading
                    $('#loadingSpinner').addClass('d-none');
                    $('#btnSimpan').prop('disabled', false); // Mengaktifkan tombol setelah proses loading

                    if (jqXHR.status == 422) {
                        var errors = jqXHR.responseJSON;
                        var errorMessages = [];
                        $.each(errors, function(key, value) {
                            errorMessages.push(value);
                        });
                        // Menampilkan pesan kesalahan dengan alert
                        alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                    } else {
                        console.error('Error saat menyimpan data pasien: ', jqXHR);
                        // Handle error sesuai kebutuhan Anda
                    }
                }
            });
        }
        //end code pasien umum

        // kode pasien bpjs
        $(document).ready(function() {
            $('#poli_bpjs').change(function() {
                var poli_id = $(this).val();
                if (poli_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('get-dokter-by-poli') }}/" + poli_id,
                        success: function(res) {
                            if (res) {
                                $("#dokter_bpjs").empty();
                                $.each(res, function(key, value) {
                                    $("#dokter_bpjs").append('<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            } else {
                                $("#dokter_bpjs").empty();
                            }
                        }
                    });
                } else {
                    $("#dokter_bpjs").empty();
                }
            });
        });

        $(document).ready(function() {
            $('#norm').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: '/search_pasien_bpjs',
                        method: 'GET',
                        data: {
                            nama: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.nama_pasien + ' - ' + item
                                        .bpjs + ' - ' + item.nik,
                                    value: item.no_rm
                                };
                            }));
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error: " + status + ' - ' + error);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#norm').val(ui.item.label.split(' - ')[1]);
                    var selected_no_rm = ui.item.value;

                    $.ajax({
                        url: '/get_pasien_bpjs',
                        method: 'GET',
                        data: {
                            bpjs: selected_no_rm
                        },
                        success: function(response) {
                            // Menampilkan response dari controller di modal
                            $('#nama_pasienbpjs').val(response.nama_pasien);
                            $('#nikbpjs').val(response.nik);
                            $('#nama_kkbpjs').val(response.nama_kk);
                            $('#tgllahirbpjs').val(response.tgllahir);
                            $('#jekelbpjs').val(response.jekel);
                            $('#alamat_asalbpjs').val(response.alamat_asal);
                            $('#pekerjaanbpjs').val(response.pekerjaan);
                            $('#domisilibpjs').val(response.domisili);
                            $('#noHPbpjs').val(response.noHP);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error: " + status + ' - ' + error);
                        }
                    });
                    return false;
                },
                appendTo: "#autocompletebpjs-results" // Menetapkan elemen yang akan menampung hasil autocomplete
            });
        });

        function saveDataBpjs() {
            // Menampilkan efek loading
            $('#loadingSpinnerLama').removeClass('d-none');
            $('#simpanBpjs').prop('disabled', true); // Menonaktifkan tombol selama proses loading
            var formData = {
                poli: document.getElementById('poli_bpjs').value,
                dokter: document.getElementById('dokter_bpjs').value,
                bpjs: document.getElementById('norm').value,
                nama_pasien: document.getElementById('nama_pasienbpjs').value,
                nik: document.getElementById('nikbpjs').value,
                nama_kk: document.getElementById('nama_kkbpjs').value,
                pekerjaan: document.getElementById('pekerjaanbpjs').value,
                tgllahir: document.getElementById('tgllahirbpjs').value,
                jekel: document.getElementById('jekelbpjs').value,
                alamat_asal: document.getElementById('alamat_asalbpjs').value,
                domisili: document.getElementById('domisilibpjs').value,
                noHP: document.getElementById('noHPbpjs').value,
            };
            console.log(formData);
            // Melakukan validasi
            var errorMessages = [];

            // Validasi khusus
            if (!formData.poli) {
                errorMessages.push("- Poli harus dipilih.");
            }
            if (!formData.dokter) {
                errorMessages.push("- Dokter harus dipilih.");
            }
            if (!formData.bpjs) {
                errorMessages.push("- No. BPJS harus diisi.");
            }

            // Jika ada error, menampilkan pesan kesalahan
            if (errorMessages.length > 0) {
                $('#loadingSpinnerLama').addClass('d-none');
                $('#simpanBpjs').prop('disabled', false);
                alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                return; // Menghentikan eksekusi fungsi jika ada error
            }
            // console.log(formData);
            $.ajax({
                url: '/perawat/store-bpjs', // Ganti dengan URL backend Anda
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Check if the server response contains the 'redirect' key
                    if (response.redirect) {
                        // Redirect to the specified URL
                        window.location.href = response.redirect;
                    } else {
                        // If no redirect URL is provided, you can handle it accordingly
                        console.error('No redirect URL provided in the server response.');
                    }

                },
                error: function(jqXHR) {
                    // Menyembunyikan efek loading
                    $('#loadingSpinnerLama').addClass('d-none');
                    $('#simpanBpjs').prop('disabled', false); // Mengaktifkan tombol setelah proses loading

                    if (jqXHR.status == 422) {
                        var errors = jqXHR.responseJSON;
                        var errorMessages = [];
                        $.each(errors, function(key, value) {
                            errorMessages.push(value);
                        });
                        // Menampilkan pesan kesalahan dengan alert
                        alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                    } else {
                        console.error('Error saat menyimpan data pasien: ', jqXHR);
                        // Handle error sesuai kebutuhan Anda
                    }
                }
            });
        }

        // Get the input fields
        var gcs_e = document.getElementById('gcs_e');
        var gcs_m = document.getElementById('gcs_m');
        var gcs_v = document.getElementById('gcs_v');
        var gcs_total = document.getElementById('gcs_total');

        // Function to calculate the total GCS score
        function calculateTotal() {
            var e = parseFloat(gcs_e.value) || 0;
            var m = parseFloat(gcs_m.value) || 0;
            var v = parseFloat(gcs_v.value) || 0;

            var totalInput = e + m + v;

            // // Jika total input lebih dari 0, maka normalkan nilai input agar total selalu 15
            // if (totalInput > 0) {
            //     e = (e / totalInput) * 15;
            //     m = (m / totalInput) * 15;
            //     v = (v / totalInput) * 15;
            // } else {
            //     e = m = v = 0; // Jika semua input 0, totalnya tetap 0
            // }

            // var total = e + m + v;
            // gcs_total.textContent = Math.round(total); // Membulatkan hasil ke bilangan bulat

            // Jika total input melebihi 15, normalkan nilai sehingga totalnya menjadi 15
            if (totalInput > 15) {
                var ratio = 15 / totalInput;
                e = e * ratio;
                m = m * ratio;
                v = v * ratio;
                totalInput = 15; // Update totalInput untuk mencerminkan nilai yang sudah dinormalisasi
            }

            // Hitung total akhir
            var total = e + m + v;
            gcs_total.textContent = Math.round(total); // Membulatkan hasil ke bilangan bulat
        }

        // Listen for input changes and recalculate total
        gcs_e.addEventListener('input', calculateTotal);
        gcs_m.addEventListener('input', calculateTotal);
        gcs_v.addEventListener('input', calculateTotal);

        // Initial calculation
        calculateTotal();

        // Mendapatkan nilai tinggi badan dan berat badan dari inputan
        var tbInput = document.getElementById('p_tb');
        var bbInput = document.getElementById('p_bb');
        var imtInput = document.getElementById('p_imt');

        // Event listener untuk menghitung IMT setiap kali input berubah
        tbInput.addEventListener('input', hitungIMT);
        bbInput.addEventListener('input', hitungIMT);

        function hitungIMT() {
            // Mengambil nilai tinggi badan dan berat badan dari inputan
            var tb = parseFloat(tbInput.value);
            var bb = parseFloat(bbInput.value);

            // Memastikan bahwa tinggi badan dan berat badan valid
            if (!isNaN(tb) && !isNaN(bb) && tb > 0 && bb > 0) {
                // Menghitung IMT
                var imt = bb / ((tb / 100) * (tb / 100));
                // Menetapkan nilai IMT ke inputan IMT
                imtInput.value = imt.toFixed(2); // Memformat menjadi dua desimal
            } else {
                // Jika ada input yang tidak valid, atur nilai IMT menjadi kosong
                imtInput.value = '';
            }
        }

        // Mendapatkan nilai tinggi badan dan berat badan dari inputan
        var tblmInput = document.getElementById('tb');
        var bblmInput = document.getElementById('bb');
        var imtlmInput = document.getElementById('l_imt');

        // Event listener untuk menghitung IMT setiap kali input berubah
        tblmInput.addEventListener('input', hitungIMTLama);
        bblmInput.addEventListener('input', hitungIMTLama);

        function hitungIMTLama() {
            // Mengambil nilai tinggi badan dan berat badan dari inputan
            var tb = parseFloat(tblmInput.value);
            var bb = parseFloat(bblmInput.value);

            // Memastikan bahwa tinggi badan dan berat badan valid
            if (!isNaN(tb) && !isNaN(bb) && tb > 0 && bb > 0) {
                // Menghitung IMT
                var imt = bb / ((tb / 100) * (tb / 100));
                // Menetapkan nilai IMT ke inputan IMT
                imtlmInput.value = imt.toFixed(2); // Memformat menjadi dua desimal
            } else {
                // Jika ada input yang tidak valid, atur nilai IMT menjadi kosong
                imtlmInput.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Menambahkan event listener untuk penutupan modal kedua
            document.querySelectorAll('.modal').forEach(function(modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    // Menghapus kelas 'show' dari modal yang terakhir ditutup
                    modal.classList.remove('show');
                    // Menghapus kelas 'modal-open' dari body
                    document.body.classList.remove('modal-open');
                    // Menghapus backdrop secara langsung dari DOM
                    var backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.parentNode.removeChild(backdrop);
                    }
                });
            });
        });

        function toggleStep(element) {
            const step = element.parentElement;
            step.classList.toggle('opened');
            const icon = element.querySelector('i');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }
    </script>
@endpush
