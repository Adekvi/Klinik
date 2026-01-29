
<div class="modal fade" id="modalSoap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Tindakan Dokter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(url('dokter/store/' . $id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profesi" style="font-weight: bold">Dokter Penanggung Jawab Pasien</label>
                                <input type="text" style="font-weight: bold"
                                    value="<?php echo e($antrianDokter->dokter->nama_dokter); ?>" class="form-control mt-2"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="">Nama Pasien</label>
                                <input type="text" name="nama_pasien" id="nama_pasien" class="form-control mt-2"
                                    value="<?php echo e($antrianDokter->booking->pasien->nama_pasien); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="">Umur</label>
                                <input type="text" class="form-control mt-2"
                                    value="<?php echo e(\Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir)->age . ' Tahun'); ?>"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <h6 class="mt-4" style="font-weight: bold; margin-bottom: 5px">ASESMEN</h6>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group mt-3">
                                <label for="keluhan" style="font-weight: bold">Keluhan (S)</label>
                                <input type="text" name="keluhan" value="<?php echo e($antrianDokter->rm->a_keluhan_utama); ?>"
                                    class="form-control mt-2">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mt-3">
                                <label for="riwayat-alergi" style="font-weight: bold">Alergi</label>
                                <select name="a_riwayat_alergi" id="a_riwayat_alergi" class="form-control mt-2 mb-2 ">
                                    <option value="<?php echo e($antrianDokter->rm->a_riwayat_alergi ?? 'Tidak Ada'); ?>" selected>
                                        <?php echo e($antrianDokter->rm->a_riwayat_alergi ?? 'Tidak Ada'); ?></option>
                                    <option value="Ada">Ada</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mt-3">
                                <label for="riwayat-penyakit-skrg"><strong>Riwayat Penyakit Sekarang</strong></label>
                                <input type="text" name="a_riwayat_penyakit_skrg" id="a_riwayat_penyakit_skrg"
                                    class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Sekarang"
                                    value="<?php echo e($antrianDokter->rm->a_riwayat_penyakit_skrg ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="isian" style="font-weight: bold; margin-bottom: 10px">Isian Pilihan</label>
                        <?php
                            $isianPilihan = trim(optional($antrianDokter->isian)->p_form_isian_pilihan ?? '');
                        ?>

                        <div id="isian" class="mt-3 mb-2">
                            <label>
                                <input type="radio" name="isian" id="isian-ya" value="Auto-anamnesis">
                                Auto Anamnesis
                            </label>

                            <label style="margin-left:30px">
                                <input type="radio" name="isian" id="isian-tidak" value="Aloanamnesis">
                                Aloanamnesis
                            </label>
                        </div>

                        <div id="alasan-isian-soap"
                            style="<?php echo e($isianPilihan === 'Aloanamnesis' ? 'display:block' : 'display:none'); ?>">
                            <input type="text" class="form-control" value="<?php echo e(optional($antrianDokter->isian)->p_form_isian_pilihan_uraian); ?>">
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const value = <?php echo json_encode($isianPilihan, 15, 512) ?>;

                                if (value === 'Auto-anamnesis') {
                                    document.getElementById('isian-ya').checked = true;
                                } else if (value === 'Aloanamnesis') {
                                    document.getElementById('isian-tidak').checked = true;
                                }
                            });
                        </script>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="pf" style="font-weight: bold; text-align: center">Pemeriksaan Fisik</label>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="kesadaran" style="width: 30%">1. Kesadaran</label> :
                            <select name="kesadaran" id="kesadaran" class="form-control" style="width: 40%">
                                <option value="Compos Mentis">Compos Mentis</option>
                                <option value="Somnolence">Somnolence</option>
                                <option value="Sopor">Sopor</option>
                                <option value="Coma">Coma</option>
                            </select>
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="gcs" style="width: 30%">2. GCS</label> :
                            <div class="input-group d-flex mt-3" style="width: 40%">
                                <input type="text" name="gcs_e" id="gcs_e"
                                    value="<?php echo e($antrianDokter->isian->gcs_e); ?>" class="form-control"
                                    aria-describedby="basic-addon2" placeholder="E">
                                <input type="text" name="gcs_m" id="gcs_m"
                                    value="<?php echo e($antrianDokter->isian->gcs_m); ?>" class="form-control"
                                    aria-describedby="basic-addon2" placeholder="M">
                                <input type="text" name="gcs_v" id="gcs_v"
                                    value="<?php echo e($antrianDokter->isian->gcs_v); ?>" class="form-control"
                                    aria-describedby="basic-addon2" placeholder="V">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"
                                        style="background: rgb(228, 228, 228)">
                                        <span id="gcs_total"> <b>0</b></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="kepala" style="width: 30%">3. Kepala</label> :
                            <select name="kepala" id="kepala" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-kepala_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_kepala === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_kepala === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-kepala_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_kepala === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-kepala_<?php echo e($antrianDokter->rm->id); ?>"
                                name="alasan-kepala" class="form-control mt-2 mb-2"
                                value="<?php echo e($antrianDokter->rm->o_kepala_uraian); ?>"
                                placeholder="Alasan Kepala Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="mata" style="width: 30%">4. Mata</label> :
                            <select name="mata" id="mata" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-mata_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_mata === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_mata === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-mata_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_mata === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-mata_<?php echo e($antrianDokter->rm->id); ?>" name="alasan-mata"
                                value="<?php echo e($antrianDokter->rm->o_mata_uraian); ?>" class="form-control mt-2 mb-2"
                                placeholder="Alasan Mata Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="leher" style="width: 30%">5. Leher</label> :
                            <select name="leher" id="leher" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-leher_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option value="Normal"
                                    <?php echo e($antrianDokter->rm->o_leher === 'Normal' ? 'selected' : ''); ?>>Normal</option>
                                <option value="Abnormal"
                                    <?php echo e($antrianDokter->rm->o_leher === 'Abnormal' ? 'selected' : ''); ?>>Abnormal
                                </option>
                            </select>
                        </div>
                        <div id="alasan-leher_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_leher === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-leher_<?php echo e($antrianDokter->rm->id); ?>" name="alasan-leher"
                                value="<?php echo e($antrianDokter->rm->o_leher_uraian); ?>" class="form-control mt-2 mb-2"
                                placeholder="Alasan Leher Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="tht" style="width: 30%">6. THT</label> :
                            <select name="tht" id="tht" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-tht_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option value="Normal" <?php echo e($antrianDokter->rm->o_tht === 'Normal' ? 'selected' : ''); ?>>
                                    Normal</option>
                                <option value="Abnormal"
                                    <?php echo e($antrianDokter->rm->o_tht === 'Abnormal' ? 'selected' : ''); ?>>Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-tht_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-tht_<?php echo e($antrianDokter->rm->id); ?>" name="alasan-tht"
                                value="<?php echo e($antrianDokter->rm->o_tht_uraian); ?>" class="form-control mt-2 mb-2"
                                placeholder="Alasan THT Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="thorax" style="width: 30%">7. Thorax</label> :
                            <select name="thorax" id="thorax" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-thorax_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_thorax === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_thorax === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-thorax_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-thorax_<?php echo e($antrianDokter->rm->id); ?>"
                                name="alasan-thorax" value="<?php echo e($antrianDokter->rm->o_thorax_uraian); ?>"
                                class="form-control mt-2 mb-2" placeholder="Alasan Thorax Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="paru" style="width: 30%">8. Paru</label> :
                            <select name="paru" id="paru" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-paru_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_paru === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_paru === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-paru_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_paru === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-paru_<?php echo e($antrianDokter->rm->id); ?>" name="alasan-paru"
                                class="form-control mt-2 mb-2" value="<?php echo e($antrianDokter->rm->o_paru_uraian); ?>"
                                placeholder="Alasan Paru Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="jantung" style="width: 30%">9. Jantung</label> :
                            <select name="jantung" id="jantung" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-jantung_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_jantung === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_jantung === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-jantung_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_jantung === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-jantung_<?php echo e($antrianDokter->rm->id); ?>"
                                name="alasan-jantung" value="<?php echo e($antrianDokter->rm->o_jantung_uraian); ?>"
                                class="form-control mt-2 mb-2" placeholder="Alasan Jantung Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="abdomen" style="width: 30%">10. Abdomen</label> :
                            <select name="abdomen" id="abdomen" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-abdomen_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_abdomen === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_abdomen === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-abdomen_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_abdomen === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-abdomen_<?php echo e($antrianDokter->rm->id); ?>"
                                value="<?php echo e($antrianDokter->rm->o_abdomen_uraian); ?>" name="alasan-abdomen"
                                class="form-control mt-2 mb-2" placeholder="Alasan Abdomen Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="ekstremitas" style="width: 30%">11. Ekstremitas</label> :
                            <select name="ekstremitas" id="ekstremitas" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-ekstremitas_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_ekstremitas === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_ekstremitas === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-ekstremitas_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_ekstremitas === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-ekstremitas_<?php echo e($antrianDokter->rm->id); ?>"
                                name="alasan-ekstremitas" value="<?php echo e($antrianDokter->rm->o_ekstremitas_uraian); ?>"
                                class="form-control mt-2 mb-2" placeholder="Alasan Ekstremitas Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="kulit" style="width: 30%">12. Kulit</label> :
                            <select name="kulit" id="kulit" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-kulit_<?php echo e($antrianDokter->rm->id); ?>', this)">
                                <option <?php echo e($antrianDokter->rm->o_kulit === 'Normal' ? 'selected' : ''); ?>

                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option <?php echo e($antrianDokter->rm->o_kulit === 'Abnormal' ? 'selected' : ''); ?>

                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-kulit_<?php echo e($antrianDokter->rm->id); ?>"
                            style="<?php echo e($antrianDokter->rm->o_kulit === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                            <input type="text" id="alasan-kulit_<?php echo e($antrianDokter->rm->id); ?>"
                                value="<?php echo e($antrianDokter->rm->o_kulit_uraian); ?>" name="alasan-kulit"
                                class="form-control mt-2 mb-2" placeholder="Alasan Kulit Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="lain-lain" style="width: 30%">13. Lain-lain</label> :
                            <input type="text" id="lain" name="lain"
                                value="<?php echo e($antrianDokter->rm->lain_lain); ?>" class="form-control mt-3 mb-2"
                                placeholder="Lain-lain" style="width: 40%">
                        </div>
                        <div id="imageContainer"></div>
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <label for="tanda-vital" style="font-weight: bold">Tanda Vital (O)</label>
                        <div class="col-lg-12">
                            <div class="row mt-2">
                                <!-- Tensi -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="tensi">Tensi</label>
                                        <div class="input-group">
                                            <input type="text" name="tensi"
                                                value="<?php echo e($antrianDokter->isian->p_tensi); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>mmHg</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- RR -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="rr">RR</label>
                                        <div class="input-group">
                                            <input type="text" name="rr"
                                                value="<?php echo e($antrianDokter->isian->p_rr); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>/ minute</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nadi -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="nadi">Nadi</label>
                                        <div class="input-group">
                                            <input type="text" name="nadi"
                                                value="<?php echo e($antrianDokter->isian->p_nadi); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>/ minute</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SpO2 -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="spo2">SpO2</label>
                                        <div class="input-group">
                                            <input type="text" name="spo2"
                                                value="<?php echo e($antrianDokter->isian->spo2); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>%</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Suhu -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="suhu">Suhu</label>
                                        <div class="input-group">
                                            <input type="text" name="suhu"
                                                value="<?php echo e($antrianDokter->isian->p_suhu); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>°c</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tinggi Badan -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="tb">Tinggi Badan</label>
                                        <div class="input-group">
                                            <input type="number" name="tb" id="tb"
                                                value="<?php echo e($antrianDokter->isian->p_tb); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>cm</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Berat Badan -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="bb">Berat Badan</label>
                                        <div class="input-group">
                                            <input type="number" name="bb" id="bb"
                                                value="<?php echo e($antrianDokter->isian->p_bb); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>kg</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- IMT -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="imt">IMT</label>
                                        <div class="input-group">
                                            <input type="text" name="p_imt" id="p_imt"
                                                value="<?php echo e($antrianDokter->isian->p_imt); ?>"
                                                class="form-control mt-2 mb-2" aria-describedby="basic-addon2"
                                                readonly>
                                            <div class="input-group-append mt-2 mb-2">
                                                <span class="input-group-text" id="basic-addon2"
                                                    style="background: rgb(228, 228, 228)">
                                                    <b>kg/m2</b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    $tgllahir = \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir);
                                    $umur = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                                    $jenis_kelamin = $antrianDokter->booking->pasien->jekel;
                                    // dd($umur, $jenis_kelamin);
                                ?>

                                <?php if($umur > 16 && $jenis_kelamin === 'P'): ?>
                                    
                                    
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="lingkar-kepala-anak">Lingkar Kepala Anak</label>
                                            <div class="input-group">
                                                <input type="number" name="p_lngkr_kepala_anak"
                                                    id="p_lngkr_kepala_anak"
                                                    value="<?php echo e($antrianDokter->isian->p_lngkr_kepala_anak); ?>"
                                                    class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2"
                                                        style="background: rgb(228, 228, 228)">
                                                        <b>cm</b>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="lingkar-lengan">Lingkar Lengan</label>
                                            <div class="input-group">
                                                <input type="text" name="p_lngkr_lengan_anc"
                                                    id="p_lngkr_lengan_anc"
                                                    value="<?php echo e($antrianDokter->isian->p_lngkr_lengan_anc); ?>"
                                                    class="form-control mt-2 mb-2" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2"
                                                        style="background: rgb(228, 228, 228)">
                                                        <b>cm</b>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="soap_a_input" style="font-weight: bold">Diagnosa (A)</label>
                        <div class="col-md-12 mt-2">
                            <div class="input-group position-relative">
                                <input type="text" id="soap_a_input" class="form-control" placeholder="Cari Diagnosa">
                                <button class="btn btn-primary" type="button" id="add-diagnosa-btn">Add</button>
                                <div id="dropdown-diagnosa" class="dropdown-menu w-100" style="display: none; top: 100%; left: 0;"></div>
                            </div>

                            <!-- Container untuk daftar diagnosa yang ditambahkan -->
                            <ul id="diagnosa-list" class="list-group mt-2"></ul>
                        </div>
                    </div>

                    <div class="form-group mt-3 mb-2">
                        <label for="soap_p_input" style="font-weight: bold; margin-top: 10px; margin-bottom: 5px;">
                        Pilih Obat (P)
                        </label>

                        <div id="obat-form" class="mb-3">

                        <!-- Baris Nama Obat dan Jenis Sediaan -->
                        <div class="input-row d-flex gap-3 mb-2">
                            <input type="text" id="nama-obat-input" class="form-control flex-grow-1" placeholder="Cari Nama Obat" autocomplete="off" data-url="<?php echo e(url('/resep-autocomplete')); ?>">
                            <input type="text" id="jenis-sediaan-input" class="form-control" style="flex-basis: 220px;" placeholder="Cari Jenis Sediaan" autocomplete="off" data-url="<?php echo e(url('/jenis-autocomplete')); ?>">
                        </div>

                        <!-- Baris Aturan Pakai dan Anjuran Minum -->
                        <div class="input-row d-flex gap-3 mb-2">
                            <input type="text" id="aturan-pakai-input" class="form-control flex-grow-1" placeholder="Cari Aturan Pakai" autocomplete="off" data-url="<?php echo e(url('/aturan-autocomplete')); ?>">
                            <input type="text" id="anjuran-minum-input" class="form-control" style="flex-basis: 220px;" placeholder="Cari Anjuran Minum" autocomplete="off" data-url="<?php echo e(url('/anjuran-autocomplete')); ?>">
                        </div>

                        <!-- Baris Jumlah dan Tombol Add -->
                        <div class="input-row d-flex gap-3 align-items-center">
                            <input type="number" id="jumlah-input" class="form-control" placeholder="Jumlah" min="1" style="flex-basis: 100px;">
                            <button id="add-obat-btn" class="btn btn-primary" style="flex-basis: 80px; padding: 6px 12px;">Add</button>
                        </div>

                        </div>

                        <!-- Racikan -->
                        <label for="racikan-textarea" style="font-weight: bold; margin-top: 20px; margin-bottom: 5px; display: block;">Resep Racikan</label>
                        <textarea name="ObatRacikan" id="racikan-textarea" cols="30" rows="5" class="form-control mb-3"></textarea>

                        <!-- List Obat hasil Add -->
                        <ul id="obat-list" class="list-group"></ul>
                    </div>
                    <div class="form-group">
                        <label for="edukasi" style="font-weight: bold">Edukasi</label>
                        <input type="text" class="form-control mt-2 mb-2" name="edukasi" id="edukasi"
                            placeholder="Edukasi">
                    </div>
                    <div class="form-group">
                        <label for="rujuk" style="font-weight: bold">Rencana Tindak Lanjut</label>
                        <select name="rujuk" id="rujuk" class="form-control mt-2 mb-2">
                            <option value="Tidak Ada" selected>Tidak Ada</option>
                            <option value="Rumah Sakit">Rumah Sakit</option>
                            <option value="Laborat">Laborat</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('style'); ?>
    <style>
        /* RESEP */
        .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        }
        .list-group-item .btn {
        margin-left: 10px;
        }
        .autocomplete-dropdown {
        position: absolute;
        z-index: 1000;
        background: white;
        border: 1px solid #ccc;
        width: 100%;
        max-height: 150px;
        overflow-y: auto;
        cursor: pointer;
        }
        /* Agar input-row memiliki margin bawah dan spasi antar input */
        .input-row {
        width: 100%;
        }

        /* Agar dropdown autocomplete muncul dengan lebar 100% sesuai input */
        .autocomplete-dropdown {
        position: absolute;
        z-index: 1000;
        background: white;
        border: 1px solid #ccc;
        max-height: 180px;
        overflow-y: auto;
        width: 100%;
        cursor: pointer;
        box-sizing: border-box;
        }

        /* Gaya tombol add agar tidak terlalu besar */
        #add-obat-btn {
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        }

        /* Tambahan responsif kecil agar baris inputan rapih */
        @media (max-width: 576px) {
        .input-row.d-flex {
        flex-direction: column;
        }
        .input-row.d-flex > input,
        .input-row.d-flex > button {
        flex-basis: 100% !important;
        margin-bottom: 8px;
        }
        }


    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // DIAGNOSA
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('soap_a_input');
            const dropdown = document.getElementById('dropdown-diagnosa');
            const addBtn = document.getElementById('add-diagnosa-btn');
            const diagnosaList = document.getElementById('diagnosa-list');

            function showDropdown(results) {
                dropdown.innerHTML = '';
                if (results.length === 0) {
                    dropdown.style.display = 'none';
                    return;
                }
                results.forEach(result => {
                    const option = document.createElement('div');
                    option.classList.add('dropdown-item');
                    option.textContent = result.text;
                    option.dataset.id = result.id;

                    option.addEventListener('click', function() {
                        input.value = result.text;
                        dropdown.style.display = 'none';
                    });

                    dropdown.appendChild(option);
                });
                dropdown.style.display = 'block';
            }

            function searchDiagnosa(term, callback) {
                fetch(`/search-diagnosa?term=${encodeURIComponent(term)}`)
                    .then(res => res.json())
                    .then(data => callback(data))
                    .catch(err => console.error(err));
            }

            input.addEventListener('input', function() {
                const term = input.value;
                if (term.length > 2) {
                    searchDiagnosa(term, showDropdown);
                } else {
                    dropdown.style.display = 'none';
                }
            });

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            function addDiagnosa(value) {
                if (!value.trim()) return;

                const li = document.createElement('li');
                li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                const badge = document.createElement('span');
                badge.classList.add('badge', 'bg-info', 'me-2');
                badge.textContent = diagnosaList.children.length === 0 ? 'Primer' : 'Sekunder';

                const textNode = document.createTextNode(value);
                li.appendChild(badge);
                li.appendChild(textNode);

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
                removeBtn.textContent = 'Hapus';
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    li.remove();
                });

                li.appendChild(removeBtn);

                // Klik item untuk ubah tipe
                li.addEventListener('click', function(e) {
                    const currentType = badge.textContent;

                    if (currentType === 'Sekunder') {
                        if (confirm(`Jadikan "${value}" sebagai Primer?`)) {
                            // Cari Primer saat ini, ubah jadi Sekunder
                            const items = diagnosaList.children;
                            for (let i = 0; i < items.length; i++) {
                                const b = items[i].querySelector('span.badge');
                                if (b.textContent === 'Primer') {
                                    b.textContent = 'Sekunder';
                                }
                            }
                            // Jadikan item ini Primer
                            badge.textContent = 'Primer';
                            diagnosaList.prepend(li); // naik ke atas
                        }
                    } else if (currentType === 'Primer') {
                        if (confirm(`Jadikan "${value}" sebagai Sekunder?`)) {
                            badge.textContent = 'Sekunder';
                            diagnosaList.appendChild(li); // pindah ke bawah
                        }
                    }
                });

                diagnosaList.appendChild(li);
            }

            addBtn.addEventListener('click', function() {
                addDiagnosa(input.value.trim());
                input.value = '';
            });
        });





        // RESEP
        document.addEventListener('DOMContentLoaded', function() {
  // Helper: buat autocomplete sederhana
  function setupAutocomplete(input) {
    const url = input.dataset.url;
    const dropdown = document.createElement('div');
    dropdown.classList.add('autocomplete-dropdown');
    input.parentNode.style.position = 'relative';
    input.parentNode.appendChild(dropdown);

    input.addEventListener('input', function() {
      const term = input.value.trim();
      if(term.length < 2) {
        dropdown.style.display = 'none';
        return;
      }
      fetch(`${url}?term=${encodeURIComponent(term)}`)
        .then(res => res.json())
        .then(data => {
          dropdown.innerHTML = '';
          if(data.length === 0) {
            dropdown.innerHTML = '<div class="dropdown-item disabled">Tidak ada data</div>';
          } else {
            data.forEach(item => {
              const option = document.createElement('div');
              option.classList.add('dropdown-item');
              option.textContent = item.text || item.nama || item.nama_obat || item.jenis || item.aturan || item.anjuran || 'Unknown';
              option.dataset.value = item.id || item.value || option.textContent;
              option.addEventListener('click', () => {
                input.value = option.textContent;
                dropdown.style.display = 'none';
              });
              dropdown.appendChild(option);
            });
          }
          dropdown.style.display = 'block';
        })
        .catch(() => {
          dropdown.innerHTML = '<div class="dropdown-item disabled">Error loading data</div>';
          dropdown.style.display = 'block';
        });
    });

    // Hide dropdown saat klik di luar
    document.addEventListener('click', e => {
      if(!input.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
      }
    });
  }

  // Setup autocomplete pada semua input dengan data-url
  ['nama-obat-input', 'jenis-sediaan-input', 'aturan-pakai-input', 'anjuran-minum-input'].forEach(id => {
    const el = document.getElementById(id);
    if(el) setupAutocomplete(el);
  });

  // Referensi input dan tombol
  const namaObatInput = document.getElementById('nama-obat-input');
  const jenisSediaanInput = document.getElementById('jenis-sediaan-input');
  const aturanPakaiInput = document.getElementById('aturan-pakai-input');
  const anjuranMinumInput = document.getElementById('anjuran-minum-input');
  const jumlahInput = document.getElementById('jumlah-input');
  const addBtn = document.getElementById('add-obat-btn');
  const obatList = document.getElementById('obat-list');
  const racikanTextarea = document.getElementById('racikan-textarea');

  // Fungsi clear semua input setelah add
  function clearInputs() {
    namaObatInput.value = '';
    jenisSediaanInput.value = '';
    aturanPakaiInput.value = '';
    anjuranMinumInput.value = '';
    jumlahInput.value = '';
  }

  // Fungsi tambah item obat ke list
  function addObat() {
    const namaObat = namaObatInput.value.trim();
    const jenisSediaan = jenisSediaanInput.value.trim();
    const aturanPakai = aturanPakaiInput.value.trim();
    const anjuranMinum = anjuranMinumInput.value.trim();
    const jumlah = jumlahInput.value.trim();

    if(!namaObat) {
      alert('Nama Obat harus diisi');
      namaObatInput.focus();
      return;
    }
    if(!jumlah || isNaN(jumlah) || parseInt(jumlah) <= 0) {
      alert('Jumlah harus angka lebih dari 0');
      jumlahInput.focus();
      return;
    }

    const li = document.createElement('li');
    li.classList.add('list-group-item');

    li.innerHTML = `
      <div>
        <strong>${namaObat}</strong> - ${jenisSediaan ? jenisSediaan : '-'}<br>
        Aturan Pakai: ${aturanPakai ? aturanPakai : '-'}, Anjuran Minum: ${anjuranMinum ? anjuranMinum : '-'}<br>
        Jumlah: ${jumlah}
      </div>
      <button class="btn btn-danger btn-sm">Hapus</button>
    `;

    // Event hapus
    li.querySelector('button').addEventListener('click', () => {
      li.remove();
    });

    // Tambah ke list
    obatList.appendChild(li);

    // Clear input form
    clearInputs();

    // Fokus ke nama obat
    namaObatInput.focus();
  }

  // Event klik tombol Add
  addBtn.addEventListener('click', addObat);

  // Optional: bisa juga tekan Enter di jumlah input untuk Add
  jumlahInput.addEventListener('keypress', e => {
    if(e.key === 'Enter') {
      e.preventDefault();
      addObat();
    }
  });
});

    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/dokter/modal/modalSoap.blade.php ENDPATH**/ ?>