<?php if($fisik && $fisik->id): ?>
    <div class="modal fade" id="edittubuh<?php echo e($fisik->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="edittubuh" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Edit Anatomi
                        Pasien
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('dokter/edit-fisik/' . $fisik->id)); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="dokter_id" value="<?php echo e($antrianDokter->dokter_id); ?>">
                    <input type="hidden" name="pasien_id" value="<?php echo e($antrianDokter->booking->pasien_id); ?>">
                    <div class="modal-body">
                        <div class="row" style="width: 100%">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="text-muted">
                                            <li><strong>Identitas Pasien</strong></li>
                                        </h5>
                                    </div>
                                    <hr>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left">
                                                    Tanggal Periksa
                                                </th>
                                                <td style="padding: 4px; width: 10px;">:</td>
                                                <td style="font-weight: bold; padding: 4px;">
                                                    <?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">No RM</th>
                                                <td style="padding: 4px; width: 10px;">:</td>
                                                <td style="padding: 4px;"><?php echo e($antrianDokter->booking->pasien->no_rm); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Nama Pasien
                                                </th>
                                                <td style="padding: 4px; width: 10px;">:</td>
                                                <td style="padding: 4px;">
                                                    <?php echo e($antrianDokter->booking->pasien->nama_pasien); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Jenis Pasien
                                                </th>
                                                <td style="padding: 4px; width: 10px;">:</td>
                                                <td style="padding: 4px;">
                                                    <?php echo e($antrianDokter->booking->pasien->jenis_pasien); ?>

                                                </td>
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
                                                <th scope="row" style="padding: 4px; text-align: left;">Jenis Kelamin
                                                </th>
                                                <td style="padding: 4px; width: 10px;">:</td>
                                                <td style="padding: 4px;">
                                                    <?php echo e($antrianDokter->booking->pasien->jekel == 'L' ? 'Laki-laki' : ($antrianDokter->booking->pasien->jekel == 'P' ? 'Perempuan' : '')); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Alamat
                                                    Domisili
                                                </th>
                                                <td style="padding: 4px; width: 10px;">:</td>
                                                <td style="padding: 4px;">
                                                    <?php echo e($antrianDokter->booking->pasien->domisili); ?>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="text-muted">
                                            <li>
                                                <strong>
                                                    Keterangan Anatomi Tubuh Pasien
                                                </strong>
                                            </li>
                                        </h5>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary"
                                                    onclick="showImage('depan')">
                                                    <i class="fa-solid fa-arrow-up-from-bracket"></i> Depan
                                                </button>
                                                <textarea name="depan" class="form-control mt-2 mb-2" id="depan" cols="5" rows="5"><?php echo e($fisik->depan ?? '-'); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary"
                                                    onclick="showImage('samping')">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Samping
                                                </button>
                                                <textarea name="samping" class="form-control mt-2 mb-2" id="samping" cols="5" rows="5"><?php echo e($fisik->samping ?? '-'); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary"
                                                    onclick="showImage('belakang')">
                                                    <i class="fa-solid fa-arrows-rotate"></i> Belakang
                                                </button>
                                                <textarea name="belakang" class="form-control mt-2 mb-2" id="belakang" cols="5" rows="5"><?php echo e($fisik->belakang ?? '-'); ?></textarea>
                                            </div>
                                            <div class="tutup" style="margin-top: 10px; margin-left: 150px">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <p class="text-muted"
                                                style="font-size: 20px; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">
                                                Anatomi
                                                Tubuh Manusia</p>
                                            <img id="displayedImage" src="<?php echo e(asset('assets/images/depan.png')); ?>"
                                                style="max-width: 70%; height: auto; border-radius: 10px;"
                                                alt="Kerangka">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Klinik\resources\views/dokter/umum/edittubuh.blade.php ENDPATH**/ ?>