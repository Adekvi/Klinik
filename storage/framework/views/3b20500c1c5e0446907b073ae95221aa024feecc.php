<!-- modal pemeriksaan -->
<div class="modal fade" id="gigi<?php echo e($antrianDokter->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalFisik" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Odontogram
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(url('dokter/tambah/' . $antrianDokter->id)); ?>" method="post"
                enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="dokter_id" value="<?php echo e($antrianDokter->dokter_id); ?>">
                    <input type="hidden" name="pasien_id" value="<?php echo e($antrianDokter->booking->pasien_id); ?>">

                    <div class="row">
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
                                                
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">No RM</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="font-weight: bold; padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->no_rm); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Nama Pasien</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->nama_pasien); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">TTL</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e(\Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir)->translatedFormat('d F Y')); ?>

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
                                                        <?php echo e($antrianDokter->booking->pasien->jekel == 'L' ? 'Laki-laki' : ($antrianDokter->booking->pasien->jekel == 'P' ? 'Perempuan' : '')); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Alamat
                                                    </th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->domisili); ?></td>
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
                                                        <?php echo e($antrianDokter->booking->pasien->nama_kk); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">No. Nik</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->nik); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Jenis Pasien</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->jenis_pasien); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">No. Bpjs</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->bpjs ?? '-'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Pekerjaan</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->pekerjaan); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">No. Hp
                                                    </th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->booking->pasien->noHP); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>

                                
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
                                                        <?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Jam</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="font-weight: bold; padding: 4px;">
                                                        <?php echo e(\Carbon\Carbon::now()->translatedFormat('H:i:s')); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Alergi</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <input type="text" name="alergi_gigi" id="alergi_gigi"
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
                                                    <td style="padding: 4px; text-align: left; white-space: nowrap">
                                                        Dengan menggunakan
                                                        metode
                                                    </td>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <div id="metode" class="d-flex flex-wrap"
                                                            style="white-space: nowrap">
                                                            <label for="nrs" class="mr-4">
                                                                <input type="radio" name="metode" id="nrs"
                                                                    value="NRS"
                                                                    style="transform: scale(1.5); margin-right: 5px">
                                                                NRS
                                                            </label>
                                                            <label for="wongbaker_faces" class="mx-3">
                                                                <input type="radio" name="metode"
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
                                            <img src="<?php echo e(asset('assets/images/analog-gigi.png')); ?>" alt=""
                                                height="auto" width="70%">
                                        </div>
                                        <div class="row text-center" style="font-size: 18px">
                                            <div class="col">
                                                <input type="checkbox" name="wongbaker[]" id="wongbaker-0"
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
                                                            value="<?php echo e($antrianDokter->rm->a_keluhan_utama); ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">
                                                        2. Riwayat Penyakit Sekarang</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="font-weight: bold; padding: 4px;">
                                                        <input type="text" name="a_riwayat_penyakit_skrg"
                                                            id="a_riwayat_penyakit_skrg" class="form-control"
                                                            value="<?php echo e($antrianDokter->rm->a_riwayat_penyakit_skrg); ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">
                                                        3. Riwayat Penyakit Terdahulu</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <input type="text" name="a_riwayat_penyakit_terdahulu"
                                                            id="a_riwayat_penyakit_terdahulu" class="form-control"
                                                            value="<?php echo e($antrianDokter->rm->a_riwayat_penyakit_terdahulu); ?>">
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
                                                            value="<?php echo e($antrianDokter->rm->a_riwayat_penyakit_keluarga); ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">5. Riwayat Pengggunaan
                                                        Obat
                                                    </th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <input type="text" name="a_riwayat_penggunaan_obat"
                                                            id="a_riwayat_penggunaan_obat" class="form-control"
                                                            placeholder="Riwaat Penggunaan Obat">
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
                                        <img id="displayedImage" src="<?php echo e(asset('assets/images/gigi.jpeg')); ?>"
                                            style="max-width: 70%; height: auto; border-radius: 10px" alt="Kerangka">
                                    </div>
                                    <hr>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group" id="tambahGigi-container">
                                            <label for="no_gigi">Nomor Gigi</label>
                                            <select name="no_gigi[]" id="no_gigi"
                                                class="form-control mt-2 mb-2 select2" multiple>
                                                <option value="">--Pilih Gigi--</option>
                                                <?php for($i = 1; $i <= 85; $i++): ?>
                                                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
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
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="keterangan_gigi">Keterangan Gigi</label>
                                            <textarea class="form-control mt-2 mb-2" name="keterangan_gigi" cols="10" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        
                                        <div class="form-group d-flex align-items-center mb-3 mt-4" style="gap: 8px">
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
                                                    <input type="radio" name="occlusi_gigi" id="jawaban-crossbite"
                                                        value="Cross-bite"
                                                        style="transform: scale(1.5); margin-right: 10px;">
                                                    Cross
                                                    Bite
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="occlusi_gigi" id="jawaban-steepbite"
                                                        value="Steep-bite"
                                                        style="transform: scale(1.5); margin-right: 10px;">
                                                    Steep
                                                    Bite
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group d-flex align-items-center mb-3 mt-4" style="gap: 8px">
                                            <label style="min-width: 200px; margin-bottom: 0;">Torus Palatines</label>
                                            <span style="width: 30px">:</span>
                                            <div id="torus_palatines">
                                                <label for="jawaban-normal" class="mr-3">
                                                    <input type="radio" name="torus_palatines"
                                                        id="jawaban-tidak-ada" value="Tidak ada" checked
                                                        style="transform: scale(1.5); margin-right: 10px;">
                                                    Tidak Ada
                                                </label>
                                                <label for="jawaban-crossbite" class="mx-3">
                                                    <input type="radio" name="torus_palatines" id="jawaban-kecil"
                                                        value="Kecil"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 13px">
                                                    Kecil
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="torus_palatines" id="jawaban-sedang"
                                                        value="Sedang"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 37px">
                                                    Sedang
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="torus_palatines" id="jawaban-besar"
                                                        value="Besar"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 40px">
                                                    Besar
                                                </label>
                                                <label for="jawaban-steepbite" style="margin-left: 12px">
                                                    <input type="radio" name="torus_palatines"
                                                        id="jawaban-multiple" value="Multiple"
                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 40px">
                                                    Multiple
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group d-flex align-items-center mb-3 mt-4" style="gap: 8px">
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
                                        
                                        <div class="form-group d-flex align-items-center mb-3 mt-4" style="gap: 8px">
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
                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Diastema</label>
                                                <span style="width: 30px;">:</span>
                                                <div id="diastema">
                                                    <label for="jawaban-tidak_ada" class="mr-3">
                                                        <input type="radio" name="diastema" id="jawaban-tidak_ada"
                                                            value="tidak-ada" checked
                                                            style="transform: scale(1.5); margin-right: 10px;"> Tidak
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
                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Gigi Anomaly</label>
                                                <span style="width: 30px;">:</span>
                                                <div id="gigi_anomali">
                                                    <label for="anomali-tidak_ada" class="mr-3">
                                                        <input type="radio" name="gigi_anomali"
                                                            id="anomali-tidak_ada" value="tidak-ada" checked
                                                            style="transform: scale(1.5); margin-right: 10px;"> Tidak
                                                        Ada
                                                    </label>
                                                    <label for="anomali-ada" class="mx-3">
                                                        <input type="radio" name="gigi_anomali" id="anomali-ada"
                                                            value="ada"
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
                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Jumlah Foto yang
                                                    diambil</label>
                                                <span style="width: 30px;">:</span>
                                                <div id="foto_ambil">
                                                    <label for="digital" class="mr-3">
                                                        <input type="checkbox" name="foto_yg_diambil_digital"
                                                            id="digital" value="Digital" checked
                                                            style="transform: scale(1.5); margin-right: 10px;"> Digital
                                                    </label>
                                                    <label for="intraoral" class="mx-3">
                                                        <input type="checkbox" name="foto_yg_diambil_intraoral"
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
                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Jumlah rontgen photo
                                                    <br>
                                                    yang diambil</label>
                                                <span style="width: 30px;">:</span>
                                                <div id="foto_rontgen_ambil">
                                                    <label for="Dental" class="mr-3">
                                                        <input type="checkbox" name="foto_rontgen_ambil_dental"
                                                            id="Dental" value="Dental" checked
                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Dental
                                                    </label>
                                                    <label for="PA" class="mx-3">
                                                        <input type="checkbox" name="foto_rontgen_ambil_pa"
                                                            id="PA" value="PA"
                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        PA
                                                    </label>
                                                    <label for="OPG" class="mx-3">
                                                        <input type="checkbox" name="foto_rontgen_ambil_opg"
                                                            id="OPG" value="OPG"
                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        OPG
                                                    </label>
                                                    <label for="Ceph" class="mx-3">
                                                        <input type="checkbox" name="foto_rontgen_ambil_ceph"
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
                                            
                                        </div>
                                    </div>
                                    <hr>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tindakan</label>
                                            <input type="date" class="form-control mt-2 mb-2" name="tindakan_gigi"
                                                id="tindakan_gigi" placeholder="Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Prosedur Tindakan</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="prosedur_tindakan" id="prosedur_tindakan"
                                                placeholder="Prosedur Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Rencana</label>
                                            <input type="date" class="form-control mt-2 mb-2" name="tgl_rencana"
                                                id="tgl_rencana" placeholder="Prosedur Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Lama Tindakan</label>
                                            <input type="text" class="form-control mt-2 mb-2" name="lama_tindakan"
                                                id="lama_tindakan" placeholder="Lama Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Hasil</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="hasil_tindakan" id="hasil_tindakan" placeholder="Hasil">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Indikasi</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="indikasi_tindakan" id="indikasi_tindakan"
                                                placeholder="Indikasi">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tujuan</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="tujuan_tindakan" id="tujuan_tindakan" placeholder="Tujuan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Resiko</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="resiko_tindakan" id="resiko_tindakan" placeholder="Resiko">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Komplikasi</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="komplikasi_tindakan" id="komplikasi_tindakan"
                                                placeholder="Komplikasi">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Prognosa</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="prognosa_tindakan" id="prognosa_tindakan"
                                                placeholder="Prognosa">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Alternatif & Resiko</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="alternatif_resiko" id="alternatif_resiko"
                                                placeholder="Alternatif & Resiko">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Keterangan Tindakan</label>
                                            <textarea class="form-control mt-2 mb-2" name="keterangan_tindakan" id="keterangan_tindakan" cols="10"
                                                rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="card-title">
                                    <h6 class="text-muted">
                                        <strong>
                                            <li>Penetapan Jenis Pelayanan</li>
                                        </strong>
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_pelayanan_preventif"></label>
                                            <div id="preventif">
                                                <input type="checkbox" name="jenis_pelayanan_preventif"
                                                    id="jenis_pelayanan_preventif" value="Preventif"
                                                    style="transform: scale(1.5); margin-right: 10px;"> Preventif
                                            </div>
                                            <div id="alasan-preventif" style="display: none; margin-top: 8px;">
                                                <span
                                                    style="width:
                                                30px"></span>
                                                <input type="text" id="jenis_pelayanan_preventif_alasan"
                                                    name="jenis_pelayanan_preventif_alasan" class="form-control"
                                                    placeholder="........">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pelayanan_paliatif"></label>
                                            <div id="paliatif">
                                                <input type="checkbox" name="jenis_pelayanan_paliatif"
                                                    id="jenis_pelayanan_paliatif" value="Paliatif"
                                                    style="transform: scale(1.5); margin-right: 10px;"> Paliatif
                                            </div>
                                            <div id="alasan-paliatif" style="display: none; margin-top: 8px;">
                                                <span
                                                    style="width:
                                                30px"></span>
                                                <input type="text" id="jenis_pelayanan_paliatif_alasan"
                                                    name="jenis_pelayanan_paliatif_alasan" class="form-control"
                                                    placeholder="........">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_pelayanan_kuratif"></label>
                                            <div id="kuratif">
                                                <input type="checkbox" name="jenis_pelayanan_kuratif"
                                                    id="jenis_pelayanan_kuratif" value="Kuratif"
                                                    style="transform: scale(1.5); margin-right: 10px;"> Kuratif
                                            </div>
                                            <div id="alasan-kuratif" style="display: none; margin-top: 8px;">
                                                <span
                                                    style="width:
                                                30px"></span>
                                                <input type="text" id="jenis_pelayanan_kuratif_alasan"
                                                    name="jenis_pelayanan_kuratif_alasan" class="form-control"
                                                    placeholder="........">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pelayanan_rehabilitatif"></label>
                                            <div id="rahabilitatif">
                                                <input type="checkbox" name="jenis_pelayanan_rehabilitatif"
                                                    id="jenis_pelayanan_rehabilitatif" value="Rehabilitatif"
                                                    style="transform: scale(1.5); margin-right: 10px;"> Rehabilitatif
                                            </div>
                                            <div id="alasan-rehabilitatif" style="display: none; margin-top: 8px;">
                                                <span
                                                    style="width:
                                                30px"></span>
                                                <input type="text" id="jenis_pelayanan_rehabilitatif_alasan"
                                                    name="jenis_pelayanan_rehabilitatif_alasan" class="form-control"
                                                    placeholder="........">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('style'); ?>
    <!-- Select2 core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 Bootstrap 5 theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <style>
        /* Menyesuaikan container Select2 */
        .select2-container {
            width: 100% !important;
            margin-top: 7px;
        }

        /* Menyesuaikan selection area untuk multiple */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            min-height: calc(2.25rem + 2px) !important;
            padding: 0.375rem 0.75rem !important;
        }

        /* Menyesuaikan pilihan (tag) di dalam select multiple */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 0.375rem !important;
            padding: 0.25rem 0.5rem !important;
            margin: 2px !important;
        }

        /* Menyesuaikan tombol hapus pada pilihan */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff !important;
            margin-right: 5px !important;
        }

        /* Menyesuaikan dropdown saat terbuka */
        .select2-container--default .select2-dropdown {
            border: 1px solid #0d6efd !important;
            border-radius: 0.375rem !important;
            margin-top: 0 !important;
        }

        /* Menyesuaikan placeholder */
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: #6c757d !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <!-- Di bagian bawah sebelum </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Diastema elements
        const tidakAdaDiastemacheckbox = document.getElementById('jawaban-tidak_ada');
        const adaDiastemacheckbox = document.getElementById('jawaban-ada');
        const alasanDiastema = document.getElementById('alasan-diastema');

        // Gigi Anomali elements
        const tidakAdaAnomalicheckbox = document.getElementById('anomali-tidak_ada');
        const adaAnomalicheckbox = document.getElementById('anomali-ada');
        const alasanGigiAnomali = document.getElementById('alasan-gigi_anomali');

        // Function to toggle alasan for diastema
        function toggleAlasanDiastema() {
            if (adaDiastemacheckbox.checked) {
                alasanDiastema.style.display = 'block';
            } else {
                alasanDiastema.style.display = 'none';
            }
        }

        // Function to toggle alasan for gigi_anomali
        function toggleAlasanGigiAnomali() {
            if (adaAnomalicheckbox.checked) {
                alasanGigiAnomali.style.display = 'block';
            } else {
                alasanGigiAnomali.style.display = 'none';
            }
        }

        // Event listeners for diastema checkbox buttons
        tidakAdaDiastemacheckbox.addEventListener('change', toggleAlasanDiastema);
        adaDiastemacheckbox.addEventListener('change', toggleAlasanDiastema);

        // Event listeners for gigi_anomali checkbox buttons
        tidakAdaAnomalicheckbox.addEventListener('change', toggleAlasanGigiAnomali);
        adaAnomalicheckbox.addEventListener('change', toggleAlasanGigiAnomali);

        // Initialize on page load
        toggleAlasanDiastema();
        toggleAlasanGigiAnomali();

        // KEADAAN GIGI
        $(document).ready(function() {
            // NO GIGI
            $('#no_gigi').select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                placeholder: '-- Pilih Keadaan --',
                width: '100%',
                allowClear: true,
                dropdownParent: $('#no_gigi')
                    .parent() // Mengatur dropdown parent agar sesuai dengan form-group
            });

            // Menangani fokus pada dropdown saat terbuka
            $('#no_gigi').on('select2:open', function() {
                $('.select2-container--open .select2-dropdown').css({
                    'border': '1px solid #0d6efd',
                    'border-radius': '0.375rem'
                });
            });

            // KEADAAN GIGI
            $('#keadaan_gigi').select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                placeholder: '-- Pilih Keadaan --',
                width: '100%',
                allowClear: true,
                dropdownParent: $('#keadaan_gigi')
                    .parent() // Mengatur dropdown parent agar sesuai dengan form-group
            });

            // Menangani fokus pada dropdown saat terbuka
            $('#keadaan_gigi').on('select2:open', function() {
                $('.select2-container--open .select2-dropdown').css({
                    'border': '1px solid #0d6efd',
                    'border-radius': '0.375rem'
                });
            });
        });

        // PELAYANAN
        // Ambil semua checkbox dan kolom alasan
        const preventifCheckbox = document.getElementById('jenis_pelayanan_preventif');
        const alasanPreventif = document.getElementById('alasan-preventif');

        const paliatifCheckbox = document.getElementById('jenis_pelayanan_paliatif');
        const alasanPaliatif = document.getElementById('alasan-paliatif');

        const kuratifCheckbox = document.getElementById('jenis_pelayanan_kuratif');
        const alasanKuratif = document.getElementById('alasan-kuratif');

        const rehabilitatifCheckbox = document.getElementById('jenis_pelayanan_rehabilitatif');
        const alasanRehabilitatif = document.getElementById('alasan-rehabilitatif');

        // Daftar semua checkbox dan kolom alasan untuk mempermudah pengelolaan
        const checkboxes = [{
                checkbox: preventifCheckbox,
                alasan: alasanPreventif
            },
            {
                checkbox: paliatifCheckbox,
                alasan: alasanPaliatif
            },
            {
                checkbox: kuratifCheckbox,
                alasan: alasanKuratif
            },
            {
                checkbox: rehabilitatifCheckbox,
                alasan: alasanRehabilitatif
            }
        ];

        // Fungsi untuk menangani perubahan pada checkbox
        function handleCheckboxChange(selectedCheckbox, selectedAlasan) {
            // Loop melalui semua checkbox
            checkboxes.forEach(item => {
                if (item.checkbox === selectedCheckbox) {
                    // Tampilkan atau sembunyikan kolom alasan berdasarkan status checkbox
                    item.alasan.style.display = selectedCheckbox.checked ? 'block' : 'none';
                } else {
                    // Uncheck checkbox lain dan sembunyikan kolom alasan mereka
                    item.checkbox.checked = false;
                    item.alasan.style.display = 'none';
                }
            });
        }

        // Tambahkan event listener ke setiap checkbox
        checkboxes.forEach(item => {
            item.checkbox.addEventListener('change', () => {
                handleCheckboxChange(item.checkbox, item.alasan);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/dokter/gigi/gigi.blade.php ENDPATH**/ ?>