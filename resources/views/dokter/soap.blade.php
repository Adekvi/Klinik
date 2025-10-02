@extends('admin.layout.dasbrod')
@section('title', 'Asesmen')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title mt-3">
                    <div class="judul d-flex justify-content-between align-items-center">
                        <h4><strong>Asesmen Pasien</strong></h4>
                        <div class="date-time d-flex align-items-center gap-2 text-center">
                            <div class="tanggal text-muted" id="tanggal"></div>
                            <div class="jam text-muted" id="jam"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex" style="gap: 5px">
                            <div class="kembali">
                                <a href="{{ url('dokter/index') }}" class="btn btn-outline-primary" data-toggle="tooltip"
                                    data-bs-placement="top" title="Kembali">
                                    <i class="fa-solid fa-backward"></i> Kembali
                                </a>
                            </div>

                            <div class="periksa">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSoap">
                                    <i class="fa-solid fa-user-doctor"></i> Periksa
                                </button>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="riwayatDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-book-medical"></i> Riwayat Periksa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="riwayatDropdown">
                                    @if ($antrianDokter->poli->namapoli === 'Umum')
                                        <li>
                                            <h6 class="dropdown-header">Riwayat Pasien Poli Umum</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#riwayat{{ $antrianDokter->id }}">Riwayat SOAP</a></li>
                                        <li>
                                            @if ($fisik && $fisik->id)
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#riwayatTubuh{{ $fisik->id }}">Riwayat Periksa
                                                    Tubuh</a>
                                            @else
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal">Riwayat
                                                    Periksa Tubuh</a>
                                            @endif
                                        </li>
                                    @elseif ($antrianDokter->poli->namapoli === 'Gigi')
                                        <li>
                                            <h6 class="dropdown-header">Riwayat Pasien Poli Gigi</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#riwayat{{ $antrianDokter->id }}">Riwayat SOAP</a></li>
                                        <li>
                                            @if ($fisik && $fisik->id)
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#riwayatGigi{{ $fisik->id }}">Riwayat Odontogram</a>
                                            @else
                                                <a class="dropdown-item disabled" href="#"
                                                    aria-disabled="true">Riwayat Odontogram (Belum Ada)</a>
                                            @endif
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="fisik-tubuh">
                                @if ($antrianDokter->poli->namapoli === 'Umum')
                                    @php
                                        $isTubuhLocked =
                                            $lastTubuhTime && Carbon\Carbon::now()->diffInHours($lastTubuhTime) < 24;
                                    @endphp
                                    @if (!$isTubuhLocked)
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#tubuh{{ $antrianDokter->id }}">
                                            <i class="fa-solid fa-stethoscope"></i> Periksa Tubuh
                                        </button>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-circle-info text-success"></i> Periksa Tubuh terakhir
                                            diisi:
                                            {{ $lastTubuhTime->translatedFormat('H:i') }}</span>
                                    @endif
                                @elseif ($antrianDokter->poli->namapoli === 'Gigi')
                                    @php
                                        $isOdontogramLocked =
                                            $lastOdontogramTime &&
                                            Carbon\Carbon::now()->diffInHours($lastOdontogramTime) < 24;
                                    @endphp
                                    @if (!$isOdontogramLocked)
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#gigi{{ $antrianDokter->id }}">
                                            <i class="fa-solid fa-tooth"></i> Odontogram
                                        </button>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-circle-info text-success"></i>Periksa Gigi Odontogram terakhir
                                            diisi:
                                            {{ $lastOdontogramTime->translatedFormat('H:i') }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table" style="width: 50%; border-collapse: separate">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">No RM</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Nama Pasien</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->nama_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Jenis Pasien</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->jenis_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Umur</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">
                                            <?php
                                            $tgllahir = \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir);
                                            $umur = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                                            
                                            if ($umur < 12) {
                                                echo $tgllahir->diff(\Carbon\Carbon::now())->format('%m&nbsp;bulan&nbsp;%d&nbsp;hari');
                                            } else {
                                                echo $tgllahir->age . '&nbsp;Tahun';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Jenis Kelamin</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">
                                            {{ $antrianDokter->booking->pasien->jekel == 'L' ? 'Laki-laki' : ($antrianDokter->booking->pasien->jekel == 'P' ? 'Perempuan' : '') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Alamat Domisili</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->domisili }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead class="table-primary" style="text-align: center;">
                                    <tr>
                                        <th>AKSI</th>
                                        <th>TGL DAN JAM</th>
                                        <th>PROFESI</th>
                                        <th>ASESMEN</th>
                                        <th>EDUKASI</th>
                                        {{-- <th>Paraf</th> --}}
                                    </tr>
                                </thead>
                                @php
                                    $allSoapPatients = [];
                                @endphp

                                @foreach ($soap as $item)
                                    @php
                                        $soapData = json_decode($item['soap_p'], true);
                                        $allSoapPatients = array_merge($allSoapPatients, array_keys($soapData));
                                    @endphp
                                @endforeach

                                @php
                                    $allSoapPatients = array_unique($allSoapPatients);
                                    // dd($allSoapPatients);
                                @endphp

                                <tbody style="text-align: center; white-space: nowrap">
                                    @if (count($soap) > 0)
                                        @foreach ($soap as $item)
                                            <tr>
                                                <td>
                                                    @if ($soapTerbaru)
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-offset="0,4" data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Edit SOAP</span>">
                                                            <button type="button" class="btn text-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editSoap{{ $soapTerbaru->id }}">
                                                                <i class="fas fa-pen"></i>
                                                            </button>
                                                        </span>
                                                    @endif
                                                    @if ($fisik && $fisik->dokter && $fisik->dokter->poli)
                                                        @if ($fisik->dokter->poli->namapoli == 'Umum')
                                                            <!-- Tombol edit anatomi -->
                                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-offset="0,4" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Edit Anatomi</span>">
                                                                <button type="button" class="btn text-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edittubuh{{ $fisik->id }}">
                                                                    <i class="fa-solid fa-stethoscope"></i>
                                                                </button>
                                                            </span>
                                                        @elseif ($fisik->dokter->poli->namapoli == 'Gigi')
                                                            <!-- Tombol edit odontogram -->
                                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-offset="0,4" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Edit Odontogram</span>">
                                                                <button type="button" class="btn text-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editFisik{{ $fisik->id }}">
                                                                    <i class="fa-solid fa-tooth"></i>
                                                                </button>
                                                            </span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ date_format(date_create($item['created_at']), 'Y-m-d/H:i') }}
                                                </td>
                                                <td>{{ $item['nama_dokter'] }}</td>
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
                                                                <td>
                                                                    <li>{{ $item['keluhan_utama'] ?? '-' }}</li>
                                                                </td>
                                                                <td>
                                                                    <ul style="padding-left: 20px; margin: 0;">
                                                                        <li>
                                                                            <div
                                                                                style="display: grid; grid-template-columns: 80px auto;">
                                                                                <span>Tensi</span><span>:
                                                                                    {{ $item['p_tensi'] ?? '-' }} /
                                                                                    mmHg</span>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div
                                                                                style="display: grid; grid-template-columns: 80px auto;">
                                                                                <span>RR</span><span>:
                                                                                    {{ $item['p_rr'] ?? '-' }} /
                                                                                    minute</span>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div
                                                                                style="display: grid; grid-template-columns: 80px auto;">
                                                                                <span>Nadi</span><span>:
                                                                                    {{ $item['p_nadi'] ?? '-' }} /
                                                                                    minute</span>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div
                                                                                style="display: grid; grid-template-columns: 80px auto;">
                                                                                <span>Suhu</span><span>:
                                                                                    {{ $item['p_suhu'] ?? '-' }} °c</span>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div
                                                                                style="display: grid; grid-template-columns: 80px auto;">
                                                                                <span>TB</span><span>:
                                                                                    {{ $item['p_tb'] ?? '-' }} / cm</span>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div
                                                                                style="display: grid; grid-template-columns: 80px auto;">
                                                                                <span>BB</span><span>:
                                                                                    {{ $item['p_bb'] ?? '-' }} / kg</span>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $diagnosaPrimer = json_decode(
                                                                            $item['soap_a_primer'] ?? '[]',
                                                                            true,
                                                                        );
                                                                        $diagnosaPrimer = array_values($diagnosaPrimer);
                                                                        $diagnosaSekunder = json_decode(
                                                                            $item['soap_a_sekunder'] ?? '[]',
                                                                            true,
                                                                        );
                                                                        $diagnosaSekunder = array_values(
                                                                            $diagnosaSekunder,
                                                                        );
                                                                    @endphp
                                                                    @if (!empty($diagnosaPrimer) || !empty($diagnosaSekunder))
                                                                        @foreach ($diagnosaPrimer as $diag)
                                                                            <ul>
                                                                                <li>{{ $diag ?? '-' }}</li>
                                                                            </ul>
                                                                        @endforeach
                                                                        @foreach ($diagnosaSekunder as $diagn)
                                                                            <ul>
                                                                                <li>{{ $diagn ?? '-' }}</li>
                                                                            </ul>
                                                                        @endforeach
                                                                    @else
                                                                        <ul>
                                                                            <li>Tidak Ada Diagnosa</li>
                                                                        </ul>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <p style="font-weight: bold; margin-bottom: -0px">
                                                                        Resep :</p>
                                                                    <p style="font-weight: bold; margin-bottom: -0px">
                                                                        - Non Racikan
                                                                    </p>
                                                                    @php
                                                                        $resep = json_decode(
                                                                            $item['soap_p'] ?? '[]',
                                                                            true,
                                                                        );
                                                                        $aturan = json_decode(
                                                                            $item['soap_p_aturan'] ?? '[]',
                                                                            true,
                                                                        );
                                                                    @endphp
                                                                    @if (is_array($resep) && is_array($aturan) && count($resep) == count($aturan))
                                                                        @foreach ($resep as $obat => $namaObat)
                                                                            @php
                                                                                $aturanMinum = $aturan[$obat] ?? '-';
                                                                            @endphp
                                                                            <ul>
                                                                                <li>
                                                                                    <div
                                                                                        style="display: grid; grid-template-columns: 200px 20px auto; gap: 5px;">
                                                                                        <span>{{ $namaObat ?? '-' }}</span>
                                                                                        <span>-</span>
                                                                                        <span>{{ $aturanMinum ?? '-' }}</span>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        @endforeach
                                                                    @else
                                                                        <p>-</p>
                                                                    @endif
                                                                    <p style="font-weight: bold; margin-bottom: -0px">
                                                                        - Racikan
                                                                    </p>
                                                                    <ul>
                                                                        <li>
                                                                            {{ $item['ObatRacikan'] ?? '-' }}

                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>{{ $item['edukasi'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SOAP --}}
    @include('dokter.modal.modalSoap')
    @include('dokter.modal.editSoap')

    {{-- DOOKTER UMUM --}}
    @include('dokter.umum.tubuh')
    @include('dokter.umum.edittubuh')
    @include('dokter.umum.riwayat')

    {{-- DOKTER GIGI --}}
    @include('dokter.gigi.editgigi')
    @include('dokter.gigi.gigi')
    @include('dokter.gigi.riwayat')

    {{-- RIWAYAT --}}
    @include('dokter.modal.riwayatPasien')

@endsection

@push('style')
    <style>
        .table th,
        .table td {
            padding: 5px 5px;
            /* Mengurangi padding */
            margin: 0;
            /* Menghapus margin */
            line-height: 1.5;
            /* Mengurangi tinggi baris */
        }

        .table th {
            vertical-align: top;
            /* Menyelaraskan teks ke atas untuk header kolom */
        }

        .table td {
            vertical-align: top;
            /* Menyelaraskan teks ke atas untuk sel */
        }

        /* Alert */
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // jam dan tanggal
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

            // Calculate the sum of E, M, and V
            var totalInput = e + m + v;

            // Check if any input is missing (i.e. if any value is 0)
            if (e === 0 || m === 0 || v === 0) {
                gcs_total.textContent = totalInput; // Set total to the actual sum of the inputs
            } else {
                // If all inputs are filled, normalize to 15
                if (totalInput !== 15) {
                    var ratio = 15 / totalInput;
                    e = e * ratio;
                    m = m * ratio;
                    v = v * ratio;
                    totalInput = 15; // Normalize the total to 15
                }
                gcs_total.textContent = 15; // Always display 15 when all inputs are valid
            }
        }

        // Listen for input changes and recalculate total
        gcs_e.addEventListener('input', calculateTotal);
        gcs_m.addEventListener('input', calculateTotal);
        gcs_v.addEventListener('input', calculateTotal);

        // Initial calculation
        calculateTotal();

        // Mendapatkan nilai tinggi badan dan berat badan dari inputan
        var tbInput = document.getElementById('tb');
        var bbInput = document.getElementById('bb');
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

        // modal close
        document.addEventListener('DOMContentLoaded', (event) => {
            console.log("DOM fully loaded and parsed");

            // Event listener untuk tombol close
            const closeModalButtons = document.querySelectorAll('[data-bs-dismiss="modal"]');
            closeModalButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    console.log("Close button clicked");
                });
            });
        });
    </script>
@endpush
