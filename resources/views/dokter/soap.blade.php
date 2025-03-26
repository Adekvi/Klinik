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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSoap">
                            <i class="fa-solid fa-user-doctor"></i> Periksa
                        </button>

                        <a href="{{ url('dokter/index') }}" class="btn btn-primary" data-toggle="tooltip"
                            data-bs-placement="top" title="Kembali">
                            <i class="fa-solid fa-backward"></i> Kembali
                        </a>

                        @if ($antrianDokter->poli->namapoli === 'Umum')
                            <a href="{{ url('dokter/tubuh/' . $antrianDokter->id) }}" class="btn btn-warning">
                                <i class="fa-solid fa-stethoscope"></i> Periksa Tubuh
                            </a>
                            {{-- <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalFisik">
                        <i class="fa-solid fa-stethoscope"></i> Gambar
                    </button> --}}
                        @elseif ($antrianDokter->poli->namapoli === 'Gigi')
                            <a href="{{ url('dokter/odontogram') }}" class="btn btn-warning" target="_blank">
                                <i class="fa-solid fa-tooth"></i> Odontogram
                            </a>
                            {{-- <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalFisik">
                        <i class="fa-solid fa-tooth"></i> Odontogram
                    </button> --}}
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table" style="width: 50%; margin-top: -30px; border-collapse: separate">
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
                                        {{-- <th>No</th> --}}
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
                                    @if (count($soap) === 0)
                                        <tr>
                                            <td colspan="5" style="text-align: center">Belum ada Asesmen</td>
                                        </tr>
                                    @else
                                        @foreach ($soap as $item)
                                            <tr>
                                                <td>
                                                    {{ date_format(date_create($item['created_at']), 'Y-m-d/H:i:s') }}
                                                    {{-- lihat gambar --}}
                                                    @foreach ($fisik as $row)
                                                        <button type="button" style="margin-top: 10px"
                                                            class="btn btn-primary" data-toggle="modal"
                                                            data-target="#gambarModal{{ $row['id'] }}">
                                                            <i class="fa-solid fa-eye"></i> Gambar
                                                        </button>
                                                    @endforeach
                                                    @include('dokter.modal.lihat')
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
                                                                <td>{{ $item['keluhan_utama'] }} </td>
                                                                <td>
                                                                    <ul>
                                                                        <li>Tensi : {{ $item['p_tensi'] }} / mmHg</li>
                                                                        <li>RR : {{ $item['p_rr'] }} / minute</li>
                                                                        <li>Nadi : {{ $item['p_nadi'] }} / minute</li>
                                                                        <li>Suhu : {{ $item['p_suhu'] }} °c</li>
                                                                        <li>TB : {{ $item['p_tb'] }} / cm</li>
                                                                        <li>BB : {{ $item['p_bb'] }} / kg</li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $diagnosaPrimer = json_decode(
                                                                            $item['soap_a_primer'],
                                                                            true,
                                                                        );
                                                                        $diagnosaPrimer = array_values($diagnosaPrimer); // menghapus kunci asosiatif
                                                                        $diagnosaSekunder = json_decode(
                                                                            $item['soap_a_sekunder'],
                                                                            true,
                                                                        );
                                                                        $diagnosaSekunder = array_values(
                                                                            $diagnosaSekunder,
                                                                        ); // menghapus kunci asosiatif
                                                                        // dd($diagnosaPrimer);
                                                                    @endphp

                                                                    @if (!empty($diagnosaPrimer) || !empty($diagnosaSekunder))
                                                                        @foreach ($diagnosaPrimer as $diag)
                                                                            <ul>
                                                                                <li>{{ $diag }}</li>
                                                                            </ul>
                                                                        @endforeach
                                                                        @foreach ($diagnosaSekunder as $diagn)
                                                                            <ul>
                                                                                <li>{{ $diagn }}</li>
                                                                            </ul>
                                                                        @endforeach
                                                                    @else
                                                                        <ul>Tidak Ada Diagnosa</ul>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <p style="font-weight: bold; margin-bottom: -0px">Resep
                                                                        :</p>
                                                                    <p style="font-weight: bold; margin-bottom: -0px">- Non
                                                                        Racikan</p>
                                                                    @php
                                                                        $resep = json_decode($item['soap_p'], true); // Mendecode data JSON obat
                                                                        $aturan = json_decode(
                                                                            $item['soap_p_aturan'],
                                                                            true,
                                                                        ); // Mendecode data JSON aturan
                                                                    @endphp

                                                                    @if (is_array($resep) && is_array($aturan))
                                                                        @if (count($resep) == count($aturan))
                                                                            @foreach ($resep as $obat => $namaObat)
                                                                                @php
                                                                                    // Ambil aturan minum yang sesuai berdasarkan nama obat
                                                                                    $aturanMinum = $aturan[$obat];
                                                                                @endphp
                                                                                <ul>
                                                                                    <li>{{ $namaObat ?? '-' }} |
                                                                                        {{ $aturanMinum ?? '-' }}</li>
                                                                                </ul>
                                                                                <!-- Menampilkan nama obat, jumlah, dan aturan minum -->
                                                                            @endforeach
                                                                        @else
                                                                            <p>-</p>
                                                                        @endif
                                                                    @else
                                                                        <p>-</p>
                                                                    @endif

                                                                    {{-- <p style="font-weight: bold; margin-bottom: -0px">- Racikan (Puyer)</p>
                                                            
                                                            @php
                                                                $obatRacikan = json_decode($item['soap_r'], true);
                                                                $takaran = json_decode($item['soap_r_takaran'], true);
                                                                // dd($obatRacikan);
                                                            @endphp
    
                                                            @if (is_array($obatRacikan) && is_array($takaran))
                                                                @if (count($obatRacikan) == 0 && count($takaran) == 0)
                                                                    <p>-</p>
                                                                @elseif(count($obatRacikan) == count($takaran))
                                                                    @for ($i = 0; $i < count($obatRacikan); $i++)
                                                                        <ul>
                                                                            <li>{{ array_keys($obatRacikan)[$i] }} - {{ array_values($obatRacikan)[$i] }}</li>
                                                                        </ul>
                                                                    @endfor
                                                                @else
                                                                    <p><ul><li></li></ul></p>
                                                                @endif
                                                            @else
                                                                <p><ul><li></li></ul></p>
                                                            @endif --}}

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
                                                <td>
                                                    {{ $item['edukasi'] ?? '-' }}
                                                </td>
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

        @include('dokter.modal.modalSoap')

    </div>


    @include('dokter.modal.modalGambar')
    @include('dokter.modal.tindakan')

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
    </style>
