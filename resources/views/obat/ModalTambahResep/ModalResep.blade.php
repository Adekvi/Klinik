<!-- Modal Resep BARU -->
<div class="modal fade" id="tambahObat{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Tambah Obat atau
                    Resep</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('obat/store/' . $item->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="container" style="margin-top: -10px">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <h2><strong>{{ $item->booking->pasien->nama_pasien }}</strong></h2>
                                    <hr style="margin-top: -5px">
                                    <p style="font-size: 14px; margin-top: -5px">
                                        <strong>Sengonbugel RT.01/01, Mayong, Jepara</strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                    <p style="margin-top: -5px">
                                        <strong>
                                            {{ $item->booking->pasien->alamat_asal }},
                                            {{ $item->booking->pasien->tgllahir }}
                                            ({{ \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age }} Tahun)
                                        </strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Tinggi Badan</label>
                                            <span>:</span>
                                            <p>{{ $item->isian->p_tb }} Cm</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Berat Badan</label>
                                            <span>:</span>
                                            <p>{{ $item->isian->p_bb }} Kg</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Kelamin</label>
                                            <span>:</span>
                                            <p>
                                                @if ($item->booking->pasien->jekel === 'P' ?? 'Perempuan')
                                                    Perempuan
                                                @elseif($item->booking->pasien->jekel === 'L' ?? 'Laki-laki')
                                                    Laki-laki
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top: -20px">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Pasien</label>
                                            <span>:</span>
                                            <p>{{ $item->booking->pasien->jenis_pasien }}</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Poli</label>
                                            <span>:</span>
                                            <p>{{ $item->poli->namapoli }}</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No NIK</label>
                                            <span>:</span>
                                            <p>{{ $item->booking->pasien->nik }}</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No BPJS</label>
                                            <span>:</span>
                                            <p>
                                                @if (!empty($item->pasien->booking->bpjs))
                                                    {{ $item->pasien->booking->bpjs }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table mt-2 mb-2 table-striped table-bordered"
                                        style="overflow: auto; min-width: 130%;">
                                        <thead class="table-primary text-center text-nowrap">
                                            <tr>
                                                <th>NAMA OBAT</th>
                                                <th>ATURAN MINUM</th>
                                                <th>JUMLAH OBAT</th>
                                                <th>HARGA/TABLET</th>
                                                <th>TOTAL HARGA</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            {{-- {{ dd($antrianObat) }} --}}
                                            <tr>
                                                {{-- NAMA OBAT --}}
                                                <td>
                                                    <div class="Obat" data-pasien-id="{{ $item->id }}">
                                                        @php
                                                            $semuaObat = json_decode($item->obat->obat_Ro, true) ?? [];
                                                            $anjuranMinum =
                                                                json_decode($item->obat->soap->soap_p_anjuran, true) ??
                                                                [];
                                                            $ngombe =
                                                                json_decode($item->obat->soap->soap_r_minum, true) ??
                                                                [];
                                                            $olehNgombe = array_merge(
                                                                (array) $anjuranMinum,
                                                                (array) $ngombe,
                                                            );
                                                            $hargaJualData = $reseps->keyBy('nama_obat');
                                                        @endphp

                                                        @if (!empty($semuaObat) && !empty($olehNgombe))
                                                            @foreach ($semuaObat as $index => $namaObat)
                                                                @php
                                                                    // Memastikan $namaObat adalah string
                                                                    $namaObat = is_array($namaObat)
                                                                        ? implode(', ', $namaObat)
                                                                        : $namaObat;

                                                                    // Pastikan $anjuran adalah string
                                                                    $anjuran = isset($olehNgombe[$index])
                                                                        ? $olehNgombe[$index]
                                                                        : 'Kosong';

                                                                    // Memeriksa keberadaan nama obat dan mengambil harga
                                                                    $hargaPokok = '0'; // Default value
                                                                    // dd($hargaPokok);

                                                                    if (
                                                                        $hargaJualData->contains('nama_obat', $namaObat)
                                                                    ) {
                                                                        $hargaJual = $hargaJualData->get($namaObat);

                                                                        // Pastikan $hargaJual adalah objek dan memiliki properti harga_pokok
                                                                        if (
                                                                            is_object($hargaJual) &&
                                                                            property_exists($hargaJual, 'harga_jual')
                                                                        ) {
                                                                            $hargaPokok = $hargaJual->harga_jual;
                                                                        } else {
                                                                            Log::warning(
                                                                                'hargaJual tidak valid untuk: ' .
                                                                                    $namaObat,
                                                                            );
                                                                        }
                                                                    } else {
                                                                        Log::warning(
                                                                            'Nama obat tidak ditemukan dalam hargaJualData: ' .
                                                                                $namaObat,
                                                                        );
                                                                    }
                                                                @endphp
                                                                <div class="form-group"
                                                                    data-pasien-id="{{ $item->id }}"
                                                                    style="display: flex; align-items: center;">
                                                                    <div class="nama-obat"
                                                                        style="margin-right: 10px; margin-top: 12px; display: flex; gap: 10px; align-items: center; width: 100%;">
                                                                        <div class="input-row d-flex" style="flex: 1;">
                                                                            <input type="text"
                                                                                name="obat_Ro[{{ $index }}][namaObatUpdate]"
                                                                                id="obat_Ro_{{ $item->id }}_{{ $index }}"
                                                                                data-pasien-id="{{ $item->id }}"
                                                                                value="{{ $namaObat }}"
                                                                                class="form-control text-center border-primary obat-input"
                                                                                style="font-size: 14px; font-weight: bold; width: 180px"
                                                                                placeholder="Cari Obat..." />
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-hapus"
                                                                                style="margin-left: 10px; font-size: 14px;"
                                                                                data-pasien-id="{{ $item->id }}"
                                                                                data-index="{{ $index }}"
                                                                                data-nama-obat="{{ $namaObat }}"
                                                                                data-harga="{{ $hargaPokok }}">
                                                                                <i class="fa-solid fa-trash"
                                                                                    style="justify-content: start"></i>
                                                                            </button>

                                                                            {{-- <div id="dropdown-namaobat-apoteker-{{ $item->id }}-{{ $index }}" class="dropdown-menu" data-pasien-id="{{ $item->id }}" style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 30%;"></div> --}}

                                                                            <div class="search-results border-primary"
                                                                                id="results-{{ $item->id }}-{{ $index }}"
                                                                                data-pasien-id="{{ $item->id }}"
                                                                                style="width: 170px; position: absolute; z-index: 1000; background: white; border: 1px solid #ccc; display: none; cursor: pointer;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-row" style="flex: 0 0 auto;">
                                                                            <select
                                                                                name="obat_Ro[{{ $index }}][anjuran]"
                                                                                id="anjuran_{{ $item->id }}_{{ $index }}"
                                                                                class="form-control border-primary text-center"
                                                                                style="font-size: 14px;">
                                                                                {{-- <option value="-" selected >-</option> --}}
                                                                                <option value="AC"
                                                                                    {{ $anjuran == 'AC' ? 'selected' : '' }}>
                                                                                    AC</option>
                                                                                <option value="AD"
                                                                                    {{ $anjuran == 'AD' ? 'selected' : '' }}>
                                                                                    AD</option>
                                                                                <option value="AS"
                                                                                    {{ $anjuran == 'AS' ? 'selected' : '' }}>
                                                                                    AS</option>
                                                                                <option value="C"
                                                                                    {{ $anjuran == 'C' ? 'selected' : '' }}>
                                                                                    C</option>
                                                                                <option value="CTH"
                                                                                    {{ $anjuran == 'CTH' ? 'selected' : '' }}>
                                                                                    CTH</option>
                                                                                <option value="DC"
                                                                                    {{ $anjuran == 'DC' ? 'selected' : '' }}>
                                                                                    DC</option>
                                                                                <option value="PC"
                                                                                    {{ $anjuran == 'PC' ? 'selected' : '' }}>
                                                                                    PC</option>
                                                                                <option value="OD"
                                                                                    {{ $anjuran == 'OD' ? 'selected' : '' }}>
                                                                                    OD</option>
                                                                                <option value="OS"
                                                                                    {{ $anjuran == 'OS' ? 'selected' : '' }}>
                                                                                    OS</option>
                                                                                <option value="ODS"
                                                                                    {{ $anjuran == 'ODS' ? 'selected' : '' }}>
                                                                                    ODS</option>
                                                                                <option value="PRM"
                                                                                    {{ $anjuran == 'PRM' ? 'selected' : '' }}>
                                                                                    PRM</option>
                                                                                <option value="UE"
                                                                                    {{ $anjuran == 'UE' ? 'selected' : '' }}>
                                                                                    UE</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>Kosong</p>
                                                        @endif
                                                    </div>
                                                </td>

                                                {{-- ATURAN MINUM --}}
                                                <td>
                                                    <div class="minum mt-3"
                                                        style="display: flex; align-items: center; gap: 15px; justify-content: center">
                                                        <div class="ngombe">
                                                            @php
                                                                $aturanMinum =
                                                                    json_decode(
                                                                        $item->obat->soap->soap_p_aturan,
                                                                        true,
                                                                    ) ?? [];
                                                                $minumAturan =
                                                                    json_decode(
                                                                        $item->obat->soap->soap_r_minumRacikan,
                                                                        true,
                                                                    ) ?? []; // Decode JSON menjadi array

                                                                // Gabungkan data aturan minum dari kedua sumber
                                                                $allMinumAturan = array_merge(
                                                                    (array) $aturanMinum,
                                                                    array_filter((array) $minumAturan),
                                                                );
                                                                // dd($allMinumAturan);
                                                            @endphp

                                                            {{-- ATURAN MINUM --}}
                                                            @if (!empty($allMinumAturan))
                                                                @foreach ($allMinumAturan as $index => $minum)
                                                                    <div class="form-group"
                                                                        style="display: flex; align-items: center;">
                                                                        <div class="input-group">
                                                                            <select
                                                                                name="obat_Ro[{{ $index }}][sehari]"
                                                                                id="sehari[{{ $index }}]"
                                                                                style="min-width: 80px; margin-right: 10px; width: 50px; font-weight: bold"
                                                                                class="form-control border border-primary text-center">
                                                                                <option value="1x1"
                                                                                    {{ $minum == '1x1' ? 'selected' : '' }}>
                                                                                    1x1</option>
                                                                                <option value="2x1"
                                                                                    {{ $minum == '2x1' ? 'selected' : '' }}>
                                                                                    2x1</option>
                                                                                <option value="3x1"
                                                                                    {{ $minum == '3x1' ? 'selected' : '' }}>
                                                                                    3x1</option>
                                                                                <option value="4x1"
                                                                                    {{ $minum == '4x1' ? 'selected' : '' }}>
                                                                                    4x1</option>
                                                                                <option value="5x1"
                                                                                    {{ $minum == '5x1' ? 'selected' : '' }}>
                                                                                    5x1</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <select
                                                                                name="obat_Ro[{{ $index }}][aturan]"
                                                                                id="aturan[{{ $index }}]"
                                                                                class="form-control mt-1 mb-1 border border-primary text-black"
                                                                                style="font-size: 14px; width: auto; font-weight: bold">
                                                                                <option value="Sesudah Makan"
                                                                                    {{ $minum == 'Sesudah Makan' ? 'selected' : '' }}>
                                                                                    Sesudah Makan</option>
                                                                                <option value="Sebelum Makan"
                                                                                    {{ $minum == 'Sebelum Makan' ? 'selected' : '' }}>
                                                                                    Sebelum Makan</option>
                                                                                <option value="Bersama Makan"
                                                                                    {{ $minum == 'Bersama Makan' ? 'selected' : '' }}>
                                                                                    Bersama Makan</option>
                                                                                <option value="Dilarutkan"
                                                                                    {{ $minum == 'Dilarutkan' ? 'selected' : '' }}>
                                                                                    Dilarutkan</option>
                                                                                <option value="Dioleskan"
                                                                                    {{ $minum == 'Dioleskan' ? 'selected' : '' }}>
                                                                                    Dioleskan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <p>Kosong</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- JUMLAH OBAT --}}
                                                <td>
                                                    <div class="jumlah mt-3" data-pasien-id="{{ $item->id }}">
                                                        @php
                                                            // Decode JSON menjadi array
                                                            $jmlhP =
                                                                json_decode($item->obat->soap->soap_p_jumlah, true) ??
                                                                [];
                                                            $jmlhR =
                                                                json_decode(
                                                                    $item->obat->soap->soap_r_jumlahObatRacikan,
                                                                    true,
                                                                ) ?? [];

                                                            // Hanya ambil nilai yang tidak null atau kosong
                                                            $jmlhP = array_filter(
                                                                $jmlhP,
                                                                fn($value) => !is_null($value) && $value !== '',
                                                            );
                                                            $jmlhR = array_filter(
                                                                $jmlhR,
                                                                fn($value) => !is_null($value) && $value !== '',
                                                            );

                                                            // Gabungkan kedua array jumlah
                                                            $allJumlah = array_merge($jmlhP, $jmlhR);

                                                            // jenis obat
                                                            $jenisObat =
                                                                json_decode(
                                                                    $item->obat->soap->soap_p_jenisobat,
                                                                    true,
                                                                ) ?? [];
                                                            $bangsaObat =
                                                                json_decode(
                                                                    $item->obat->soap->soap_r_jenisObatRacikan,
                                                                    true,
                                                                ) ?? [];

                                                            // Hanya ambil jenis obat yang sesuai
                                                            $jenisObat = array_filter(
                                                                $jenisObat,
                                                                fn($value) => !is_null($value) && $value !== '',
                                                            );
                                                            $bangsaObat = array_filter(
                                                                $bangsaObat,
                                                                fn($value) => !is_null($value) && $value !== '',
                                                            );

                                                            // Gabungkan kedua array jenis obat
                                                            $allJenisObat = array_merge($jenisObat, $bangsaObat);

                                                            // Hitung total jumlah
                                                            $totalJumlah = array_sum(array_map('intval', $allJumlah));
                                                        @endphp

                                                        {{-- Tampilkan jenis obat dengan jumlahnya --}}
                                                        <div class="form-group"
                                                            style="display: contents; align-items: center;">
                                                            @if (!empty($allJenisObat))
                                                                @foreach ($allJenisObat as $index => $jenis)
                                                                    @php
                                                                        $jumlah = $allJumlah[$index] ?? 0;
                                                                    @endphp
                                                                    <div class="jmlh">
                                                                        <div class="input-row"
                                                                            style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                                                            <select
                                                                                name="obat_Ro[{{ $index }}][jenisObat]"
                                                                                id="jenisObat[{{ $index }}]"
                                                                                style="min-width: 100px; margin-right: 10px; width: 100px; font-weight: bold"
                                                                                class="form-control border border-primary text-center">
                                                                                <option value="Tablet"
                                                                                    {{ $jenis == 'Tablet' ? 'selected' : '' }}>
                                                                                    Tablet</option>
                                                                                <option value="Kapsul"
                                                                                    {{ $jenis == 'Kapsul' ? 'selected' : '' }}>
                                                                                    Kapsul</option>
                                                                                <option value="Bungkus"
                                                                                    {{ $jenis == 'Bungkus' ? 'selected' : '' }}>
                                                                                    Bungkus</option>
                                                                                <option value="Salep"
                                                                                    {{ $jenis == 'Salep' ? 'selected' : '' }}>
                                                                                    Salep</option>
                                                                                <option value="Krim"
                                                                                    {{ $jenis == 'Krim' ? 'selected' : '' }}>
                                                                                    Krim</option>
                                                                                <option value="Mililiter"
                                                                                    {{ $jenis == 'Mililiter' ? 'selected' : '' }}>
                                                                                    Mililiter</option>
                                                                                <option value="Sendok Teh"
                                                                                    {{ $jenis == 'Sendok Teh' ? 'selected' : '' }}>
                                                                                    Sendok Teh</option>
                                                                                <option value="Sendok Makan"
                                                                                    {{ $jenis == 'Sendok Makan' ? 'selected' : '' }}>
                                                                                    Sendok Makan</option>
                                                                                <option value="Tetes"
                                                                                    {{ $jenis == 'Tetes' ? 'selected' : '' }}>
                                                                                    Tetes</option>
                                                                                <option value="Puyer/Racikan"
                                                                                    {{ $jenis == 'Puyer/Racikan' ? 'selected' : '' }}>
                                                                                    Puyer/Racikan</option>
                                                                            </select>
                                                                            <span>:</span>
                                                                            <input type="text"
                                                                                name="obat_Ro[{{ $index }}][jumlah]"
                                                                                id="jumlah[{{ $index }}]"
                                                                                class="form-control jumlahObatt"
                                                                                data-pasien-id="{{ $item->id }}"
                                                                                value="{{ $jumlah }}"
                                                                                style="width: 70px"
                                                                                placeholder="Jumlah">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <p>Kosong</p>
                                                            @endif
                                                        </div>

                                                        {{-- Tampilkan total jumlah --}}
                                                        {{-- <div class="jmlah-total mt-2" data-group="jumlahObatt_{{ $index }}" style="display: flex; justify-content: center; align-items: center; height: 50%;">
                                                    <div class="input-row">
                                                        <input type="text" name="" class="form-control border-primary text-center jumlahTotal" disabled value="{{ $totalJumlah }}" style="font-size: 20px; font-weight: bold; width: 50px;">
                                                    </div>
                                                </div> --}}
                                                    </div>
                                                </td>

                                                {{-- HARGA/TABLET --}}
                                                <td>
                                                    <div class="harga-tablet mr-3"
                                                        data-pasien-id="{{ $item->id }}" id="hargaTablet">
                                                        @php
                                                            // Fungsi untuk memformat harga ke dalam format Rupiah
                                                            if (!function_exists('Rupiah')) {
                                                                function Rupiah($angka)
                                                                {
                                                                    return 'Rp ' . number_format($angka, 2, ',', '.');
                                                                }
                                                            }

                                                            // Ambil data harga jual dari model resep dan simpan dalam array associative
                                                            $hargaJualData = $reseps->keyBy('nama_obat'); // Pastikan $reseps adalah koleksi dari model Resep

                                                            // Decode JSON menjadi array
                                                            $regoObat =
                                                                json_decode($item->obat->soap->soap_p, true) ?? [];
                                                            $regoObatRacikan =
                                                                json_decode($item->obat->soap->soap_r, true) ?? [];

                                                            // Gabungkan semua obat
                                                            $regoDewedewe = array_merge(
                                                                (array) $regoObat,
                                                                array_filter((array) $regoObatRacikan),
                                                            );
                                                            // dd($regoDewedewe);
                                                        @endphp

                                                        {{-- Gabungan obat racikan dan resep --}}
                                                        @if (is_array($regoDewedewe) && count($regoDewedewe) > 0)
                                                            @foreach ($regoDewedewe as $namaObat)
                                                                @php
                                                                    // Dapatkan harga jual berdasarkan nama obat
                                                                    $hargaJual =
                                                                        $hargaJualData->get($namaObat)->harga_jual ??
                                                                        '0,00'; // Default ke 0 jika tidak ada
                                                                @endphp
                                                                <div class="form-group" style="margin-top: -20px">
                                                                    <label for="harga"></label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text mt-2"
                                                                                style="background: rgb(228, 228, 228)">
                                                                                <b>Rp.</b>
                                                                            </span>
                                                                        </div>
                                                                        {{-- Tampilkan harga dengan format Rupiah --}}
                                                                        <input type="text"
                                                                            name="obat_Ro[{{ $loop->index }}][hargaTablet]"
                                                                            id="hargaTablet[{{ $loop->index }}]"
                                                                            class="form-control mt-2 text-end hargaTablet"
                                                                            data-pasien-id="{{ $item->id }}"
                                                                            readonly value="{{ $hargaJual }}">
                                                                    </div>
                                                                </div> <!-- Menampilkan nama obat dan harga jual -->
                                                            @endforeach
                                                        @else
                                                            <p>Tidak ada obat yang tersedia</p>
                                                        @endif
                                                    </div>
                                                </td>

                                                {{-- HARGA TOTAL --}}
                                                <td>
                                                    <div class="harga-total mr-3"
                                                        data-pasien-id="{{ $item->id }}">
                                                        @php
                                                            if (!function_exists('Rupiah')) {
                                                                function Rupiah($angka)
                                                                {
                                                                    return 'Rp ' . number_format($angka, 2, ',', '.');
                                                                }
                                                            }

                                                            $hargaJualData = $reseps->keyBy('nama_obat');
                                                            $obatData =
                                                                json_decode($item->obat->soap->soap_p, true) ?? [];
                                                            $obatRacikanData =
                                                                json_decode($item->obat->soap->soap_r, true) ?? [];
                                                            $jmlhP =
                                                                json_decode($item->obat->soap->soap_p_jumlah, true) ??
                                                                [];
                                                            $jmlhR =
                                                                json_decode(
                                                                    $item->obat->soap->soap_r_jumlahObatRacikan,
                                                                    true,
                                                                ) ?? [];
                                                            $semuaObat = array_merge($obatData, $obatRacikanData);
                                                            $allJumlah = array_merge($jmlhP, $jmlhR);
                                                        @endphp

                                                        @if (is_array($semuaObat) && count($semuaObat) > 0)
                                                            @foreach ($semuaObat as $index => $namaObat)
                                                                @php
                                                                    $hargaJual =
                                                                        $hargaJualData->get($namaObat)->harga_jual ?? 0;
                                                                    $jumlahObat = $allJumlah[$index] ?? 0;
                                                                    $totalHarga = $hargaJual * $jumlahObat;
                                                                @endphp
                                                                <div class="form-group" style="margin-top: -20px">
                                                                    <label for="harga"></label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text mt-2"
                                                                                style="background: rgb(228, 228, 228)">
                                                                                <b>Rp.</b>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text"
                                                                            name="obat_Ro[{{ $index }}][hargaTotal]"
                                                                            data-pasien-id="{{ $item->id }}"
                                                                            id="TotalHarga_{{ $item->id }}_{{ $index }}"
                                                                            class="form-control mt-2 text-end harga_total"
                                                                            value="{{ $totalHarga }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>Tidak ada obat yang tersedia</p>
                                                        @endif
                                                    </div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="racikan">Obat Racikan</label>
                                    <textarea name="obat_racikan" id="obat_racikan" class="form-control mt-2" rows="3" disabled>{{ $item->obat->soap->ObatRacikan ?? 'Tidak ada obat racikan' }}</textarea>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="tambahan">Aturan Tambahan</label>
                                    <textarea name="aturan_tambahan" id="aturanTambah" class="form-control mt-2" id="aturan_tambahan" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3" style="justify-content: end">
                                <div class="form-group">
                                    <label for="total_semua"><strong>TOTAL HARGA KESELURUHAN</strong></label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2"
                                                style="background: rgb(228, 228, 228); padding: 12px 17px; font-size: 30px;">
                                                <b>Rp.</b>
                                            </span>
                                        </div>
                                        <input type="text" name="totalSemuaHarga"
                                            data-pasien-id="{{ $item->id }}" id="totalSemuaHarga"
                                            class="form-control mt-2 text-end" readonly
                                            style="padding: 12px 17px; font-size: 28px;" placeholder="Total Semua">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success" onclick="printCard()">Cetak</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        .info-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 40px;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 50px;
            flex: 1 1 200px;
            /* Adjust the flex-basis if needed */
        }

        .info-item label {
            font-weight: bold;
            margin-right: 0.5rem;
        }

        .info-item p {
            margin: 0;
        }
    </style>
@endpush

@push('script')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        // CARI OBAT DAN GANTI
        $(document).ready(function() {
            $('.obat-input').each(function() {
                const input = $(this);
                const previousValue = input.val(); // Menyimpan nilai sebelumnya

                input.on('focus', function() {
                    input.val(''); // Kosongkan saat kolom diklik
                }).on('blur', function() {
                    if (input.val() === '') {
                        input.val(previousValue); // Kembalikan nilai sebelumnya jika kosong
                    }
                });

                input.on('input', function() {
                    const [patientId, index] = input.attr('id').match(/_(\d+)_(\d+)/).slice(
                        1); // Mendapatkan patientId dan index
                    const query = input.val();

                    if (query.length > 1) { // Minimal dua karakter untuk memulai pencarian
                        $.ajax({
                            url: '/cariObat-ganti',
                            data: {
                                term: query
                            },
                            success: function(data) {
                                let resultsContainer = $('#results-' + patientId + '-' +
                                    index);
                                resultsContainer.empty(); // Kosongkan hasil sebelumnya
                                resultsContainer.show(); // Tampilkan hasil

                                if (data.length) {
                                    $.each(data, function(i, item) {
                                        resultsContainer.append(
                                            '<div class="result-item" data-id="' +
                                            item.id + '">' + item.text +
                                            '</div>');
                                    });
                                } else {
                                    resultsContainer.append(
                                        '<div>Tidak ada hasil</div>');
                                }
                            },
                            delay: 100 // Mengurangi delay untuk pemanggilan AJAX
                        });
                    } else {
                        $('#results-' + patientId + '-' + index)
                            .hide(); // Sembunyikan jika kurang dari dua karakter
                    }
                });
            });

            // Menangani klik pada hasil pencarian
            $(document).on('click', '.result-item', function() {
                const itemId = $(this).data('id');
                const itemName = $(this).text();
                const input = $(this).closest('.nama-obat').find('.obat-input');

                input.val(itemName); // Set nilai input dengan nama obat yang dipilih
                $('#results-' + input.attr('id').match(/_(\d+)_(\d+)/)[1] + '-' + input.attr('id').match(
                    /_(\d+)_(\d+)/)[2]).hide(); // Sembunyikan hasil

                // Menyembunyikan semua hasil setelah pemilihan obat
                $('.search-results').hide();
            });

            // Sembunyikan hasil saat mengklik di luar
            $(document).click(function(e) {
                if (!$(e.target).closest('.nama-obat').length) {
                    $('.search-results').hide();
                }
            });
        });

        // document.addEventListener('DOMContentLoaded', function () {
        //     document.querySelectorAll('.obat-input').forEach(input => {
        //         const previousValue = input.value; // Menyimpan nilai sebelumnya
        //         let currentPage = 1; // Halaman awal untuk pagination

        //         input.addEventListener('focus', () => {
        //             input.value = ''; // Kosongkan saat kolom diklik
        //         });

        //         input.addEventListener('blur', () => {
        //             if (input.value === '') {
        //                 input.value = previousValue; // Kembalikan nilai sebelumnya jika kosong
        //             }
        //             setTimeout(() => { 
        //                 const dropdownId = `dropdown-namaobat-apoteker-${input.dataset.pasienId}-${input.dataset.index}`;
        //                 const dropdownElement = document.getElementById(dropdownId);
        //                 dropdownElement.style.display = 'none'; // Sembunyikan dropdown setelah blur
        //             }, 200);
        //         });

        //         input.addEventListener('input', () => {
        //             const term = input.value;
        //             const [patientId, index] = input.id.match(/_(\d+)_(\d+)/).slice(1); 
        //             const dropdownId = `dropdown-namaobat-apoteker-${patientId}-${index}`;
        //             const dropdownElement = document.getElementById(dropdownId);

        //             if (term.length >= 4) { // Minimal empat karakter untuk memulai pencarian
        //                 currentPage = 1; // Reset ke halaman pertama setiap kali input berubah
        //                 searchObat(term, currentPage, function(results, totalPages) {
        //                     showDropdown(input, dropdownElement, results, totalPages);
        //                 });
        //             } else {
        //                 dropdownElement.style.display = 'none'; // Sembunyikan dropdown jika kurang dari empat karakter
        //             }
        //         });
        //     });

        //     // Fungsi untuk menampilkan hasil pencarian dan pagination dalam dropdown
        //     function showDropdown(inputElement, dropdownElement, results, totalPages) {
        //         dropdownElement.innerHTML = ''; // Bersihkan dropdown sebelumnya
        //         if (results.length === 0) {
        //             dropdownElement.style.display = 'none';
        //             return;
        //         }

        //         results.forEach(result => {
        //             const option = document.createElement('div');
        //             option.classList.add('dropdown-item');
        //             option.textContent = result.text; // Tampilkan nama obat
        //             option.dataset.id = result.id;

        //             // Pilih obat ketika salah satu item diklik
        //             option.addEventListener('click', () => {
        //                 inputElement.value = result.text;
        //                 dropdownElement.style.display = 'none'; // Sembunyikan dropdown setelah dipilih
        //             });

        //             dropdownElement.appendChild(option);
        //         });

        //         // Tampilkan tombol untuk halaman berikutnya jika ada lebih dari satu halaman
        //         if (totalPages > 1) {
        //             const paginationDiv = document.createElement('div');
        //             paginationDiv.classList.add('pagination-controls');

        //             // Tombol untuk halaman sebelumnya
        //             const prevButton = document.createElement('button');
        //             prevButton.textContent = 'Previous';
        //             prevButton.disabled = (currentPage === 1); // Nonaktifkan jika di halaman pertama
        //             prevButton.addEventListener('click', () => {
        //                 currentPage--;
        //                 searchObat(inputElement.value, currentPage, function(results, totalPages) {
        //                     showDropdown(inputElement, dropdownElement, results, totalPages);
        //                 });
        //             });

        //             // Tombol untuk halaman berikutnya
        //             const nextButton = document.createElement('button');
        //             nextButton.textContent = 'Next';
        //             nextButton.disabled = (currentPage === totalPages); // Nonaktifkan jika di halaman terakhir
        //             nextButton.addEventListener('click', () => {
        //                 currentPage++;
        //                 searchObat(inputElement.value, currentPage, function(results, totalPages) {
        //                     showDropdown(inputElement, dropdownElement, results, totalPages);
        //                 });
        //             });

        //             paginationDiv.appendChild(prevButton);
        //             paginationDiv.appendChild(nextButton);
        //             dropdownElement.appendChild(paginationDiv);
        //         }

        //         dropdownElement.style.display = 'block';
        //     }

        //     // Fungsi untuk mengambil hasil pencarian dari server
        //     function searchObat(term, page, callback) {
        //         fetch(`/cariObat-ganti?term=${encodeURIComponent(term)}&page=${page}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 console.log(data); 
        //                 callback(data.data, data.total_pages);
        //             })
        //             .catch(error => console.error('Error:', error));
        //     }

        //     // Menyembunyikan dropdown saat mengklik di luar elemen dropdown atau input
        //     document.addEventListener('click', function (e) {
        //         if (!e.target.closest('.dropdown-menu') && !e.target.classList.contains('obat-input')) {
        //             document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
        //                 dropdown.style.display = 'none';
        //             });
        //         }
        //     });
        // });

        // $(document).ready(function() {
        //     $('.obat-input').each(function() {
        //         const input = $(this);
        //         const previousValue = input.val(); // Menyimpan nilai sebelumnya

        //         input.on('focus', function() {
        //             input.val(''); // Kosongkan saat kolom diklik
        //         }).on('blur', function() {
        //             if (input.val() === '') {
        //                 input.val(previousValue); // Kembalikan nilai sebelumnya jika kosong
        //             }
        //         });

        //         input.on('input', function() {
        //             const [patientId, index] = input.attr('id').match(/_(\d+)_(\d+)/).slice(1); // Mendapatkan patientId dan index
        //             const query = input.val();

        //             if (query.length > 1) { // Minimal dua karakter untuk memulai pencarian
        //                 $.ajax({
        //                     url: '/cariObat-ganti',
        //                     data: { term: query },
        //                     success: function(data) {
        //                         let resultsContainer = $('#results-' + patientId + '-' + index);
        //                         resultsContainer.empty(); // Kosongkan hasil sebelumnya
        //                         resultsContainer.show(); // Tampilkan hasil

        //                         if (data.length) {
        //                             $.each(data, function(i, item) {
        //                                 resultsContainer.append('<div class="result-item" data-id="' + item.id + '">' + item.text + '</div>');
        //                             });
        //                         } else {
        //                             resultsContainer.append('<div>Tidak ada hasil</div>');
        //                         }
        //                     },
        //                     delay: 100 // Mengurangi delay untuk pemanggilan AJAX
        //                 });
        //             } else {
        //                 $('#results-' + patientId + '-' + index).hide(); // Sembunyikan jika kurang dari dua karakter
        //             }
        //         });
        //     });

        //     // Menangani klik pada hasil pencarian
        //     $(document).on('click', '.result-item', function() {
        //         const itemId = $(this).data('id');
        //         const itemName = $(this).text();
        //         const input = $(this).closest('.nama-obat').find('.obat-input');

        //         input.val(itemName); // Set nilai input dengan nama obat yang dipilih
        //         $('#results-' + input.attr('id').match(/_(\d+)_(\d+)/)[1] + '-' + input.attr('id').match(/_(\d+)_(\d+)/)[2]).hide(); // Sembunyikan hasil
        //     });

        //     // Sembunyikan hasil saat mengklik di luar
        //     $(document).click(function(e) {
        //         if (!$(e.target).closest('.nama-obat').length) {
        //             $('.search-results').hide();
        //         }
        //     });
        // });

        // PERUBAHAN HARGA TABLET MENYESUAIKAN PERUBAHAN NAMA OBAT
        $(document).ready(function() {
            var previousPrices = {};

            // Fokus pada input untuk menyimpan harga sebelumnya
            $(document).on('focus', '.obat-input', function() {
                var input = $(this);
                var pasienId = input.data('pasien-id'); // Ambil ID pasien
                var index = input.attr('id').split('_').pop();
                var hargaInput = $('#hargaTablet\\[' + index + '\\][data-pasien-id="' + pasienId +
                    '"]'); // Pastikan sesuai pasien dan index
                var previousHarga = hargaInput.val();
                previousPrices[index] = previousHarga;
            });

            // AJAX untuk saran obat saat pengguna mengetik
            $(document).on('input', '.obat-input', function() {
                var input = $(this);
                var namaObat = input.val();
                var pasienId = input.data('pasien-id');
                var index = input.attr('id').split('_').pop();
                var resultsContainer = $('#results-' + pasienId + '-' + index);

                if (namaObat.length > 3) {
                    $.ajax({
                        url: '/gantiObat-RegoGanti',
                        type: 'GET',
                        data: {
                            nama_obat: namaObat
                        },
                        success: function(response) {
                            if (response.success && response.data.length > 0) {
                                resultsContainer.empty()
                                    .show(); // Bersihkan hasil dan tampilkan

                                let obatFound = false;
                                response.data.forEach(function(item) {
                                    var option = $('<div>')
                                        .addClass('result-item')
                                        .text(item.nama_obat)
                                        .data('harga', item.harga_jual)
                                        .data('id', item.id); // Simpan ID resep
                                    resultsContainer.append(option);

                                    // Jika input obat sama dengan nama di saran, otomatis update harga
                                    if (item.nama_obat.toLowerCase() === namaObat
                                        .toLowerCase()) {
                                        $('#hargaTablet\\[' + index +
                                            '\\][data-pasien-id="' + pasienId + '"]'
                                        ).val(item.harga_jual);
                                        previousPrices[index] = item
                                            .harga_jual; // Simpan harga baru
                                        obatFound = true;
                                    }
                                });

                                // Jika tidak ditemukan harga, kosongkan
                                if (!obatFound) {
                                    $('#hargaTablet\\[' + index + '\\][data-pasien-id="' +
                                        pasienId + '"]').val('');
                                }

                            } else {
                                resultsContainer.hide(); // Sembunyikan jika tidak ada hasil
                            }
                        }
                    });
                } else {
                    resultsContainer.hide(); // Sembunyikan jika input kurang dari 2 huruf
                }
            });

            // Menangani pemilihan obat dari hasil pencarian
            $(document).on('click', '.result-item', function() {
                var selectedObat = $(this).text();
                var harga = $(this).data('harga');
                var idObat = $(this).data('id'); // Ambil ID resep
                var pasienId = $(this).closest('.search-results').data('pasien-id'); // Ambil ID pasien
                var index = $(this).closest('.search-results').attr('id').split('-').pop();
                var input = $('#obat_Ro_' + pasienId + '_' + index); // Sesuaikan ID pasien
                var hargaInput = $('#hargaTablet\\[' + index + '\\][data-pasien-id="' + pasienId +
                    '"]'); // Sesuaikan ID pasien dan index

                input.val(selectedObat);
                hargaInput.val(harga);
                previousPrices[index] = harga;

                // Sembunyikan hasil pencarian setelah dipilih
                $(this).closest('.search-results').hide();

                // Panggil API berdasarkan ID obat yang dipilih untuk update harga
                $.ajax({
                    url: '/gantiObat-RegoGanti',
                    type: 'GET',
                    data: {
                        id_obat: idObat
                    },
                    success: function(response) {
                        if (response.success) {
                            hargaInput.val(response.data
                                .harga_jual); // Set harga berdasarkan ID
                            previousPrices[index] = response.data
                                .harga_jual; // Simpan harga baru
                        }
                    }
                });
            });

            // Mengembalikan harga jika input kosong
            $(document).on('blur', '.obat-input', function() {
                var input = $(this);
                var pasienId = input.data('pasien-id');
                var index = input.attr('id').split('_').pop();
                var hargaInput = $('#hargaTablet\\[' + index + '\\][data-pasien-id="' + pasienId + '"]');

                if (input.val().trim() === '') {
                    var previousHarga = previousPrices[index] || '0';
                    hargaInput.val(previousHarga);
                }
            });

            // HAPUS NAMA OBAT MERESET HARGA
            $(document).on('click', '.btn-hapus', function() {
                var pasienId = $(this).data('pasien-id');
                var index = $(this).data('index');
                var namaObatAwal = $(this).data('nama-obat');
                var hargaAwal = parseFloat($(this).data('harga')); // Pastikan harga adalah angka
                var jumlahAwal = parseInt($('#jumlah\\[' + index + '\\][data-pasien-id="' + pasienId + '"]')
                    .val()); // Ambil nilai jumlah awal

                var inputObat = $('#obat_Ro_' + pasienId + '_' + index);
                var hargaInput = $('#hargaTablet\\[' + index + '\\][data-pasien-id="' + pasienId + '"]');
                var totalHargaInput = $('#TotalHarga_' + pasienId + '_' + index);

                // Reset input ke nilai awal
                inputObat.val(namaObatAwal);
                hargaInput.val(hargaAwal);

                // Hitung harga total awal
                var hargaTotalAwal = jumlahAwal > 1 ? hargaAwal * jumlahAwal : hargaAwal;
                totalHargaInput.val(hargaTotalAwal); // Reset total harga untuk obat ini

                // Update total semua harga
                updateTotalSemuaHarga(pasienId);
            });

            // Fungsi untuk menghitung total semua harga
            function updateTotalSemuaHarga(pasienId) {
                var totalSemua = 0;
                $('.harga_total[data-pasien-id="' + pasienId + '"]').each(function() {
                    var harga = parseFloat($(this).val().replace(/[^\d.-]/g, '')) ||
                        0; // Menghapus format Rupiah
                    totalSemua += harga;
                });
                $('#totalSemuaHarga[data-pasien-id="' + pasienId + '"]').val(
                    totalSemua); // Update input total semua harga
            }

        });

        // JUMLAH OBAT
        document.addEventListener("DOMContentLoaded", function() {
            function updateTotalJumlah(pasienId) {
                const jumlahObatInputs = document.querySelectorAll(`.jumlahObatt[data-pasien-id="${pasienId}"]`);
                let totalJumlah = 0;

                // Loop untuk menjumlahkan semua nilai
                jumlahObatInputs.forEach(input => {
                    const jumlah = parseFloat(input.value) || 0; // Ambil nilai dan parse
                    totalJumlah += jumlah; // Tambahkan ke total
                });

                // Update total jumlah di input dengan class 'jumlahTotal' untuk pasien yang sama
                const totalInput = document.querySelector(`.jumlah[data-pasien-id="${pasienId}"] .jumlahTotal`);
                if (totalInput) {
                    totalInput.value = totalJumlah; // Set nilai total
                }

                console.log('Total Jumlah untuk pasien', pasienId, ':', totalJumlah); // Debugging
            }

            // Tambahkan event listener pada input jumlah
            const jumlahObatInputs = document.querySelectorAll('.jumlahObatt');
            jumlahObatInputs.forEach(input => {
                const pasienId = input.dataset.pasienId; // Ambil ID pasien dari data attribute
                input.addEventListener('input', () => updateTotalJumlah(
                    pasienId)); // Panggil fungsi saat input berubah
            });

            // Hitung total saat halaman pertama kali dimuat
            jumlahObatInputs.forEach(input => {
                const pasienId = input.dataset.pasienId; // Ambil ID pasien dari data attribute
                updateTotalJumlah(pasienId);
            });
        });

        // TOTAL SEMUA
        document.addEventListener("DOMContentLoaded", function() {
            // Fungsi untuk memformat angka ke format rupiah
            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Fungsi untuk menghapus format rupiah (menghapus titik) agar bisa diubah ke angka
            function unformatRupiah(angka) {
                return parseFloat(angka.replace(/\./g, '')); // Hapus titik untuk konversi ke angka
            }

            // Fungsi untuk mengupdate total harga berdasarkan jumlah obat dan harga per tablet
            function updateTotalHarga(pasienId) {
                const jumlahObatInputs = document.querySelectorAll(`.jumlahObatt[data-pasien-id="${pasienId}"]`);
                const hargaTabletInputs = document.querySelectorAll(`.hargaTablet[data-pasien-id="${pasienId}"]`);
                const hargaTotalInputs = document.querySelectorAll(`.harga_total[data-pasien-id="${pasienId}"]`);

                jumlahObatInputs.forEach((jumlahInput, index) => {
                    const jumlah = parseFloat(jumlahInput.value) || 0;
                    const hargaPerTablet = unformatRupiah(hargaTabletInputs[index].value) ||
                        0; // Unformat harga terlebih dahulu

                    // Hitung total harga per obat
                    const totalHarga = hargaPerTablet * jumlah;

                    // Update input harga total dengan format rupiah
                    if (hargaTotalInputs[index]) {
                        hargaTotalInputs[index].value = formatRupiah(totalHarga.toFixed(0));
                    }
                });

                // Setelah total harga setiap obat diperbarui, hitung total keseluruhan untuk pasien
                updateTotalSemua(pasienId);
            }

            // Fungsi untuk mengupdate total harga keseluruhan untuk pasien tertentu
            function updateTotalSemua(pasienId) {
                let totalSemua = 0;

                // Pilih semua input harga_total untuk pasien yang sesuai
                const hargaInputs = document.querySelectorAll(`.harga_total[data-pasien-id="${pasienId}"]`);

                hargaInputs.forEach(function(input) {
                    const harga = unformatRupiah(input.value) || 0; // Unformat harga sebelum penjumlahan
                    totalSemua += harga;
                });

                // Update totalSemuaHarga dengan format rupiah
                const totalSemuaInput = document.querySelector(`#totalSemuaHarga[data-pasien-id="${pasienId}"]`);
                if (totalSemuaInput) {
                    totalSemuaInput.value = formatRupiah(totalSemua.toFixed(0));
                }
            }

            // Event listener untuk perubahan pada input jumlah dan harga
            const jumlahObatInputs = document.querySelectorAll('.jumlahObatt');
            jumlahObatInputs.forEach(input => {
                const pasienId = input.getAttribute('data-pasien-id');
                input.addEventListener('input', function() {
                    updateTotalHarga(pasienId);
                });
            });

            const hargaTabletInputs = document.querySelectorAll('.hargaTablet');
            hargaTabletInputs.forEach(input => {
                const pasienId = input.getAttribute('data-pasien-id');
                input.addEventListener('input', function() {
                    updateTotalHarga(
                        pasienId
                    ); // Memanggil updateTotalHarga juga akan memanggil updateTotalSemua
                });
            });

            // Inisialisasi perhitungan total saat halaman dimuat
            jumlahObatInputs.forEach(input => {
                const pasienId = input.getAttribute('data-pasien-id');
                updateTotalHarga(pasienId);
            });
        });
    </script>
@endpush

{{-- <div class="row">
    <div class="row obat-row" style="margin-top: -10px">
        <div class="col-lg-3">
            <div class="form-group mt-3">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" name="resep[]" value="{{ $obat }}" class="form-control mt-2 nama_obat">
            </div>
        </div>
        <div class="col-lg-5">
            <div class="form-group mt-3">
                <label for="">Aturan Minum</label>
                <div class="input-group">
                    <input type="text" name="aturan_minum[]" value="{{ isset($aturanMinum[$namaObat]) ? $aturanMinum[$namaObat] : '' }}" class="form-control mt-2">
                    <select name="aturan[]" class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                        <option value="{{ isset($soapData[$obat]) ? $soapData[$obat] : '' }}">{{ isset($soapData[$obat]) ? $soapData[$obat] : '' }}</option>
                        <option value="Sesudah Makan" style="background: white">Sesudah Makan</option>
                        <option value="Sebelum Makan" style="background: white">Sebelum Makan</option>
                        <option value="Bersama Makan" style="background: white">Bersama Makan</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah[]" class="form-control mt-2 jumlah" placeholder="Jumlah" oninput="calculateTotal(this)">
            </div>
        </div>
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <label for="harga_satuan">Harga</label>
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                            <b>Rp.</b>
                        </span>
                    </div>
                    <input type="number" name="harga_satuan[]" class="form-control mt-2 harga_satuan" value="{{ $reseps->where('nama_obat', $obat)->first()->harga }}" placeholder="Harga Satuan" readonly>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <label for="total">Total</label>
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                            <b>Rp.</b>
                        </span>
                    </div>
                    <input type="number" name="harga_obat[]" class="form-control mt-2 total_harga" placeholder="Total Harga" readonly>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <label for="satuan">Satuan</label>
                <select name="satuan[]" class="form-control mt-2">
                    <option value="">--Pilih--</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Kapsul">Kapsul</option>
                    <option value="Bungkus">Bungkus</option>
                    <option value="Salep">Salep</option>
                    <option value="Krim">Krim</option>
                    <option value="Ml">Ml</option>
                    <option value="Sendok Sirup">Sendok Teh</option>
                    <option value="Sendok Makan">Sendok Makan</option>
                    <option value="Tetes">Tetes</option>
                </select>
            </div>
        </div>
    </div>
</div> --}}
