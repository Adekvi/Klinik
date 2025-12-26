<div id="formAsesmen<?php echo e($booking->id); ?>">
    <input type="hidden" name="id_pasien" value="<?php echo e($booking->id_pasien); ?>">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Nama Pasien</label>
                <input type="text" name="nama_pasien" id="nama_pasien" class="form-control mt-2 mb-2"
                    value="<?php echo e($booking->pasien->nama_pasien); ?>">
            </div>
            <p class="text-danger">
                <span style="font-style: italic">
                    <strong>
                        <i class="fa-solid fa-circle-exclamation"></i> *Cek ulang Nama Pasien
                    </strong>
                </span>
            </p>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Umur</label>
                <input type="text" value="<?php echo e(\Carbon\Carbon::parse($booking->pasien->tgllahir)->age . ' Tahun'); ?>"
                    class="form-control mt-2 mb-2" readonly>
            </div>
        </div>
        <hr style="border: none; height: 1px">
    </div>

    <div class="form-isian">
        <h5 style="text-align: center; font-size: 20px"><strong>Form Isian</strong></h5>
        <div class="form-group mt-2 mb-2">
            <p onclick="toggleInput('isian')" style="margin-bottom: 3px; text-align: start">
                Isian Pilihan</p>
            <div id="isian" style="text-align: start; font-size: 20px">
                <label for="isian-ya">
                    <input type="radio" name="isian" id="isian-ya" value="Auto-anamnesis"
                        onclick="toggleChange('alasan-isian', this) "
                        style="transform: scale(1.5); margin-right: 10px;"> Auto Anamnesis
                </label>
                <label for="isian-tidak">
                    <input type="radio" name="isian" id="isian-tidak" value="Aloanamnesis"
                        onclick="toggleChange('alasan-isian', this)"
                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                    Aloanamnesis
                </label>
            </div>
            <div id="alasan-isian" style="display: none;">
                <div class="col-md-6">
                    <input type="text" id="isian_alasan" name="isian_alasan" class="form-control mt-2 mb-2"
                        placeholder="Alasan">
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="anamnesis-s">
        <h5 style="text-align: center; font-size: 20px"><strong>Anamnesis (S)</strong>
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="keluhan">Keluhan Utama </label>
                    <input type="text" name="a_keluhan_utama" id="a_keluhan_utama" class="form-control mt-2 mb-2 "
                        placeholder="Isi Keluhan Utama" value="<?php echo e($booking->rm->a_keluhan_utama ?? ''); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="riwayat-penyakit-skrg">Riwayat Penyakit Sekarang</label>
                    <input type="text" name="a_riwayat_penyakit_skrg" id="a_riwayat_penyakit_skrg"
                        class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Sekarang"
                        value="<?php echo e($booking->rm->a_riwayat_penyakit_skrg ?? ''); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="riwayat-penyakit-terdahulu">Riwayat Penyakit
                        Terdahulu</label>
                    <input type="text" name="a_riwayat_penyakit_terdahulu" id="a_riwayat_penyakit_terdahulu"
                        class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Terdahulu"
                        value="<?php echo e($booking->rm->a_riwayat_penyakit_terdahulu ?? ''); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="riwayat-penyakit-keluarga">Riwayat Penyakit
                        Keluarga</label>
                    <input type="text" name="a_riwayat_penyakit_keluarga" id="a_riwayat_penyakit_keluarga"
                        class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Keluarga"
                        value="<?php echo e($booking->rm->a_riwayat_penyakit_keluarga ?? ''); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="riwayat-alergi">Riwayat Alergi</label>
                    <select name="a_riwayat_alergi" id="a_riwayat_alergi" class="form-control mt-2 mb-2 ">
                        <option value="Ada" <?php echo e(($booking->rm->a_riwayat_alergi ?? '')=='Ada'?'selected':''); ?>>Ada</option>
                        <option value="Tidak" <?php echo e(($booking->rm->a_riwayat_alergi ?? '')=='Tidak'?'selected':''); ?>>Tidak</option>
                    </select>

                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="tanda-vital">
        <h5 style="text-align: center; font-size: 20px;">
            <strong>Tanda Vital</strong>
        </h5>

        
        <div class="row">
            <div class="col-md-4">
                <label>Tensi</label>
                <div class="input-group">
                    <input type="text" name="p_tensi" wire:model.defer="p_tensi" class="form-control mt-2 mb-2">
                    <span class="input-group-text mb-2 mt-2"><b>mmHg</b></span>
                </div>
            </div>

            <div class="col-md-4">
                <label>RR</label>
                <div class="input-group">
                    <input type="text" name="p_rr" wire:model.defer="p_rr" class="form-control mt-2 mb-2">
                    <span class="input-group-text mb-2 mt-2"><b>/ minute</b></span>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-4">
                <label>Nadi</label>
                <div class="input-group">
                    <input type="text" name="p_nadi" wire:model.defer="p_nadi" class="form-control mt-2 mb-2">
                    <span class="input-group-text mb-2 mt-2"><b>/ minute</b></span>
                </div>
            </div>

            <div class="col-md-4">
                <label>SpO2</label>
                <div class="input-group">
                    <input type="text" name="p_spo2" wire:model.defer="p_suhu" class="form-control mt-2 mb-2">
                    <span class="input-group-text mb-2 mt-2"><b>%</b></span>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-4">
                <label>Suhu</label>
                <div class="input-group">
                    <input type="text" name="p_suhu" wire:model.defer="p_suhu" class="form-control mt-2 mb-2">
                    <span class="input-group-text mb-2 mt-2"><b>°c</b></span>
                </div>
            </div>

            <div class="col-md-4">
                <label>Tinggi Badan</label>
                <div class="input-group">
                    <input type="number" name="p_tb" wire:model.live="p_tb" class="form-control mt-2 mb-2">
                    <span class="input-group-text mb-2 mt-2"><b>cm</b></span>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-4">
                <label>Berat Badan</label>
                <div class="input-group">
                    <input type="number" name="p_bb" wire:model.live="p_bb" class="form-control mt-2 mb-2">
                    <span class="input-group-text mb-2 mt-2"><b>kg</b></span>
                </div>
            </div>

            <div class="col-md-4">
                <label>IMT</label>
                <div class="input-group">
                    <input type="text" name="p_imt" wire:model="p_imt" class="form-control mt-2 mb-2" readonly>
                    <span class="input-group-text mb-2 mt-2"><b>kg/m²</b></span>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="anamnesis-o">
        <h5 style="text-align: center; font-size: 20px;"><strong>Pemeriksaan Fisik Umum
                (0)</strong></h5>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="keadaan_umum">Keadaan Umum</label>
                    <input type="text" name="keadaan_umum" id="keadaan_umum" class="form-control mt-2 mb-2 "
                        placeholder="Isi Keadaan Umum" value="<?php echo e($booking->rm->o_keadaan_umum ?? ''); ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group mt-2 mb-2">
                    
                    <label for="kesadaran">Kesadaran</label>
                    <select name="kesadaran" id="kesadaran" class="form-control">
                        <option value="Compos Mentis">Compos Mentis</option>
                        <option value="Somnolence">Somnolence</option>
                        <option value="Sopor">Sopor</option>
                        <option value="Coma">Coma</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="row">
                <div class="col-md-8">
                    <label for="gcs">GCS</label>

                    <div class="input-group d-flex mt-2">
                        <input type="number" name="gcs_e" wire:model.live="gcs_e" class="form-control" placeholder="E">
                        <input type="number" name="gcs_m" wire:model.live="gcs_m" class="form-control" placeholder="M">
                        <input type="number" name="gcs_v" wire:model.live="gcs_v" class="form-control" placeholder="V">

                        <input type="hidden" name="gcs_total" value="<?php echo e($gcs_total); ?>">


                        <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                            Total:&nbsp;<b><?php echo e($gcs_total); ?></b>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="text-align: start">
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px">Kepala</p>
                <div id="kepala">
                    <label for="jawaban-normal">
                        <input type="radio" name="kepala" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-kepala_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="kepala" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-kepala_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-kepala_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-kepala_<?php echo e($booking->id); ?>" name="alasan_kepala"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Mata</p>
                <div id="mata">
                    <label for="jawaban-normal">
                        <input type="radio" name="mata" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-mata_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="mata" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-mata_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-mata_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-mata_<?php echo e($booking->id); ?>" name="alasan_mata"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Leher</p>
                <div id="leher">
                    <label for="jawaban-normal">
                        <input type="radio" name="leher" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-leher_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="leher" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-leher_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-leher_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-leher_<?php echo e($booking->id); ?>" name="alasan_leher"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">THT (Telinga Hidung Tenggorokan)</p>
                <div id="tht">
                    <label for="jawaban-normal">
                        <input type="radio" name="tht" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-tht_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="tht" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-tht_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-tht_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-tht_<?php echo e($booking->id); ?>" name="alasan_tht"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Thorax</p>
                <div id="thorax">
                    <label for="jawaban-normal">
                        <input type="radio" name="thorax" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-thorax_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="thorax" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-thorax_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-thorax_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-thorax_<?php echo e($booking->id); ?>" name="alasan_thorax"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Paru</p>
                <div id="paru">
                    <label for="jawaban-normal">
                        <input type="radio" name="paru" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-paru_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="paru" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-paru_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-paru_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-paru_<?php echo e($booking->id); ?>" name="alasan_paru"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Jantung</p>
                <div id="jantung">
                    <label for="jawaban-normal">
                        <input type="radio" name="jantung" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-jantung_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="jantung" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-jantung_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-jantung_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-jantung_<?php echo e($booking->id); ?>" name="alasan_jantung"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Abdomen</p>
                <div id="abdomen">
                    <label for="jawaban-normal">
                        <input type="radio" name="abdomen" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-abdomen_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="abdomen" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-abdomen_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-abdomen_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-abdomen_<?php echo e($booking->id); ?>" name="alasan_abdomen"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Ekstremitas / Anggota Gerak</p>
                <div id="ekstremitas">
                    <label for="jawaban-normal">
                        <input type="radio" name="ekstremitas" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-ekstremitas_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="ekstremitas" id="jawaban-abnormal"
                            value="Abnormal" onclick="toggleChange('alasan-ekstremitas_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-ekstremitas_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-ekstremitas_<?php echo e($booking->id); ?>"
                                name="alasan_ekstremitas" class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 mb-2">
                <p style="margin-bottom: 5px;">Kulit</p>
                <div id="kulit">
                    <label for="jawaban-normal">
                        <input type="radio" name="kulit" id="jawaban-normal" value="Normal" checked
                            onclick="toggleChange('alasan-kulit_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px;"> Normal
                    </label>
                    <label for="jawaban-abnormal">
                        <input class="mx-3" type="radio" name="kulit" id="jawaban-abnormal" value="Abnormal"
                            onclick="toggleChange('alasan-kulit_<?php echo e($booking->id); ?>', this)"
                            style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                        Abnormal
                    </label>
                </div>
                <div id="alasan-kulit_<?php echo e($booking->id); ?>" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="alasan-kulit_<?php echo e($booking->id); ?>" name="alasan_kulit"
                                class="form-control mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-2 mb-2">
                    <label for="lain-lain">Lain - Lain</label>
                    <input type="text" name="lain" id="lain" class="form-control mt-2 mb-2"
                        placeholder="Lain-lain">
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="col-md-6">
        <div class="form-group">
            <strong>Tanda Tangan Perawat</strong>
            <select wire:model="selectedTtdPerawat" name="id_ttd_medis" id="id_ttd_medis<?php echo e($booking->id); ?>"
                class="form-control mt-2 mb-2" required>
                <option value="">Nama Perawat</option>
                <?php $__currentLoopData = $ttd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perawat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($perawat->id); ?>"><?php echo e($perawat->nama); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Klinik\resources\views/perawat/modalPerawat/tabs/tab-asesmen-awal.blade.php ENDPATH**/ ?>