@endpush
@push('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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

        // DIAGNOSA
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk memunculkan dropdown berdasarkan hasil pencarian
            function showDropdown(inputElement, dropdownElement, results) {
                dropdownElement.innerHTML = ''; // Bersihkan dropdown sebelumnya
                if (results.length === 0) {
                    dropdownElement.style.display = 'none'; // Sembunyikan jika tidak ada hasil
                    return;
                }

                results.forEach(function(result) {
                    const option = document.createElement('div');
                    option.classList.add('dropdown-item');
                    option.textContent = result.text; // Tampilkan hasil pencarian
                    option.dataset.id = result.id;

                    // Pilih diagnosa ketika salah satu item diklik
                    option.addEventListener('click', function() {
                        inputElement.value = result.text;
                        dropdownElement.style.display =
                            'none'; // Sembunyikan dropdown setelah dipilih
                    });

                    dropdownElement.appendChild(option);
                });
                dropdownElement.style.display = 'block'; // Tampilkan dropdown jika ada hasil
            }

            // Fungsi untuk mengambil hasil pencarian dari server
            function searchDiagnosa(term, callback) {
                fetch(`/search-diagnosa?term=${encodeURIComponent(term)}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Tambahkan ini untuk melihat hasil di console
                        callback(data);
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Event untuk pencarian diagnosa primer
            const diagnosaPrimerInput = document.getElementById('soap_a_0');
            const dropdownDiagnosaPrimer = document.getElementById('dropdown-diagnosa-primer');

            diagnosaPrimerInput.addEventListener('input', function() {
                const searchTerm = this.value;

                if (searchTerm.length > 2) {
                    searchDiagnosa(searchTerm, function(results) {
                        showDropdown(diagnosaPrimerInput, dropdownDiagnosaPrimer, results);
                    });
                } else {
                    dropdownDiagnosaPrimer.style.display =
                        'none'; // Sembunyikan dropdown jika input terlalu pendek
                }
            });

            // Event untuk pencarian diagnosa sekunder
            const diagnosaSekunderInput = document.getElementById('soap_a_b_0');
            const dropdownDiagnosaSekunder = document.getElementById('dropdown-diagnosa-sekunder');

            diagnosaSekunderInput.addEventListener('input', function() {
                const searchTerm = this.value;

                if (searchTerm.length > 2) {
                    searchDiagnosa(searchTerm, function(results) {
                        showDropdown(diagnosaSekunderInput, dropdownDiagnosaSekunder, results);
                    });
                } else {
                    dropdownDiagnosaSekunder.style.display = 'none';
                }
            });
        });

        // RESEP
        $(document).ready(function() {
            // Fungsi untuk pencarian obat
            function searchObat(inputId, dropdownId) {
                $(`#${inputId}`).on('input', function() {
                    const query = $(this).val();
                    if (query) {
                        $.ajax({
                            url: '{{ url('/resep-autocomplete') }}',
                            data: {
                                term: query
                            },
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                // Kosongkan dropdown sebelum menambah item baru
                                $(`#${dropdownId}`).empty().show();
                                if (data.length) {
                                    data.forEach(item => {
                                        // Gunakan item.id untuk data-value
                                        $(`#${dropdownId}`).append(
                                            `<div class="dropdown-item" data-value="${item.id}">${item.text}</div>`
                                        );
                                    });
                                } else {
                                    $(`#${dropdownId}`).append(
                                        '<div class="dropdown-item">Tidak ada saran</div>');
                                }
                            },
                            error: function() {
                                console.log("Error fetching data");
                            }
                        });
                    } else {
                        $(`#${dropdownId}`).hide();
                    }
                });

                // Event untuk memilih item dari dropdown
                $(document).on('click', `#${dropdownId} .dropdown-item`, function() {
                    const value = $(this).data('value'); // Akses data-value
                    console.log("Selected Value:", value); // Debugging
                    $(`#${inputId}`).val($(this).text()); // Isi input dengan nama obat
                    $(`#${dropdownId}`).hide(); // Sembunyikan dropdown
                });
            }

            // Panggil fungsi pencarian dengan ID input dan dropdown yang sesuai
            searchObat('resep_0', 'dropdown-resep_0');

            let kolomIndex = 1; // Inisialisasi indeks untuk kolom baru

            // Tambahkan kolom baru
            window.addColumn = function() {
                let newElement = `
                <div class="input-package new-package" id="package_${kolomIndex}" style="display: contents; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
                    <label for="soap_p_0" style="font-weight: bold; margin-top: 20px;">Pilih Obat Baru (P)</label>
                    
                    <!-- Nama Obat -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="resep_${kolomIndex}" style="min-width: 100px;">Nama Obat</label>
                        <span>:</span>
                        <input type="text" class="form-control soap_p" name="soap_p[${kolomIndex}][resep]" id="resep_${kolomIndex}" placeholder="Cari Obat" autocomplete="off">
                        <div id="dropdown-resep_${kolomIndex}" class="dropdown-menu" style="display: none; position: absolute; z-index: 1000; cursor: pointer;"></div>
                    </div>
                    
                    <!-- Jenis Obat -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="jenis_obat_${kolomIndex}" style="min-width: 100px;">Jenis Obat</label>
                        <span>:</span>
                        <select name="soap_p[${kolomIndex}][jenisobat]" id="jenis_obat_${kolomIndex}" class="form-control" required>
                            <option value="">--Pilih Jenis Obat--</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Kapsul">Kapsul</option>
                            <option value="Bungkus">Bungkus</option>
                            <option value="Salep">Salep</option>
                            <option value="Sirup">Sirup</option>
                            <option value="Mililiter">Mililiter</option>
                            <option value="Sendok Teh">Sendok Teh</option>
                            <option value="Sendok Makan">Sendok Makan</option>
                            <option value="Tetes">Tetes</option>
                            <option value="Puyer/Racikan">Puyer/Racikan</option>
                        </select>
                    </div>

                    <!-- Aturan Minum Perhari -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="aturan_${kolomIndex}" style="min-width: 100px;">Aturan Minum Perhari</label>
                        <span>:</span>
                        <select class="form-control" name="soap_p[${kolomIndex}][aturan]" id="aturan_${kolomIndex}" required>
                            <option value="">--Pilih Aturan Minum--</option>
                            <option value="1x1">1x1</option>
                            <option value="2x1">2x1</option>
                            <option value="3x1">3x1</option>
                            <option value="4x1">4x1</option>
                            <option value="5x1">5x1</option>
                        </select>
                    </div>

                    <!-- Anjuran Minum -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="anjuran_${kolomIndex}" style="min-width: 100px;">Anjuran Minum</label>
                        <span>:</span>
                        <select name="soap_p[${kolomIndex}][anjuran]" id="anjuran_${kolomIndex}" class="form-control" required>
                            <option value="">--Pilih Anjuran Minum--</option>
                            <option value="AC">AC</option>
                            <option value="AD">AD</option>
                            <option value="AS">AS</option>
                            <option value="C">C</option>
                            <option value="CTH">CTH</option>
                            <option value="DC">DC</option>
                            <option value="PC">PC</option>
                            <option value="OD">OD</option>
                            <option value="OS">OS</option>
                            <option value="ODS">ODS</option>
                            <option value="PRM">PRM</option>
                            <option value="UE">UE</option>
                        </select>
                    </div>

                    <!-- Jumlah Masing-masing Obat -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="jumlah_${kolomIndex}" style="min-width: 100px;">Jumlah</label>
                        <span>:</span>
                        <input type="number" name="soap_p[${kolomIndex}][jumlah]" id="jumlah_${kolomIndex}" class="form-control" placeholder="Masukkan Jumlah Obat" required>
                    </div>

                    <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-danger btn-wide" style="width: 50px; padding: 5px 10px; margin-bottom: 5px" onclick="$(this).closest('.input-package').remove()">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;

                // Tambahkan elemen baru ke dalam div "resep"
                $('#resep').append(newElement);

                // Panggil fungsi pencarian untuk kolom baru
                searchObat(`resep_${kolomIndex}`, `dropdown-resep_${kolomIndex}`);

                kolomIndex++; // Perbarui indeks setelah menambahkan kolom
            };
        });

        // Keterangan Dokter Gigi
        $(document).ready(function() {
            // Mengatur tanggal input dengan tanggal hari ini
            var today = new Date().toISOString().split('T')[0];
            $('#tanggal').val(today);

            $('.tambah-keterangan').click(function() {
                var keteranganElement = `
                <div class="form-group keterangan-item">
                    <label for="no_gigi">Nomor Gigi</label>
                    <input type="number" class="form-control mt-2 mb-2" name="no_gigi[]" placeholder="Masukkan Nomor Gigi">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control mt-2 mb-2" name="keterangan[]" placeholder="Keterangan">
                </div>
            `;
                $('#keterangan-container').append(keteranganElement);
            });

            // Hapus keterangan
            $(document).on('click', '.hapus-keterangan', function() {
                $('#keterangan-container .keterangan-item:last').remove();
            });
        });

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

{{-- DIAGNOSA --}}
{{-- Tambah event listener untuk tombol tambah diagnosa
            $('.tambah-diagno').click(function () {
                i++;
                var resepElementDiagno = `
                    <div class="diagno mt-1" id="diagno_${i}">
                        <select class="form-control soap_a" name="soap_a[${i}]['diagnosa_primer']" id="soap_a_${i}">
                            <option value="" disabled selected>Pilih Diagnosa</option>
                        </select>
                        <select class="form-control soap_a_b" name="soap_a_b[${i}]['diagnosa_sekunder']" id="soap_a_b_${i}">
                            <option value="" disabled selected>Pilih Diagnosa</option>
                        </select>
                        <button type="button" class="btn btn-danger mt-2 mb-2 hapus-diagno" data-target="${i}">-</button>
                    </div>
                `;
                $('#diagno').append(resepElementDiagno);

                // Panggil Select2 pada elemen select yang baru ditambahkan
                $(`#soap_a_${i}`).select2({
                    placeholder: "Cari Diagnosa",
                    allowClear: true,
                    dropdownParent: $('#modalSoap'),
                    ajax: {
                        url: '{{ url('/search-diagnosa') }}',
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        }
                    }
                });
                $(`#soap_a_b_${i}`).select2({
                    placeholder: "Cari Diagnosa Sekunder",
                    allowClear: true,
                    dropdownParent: $('#modalSoap'),
                    ajax: {
                        url: '{{ url('/search-diagnosa') }}',
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        }
                    }
                });
            }); --}}

