<x-admin.layout.terminal title="Dokter Gigi | Odontogram">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <div class="judul mt-3">
                        <h4><strong>@yield('title')</strong></h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="kembali mb-2" style="display: flex; justify-content: space-between">
                            <a href="{{ url('dokter/soap/' . $antrianDokter->id) }}" class="btn btn-primary"
                                data-toggle="tooltip" data-bs-placement="top" title="Kembali" style>
                                <i class="fa-solid fa-backward"></i> Kembali
                            </a>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>

                        <form action="{{ url('dokter/tambah/' . $antrianDokter->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="dokter_id" value="{{ $antrianDokter->dokter_id }}">
                            <input type="hidden" name="pasien_id" value="{{ $antrianDokter->booking->pasien_id }}">

                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="text-muted">
                                            <strong>
                                                <li>Pengkajian Awal Pasien Gigi</li>
                                            </strong>
                                        </h5>
                                    </div>
                                    <hr>
                                    <div class="row display-flex justify-content-between">
                                        <div class="col-md-6">
                                            <table class="table">
                                                <tbody>
                                                    {{-- <tr>
                                                        <th style="padding: 4px; text-align: left">
                                                            Tanggal Periksa
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="font-weight: bold; padding: 4px;">
                                                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                                                        </td>
                                                    </tr> --}}
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">No RM</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="font-weight: bold; padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->no_rm }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Nama Pasien</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->nama_pasien }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">TTL</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir)->translatedFormat('d F Y') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Umur</th>
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
                                                        <th style="padding: 4px; text-align: left;">Jenis Kelamin
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->jekel == 'L' ? 'Laki-laki' : ($antrianDokter->booking->pasien->jekel == 'P' ? 'Perempuan' : '') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Alamat
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->domisili }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Nama KK</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->nama_kk }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">No. Nik</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->nik }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Jenis Pasien</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->jenis_pasien }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">No. Bpjs</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->bpjs ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Pekerjaan</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->pekerjaan }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">No. Hp
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            {{ $antrianDokter->booking->pasien->noHP }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            {{-- KUNJUNGAN --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="text-muted">
                                            <strong>
                                                <li>Kunjungan</li>
                                            </strong>
                                        </h5>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left">
                                                            Tanggal Kunjungan
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="font-weight: bold; padding: 4px;">
                                                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Jam</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="font-weight: bold; padding: 4px;">
                                                            {{ \Carbon\Carbon::now()->translatedFormat('H:i:s') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Alergi</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            <input type="text" name="alegi_gigi" id="alegi_gigi"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">Skala Nyeri
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            <input type="text" name="skala_nyeriGigi"
                                                                id="skala_nyeriGigi" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="padding: 4px; text-align: left; white-space: nowrap">
                                                            Dengan menggunakan
                                                            metode
                                                        </td>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            <div id="metode" class="d-flex flex-wrap"
                                                                style="white-space: nowrap">
                                                                <label for="nrs" class="mr-4">
                                                                    <input type="checkbox" name="metode"
                                                                        id="nrs" value="NRS"
                                                                        style="transform: scale(1.5); margin-right: 5px">
                                                                    NRS
                                                                </label>
                                                                <label for="wongbaker_faces" class="mx-3">
                                                                    <input type="checkbox" name="metode"
                                                                        id="wongbaker_faces" value="Wong Baker FACES"
                                                                        style="transform: scale(1.5); margin-right: 5px">
                                                                    Wong Baker Faces
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="skala text-center mt-3">
                                                <img src="{{ asset('assets/images/analog-gigi.png') }}"
                                                    alt="" height="auto" width="70%">
                                            </div>
                                            <div class="row text-center" style="font-size: 18px">
                                                <div class="col">
                                                    <input type="checkbox" name="wongbaker" id="wongbaker-0"
                                                        value="0"
                                                        style="transform: scale(1.5); margin-right: 10px;">0
                                                    <input type="checkbox" name="wongbaker" id="wongbaker-2"
                                                        value="2"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 40px">2
                                                    <input type="checkbox" name="wongbaker" id="wongbaker-4"
                                                        value="2"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">4
                                                    <input type="checkbox" name="wongbaker" id="wongbaker-6"
                                                        value="4"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">6
                                                    <input type="checkbox" name="wongbaker" id="wongbaker-8"
                                                        value="8"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">8
                                                    <input type="checkbox" name="wongbaker" id="wongbaker-10"
                                                        value="10"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            {{-- ASESMEN DOKTER --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="text-muted">
                                            <strong>
                                                I. ASESMEN DOKTER
                                            </strong>
                                        </h5>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="judul">
                                                <h6 class="text-muted">
                                                    <strong>
                                                        <li>Anamnesis (S)</li>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left">
                                                            1. Keluhan Utama
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="font-weight: bold; padding: 4px;">
                                                            <input type="text" name="a_keluhan_utama"
                                                                id="a_keluhan_utama" class="form-control"
                                                                value="{{ $antrianDokter->rm->a_keluhan_utama }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">
                                                            2. Riwayat Penyakit Sekarang</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="font-weight: bold; padding: 4px;">
                                                            <input type="text" name="a_riwayat_penyakit_skrg"
                                                                id="a_riwayat_penyakit_skrg" class="form-control"
                                                                value="{{ $antrianDokter->rm->a_riwayat_penyakit_skrg }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">
                                                            3. Riwayat Penyakit Terdahulu</th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            <input type="text" name="a_riwayat_penyakit_terdahulu"
                                                                id="a_riwayat_penyakit_terdahulu" class="form-control"
                                                                value="{{ $antrianDokter->rm->a_riwayat_penyakit_terdahulu }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">4. Riwayat Penyakit
                                                            Keluarga
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            <input type="text" name="a_riwayat_penyakit_keluarga"
                                                                id="a_riwayat_penyakit_keluarga" class="form-control"
                                                                value="{{ $antrianDokter->rm->a_riwayat_penyakit_keluarga }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding: 4px; text-align: left;">5. Riwayat
                                                            Pengggunaan
                                                            Obat
                                                        </th>
                                                        <td style="padding: 4px; width: 10px;">:</td>
                                                        <td style="padding: 4px;">
                                                            <input type="text" name="a_riwayat_penggunaan_obat"
                                                                id="a_riwayat_penggunaan_obat" class="form-control">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <div class="judul2">
                                                <h6 class="text-muted">
                                                    <strong>
                                                        <li>Pemeriksaan Fisik (O)</li>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="periksa_fisik" id="periksa_fisik" class="form-control mt-2 mb-2" cols="4" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="text-muted">
                                            <strong>
                                                <li>Gambar Odontogram Gigi</li>
                                            </strong>
                                        </h5>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="d-flex justify-content-center mb-4 mt-3">
                                            <img id="displayedImage" src="{{ asset('assets/images/gigi.jpeg') }}"
                                                style="max-width: 70%; height: auto; border-radius: 10px"
                                                alt="Kerangka">
                                        </div>
                                        <hr>
                                        {{-- PILIH GIGI --}}
                                        <div class="col-md-6">
                                            <div class="form-group" id="tambahGigi-container">
                                                <label for="no_gigi">Nomor Gigi</label>
                                                <select name="no_gigi[]" id="no_gigi"
                                                    class="form-control mt-2 mb-2 select2" multiple>
                                                    <option value="">--Pilih Gigi--</option>
                                                    @for ($i = 1; $i <= 85; $i++)
                                                        <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                {{-- <div class="input-row d-flex align-items-center mb-2" style="gap: 8px;">
                                                    <input type="text" class="form-control mt-2 mb-2"
                                                        name="no_gigi[0]" placeholder="Masukkan Nomor Gigi">

                                                    <button type="button" class="btn btn-primary tambah-gigi mt-2 mb-2"
                                                        onclick="tambahKolom('tambahGigi')">
                                                        <i class="fa-solid fa-tooth"></i>
                                                    </button>
                                                </div> --}}
                                            </div>
                                        </div>
                                        {{-- KEADAAN GIGI --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="keadaan_gigi">Keadaan Gigi</label>
                                                <select class="form-control mt-2 mb-2 select2" name="keadaan_gigi[]"
                                                    id="keadaan_gigi" multiple>
                                                    <option value="">--Pilih Keadaan--</option>
                                                    <option value="SOU">SOU</option>
                                                    <option value="NVT">NVT</option>
                                                    <option value="NON">NON</option>
                                                    <option value="UNE">UNE</option>
                                                    <option value="PRE">PRE</option>
                                                    <option value="ANO">ANO</option>
                                                    <option value="CFR">CFR</option>
                                                    <option value="RRX">RRX</option>
                                                    <option value="MIS">MIS</option>
                                                    <option value="IMV">IMV</option>
                                                    <option value="DIA">DIA</option>
                                                    <option value="ATT">ATT</option>
                                                    <option value="ABR">ABR</option>
                                                    <option value="CAR">CAR</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- KETERANGAN GIGI --}}
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan Gigi</label>
                                                <textarea class="form-control mt-2 mb-2" name="keterangan[0]" cols="10" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            {{-- OCCLUSI --}}
                                            <div class="form-group d-flex align-items-center mb-3 mt-4"
                                                style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Occlusi</label>
                                                <span style="width: 30px">:</span>
                                                <div id="occlusi_gigi">
                                                    <label for="jawaban-normal" class="mr-3">
                                                        <input type="radio" name="occlusi_gigi" id="jawaban-normal"
                                                            value="Normal-bite" checked
                                                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                                                        Bite
                                                    </label>
                                                    <label for="jawaban-crossbite" class="mx-3">
                                                        <input type="radio" name="occlusi_gigi"
                                                            id="jawaban-crossbite" value="Cross-bite"
                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Cross
                                                        Bite
                                                    </label>
                                                    <label for="jawaban-steepbite" class="ml-3">
                                                        <input type="radio" name="occlusi_gigi"
                                                            id="jawaban-steepbite" value="Steep-bite"
                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Steep
                                                        Bite
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- PALATINES --}}
                                            <div class="form-group d-flex align-items-center mb-3 mt-4"
                                                style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Torus
                                                    Palatines</label>
                                                <span style="width: 30px">:</span>
                                                <div id="torus_palatinus">
                                                    <label for="jawaban-normal" class="mr-3">
                                                        <input type="radio" name="torus_palatinus"
                                                            id="jawaban-tidak-ada" value="Tidak-ada" checked
                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Tidak Ada
                                                    </label>
                                                    <label for="jawaban-crossbite" class="mx-3">
                                                        <input type="radio" name="torus_palatinus"
                                                            id="jawaban-kecil" value="Kecil"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 13px">
                                                        Kecil
                                                    </label>
                                                    <label for="jawaban-steepbite" class="ml-3">
                                                        <input type="radio" name="torus_palatinus"
                                                            id="jawaban-sedang" value="Sedang"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 37px">
                                                        Sedang
                                                    </label>
                                                    <label for="jawaban-steepbite" class="ml-3">
                                                        <input type="radio" name="torus_palatinus"
                                                            id="jawaban-besar" value="Besar"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 40px">
                                                        Besar
                                                    </label>
                                                    <label for="jawaban-steepbite" style="margin-left: 12px">
                                                        <input type="radio" name="torus_palatinus"
                                                            id="jawaban-multiple" value="Multiple"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 40px">
                                                        Multiple
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- MANDIBULARIS --}}
                                            <div class="form-group d-flex align-items-center mb-3 mt-4"
                                                style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Torus
                                                    Mandibularis</label>
                                                <span style="width: 30px">:</span>
                                                <div id="torus_mandibularis">
                                                    <label for="jawaban-normal" class="mr-3">
                                                        <input type="radio" name="torus_mandibularis"
                                                            id="jawaban-tidak-ada" value="Tidak-ada" checked
                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Tidak Ada
                                                    </label>
                                                    <label for="jawaban-crossbite" class="mx-3">
                                                        <input type="radio" name="torus_mandibularis"
                                                            id="jawaban-sisi_kiri" value="Sisi_kiri"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 13px">
                                                        Sisi
                                                        Kiri
                                                    </label>
                                                    <label for="jawaban-steepbite" class="ml-3">
                                                        <input type="radio" name="torus_mandibularis"
                                                            id="jawaban-sisi_kanan" value="Sisi_kanan"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 19px">
                                                        Sisi
                                                        Kanan
                                                    </label>
                                                    <label for="jawaban-steepbite" class="ml-3">
                                                        <input type="radio" name="torus_mandibularis"
                                                            id="jawaban-kedua_sisi" value="Kedua_sisi"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 21px">
                                                        Kedua
                                                        Sisi
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- PALATUM --}}
                                            <div class="form-group d-flex align-items-center mb-3 mt-4"
                                                style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Palatum</label>
                                                <span style="width: 30px">:</span>
                                                <div id="palatum">
                                                    <label for="jawaban-normal" class="mr-3">
                                                        <input type="radio" name="palatum" id="jawaban-dalam"
                                                            value="dalam" checked
                                                            style="transform: scale(1.5); margin-right: 10px;"> Dalam
                                                    </label>
                                                    <label for="jawaban-crossbite" class="mx-3">
                                                        <input type="radio" name="palatum" id="jawaban-sedang"
                                                            value="sedang"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 38px">
                                                        Sedang
                                                    </label>
                                                    <label for="jawaban-steepbite" class="ml-3">
                                                        <input type="radio" name="palatum" id="jawaban-rendah"
                                                            value="rendah"
                                                            style="transform: scale(1.5); margin-right: 10px; margin-left: 18px">
                                                        Rendah
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- DIASTEMA --}}
                                            <div class="form-group mb-3 mt-4">
                                                <div class="d-flex align-items-center" style="gap: 8px">
                                                    <label style="min-width: 200px; margin-bottom: 0;">Diastema</label>
                                                    <span style="width: 30px;">:</span>
                                                    <div id="diastema">
                                                        <label for="jawaban-tidak_ada" class="mr-3">
                                                            <input type="radio" name="diastema"
                                                                id="jawaban-tidak_ada" value="tidak-ada" checked
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            Tidak
                                                            Ada
                                                        </label>
                                                        <label for="jawaban-ada" class="mx-3">
                                                            <input type="radio" name="diastema" id="jawaban-ada"
                                                                value="ada"
                                                                style="transform: scale(1.5); margin-right: 10px;"> Ada
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="alasan-diastema"
                                                    style="display: none; margin-top: 8px; min-width: 200px; margin-left: 26%">
                                                    <span style="width: 30px"></span>
                                                    <input type="text" id="diastema_alasan" name="diastema_alasan"
                                                        class="form-control" placeholder="Penjelasan">
                                                    <p
                                                        style="font-size: 14px; margin-top: 5px; font-style: italic; color: red">
                                                        (*dijelaskan dimana dan
                                                        berapa lebarnya)</p>
                                                </div>
                                            </div>
                                            {{-- GIGI ANOMALI --}}
                                            <div class="form-group mb-3 mt-4">
                                                <div class="d-flex align-items-center" style="gap: 8px">
                                                    <label style="min-width: 200px; margin-bottom: 0;">Gigi
                                                        Anomaly</label>
                                                    <span style="width: 30px;">:</span>
                                                    <div id="gigi_anomali">
                                                        <label for="anomali-tidak_ada" class="mr-3">
                                                            <input type="radio" name="gigi_anomali"
                                                                id="anomali-tidak_ada" value="tidak-ada" checked
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            Tidak
                                                            Ada
                                                        </label>
                                                        <label for="anomali-ada" class="mx-3">
                                                            <input type="radio" name="gigi_anomali"
                                                                id="anomali-ada" value="ada"
                                                                style="transform: scale(1.5); margin-right: 10px;"> Ada
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="alasan-gigi_anomali"
                                                    style="display: none; margin-top: 8px; min-width: 200px; margin-left: 26%">
                                                    <span style="width: 30px"></span>
                                                    <input type="text" id="gigi_anomali_alasan"
                                                        name="gigi_anomali_alasan" class="form-control"
                                                        placeholder="Penjelasan">
                                                    <p
                                                        style="font-size: 14px; margin-top: 5px; font-style: italic; color: red">
                                                        (*dijelaskan gigi yang mana
                                                        dan bentuknya)</p>
                                                </div>
                                            </div>
                                            {{-- LAIN-LAIN  --}}
                                            <div class="form-group mb-3 mt-4">
                                                <div class="d-flex align-items-center" style="gap: 8px">
                                                    <label for="lain-lain"
                                                        style="min-width: 200px; margin-bottom: 0;">Lain-lain</label>
                                                    <span style="width: 30px;">:</span>
                                                    <input type="text" class="form-control" name="gigi_lain_lain"
                                                        id="gigi_lain-lain" placeholder="Lain-lain">
                                                </div>
                                                <p
                                                    style="font-size: 14px; font-style: italic; color: red; margin-top: 4px; margin-left: 26%;">
                                                    (*hal-hal yang tidak tercakup diatas)</p>
                                            </div>
                                            {{-- JUMLAH FOTO --}}
                                            <div class="form-group mb-3 mt-4">
                                                <div class="d-flex align-items-center" style="gap: 8px">
                                                    <label style="min-width: 200px; margin-bottom: 0;">Jumlah Foto yang
                                                        diambil</label>
                                                    <span style="width: 30px;">:</span>
                                                    <div id="foto_ambil">
                                                        <label for="digital" class="mr-3">
                                                            <input type="checkbox" name="foto_yg_diambil"
                                                                id="digital" value="Digital" checked
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            Digital
                                                        </label>
                                                        <label for="intraoral" class="mx-3">
                                                            <input type="checkbox" name="foto_yg_diambil"
                                                                id="intraoral" value="Intraoral"
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            Intraoral
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="foto_jumlah" style="margin-top: 8px; margin-left: 237px;">
                                                    <span style="width: 30px;"></span>
                                                    <input type="text" id="jumlah" name="foto_jumlah"
                                                        class="form-control mt-2 mb-2 w-25" placeholder="Jumlah">
                                                </div>
                                            </div>
                                            {{-- JUMLAH RONTGEN --}}
                                            <div class="form-group mb-3 mt-4">
                                                <div class="d-flex align-items-center" style="gap: 8px">
                                                    <label style="min-width: 200px; margin-bottom: 0;">Jumlah rontgen
                                                        photo
                                                        <br>
                                                        yang diambil</label>
                                                    <span style="width: 30px;">:</span>
                                                    <div id="foto_rontgen_ambil">
                                                        <label for="Dental" class="mr-3">
                                                            <input type="checkbox" name="foto_rontgen_ambil"
                                                                id="Dental" value="Dental" checked
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            Dental
                                                        </label>
                                                        <label for="PA" class="mx-3">
                                                            <input type="checkbox" name="foto_rontgen_ambil"
                                                                id="PA" value="PA"
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            PA
                                                        </label>
                                                        <label for="OPG" class="mx-3">
                                                            <input type="checkbox" name="foto_rontgen_ambil"
                                                                id="OPG" value="OPG"
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            OPG
                                                        </label>
                                                        <label for="Ceph" class="mx-3">
                                                            <input type="checkbox" name="foto_rontgen_ambil"
                                                                id="Ceph" value="Ceph"
                                                                style="transform: scale(1.5); margin-right: 10px;">
                                                            Ceph
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="foto_rontgen_jumlah"
                                                    style="margin-top: 8px; margin-left: 237px;">
                                                    <span style="width: 30px;"></span>
                                                    <input type="text" id="jumlah" name="foto_rontgen_jumlah"
                                                        class="form-control mt-2 mb-2 w-25" placeholder="Jumlah">
                                                </div>
                                                {{-- <div class="form-group">
                                                    <p style="margin-bottom: 5px; margin-top: 15px">Keterangan</p>
                                                    <textarea name="gigi_keterangan" id="gigi_keterangan" cols="57" rows="5" class="form-control"
                                                        placeholder="Keterangan"></textarea>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <hr>

                                        {{-- TINDAKAN --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Tindakan</label>
                                                <input type="date" class="form-control mt-2 mb-2"
                                                    name="tindakan_gigi" id="tindakan_gigi" placeholder="Tindakan">
                                            </div>
                                        </div>
                                        {{-- PROSEDURE TINDAKAN --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Prosedur Tindakan Tindakan</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="prosedur_tindakan" id="prosedur_tindakan"
                                                    placeholder="Prosedur Tindakan">
                                            </div>
                                        </div>
                                        {{-- TANGGAL RENCANA --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Tanggal Rencana</label>
                                                <input type="date" class="form-control mt-2 mb-2"
                                                    name="tgl_rencana" id="tgl_rencana"
                                                    placeholder="Prosedur Tindakan">
                                            </div>
                                        </div>
                                        {{-- LAMA TINDAKAN --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Lama Tindakan</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="lama_tindakan" id="lama_tindakan"
                                                    placeholder="Lama Tindakan">
                                            </div>
                                        </div>
                                        {{-- HASIL --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Hasil</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="hasil_tindakan" id="hasil_tindakan" placeholder="Hasil">
                                            </div>
                                        </div>
                                        {{-- INDIKASI --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Indikasi</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="indikasi_tindakan" id="indikasi_tindakan"
                                                    placeholder="Indikasi">
                                            </div>
                                        </div>
                                        {{-- TUJUAN --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Tujuan</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="tujuan_tindakan" id="tujuan_tindakan" placeholder="Tujuan">
                                            </div>
                                        </div>
                                        {{-- RESIKO --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Resiko</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="resiko_tindakan" id="resiko_tindakan" placeholder="Resiko">
                                            </div>
                                        </div>
                                        {{-- KOMPLIKASI --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Komplikasi</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="komplikasi_tindakan" id="komplikasi_tindakan"
                                                    placeholder="Komplikasi">
                                            </div>
                                        </div>
                                        {{-- PROGNOSA --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Prognosa</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="prognosa_tindakan" id="prognosa_tindakan"
                                                    placeholder="Prognosa">
                                            </div>
                                        </div>
                                        {{-- ALTERNATIF --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Alternatif & Resiko</label>
                                                <input type="text" class="form-control mt-2 mb-2"
                                                    name="alternatif_resiko" id="alternatif_resiko"
                                                    placeholder="Alternatif & Resiko">
                                            </div>
                                        </div>
                                        {{-- KETERANGAN TINDAKAN --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Keterangan Tindakan</label>
                                                <textarea class="form-control mt-2 mb-2" name="keterangan_tindakan" id="keterangan_tindakan" cols="10"
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="tutup" style="margin-top: 20px; margin-bottom: 30px;">
                                            <button type="submit" class="btn btn-primary ml-1">
                                                <i class="fas fa-file"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin.layout.terminal>
