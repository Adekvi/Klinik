<?php if($soapTerbaru): ?>
    <div class="modal fade" id="editSoap<?php echo e($soapTerbaru->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Ubah Tindakan
                        Dokter
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(url('soap/update/' . $soapTerbaru->id)); ?>" method="post"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="profesi" style="font-weight: bold">Dokter Penanggung Jawab
                                        Pasien</label>
                                    <input type="text" style="font-weight: bold"
                                        value="<?php echo e($soapTerbaru->dokter->nama_dokter); ?>" class="form-control mt-2"
                                        disabled>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label for="">Nama Pasien</label>
                                    <input type="text" name="nama_pasien" id="nama_pasien" class="form-control mt-2"
                                        value="<?php echo e($soapTerbaru->pasien->nama_pasien); ?>" readonly>
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
                                    <input type="text" name="keluhan" value="<?php echo e($soapTerbaru->rm->a_keluhan_utama); ?>"
                                        class="form-control mt-2">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="riwayat-alergi" style="font-weight: bold">Alergi</label>
                                    <select name="a_riwayat_alergi" id="a_riwayat_alergi"
                                        class="form-control mt-2 mb-2 ">
                                        <option value="<?php echo e($soapTerbaru->rm->a_riwayat_alergi ?? 'Tidak Ada'); ?>"
                                            selected>
                                            <?php echo e($soapTerbaru->rm->a_riwayat_alergi ?? 'Tidak Ada'); ?></option>
                                        <option value="Ada">Ada</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="riwayat-penyakit-skrg"><strong>Riwayat Penyakit
                                            Sekarang</strong></label>
                                    <input type="text" name="a_riwayat_penyakit_skrg" id="a_riwayat_penyakit_skrg"
                                        class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Sekarang"
                                        value="<?php echo e($soapTerbaru->rm->a_riwayat_penyakit_skrg ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="isian" style="font-weight: bold; margin-bottom: 10px">Isian Pilihan</label>
                            <div id="isian mt-3 mb-2">
                                <label for="isian-ya">
                                    <input type="radio" name="isian" checked id="isian-ya"
                                        style="transform: scale(1.5); margin-right: 10px" value="auto-anamnesis"
                                        onclick="toggleChangeSoap('alasan-isian-soap', this)"
                                        <?php echo e($soapTerbaru->isian->p_form_isian_pilihan === 'auto-anamnesis' ? 'checked' : ''); ?>>
                                    Auto Anamnesis
                                </label>
                                <label for="isian-tidak">
                                    <input type="radio" name="isian" id="isian-tidak"
                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                        value="Aloanamnesis" onclick="toggleChangeSoap('alasan-isian-soap', this)"
                                        <?php echo e($soapTerbaru->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'checked' : ''); ?>>
                                    Aloanamnesis
                                </label>
                            </div>
                            <div id="alasan-isian-soap"
                                style="<?php echo e($soapTerbaru->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="isian_alasan" name="isian_alasan"
                                    class="form-control mt-2 mb-2" placeholder="Alasan"
                                    value="<?php echo e($soapTerbaru->isian->p_form_isian_pilihan_uraian); ?>">
                            </div>
                        </div>
                        <div class="form-group mt-3 mb-2">
                            <label for="pf" style="font-weight: bold; text-align: center">Pemeriksaan
                                Fisik</label>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="kesadaran" style="width: 30%">1. Kesadaran</label> :
                                <select name="kesadaran" id="kesadaran" class="form-control" style="width: 40%">
                                    <option value="Compos Mentis">Compos Mentis</option>
                                    <option value="Somnolence">Somnolence</option>
                                    <option value="Sopor">Sopor</option>
                                    <option value="Coma">Coma</option>
                                </select>
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="gcs" style="width: 30%">2. GCS</label> :
                                <div class="input-group d-flex mt-3" style="width: 40%">
                                    <input type="text" name="gcs_e" id="gcs_e"
                                        value="<?php echo e($soapTerbaru->isian->gcs_e); ?>" class="form-control"
                                        aria-describedby="basic-addon2" placeholder="E">
                                    <input type="text" name="gcs_m" id="gcs_m"
                                        value="<?php echo e($soapTerbaru->isian->gcs_m); ?>" class="form-control"
                                        aria-describedby="basic-addon2" placeholder="M">
                                    <input type="text" name="gcs_v" id="gcs_v"
                                        value="<?php echo e($soapTerbaru->isian->gcs_v); ?>" class="form-control"
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
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="kepala" style="width: 30%">3. Kepala</label> :
                                <select name="kepala" id="kepala" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-kepala_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_kepala === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_kepala === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-kepala_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_kepala === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-kepala_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-kepala" class="form-control mt-2 mb-2"
                                    value="<?php echo e($soapTerbaru->rm->o_kepala_uraian); ?>"
                                    placeholder="Alasan Kepala Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="mata" style="width: 30%">4. Mata</label> :
                                <select name="mata" id="mata" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-mata_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_mata === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_mata === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-mata_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_mata === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-mata_<?php echo e($soapTerbaru->rm->id); ?>" name="alasan-mata"
                                    value="<?php echo e($soapTerbaru->rm->o_mata_uraian); ?>" class="form-control mt-2 mb-2"
                                    placeholder="Alasan Mata Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="leher" style="width: 30%">5. Leher</label> :
                                <select name="leher" id="leher" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-leher_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option value="Normal"
                                        <?php echo e($soapTerbaru->rm->o_leher === 'Normal' ? 'selected' : ''); ?>>
                                        Normal
                                    </option>
                                    <option value="Abnormal"
                                        <?php echo e($soapTerbaru->rm->o_leher === 'Abnormal' ? 'selected' : ''); ?>>Abnormal
                                    </option>
                                </select>
                            </div>
                            <div id="alasan-leher_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_leher === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-leher_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-leher" value="<?php echo e($soapTerbaru->rm->o_leher_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Leher Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="tht" style="width: 30%">6. THT</label> :
                                <select name="tht" id="tht" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-tht_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option value="Normal"
                                        <?php echo e($soapTerbaru->rm->o_tht === 'Normal' ? 'selected' : ''); ?>>
                                        Normal</option>
                                    <option value="Abnormal"
                                        <?php echo e($soapTerbaru->rm->o_tht === 'Abnormal' ? 'selected' : ''); ?>>
                                        Abnormal
                                    </option>
                                </select>
                            </div>
                            <div id="alasan-tht_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-tht_<?php echo e($soapTerbaru->rm->id); ?>" name="alasan-tht"
                                    value="<?php echo e($soapTerbaru->rm->o_tht_uraian); ?>" class="form-control mt-2 mb-2"
                                    placeholder="Alasan THT Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="thorax" style="width: 30%">7. Thorax</label> :
                                <select name="thorax" id="thorax" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-thorax_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_thorax === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_thorax === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-thorax_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-thorax_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-thorax" value="<?php echo e($soapTerbaru->rm->o_thorax_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Thorax Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="paru" style="width: 30%">8. Paru</label> :
                                <select name="paru" id="paru" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-paru_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_paru === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_paru === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-paru_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_paru === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-paru_<?php echo e($soapTerbaru->rm->id); ?>" name="alasan-paru"
                                    class="form-control mt-2 mb-2" value="<?php echo e($soapTerbaru->rm->o_paru_uraian); ?>"
                                    placeholder="Alasan Paru Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="jantung" style="width: 30%">9. Jantung</label> :
                                <select name="jantung" id="jantung" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-jantung_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_jantung === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_jantung === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-jantung_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_jantung === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-jantung_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-jantung" value="<?php echo e($soapTerbaru->rm->o_jantung_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Jantung Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="abdomen" style="width: 30%">10. Abdomen</label> :
                                <select name="abdomen" id="abdomen" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-abdomen_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_abdomen === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_abdomen === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-abdomen_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_abdomen === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-abdomen_<?php echo e($soapTerbaru->rm->id); ?>"
                                    value="<?php echo e($soapTerbaru->rm->o_abdomen_uraian); ?>" name="alasan-abdomen"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Abdomen Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="ekstremitas" style="width: 30%">11. Ekstremitas</label> :
                                <select name="ekstremitas" id="ekstremitas" class="form-control mt-3"
                                    style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-ekstremitas_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_ekstremitas === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_ekstremitas === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-ekstremitas_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_ekstremitas === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-ekstremitas_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-ekstremitas" value="<?php echo e($soapTerbaru->rm->o_ekstremitas_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Ekstremitas Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="kulit" style="width: 30%">12. Kulit</label> :
                                <select name="kulit" id="kulit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-kulit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_kulit === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_kulit === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-kulit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_kulit === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-kulit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    value="<?php echo e($soapTerbaru->rm->o_kulit_uraian); ?>" name="alasan-kulit"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Kulit Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="lain-lain" style="width: 30%">13. Lain-lain</label> :
                                <input type="text" id="lain" name="lain"
                                    value="<?php echo e($soapTerbaru->rm->lain_lain); ?>" class="form-control mt-3 mb-2"
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
                                                    value="<?php echo e($soapTerbaru->isian->p_tensi); ?>"
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
                                                    value="<?php echo e($soapTerbaru->isian->p_rr); ?>"
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
                                                    value="<?php echo e($soapTerbaru->isian->p_nadi); ?>"
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
                                                    value="<?php echo e($soapTerbaru->isian->spo2); ?>"
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
                                                    value="<?php echo e($soapTerbaru->isian->p_suhu); ?>"
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
                                                    value="<?php echo e($soapTerbaru->isian->p_tb); ?>"
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
                                                    value="<?php echo e($soapTerbaru->isian->p_bb); ?>"
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
                                                    value="<?php echo e($soapTerbaru->isian->p_imt); ?>"
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
                                        $tgllahir = \Carbon\Carbon::parse($soapTerbaru->pasien->tgllahir);
                                        $umur = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                                        $jenis_kelamin = $soapTerbaru->pasien->jekel;
                                        // dd($umur, $jenis_kelamin);
                                    ?>

                                    <?php if($umur > 16 && $jenis_kelamin === 'P'): ?>
                                        
                                        
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="lingkar-kepala-anak">Lingkar Kepala Anak</label>
                                                <div class="input-group">
                                                    <input type="number" name="p_lngkr_kepala_anak"
                                                        id="p_lngkr_kepala_anak"
                                                        value="<?php echo e($soapTerbaru->isian->p_lngkr_kepala_anak); ?>"
                                                        class="form-control mt-2 mb-2"
                                                        aria-describedby="basic-addon2">
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
                                                        value="<?php echo e($soapTerbaru->isian->p_lngkr_lengan_anc); ?>"
                                                        class="form-control mt-2 mb-2"
                                                        aria-describedby="basic-addon2">
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
                                        <label>Diagnosa Primer</label>
                                        <?php $__empty_1 = true; $__currentLoopData = $diagnosaPrimer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <input type="text" id="soap_a_<?php echo e($index); ?>"
                                                name="soap_a[<?php echo e($index); ?>][diagnosa_primer]"
                                                class="soap_a form-control mt-2 mb-2" value="<?php echo e($diag); ?>"
                                                placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-primer-<?php echo e($index); ?>"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <input type="text" id="soap_a_0" name="soap_a[0][diagnosa_primer]"
                                                class="soap_a form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-primer-0"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-6">
                                        <label>Diagnosa Sekunder</label>
                                        <?php $__empty_1 = true; $__currentLoopData = $diagnosaSekunder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <input type="text" id="soap_a_b_<?php echo e($index); ?>"
                                                name="soap_a_b[<?php echo e($index); ?>][diagnosa_sekunder]"
                                                class="soap_a_b form-control mt-2 mb-2" value="<?php echo e($diag); ?>"
                                                placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-sekunder-<?php echo e($index); ?>"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <input type="text" id="soap_a_b_0"
                                                name="soap_a_b[0][diagnosa_sekunder]"
                                                class="soap_a_b form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-sekunder-0"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- resources/views/dokter/modal/editSoap.blade.php -->
                        <div class="form-group mt-3 mb-2">
                            <label for="soap_p_0"
                                style="font-weight: bold; margin-top: 10px; margin-bottom: 5px; width: 100%; cursor: pointer;"
                                onclick="toggleObatContainer()">
                                Pilih Obat (P)
                            </label>
                            <div class="resep" id="edit-resep">
                                <?php if(!empty($resep) || !empty($resepJenis) || !empty($resepAturan) || !empty($resepAnjuran) || !empty($resepJumlah)): ?>
                                    <?php
                                        $entryCount = count($resepJumlah); // 2 entri
                                        $resepArray = is_array($resep)
                                            ? array_chunk($resep, ceil(count($resep) / $entryCount))
                                            : [];
                                        $resepJenisArray = is_array($resepJenis)
                                            ? array_chunk($resepJenis, ceil(count($resepJenis) / $entryCount))
                                            : [];
                                        $resepAturanArray = is_array($resepAturan)
                                            ? array_chunk($resepAturan, ceil(count($resepAturan) / $entryCount))
                                            : [];
                                        $resepAnjuranArray = is_array($resepAnjuran)
                                            ? array_chunk($resepAnjuran, ceil(count($resepAnjuran) / $entryCount))
                                            : [];
                                    ?>
                                    <?php for($index = 0; $index < $entryCount; $index++): ?>
                                        <div class="entry-group" id="edit-entry_<?php echo e($index); ?>">
                                            <?php for($subIndex = 0; $subIndex < (isset($resepJumlah[$index]) ? count($resepJumlah[$index]) : 0); $subIndex++): ?>
                                                <!-- Nama Obat -->
                                                <div class="input-row"
                                                    id="edit-namaObatContainer_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <label for="edit-resep_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                        style="min-width: 100px;">Nama Obat</label>
                                                    <span>:</span>
                                                    <div class="input-wrapper">
                                                        <div class="multi-select-wrapper form-control"
                                                            data-input-id="edit-resep_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                            <div class="selected-tags"
                                                                id="edit-resep_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_tags">
                                                                <?php if(isset($resepArray[$index][$subIndex])): ?>
                                                                    <span class="tag"
                                                                        data-value="<?php echo e($resepArray[$index][$subIndex]); ?>"><?php echo e($resepArray[$index][$subIndex]); ?>

                                                                        <i class="fas fa-times remove-tag"></i></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="text"
                                                                class="autocomplete-input multi-select-input"
                                                                id="edit-resep_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                                placeholder="Cari Obat" autocomplete="off"
                                                                data-url="<?php echo e(url('/resep-autocomplete')); ?>"
                                                                data-dropdown="edit-dropdown-resep_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                        </div>
                                                        <input type="hidden"
                                                            name="soap_p[<?php echo e($index); ?>][resep][]"
                                                            id="edit-resep_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_hidden"
                                                            value="<?php echo e(isset($resepArray[$index][$subIndex]) ? $resepArray[$index][$subIndex] : ''); ?>">
                                                        <div id="edit-dropdown-resep_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                            class="dropdown-menu autocomplete-dropdown"></div>
                                                        <p class="text-warning"
                                                            style="font-style: italic; font-size: 12px">
                                                            *Bisa memilih lebih dari 1 obat
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Jenis Obat -->
                                                <div class="input-row"
                                                    id="edit-jenisObatContainer_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <label
                                                        for="edit-jenis_obat_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                        style="min-width: 100px;">Jenis Obat</label>
                                                    <span>:</span>
                                                    <div class="input-wrapper">
                                                        <div class="multi-select-wrapper form-control"
                                                            data-input-id="edit-jenis_obat_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                            <div class="selected-tags"
                                                                id="edit-jenis_obat_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_tags">
                                                                <?php if(isset($resepJenisArray[$index][$subIndex])): ?>
                                                                    <span class="tag"
                                                                        data-value="<?php echo e($resepJenisArray[$index][$subIndex]); ?>"><?php echo e($resepJenisArray[$index][$subIndex]); ?>

                                                                        <i class="fas fa-times remove-tag"></i></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="text"
                                                                class="autocomplete-input multi-select-input"
                                                                id="edit-jenis_obat_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                                placeholder="Cari Jenis Obat" autocomplete="off"
                                                                data-url="<?php echo e(url('jenis-autocomplete')); ?>"
                                                                data-dropdown="edit-dropdown-jenis_obat_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                        </div>
                                                        <input type="hidden"
                                                            name="soap_p[<?php echo e($index); ?>][jenisobat][]"
                                                            id="edit-jenis_obat_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_hidden"
                                                            value="<?php echo e(isset($resepJenisArray[$index][$subIndex]) ? $resepJenisArray[$index][$subIndex] : ''); ?>">
                                                        <div id="edit-dropdown-jenis_obat_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                            class="dropdown-menu autocomplete-dropdown"></div>
                                                        <p class="text-warning"
                                                            style="font-style: italic; font-size: 12px">
                                                            *Bisa memilih lebih dari 1 jenis obat
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Aturan Pakai -->
                                                <div class="input-row"
                                                    id="edit-aturanContainer_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <label
                                                        for="edit-aturan_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                        style="min-width: 100px">Aturan Pakai</label>
                                                    <span>:</span>
                                                    <div class="input-wrapper">
                                                        <div class="multi-select-wrapper form-control"
                                                            data-input-id="edit-aturan_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                            <div class="selected-tags"
                                                                id="edit-aturan_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_tags">
                                                                <?php if(isset($resepAturanArray[$index][$subIndex])): ?>
                                                                    <span class="tag"
                                                                        data-value="<?php echo e($resepAturanArray[$index][$subIndex]); ?>"><?php echo e($resepAturanArray[$index][$subIndex]); ?>

                                                                        <i class="fas fa-times remove-tag"></i></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="text"
                                                                class="autocomplete-input multi-select-input"
                                                                id="edit-aturan_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                                placeholder="Cari Aturan Pakai" autocomplete="off"
                                                                data-url="<?php echo e(url('aturan-autocomplete')); ?>"
                                                                data-dropdown="edit-dropdown-aturan_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                        </div>
                                                        <input type="hidden"
                                                            name="soap_p[<?php echo e($index); ?>][aturan][]"
                                                            id="edit-aturan_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_hidden"
                                                            value="<?php echo e(isset($resepAturanArray[$index][$subIndex]) ? $resepAturanArray[$index][$subIndex] : ''); ?>">
                                                        <div id="edit-dropdown-aturan_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                            class="dropdown-menu autocomplete-dropdown"></div>
                                                        <p class="text-warning"
                                                            style="font-style: italic; font-size: 12px">
                                                            *Bisa memilih lebih dari 1 aturan pakai
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Anjuran Minum -->
                                                <div class="input-row"
                                                    id="edit-anjuranMinumContainer_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <label
                                                        for="edit-anjuran_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                        style="min-width: 100px">Anjuran Minum</label>
                                                    <span>:</span>
                                                    <div class="input-wrapper">
                                                        <div class="multi-select-wrapper form-control"
                                                            data-input-id="edit-anjuran_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                            <div class="selected-tags"
                                                                id="edit-anjuran_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_tags">
                                                                <?php if(isset($resepAnjuranArray[$index][$subIndex])): ?>
                                                                    <span class="tag"
                                                                        data-value="<?php echo e($resepAnjuranArray[$index][$subIndex]); ?>"><?php echo e($resepAnjuranArray[$index][$subIndex]); ?>

                                                                        <i class="fas fa-times remove-tag"></i></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="text"
                                                                class="autocomplete-input multi-select-input"
                                                                id="edit-anjuran_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                                placeholder="Cari Anjuran Minum" autocomplete="off"
                                                                data-url="<?php echo e(url('anjuran-autocomplete')); ?>"
                                                                data-dropdown="edit-dropdown-anjuran_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                        </div>
                                                        <input type="hidden"
                                                            name="soap_p[<?php echo e($index); ?>][anjuran][]"
                                                            id="edit-anjuran_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_hidden"
                                                            value="<?php echo e(isset($resepAnjuranArray[$index][$subIndex]) ? $resepAnjuranArray[$index][$subIndex] : ''); ?>">
                                                        <div id="edit-dropdown-anjuran_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                            class="dropdown-menu autocomplete-dropdown"></div>
                                                        <p class="text-warning"
                                                            style="font-style: italic; font-size: 12px">
                                                            *Bisa memilih lebih dari 1 anjuran minum
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Jumlah Masing-masing Obat -->
                                                <div class="input-row"
                                                    id="edit-jumlahObatContainer_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <label
                                                        for="edit-jumlah_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                        style="min-width: 100px">Jumlah</label>
                                                    <span>:</span>
                                                    <div class="input-wrapper">
                                                        <div class="multi-select-wrapper form-control"
                                                            data-input-id="edit-jumlah_<?php echo e($index); ?>_<?php echo e($subIndex); ?>">
                                                            <div class="selected-tags"
                                                                id="edit-jumlah_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_tags">
                                                                <?php if(isset($resepJumlah[$index][$subIndex])): ?>
                                                                    <span class="tag"
                                                                        data-value="<?php echo e($resepJumlah[$index][$subIndex]); ?>"><?php echo e($resepJumlah[$index][$subIndex]); ?>

                                                                        <i class="fas fa-times remove-tag"></i></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="number"
                                                                class="multi-select-input jumlah-input"
                                                                id="edit-jumlah_<?php echo e($index); ?>_<?php echo e($subIndex); ?>"
                                                                placeholder="Masukkan Jumlah" min="1">
                                                        </div>
                                                        <input type="hidden"
                                                            name="soap_p[<?php echo e($index); ?>][jumlah][]"
                                                            id="edit-jumlah_<?php echo e($index); ?>_<?php echo e($subIndex); ?>_hidden"
                                                            value="<?php echo e(isset($resepJumlah[$index][$subIndex]) ? $resepJumlah[$index][$subIndex] : ''); ?>">
                                                        <p class="text-warning"
                                                            style="font-style: italic; font-size: 12px">
                                                            *Bisa memasukkan lebih dari 1 jumlah (tekan Enter untuk
                                                            menambah)
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endfor; ?>
                                <?php else: ?>
                                    <!-- Form kosong jika tidak ada data -->
                                    <div class="input-row" id="edit-namaObatContainer_0_0"
                                        style="display: flex; align-items: center; gap: 5px;">
                                        <label for="edit-resep_0_0" style="min-width: 100px;">Nama Obat</label>
                                        <span>:</span>
                                        <div class="input-wrapper">
                                            <div class="multi-select-wrapper form-control"
                                                data-input-id="edit-resep_0_0">
                                                <div class="selected-tags" id="edit-resep_0_0_tags"></div>
                                                <input type="text" class="autocomplete-input multi-select-input"
                                                    id="edit-resep_0_0" placeholder="Cari Obat" autocomplete="off"
                                                    data-url="<?php echo e(url('/resep-autocomplete')); ?>"
                                                    data-dropdown="edit-dropdown-resep_0_0">
                                            </div>
                                            <input type="hidden" name="soap_p[0][resep][]"
                                                id="edit-resep_0_0_hidden">
                                            <div id="edit-dropdown-resep_0_0"
                                                class="dropdown-menu autocomplete-dropdown"></div>
                                            <p class="text-warning" style="font-style: italic; font-size: 12px">
                                                *Bisa memilih lebih dari 1 obat
                                            </p>
                                        </div>
                                    </div>
                                    <div class="input-row" id="edit-jenisObatContainer_0_0"
                                        style="display: flex; align-items: center; gap: 5px;">
                                        <label for="edit-jenis_obat_0_0" style="min-width: 100px;">Jenis Obat</label>
                                        <span>:</span>
                                        <div class="input-wrapper">
                                            <div class="multi-select-wrapper form-control"
                                                data-input-id="edit-jenis_obat_0_0">
                                                <div class="selected-tags" id="edit-jenis_obat_0_0_tags"></div>
                                                <input type="text" class="autocomplete-input multi-select-input"
                                                    id="edit-jenis_obat_0_0" placeholder="Cari Jenis Obat"
                                                    autocomplete="off" data-url="<?php echo e(url('jenis-autocomplete')); ?>"
                                                    data-dropdown="edit-dropdown-jenis_obat_0_0">
                                            </div>
                                            <input type="hidden" name="soap_p[0][jenisobat][]"
                                                id="edit-jenis_obat_0_0_hidden">
                                            <div id="edit-dropdown-jenis_obat_0_0"
                                                class="dropdown-menu autocomplete-dropdown"></div>
                                            <p class="text-warning" style="font-style: italic; font-size: 12px">
                                                *Bisa memilih lebih dari 1 jenis obat
                                            </p>
                                        </div>
                                    </div>
                                    <div class="input-row" id="edit-aturanContainer_0_0"
                                        style="display: flex; align-items: center; gap: 5px;">
                                        <label for="edit-aturan_0_0" style="min-width: 100px">Aturan Pakai</label>
                                        <span>:</span>
                                        <div class="input-wrapper">
                                            <div class="multi-select-wrapper form-control"
                                                data-input-id="edit-aturan_0_0">
                                                <div class="selected-tags" id="edit-aturan_0_0_tags"></div>
                                                <input type="text" class="autocomplete-input multi-select-input"
                                                    id="edit-aturan_0_0" placeholder="Cari Aturan Pakai"
                                                    autocomplete="off" data-url="<?php echo e(url('aturan-autocomplete')); ?>"
                                                    data-dropdown="edit-dropdown-aturan_0_0">
                                            </div>
                                            <input type="hidden" name="soap_p[0][aturan][]"
                                                id="edit-aturan_0_0_hidden">
                                            <div id="edit-dropdown-aturan_0_0"
                                                class="dropdown-menu autocomplete-dropdown"></div>
                                            <p class="text-warning" style="font-style: italic; font-size: 12px">
                                                *Bisa memilih lebih dari 1 aturan pakai
                                            </p>
                                        </div>
                                    </div>
                                    <div class="input-row" id="edit-anjuranMinumContainer_0_0"
                                        style="display: flex; align-items: center; gap: 5px;">
                                        <label for="edit-anjuran_0_0" style="min-width: 100px">Anjuran Minum</label>
                                        <span>:</span>
                                        <div class="input-wrapper">
                                            <div class="multi-select-wrapper form-control"
                                                data-input-id="edit-anjuran_0_0">
                                                <div class="selected-tags" id="edit-anjuran_0_0_tags"></div>
                                                <input type="text" class="autocomplete-input multi-select-input"
                                                    id="edit-anjuran_0_0" placeholder="Cari Anjuran Minum"
                                                    autocomplete="off" data-url="<?php echo e(url('anjuran-autocomplete')); ?>"
                                                    data-dropdown="edit-dropdown-anjuran_0_0">
                                            </div>
                                            <input type="hidden" name="soap_p[0][anjuran][]"
                                                id="edit-anjuran_0_0_hidden">
                                            <div id="edit-dropdown-anjuran_0_0"
                                                class="dropdown-menu autocomplete-dropdown"></div>
                                            <p class="text-warning" style="font-style: italic; font-size: 12px">
                                                *Bisa memilih lebih dari 1 anjuran minum
                                            </p>
                                        </div>
                                    </div>
                                    <div class="input-row" id="edit-jumlahObatContainer_0_0"
                                        style="display: flex; align-items: center; gap: 5px;">
                                        <label for="edit-jumlah_0_0" style="min-width: 100px">Jumlah</label>
                                        <span>:</span>
                                        <div class="input-wrapper">
                                            <div class="multi-select-wrapper form-control"
                                                data-input-id="edit-jumlah_0_0">
                                                <div class="selected-tags" id="edit-jumlah_0_0_tags"></div>
                                                <input type="number" class="multi-select-input jumlah-input"
                                                    id="edit-jumlah_0_0" placeholder="Masukkan Jumlah"
                                                    min="1">
                                            </div>
                                            <input type="hidden" name="soap_p[0][jumlah][]"
                                                id="edit-jumlah_0_0_hidden">
                                            <p class="text-warning" style="font-style: italic; font-size: 12px">
                                                *Bisa memasukkan lebih dari 1 jumlah (tekan Enter untuk menambah)
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <button type="button" class="btn btn-outline-primary" onclick="editAddColumn()"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                    data-bs-html="true"
                                    data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Tambah Obat</span>">
                                    <i class="fa-solid fa-pills"></i>
                                </button>

                                <label for=""
                                    style="font-weight: bold; margin-top: 20px; margin-bottom: 5px; width: 100%; cursor: pointer"
                                    onclick="toggleRacikanContainer()">Resep Racikan</label>
                                <div class="racikan" id="edit-resepRacikan">
                                    <textarea name="ObatRacikan" id="edit-ObatRacikan" cols="30" rows="5" class="form-control mb-2 mt-2"><?php echo e($soapTerbaru->ObatRacikan ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edukasi" style="font-weight: bold">Edukasi</label>
                            <input type="text" class="form-control mt-2 mb-2" name="edukasi" id="edukasi"
                                placeholder="Edukasi" value="<?php echo e($soapTerbaru->edukasi); ?>">
                        </div>
                        <div class="form-group">
                            <label for="rujuk" style="font-weight: bold">Rencana Tindak Lanjut</label>
                            <select name="rujuk" id="rujuk" class="form-control mt-2 mb-2">
                                <option value="Tidak Ada" <?php echo e($soapTerbaru->rujuk == 'Tidak Ada' ? 'selected' : ''); ?>>
                                    Tidak Ada</option>
                                <option value="Rumah Sakit"
                                    <?php echo e($soapTerbaru->rujuk == 'Rumah Sakit' ? 'selected' : ''); ?>>Rumah Sakit</option>
                                <option value="Laborat" <?php echo e($soapTerbaru->rujuk == 'Laborat' ? 'selected' : ''); ?>>
                                    Laborat</option>
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
<?php endif; ?>

<?php $__env->startPush('style'); ?>
    <style>
        #edit-resep,
        .input-wrapper {
            overflow: visible !important;
            position: relative;
            flex-grow: 1;
        }

        .dropdown-menu-autocomplete {
            position: absolute;
            top: 100%;
            /* Dropdown akan muncul tepat di bawah input */
            left: 0;
            z-index: 1000 !important;
            width: 100%;
            max-height: 250px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
            display: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-top: 2px;
            /* Sedikit jarak dari input */
        }

        /* Pastikan row tidak memotong dropdown */
        .input-row {
            position: static;
            /* atau relative */
            overflow: visible !important;
            z-index: auto;
        }

        .racikan {
            display: flex;
            flex-direction: column;
            margin-top: 0;
        }

        #edit-racikan {
            display: block;
            /* Menampilkan elemen secara default */
        }

        .input-row label {
            width: 150px;
            margin-right: 20px;
            /* font-weight: bold; */
            flex-shrink: 0;
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

        .input-group {
            display: flex;
            align-soapTerbarus: center;
        }

        .input-group input {
            flex-grow: 1;
        }

        .input-group .input-group-append {
            display: flex;
            align-soapTerbarus: center;
        }

        .input-group .input-group-text {
            background-color: rgb(228, 228, 228);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <!-- JS Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>

    <script>
        // DIAGNOSA - Versi yang diperbaiki
        document.addEventListener('DOMContentLoaded', function() {
            function showDiagnosaDropdown(inputElement, dropdownElement, results) {
                dropdownElement.innerHTML = '';
                if (results.length === 0) {
                    dropdownElement.style.display = 'none';
                    return;
                }

                results.forEach(function(result) {
                    const option = document.createElement('div');
                    option.classList.add('dropdown-item');
                    option.textContent = result.text;
                    option.dataset.id = result.id;
                    option.style.cursor = 'pointer';

                    option.addEventListener('click', function() {
                        inputElement.value = result.text;
                        dropdownElement.style.display = 'none';
                    });

                    dropdownElement.appendChild(option);
                });

                dropdownElement.style.display = 'block';
            }

            function searchDiagnosa(term, callback) {
                if (term.length < 3) {
                    callback([]);
                    return;
                }

                fetch(`/search-diagnosa?term=${encodeURIComponent(term)}`)
                    .then(response => response.json())
                    .then(data => callback(data))
                    .catch(error => {
                        console.error('Error fetching diagnosa:', error);
                        callback([]);
                    });
            }

            function initDiagnosaAutocomplete(prefix, dropdownPrefix) {
                document.querySelectorAll(`[id^="${prefix}"]`).forEach(input => {
                    const index = input.id.replace(prefix, '');
                    const dropdownElement = document.getElementById(`${dropdownPrefix}${index}`);

                    if (dropdownElement) {
                        input.addEventListener('input', function() {
                            searchDiagnosa(this.value, function(results) {
                                showDiagnosaDropdown(input, dropdownElement, results);
                            });
                        });

                        document.addEventListener('click', function(e) {
                            if (!input.contains(e.target) && !dropdownElement.contains(e.target)) {
                                dropdownElement.style.display = 'none';
                            }
                        });
                    }
                });
            }

            initDiagnosaAutocomplete('soap_a_', 'dropdown-diagnosa-primer-');
            initDiagnosaAutocomplete('soap_a_b_', 'dropdown-diagnosa-sekunder-');
        });

        // RESEP OBAT
        // resources/js/editSoap.js
        document.addEventListener('DOMContentLoaded', function() {
            function initializeMultiSelect(inputId, hiddenInputId, dropdownId, url, existingValues = []) {
                const input = document.getElementById(inputId);
                const hiddenInput = document.getElementById(hiddenInputId);
                const dropdown = document.getElementById(dropdownId);
                const tagsContainer = document.getElementById(`${inputId}_tags`);
                let selectedValues = existingValues.length ? existingValues : hiddenInput.value ? hiddenInput.value
                    .split(',') : [];

                // Tampilkan nilai default sebagai tag
                selectedValues.forEach(value => {
                    if (value) {
                        const tag = document.createElement('span');
                        tag.className = 'tag';
                        tag.dataset.value = value;
                        tag.innerHTML = `${value} <i class="fas fa-times remove-tag"></i>`;
                        tagsContainer.appendChild(tag);
                    }
                });

                // Update hidden input
                function updateHiddenInput() {
                    hiddenInput.value = selectedValues.join(',');
                }

                // Event listener untuk input autocomplete
                input.addEventListener('input', function() {
                    const query = input.value;
                    if (query.length < 2) {
                        dropdown.style.display = 'none';
                        return;
                    }

                    fetch(`${url}?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            dropdown.innerHTML = '';
                            data.forEach(item => {
                                const li = document.createElement('li');
                                li.textContent = item
                                    .value; // Sesuaikan dengan struktur data dari endpoint
                                li.addEventListener('click', () => {
                                    if (!selectedValues.includes(item.value)) {
                                        selectedValues.push(item.value);
                                        const tag = document.createElement('span');
                                        tag.className = 'tag';
                                        tag.dataset.value = item.value;
                                        tag.innerHTML =
                                            `${item.value} <i class="fas fa-times remove-tag"></i>`;
                                        tagsContainer.appendChild(tag);
                                        updateHiddenInput();
                                    }
                                    input.value = '';
                                    dropdown.style.display = 'none';
                                });
                                dropdown.appendChild(li);
                            });
                            dropdown.style.display = data.length ? 'block' : 'none';
                        });
                });

                // Event listener untuk menghapus tag
                tagsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-tag')) {
                        const tag = e.target.parentElement;
                        const value = tag.dataset.value;
                        selectedValues = selectedValues.filter(val => val !== value);
                        tag.remove();
                        updateHiddenInput();
                    }
                });

                // Event listener untuk jumlah (tekan Enter)
                if (input.type === 'number') {
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter' && input.value) {
                            selectedValues.push(input.value);
                            const tag = document.createElement('span');
                            tag.className = 'tag';
                            tag.dataset.value = input.value;
                            tag.innerHTML = `${input.value} <i class="fas fa-times remove-tag"></i>`;
                            tagsContainer.appendChild(tag);
                            updateHiddenInput();
                            input.value = '';
                        }
                    });
                }
            }

            // Inisialisasi multi-select untuk setiap entri
            document.querySelectorAll('.multi-select-wrapper').forEach(wrapper => {
                const inputId = wrapper.dataset.inputId;
                const hiddenInputId = `${inputId}_hidden`;
                const dropdownId = wrapper.dataset.dropdown ||
                    `edit-dropdown-${inputId.split('_').slice(1).join('_')}`;
                const url = wrapper.querySelector('.autocomplete-input')?.dataset.url || '';
                const existingValues = wrapper.querySelector('.selected-tags').children.length ?
                    Array.from(wrapper.querySelector('.selected-tags').children).map(tag => tag.dataset
                        .value) : [];
                initializeMultiSelect(inputId, hiddenInputId, dropdownId, url, existingValues);
            });

            // Fungsi untuk menambah kolom baru
            window.editAddColumn = function() {
                const container = document.getElementById('edit-resep');
                const index = container.querySelectorAll('.input-row[id*="edit-namaObatContainer"]').length;
                const newRow = `
                        <div class="input-row" id="edit-namaObatContainer_${index}" style="display: flex; align-items: center; gap: 5px;">
                            <label for="edit-resep_${index}" style="min-width: 100px;">Nama Obat</label>
                            <span>:</span>
                            <div class="input-wrapper">
                                <div class="multi-select-wrapper form-control" data-input-id="edit-resep_${index}">
                                    <div class="selected-tags" id="edit-resep_${index}_tags"></div>
                                    <input type="text" class="autocomplete-input multi-select-input" id="edit-resep_${index}"
                                        placeholder="Cari Obat" autocomplete="off" data-url="<?php echo e(url('/resep-autocomplete')); ?>"
                                        data-dropdown="edit-dropdown-resep_${index}">
                                </div>
                                <input type="hidden" name="soap_p[${index}][resep][]" id="edit-resep_${index}_hidden">
                                <div id="edit-dropdown-resep_${index}" class="dropdown-menu autocomplete-dropdown"></div>
                                <p class="text-warning" style="font-style: italic; font-size: 12px">
                                    *Bisa memilih lebih dari 1 obat
                                </p>
                            </div>
                        </div>
                        <div class="input-row" id="edit-jenisObatContainer_${index}" style="display: flex; align-items: center; gap: 5px;">
                            <label for="edit-jenis_obat_${index}" style="min-width: 100px;">Jenis Obat</label>
                            <span>:</span>
                            <div class="input-wrapper">
                                <div class="multi-select-wrapper form-control" data-input-id="edit-jenis_obat_${index}">
                                    <div class="selected-tags" id="edit-jenis_obat_${index}_tags"></div>
                                    <input type="text" class="autocomplete-input multi-select-input" id="edit-jenis_obat_${index}"
                                        placeholder="Cari Jenis Obat" autocomplete="off" data-url="<?php echo e(url('jenis-autocomplete')); ?>"
                                        data-dropdown="edit-dropdown-jenis_obat_${index}">
                                </div>
                                <input type="hidden" name="soap_p[${index}][jenisobat][]" id="edit-jenis_obat_${index}_hidden">
                                <div id="edit-dropdown-jenis_obat_${index}" class="dropdown-menu autocomplete-dropdown"></div>
                                <p class="text-warning" style="font-style: italic; font-size: 12px">
                                    *Bisa memilih lebih dari 1 jenis obat
                                </p>
                            </div>
                        </div>
                        <div class="input-row" id="edit-aturanContainer_${index}" style="display: flex; align-items: center; gap: 5px;">
                            <label for="edit-aturan_${index}" style="min-width: 100px">Aturan Pakai</label>
                            <span>:</span>
                            <div class="input-wrapper">
                                <div class="multi-select-wrapper form-control" data-input-id="edit-aturan_${index}">
                                    <div class="selected-tags" id="edit-aturan_${index}_tags"></div>
                                    <input type="text" class="autocomplete-input multi-select-input" id="edit-aturan_${index}"
                                        placeholder="Cari Aturan Pakai" autocomplete="off" data-url="<?php echo e(url('aturan-autocomplete')); ?>"
                                        data-dropdown="edit-dropdown-aturan_${index}">
                                </div>
                                <input type="hidden" name="soap_p[${index}][aturan][]" id="edit-aturan_${index}_hidden">
                                <div id="edit-dropdown-aturan_${index}" class="dropdown-menu autocomplete-dropdown"></div>
                                <p class="text-warning" style="font-style: italic; font-size: 12px">
                                    *Bisa memilih lebih dari 1 aturan pakai
                                </p>
                            </div>
                        </div>
                        <div class="input-row" id="edit-anjuranMinumContainer_${index}" style="display: flex; align-items: center; gap: 5px;">
                            <label for="edit-anjuran_${index}" style="min-width: 100px">Anjuran Minum</label>
                            <span>:</span>
                            <div class="input-wrapper">
                                <div class="multi-select-wrapper form-control" data-input-id="edit-anjuran_${index}">
                                    <div class="selected-tags" id="edit-anjuran_${index}_tags"></div>
                                    <input type="text" class="autocomplete-input multi-select-input" id="edit-anjuran_${index}"
                                        placeholder="Cari Anjuran Minum" autocomplete="off" data-url="<?php echo e(url('anjuran-autocomplete')); ?>"
                                        data-dropdown="edit-dropdown-anjuran_${index}">
                                </div>
                                <input type="hidden" name="soap_p[${index}][anjuran][]" id="edit-anjuran_${index}_hidden">
                                <div id="edit-dropdown-anjuran_${index}" class="dropdown-menu autocomplete-dropdown"></div>
                                <p class="text-warning" style="font-style: italic; font-size: 12px">
                                    *Bisa memilih lebih dari 1 anjuran minum
                                </p>
                            </div>
                        </div>
                        <div class="input-row" id="edit-jumlahObatContainer_${index}" style="display: flex; align-items: center; gap: 5px;">
                            <label for="edit-jumlah_${index}" style="min-width: 100px">Jumlah</label>
                            <span>:</span>
                            <div class="input-wrapper">
                                <div class="multi-select-wrapper form-control" data-input-id="edit-jumlah_${index}">
                                    <div class="selected-tags" id="edit-jumlah_${index}_tags"></div>
                                    <input type="number" class="multi-select-input jumlah-input" id="edit-jumlah_${index}"
                                        placeholder="Masukkan Jumlah" min="1">
                                </div>
                                <input type="hidden" name="soap_p[${index}][jumlah][]" id="edit-jumlah_${index}_hidden">
                                <p class="text-warning" style="font-style: italic; font-size: 12px">
                                    *Bisa memasukkan lebih dari 1 jumlah (tekan Enter untuk menambah)
                                </p>
                            </div>
                        </div>
                        <hr>
                    `;
                container.insertAdjacentHTML('beforeend', newRow);
                initializeMultiSelect(`edit-resep_${index}`, `edit-resep_${index}_hidden`,
                    `edit-dropdown-resep_${index}`, '<?php echo e(url('/resep-autocomplete')); ?>');
                initializeMultiSelect(`edit-jenis_obat_${index}`, `edit-jenis_obat_${index}_hidden`,
                    `edit-dropdown-jenis_obat_${index}`, '<?php echo e(url('/jenis-autocomplete')); ?>');
                initializeMultiSelect(`edit-aturan_${index}`, `edit-aturan_${index}_hidden`,
                    `edit-dropdown-aturan_${index}`, '<?php echo e(url('/aturan-autocomplete')); ?>');
                initializeMultiSelect(`edit-anjuran_${index}`, `edit-anjuran_${index}_hidden`,
                    `edit-dropdown-anjuran_${index}`, '<?php echo e(url('/anjuran-autocomplete')); ?>');
                initializeMultiSelect(`edit-jumlah_${index}`, `edit-jumlah_${index}_hidden`,
                    `edit-jumlah_${index}`, '');
            };
        });

        // RESEP
        function toggleObatContainer() {
            // Ambil elemen dengan id "resep"
            var resepContainer = document.getElementById('edit-resep');

            // Cek status saat ini (apakah tersembunyi atau terlihat)
            if (resepContainer.style.display === 'none' || resepContainer.style.display === '') {
                // Jika tersembunyi, tampilkan
                resepContainer.style.display = 'block';
            } else {
                // Jika terlihat, sembunyikan
                resepContainer.style.display = 'none';
            }
        }

        // RACIKAN
        function toggleRacikanContainer() {
            // Ambil elemen dengan id "resepRacikan"
            var resepRacikanContainer = document.getElementById('edit-resepRacikan');

            // Cek status saat ini (apakah tersembunyi atau terlihat)
            if (resepRacikanContainer.style.display === 'none' || resepRacikanContainer.style.display === '') {
                // Jika tersembunyi, tampilkan
                resepRacikanContainer.style.display = 'block';
            } else {
                // Jika terlihat, sembunyikan
                resepRacikanContainer.style.display = 'none';
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/dokter/modal/editSoap.blade.php ENDPATH**/ ?>