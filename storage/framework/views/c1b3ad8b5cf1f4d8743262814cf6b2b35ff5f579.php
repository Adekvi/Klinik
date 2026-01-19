
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
                        <label for="soap_a_0" style="font-weight: bold">Diagnosa (A)</label>
                        <div class="col-md-12 mt-2">
                            

                            <div class="row">
                                <div class="col-6">
                                    <label for="diagnosa_primer">Diagnosa Primer</label>
                                    <div class="input-wrapper"> <!-- tambahkan wrapper -->
                                        <input type="text" id="soap_a_0" name="soap_a[0][diagnosa_primer]"
                                            class="soap_a form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                        <div id="dropdown-diagnosa-primer" class="dropdown-menu"
                                            style="z-index: 1000; display: none; cursor: pointer; width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="diagnosa_sekunder">Diagnosa Sekunder</label>
                                    <div class="input-wrapper"> <!-- tambahkan wrapper -->
                                        <input type="text" id="soap_a_b_0" name="soap_a_b[0][diagnosa_sekunder]"
                                            class="soap_a_b form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                        <div id="dropdown-diagnosa-sekunder" class="dropdown-menu"
                                            style="z-index: 1000; display: none; cursor: pointer; width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="soap_p_0"
                            style="font-weight: bold; margin-top: 10px; margin-bottom: 5px; width: 100%; cursor: pointer;"
                            onclick="toggleObatContainer()">Pilih Obat (P)</label>
                        <div class="resep" id="modal-resep">
                            <!-- Nama Obat -->
                            <div class="input-row" id="modal-namaObatContainer">
                                <label for="modal-resep_0" style="min-width: 100px;">Nama Obat</label>
                                <span>:</span>
                                <div class="input-wrapper">
                                    <div class="multi-select-wrapper form-control" data-input-id="modal-resep_0">
                                        <div class="selected-tags" id="modal-resep_0_tags"></div>
                                        <input type="text" class="autocomplete-input multi-select-input"
                                            id="modal-resep_0" placeholder="Cari Obat" autocomplete="off"
                                            data-url="<?php echo e(url('/resep-autocomplete')); ?>"
                                            data-dropdown="modal-dropdown-resep_0">
                                    </div>
                                    <input type="hidden" name="soap_p[0][resep][]" id="modal-resep_0_hidden">
                                    <div id="modal-dropdown-resep_0" class="dropdown-menu autocomplete-dropdown">
                                    </div>
                                    <p class="text-warning" style="font-style: italic; font-size: 12px">
                                        *Bisa memilih lebih dari 1 obat
                                    </p>
                                </div>
                            </div>
                            <!-- Jenis Obat -->
                            <div class="input-row" id="modal-jenisObatContainer">
                                <label for="modal-jenis_obat_0" style="min-width: 100px;">Jenis Obat</label>
                                <span>:</span>
                                <div class="input-wrapper">
                                    <div class="multi-select-wrapper form-control" data-input-id="modal-jenis_obat_0">
                                        <div class="selected-tags" id="modal-jenis_obat_0_tags"></div>
                                        <input type="text" class="autocomplete-input multi-select-input"
                                            id="modal-jenis_obat_0" placeholder="Cari Jenis Obat" autocomplete="off"
                                            data-url="<?php echo e(url('jenis-autocomplete')); ?>"
                                            data-dropdown="modal-dropdown-jenis_obat_0">
                                    </div>
                                    <input type="hidden" name="soap_p[0][jenisobat][]"
                                        id="modal-jenis_obat_0_hidden">
                                    <div id="modal-dropdown-jenis_obat_0" class="dropdown-menu autocomplete-dropdown">
                                    </div>
                                    <p class="text-warning" style="font-style: italic; font-size: 12px">
                                        *Bisa memilih lebih dari 1 jenis obat
                                    </p>
                                </div>
                            </div>
                            <!-- Aturan Pakai -->
                            <div class="input-row" id="modal-aturanContainer">
                                <label for="modal-aturan_0" style="min-width: 100px">Aturan Pakai</label>
                                <span>:</span>
                                <div class="input-wrapper">
                                    <div class="multi-select-wrapper form-control" data-input-id="modal-aturan_0">
                                        <div class="selected-tags" id="modal-aturan_0_tags"></div>
                                        <input type="text" class="autocomplete-input multi-select-input"
                                            id="modal-aturan_0" placeholder="Cari Aturan Pakai" autocomplete="off"
                                            data-url="<?php echo e(url('aturan-autocomplete')); ?>"
                                            data-dropdown="modal-dropdown-aturan_0">
                                    </div>
                                    <input type="hidden" name="soap_p[0][aturan][]" id="modal-aturan_0_hidden">
                                    <div id="modal-dropdown-aturan_0" class="dropdown-menu autocomplete-dropdown">
                                    </div>
                                    <p class="text-warning" style="font-style: italic; font-size: 12px">
                                        *Bisa memilih lebih dari 1 aturan pakai
                                    </p>
                                </div>
                            </div>
                            <!-- Anjuran Minum -->
                            <div class="input-row" id="modal-anjuranMinumContainer">
                                <label for="modal-anjuran_0" style="min-width: 100px">Anjuran Minum</label>
                                <span>:</span>
                                <div class="input-wrapper">
                                    <div class="multi-select-wrapper form-control" data-input-id="modal-anjuran_0">
                                        <div class="selected-tags" id="modal-anjuran_0_tags"></div>
                                        <input type="text" class="autocomplete-input multi-select-input"
                                            id="modal-anjuran_0" placeholder="Cari Anjuran Minum" autocomplete="off"
                                            data-url="<?php echo e(url('anjuran-autocomplete')); ?>"
                                            data-dropdown="modal-dropdown-anjuran_0">
                                    </div>
                                    <input type="hidden" name="soap_p[0][anjuran][]" id="modal-anjuran_0_hidden">
                                    <div id="modal-dropdown-anjuran_0" class="dropdown-menu autocomplete-dropdown">
                                    </div>
                                    <p class="text-warning" style="font-style: italic; font-size: 12px">
                                        *Bisa memilih lebih dari 1 anjuran minum
                                    </p>
                                </div>
                            </div>
                            <!-- Jumlah Masing-masing Obat -->
                            <div class="input-row" id="modal-jumlahObatContainer">
                                <label for="modal-jumlah_0" style="min-width: 100px">Jumlah</label>
                                <span>:</span>
                                <div class="input-wrapper">
                                    <div class="multi-select-wrapper form-control" data-input-id="modal-jumlah_0">
                                        <div class="selected-tags" id="modal-jumlah_0_tags"></div>
                                        <input type="number" class="multi-select-input jumlah-input"
                                            id="modal-jumlah_0" placeholder="Masukkan Jumlah" min="1">
                                    </div>
                                    <input type="hidden" name="soap_p[0][jumlah][]" id="modal-jumlah_0_hidden">
                                    <p class="text-warning" style="font-style: italic; font-size: 12px">
                                        *Bisa memasukkan lebih dari 1 jumlah (tekan Enter untuk menambah)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <label for=""
                            style="font-weight: bold; margin-top: 20px; margin-bottom: 5px; width: 100%; cursor: pointer"
                            onclick="toggleRacikanContainer()">Resep Racikan</label>
                        <div class="racikan" id="modal-resepRacikan">
                            <textarea name="ObatRacikan" id="modal-ObatRacikan" cols="30" rows="5" class="form-control mb-2 mt-2"></textarea>
                        </div>
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
        .resep {
            display: flex;
            flex-direction: column;
            margin-top: 0;
        }

        .racikan {
            display: flex;
            flex-direction: column;
            margin-top: 0;
        }

        #modal-resep,
        #modal-resepRacikan {
            display: block;
        }

        .input-row {
            display: flex;
            align-items: center;
            overflow-x: auto;
            white-space: nowrap;
            max-width: 100%;
            margin-bottom: 10px;
        }

        .input-row label {
            width: 150px;
            margin-right: 20px;
            flex-shrink: 0;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }

        .input-row span {
            margin-right: 5px;
        }

        .input-row .form-control {
            flex-grow: 1;
            margin-right: 10px;
        }

        .input-row .btn {
            margin-left: 5px;
        }

        .input-wrapper {
            position: relative;
            flex-grow: 1;
        }

        .input-wrapper p.text-warning {
            margin-top: 5px;
            /* beri jarak dengan input */
            margin-bottom: 0;
            /* rapatkan ke bawah */
        }

        /* Multi-select wrapper */
        .multi-select-wrapper {
            display: flex;
            flex-wrap: wrap;
            align-items: start;
            padding: 2px;
            min-height: 38px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
        }

        .selected-tags {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            flex-grow: 1;
            padding: 2px;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            background-color: #e9ecef;
            border-radius: 4px;
            padding: 2px 8px;
            margin: 2px;
            font-size: 14px;
            cursor: pointer;
            /* Tambah cursor pointer untuk menunjukkan bisa diklik */
        }

        .tag:hover {
            background-color: #dc3545;
            /* Warna merah saat hover untuk indikasi hapus */
            color: white;
        }

        .tag .remove-tag {
            margin-left: 5px;
            color: #dc3545;
            font-weight: bold;
        }

        .tag:hover .remove-tag {
            color: white;
            /* Ubah warna × saat hover */
        }

        .multi-select-input {
            border: none !important;
            outline: none !important;
            flex-grow: 1;
            min-width: 100px;
            height: 30px;
            padding: 0 5px;
            margin: 2px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            z-index: 1000;
            cursor: pointer;
            width: 100%;
            top: 100%;
            left: 0;
            background-color: white;
            border: 1px solid #ccc;
        }

        .dropdown-item {
            padding: 8px 12px;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f0f0f0;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>

    <script>
        // DIAGNOSA
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk memunculkan dropdown berdasarkan hasil pencarian
            function showDropdown(inputElement, dropdownElement, results) {
                dropdownElement.innerHTML = ''; // Bersihkan dropdown sebelumnya
                if (results.length === 0) {
                    dropdownElement.style.display = 'none'; // Sembunyikan jika tidak ada hasil
                    return;
                }

                results.forEach(function(result) {
                    const option = document.createElement('div');
                    option.classList.add('dropdown-item');
                    option.textContent = result.text; // Tampilkan hasil pencarian
                    option.dataset.id = result.id;

                    // Pilih diagnosa ketika salah satu item diklik
                    option.addEventListener('click', function() {
                        inputElement.value = result.text;
                        dropdownElement.style.display =
                            'none'; // Sembunyikan dropdown setelah dipilih
                    });

                    dropdownElement.appendChild(option);
                });
                dropdownElement.style.display = 'block'; // Tampilkan dropdown jika ada hasil
            }

            // Fungsi untuk mengambil hasil pencarian dari server
            function searchDiagnosa(term, callback) {
                fetch(`/search-diagnosa?term=${encodeURIComponent(term)}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Tambahkan ini untuk melihat hasil di console
                        callback(data);
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Event untuk pencarian diagnosa primer
            const diagnosaPrimerInput = document.getElementById('soap_a_0');
            const dropdownDiagnosaPrimer = document.getElementById('dropdown-diagnosa-primer');

            diagnosaPrimerInput.addEventListener('input', function() {
                const searchTerm = this.value;

                if (searchTerm.length > 2) {
                    searchDiagnosa(searchTerm, function(results) {
                        showDropdown(diagnosaPrimerInput, dropdownDiagnosaPrimer, results);
                    });
                } else {
                    dropdownDiagnosaPrimer.style.display =
                        'none'; // Sembunyikan dropdown jika input terlalu pendek
                }
            });

            // Event untuk pencarian diagnosa sekunder
            const diagnosaSekunderInput = document.getElementById('soap_a_b_0');
            const dropdownDiagnosaSekunder = document.getElementById('dropdown-diagnosa-sekunder');

            diagnosaSekunderInput.addEventListener('input', function() {
                const searchTerm = this.value;

                if (searchTerm.length > 2) {
                    searchDiagnosa(searchTerm, function(results) {
                        showDropdown(diagnosaSekunderInput, dropdownDiagnosaSekunder, results);
                    });
                } else {
                    dropdownDiagnosaSekunder.style.display = 'none';
                }
            });

            // toggle
            window.toggleObatContainer = function() {
                var resepContainer = document.getElementById('modal-resep');
                if (!resepContainer) return;
                resepContainer.style.display =
                    (resepContainer.style.display === 'none' || resepContainer.style.display === '') ?
                    'block' :
                    'none';
            };

            window.toggleRacikanContainer = function() {
                var resepRacikanContainer = document.getElementById('modal-resepRacikan');
                if (!resepRacikanContainer) return;
                resepRacikanContainer.style.display =
                    (resepRacikanContainer.style.display === 'none' || resepRacikanContainer.style.display ===
                        '') ?
                    'block' :
                    'none';
            };
        });

        // RESEP
        $(document).ready(function() {
            console.log('[document.ready] Script autocomplete dan jumlah dimuat untuk modal.');

            // Fungsi untuk menginisialisasi autocomplete pada satu input
            function initializeAutocomplete($input) {
                const url = $input.data('url');
                const dropdownId = $input.data('dropdown');
                const $dropdown = $(`#${dropdownId}`);
                const inputId = $input.attr('id');
                const $wrapper = $input.closest('.multi-select-wrapper');
                const $tagsContainer = $wrapper.find('.selected-tags');
                const $hiddenInput = $(`#${inputId}_hidden`);

                if (!$input.length || !$dropdown.length || !$hiddenInput.length) {
                    console.error(
                        `[initializeAutocomplete] Elemen input (${inputId}), dropdown (${dropdownId}), atau hidden input tidak ditemukan`
                    );
                    return;
                }

                console.log(
                    `[initializeAutocomplete] Menginisialisasi autocomplete untuk ${inputId} dengan URL: ${url}`
                );

                // Simpan item terpilih dalam array (ID, bukan teks)
                let selectedItems = [];

                // Fungsi untuk memperbarui input tersembunyi
                function updateHiddenInput() {
                    // Hapus semua input hidden dengan nama yang sama
                    $wrapper.find(`input[name="${$hiddenInput.attr('name')}"]`).remove();
                    // Tambahkan input hidden baru hanya untuk nilai yang valid
                    selectedItems.forEach(value => {
                        if (value && value !== 'null' && value !== '') {
                            $wrapper.append(
                                `<input type="hidden" name="${$hiddenInput.attr('name')}" value="${value}">`
                            );
                        }
                    });
                }

                // Fungsi untuk menambahkan tag
                function addTag(text, value) {
                    if (value && value !== 'null' && value !== '') { // Pastikan nilai valid
                        selectedItems.push(value);
                        const tagHtml = `
                    <span class="tag" data-value="${value}" data-text="${text}">
                        ${text}
                        <span class="remove-tag">×</span>
                    </span>`;
                        $tagsContainer.append(tagHtml);
                        updateHiddenInput();
                        $input.val(''); // Kosongkan input pencarian
                    }
                }

                // Fungsi untuk menghapus tag
                function removeTag(value, index) {
                    selectedItems.splice(index, 1);
                    $tagsContainer.find(`.tag[data-value="${value}"]:eq(${index})`).remove();
                    updateHiddenInput();
                }

                // Event input untuk pencarian autocomplete
                $input.off('input').on('input', function() {
                    const query = $(this).val().trim();
                    console.log(`[initializeAutocomplete] Input: ${inputId}, Value: "${query}"`);
                    if (query.length >= 2) {
                        $.ajax({
                            url: url,
                            data: {
                                term: query
                            },
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                console.log(
                                    `[initializeAutocomplete] Data diterima untuk ${inputId}:`,
                                    data);
                                $dropdown.empty().show();
                                if (data.length) {
                                    data.forEach(item => {
                                        $dropdown.append(
                                            `<div class="dropdown-item" data-value="${item.id}" data-text="${item.text}">${item.text}</div>`
                                        );
                                    });
                                } else {
                                    $dropdown.append(
                                        '<div class="dropdown-item">Tidak ada saran</div>');
                                    console.warn(
                                        `[initializeAutocomplete] Tidak ada data untuk ${inputId} dengan query "${query}"`
                                    );
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error(
                                    `[initializeAutocomplete] Error fetching data untuk ${inputId}:`,
                                    textStatus, errorThrown
                                );
                                $dropdown.empty().show().append(
                                    `<div class="dropdown-item">Error: ${textStatus}</div>`
                                );
                            }
                        });
                    } else {
                        $dropdown.hide();
                    }
                });

                // Event click untuk memilih item dari dropdown
                $dropdown.off('click').on('click', '.dropdown-item', function() {
                    const text = $(this).data('text');
                    const value = $(this).data('value');
                    if (text !== 'Tidak ada saran' && !text.startsWith('Error:') && value && value !==
                        'null' && value !== '') {
                        addTag(text, value);
                        $dropdown.hide();
                    }
                });

                // Event click untuk menghapus tag
                $tagsContainer.off('click').on('click', '.tag', function() {
                    const value = $(this).data('value');
                    const index = $tagsContainer.find('.tag').index(this);
                    removeTag(value, index);
                });
            }

            // Fungsi untuk menginisialisasi input jumlah
            function initializeJumlahInput($input) {
                const inputId = $input.attr('id');
                const $wrapper = $input.closest('.multi-select-wrapper');
                const $tagsContainer = $wrapper.find('.selected-tags');
                const $hiddenInput = $(`#${inputId}_hidden`);

                if (!$input.length || !$tagsContainer.length || !$hiddenInput.length) {
                    console.error(
                        `[initializeJumlahInput] Elemen input (${inputId}), tags container, atau hidden input tidak ditemukan`
                    );
                    return;
                }

                console.log(`[initializeJumlahInput] Menginisialisasi input jumlah untuk ${inputId}`);

                // Simpan item terpilih dalam array
                let selectedItems = [];

                // Fungsi untuk memperbarui input tersembunyi
                function updateHiddenInput() {
                    // Hapus semua input hidden dengan nama yang sama
                    $wrapper.find(`input[name="${$hiddenInput.attr('name')}"]`).remove();
                    // Tambahkan input hidden baru hanya untuk nilai yang valid
                    selectedItems.forEach(value => {
                        if (value && value !== 'null' && value !== '') {
                            $wrapper.append(
                                `<input type="hidden" name="${$hiddenInput.attr('name')}" value="${value}">`
                            );
                        }
                    });
                }

                // Fungsi untuk menambahkan tag
                function addTag(value) {
                    if (value && !isNaN(value) && value > 0) {
                        selectedItems.push(value.toString());
                        const tagHtml = `
                    <span class="tag" data-value="${value}" data-text="${value}">
                        ${value}
                        <span class="remove-tag">×</span>
                    </span>`;
                        $tagsContainer.append(tagHtml);
                        updateHiddenInput();
                        $input.val(''); // Kosongkan input
                    }
                }

                // Fungsi untuk menghapus tag
                function removeTag(value, index) {
                    selectedItems.splice(index, 1);
                    $tagsContainer.find(`.tag[data-value="${value}"]:eq(${index})`).remove();
                    updateHiddenInput();
                }

                // Event keypress untuk menambahkan jumlah saat tekan Enter
                $input.off('keypress').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        e.preventDefault();
                        const value = $(this).val().trim();
                        if (value && !isNaN(value) && value > 0) {
                            addTag(value);
                        } else {
                            console.warn(
                                `[initializeJumlahInput] Input tidak valid untuk ${inputId}: ${value}`
                            );
                        }
                    }
                });

                // Event click untuk menghapus tag
                $tagsContainer.off('click').on('click', '.tag', function() {
                    const value = $(this).data('value');
                    const index = $tagsContainer.find('.tag').index(this);
                    removeTag(value, index);
                });
            }

            // Inisialisasi semua input autocomplete dan jumlah
            function initializeAllInputs() {
                $('.autocomplete-input').each(function() {
                    initializeAutocomplete($(this));
                });
                $('.jumlah-input').each(function() {
                    initializeJumlahInput($(this));
                });
            }

            // Panggil inisialisasi untuk input awal
            initializeAllInputs();

            // Sembunyikan dropdown saat klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest(
                        '.autocomplete-input, .autocomplete-dropdown, .multi-select-wrapper, .jumlah-input'
                    ).length) {
                    $('.autocomplete-dropdown').hide();
                }
            });

            // Bersihkan input hidden kosong sebelum submit form
            $('form').on('submit', function() {
                $(this).find('input[type="hidden"]').each(function() {
                    const value = $(this).val();
                    if (!value || value === 'null' || value === '') {
                        $(this).remove();
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/dokter/modal/modalSoap.blade.php ENDPATH**/ ?>