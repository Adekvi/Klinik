<!-- Modal Resep BARU -->
<div class="modal fade" id="tambahObat{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
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
                                        style="overflow: auto; min-width: 165%;">
                                        <thead class="table-primary text-center text-nowrap">
                                            <tr>
                                                <th>NAMA OBAT</th>
                                                <th>ATURAN PENGGUNAAN</th>
                                                <th>JUMLAH OBAT</th>
                                                <th>HARGA/TABLET</th>
                                                <th>TOTAL HARGA</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            {{-- {{ dd($antrianObat) }} --}}

                                            {{-- NAMA OBAT --}}
                                            <td>
                                                <div class="obat-container" data-pasien-id="{{ $item->id }}">
                                                    @php
                                                        $semuaObat = json_decode($item->obat->obat_Ro, true) ?? [];
                                                        $anjuranMinum =
                                                            json_decode($item->obat->soap->soap_p_anjuran, true) ?? [];
                                                        $ngombe =
                                                            json_decode($item->obat->soap->soap_r_minum, true) ?? [];
                                                        $olehNgombe = array_merge(
                                                            (array) $anjuranMinum,
                                                            (array) $ngombe,
                                                        );
                                                        $aturanMinum =
                                                            json_decode($item->obat->soap->soap_p_aturan, true) ?? [];
                                                        $minumAturan =
                                                            json_decode($item->obat->soap->soap_r_minumRacikan, true) ??
                                                            [];
                                                        $allMinumAturan = array_merge(
                                                            (array) $aturanMinum,
                                                            array_filter((array) $minumAturan),
                                                        );
                                                        $hargaJualData = $reseps->keyBy('nama_obat');
                                                    @endphp

                                                    @if (!empty($semuaObat) && !empty($olehNgombe))
                                                        @foreach ($semuaObat as $index => $namaObat)
                                                            @php
                                                                $namaObat = is_array($namaObat)
                                                                    ? implode(', ', $namaObat)
                                                                    : $namaObat;
                                                                $anjuran = isset($olehNgombe[$index])
                                                                    ? $olehNgombe[$index]
                                                                    : 'AC';
                                                                $aturan = isset($allMinumAturan[$index])
                                                                    ? $allMinumAturan[$index]
                                                                    : 'Sebelum Makan';
                                                                $hargaPokok = $hargaJualData->contains(
                                                                    'nama_obat',
                                                                    $namaObat,
                                                                )
                                                                    ? $hargaJualData->get($namaObat)->harga_jual ?? '0'
                                                                    : '0';
                                                            @endphp
                                                            <div class="form-group obat-row">
                                                                <div class="nama-obat">
                                                                    <div class="input-row">
                                                                        <div class="nama-obat-container">
                                                                            <input type="text"
                                                                                name="obat_Ro[{{ $index }}][namaObatUpdate]"
                                                                                id="obat_Ro_{{ $item->id }}_{{ $index }}"
                                                                                data-pasien-id="{{ $item->id }}"
                                                                                data-index="{{ $index }}"
                                                                                value="{{ $namaObat }}"
                                                                                class="form-control obat-input"
                                                                                placeholder="Cari Obat..."
                                                                                aria-autocomplete="list"
                                                                                aria-controls="results-{{ $item->id }}-{{ $index }}" />
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-hapus"
                                                                                data-pasien-id="{{ $item->id }}"
                                                                                data-index="{{ $index }}"
                                                                                data-nama-obat="{{ $namaObat }}"
                                                                                data-harga="{{ $hargaPokok }}"
                                                                                aria-label="Hapus obat">
                                                                                <i class="fa-solid fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="search-results border-primary"
                                                                            id="results-{{ $item->id }}-{{ $index }}"
                                                                            role="listbox"></div>
                                                                    </div>
                                                                    <div class="anjuran">
                                                                        <input type="hidden"
                                                                            name="obat_Ro[{{ $index }}][anjuran]"
                                                                            id="anjuran_{{ $item->id }}_{{ $index }}"
                                                                            class="form-control anjuran-select"
                                                                            value="{{ $anjuran }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="no-data">Tidak ada obat</p>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- ATURAN MINUM -->
                                            <td>
                                                <div class="minum-container">
                                                    @if (!empty($allMinumAturan))
                                                        @foreach ($allMinumAturan as $index => $minum)
                                                            <div class="form-group minum-row">
                                                                <div class="input-group d-flex align-items-center">
                                                                    <!-- Dropdown untuk frekuensi minum -->
                                                                    <select name="obat_Ro[{{ $index }}][sehari]"
                                                                        id="sehari_{{ $item->id }}_{{ $index }}"
                                                                        class="form-control sehari-select"
                                                                        aria-label="Pilih frekuensi minum"
                                                                        onchange="toggleInput(this, '{{ $item->id }}_{{ $index }}')">
                                                                        <option value="1x1 SENDOK"
                                                                            {{ $minum == '1x1 SENDOK' ? 'selected' : '' }}>
                                                                            1x1 SENDOK</option>
                                                                        <option value="1x1/2 SENDOK"
                                                                            {{ $minum == '1x1/2 SENDOK' ? 'selected' : '' }}>
                                                                            1x1/2 SENDOK</option>
                                                                        <option value="1x3/4 SENDOK"
                                                                            {{ $minum == '1x3/4 SENDOK' ? 'selected' : '' }}>
                                                                            1x3/4 SENDOK</option>
                                                                        <option value="1x1 1/2 SENDOK"
                                                                            {{ $minum == '1x1 1/2 SENDOK' ? 'selected' : '' }}>
                                                                            1x1 1/2 SENDOK</option>
                                                                        <option value="2x1 SENDOK"
                                                                            {{ $minum == '2x1 SENDOK' ? 'selected' : '' }}>
                                                                            2x1 SENDOK</option>
                                                                        <option value="2x1/2 SENDOK"
                                                                            {{ $minum == '2x1/2 SENDOK' ? 'selected' : '' }}>
                                                                            2x1/2 SENDOK</option>
                                                                        <option value="2x3/4 SENDOK"
                                                                            {{ $minum == '2x3/4 SENDOK' ? 'selected' : '' }}>
                                                                            2x3/4 SENDOK</option>
                                                                        <option value="3x1 SENDOK"
                                                                            {{ $minum == '3x1 SENDOK' ? 'selected' : '' }}>
                                                                            3x1 SENDOK</option>
                                                                        <option value="3x1/2 SENDOK"
                                                                            {{ $minum == '3x1/2 SENDOK' ? 'selected' : '' }}>
                                                                            3x1/2 SENDOK</option>
                                                                        <option value="3x3/4 SENDOK"
                                                                            {{ $minum == '3x3/4 SENDOK' ? 'selected' : '' }}>
                                                                            3x3/4 SENDOK</option>
                                                                        <option value="3x1 1/2 SENDOK"
                                                                            {{ $minum == '3x1 1/2 SENDOK' ? 'selected' : '' }}>
                                                                            3x1 1/2 SENDOK</option>
                                                                        <option value="4x1 SENDOK"
                                                                            {{ $minum == '4x1 SENDOK' ? 'selected' : '' }}>
                                                                            4x1 SENDOK</option>
                                                                        <option value="4x1 1/2 SENDOK"
                                                                            {{ $minum == '4x1 1/2 SENDOK' ? 'selected' : '' }}>
                                                                            4x1 1/2 SENDOK</option>
                                                                        <option value="4x1/2 SENDOK"
                                                                            {{ $minum == '4x1/2 SENDOK' ? 'selected' : '' }}>
                                                                            4x1/2 SENDOK</option>
                                                                        <option value="4x3/4 SENDOK"
                                                                            {{ $minum == '4x3/4 SENDOK' ? 'selected' : '' }}>
                                                                            4x3/4 SENDOK</option>
                                                                        <option value="3x SEHARI OLES TIPIS-TIPIS"
                                                                            {{ $minum == '3x SEHARI OLES TIPIS-TIPIS' ? 'selected' : '' }}>
                                                                            3x SEHARI OLES TIPIS-TIPIS</option>
                                                                        <option value="2x SEHARI OLES TIPIS-TIPIS"
                                                                            {{ $minum == '2x SEHARI OLES TIPIS-TIPIS' ? 'selected' : '' }}>
                                                                            2x SEHARI OLES TIPIS-TIPIS</option>
                                                                        <option value="1x1 TABLET"
                                                                            {{ $minum == '1x1 TABLET' ? 'selected' : '' }}>
                                                                            1x1 TABLET</option>
                                                                        <option value="2x1 TABLET"
                                                                            {{ $minum == '2x1 TABLET' ? 'selected' : '' }}>
                                                                            2x1 TABLET</option>
                                                                        <option value="3x1 TABLET"
                                                                            {{ $minum == '3x1 TABLET' ? 'selected' : '' }}>
                                                                            3x1 TABLET</option>
                                                                        <option value="3x1 BUNGKUS"
                                                                            {{ $minum == '3x1 BUNGKUS' ? 'selected' : '' }}>
                                                                            3x1 BUNGKUS</option>
                                                                        <option value="3x2 TETES"
                                                                            {{ $minum == '3x2 TETES' ? 'selected' : '' }}>
                                                                            3x2 TETES</option>
                                                                        <option value="3x1 TETES"
                                                                            {{ $minum == '3x1 TETES' ? 'selected' : '' }}>
                                                                            3x1 TETES</option>
                                                                        <option value="4x2 TETES"
                                                                            {{ $minum == '4x2 TETES' ? 'selected' : '' }}>
                                                                            4x2 TETES</option>
                                                                        <option value="INJEKSI 1 ml"
                                                                            {{ $minum == 'INJEKSI 1 ml' ? 'selected' : '' }}>
                                                                            INJEKSI 1 ml</option>
                                                                        <option value="INJEKSI 2 ml"
                                                                            {{ $minum == 'INJEKSI 2 ml' ? 'selected' : '' }}>
                                                                            INJEKSI 2 ml</option>
                                                                        <option value="INJEKSI 3 ml"
                                                                            {{ $minum == 'INJEKSI 3 ml' ? 'selected' : '' }}>
                                                                            INJEKSI 3 ml</option>
                                                                        <option value="NEBUL 1 ampul"
                                                                            {{ $minum == 'NEBUL 1 ampul' ? 'selected' : '' }}>
                                                                            NEBUL 1 ampul</option>
                                                                        <option value="custom">Lainnya</option>
                                                                    </select>
                                                                    <!-- Input kustom untuk opsi "Lainnya" (awalnya disembunyikan) -->
                                                                    <input type="text"
                                                                        name="obat_Ro[{{ $index }}][sehari]"
                                                                        id="custom_sehari_{{ $item->id }}_{{ $index }}"
                                                                        class="form-control sehari-select custom-input d-none"
                                                                        placeholder="Masukkan aturan minum kustom"
                                                                        style="display: none;">
                                                                    <span class="separator">-</span>
                                                                    <!-- Input untuk aturan minum -->
                                                                    <input type="text"
                                                                        name="obat_Ro[{{ $index }}][aturan]"
                                                                        id="aturan_{{ $item->id }}_{{ $index }}"
                                                                        class="form-control aturan-select"
                                                                        value="Sebelum Makan">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="no-data">Kosong</p>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- JUMLAH OBAT -->
                                            <td>
                                                <div class="jumlah-container" data-pasien-id="{{ $item->id }}">
                                                    @php
                                                        $jmlhP =
                                                            json_decode($item->obat->soap->soap_p_jumlah, true) ?? [];
                                                        $jmlhR =
                                                            json_decode(
                                                                $item->obat->soap->soap_r_jumlahObatRacikan,
                                                                true,
                                                            ) ?? [];
                                                        $jmlhP = array_filter($jmlhP, function ($value) {
                                                            return !is_null($value) && $value !== '';
                                                        });
                                                        $jmlhR = array_filter($jmlhR, function ($value) {
                                                            return !is_null($value) && $value !== '';
                                                        });
                                                        $allJumlah = array_merge($jmlhP, $jmlhR);
                                                        $jenisObat =
                                                            json_decode($item->obat->soap->soap_p_jenisobat, true) ??
                                                            [];
                                                        $bangsaObat =
                                                            json_decode(
                                                                $item->obat->soap->soap_r_jenisObatRacikan,
                                                                true,
                                                            ) ?? [];
                                                        $jenisObat = array_filter($jenisObat, function ($value) {
                                                            return !is_null($value) && $value !== '';
                                                        });
                                                        $bangsaObat = array_filter($bangsaObat, function ($value) {
                                                            return !is_null($value) && $value !== '';
                                                        });
                                                        $allJenisObat = array_merge($jenisObat, $bangsaObat);
                                                    @endphp
                                                    @if (!empty($allJenisObat))
                                                        @foreach ($allJenisObat as $index => $jenis)
                                                            @php
                                                                $jumlah = $allJumlah[$index] ?? 0;
                                                            @endphp
                                                            <div class="form-group jumlah-row">
                                                                <div class="jumlah-group">
                                                                    <select
                                                                        name="obat_Ro[{{ $index }}][jenisObat]"
                                                                        id="jenisObat_{{ $item->id }}_{{ $index }}"
                                                                        class="form-control jenis-obat-select"
                                                                        aria-label="Pilih jenis obat">
                                                                        <option value="Tablet"
                                                                            {{ $jenis == 'Tablet' ? 'selected' : '' }}>
                                                                            Tablet</option>
                                                                        <option value="Kapsul"
                                                                            {{ $jenis == 'Kapsul' ? 'selected' : '' }}>
                                                                            Kapsul</option>
                                                                        <option value="Bungkus"
                                                                            {{ $jenis == 'Bungkus' ? 'selected' : '' }}>
                                                                            Bungkus</option>
                                                                        <option value="Sirup"
                                                                            {{ $jenis == 'Sirup' ? 'selected' : '' }}>
                                                                            Sirup</option>
                                                                        <option value="Salep"
                                                                            {{ $jenis == 'Salep' ? 'selected' : '' }}>
                                                                            Salep</option>
                                                                        <option value="Krim"
                                                                            {{ $jenis == 'Krim' ? 'selected' : '' }}>
                                                                            Krim</option>
                                                                        <option value="Fls"
                                                                            {{ $jenis == 'Fls' ? 'selected' : '' }}>
                                                                            Fls</option>
                                                                        <option value="Ampul"
                                                                            {{ $jenis == 'Ampul' ? 'selected' : '' }}>
                                                                            Ampul</option>
                                                                        <option value="Vial"
                                                                            {{ $jenis == 'Vial' ? 'selected' : '' }}>
                                                                            Vial</option>
                                                                        <option value="Puyer/Racikan"
                                                                            {{ $jenis == 'Puyer/Racikan' ? 'selected' : '' }}>
                                                                            Puyer/Racikan</option>
                                                                    </select>
                                                                    <span class="separator">:</span>
                                                                    <input type="text"
                                                                        name="obat_Ro[{{ $index }}][jumlah]"
                                                                        id="jumlah_{{ $item->id }}_{{ $index }}"
                                                                        class="form-control jumlah-input"
                                                                        data-pasien-id="{{ $item->id }}"
                                                                        data-index="{{ $index }}"
                                                                        value="{{ $jumlah }}"
                                                                        placeholder="Jumlah"
                                                                        aria-label="Masukkan jumlah obat" />
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="no-data">Kosong</p>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- HARGA/TABLET -->
                                            <td>
                                                <div class="harga-tablet-container"
                                                    data-pasien-id="{{ $item->id }}" id="hargaTablet">
                                                    @php
                                                        $hargaJualData = $reseps->keyBy('nama_obat');
                                                        $regoObat = json_decode($item->obat->soap->soap_p, true) ?? [];
                                                        $regoObatRacikan =
                                                            json_decode($item->obat->soap->soap_r, true) ?? [];
                                                        $regoDewedewe = array_merge(
                                                            (array) $regoObat,
                                                            array_filter((array) $regoObatRacikan),
                                                        );
                                                    @endphp
                                                    @if (is_array($regoDewedewe) && count($regoDewedewe) > 0)
                                                        @foreach ($regoDewedewe as $index => $namaObat)
                                                            @php
                                                                $hargaJual =
                                                                    $hargaJualData->get($namaObat)->harga_jual ?? '0';
                                                            @endphp
                                                            <div class="form-group harga-tablet-row">
                                                                <div class="input-group">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"
                                                                            style="background: rgb(255, 255, 255)">
                                                                            <b>Rp.</b>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text"
                                                                        name="obat_Ro[{{ $index }}][hargaTablet]"
                                                                        id="hargaTablet_{{ $item->id }}_{{ $index }}"
                                                                        class="form-control harga-tablet-input"
                                                                        data-pasien-id="{{ $item->id }}"
                                                                        data-index="{{ $index }}"
                                                                        data-nama-obat="{{ $namaObat }}"
                                                                        value="{{ number_format($hargaJual, 0, ',', '.') }}"
                                                                        readonly aria-label="Harga per tablet">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="no-data">Tidak ada obat yang tersedia</p>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- HARGA TOTAL -->
                                            <td>
                                                <div class="harga-total-container"
                                                    data-pasien-id="{{ $item->id }}">
                                                    @php
                                                        $obatData = json_decode($item->obat->soap->soap_p, true) ?? [];
                                                        $obatRacikanData =
                                                            json_decode($item->obat->soap->soap_r, true) ?? [];
                                                        $jmlhP =
                                                            json_decode($item->obat->soap->soap_p_jumlah, true) ?? [];
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
                                                            <div class="form-group harga-total-row">
                                                                <div class="input-group">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"
                                                                            style="background: rgb(255, 255, 255)">
                                                                            <b>Rp.</b>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text"
                                                                        name="obat_Ro[{{ $index }}][hargaTotal]"
                                                                        id="TotalHarga_{{ $item->id }}_{{ $index }}"
                                                                        class="form-control harga-total-input"
                                                                        data-pasien-id="{{ $item->id }}"
                                                                        data-index="{{ $index }}"
                                                                        data-nama-obat="{{ $namaObat }}"
                                                                        value="{{ number_format($totalHarga, 0, ',', '.') }}"
                                                                        readonly aria-label="Harga total">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="no-data">Tidak ada obat yang tersedia</p>
                                                    @endif
                                                </div>
                                            </td>

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
                                    <label for="totalSemuaHarga"><strong>TOTAL HARGA KESELURUHAN</strong></label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2"
                                                style="background: rgb(255, 255, 255)">
                                                <b>Rp.</b>
                                            </span>
                                        </div>
                                        <input type="text" name="totalSemuaHarga"
                                            data-pasien-id="{{ $item->id }}"
                                            id="totalSemuaHarga_{{ $item->id }}"
                                            class="form-control mt-2 text-end" readonly placeholder="Total Semua">
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
        /* Container utama */
        .obat-container,
        .minum-container,
        .jumlah-container,
        .harga-tablet-container,
        .harga-total-container {
            padding: 12px;
            width: 100%;
            position: relative;
        }

        /* Form group untuk setiap baris */
        .form-group.obat-row,
        .form-group.minum-row,
        .form-group.jumlah-row,
        .form-group.harga-tablet-row,
        .form-group.harga-total-row {
            display: flex;
            align-items: center;
        }

        /* Jarak ke bawah hanya jika ada lebih dari 1 data */
        .obat-container:has(.obat-row:nth-child(n+2)) .obat-row:not(:last-child),
        .minum-container:has(.minum-row:nth-child(n+2)) .minum-row:not(:last-child),
        .jumlah-container:has(.jumlah-row:nth-child(n+2)) .jumlah-row:not(:last-child),
        .harga-tablet-container:has(.harga-tablet-row:nth-child(n+2)) .harga-tablet-row:not(:last-child),
        .harga-total-container:has(.harga-total-row:nth-child(n+2)) .harga-total-row:not(:last-child) {
            margin-bottom: 12px;
        }

        /* Container nama obat, select, dan tombol */
        .nama-obat {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            width: 100%;
        }

        /* Input row untuk input dan search results */
        .input-row {
            position: relative;
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-height: 40px;
        }

        /* Container untuk input dan tombol hapus */
        .nama-obat-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Container untuk jumlah obat */
        .jumlah-group {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        /* Styling input obat */
        .obat-input {
            width: 200px;
            font-size: 14px;
            border-radius: 4px;
            transition: border-color 0.2s ease;
            padding: 6px 12px;
        }

        .obat-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        /* Styling select anjuran */
        .anjuran-select {
            width: 80px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        /* Styling select aturan minum */
        .sehari-select {
            width: 100px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        .aturan-select {
            width: 100px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        /* Styling select dan input jumlah */
        .jenis-obat-select {
            width: 120px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        .jumlah-input {
            width: 80px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
            text-align: end;
        }

        .separator {
            font-size: 14px;
            color: #666;
            flex: 0 0 auto;
            width: 20px;
            text-align: center;
        }

        /* Styling input harga */
        .harga-tablet-input,
        .harga-total-input {
            width: 150px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
            text-align: end;
        }

        .input-group-text {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px 0 0 4px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-right: none;
        }

        /* Styling tombol hapus */
        .btn-hapus {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            line-height: 1;
        }

        /* Styling search results */
        .search-results {
            width: 100%;
            min-height: 20px;
            max-height: 200px;
            overflow-y: auto;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            border: 1px solid #007bff;
            background: #ffffff;
            color: #333;
            position: static;
            margin-top: 4px;
            display: none;
            transition: opacity 0.2s ease;
            opacity: 0;
            z-index: 1000;
        }

        .search-results.show {
            display: block !important;
            opacity: 1 !important;
            overflow-x: auto;
        }

        .search-results .result-item {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s ease;
            color: #333;
            background: #ffffff;
        }

        .search-results .result-item:hover,
        .search-results .result-item.selected {
            background-color: #e9f5ff;
        }

        .search-results .result-item.loading {
            color: #888;
            font-style: italic;
            cursor: default;
        }

        .search-results .result-item.error {
            color: #d9534f;
            font-style: italic;
            cursor: default;
        }

        /* Styling untuk pesan "Tidak ada obat" atau "Kosong" */
        .no-data {
            margin: 12px 0;
            color: #666;
            font-style: italic;
        }

        /* Konsistensi untuk elemen lain di halaman */
        .info-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 24px;
            gap: 12px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1 1 200px;
        }

        .info-item label {
            font-weight: bold;
            margin: 0;
        }

        .info-item p {
            margin: 0;
        }

        /* Styling tambahan untuk input kustom */
        .input-group .custom-input {
            width: 100px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        /* Pastikan input-group tetap berdampingan */
        .input-group {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        /* Responsivitas */
        @media (max-width: 768px) {

            .nama-obat,
            .input-group,
            .input-row,
            .nama-obat-container,
            .jumlah-group {
                flex-direction: column;
                gap: 8px;
            }

            .obat-input,
            .search-results,
            .anjuran-select,
            .sehari-select,
            .aturan-select,
            .custom-input,
            .jenis-obat-select,
            .jumlah-input,
            .harga-tablet-input,
            .harga-total-input {
                width: 100% !important;
            }

            .btn-hapus {
                width: 100%;
                margin: 8px 0 0 0;
            }

            .separator {
                display: none;
            }

            .form-group.obat-row,
            .form-group.minum-row,
            .form-group.jumlah-row,
            .form-group.harga-tablet-row,
            .form-group.harga-total-row {
                margin-bottom: 8px;
            }

            .info-container {
                margin-top: 16px;
                gap: 8px;
            }
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
            // Fungsi debounce untuk membatasi frekuensi AJAX
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            console.log('jQuery initialized. Found .obat-input:', $('.obat-input').length);

            $('.obat-input').each(function() {
                const input = $(this);
                let previousValue = input.val();
                const inputId = input.attr('id');
                console.log('Binding input:', inputId);

                // Kosongkan input saat fokus dan kembalikan nilai sebelumnya saat blur
                input.on('focus', function() {
                    previousValue = input.val();
                    input.val('');
                    console.log('Focus on input:', inputId);
                }).on('blur', function() {
                    if (input.val().trim() === '') {
                        input.val(previousValue);
                    }
                    console.log('Blur on input:', inputId);
                });

                // Pencarian dengan debounce
                input.on('input', debounce(function() {
                    const match = input.attr('id').match(/_(\d+)_(\d+)/);
                    if (!match) {
                        console.error('Invalid input ID format:', inputId);
                        return;
                    }
                    const [pasienId, index] = match.slice(1);
                    const query = input.val().trim();

                    // Jangan panggil AJAX jika query adalah 'Cari Obat' atau kosong
                    if (query === 'Cari Obat' || query.length <= 1) {
                        $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0));
                        calculateTotalHarga(pasienId, index);
                        resultsContainer.empty().removeClass('show');
                        return;
                    }

                    const resultsContainer = $(`#results-${pasienId}-${index}`);
                    if (!resultsContainer.length) {
                        console.error('Results container not found for ID:',
                            `results-${pasienId}-${index}`);
                        return;
                    }

                    console.log('Searching for query:', query, 'Pasien ID:', pasienId, 'Index:',
                        index);
                    resultsContainer.empty().removeClass('show');

                    resultsContainer.append('<div class="result-item loading">Memuat...</div>')
                        .addClass('show');
                    $.ajax({
                        url: '/cariObat-ganti',
                        method: 'GET',
                        data: {
                            term: query
                        },
                        success: function(data) {
                            console.log('AJAX /cariObat-ganti success. Data:',
                                data);
                            resultsContainer.empty();
                            if (data && Array.isArray(data) && data.length) {
                                $.each(data, function(i, item) {
                                    const itemText = item.text || item
                                        .label || item.name || 'Unknown';
                                    const itemId = item.id || i;
                                    const itemHarga = parseFloat(item
                                        .harga_jual) || 0;
                                    resultsContainer.append(
                                        `<div class="result-item" data-id="${itemId}" data-harga="${itemHarga}" role="option">${itemText}</div>`
                                    );
                                });
                                resultsContainer.addClass('show');
                            } else {
                                resultsContainer.append(
                                    '<div class="result-item">Tidak ada hasil</div>'
                                ).addClass('show');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX /cariObat-ganti error:', textStatus,
                                errorThrown);
                            resultsContainer.empty().append(
                                '<div class="result-item error">Terjadi kesalahan saat mencari</div>'
                            ).addClass('show');
                        }
                    });
                }, 300));
            });

            // Tidak perlu perubahan besar, tetapi pastikan bagian ini tetap berfungsi
            $(document).on('click', '.result-item', function() {
                const itemName = $(this).text();
                const resultsContainer = $(this).parent();
                const inputId = resultsContainer.attr('id').replace('results-', 'obat_Ro_');
                const input = $(`#${inputId}`);

                console.log('Selected item:', itemName, 'for input:', inputId);
                input.val(itemName);
                resultsContainer.removeClass('show'); // Pastikan dropdown disembunyikan setelah memilih
            });

            // Sembunyikan hasil saat klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.input-row').length) {
                    console.log('Click outside, hiding search results');
                    $('.search-results').removeClass('show');
                }
            });

            // Navigasi keyboard untuk hasil pencarian
            $('.obat-input').on('keydown', function(e) {
                const inputId = $(this).attr('id');
                const resultsContainer = $(`#results-${inputId.replace('obat_Ro_', '')}`);
                const items = resultsContainer.find('.result-item');
                let selectedIndex = items.filter('.selected').index();

                console.log('Keydown:', e.key, 'on input:', inputId);
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = selectedIndex === -1 ? items.length - 1 : (selectedIndex - 1 + items
                        .length) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'Enter' && items.hasClass('selected')) {
                    e.preventDefault();
                    items.filter('.selected').trigger('click');
                }
            });
        });

        // PERUBAHAN HARGA TABLET MENYESUAIKAN PERUBAHAN NAMA OBAT
        $(document).ready(function() {
            // Fungsi debounce
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Fungsi format angka
            function formatAngka(angka) {
                return parseInt(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function unformatAngka(angka) {
                return parseInt(angka.replace(/\./g, '')) || 0;
            }

            // Fungsi untuk menghitung total harga
            function calculateTotalHarga(pasienId, index) {
                const jumlahInput = $(`#jumlah_${pasienId}_${index}`);
                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                const totalHargaInput = $(`#TotalHarga_${pasienId}_${index}`);

                if (!jumlahInput.length || !hargaTabletInput.length || !totalHargaInput.length) {
                    console.warn(`Input missing for Pasien ${pasienId}, Index ${index}`);
                    return;
                }

                const jumlahObat = parseFloat(jumlahInput.val()) || 0;
                const hargaTablet = unformatAngka(hargaTabletInput.val());
                const totalHarga = jumlahObat * hargaTablet;

                totalHargaInput.val(formatAngka(totalHarga));
                updateTotalSemua(pasienId);
            }

            function updateTotalSemua(pasienId) {
                let totalSemua = 0;
                const hargaTotalInputs = $(`.harga-total-input[data-pasien-id="${pasienId}"]`);
                hargaTotalInputs.each(function() {
                    const harga = unformatAngka($(this).val());
                    totalSemua += harga;
                });

                const totalSemuaInput = $(`#totalSemuaHarga_${pasienId}`);
                if (totalSemuaInput.length) {
                    totalSemuaInput.val(formatAngka(totalSemua));
                }
            }

            function updateHargaObat(pasienId, index, obatId, obatName) {
                if (obatName === 'Cari Obat' || !obatName) {
                    console.log('Skipping updateHargaObat for Cari Obat');
                    const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                    if (hargaTabletInput.length) {
                        hargaTabletInput.val(formatAngka(0));
                        hargaTabletInput.attr('data-nama-obat', '');
                        hargaTabletInput.trigger('change');
                    }
                    calculateTotalHarga(pasienId, index);
                    return;
                }

                console.log(`Updating harga for: ${obatName} (ID: ${obatId})`);
                $.ajax({
                    url: '/gantiObat-RegoGanti',
                    type: 'GET',
                    data: {
                        id_obat: obatId,
                        nama_obat: obatName
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            const hargaJual = parseFloat(response.data.harga_jual) || 0;
                            const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                            if (hargaTabletInput.length) {
                                hargaTabletInput.val(formatAngka(hargaJual));
                                hargaTabletInput.attr('data-nama-obat', obatName);
                                hargaTabletInput.trigger('change');
                                calculateTotalHarga(pasienId, index);
                            }
                        } else {
                            $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0)).trigger(
                                'change');
                            calculateTotalHarga(pasienId, index);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX /gantiObat-RegoGanti error:', textStatus, errorThrown);
                        $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0)).trigger('change');
                        calculateTotalHarga(pasienId, index);
                    }
                });
            }

            $('.obat-input').each(function() {
                const input = $(this);
                let previousValue = input.val() || 'Cari Obat';
                const inputId = input.attr('id');

                input.on('focus', function() {
                    previousValue = input.val();
                    if (previousValue === 'Cari Obat') {
                        input.val('');
                    }
                    console.log('Focus on input:', inputId, 'Previous:', previousValue);
                }).on('blur', function() {
                    if (input.val().trim() === '') {
                        input.val('Cari Obat');
                        previousValue = 'Cari Obat';
                        input.trigger('change');

                        const match = inputId.match(/_(\d+)_(\d+)/);
                        if (match) {
                            const [pasienId, index] = match.slice(1);
                            const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                            if (hargaTabletInput.length) {
                                hargaTabletInput.val(formatAngka(0));
                                hargaTabletInput.attr('data-nama-obat', '');
                                hargaTabletInput.trigger('change');
                            }
                            calculateTotalHarga(pasienId, index);
                        }
                    }
                    console.log('Blur on input:', inputId, 'Value:', input.val());
                });

                input.on('input', debounce(function() {
                    const match = input.attr('id').match(/_(\d+)_(\d+)/);
                    if (!match) {
                        console.error('Invalid input ID format:', inputId);
                        return;
                    }
                    const [pasienId, index] = match.slice(1);
                    const query = input.val().trim();

                    if (query === 'Cari Obat' || query.length <= 1) {
                        const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                        if (hargaTabletInput.length) {
                            hargaTabletInput.val(formatAngka(0));
                            hargaTabletInput.attr('data-nama-obat', '');
                            hargaTabletInput.trigger('change');
                        }
                        calculateTotalHarga(pasienId, index);
                        $(`#results-${pasienId}-${index}`).empty().removeClass('show');
                        return;
                    }

                    const resultsContainer = $(`#results-${pasienId}-${index}`);
                    if (!resultsContainer.length) {
                        console.error('Results container not found for ID:',
                            `results-${pasienId}-${index}`);
                        return;
                    }

                    resultsContainer.empty().removeClass('show');
                    resultsContainer.append('<div class="result-item loading">Memuat...</div>')
                        .addClass('show');
                    $.ajax({
                        url: '/cariObat-ganti',
                        method: 'GET',
                        data: {
                            term: query
                        },
                        success: function(data) {
                            resultsContainer.empty();
                            if (data && Array.isArray(data) && data.length) {
                                $.each(data, function(i, item) {
                                    const itemText = item.text || item
                                        .label || item.name || 'Unknown';
                                    const itemId = item.id || i;
                                    const itemHarga = parseFloat(item
                                        .harga_jual) || 0;
                                    resultsContainer.append(
                                        `<div class="result-item" data-id="${itemId}" data-harga="${itemHarga}" role="option">${itemText}</div>`
                                    );
                                });
                                resultsContainer.addClass('show');
                            } else {
                                resultsContainer.append(
                                    '<div class="result-item">Tidak ada hasil</div>'
                                ).addClass('show');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX /cariObat-ganti error:', textStatus,
                                errorThrown);
                            resultsContainer.empty().append(
                                '<div class="result-item error">Terjadi kesalahan saat mencari</div>'
                            ).addClass('show');
                        }
                    });
                }, 300));
            });

            $(document).on('click', '.result-item', function() {
                const itemText = $(this).text();
                const itemId = $(this).data('id');
                const itemHarga = parseFloat($(this).data('harga')) || 0;
                const resultsContainer = $(this).parent();
                const containerId = resultsContainer.attr('id');
                const [pasienId, index] = containerId.match(/-(\d+)-(\d+)/).slice(1);

                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                if (inputObat.length) {
                    inputObat.val(itemText);
                    inputObat.attr('data-nama-obat', itemText);
                    inputObat.data('previous-value', itemText);
                    inputObat.trigger('change');
                }

                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                if (hargaTabletInput.length) {
                    hargaTabletInput.val(formatAngka(itemHarga));
                    hargaTabletInput.attr('data-nama-obat', itemText);
                    hargaTabletInput.trigger('change');
                }

                calculateTotalHarga(pasienId, index);
                resultsContainer.removeClass('show');
                updateHargaObat(pasienId, index, itemId, itemText);
            });

            $(document).on('click', '.btn-hapus', function() {
                const pasienId = $(this).data('pasien-id');
                const index = $(this).data('index');

                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                if (inputObat.length) {
                    inputObat.val('Cari Obat');
                    inputObat.attr('data-nama-obat', '');
                    inputObat.data('previous-value', 'Cari Obat');
                    inputObat.trigger('change');
                }

                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                if (hargaTabletInput.length) {
                    hargaTabletInput.val(formatAngka(0));
                    hargaTabletInput.attr('data-nama-obat', '');
                    hargaTabletInput.trigger('change');
                }

                const jumlahInput = $(`#jumlah_${pasienId}_${index}`);
                if (jumlahInput.length) {
                    jumlahInput.val('0');
                    jumlahInput.trigger('change');
                }

                const totalHargaInput = $(`#TotalHarga_${pasienId}_${index}`);
                if (totalHargaInput.length) {
                    totalHargaInput.val(formatAngka(0));
                    totalHargaInput.trigger('change');
                }

                $(`#anjuran_${pasienId}_${index}`).val('AC').trigger('change');
                $(`#aturan_${pasienId}_${index}`).val('Sebelum Makan').trigger('change');
                $(`#sehari_${pasienId}_${index}`).val('1x1/5').trigger('change');
                $(`#jenisObat_${pasienId}_${index}`).val('Tablet').trigger('change');

                calculateTotalHarga(pasienId, index);

                console.log('Reset values:', {
                    obat: inputObat.val(),
                    hargaTablet: hargaTabletInput.val(),
                    jumlah: jumlahInput.val(),
                    totalHarga: totalHargaInput.val()
                });
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.input-row').length) {
                    $('.search-results').removeClass('show');
                }
            });

            $('.obat-input').on('keydown', function(e) {
                const inputId = $(this).attr('id');
                const resultsContainer = $(`#results-${inputId.replace('obat_Ro_', '')}`);
                const items = resultsContainer.find('.result-item');
                let selectedIndex = items.filter('.selected').index();

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = selectedIndex === -1 ? items.length - 1 : (selectedIndex - 1 + items
                        .length) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'Enter' && items.hasClass('selected')) {
                    e.preventDefault();
                    items.filter('.selected').trigger('click');
                }
            });

            $('form').on('submit', function(e) {
                $('.obat-input').each(function() {
                    const input = $(this);
                    if (input.val() === 'Cari Obat') {
                        input.val('');
                    }
                });
            });

            $('.obat-container').each(function() {
                const pasienId = $(this).data('pasien-id');
                $(`.harga-total-input[data-pasien-id="${pasienId}"]`).each(function(index) {
                    calculateTotalHarga(pasienId, index);
                });
                updateTotalSemua(pasienId);
            });
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
        $(document).ready(function() {
            // Fungsi debounce untuk membatasi frekuensi AJAX
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Fungsi untuk format angka dengan pemisah titik (misalnya, 1000 -> 1.000)
            function formatAngka(angka) {
                return parseInt(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Fungsi untuk menghapus format angka (menghapus titik) agar bisa diubah ke angka
            function unformatAngka(angka) {
                return parseInt(angka.replace(/\./g, '')) || 0;
            }

            // Fungsi untuk menghitung total harga per obat
            function calculateTotalHarga(pasienId, index) {
                const jumlahInput = $(`#jumlah_${pasienId}_${index}`);
                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                const totalHargaInput = $(`#TotalHarga_${pasienId}_${index}`);

                const jumlahObat = parseFloat(jumlahInput.val()) || 0;
                const hargaTablet = unformatAngka(hargaTabletInput.val());
                const totalHarga = jumlahObat * hargaTablet;

                totalHargaInput.val(formatAngka(totalHarga));
                console.log(`Calculated total: Pasien ${pasienId}, Index ${index}, Total ${totalHarga}`);

                // Update total harga keseluruhan setelah menghitung total per obat
                updateTotalSemua(pasienId);
            }

            // Fungsi untuk menghitung total harga keseluruhan untuk pasien tertentu
            function updateTotalSemua(pasienId) {
                let totalSemua = 0;

                // Pilih semua input harga_total untuk pasien yang sesuai
                const hargaTotalInputs = $(`.harga-total-input[data-pasien-id="${pasienId}"]`);
                hargaTotalInputs.each(function() {
                    const harga = unformatAngka($(this).val());
                    totalSemua += harga;
                });

                // Update input totalSemuaHarga dengan format angka
                const totalSemuaInput = $(`#totalSemuaHarga_${pasienId}`);
                if (totalSemuaInput.length) {
                    totalSemuaInput.val(formatAngka(totalSemua));
                    console.log(`Updated total semua: Pasien ${pasienId}, Total ${totalSemua}`);
                } else {
                    console.warn(`Total semua input not found for Pasien ${pasienId}`);
                }
            }

            // Fungsi untuk update harga berdasarkan obat yang dipilih
            function updateHargaObat(pasienId, index, obatId, obatName) {
                console.log(`Updating harga for: ${obatName} (ID: ${obatId})`);
                $.ajax({
                    url: '/gantiObat-RegoGanti',
                    type: 'GET',
                    data: {
                        id_obat: obatId,
                        nama_obat: obatName
                    },
                    success: function(response) {
                        console.log('AJAX /gantiObat-RegoGanti success:', response);
                        if (response.success && response.data) {
                            const hargaJual = parseFloat(response.data.harga_jual) || 0;
                            const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                            hargaTabletInput.val(formatAngka(hargaJual));
                            hargaTabletInput.attr('data-nama-obat', obatName);
                            calculateTotalHarga(pasienId, index);
                        } else {
                            console.warn('No valid harga_jual in response:', response);
                            $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0));
                            calculateTotalHarga(pasienId, index);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX /gantiObat-RegoGanti error:', textStatus, errorThrown);
                        $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0));
                        calculateTotalHarga(pasienId, index);
                    }
                });
            }

            // Event untuk input obat
            $('.obat-input').each(function() {
                const input = $(this);
                let previousValue = input.val();
                const inputId = input.attr('id');
                console.log('Binding input:', inputId);

                input.on('focus', function() {
                    previousValue = input.val();
                    input.val('');
                    console.log('Focus on input:', inputId);
                }).on('blur', function() {
                    if (input.val().trim() === '') {
                        input.val(previousValue);
                    }
                    console.log('Blur on input:', inputId);
                });

                // Pencarian dengan debounce
                input.on('input', debounce(function() {
                    const match = input.attr('id').match(/_(\d+)_(\d+)/);
                    if (!match) {
                        console.error('Invalid input ID format:', inputId);
                        return;
                    }
                    const [pasienId, index] = match.slice(1);
                    const query = input.val().trim();

                    const resultsContainer = $(`#results-${pasienId}-${index}`);
                    if (!resultsContainer.length) {
                        console.error('Results container not found for ID:',
                            `results-${pasienId}-${index}`);
                        return;
                    }

                    console.log('Searching for query:', query, 'Pasien ID:', pasienId, 'Index:',
                        index);
                    resultsContainer.empty().removeClass('show');

                    if (query.length > 1) {
                        resultsContainer.append(
                            '<div class="result-item loading">Memuat...</div>').addClass(
                            'show');
                        $.ajax({
                            url: '/cariObat-ganti',
                            method: 'GET',
                            data: {
                                term: query
                            },
                            success: function(data) {
                                console.log('AJAX /cariObat-ganti success. Data:',
                                    data);
                                resultsContainer.empty();
                                if (data && Array.isArray(data) && data.length) {
                                    $.each(data, function(i, item) {
                                        const itemText = item.text || item
                                            .label || item.name ||
                                            'Unknown';
                                        const itemId = item.id || i;
                                        const itemHarga = parseFloat(item
                                            .harga_jual) || 0;
                                        resultsContainer.append(
                                            `<div class="result-item" data-id="${itemId}" data-harga="${itemHarga}" role="option">${itemText}</div>`
                                        );
                                    });
                                    resultsContainer.addClass('show');
                                } else {
                                    resultsContainer.append(
                                        '<div class="result-item">Tidak ada hasil</div>'
                                    ).addClass('show');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('AJAX /cariObat-ganti error:',
                                    textStatus, errorThrown);
                                resultsContainer.empty().append(
                                    '<div class="result-item error">Terjadi kesalahan saat mencari</div>'
                                ).addClass('show');
                            }
                        });
                    } else {
                        console.log('Query too short:', query);
                    }
                }, 300));
            });

            // Event klik pada hasil pencarian obat
            $(document).on('click', '.result-item', function() {
                const itemText = $(this).text();
                const itemId = $(this).data('id');
                const itemHarga = parseFloat($(this).data('harga')) || 0;
                const resultsContainer = $(this).parent();
                const containerId = resultsContainer.attr('id');
                const [pasienId, index] = containerId.match(/-(\d+)-(\d+)/).slice(1);

                console.log(`Selected item: ${itemText} (ID: ${itemId}, Harga: ${itemHarga})`);

                // Update input obat
                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                inputObat.val(itemText);
                inputObat.attr('data-nama-obat', itemText);

                // Update harga tablet
                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                hargaTabletInput.val(formatAngka(itemHarga));
                hargaTabletInput.attr('data-nama-obat', itemText);

                // Hitung total harga per obat dan update total semua
                calculateTotalHarga(pasienId, index);

                // Sembunyikan dropdown
                resultsContainer.removeClass('show');

                // Panggil AJAX untuk validasi harga dari server
                updateHargaObat(pasienId, index, itemId, itemText);
            });

            // Event perubahan jumlah obat
            $(document).on('input change', '.jumlah-input', function() {
                const pasienId = $(this).data('pasien-id');
                const index = $(this).data('index');
                console.log(`Jumlah changed: Pasien ${pasienId}, Index ${index}, Value ${$(this).val()}`);
                calculateTotalHarga(pasienId, index);
            });

            // Event tombol hapus
            $(document).on('click', '.btn-hapus', function() {
                const pasienId = $(this).data('pasien-id');
                const index = $(this).data('index');
                const namaObatAwal = $(this).data('nama-obat');
                const hargaAwal = parseFloat($(this).data('harga')) || 0;

                console.log(
                    `Resetting: Pasien ${pasienId}, Index ${index}, Obat ${namaObatAwal}, Harga ${hargaAwal}`
                );

                // Reset nilai
                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                inputObat.val(namaObatAwal);
                inputObat.attr('data-nama-obat', namaObatAwal);

                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                hargaTabletInput.val(formatAngka(hargaAwal));
                hargaTabletInput.attr('data-nama-obat', namaObatAwal);

                // Hitung ulang total harga per obat dan update total semua
                calculateTotalHarga(pasienId, index);
            });

            // Sembunyikan hasil saat klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.input-row').length) {
                    console.log('Click outside, hiding search results');
                    $('.search-results').removeClass('show');
                }
            });

            // Navigasi keyboard untuk hasil pencarian
            $('.obat-input').on('keydown', function(e) {
                const inputId = $(this).attr('id');
                const resultsContainer = $(`#results-${inputId.replace('obat_Ro_', '')}`);
                const items = resultsContainer.find('.result-item');
                let selectedIndex = items.filter('.selected').index();

                console.log('Keydown:', e.key, 'on input:', inputId);
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = selectedIndex === -1 ? items.length - 1 : (selectedIndex - 1 + items
                        .length) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'Enter' && items.hasClass('selected')) {
                    e.preventDefault();
                    items.filter('.selected').trigger('click');
                }
            });

            // Inisialisasi perhitungan total saat halaman dimuat
            $('.obat-container').each(function() {
                const pasienId = $(this).data('pasien-id');
                $(`.harga-total-input[data-pasien-id="${pasienId}"]`).each(function(index) {
                    calculateTotalHarga(pasienId, index);
                });
                updateTotalSemua(pasienId);
            });
        });

        // INPUT ATURAN
        function toggleInput(selectElement, uniqueId) {
            const parent = selectElement.parentElement;
            const selectedValue = selectElement.value;
            const customInput = document.getElementById(`custom_sehari_${uniqueId}`);
            const originalSelect = document.getElementById(`sehari_${uniqueId}`);

            if (selectedValue === 'custom') {
                // Tampilkan input kustom di sebelah select
                customInput.classList.remove('d-none');
                customInput.style.display = 'block';
                customInput.focus();

                // Tambahkan event listener untuk kembali ke select
                customInput.addEventListener('blur', function revertToSelect() {
                    if (customInput.value.trim() === '') {
                        // Jika input kosong, sembunyikan input kustom
                        customInput.classList.add('d-none');
                        customInput.style.display = 'none';
                        originalSelect.value = '1x1 SENDOK'; // Reset ke opsi default
                    }
                    // Hapus event listener setelah digunakan
                    customInput.removeEventListener('blur', revertToSelect);
                });
            } else {
                // Sembunyikan input kustom
                customInput.classList.add('d-none');
                customInput.style.display = 'none';
            }
        }
    </script>
@endpush
