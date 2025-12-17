<x-admin.layout.terminal title="Perawat">

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
                                            <button type="button" class="btn-close text-reset"
                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                            <div class="text-center mb-3">
                                                <h4 class="mb-3"><strong>Update Pasien</strong></h4>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div class="text-center d-flex flex-column align-items-center">
                                                        <!-- Teks dan ikon di atas -->
                                                        <span class="badge border text-success fs-6 p-3">
                                                            <i class="fa-solid fa-check-circle"></i> Dilayani:
                                                            <span id="pasienDilayani"
                                                                style="font-size: 25px">{{ $pasienDilayani }}</span>
                                                        </span>
                                                        <!-- Gambar di bawah -->
                                                        <img src="{{ asset('aset/img/periksa.jpg') }}"
                                                            alt="Pasien DIlayani" style="width: 60%; height: auto;">
                                                    </div>
                                                    <div class="text-center d-flex flex-column align-items-center">
                                                        <!-- Teks dan ikon di atas -->
                                                        <span class="badge border text-warning fs-6 p-3">
                                                            <i class="fa-solid fa-times-circle"></i> Belum Dilayani:
                                                            <span id="pasienBelumDilayani"
                                                                style="font-size: 25px">{{ $pasienBelumDilayani }}</span>
                                                        </span>
                                                        <!-- Gambar di bawah -->
                                                        <img src="{{ asset('aset/img/check.jpg') }}"
                                                            alt="Pasien Belum Dilayani"
                                                            style="width: 60%; height: auto;">
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
                                                                <td id="poliUmumBpjsPagi" class="text-center">
                                                                    {{ $countShiftPagiUmumBPJS }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumPagi" class="text-center">
                                                                    {{ $countShiftPagiUmumUmum }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsPagi" class="text-center">
                                                                    {{ $countShiftPagiGigiBPJS }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumPagi" class="text-center">
                                                                    {{ $countShiftPagiGigiUmum }}
                                                                </td>
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
                                                                <td id="poliUmumBpjsSiang" class="text-center">
                                                                    {{ $countShiftSiangUmumBPJS }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumSiang" class="text-center">
                                                                    {{ $countShiftSiangUmumUmum }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsSiang" class="text-center">
                                                                    {{ $countShiftSiangGigiBpjs }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumSiang" class="text-center">
                                                                    {{ $countShiftSiangGigiUmum }}
                                                                </td>
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
                                                                <th class="text-center">PASIEN SHIFT PAGI DAN SIANG
                                                                </th>
                                                                <th class="text-center">KET.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                                <td id="poliUmumBpjsTotal" style="text-align: center">
                                                                    {{ $totalPoliUmumPasienBPJS }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumTotal" style="text-align: center">
                                                                    {{ $totalPoliUmumPasienUmum }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsTotal" style="text-align: center">
                                                                    {{ $totalPoliGigiPasienBPJS }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumTotal" style="text-align: center">
                                                                    {{ $totalPoliGigiPasienUmum }}</td>
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
                                                    <a href="{{ url('perawat/rekap/harian') }}"
                                                        class="btn btn-primary w-100">
                                                        <i class="menu-icon tf-icons fa-solid fa-folder"></i> Menu
                                                        Rekap
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
                            <div class="table-responsive">
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
                                            <th>Umur</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center; text-transform: uppercase;">
                                        @if (count($pasien) === 0)
                                            <tr>
                                                <td colspan="10" style="text-align: center; font-size: bold">Belum
                                                    ada
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
                                                            <button
                                                                data-nomor-antrian-perawat="{{ $item->kode_antrian }}"
                                                                data-poli="{{ $item->poli->namapoli }}"
                                                                class="btn btn-success btn-panggil-perawat mb-1"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
                                                                <i class="fas fa-bell"></i>
                                                            </button>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
                                                                <button type="button" class="btn btn-secondary mb-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#lewati{{ $item->id }}">
                                                                    <i class="fa-solid fa-forward"></i>
                                                                </button>
                                                            </span>
                                                            <button type="button" class="btn btn-primary mb-1"
                                                                onclick="Livewire.emit('openAsesmenModal', {{ $item->id }})">
                                                                <i class="fas fa-pen"></i>
                                                            </button>

                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
                                                                <button type="button" class="btn btn-info mb-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#riwayatModal{{ $item->id }}">
                                                                    <i class="fas fa-info"></i>
                                                                </button>
                                                            </span>
                                                            <a href="{{ url('cetak-antrianPerawat/' . $item->id) }}"
                                                                class="btn btn-warning mb-1" target="_blank"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
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
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age }}
                                                            Tahun
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill">
                                                                Datang
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                                {{-- <script>
                                                    // Tanda Tangan
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const select = document.getElementById('ak_nama_perawat_bidan');
                                                        const image = document.getElementById('ttd_perawat_image');

                                                        // Jika salah satu elemen tidak ditemukan, hentikan tanpa error
                                                        if (!select || !image) return;

                                                        select.addEventListener('change', function() {
                                                            const selectedOption = select.options[select.selectedIndex];
                                                            const imageSrc = selectedOption.getAttribute('data-image');

                                                            if (imageSrc) {
                                                                image.src = imageSrc;
                                                                image.style.display = 'block';
                                                            } else {
                                                                image.removeAttribute('src');
                                                                image.style.display = 'none';
                                                            }
                                                        });

                                                        // Jalankan sekali untuk inisialisasi awal
                                                        if (select.options.length > 0) {
                                                            select.dispatchEvent(new Event('change'));
                                                        }
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
                                                </script> --}}
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="halaman d-flex justify-content-end">
                                {{ $pasien->appends(request()->only(['search', 'entries']))->links() }}
                            </div>
                            <livewire:perawat.asesmen-pasien-modal />
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
                                    <option value="10"
                                        {{ request('periksa_entries', 10) == 10 ? 'selected' : '' }}>10
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
                            <table class="table table-striped table-bordered"
                                style="background-color: white; white-space: nowrap;">
                                <thead class="table-secondary" style="text-align: center; width: auto">
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl/Jam</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>No. Antrian</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Pasien</th>
                                        <th>Umur</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center; text-transform: uppercase;">
                                    @if (count($periksa) == 0)
                                        <tr>
                                            <td colspan="9" style="text-align: center">Tidak Ada Data Pasien</td>
                                        </tr>
                                    @else
                                        <?php $no = 1; ?>
                                        @foreach ($periksa as $item)
                                            @if ($item->status == 'M')
                                                <tr id="row_{{ $item->id }}">
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y / H:i') }}
                                                    </td>
                                                    <td>{{ $item->booking->pasien->no_rm }}</td>
                                                    <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                    <td>{{ $item->kode_antrian }}</td>
                                                    <td>{{ $item->poli->namapoli }}</td>
                                                    <td>{{ $item->dokter->nama_dokter }}</td>
                                                    <td>{{ $item->booking->pasien->domisili }}</td>
                                                    <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age }}
                                                        Tahun
                                                    </td>
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
                        </div>
                        <div class="page d-flex justify-content-end">
                            {{ $periksa->appends(request()->only(['periksa_search', 'periksa_entries']))->links() }}
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="asesmen">
                            <table class="table table-bordered">
                                <thead class="table-info">
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
                                                        data-toggle="tooltip" data-bs-placement="top"
                                                        title="Asesmen">
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
                <div class="modal-dialog modal-lg" style="display: contents">
                    <div class="modal-content" style="margin-top: 20px; width: 95%; margin-left: 3%;">
                        <div class="modal-header bg-primary">
                            <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">
                                Detail Asesmen
                                Tanggal:
                                {{ $asesmen->created_at ? date_format(date_create($asesmen->created_at), 'd-m-Y') : 'N/A' }}
                            </h1>
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
                                            <td>{{ $asesmen->created_at ? date_format(date_create($asesmen->created_at), 'Y-m-d H:i:s') : 'N/A' }}
                                            </td>
                                            <td>{{ $asesmen->nama_dokter ?? 'N/A' }}</td>
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
                                                            <td>{{ $asesmen->keluhan_utama ?? 'N/A' }}</td>
                                                            <td>
                                                                <ul>
                                                                    <li>Tensi: {{ $asesmen->p_tensi ?? 'N/A' }} mmHg
                                                                    </li>
                                                                    <li>RR: {{ $asesmen->p_rr ?? 'N/A' }} / minute</li>
                                                                    <li>Nadi: {{ $asesmen->p_nadi ?? 'N/A' }} / minute
                                                                    </li>
                                                                    <li>Suhu: {{ $asesmen->p_suhu ?? 'N/A' }} °C</li>
                                                                    <li>TB: {{ $asesmen->p_tb ?? 'N/A' }} cm</li>
                                                                    <li>BB: {{ $asesmen->p_bb ?? 'N/A' }} kg</li>
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $diagnosaPrimer = !empty($asesmen->soap_a_primer)
                                                                        ? json_decode($asesmen->soap_a_primer, true)
                                                                        : [];
                                                                    $diagnosaSekunder = !empty(
                                                                        $asesmen->soap_a_sekunder
                                                                    )
                                                                        ? json_decode($asesmen->soap_a_sekunder, true)
                                                                        : [];
                                                                    $diagnosaPrimer = is_array($diagnosaPrimer)
                                                                        ? array_values($diagnosaPrimer)
                                                                        : [];
                                                                    $diagnosaSekunder = is_array($diagnosaSekunder)
                                                                        ? array_values($diagnosaSekunder)
                                                                        : [];
                                                                @endphp
                                                                <p style="font-weight: bold">Diagnosa Primer</p>
                                                                @if (!empty($diagnosaPrimer))
                                                                    @foreach ($diagnosaPrimer as $diag)
                                                                        <ul>
                                                                            <li>{{ $diag }}</li>
                                                                        </ul>
                                                                    @endforeach
                                                                @else
                                                                    <p>-</p>
                                                                @endif
                                                                <p style="font-weight: bold">Diagnosa Sekunder</p>
                                                                @if (!empty($diagnosaSekunder))
                                                                    @foreach ($diagnosaSekunder as $diagn)
                                                                        <ul>
                                                                            <li>{{ $diagn }}</li>
                                                                        </ul>
                                                                    @endforeach
                                                                @else
                                                                    <p>-</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <p style="font-weight: bold; margin-bottom: 0">Resep:
                                                                </p>
                                                                <p style="font-weight: bold; margin-bottom: 0">Non
                                                                    Racikan
                                                                </p>
                                                                @php
                                                                    $resep = !empty($asesmen->soap_p)
                                                                        ? json_decode($asesmen->soap_p, true)
                                                                        : [];
                                                                    $aturan = !empty($asesmen->soap_p_aturan)
                                                                        ? json_decode($asesmen->soap_p_aturan, true)
                                                                        : [];
                                                                @endphp
                                                                @if (is_array($resep) && is_array($aturan) && count($resep) == count($aturan) && !empty($resep))
                                                                    @foreach ($resep as $obat => $namaObat)
                                                                        @php
                                                                            $aturanMinum = $aturan[$obat] ?? 'N/A';
                                                                        @endphp
                                                                        <ul>
                                                                            <li>{{ $namaObat }} |
                                                                                {{ $aturanMinum }}
                                                                            </li>
                                                                        </ul>
                                                                    @endforeach
                                                                @else
                                                                    <p>-</p>
                                                                @endif

                                                                <p style="font-weight: bold; margin-bottom: 0">Racikan
                                                                    (Puyer)
                                                                </p>
                                                                @php
                                                                    $obatRacikan = !empty($asesmen->soap_r)
                                                                        ? json_decode($asesmen->soap_r, true)
                                                                        : [];
                                                                    $takaran = !empty($asesmen->soap_r_takaran)
                                                                        ? json_decode($asesmen->soap_r_takaran, true)
                                                                        : [];
                                                                @endphp
                                                                @if (is_array($obatRacikan) && is_array($takaran) && count($obatRacikan) > 0 && count($obatRacikan) == count($takaran))
                                                                    @foreach ($obatRacikan as $namaObat => $jumlah)
                                                                        <ul>
                                                                            <li>{{ $namaObat }} -
                                                                                {{ $jumlah }}
                                                                                ({{ $takaran[$namaObat] ?? 'N/A' }})
                                                                            </li>
                                                                        </ul>
                                                                    @endforeach
                                                                @else
                                                                    <p>-</p>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>{{ $asesmen->edukasi ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- Asumsikan kembali ke modal riwayat pasien yang sesuai -->
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali</button>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Lewati
                            Pasien
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Pendaftaran
                        Pasien
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
                        <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir"
                            required>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Pendaftaran Pasien
                    </h1>
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
                        <input type="text" class="form-control mt-2 mb-2" name="search_pasien"
                            id="nama_pasienbpjs" placeholder="Masukkan Nama Pasien" required>
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
                        <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahirbpjs"
                            required>
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

    @include('perawat.kunjunganSehat.modalSehat')
    @include('perawat.kunjunganOnline.modalOnline')

    @push('style')
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
        <script src="{{ asset('aset/js/popper/popper.min.js') }}"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> --}}
        <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
        {{-- <script src="{{ asset('assets/responsivevoice.js') }}"></script> --}}
        <script src="{{ asset('assets/js/antrian.script.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>

        <script>
            // SHIFT
            document.addEventListener("DOMContentLoaded", function() {
                function checkShift() {
                    let now = new Date();
                    let hours = now.getHours();

                    let shiftPagi = document.getElementById("shiftPagi");
                    let shiftSiang = document.getElementById("shiftSiang");
                    let shiftTotal = document.getElementById("shiftReportTotal");

                    // Pengecekan elemen
                    if (!shiftPagi || !shiftSiang || !shiftTotal) {
                        console.error("Elemen shift tidak ditemukan: shiftPagi, shiftSiang, atau shiftReportTotal");
                        return;
                    }

                    let tanggalHariIni = now.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    // Atur tanggal di tabel shift pagi dan siang
                    let tanggalShiftPagi = document.getElementById("tanggalShiftPagi");
                    let tanggalShiftSiang = document.getElementById("tanggalShiftSiang");
                    if (tanggalShiftPagi && tanggalShiftSiang) {
                        tanggalShiftPagi.innerText = tanggalHariIni;
                        tanggalShiftSiang.innerText = tanggalHariIni;
                    } else {
                        console.error("Elemen tanggal shift tidak ditemukan: tanggalShiftPagi atau tanggalShiftSiang");
                    }

                    // Reset tampilan semua shift
                    shiftPagi.style.display = "none";
                    shiftSiang.style.display = "none";
                    shiftTotal.style.display = "none";

                    // Tampilkan tabel sesuai shift
                    if (hours >= 7 && hours < 12) {
                        shiftPagi.style.display = "block";
                    } else if (hours >= 12 && hours < 17) {
                        shiftSiang.style.display = "block";
                    } else {
                        shiftTotal.style.display = "block";
                    }
                }

                checkShift();
                setInterval(checkShift, 60000);
            });

            // TANGGAL SHIFT
            function updateTanggal() {
                var now = new Date();
                var options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric'
                };

                var tanggalPagiElement = document.getElementById('tanggalShiftPagi');
                var tanggalSiangElement = document.getElementById('tanggalShiftSiang');

                if (tanggalPagiElement && tanggalSiangElement) {
                    var tanggalLengkap = now.toLocaleDateString('id-ID', options);
                    tanggalPagiElement.textContent = tanggalLengkap;
                    tanggalSiangElement.textContent = tanggalLengkap;
                } else {
                    console.error("Elemen tanggal shift tidak ditemukan: tanggalShiftPagi atau tanggalShiftSiang");
                }
            }

            // Panggil fungsi saat halaman dimuat
            document.addEventListener("DOMContentLoaded", updateTanggal);

            // JAM DAN TANGGAL
            function updateClock() {
                var now = new Date();
                var tanggalElement = document.getElementById('tanggal');
                var jamElement = document.getElementById('jam');

                if (!tanggalElement || !jamElement) {
                    console.error("Elemen tanggal atau jam tidak ditemukan: tanggal atau jam");
                    return;
                }

                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');
                jamElement.innerHTML = '<h6>' + jamString + '</h6>';
            }

            document.addEventListener("DOMContentLoaded", function() {
                updateClock();
                setInterval(updateClock, 1000);
            });

            // Tampilkan modal jumlah pasien
            function togglePopup() {
                if (typeof $ !== 'undefined' && $('#jmlhpasien').length) {
                    $('#jmlhpasien').modal('toggle');
                } else {
                    console.error("jQuery atau elemen jmlhpasien tidak ditemukan");
                }
            }

            // CSRF Token Setup
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
                        }
                    });
                } else {
                    console.error("jQuery tidak ditemukan untuk pengaturan CSRF");
                }
            });

            // Kode pasien umum
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#poli_umum').length) {
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
                                            $("#dokter_umum").append('<option value="' +
                                                key + '">' + value + '</option>');
                                        });
                                    } else {
                                        $("#dokter_umum").empty();
                                    }
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching dokter data: ", jqXHR);
                                }
                            });
                        } else {
                            $("#dokter_umum").empty();
                        }
                    });
                } else {
                    console.error("jQuery atau elemen poli_umum tidak ditemukan");
                }
            });

            // Autocomplete pasien umum
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#search_pasien').length && $.ui && $.ui.autocomplete) {
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
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien data: ", jqXHR);
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
                                    $('#nik').val(response.nik || '');
                                    $('#nama_kk').val(response.nama_kk || '');
                                    $('#tgllahir').val(response.tgllahir || '');
                                    $('#jekel').val(response.jekel || '');
                                    $('#alamat_asal').val(response.alamat_asal || '');
                                    $('#pekerjaan').val(response.pekerjaan || '');
                                    $('#domisili').val(response.domisili || '');
                                    $('#noHP').val(response.noHP || '');
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien details: ", jqXHR);
                                }
                            });
                            return false;
                        },
                        appendTo: "#autocomplete-results"
                    }).focus(function() {
                        $(this).autocomplete("search", "");
                    });
                } else {
                    console.error("jQuery, jQuery UI, atau elemen search_pasien tidak ditemukan");
                }
            });

            // Simpan data pasien umum
            function saveData() {
                var loadingSpinner = $('#loadingSpinner');
                var btnSimpan = $('#btnSimpan');
                if (!loadingSpinner.length || !btnSimpan.length) {
                    console.error("Elemen loadingSpinner atau btnSimpan tidak ditemukan");
                    return;
                }

                loadingSpinner.removeClass('d-none');
                btnSimpan.prop('disabled', true);

                var formData = {
                    poli: document.getElementById('poli_umum')?.value || '',
                    dokter: document.getElementById('dokter_umum')?.value || '',
                    nama_pasien: document.getElementById('search_pasien')?.value || '',
                    nik: document.getElementById('nik')?.value || '',
                    nama_kk: document.getElementById('nama_kk')?.value || '',
                    pekerjaan: document.getElementById('pekerjaan')?.value || '',
                    tgllahir: document.getElementById('tgllahir')?.value || '',
                    jekel: document.getElementById('jekel')?.value || '',
                    alamat_asal: document.getElementById('alamat_asal')?.value || '',
                    domisili: document.getElementById('domisili')?.value || '',
                    noHP: document.getElementById('noHP')?.value || ''
                };

                var errorMessages = [];
                if (!formData.poli) errorMessages.push("- Poli harus dipilih.");
                if (!formData.dokter) errorMessages.push("- Dokter harus dipilih.");
                if (!formData.nama_pasien) errorMessages.push("- Nama Pasien harus diisi.");
                if (!formData.nik) errorMessages.push("- NIK harus diisi.");
                if (!formData.nama_kk) errorMessages.push("- Nama Kepala Keluarga harus diisi.");
                if (!formData.tgllahir) errorMessages.push("- Tanggal Lahir harus diisi.");
                if (!formData.jekel) errorMessages.push("- Jenis kelamin harus dipilih.");
                if (!formData.alamat_asal) errorMessages.push("- Alamat Asal harus diisi.");
                if (!formData.pekerjaan) errorMessages.push("- Pekerjaan harus diisi.");
                if (!formData.domisili) errorMessages.push("- Alamat Domisili harus diisi.");
                if (!formData.noHP) errorMessages.push("- No. HP harus diisi.");

                if (errorMessages.length > 0) {
                    loadingSpinner.addClass('d-none');
                    btnSimpan.prop('disabled', false);
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return;
                }

                $.ajax({
                    url: '/perawat/store-umum',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            console.error('No redirect URL provided in the server response.');
                        }
                    },
                    error: function(jqXHR) {
                        loadingSpinner.addClass('d-none');
                        btnSimpan.prop('disabled', false);
                        if (jqXHR.status == 422) {
                            var errors = jqXHR.responseJSON;
                            var errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value);
                            });
                            alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                        } else {
                            console.error('Error saat menyimpan data pasien: ', jqXHR);
                        }
                    }
                });
            }

            // Kode pasien BPJS
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#poli_bpjs').length) {
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
                                            $("#dokter_bpjs").append('<option value="' +
                                                key + '">' + value + '</option>');
                                        });
                                    } else {
                                        $("#dokter_bpjs").empty();
                                    }
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching dokter BPJS data: ", jqXHR);
                                }
                            });
                        } else {
                            $("#dokter_bpjs").empty();
                        }
                    });
                } else {
                    console.error("jQuery atau elemen poli_bpjs tidak ditemukan");
                }
            });

            // Autocomplete pasien BPJS
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#norm').length && $.ui && $.ui.autocomplete) {
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
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien BPJS data: ", jqXHR);
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
                                    $('#nama_pasienbpjs').val(response.nama_pasien || '');
                                    $('#nikbpjs').val(response.nik || '');
                                    $('#nama_kkbpjs').val(response.nama_kk || '');
                                    $('#tgllahirbpjs').val(response.tgllahir || '');
                                    $('#jekelbpjs').val(response.jekel || '');
                                    $('#alamat_asalbpjs').val(response.alamat_asal || '');
                                    $('#pekerjaanbpjs').val(response.pekerjaan || '');
                                    $('#domisilibpjs').val(response.domisili || '');
                                    $('#noHPbpjs').val(response.noHP || '');
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien BPJS details: ",
                                        jqXHR);
                                }
                            });
                            return false;
                        },
                        appendTo: "#autocompletebpjs-results"
                    });
                } else {
                    console.error("jQuery, jQuery UI, atau elemen norm tidak ditemukan");
                }
            });

            // Simpan data pasien BPJS
            function saveDataBpjs() {
                var loadingSpinner = $('#loadingSpinnerLama');
                var btnSimpan = $('#simpanBpjs');
                if (!loadingSpinner.length || !btnSimpan.length) {
                    console.error("Elemen loadingSpinnerLama atau simpanBpjs tidak ditemukan");
                    return;
                }

                loadingSpinner.removeClass('d-none');
                btnSimpan.prop('disabled', true);

                var formData = {
                    poli: document.getElementById('poli_bpjs')?.value || '',
                    dokter: document.getElementById('dokter_bpjs')?.value || '',
                    bpjs: document.getElementById('norm')?.value || '',
                    nama_pasien: document.getElementById('nama_pasienbpjs')?.value || '',
                    nik: document.getElementById('nikbpjs')?.value || '',
                    nama_kk: document.getElementById('nama_kkbpjs')?.value || '',
                    pekerjaan: document.getElementById('pekerjaanbpjs')?.value || '',
                    tgllahir: document.getElementById('tgllahirbpjs')?.value || '',
                    jekel: document.getElementById('jekelbpjs')?.value || '',
                    alamat_asal: document.getElementById('alamat_asalbpjs')?.value || '',
                    domisili: document.getElementById('domisilibpjs')?.value || '',
                    noHP: document.getElementById('noHPbpjs')?.value || ''
                };

                var errorMessages = [];
                if (!formData.poli) errorMessages.push("- Poli harus dipilih.");
                if (!formData.dokter) errorMessages.push("- Dokter harus dipilih.");
                if (!formData.bpjs) errorMessages.push("- No. BPJS harus diisi.");

                if (errorMessages.length > 0) {
                    loadingSpinner.addClass('d-none');
                    btnSimpan.prop('disabled', false);
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return;
                }

                $.ajax({
                    url: '/perawat/store-bpjs',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            console.error('No redirect URL provided in the server response.');
                        }
                    },
                    error: function(jqXHR) {
                        loadingSpinner.addClass('d-none');
                        btnSimpan.prop('disabled', false);
                        if (jqXHR.status == 422) {
                            var errors = jqXHR.responseJSON;
                            var errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value);
                            });
                            alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                        } else {
                            console.error('Error saat menyimpan data pasien BPJS: ', jqXHR);
                        }
                    }
                });
            }

            // // GCS Calculation
            // document.addEventListener("DOMContentLoaded", function() {
            //     var gcs_e = document.getElementById('gcs_e');
            //     var gcs_m = document.getElementById('gcs_m');
            //     var gcs_v = document.getElementById('gcs_v');
            //     var gcs_total = document.getElementById('gcs_total');

            //     if (gcs_e && gcs_m && gcs_v && gcs_total) {
            //         function calculateTotal() {
            //             var e = parseFloat(gcs_e.value) || 0;
            //             var m = parseFloat(gcs_m.value) || 0;
            //             var v = parseFloat(gcs_v.value) || 0;
            //             var totalInput = e + m + v;

            //             if (totalInput > 15) {
            //                 var ratio = 15 / totalInput;
            //                 e = e * ratio;
            //                 m = m * ratio;
            //                 v = v * ratio;
            //                 totalInput = 15;
            //             }

            //             var total = e + m + v;
            //             gcs_total.textContent = Math.round(total);
            //         }

            //         gcs_e.addEventListener('input', calculateTotal);
            //         gcs_m.addEventListener('input', calculateTotal);
            //         gcs_v.addEventListener('input', calculateTotal);
            //         calculateTotal();
            //     } else {
            //         console.error("Elemen GCS tidak ditemukan: gcs_e, gcs_m, gcs_v, atau gcs_total");
            //     }
            // });

            // // IMT Calculation (Pasien Baru)
            // document.addEventListener("DOMContentLoaded", function() {
            //     var tbInput = document.getElementById('p_tb');
            //     var bbInput = document.getElementById('p_bb');
            //     var imtInput = document.getElementById('p_imt');

            //     if (tbInput && bbInput && imtInput) {
            //         function hitungIMT() {
            //             var tb = parseFloat(tbInput.value);
            //             var bb = parseFloat(bbInput.value);
            //             if (!isNaN(tb) && !isNaN(bb) && tb > 0 && bb > 0) {
            //                 var imt = bb / ((tb / 100) * (tb / 100));
            //                 imtInput.value = imt.toFixed(2);
            //             } else {
            //                 imtInput.value = '';
            //             }
            //         }

            //         tbInput.addEventListener('input', hitungIMT);
            //         bbInput.addEventListener('input', hitungIMT);
            //         hitungIMT(); // Hitung IMT saat halaman dimuat jika ada nilai awal
            //     } else {
            //         console.error("Elemen IMT tidak ditemukan: p_tb, p_bb, atau p_imt");
            //     }
            // });

            // // IMT Calculation (Pasien Lama) - Dinonaktifkan jika elemen tidak ada
            // document.addEventListener("DOMContentLoaded", function() {
            //     var tblmInput = document.getElementById('tb');
            //     var bblmInput = document.getElementById('bb');
            //     var imtlmInput = document.getElementById('l_imt');

            //     if (tblmInput && bblmInput && imtlmInput) {
            //         function hitungIMTLama() {
            //             var tb = parseFloat(tblmInput.value);
            //             var bb = parseFloat(bblmInput.value);
            //             if (!isNaN(tb) && !isNaN(bb) && tb > 0 && bb > 0) {
            //                 var imt = bb / ((tb / 100) * (tb / 100));
            //                 imtlmInput.value = imt.toFixed(2);
            //             } else {
            //                 imtlmInput.value = '';
            //             }
            //         }

            //         tblmInput.addEventListener('input', hitungIMTLama);
            //         bblmInput.addEventListener('input', hitungIMTLama);
            //         hitungIMTLama(); // Hitung IMT saat halaman dimuat jika ada nilai awal
            //     } else {
            //         console.warn(
            //             "Elemen IMT lama tidak ditemukan: tb, bb, atau l_imt. Fungsi hitungIMTLama dinonaktifkan.");
            //     }
            // });
        </script>
    @endpush

</x-admin.layout.terminal>
