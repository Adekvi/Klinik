<div id="formKajian<?php echo e($booking->id); ?>">
    <div class="kebiasaan">
        <h5 class="text-center fw-bold" onclick="toggleStep(this)">
            Kebiasaan</h5>
        <div class="row">
            <div class="col-md-3">
                <!-- Rokok -->
                <div class="form-group mt-3">
                    <p class="text-start">Rokok</p>
                    <div id="rokok">
                        <label for="rokok-ya" style="gap: 10; margin-right: 10px;">
                            <input type="radio" name="rokok" id="rokok-ya" value="Ya"
                                style="transform: scale(1.5); margin-right: 10px;"> Ya
                        </label>
                        <label for="rokok-tidak">
                            <input type="radio" name="rokok" id="rokok-tidak" value="Tidak" checked
                                style="transform: scale(1.5); margin-right: 10px;"> Tidak
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Alkohol -->
                <div class="form-group mt-3">
                    <p class="text-start">Alkohol</p>
                    <div id="alkohol">
                        <label for="alkohol-ya" style="gap: 10; margin-right: 10px;">
                            <input type="radio" name="alkohol" id="alkohol-ya" value="Ya"
                                style="transform: scale(1.5); margin-right: 10px;"> Ya
                        </label>
                        <label for="alkohol-tidak">
                            <input type="radio" name="alkohol" id="alkohol-tidak" value="Tidak" checked
                                style="transform: scale(1.5); margin-right: 10px;"> Tidak
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Olahraga -->
                <div class="form-group mt-3">
                    <p class="text-start">Olahraga</p>
                    <div id="olahraga">
                        <label for="olahraga-ya" style="gap: 10; margin-right: 10px;">
                            <input type="radio" name="olahraga" id="olahraga-ya" value="Ya"
                                style="transform: scale(1.5); margin-right: 10px;"> Ya
                        </label>
                        <label for="olahraga-tidak">
                            <input type="radio" name="olahraga" id="olahraga-tidak" value="Tidak" checked
                                style="transform: scale(1.5); margin-right: 10px;"> Tidak
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Obat Tidur -->
                <div class="form-group mt-3">
                    <p class="text-start">Obat Tidur</p>
                    <div id="obat_tidur">
                        <label for="obat_tidur-ya" style="gap: 10; margin-right: 10px;">
                            <input type="radio" name="obat_tidur" id="obat_tidur-ya" value="Ya"
                                style="transform: scale(1.5); margin-right: 10px;"> Ya
                        </label>
                        <label for="obat_tidur-tidak">
                            <input type="radio" name="obat_tidur" id="obat_tidur-tidak" value="Tidak" checked
                                style="transform: scale(1.5); margin-right: 10px;"> Tidak
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="riwayat-lahir">
        <h5 class="text-center fw-bold" onclick="toggleStep(this)">
            Riwayat Lahir</h5>
        <div id="p_anak_riwayat_lahir" class="form-group mb-2 text-center">
            <label for="p_anak_riwayat_lahir_spontan">
                <input type="checkbox" name="p_anak_riwayat_lahir_spontan" id="p_anak_riwayat_lahir_spontan"
                    value="Spontan" style="transform: scale(1.5); margin-right: 10px;">Spontan
            </label>
            <label for="p_anak_riwayat_lahir_operasi">
                <input type="checkbox" name="p_anak_riwayat_lahir_operasi" id="p_anak_riwayat_lahir_operasi"
                    value="Operasi" style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">Operasi
            </label>
        </div>
        <div id="p_anak_riwayat_lahir">
            <label for="p_anak_riwayat_lahir" onclick="toggleInput('p_anak_riwayat_lahir)">Riwayat
                Lahir Bulan</label>
            <div id="p_anak_riwayat_lahir">

                <div class="form-group mb-2 mt-2">
                    <label>
                        <input type="radio"
                            name="p_anak_riwayat_lahir_bulan"
                            value="cukup"
                            style="transform: scale(1.5); margin-right: 10px">
                        Cukup Bulan
                    </label>

                    <label style="margin-left: 30px">
                        <input type="radio"
                            name="p_anak_riwayat_lahir_bulan"
                            value="kurang"
                            style="transform: scale(1.5); margin-right: 10px">
                        Kurang Bulan
                    </label>
                </div>
            </div>

        </div>
        <div class="form-group mt-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="p_anak_riwayat_lahir_bb">Berat Badan Lahir</label>
                    <div class="input-group">
                        <input type="text" name="p_anak_riwayat_lahir_bb" wire:model.defer="p_anak_riwayat_lahir_bb"  class="form-control mt-2 mb-2">
                        <div class="input-group-append mb-2 mt-2">
                            <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                <b>Kg</b>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="p_anak_riwayat_lahir_pb">Panjang Badan Lahir</label>
                    <div class="input-group">
                        <input type="text" name="p_anak_riwayat_lahir_pb" wire:model.defer="p_anak_riwayat_lahir_pb" class="form-control mt-2 mb-2">
                        <div class="input-group-append mb-2 mt-2">
                            <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                <b>cm</b>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="p_anak_riwayat_lahir_vaksin">Riwayat Vaksin</label>
            <div class="form-group mb-2 mt-2">
                <label for="p_anak_riwayat_lahir_bulan">
                    <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_bcg"
                        id="p_anak_riwayat_lahir_vaksin_bcg" value="BCG"
                        style="transform: scale(1.5); margin-right: 10px">BCG
                </label>
                <label for="p_anak_riwayat_lahir_vaksin">
                    <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_hepatitis"
                        id="p_anak_riwayat_lahir_vaksin_hepatitis" value="HEPATITIS"
                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">HEPATITIS
                </label>
                <label for="p_anak_riwayat_lahir_vaksin">
                    <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_dpt"
                        id="p_anak_riwayat_lahir_vaksin_dpt" value="DPT"
                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">DPT
                </label>
                <label for="p_anak_riwayat_lahir_vaksin">
                    <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_campak"
                        id="p_anak_riwayat_lahir_vaksin_campak" value="CAMPAK"
                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">CAMPAK
                </label>
                <label for="p_anak_riwayat_lahir_vaksin">
                    <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_polio"
                        id="p_anak_riwayat_lahir_vaksin_polio" value="POLIO"
                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">POLIO
                </label>
            </div>
        </div>
    </div>
    <hr>

    <div class="asesmen-keperawatan">
        <h5 class="text-center fw-bold" onclick="toggleStep(this)">Asesmen Keperawatan</h5>
        <div class="form-group">
            <label for="nutrisi" onclick="toggleInput('nutrisi')">Nutrisi</label>
            <div class="col-lg-12 mb-2">
                <div class="row">
                    <div class="col-md-3">
                        <label for="berat-badan">Berat Badan</label>
                        <div class="input-group">
                            <input type="number" name="nutrisi_bb" wire:model.live="nutrisi_bb" class="form-control mt-2 mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text mb-2 mt-2" id="basic-addon2"
                                    style="background: rgb(228, 228, 228)">
                                    <b>ons/kg</b>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="tinggi-badan">Tinggi Badan</label>
                        <div class="input-group">
                            <input type="number" name="nutrisi_tb" wire:model.live="nutrisi_tb" class="form-control mt-2 mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text mb-2 mt-2" id="basic-addon2"
                                    style="background: rgb(228, 228, 228)">
                                    <b>cm</b>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="imt">IMT</label>
                        <div class="input-group">
                            <input type="text" name="nutrisi_imt" wire:model="nutrisi_imt" class="form-control mt-2 mb-2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text mb-2 mt-2" id="basic-addon2"
                                    style="background: rgb(228, 228, 228)">
                                    <b>kg/m2</b>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="ak_jenisaktivitas_mobilisasi" onclick="toggleInput('ak_jenisaktivitas_mobilisasi')">Aktivitas
                Latihan</label>
            <div class="row">
                <div class="col-md-6">
                    <select name="ak_jenisaktivitas_mobilisasi" id="ak_jenisaktivitas_mobilisasi"
                        class="form-control mt-2 mb-2 ">
                        <option value="">Pilih Aktivitas Mobilisasi</option>
                        <option value="0 Mandiri">0 Mandiri</option>
                        <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                        <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                            Lain
                        </option>
                        <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                            bantuan
                            Orang Lain dan Alat</option>
                        <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                            Tidak
                            Mampu</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="ak_jenisaktivitas_toileting" id="ak_jenisaktivitas_toileting"
                        class="form-control mt-2 mb-2 ">
                        <option value="">Pilih Aktivitas Toileting</option>
                        <option value="0 Mandiri">0 Mandiri</option>
                        <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                        <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                            Lain
                        </option>
                        <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                            bantuan
                            Orang Lain dan Alat</option>
                        <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                            Tidak
                            Mampu</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="ak_jenisaktivitas_makan_minum" id="ak_jenisaktivitas_makan_minum"
                        class="form-control mt-2 mb-2 ">
                        <option value="">Pilih Aktivitas Makan Minum</option>
                        <option value="0 Mandiri">0 Mandiri</option>
                        <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                        <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                            Lain
                        </option>
                        <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                            bantuan
                            Orang Lain dan Alat</option>
                        <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                            Tidak
                            Mampu</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="ak_jenisaktivitas_mandi" id="ak_jenisaktivitas_mandi"
                        class="form-control mt-2 mb-2 ">
                        <option value="">Pilih Aktivitas Mandi</option>
                        <option value="0 Mandiri">0 Mandiri</option>
                        <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                        <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                            Lain
                        </option>
                        <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                            bantuan
                            Orang Lain dan Alat</option>
                        <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                            Tidak
                            Mampu</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="ak_jenisaktivitas_berpakaian" id="ak_jenisaktivitas_berpakaian"
                        class="form-control mt-2 mb-2 ">
                        <option value="">Pilih Aktivitas Berpakaian</option>
                        <option value="0 Mandiri">0 Mandiri</option>
                        <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                        <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang Lain
                        </option>
                        <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu bantuan Orang
                            Lain dan Alat</option>
                        <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau Tidak
                            Mampu
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="resikojatuh" onclick="toggleInput('resikojatuh')">Resiko
                Jatuh</label>
            <div class="form-group mb-2 mt-2">
                <label for="ak_resiko_jatuh">
                    <input type="radio" name="ak_resiko_jatuh" value="Rendah" style="transform: scale(1.5); margin-right: 10px"> Rendah &nbsp;&nbsp;
                    <input type="radio" name="ak_resiko_jatuh" value="Sedang" style="transform: scale(1.5); margin-right: 10px"> Sedang &nbsp;&nbsp;
                    <input type="radio" name="ak_resiko_jatuh" value="Tinggi" style="transform: scale(1.5); margin-right: 10px"> Tinggi &nbsp;&nbsp;
                </label>
            </div>
        </div>
        <div class="form-group mt-3">
            <p onclick="toggleInput('psikologis')">
                Psikologis
            </p>
            <div id="psikologis">
                <label for="psikologis-senang">
                    <input type="checkbox" name="ak_psikologis_senang" id="ak_psikologis_senang" value="Senang"
                        style="transform: scale(1.5); margin-right: 7px;">
                    Senang
                </label>
                <label for="psikologis-tenang">
                    <input type="checkbox" name="ak_psikologis_tenang" id="ak_psikologis_tenang" value="Tenang"
                        style="transform: scale(1.5); margin-right: 7px; margin-left: 20px">
                    Tenang
                </label>
                <label for="psikologis-sedih">
                    <input type="checkbox" name="ak_psikologis_sedih" id="ak_psikologis_sedih" value="Sedih"
                        style="transform: scale(1.5); margin-right: 7px; margin-left: 20px">
                    Sedih
                </label>
                <label for="psikologis-tegang">
                    <input type="checkbox" name="ak_psikologis_tegang" id="ak_psikologis_tegang" value="Tegang"
                        style="transform: scale(1.5); margin-right: 7px; margin-left: 20px">
                    Tegang
                </label>
                <label for="psikologis-takut">
                    <input type="checkbox" name="ak_psikologis_takut" id="ak_psikologis_takut" value="Takut"
                        style="transform: scale(1.5); margin-right: 7px; margin-left: 20px">
                    Takut
                </label>
                <label for="psikologis-depresi">
                    <input type="checkbox" name="ak_psikologis_depresi" id="ak_psikologis_depresi" value="Depresi"
                        style="transform: scale(1.5); margin-right: 7px; margin-left: 20px">
                    Depresi
                </label>
                <label for="psikologis-lainnya">
                    <input type="checkbox" name="alasan_ak_psikologis_lain" id="ak_psikologis-lainnya"
                        value="Lainnya" style="transform: scale(1.5); margin-right: 7px; margin-left: 20px">
                    Lainnya
                </label>
                <div id="alasan-ak_psikologis" style="display: none;">
                    <input type="text" id="alasan-ak_psikologis" name="alasan_ak_psikologis_lain"
                        class="form-control mt-2 mb-2">
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="ak_masalah" onclick="toggleInput('ak_masalah')">Masalah</label>
            <div class="col-md-6">
                <input type="text" name="ak_masalah" id="ak_masalah" class="form-control mt-2 mb-2 "
                    placeholder="Masalah">
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="ak_rencana_tindakan" onclick="toggleInput('ak_rencana_tindakan')">Rencana
                Tindakan</label>
            <div class="col-md-6">
                <input type="text" name="ak_rencana_tindakan" id="ak_rencana_tindakan"
                    class="form-control mt-2 mb-2" placeholder="Rencana Tindakan">
            </div>
        </div>
    </div>
    <hr>

    <div class="psicososial-pengetahuan">
        <h5 class="text-center fw-bold" onclick="toggleStep(this)">Riwayat
            Psicososial dan
            Pengetahuan
        </h5>
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="psico_pengetahuan_ttg_penyakit_ini"
                        onclick="toggleInput('psico_pengetahuan_ttg_penyakit_ini')">Pengetahuan
                        tentang Penyakit</label>
                    <div class="col mt-3 margin-left: 35px">
                        <input type="radio" name="psico_pengetahuan_ttg_penyakit_ini"
                            id="psico_pengetahuan_ttg_penyakit_ini-tahu" value="Tahu"
                            style="transform: scale(1.5); margin-right: 10px">Tahu
                        <input type="radio" name="psico_pengetahuan_ttg_penyakit_ini"
                            id="psico_pengetahuan_ttg_penyakit_ini-tidak_tahu" value="Tidak-Tahu"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px" checked>Tidak Tahu
                    </div>
                </div>
                <div class="col-6">
                    <label for="psico_perawatan_tindakan_yg_dlakukan"
                        onclick="toggleInput('psico_perawatan_tindakan_yg_dlakukan')">Perawatan/Tindakan
                        Yang Dilakukan</label>
                    <div class="col mt-3 margin-left: 35px">
                        <input type="radio" name="psico_perawatan_tindakan_yg_dlakukan"
                            id="psico_perawatan_tindakan_yg_dlakukan-mengerti" value="Mengerti"
                            style="transform: scale(1.5); margin-right: 10px">Mengerti
                        <input type="radio" name="psico_perawatan_tindakan_yg_dlakukan"
                            id="psico_perawatan_tindakan_yg_dlakukan-tidak_mengerti" value="Tidak-mengerti"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px" checked>Tidak Mengerti
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <label for="psico_adakah_keyakinan_pantangan"
                        onclick="toggleInput('psico_adakah_keyakinan_pantangan')">Adakah
                        Keyakinan atau Pantangan</label>
                    <div class="col mt-3 margin-left: 35px">
                        <input type="radio" name="psico_adakah_keyakinan_pantangan"
                            id="psico_adakah_keyakinan_pantangan-ada" value="Ada"
                            style="transform: scale(1.5); margin-right: 10px">Ada
                        <input type="radio" name="psico_adakah_keyakinan_pantangan"
                            id="psico_adakah_keyakinan_pantangan-tidak" value="Tidak"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px" checked>Tidak
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <label for="psico_kendala_kominukasi" onclick="toggleInput('psico_kendala_kominukasi')">Kendala
                        Komunikasi</label>
                    <div class="col mt-3 margin-left: 35px">
                        <input type="radio" name="psico_kendala_kominukasi" id="psico_kendala_kominukasi-ada"
                            value="Ada" style="transform: scale(1.5); margin-right: 10px">Ada
                        <input type="radio" name="psico_kendala_kominukasi" id="psico_kendala_kominukasi-tidak"
                            value="Tidak" style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                            checked>Tidak
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <label for="psico_yang_merawat_dirumah" onclick="toggleInput('psico_yang_merawat_dirumah')">Yang
                        Merawat
                        Dirumah</label>
                    <div class="col mt-3 margin-left: 35px">
                        <input type="radio" name="psico_yang_merawat_dirumah" id="psico_yang_merawat_dirumah-ada"
                            value="Ada" style="transform: scale(1.5); margin-right: 10px">Ada
                        <input type="radio" name="psico_yang_merawat_dirumah" id="psico_yang_merawat_dirumah-tidak"
                            value="Tidak" style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                            checked>Tidak
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="asesmen-nyeri">
        <h5 class="text-center fw-bold" onclick="toggleStep(this)">Asesmen
            Nyeri</h5>
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="apakah_pasien_merasakan_nyeri"
                        onclick="toggleInput('apakah_pasien_merasakan_nyeri')">Apakah pasien merasakan nyeri</label>
                    <div class="col mt-3 margin-left: 35px">
                        <input type="radio" name="apakah_pasien_merasakan_nyeri"
                            id="apakah_pasien_merasakan_nyeri-ya" value="ya"
                            style="transform: scale(1.5); margin-right: 10px">Ya
                        <input type="radio" name="apakah_pasien_merasakan_nyeri"
                            id="apakah_pasien_merasakan_nyeri-tidak" value="tidak"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px" checked>Tidak
                    </div>
                </div>
                <div class="col-6">
                    <label for="nyeri_pencetus" onclick="toggleInput('nyeri_pencetus')">Pencetus</label>
                    <input type="text" name="nyeri_pencetus" id="nyeri_pencetus" class="form-control mt-2 mb-2 ">
                </div>
                <div class="col-12">
                    <label for="nyeri_kualitas" onclick="toggleInput('nyeri_kualitas')">Kualitas</label>
                    <div class="col mt-3 mb-3" id="nyeri">
                        <label for="nyeri-tekanan">
                            <input type="radio" name="nyeri_kualitas" id="nyeri_kualitas-tekanan" value="Tekanan"
                                style="transform: scale(1.5); margin-right: 10px;">
                            Tekanan
                        </label>
                        <label for="nyeri-terbakar">
                            <input type="radio" name="nyeri_kualitas" id="nyeri_kualitas-terbakar"
                                value="Terbakar" style="transform: scale(1.5); margin-right: 10px; margin-left: 20px">
                            Terbakar
                        </label>
                        <label for="nyeri-melilit">
                            <input type="radio" name="nyeri_kualitas" id="nyeri_kualitas-melilit" value="Melilit"
                                style="transform: scale(1.5); margin-right: 10px; margin-left: 20px">
                            Melilit
                        </label>
                        <label for="nyeri-tertusuk">
                            <input type="radio" name="nyeri_kualitas" id="nyeri_kualitas-tertusuk"
                                value="Tertusuk" style="transform: scale(1.5); margin-right: 10px; margin-left: 20px">
                            Tertusuk
                        </label>
                        <label for="nyeri-diiris">
                            <input type="radio" name="nyeri_kualitas" id="nyeri_kualitas-diiris" value="Diiris"
                                style="transform: scale(1.5); margin-right: 10px; margin-left: 20px">
                            Diiris
                        </label>
                        <label for="nyeri-mencengkram">
                            <input type="radio" name="nyeri_kualitas" id="nyeri_kualitas-mencengkram"
                                value="Mencengkram"
                                style="transform: scale(1.5); margin-right: 10px; margin-left: 20px">
                            Mencengkram
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <label for="nyeri_lokasi" onclick="toggleInput('nyeri_lokasi')">Lokasi</label>
                    <input type="text" name="nyeri_lokasi" id="nyeri_lokasi" class="form-control mt-2 mb-2 ">
                </div>
                <div class="col-6">
                    <label for="nyeri_skala" onclick="toggleInput('nyeri_skala')">Skala</label>
                    <input type="text" name="nyeri_skala" id="nyeri_skala" class="form-control mt-2 mb-2 ">
                    <p style="font-size: 13px; color: red">(*Berdasarkan Skala Nyeri)</p>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <img src="<?php echo e(asset('assets/images/analog-scale.png')); ?>" alt="" height="auto" width="55%"
                style="margin-left: 30px">
            <div class="row mb-2">
                <div class="col">
                    <input type="radio" name="nyeri_analog" id="nyeri_analog-0" value="0"
                        style="transform: scale(1.5); margin-right: 8px; margin-left: 40px">0
                    <input type="radio" name="nyeri_analog" id="nyeri_analog-2" value="2"
                        style="transform: scale(1.5); margin-right: 8px; margin-left: 71px">2
                    <input type="radio" name="nyeri_analog" id="nyeri_analog-4" value="2"
                        style="transform: scale(1.5); margin-right: 8px; margin-left: 72px">4
                    <input type="radio" name="nyeri_analog" id="nyeri_analog-6" value="4"
                        style="transform: scale(1.5); margin-right: 8px; margin-left: 72px">6
                    <input type="radio" name="nyeri_analog" id="nyeri_analog-8" value="8"
                        style="transform: scale(1.5); margin-right: 8px; margin-left: 72px">8
                    <input type="radio" name="nyeri_analog" id="nyeri_analog-10" value="10"
                        style="transform: scale(1.5); margin-right: 8px; margin-left: 72px">10
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="nyeri_waktu" onclick="toggleInput('nyeri_waktu')">Waktu</label>
                <div class="col mt-3 margin-left: 35px">
                    <input type="radio" name="nyeri_waktu" id="nyeri_waktu-intermetien" value="Intermetien"
                        style="transform: scale(1.5); margin-right: 10px">Intermetien
                    <input type="radio" name="nyeri_waktu" id="nyeri_waktu-hilang_timbul" value="Hilang-timbul"
                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">Hilang
                    Timbul
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="asesmen-resiko-jatuh">
        <h5 class="text-center fw-bold" onclick="toggleStep(this)">Asesmen Resiko Jatuh</h5>
        <div class="form-group mt-3">
            <label for="jatuh_sempoyong" onclick="toggleInput('jatuh_sempoyong')">Perhatikan cara
                berjalan pasien
                saat
                akan duduk dikursi apakah pasien tampak tidak seimbang / sempoyongan /
                libung
            </label>
            <div class="col text-center mb-2 mt-2">
                <input type="radio" name="jatuh_sempoyong" id="jatuh_sempoyong-ya" value="Ya"
                    style="transform: scale(1.5); margin-right: 10px">
                Ya
                <input type="radio" name="jatuh_sempoyong" id="jatuh_sempoyong-tidak" value="Tidak"
                    style="transform: scale(1.5); margin-right: 10px; margin-left: 30px" checked>
                Tidak
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="jatuh_pegangan" onclick="toggleInput('jatuh_pegangan')">Apakah
                pasien memegang pinggiran kursi / meja / benda lain sebagai penopang saat
                akan
                duduk</label>
            <div class="col text-center mb-2 mt-2">
                <input type="radio" name="jatuh_pegangan" id="jatuh_pegangan-ya" value="Ya"
                    style="transform: scale(1.5); margin-right: 10px">
                Ya
                <input type="radio" name="jatuh_pegangan" id="jatuh_pegangan-tidak" value="Tidak"
                    style="transform: scale(1.5); margin-right: 10px; margin-left: 30px" checked>
                Tidak
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="jatuh_hasil_kajian" onclick="toggleInput('jatuh_hasil_kajian')">Hasil
                Kajian</label>
            <div class="col text-center mb-2 mt-2">
                <input type="radio" name="jatuh_hasil_kajian" id="jatuh_hasil_kajian-tidak_beresiko"
                    value="tidak-beresiko" style="transform: scale(1.5); margin-right: 10px"> Tidak
                Beresiko
                <input type="radio" name="jatuh_hasil_kajian" id="jatuh_hasil_kajian-resiko_rendah"
                    value="resiko-rendah" style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                Resiko Rendah
                <input type="radio" name="jatuh_hasil_kajian" id="jatuh_hasil_kajian-resiko_tinggi"
                    value="resiko-tinggi" style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                Resiko Tinggi
            </div>
        </div>
    </div>
    <hr>

    <div class="masalah-keperawatan">
        <h5 class="text-center fw-bold" onclick="toggleStep(this)">
            Analisa Masalah Keperawatan / Kebidanan
        </h5>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ak_analisis_masalah_keperawatan">Analisa Masalah Keperawatan</label>
                <select wire:model="selectedAnalisaMasalah" name="ak_analisis_masalah_keperawatan"
                    id="ak_analisis_masalah_keperawatan<?php echo e($booking->id); ?>" class="form-control mt-2 mb-2">
                    <option value="">Pilih Masalah</option>
                    <option value="Bersihkan Jalan Nafas tidak Efektif">Bersihkan Jalan Nafas tidak Efektif</option>
                    <option value="Perubahan Nutrisi Kurang / Lebih Cairan">Perubahan Nutrisi Kurang / Lebih Cairan
                    </option>
                    <option value="Keseimbangan Cairan dan Elektrolit">Keseimbangan Cairan dan Elektrolit</option>
                    <option value="Gangguan Komunikasi Verbal">Gangguan Komunikasi Verbal</option>
                    <option value="Pola Nafas tidak Efektif">Pola Nafas tidak Efektif</option>
                    <option value="Resiko Infeksi / Sepsis">Resiko Infeksi / Sepsis</option>
                    <option value="Gangguan Integritas Kulit / Jaringan">Gangguan Integritas Kulit / Jaringan</option>
                    <option value="Gangguan Pola Tidur">Gangguan Pola Tidur</option>
                    <option value="Nyeri">Nyeri</option>
                    <option value="Intoleransi Aktivitas">Intoleransi Aktivitas</option>
                    <option value="Konstipasi / Diare">Konstipasi / Diare</option>
                    <option value="Cemas">Cemas</option>
                    <option value="Hypertermi / Hipotermi">Hypertermi / Hipotermi</option>
                    <option value="Lain - Lain">Lain - Lain</option>
                </select>

            </div>
        </div>
    </div>

</div>
<?php /**PATH C:\laragon\www\Klinik\resources\views/perawat/modalPerawat/tabs/tab-kajian-awal.blade.php ENDPATH**/ ?>