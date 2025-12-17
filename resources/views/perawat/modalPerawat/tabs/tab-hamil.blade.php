<div class="form-hamil{{ $booking->id }}">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2" class="text-center fw-bold fs-5 bg-light">SUBYEKTIF</th>
                </tr>

                <tr>
                    <th class="w-30 fw-bold align-middle" style="vertical-align: middle;">Riwayat Kontrasepsi Terakhir
                    </th>
                    <td class="p-3">
                        <div class="row g-4">
                            <!-- Baris atas -->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-start flex-wrap gap-5">
                                    <label class="form-check-label d-flex align-items-center">
                                        <input type="checkbox" name="kontra_tidak_menggunakan" value="Tidak Menggunakan"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        Tidak Menggunakan
                                    </label>

                                    <label class="form-check-label d-flex align-items-center">
                                        <input type="checkbox" name="kontra_suntik" value="Suntik"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        Suntik
                                    </label>

                                    <label class="form-check-label d-flex align-items-center">
                                        <input type="checkbox" name="kontra_pil" value="Pil"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        Pil
                                    </label>
                                </div>
                            </div>

                            <!-- Baris bawah -->
                            <div class="col-md-12">
                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                    <div class="form-check d-flex align-items-center me-3">
                                        <input type="checkbox" name="kontra_iud" value="IUD"
                                            class="form-check-input me-2" style="transform: scale(1.3);">
                                        <label class="form-check-label mb-0">IUD</label>
                                    </div>

                                    <div class="form-check d-flex align-items-center me-3">
                                        <input type="checkbox" name="kontra_implan" value="Implan"
                                            class="form-check-input me-2" style="transform: scale(1.3);">
                                        <label class="form-check-label mb-0">Implan</label>
                                    </div>

                                    <div class="form-check d-flex align-items-center me-3">
                                        <label class="form-check-label mb-0">Lain-lain:</label>
                                        <input type="text" name="kontra_lainnya" class="form-control ms-2"
                                            style="width: 400px;">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </td>
                </tr>

                <tr>
                    <th rowspan="1" class="fw-bold bg-light" style="width: 18%; vertical-align: top;">
                        Riwayat Kehamilan Terdahulu
                    </th>
                    <td>
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th colspan="2" class="text-center fw-bold">Hamil Ke-</th>
                                    <th rowspan="2" class="text-center fw-bold align-middle">BERAT LAHIR (gram)</th>
                                    <th rowspan="2" class="text-center fw-bold align-middle">PENOLONG PERSALINAN</th>
                                    <th rowspan="2" class="text-center fw-bold align-middle">CARA PERSALINAN</th>
                                    <th rowspan="2" class="text-center fw-bold align-middle">KEADAAN BAYI</th>
                                    <th rowspan="2" class="text-center fw-bold align-middle">KOMPLIKASI</th>
                                </tr>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    <th class="text-center">Umur Anak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 5; $i++)
                                    <tr>
                                        <!-- No. Urut -->
                                        <td class="text-center fw-bold">{{ $i }}</td>

                                        <!-- Umur Anak -->
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm border-0 border-bottom"
                                                name="hd_umur_anak_{{ $i }}" placeholder="tahun">
                                        </td>

                                        <!-- Berat Lahir -->
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm border-0 border-bottom text-center"
                                                name="hd_berat_lahir_{{ $i }}" placeholder="gram">
                                        </td>

                                        <!-- Penolong Persalinan (Dropdown) -->
                                        <td class="text-center">
                                            <select class="form-select form-select-sm"
                                                name="hd_penolong_{{ $i }}">
                                                <option value="">- Pilih -</option>
                                                <option value="Dokter">Dokter</option>
                                                <option value="Bidan">Bidan</option>
                                                <option value="Dukun">Dukun</option>
                                            </select>
                                        </td>

                                        <!-- Cara Persalinan (Dropdown) -->
                                        <td class="text-center">
                                            <select class="form-select form-select-sm"
                                                name="hd_cara_persalinan_{{ $i }}">
                                                <option value="">- Pilih -</option>
                                                <option value="Normal">Normal</option>
                                                <option value="SC">SC</option>
                                            </select>
                                        </td>

                                        <!-- Keadaan Bayi (Dropdown) -->
                                        <td class="text-center">
                                            <select class="form-select form-select-sm"
                                                name="hd_keadaan_bayi_{{ $i }}">
                                                <option value="">- Pilih -</option>
                                                <option value="Sehat">Sehat</option>
                                                <option value="Sakit/Cacat">Sakit / Cacat</option>
                                                <option value="Mati">Mati</option>
                                            </select>
                                        </td>

                                        <!-- Komplikasi -->
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm border-0 border-bottom"
                                                name="hd_komplikasi_{{ $i }}">
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>

                        <!-- ======= STATUS PSIKO-SOSIOKULTURAL DAN SPIRITUAL ======= -->
                        <div class="status">
                            <p class="mt-3 fw-bold">Status psiko-sosiokultural dan spiritual :</p>
                            <div class="ms-3">
                                <p class="mb-2"><strong>a. Status mental :</strong></p>
                                <div class="d-flex flex-wrap gap-5 ms-4 mb-3">
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_status_mental_orientasi"
                                            id="hd_status_mental_orientasi" class="form-check-input me-2"
                                            style="transform: scale(1.4);"> orientasi
                                        baik
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_status_mental_disorientasi"
                                            id="hd_status_mental_disorientasi" class="form-check-input me-2"
                                            style="transform: scale(1.4);">
                                        disorientasi
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_status_mental_gelisah"
                                            id="hd_status_mental_gelisah" class="form-check-input me-2"
                                            style="transform: scale(1.4);">
                                        gelisah
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_status_mental_tidak_respon"
                                            id="hd_status_mental_tidak_respon" class="form-check-input me-2"
                                            style="transform: scale(1.4);"> tidak
                                        respons
                                    </label>
                                </div>

                                <p class="mb-2"><strong>b. Respons emosi :</strong></p>
                                <div class="d-flex flex-wrap gap-5 ms-4 mb-3">
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_respons_tenang" id="hd_respons_tenang"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        tenang
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_respons_takut" id="hd_respons_takut"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        takut
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_respons_tegang" id="hd_respons_tegang"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        tegang
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_respons_marah" id="hd_respons_marah"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        marah
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_respons_sedih" id="hd_respons_sedih"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        sedih
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_respons_menangis" id="hd_respons_menangis"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        menangis
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_respons_gelisah" id="hd_respons_gelisah"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        gelisah
                                    </label>
                                </div>

                                <p class="mb-2"><strong>c. Hubungan pasien dengan keluarga :</strong></p>
                                <div class="d-flex gap-5 ms-4 mb-3">
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_hubungan_baik" id="hd_hubungan_baik"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        baik
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_hubungan_tidak_baik"
                                            class="form-check-input me-2" style="transform: scale(1.4);"> tidak
                                        baik
                                    </label>
                                </div>

                                <p class="mb-2"><strong>d. Ketaatan menjalankan ibadah :</strong></p>
                                <div class="d-flex gap-5 ms-4 mb-3">
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_taat_baik" id="hd_taat_baik"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        baik
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_taat_tidak_baik" id="hd_taat_tidak_baik"
                                            class="form-check-input me-2" style="transform: scale(1.4);"> tidak
                                        baik
                                    </label>
                                </div>

                                <p class="mb-2"><strong>e. Bahasa :</strong></p>
                                <div class="d-flex flex-wrap gap-5 align-items-center ms-4">
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_bhs_indo" id="hd_bhs_indo"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        Indonesia
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="hd_bhs_jawa" id="hd_bhs_jawa"
                                            class="form-check-input me-2" style="transform: scale(1.4);">
                                        Jawa
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <span>
                                            lainnya
                                        </span>
                                        <input type="text" name="hd_bhs_lainnya" id="hd_bhs_lainnya"
                                            class="form-control ms-2" style="width: 400px;">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th class="fw-bold bg-light" style="width: 18%; vertical-align: top;">
                        Riwayat Kehamilan Sekarang
                    </th>
                    <td class="p-3">
                        <!-- RIWAYAT PERKAWINAN -->
                        {{-- <div class="mb-4">
                            <strong>RIWAYAT PERKAWINAN</strong>
                            <div class="ms-4 mt-2">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-3" style="width: 150px;">Bersuami</span>
                                    <label class="d-flex align-items-center me-4">
                                        <input type="checkbox" name="bersuami_ya" class="form-check-input me-2"
                                            style="transform: scale(1.4);"> Ya
                                    </label>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="bersuami_tidak" class="form-check-input me-2"
                                            style="transform: scale(1.4);"> Tidak
                                    </label>
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-3" style="width: 150px;">Berapa lama</span>
                                    <span class="border-bottom border-dark"
                                        style="width: 400px; display: inline-block;"></span>
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-3" style="width: 150px;">Berapa kali</span>
                                    <span class="border-bottom border-dark"
                                        style="width: 400px; display: inline-block;"></span>
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-3" style="width: 150px;">Usia pertama kali kawin</span>
                                    <span class="border-bottom border-dark"
                                        style="width: 400px; display: inline-block;"></span>
                                </div>
                            </div>
                        </div> --}}

                        <!-- RIWAYAT MENSTRUASI -->
                        <div class="mb-4">
                            <strong>RIWAYAT MENSTRUASI</strong>
                            <div class="ms-4 mt-3">

                                <div>
                                    <!-- HPHT -->
                                    <div class="row align-items-center mb-3">
                                        <label class="col-sm-3 col-form-label">HPHT</label>
                                        <div class="col-sm-4">
                                            <input type="date" wire:model="hpht" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Usia Kehamilan -->
                                    <div class="row align-items-center mb-3">
                                        <label class="col-sm-3 col-form-label">Usia Kehamilan</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" wire:model="usia_kehamilan"
                                                placeholder="Usia Kehamilan" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Siklus Menstruasi -->
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-3 col-form-label">Siklus Menstruasi</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="hs_rm_siklus_hari" id="hs_rm_siklus_hari"
                                            class="form-control">
                                    </div>
                                    <div class="col-auto align-self-center me-3">hari,</div>

                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_siklus_teratur"
                                                id="hs_rm_siklus_teratur" class="form-check-input"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label" for="hs_rm_siklus_teratur">Teratur</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_siklus_tidak_teratur"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Tidak Teratur</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Banyaknya Haid -->
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-3 col-form-label">Banyaknya Haid</label>
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_banyak_banyak"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Banyak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_banyak_sedang"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Sedang</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_banyak_sedikit"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Sedikit</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gumpalan -->
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-3 col-form-label">Gumpalan</label>
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_gumpalan_gumpal"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Gumpal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_gumpalan_biasa"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Biasa</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_gumpalan_encair"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Encer</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Merasa Sakit -->
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-3 col-form-label">Merasa Sakit</label>
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_sakit_sebelum"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Sebelum Haid</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_sakit_selama" class="form-check-input"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Selama Haid</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_sakit_sesudah"
                                                class="form-check-input" style="transform: scale(1.3);">
                                            <label class="form-check-label">Sesudah Haid</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fluor -->
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-3 col-form-label">Fluor</label>
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_fluor_ya" class="form-check-input"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="hs_rm_fluor_tidak" class="form-check-input"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Garis bawah custom -->
                                <div class="ms-5">
                                    <div class="row align-items-center mb-2">
                                        <label class="col-sm-3 col-form-label">Berapa lama</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="hs_rm_berapa_lama" id="hs_rm_berapa_lama"
                                                class="form-control mt-2 mb-2">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <label class="col-sm-3 col-form-label">Warna</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="hs_rm_warna" id="hs_rm_warna"
                                                class="form-control mt-2 mb-2">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <label class="col-sm-3 col-form-label">Jumlah</label>

                                        <div class="col-sm-4 d-flex align-items-center">
                                            <div class="form-check form-check-inline me-2">
                                                <input type="checkbox" name="hs_rm_jumlah_banyak"
                                                    class="form-check-input" style="transform: scale(1.3);">
                                                <label class="form-check-label">banyak</label>
                                            </div>
                                            <span class="mx-2">/</span>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="hs_rm_jumlah_sedikit"
                                                    class="form-check-input" style="transform: scale(1.3);">
                                                <label class="form-check-label">sedikit</label>
                                            </div>
                                        </div>

                                        {{-- <div class="col-sm-5">
                                            <input type="text" name="jumlah_lain" id="jumlah_lain"
                                                class="form-control" placeholder="Isi jika lain-lain">
                                        </div> --}}
                                    </div>

                                    <div class="row align-items-center mb-2">
                                        <label class="col-sm-3 col-form-label">Bau</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="hs_rm_bau" id="hs_rm_bau"
                                                class="form-control mt-2 mb-2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- STATUS IMUNISASI -->
                        <div class="mt-4">
                            <strong>STATUS IMUNISASI</strong>
                            <div class="ms-4 mt-3">
                                <div class="row align-items-center mb-3">
                                    <label class="col-sm-3 col-form-label">Imunisasi TT</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="" id=""
                                            class="form-control mt-2 mb-2">
                                    </div>
                                    <div class="col-auto">(bulan/tahun)</div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>

                <tr>
                    <th colspan="2" class="text-center fw-bold fs-5 bg-light">OBJEKTIF</th>
                </tr>

                <tr>
                    <th class="fw-bold bg-light" style="width: 18%; vertical-align: top;">Pemeriksaan</th>
                    <td class="p-4">
                        <div class="row">
                            <!-- KIRI: STATUS GENERALIS -->
                            <div class="col-md-6 border-end border-dark pe-4">
                                <strong class="mb-3 d-block">STATUS GENERALIS</strong>

                                <!-- Bentuk Tubuh -->
                                <div class="mb-4">
                                    <strong>Bentuk Tubuh :</strong>
                                    <div class="ms-4 mt-2 d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_bentuk_normal"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_bentuk_kelainan_panggul" style="transform: scale(1.3);">
                                            <label class="form-check-label">Kelainan panggul</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_bentuk_tulang_belakang" style="transform: scale(1.3);">
                                            <label class="form-check-label">Kelainan tulang belakang</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_bentuk_tungkai"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Kelainan tungkai</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payudara -->
                                <div class="mb-4">
                                    <strong>Payudara :</strong>
                                    <div class="ms-4 mt-2 d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_payudara_normal" style="transform: scale(1.3);">
                                            <label class="form-check-label">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_payudara_benjolan" style="transform: scale(1.3);">
                                            <label class="form-check-label">Benjolan</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_payudara_kemerahan" style="transform: scale(1.3);">
                                            <label class="form-check-label">Kemerahan</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_payudara_retracted_nipple" style="transform: scale(1.3);">
                                            <label class="form-check-label">Retracted Nipple</label>
                                        </div>
                                    </div>
                                    <div class="ms-5 mt-2">
                                        <label>Lainnya :</label>
                                        <input type="text" name="obj_payudara_lainnya" class="form-control mt-1">
                                    </div>
                                </div>
                            </div>

                            <!-- KANAN: STATUS KEBIDANAN & GIZI -->
                            <div class="col-md-6 ps-4">
                                <strong class="mb-3 d-block">STATUS KEBIDANAN</strong>

                                <div class="mb-3 d-flex align-items-center">
                                    <span class="me-3" style="width: 180px;">Tinggi Fundus Uteri</span>
                                    <input type="text" name="obj_tinggi_fundus" class="form-control me-2">
                                    <span>cm</span>
                                </div>

                                <div class="mb-3">
                                    <strong>Letak Janin :</strong>
                                    <div class="ms-4 d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_letak_kepala"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Kepala</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_letak_sungsang"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Sungsang</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_letak_lintang"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Lintang</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <strong>Gerak Janin :</strong>
                                    <div class="ms-4 d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_gerak_aktif"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Aktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_gerak_jarang"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Jarang</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_gerak_tidak_ada" style="transform: scale(1.3);">
                                            <label class="form-check-label">Tidak Ada</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <span class="me-3" style="width: 180px;">Detak Jantung Janin</span>
                                    <input type="text" name="obj_detak_jantung" class="form-control me-2">
                                    <span>x/menit</span>
                                </div>

                                <div class="mb-4">
                                    <strong>Perdarahan :</strong>
                                    <div class="ms-4 d-flex gap-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="obj_perdarahan_ya"
                                                style="transform: scale(1.3);">
                                            <label class="form-check-label">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="obj_perdarahan_tidak" style="transform: scale(1.3);">
                                            <label class="form-check-label">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <strong class="mb-3 d-block">STATUS GIZI</strong>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-3" style="width: 120px;">Tinggi Badan</span>
                                    <input type="text" class="form-control me-2" style="width: 200px;">
                                    <span>cm</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

            </thead>
        </table>
    </div>
</div>
