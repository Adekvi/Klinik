<!-- Modal Riwayat Odontogram -->
<?php if($fisik && $fisik->id): ?>
    <div class="modal fade" id="riwayatGigi<?php echo e($fisik->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Riwayat Pasien
                        Odontogram</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" style="text-align: center; overflow-y: auto; white-space: nowrap">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>AKSI</th>
                                                <th>NO</th>
                                                <th>TANGGAL DAN WAKTU PERIKSA</th>
                                                <th>NO. RM</th>
                                                <th>NAMA PASIEN</th>
                                                <th>UMUR</th>
                                                <th>ALAMAT</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align: center;">
                                            <?php $no = 1; ?>
                                            <?php if(!$fisik): ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Belum ada riwayat odontogram
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info toggle-detail"
                                                            data-target="#rincian-detail" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-offset="0,4"
                                                            data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Lihat</span>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                    <td><?php echo e($no++); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($fisik->created_at)->translatedFormat('l, d-m-Y / H:i')); ?>

                                                    </td>
                                                    <td><?php echo e($antrianDokter->booking->pasien->no_rm); ?></td>
                                                    <td><?php echo e($antrianDokter->booking->pasien->nama_pasien); ?></td>
                                                    <td>
                                                        <?php echo e(\Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir)->age); ?>

                                                        Tahun
                                                    </td>
                                                    <td><?php echo e($antrianDokter->booking->pasien->alamat_asal); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rincian-detail" id="rincian-detail">
                        <div class="row">
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
                                                        <?php echo e($fisik->tgl_kunjungan); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Jam</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="font-weight: bold; padding: 4px;">
                                                        <?php echo e($fisik->created_at->translatedFormat('H:i')); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Alergi</th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($fisik->alegi_gigi); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left;">Skala Nyeri
                                                    </th>
                                                    <td style="padding: 4px; width: 10px;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($fisik->skala_nyeriGigi); ?>

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
                                                                    value="NRS" disabled
                                                                    <?php echo e($fisik && $fisik->metode === 'NRS' ? 'checked' : ''); ?>

                                                                    style="transform: scale(1.5); margin-right: 5px">
                                                                NRS
                                                            </label>
                                                            <label for="wongbaker_faces" class="mx-3">
                                                                <input type="radio" name="metode"
                                                                    id="wongbaker_faces" value="Wong Baker FACES"
                                                                    disabled
                                                                    <?php echo e($fisik && $fisik->metode === 'Wong Baker FACES' ? 'checked' : ''); ?>

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
                                                <input type="checkbox" disabled name="wongbaker[]" id="wongbaker-0"
                                                    value="0"
                                                    <?php echo e($fisik && $fisik->wongbaker === '0' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px;">0
                                                <input type="checkbox" disabled name="wongbaker" id="wongbaker-2"
                                                    value="2"
                                                    <?php echo e($fisik && $fisik->wongbaker === '2' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px; margin-left: 40px">2
                                                <input type="checkbox" disabled name="wongbaker" id="wongbaker-4"
                                                    value="4"
                                                    <?php echo e($fisik && $fisik->wongbaker === '4' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">4
                                                <input type="checkbox" disabled name="wongbaker" id="wongbaker-6"
                                                    value="6"
                                                    <?php echo e($fisik && $fisik->wongbaker === '6' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">6
                                                <input type="checkbox" disabled name="wongbaker" id="wongbaker-8"
                                                    value="8"
                                                    <?php echo e($fisik && $fisik->wongbaker === '8' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">8
                                                <input type="checkbox" disabled name="wongbaker" id="wongbaker-10"
                                                    value="10"
                                                    <?php echo e($fisik && $fisik->wongbaker === '10' ? 'checked' : ''); ?>

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
                                    <div class="col-md-8">
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
                                                    <th style="padding: 4px; text-align: left; white-space: nowrap;">
                                                        1.
                                                        Keluhan Utama</th>
                                                    <td style="padding: 4px; text-align: center;">:</td>
                                                    <td style="padding: 4px; font-weight: bold;">
                                                        <?php echo e($antrianDokter->rm->a_keluhan_utama); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left; white-space: nowrap;">
                                                        2.
                                                        Riwayat Penyakit Sekarang</th>
                                                    <td style="padding: 4px; text-align: center;">:</td>
                                                    <td style="padding: 4px; font-weight: bold;">
                                                        <?php echo e($antrianDokter->rm->a_riwayat_penyakit_skrg); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left; white-space: nowrap;">
                                                        3.
                                                        Riwayat Penyakit Terdahulu</th>
                                                    <td style="padding: 4px; text-align: center;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->rm->a_riwayat_penyakit_terdahulu); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left; white-space: nowrap;">
                                                        4.
                                                        Riwayat Penyakit Keluarga</th>
                                                    <td style="padding: 4px; text-align: center;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($antrianDokter->rm->a_riwayat_penyakit_keluarga); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px; text-align: left; white-space: nowrap;">
                                                        5.
                                                        Riwayat Penggunaan Obat</th>
                                                    <td style="padding: 4px; text-align: center;">:</td>
                                                    <td style="padding: 4px;">
                                                        <?php echo e($fisik->a_riwayat_penggunaan_obat); ?>

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
                                            <textarea name="periksa_fisik" readonly id="periksa_fisik" class="form-control mt-2 mb-2" cols="4"
                                                rows="5"><?php echo e($fisik->periksa_fisik); ?></textarea>
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
                                            <input type="text" value="<?php echo e($fisik->no_gigi); ?>"
                                                class="form-control mt-2 mb-2" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="keadaan_gigi">Keadaan Gigi</label>
                                            <input type="text" class="form-control mt-2 mb-2 select2"
                                                value="<?php echo e($fisik->keadaan_gigi); ?>" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="keterangan_gigi">Keterangan Gigi</label>
                                            <textarea class="form-control mt-2 mb-2" readonly name="keterangan_gigi" cols="10" rows="5"><?php echo e($fisik->keterangan_gigi); ?></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        
                                        <div class="form-group d-flex align-items-center mb-3 mt-4" style="gap: 8px">
                                            <label style="min-width: 200px; margin-bottom: 0;">Occlusi</label>
                                            <span style="width: 30px">:</span>
                                            <div id="occlusi_gigi">
                                                <label for="jawaban-normal" class="mr-3">
                                                    <input type="radio" disabled name="occlusi_gigi"
                                                        id="jawaban-normal" value="Normal-Bite"
                                                        <?php echo e($fisik && $fisik->occlusi_gigi === 'Normal-Bite' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px;"> Normal
                                                    Bite
                                                </label>
                                                <label for="jawaban-crossbite" class="mx-3">
                                                    <input type="radio" disabled name="occlusi_gigi"
                                                        id="jawaban-crossbite" value="Cross-Bite"
                                                        <?php echo e($fisik && $fisik->occlusi_gigi === 'Cross-Bite' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px;"> Cross
                                                    Bite
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" disabled name="occlusi_gigi"
                                                        id="jawaban-steepbite" value="Steep-Bite"
                                                        <?php echo e($fisik && $fisik->occlusi_gigi === 'Steep-Bite' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px;"> Steep
                                                    Bite
                                                </label>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group d-flex align-items-center mb-3 mt-4" style="gap: 8px">
                                            <label style="min-width: 200px; margin-bottom: 0;">Torus
                                                Palatines</label>
                                            <span style="width: 30px">:</span>
                                            <div id="torus_palatines">
                                                <label for="jawaban-tidak-ada" class="mr-3">
                                                    <input type="radio" disabled name="torus_palatines"
                                                        id="jawaban-tidak-ada" value="Tidak Ada"
                                                        <?php echo e($fisik && $fisik->torus_palatines === 'Tidak Ada' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px;"> Tidak
                                                    Ada
                                                </label>
                                                <label for="jawaban-kecil" class="mx-3">
                                                    <input type="radio" disabled name="torus_palatines"
                                                        id="jawaban-kecil" value="Kecil"
                                                        <?php echo e($fisik && $fisik->torus_palatines === 'Kecil' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 13px">
                                                    Kecil
                                                </label>
                                                <label for="jawaban-sedang" class="ml-3">
                                                    <input type="radio" disabled name="torus_palatines"
                                                        id="jawaban-sedang" value="Sedang"
                                                        <?php echo e($fisik && $fisik->torus_palatines === 'Sedang' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 37px">
                                                    Sedang
                                                </label>
                                                <label for="jawaban-besar" class="ml-3">
                                                    <input type="radio" disabled name="torus_palatines"
                                                        id="jawaban-besar" value="Besar"
                                                        <?php echo e($fisik && $fisik->torus_palatines === 'Besar' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 40px">
                                                    Besar
                                                </label>
                                                <label for="jawaban-multiple" class="ml-3">
                                                    <input type="radio" disabled name="torus_palatines"
                                                        id="jawaban-multiple" value="Multiple"
                                                        <?php echo e($fisik && $fisik->torus_palatines === 'Multiple' ? 'checked' : ''); ?>

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
                                                <label for="jawaban-tidak-ada" class="mr-3">
                                                    <input type="radio" disabled name="torus_mandibularis"
                                                        id="jawaban-tidak-ada" value="Tidak-ada"
                                                        <?php echo e($fisik && $fisik->torus_mandibularis === 'Tidak-ada' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px;"> Tidak
                                                    Ada
                                                </label>
                                                <label for="jawaban-sisi_kiri" class="mx-3">
                                                    <input type="radio" disabled name="torus_mandibularis"
                                                        id="jawaban-sisi_kiri" value="Sisi_kiri"
                                                        <?php echo e($fisik && $fisik->torus_mandibularis === 'Sisi_kiri' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 13px">
                                                    Sisi Kiri
                                                </label>
                                                <label for="jawaban-sisi_kanan" class="ml-3">
                                                    <input type="radio" disabled name="torus_mandibularis"
                                                        id="jawaban-sisi_kanan" value="Sisi_kanan"
                                                        <?php echo e($fisik && $fisik->torus_mandibularis === 'Sisi_kanan' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 19px">
                                                    Sisi Kanan
                                                </label>
                                                <label for="jawaban-kedua_sisi" class="ml-3">
                                                    <input type="radio" disabled name="torus_mandibularis"
                                                        id="jawaban-kedua_sisi" value="Kedua_sisi"
                                                        <?php echo e($fisik && $fisik->torus_mandibularis === 'Kedua_Sisi' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 21px">
                                                    Kedua Sisi
                                                </label>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group d-flex align-items-center mb-3 mt-4" style="gap: 8px">
                                            <label style="min-width: 200px; margin-bottom: 0;">Palatum</label>
                                            <span style="width: 30px">:</span>
                                            <div id="palatum">
                                                <label for="jawaban-dalam" class="mr-3">
                                                    <input type="radio" disabled name="palatum" id="jawaban-dalam"
                                                        value="dalam"
                                                        <?php echo e($fisik && $fisik->palatum === 'dalam' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px;"> Dalam
                                                </label>
                                                <label for="jawaban-sedang" class="mx-3">
                                                    <input type="radio" disabled name="palatum" id="jawaban-sedang"
                                                        value="sedang"
                                                        <?php echo e($fisik && $fisik->palatum === 'sedang' ? 'checked' : ''); ?>

                                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 38px">
                                                    Sedang
                                                </label>
                                                <label for="jawaban-rendah" class="ml-3">
                                                    <input type="radio" disabled name="palatum" id="jawaban-rendah"
                                                        value="rendah"
                                                        <?php echo e($fisik && $fisik->palatum === 'rendah' ? 'checked' : ''); ?>

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
                                                        <input type="radio" disabled name="diastema"
                                                            id="jawaban-tidak_ada" value="tidak-ada"
                                                            <?php echo e($fisik && $fisik->diastema === 'tidak-ada' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Tidak Ada
                                                    </label>
                                                    <label for="jawaban-ada" class="mx-3">
                                                        <input type="radio" disabled name="diastema"
                                                            id="jawaban-ada" value="ada"
                                                            <?php echo e($fisik && $fisik->diastema === 'ada' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;"> Ada
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="alasan-diastema"
                                                style="margin-top: 8px; min-width: 200px; margin-left: 26%">
                                                <span style="width: 30px"></span>
                                                <input type="text" id="diastema_alasan" name="diastema_alasan"
                                                    class="form-control" readonly placeholder="Penjelasan"
                                                    value="<?php echo e($fisik->diastema_alasan ?? ''); ?>">
                                                <p
                                                    style="font-size: 14px; margin-top: 5px; font-style: italic; color: red">
                                                    (*dijelaskan dimana dan berapa lebarnya)
                                                </p>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Gigi
                                                    Anomaly</label>
                                                <span style="width: 30px;">:</span>
                                                <div id="gigi_anomali">
                                                    <label for="anomali-tidak_ada" class="mr-3">
                                                        <input type="radio" disabled name="gigi_anomali"
                                                            id="anomali-tidak_ada" value="tidak-ada"
                                                            <?php echo e($fisik && $fisik->gigi_anomali === 'tidak-ada' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Tidak Ada
                                                    </label>
                                                    <label for="anomali-ada" class="mx-3">
                                                        <input type="radio" disabled name="gigi_anomali"
                                                            id="anomali-ada" value="ada"
                                                            <?php echo e($fisik && $fisik->gigi_anomali === 'ada' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;"> Ada
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="alasan-gigi_anomali"
                                                style="margin-top: 8px; min-width: 200px; margin-left: 26%">
                                                <span style="width: 30px"></span>
                                                <input type="text" readonly id="gigi_anomali_alasan"
                                                    name="gigi_anomali_alasan" class="form-control"
                                                    placeholder="Penjelasan"
                                                    value="<?php echo e($fisik->gigi_anomali_alasan ?? ''); ?>">
                                                <p
                                                    style="font-size: 14px; margin-top: 5px; font-style: italic; color: red">
                                                    (*dijelaskan gigi yang mana dan bentuknya)
                                                </p>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label for="lain-lain"
                                                    style="min-width: 200px; margin-bottom: 0;">Lain-lain</label>
                                                <span style="width: 30px;">:</span>
                                                <input type="text" class="form-control" readonly
                                                    name="gigi_lain_lain" id="gigi_lain-lain" placeholder="Lain-lain"
                                                    value="<?php echo e($fisik->gigi_lain_lain ?? ''); ?>">
                                            </div>
                                            <p
                                                style="font-size: 14px; font-style: italic; color: red; margin-top: 4px; margin-left: 26%;">
                                                (*hal-hal yang tidak tercakup diatas)
                                            </p>
                                        </div>

                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Jumlah Foto yang
                                                    diambil</label>
                                                <span style="width: 30px;">:</span>
                                                <div id="foto_ambil">
                                                    <label for="digital" class="mr-3">
                                                        <input type="checkbox" disabled name="foto_yg_diambil_digital"
                                                            id="digital" value="Digital"
                                                            <?php echo e($fisik && $fisik->foto_yg_diambil_digital === 'Digital' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Digital
                                                    </label>
                                                    <label for="intraoral" class="mx-3">
                                                        <input type="checkbox" disabled
                                                            name="foto_yg_diambil_intraoral" id="intraoral"
                                                            value="Intraoral"
                                                            <?php echo e($fisik && $fisik->foto_yg_diambil_intraoral === 'Intraoral' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Intraoral
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="foto_jumlah" style="margin-top: 8px; margin-left: 237px;">
                                                <span style="width: 30px;"></span>
                                                <input type="text" id="jumlah" name="foto_jumlah"
                                                    class="form-control mt-2 mb-2 w-25" readonly placeholder="Jumlah"
                                                    value="<?php echo e($fisik->foto_jumlah ?? ''); ?>">
                                            </div>
                                        </div>

                                        
                                        <div class="form-group mb-3 mt-4">
                                            <div class="d-flex align-items-center" style="gap: 8px">
                                                <label style="min-width: 200px; margin-bottom: 0;">Jumlah rontgen
                                                    photo yang diambil</label>
                                                <span style="width: 30px;">:</span>
                                                <div id="foto_rontgen_ambil">
                                                    <label for="Dental" class="mr-3">
                                                        <input type="checkbox" disabled
                                                            name="foto_rontgen_ambil_dental" id="Dental"
                                                            value="Dental"
                                                            <?php echo e($fisik && $fisik->foto_rontgen_ambil_dental === 'Dental' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Dental
                                                    </label>
                                                    <label for="PA" class="mx-3">
                                                        <input type="checkbox" disabled name="foto_rontgen_ambil_pa"
                                                            id="PA" value="PA"
                                                            <?php echo e($fisik && $fisik->foto_rontgen_ambil_pa === 'PA' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;"> PA
                                                    </label>
                                                    <label for="OPG" class="mx-3">
                                                        <input type="checkbox" disabled name="foto_rontgen_ambil_opg"
                                                            id="OPG" value="OPG"
                                                            <?php echo e($fisik && $fisik->foto_rontgen_ambil_opg === 'OPG' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;"> OPG
                                                    </label>
                                                    <label for="Ceph" class="mx-3">
                                                        <input type="checkbox" disabled name="foto_rontgen_ambil_ceph"
                                                            id="Ceph" value="Ceph"
                                                            <?php echo e($fisik && $fisik->foto_rontgen_ambil_ceph === 'Ceph' ? 'checked' : ''); ?>

                                                            style="transform: scale(1.5); margin-right: 10px;">
                                                        Ceph
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="foto_rontgen_jumlah"
                                                style="margin-top: 8px; margin-left: 237px;">
                                                <span style="width: 30px;"></span>
                                                <input type="text" id="jumlah" readonly
                                                    name="foto_rontgen_jumlah" class="form-control mt-2 mb-2 w-25"
                                                    placeholder="Jumlah"
                                                    value="<?php echo e($fisik->foto_rontgen_jumlah ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tindakan</label>
                                            <input type="date" class="form-control mt-2 mb-2" name="tindakan_gigi"
                                                id="tindakan_gigi" readonly value="<?php echo e($fisik->tindakan); ?>"
                                                placeholder="Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Prosedur Tindakan</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="prosedur_tindakan" id="prosedur_tindakan" readonly
                                                value="<?php echo e($fisik->prognosa_tindakan); ?>"
                                                placeholder="Prosedur Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Rencana</label>
                                            <input type="date" class="form-control mt-2 mb-2" name="tgl_rencana"
                                                id="tgl_rencana" readonly value="<?php echo e($fisik->tgl_rencana); ?>"
                                                placeholder="Prosedur Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Lama Tindakan</label>
                                            <input type="text" class="form-control mt-2 mb-2" name="lama_tindakan"
                                                id="lama_tindakan" readonly value="<?php echo e($fisik->lama_tindakan); ?>"
                                                placeholder="Lama Tindakan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Hasil</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="hasil_tindakan" id="hasil_tindakan" readonly
                                                value="<?php echo e($fisik->hasil_tindakan); ?>" placeholder="Hasil">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Indikasi</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="indikasi_tindakan" id="indikasi_tindakan" readonly
                                                value="<?php echo e($fisik->indikasi_tindakan); ?>" placeholder="Indikasi">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tujuan</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="tujuan_tindakan" id="tujuan_tindakan" readonly
                                                value="<?php echo e($fisik->tujuan_tindakan); ?>" placeholder="Tujuan">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Resiko</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="resiko_tindakan" id="resiko_tindakan" readonly
                                                value="<?php echo e($fisik->resiko_tindakan); ?>" placeholder="Resiko">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Komplikasi</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="komplikasi_tindakan" id="komplikasi_tindakan" readonly
                                                value="<?php echo e($fisik->komplikasi_tindakan); ?>" placeholder="Komplikasi">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Prognosa</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="prognosa_tindakan" id="prognosa_tindakan" readonly
                                                value="<?php echo e($fisik->prognosa_tindakan); ?>" placeholder="Prognosa">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Alternatif & Resiko</label>
                                            <input type="text" class="form-control mt-2 mb-2"
                                                name="alternatif_resiko" id="alternatif_resiko" readonly
                                                value="<?php echo e($fisik->alternatif_resiko); ?>"
                                                placeholder="Alternatif & Resiko">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Keterangan Tindakan</label>
                                            <textarea class="form-control mt-2 mb-2" readonly name="keterangan_tindakan" id="keterangan_tindakan" cols="10"
                                                rows="5"><?php echo e($fisik->keterangan_tindakan); ?></textarea>
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
                                                <input type="checkbox" disabled name="jenis_pelayanan_preventif"
                                                    id="jenis_pelayanan_preventif" value="Preventif"
                                                    <?php echo e($fisik && $fisik->jenis_pelayanan_preventif === 'Preventif' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px;"> Preventif
                                            </div>
                                            <div id="alasan-preventif" style="display: none; margin-top: 8px;">
                                                <span style="width: 30px"></span>
                                                <input type="text" readonly id="jenis_pelayanan_preventif_alasan"
                                                    name="jenis_pelayanan_preventif_alasan" class="form-control"
                                                    placeholder="........" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pelayanan_paliatif"></label>
                                            <div id="paliatif">
                                                <input type="checkbox" disabled name="jenis_pelayanan_paliatif"
                                                    id="jenis_pelayanan_paliatif" value="Paliatif"
                                                    <?php echo e($fisik && $fisik->jenis_pelayanan_paliatif === 'Paliatif' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px;"> Paliatif
                                            </div>
                                            <div id="alasan-paliatif" style="display: none; margin-top: 8px;">
                                                <span style="width: 30px"></span>
                                                <input type="text" readonly id="jenis_pelayanan_paliatif_alasan"
                                                    name="jenis_pelayanan_paliatif_alasan" class="form-control"
                                                    placeholder="........" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_pelayanan_kuratif"></label>
                                            <div id="kuratif">
                                                <input type="checkbox" disabled name="jenis_pelayanan_kuratif"
                                                    id="jenis_pelayanan_kuratif" value="Kuratif"
                                                    <?php echo e($fisik && $fisik->jenis_pelayanan_kuratif === 'Kuratif' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px;"> Kuratif
                                            </div>
                                            <div id="alasan-kuratif" style="display: none; margin-top: 8px;">
                                                <span style="width: 30px"></span>
                                                <input type="text" readonly id="jenis_pelayanan_kuratif_alasan"
                                                    name="jenis_pelayanan_kuratif_alasan" class="form-control"
                                                    placeholder="........" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pelayanan_rehabilitatif"></label>
                                            <div id="rahabilitatif">
                                                <input type="checkbox" disabled name="jenis_pelayanan_rehabilitatif"
                                                    id="jenis_pelayanan_rehabilitatif" value="Rehabilitatif"
                                                    <?php echo e($fisik && $fisik->jenis_pelayanan_rehabilitatif === 'Rehabilitatif' ? 'checked' : ''); ?>

                                                    style="transform: scale(1.5); margin-right: 10px;">
                                                Rehabilitatif
                                            </div>
                                            <div id="alasan-rehabilitatif" style="display: none; margin-top: 8px;">
                                                <span style="width: 30px"></span>
                                                <input type="text" readonly
                                                    id="jenis_pelayanan_rehabilitatif_alasan"
                                                    name="jenis_pelayanan_rehabilitatif_alasan" class="form-control"
                                                    placeholder="........" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Modal generik jika tidak ada data -->
<div id="riwayat" class="modal fade" tabindex="-1" aria-labelledby="riwayatLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatLabel">Riwayat Odontogram</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Belum ada data pemeriksaan odontogram untuk pasien ini.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('style'); ?>
    <style>
        /* Styling rincian */
        .card-body {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        /* Kontrol visibilitas dan animasi */
        .rincian-detail {
            margin-top: 1rem;
            overflow: hidden;
            height: 0;
            opacity: 0;
            transition: height 0.3s ease, opacity 0.3s ease;
            display: block;
            /* Pastikan elemen tetap ada di DOM */
        }

        .rincian-detail.active {
            height: auto;
            /* Biarkan konten menentukan tinggi */
            opacity: 1;
            padding: 1rem;
            /* Tambahkan padding untuk konten */
        }

        /* Ikon eye pada tombol */
        .btn-info .fas.fa-eye {
            color: #fff;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event click pada tombol toggle
            $('.toggle-detail').on('click', function() {
                var targetId = $(this).data('target'); // Ambil ID target dari data-target
                var $target = $(targetId); // Elemen target

                // Toggle kelas active
                $target.toggleClass('active');

                // Perbarui aria-expanded untuk aksesibilitas
                var isExpanded = $target.hasClass('active');
                $(this).attr('aria-expanded', isExpanded);

                // Atur tinggi secara dinamis untuk animasi
                if (isExpanded) {
                    var height = $target.find('.card-body').outerHeight();
                    $target.css('height', height + 'px');
                } else {
                    $target.css('height', '0');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\Klinik\resources\views/dokter/gigi/riwayat.blade.php ENDPATH**/ ?>