{{-- // Tambah event listener untuk tombol tambah resep
            // $('.tambah-resep').click(function () {
            //     i++;
            //     var resepElement = `
            //     <div class="resep" id="resep_${i}">
            //         <select class="form-control soap_p" name="soap_p[${i}]['resep']" id="soap_p_${i}" required>
            //             <option value="" disabled selected>Pilih Resep</option>
            //         </select>
            //         <div class="aturan" style="display: flex; justify-content: space-between">
            //             <select class="form-control mt-2 mb-2" name="soap_p[${i}]['keterangan']" id="keterangan_${i}" placeholder="Keterangan Resep" required style="width: 50%">
            //                 <option value="1x1">1x1</option>
            //                 <option value="2x1">2x1</option>
            //                 <option value="3x1">3x1</option>
            //                 <option value="4x1">4x1</option>
            //                 <option value="5x1">5x1</option>
            //             </select>
            //             <select name="soap_p[${i}]['aturan']" id="aturan_${i}" class="form-control mt-2 mb-2" required style="width: 45%">
            //                 <option value="">--Pilih Anjuran Minum--</option>
            //                 <option value="AC">AC</option>
            //                 <option value="AD">AD</option>
            //                 <option value="AS">AS</option>
            //                 <option value="C">C</option>
            //                 <option value="CTH">CTH</option>
            //                 <option value="DC">DC</option>
            //                 <option value="PC">PC</option>
            //                 <option value="OD">OD</option>
            //                 <option value="OS">OS</option>
            //                 <option value="ODS">ODS</option>
            //                 <option value="PRM">PRM</option>
            //                 <option value="UE">UE</option>
            //             </select>
            //         </div>
            //         <div class="row">
            //             <div class="col-lg-6">
            //                 <label for="jenisObat_${i}">Jenis Obat</label>
            //                 <select name="jenis[]" id="jenisObat_${i}" class="form-control mt-2 mb-2">
            //                     <option value="">--Pilih--</option>
            //                     <option value="Puyer/Racikan">Puyer/Racikan</option>
            //                     <option value="Tablet">Tablet</option>
            //                     <option value="Kapsul">Kapsul</option>
            //                     <option value="Bungkus">Bungkus</option>
            //                     <option value="Salep">Salep</option>
            //                     <option value="Krim">Krim</option>
            //                     <option value="Mililiter">Mililiter</option>
            //                     <option value="Sendok Teh">Sendok Teh</option>
            //                     <option value="Sendok Makan">Sendok Makan</option>
            //                     <option value="Tetes">Tetes</option>
            //                 </select>
            //             </div>
            //             <div class="col-lg-6">
            //                 <label for="jumlah_${i}">Jumlah</label>
            //                 <input type="number" name="jumlah[]" class="form-control mt-2 mb-2" placeholder="Jumlah">
            //             </div>
            //         </div>
            //         <div class="row" id="puyerObat_${i}" style="display: none;">
            //             <div class="col-lg-12">
            //                 <label for="puyer_${i}">Puyer/Racikan</label>
            //                 <input type="text" name="puyer[]" id="puyer_${i}" class="form-control mt-2 mb-2" placeholder="Masukkan Takaran">
            //             </div>
            //         </div>
            //         <button type="button" class="btn btn-danger mb-2 hapus-resep" data-target="${i}">-</button>
            //     </div>
            //     `;
            //     $('#resep').append(resepElement);

            //     // Inisialisasi Select2 pada elemen select yang baru ditambahkan
            //     $(`#soap_p_${i}`).select2({
            //         placeholder: "Cari Resep",
            //         allowClear: true,
            //         dropdownParent: $('#modalSoap'),
            //         ajax: {
            //             url: '{{ url('/resep-autocomplete') }}',
            //             dataType: 'json',
            //             processResults: function (data) {
            //                 return {
            //                     results: data
            //                 };
            //             }
            //         }
            //     });

            //     // Event listener untuk Jenis Obat
            //     $(`#jenisObat_${i}`).change(function() {
            //         if ($(this).val() === 'Puyer/Racikan') {
            //             $(`#puyerObat_${i}`).show();
            //         } else {
            //             $(`#puyerObat_${i}`).hide();
            //         }
            //     });

            //     // Event listener untuk tombol hapus resep
            //     $(`.hapus-resep[data-target="${i}"]`).click(function() {
            //         $(`#resep_${i}`).remove();
            //     });
            // });

            // // Hapus resep
            // $(document).on('click', '.hapus-resep', function () {
            //     var target = $(this).data('target');
            //     $(`#resep_${target}`).remove();
            // }); --}}
