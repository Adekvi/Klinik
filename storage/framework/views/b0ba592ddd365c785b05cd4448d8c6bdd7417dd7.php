<?php if($soapTerbaru): ?>
    <div class="modal fade" id="editSoap<?php echo e($soapTerbaru['id']); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
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
                    <form action="<?php echo e(route('soap.update', ['id' => $id, 'soap_id' => $soapTerbaru->id])); ?>"
                        method="POST" enctype="multipart/form-data" class="text-start edit-soap-form"
                        id="edit-soap-form-<?php echo e($soapTerbaru->id); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profesi" style="font-weight: bold">Dokter Penanggung Jawab
                                        Pasien</label>
                                    <input type="text" style="font-weight: bold"
                                        value="<?php echo e($soapTerbaru->dokter->nama_dokter); ?>" class="form-control mt-2"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                            <label for="isian_edit" style="font-weight: bold; margin-bottom: 10px">Isian Pilihan</label>
                            <div id="isian_edit mt-3 mb-2">
                                <label for="isian-ya_edit">
                                    <input type="radio" name="isian" checked id="isian-ya_edit"
                                        style="transform: scale(1.5); margin-right: 10px" value="auto-anamnesis"
                                        onclick="toggleChangeSoapEdit('alasan-isian-soap_edit', this)"
                                        <?php echo e($soapTerbaru->isian->p_form_isian_pilihan === 'auto-anamnesis' ? 'checked' : ''); ?>>
                                    Auto Anamnesis
                                </label>
                                <label for="isian-tidak_edit">
                                    <input type="radio" name="isian" id="isian-tidak_edit"
                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                        value="Aloanamnesis"
                                        onclick="toggleChangeSoapEdit('alasan-isian-soap_edit', this)"
                                        <?php echo e($soapTerbaru->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'checked' : ''); ?>>
                                    Aloanamnesis
                                </label>
                            </div>
                            <div id="alasan-isian-soap_edit"
                                style="<?php echo e($soapTerbaru->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="isian_alasan_edit" name="isian_alasan"
                                    class="form-control mt-2 mb-2" placeholder="Alasan"
                                    value="<?php echo e($soapTerbaru->isian->p_form_isian_pilihan_uraian); ?>">
                            </div>
                        </div>
                        <div class="form-group mt-3 mb-2">
                            <label for="pf" style="font-weight: bold; text-align: center">Pemeriksaan
                                Fisik</label>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="kesadaran_edit" style="width: 30%">1. Kesadaran</label> :
                                <select name="kesadaran" id="kesadaran_edit" class="form-control"
                                    style="width: 40%">
                                    <option value="Compos Mentis">Compos Mentis</option>
                                    <option value="Somnolence">Somnolence</option>
                                    <option value="Sopor">Sopor</option>
                                    <option value="Coma">Coma</option>
                                </select>
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="gcs_edit" style="width: 30%">2. GCS</label> :
                                <div class="input-group d-flex mt-3" style="width: 40%">
                                    <input type="text" name="gcs_e" id="gcs_e_edit"
                                        value="<?php echo e($soapTerbaru->isian->gcs_e); ?>" class="form-control"
                                        aria-describedby="basic-addon2_edit" placeholder="E">
                                    <input type="text" name="gcs_m" id="gcs_m_edit"
                                        value="<?php echo e($soapTerbaru->isian->gcs_m); ?>" class="form-control"
                                        aria-describedby="basic-addon2_edit" placeholder="M">
                                    <input type="text" name="gcs_v" id="gcs_v_edit"
                                        value="<?php echo e($soapTerbaru->isian->gcs_v); ?>" class="form-control"
                                        aria-describedby="basic-addon2_edit" placeholder="V">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2_edit"
                                            style="background: rgb(228, 228, 228)">
                                            <span id="gcs_total_edit"><b>0</b></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="kepala_edit" style="width: 30%">3. Kepala</label> :
                                <select name="kepala" id="kepala_edit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-kepala_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_kepala === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_kepala === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-kepala_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_kepala === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-kepala_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-kepala" class="form-control mt-2 mb-2"
                                    value="<?php echo e($soapTerbaru->rm->o_kepala_uraian); ?>"
                                    placeholder="Alasan Kepala Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="mata_edit" style="width: 30%">4. Mata</label> :
                                <select name="mata" id="mata_edit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-mata_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_mata === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_mata === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-mata_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_mata === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-mata_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-mata" value="<?php echo e($soapTerbaru->rm->o_mata_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Mata Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="leher_edit" style="width: 30%">5. Leher</label> :
                                <select name="leher" id="leher_edit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-leher_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option value="Normal"
                                        <?php echo e($soapTerbaru->rm->o_leher === 'Normal' ? 'selected' : ''); ?>>
                                        Normal
                                    </option>
                                    <option value="Abnormal"
                                        <?php echo e($soapTerbaru->rm->o_leher === 'Abnormal' ? 'selected' : ''); ?>>Abnormal
                                    </option>
                                </select>
                            </div>
                            <div id="alasan-leher_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_leher === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-leher_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-leher" value="<?php echo e($soapTerbaru->rm->o_leher_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Leher Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="tht_edit" style="width: 30%">6. THT</label> :
                                <select name="tht" id="tht_edit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-tht_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option value="Normal"
                                        <?php echo e($soapTerbaru->rm->o_tht === 'Normal' ? 'selected' : ''); ?>>
                                        Normal</option>
                                    <option value="Abnormal"
                                        <?php echo e($soapTerbaru->rm->o_tht === 'Abnormal' ? 'selected' : ''); ?>>
                                        Abnormal
                                    </option>
                                </select>
                            </div>
                            <div id="alasan-tht_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-tht_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-tht" value="<?php echo e($soapTerbaru->rm->o_tht_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan THT Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="thorax_edit" style="width: 30%">7. Thorax</label> :
                                <select name="thorax" id="thorax_edit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-thorax_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_thorax === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_thorax === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-thorax_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-thorax_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-thorax" value="<?php echo e($soapTerbaru->rm->o_thorax_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Thorax Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="paru_edit" style="width: 30%">8. Paru</label> :
                                <select name="paru" id="paru_edit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-paru_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_paru === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_paru === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-paru_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_paru === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-paru_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-paru" class="form-control mt-2 mb-2"
                                    value="<?php echo e($soapTerbaru->rm->o_paru_uraian); ?>" placeholder="Alasan Paru Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="jantung_edit" style="width: 30%">9. Jantung</label> :
                                <select name="jantung" id="jantung_edit" class="form-control mt-3"
                                    style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-jantung_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_jantung === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_jantung === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-jantung_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_jantung === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-jantung_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-jantung" value="<?php echo e($soapTerbaru->rm->o_jantung_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Jantung Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="abdomen_edit" style="width: 30%">10. Abdomen</label> :
                                <select name="abdomen" id="abdomen_edit" class="form-control mt-3"
                                    style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-abdomen_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_abdomen === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_abdomen === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-abdomen_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_abdomen === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-abdomen_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    value="<?php echo e($soapTerbaru->rm->o_abdomen_uraian); ?>" name="alasan-abdomen"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Abdomen Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="ekstremitas_edit" style="width: 30%">11. Ekstremitas</label> :
                                <select name="ekstremitas" id="ekstremitas_edit" class="form-control mt-3"
                                    style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-ekstremitas_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_ekstremitas === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_ekstremitas === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-ekstremitas_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_ekstremitas === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-ekstremitas_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    name="alasan-ekstremitas" value="<?php echo e($soapTerbaru->rm->o_ekstremitas_uraian); ?>"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Ekstremitas Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
                                <label for="kulit_edit" style="width: 30%">12. Kulit</label> :
                                <select name="kulit" id="kulit_edit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-kulit_edit_<?php echo e($soapTerbaru->rm->id); ?>', this)">
                                    <option <?php echo e($soapTerbaru->rm->o_kulit === 'Normal' ? 'selected' : ''); ?>

                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option <?php echo e($soapTerbaru->rm->o_kulit === 'Abnormal' ? 'selected' : ''); ?>

                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-kulit_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                style="<?php echo e($soapTerbaru->rm->o_kulit === 'Abnormal' ? 'display: block;' : 'display: none;'); ?>">
                                <input type="text" id="alasan-kulit_edit_<?php echo e($soapTerbaru->rm->id); ?>"
                                    value="<?php echo e($soapTerbaru->rm->o_kulit_uraian); ?>" name="alasan-kulit"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Kulit Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-items: baseline; justify-content: space-between">
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
                                            <label for="tb_edit">Tinggi Badan</label>
                                            <div class="input-group">
                                                <input type="number" name="tb" id="tb_edit"
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
                                            <label for="bb_edit">Berat Badan</label>
                                            <div class="input-group">
                                                <input type="number" name="bb" id="bb_edit"
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
                                            <label for="imt_edit">IMT</label>
                                            <div class="input-group">
                                                <input type="text" name="p_imt" id="p_imt_edit"
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
                            <label for="soap_a_input" style="font-weight: bold">Diagnosa (A)</label>
                            <div class="col-md-12 mt-2">
                                <div class="input-group position-relative">
                                    <input type="text" id="soap_a_input" class="form-control" placeholder="Cari Diagnosa">
                                    <button class="btn btn-primary" type="button" id="add-diagnosa-btn">Add</button>
                                    <div id="dropdown-diagnosa" class="dropdown-menu w-100" style="display: none; top: 100%; left: 0;"></div>
                                </div>

                                <!-- Container untuk daftar diagnosa yang sudah ada -->
                                <ul id="diagnosa-list" class="list-group mt-2">
                                    
                                    <?php $__currentLoopData = $diagnosaPrimer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="badge bg-info me-2">Primer</span>
                                            <?php echo e($diag); ?>

                                            <input type="hidden" name="diagnosa_primer[]" value="<?php echo e($diag); ?>">
                                            <button class="btn btn-danger btn-sm ms-2 remove-diagnosa">Hapus</button>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php $__currentLoopData = $diagnosaSekunder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="badge bg-secondary me-2">Sekunder</span>
                                            <?php echo e($diag); ?>

                                            <input type="hidden" name="diagnosa_sekunder[]" value="<?php echo e($diag); ?>">
                                            <button class="btn btn-danger btn-sm ms-2 remove-diagnosa">Hapus</button>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>


<div class="form-group mt-3 mb-2">
    <label class="fw-bold mb-2">Pilih Obat (P)</label>

    <div id="obat-form" class="mb-3">
        <!-- Input Nama Obat -->
        <div class="mb-2">
            <input type="text"
                   id="nama-obat-input"
                   class="form-control"
                   placeholder="Cari Nama Obat"
                   autocomplete="off"
                   data-url="<?php echo e(url('/resep-autocomplete')); ?>">
        </div>

        <!-- Field Pendek untuk jenis, aturan, anjuran, jumlah -->
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text"
                       id="jenis-sediaan-input"
                       class="form-control"
                       placeholder="Jenis Sediaan"
                       autocomplete="off"
                       data-url="<?php echo e(url('/jenis-autocomplete')); ?>">
            </div>

            <div class="col-md-3">
                <input type="text"
                       id="aturan-pakai-input"
                       class="form-control"
                       placeholder="Aturan Pakai"
                       autocomplete="off"
                       data-url="<?php echo e(url('/aturan-autocomplete')); ?>">
            </div>

            <div class="col-md-3">
                <input type="text"
                       id="anjuran-minum-input"
                       class="form-control"
                       placeholder="Anjuran Minum"
                       autocomplete="off"
                       data-url="<?php echo e(url('/anjuran-autocomplete')); ?>">
            </div>

            <div class="col-md-2">
                <input type="number"
                       id="jumlah-input"
                       class="form-control"
                       placeholder="QTY"
                       min="1">
            </div>

            <div class="col-md-2">
                <button id="add-obat-btn"
                        type="button"
                        class="btn btn-primary w-100">
                    Add
                </button>
            </div>
        </div>
    </div>

    <!-- Racikan -->
    <label class="fw-bold mt-4 mb-2">Resep Racikan</label>
    <textarea id="racikan-textarea"
              rows="4"
              class="form-control mb-3"
              name="ObatRacikan"><?php echo e($soapTerbaru->ObatRacikan); ?></textarea>

    <!-- List obat yang sudah ditambahkan -->
   <!-- List obat yang sudah ditambahkan -->
<ul id="obat-list" class="list-group">
<?php $__currentLoopData = $resep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $nama_obat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $obat = App\Models\Resep::where('nama_obat', $nama_obat)->first();
        $obatId = $obat ? $obat->id : '';
        $jenis = $resepJenis[$index] ?? '';
        $aturan = $resepAturan[$index] ?? '';
        $anjuran = $resepAnjuran[$index] ?? '';
        $jumlah = $resepJumlah[$index] ?? 1;

        $resepData = [
            'nama' => $nama_obat ?? '',
            'jenis_sediaan' => $jenis ?? '',
            'aturan' => $aturan ?? '',
            'anjuran' => $anjuran ?? '',
            'jumlah' => is_numeric($jumlah) && $jumlah > 0 ? (int)$jumlah : 1,
        ];

        $jsonResep = json_encode($resepData, JSON_UNESCAPED_UNICODE);
    ?>

    <?php if($obatId): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo e($nama_obat); ?> - <?php echo e($jenis); ?> - <?php echo e($aturan); ?> - <?php echo e($anjuran); ?> - QTY: <?php echo e($jumlah); ?>


            <!-- Pakai e() untuk escape, jangan htmlspecialchars -->
            <input type="hidden" name="obat[]" value="<?php echo e(e($jsonResep)); ?>">

            <span class="badge bg-danger rounded-pill remove-obat" data-index="<?php echo e($index); ?>" style="cursor:pointer;">×</span>
        </li>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

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

        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
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
    

    <script>
        // Fungsi toggle untuk form editSoap
        function toggleChangeSoapEdit(elementId, radio) {
            const element = document.getElementById(elementId);
            if (!element) {
                console.warn(`[EditSoap] Element not found: ${elementId}`);
                return;
            }

            // Tampilkan hanya jika nilai adalah "Aloanamnesis"
            element.style.display = (radio.value === 'Aloanamnesis') ? 'block' : 'none';
            console.log(`[EditSoap] Toggle ${elementId} with value: ${radio.value}, display: ${element.style.display}`);
        }

        // Inisialisasi dan perhitungan GCS serta IMT untuk editSoap
        function initializeEditSoap() {
            // GCS Calculation
            const gcs_e = document.getElementById('gcs_e_edit');
            const gcs_m = document.getElementById('gcs_m_edit');
            const gcs_v = document.getElementById('gcs_v_edit');
            const gcs_total = document.getElementById('gcs_total_edit');

            if (!gcs_e || !gcs_m || !gcs_v || !gcs_total) {
                console.error('[EditSoap] One or more GCS elements not found:', {
                    gcs_e,
                    gcs_m,
                    gcs_v,
                    gcs_total
                });
                return;
            }

            function calculateTotal() {
                let e = parseFloat(gcs_e.value) || 0;
                let m = parseFloat(gcs_m.value) || 0;
                let v = parseFloat(gcs_v.value) || 0;
                let totalInput = e + m + v;

                console.log('[EditSoap] GCS Input values:', {
                    e,
                    m,
                    v,
                    totalInput
                });

                if (e === 0 || m === 0 || v === 0) {
                    gcs_total.textContent = isNaN(totalInput) ? '0' : totalInput.toString();
                } else {
                    if (totalInput !== 15) {
                        const ratio = 15 / totalInput;
                        e = Math.round(e * ratio);
                        m = Math.round(m * ratio);
                        v = Math.round(v * ratio);
                        totalInput = 15;
                    }
                    gcs_total.textContent = '15';
                }
                console.log('[EditSoap] GCS Calculated total:', gcs_total.textContent);
            }

            [gcs_e, gcs_m, gcs_v].forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            calculateTotal();

            // IMT Calculation
            const tbInput = document.getElementById('tb_edit');
            const bbInput = document.getElementById('bb_edit');
            const imtInput = document.getElementById('p_imt_edit');

            if (!tbInput || !bbInput || !imtInput) {
                console.error('[EditSoap] One or more IMT elements not found:', {
                    tbInput,
                    bbInput,
                    imtInput
                });
                return;
            }

            function hitungIMT() {
                var tb = parseFloat(tbInput.value);
                var bb = parseFloat(bbInput.value);

                if (!isNaN(tb) && !isNaN(bb) && tb > 0 && bb > 0) {
                    var imt = bb / ((tb / 100) * (tb / 100));
                    imtInput.value = imt.toFixed(2);
                } else {
                    imtInput.value = '';
                }
                console.log('[EditSoap] IMT Calculated:', imtInput.value);
            }

            [tbInput, bbInput].forEach(input => {
                input.addEventListener('input', hitungIMT);
            });

            hitungIMT();
        }

        // Inisialisasi saat DOM siap untuk editSoap
        document.addEventListener('DOMContentLoaded', function() {
            initializeEditSoap();

            // Ambil RM ID dengan fallback (handle null di PHP: <?php if($soapTerbaru && $soapTerbaru->rm): ?> <?php echo e($soapTerbaru->rm->id); ?> <?php else: ?> 0 <?php endif; ?>
            // const rmId = <?php echo e($soapTerbaru && $soapTerbaru->rm ? $soapTerbaru->rm->id : 'null'); ?>;
            const rmId = <?php echo json_encode(optional($soapTerbaru->rm)->id, 15, 512) ?>;

            // Tambahkan event listener untuk semua select yang memicu toggle
            const selects = document.querySelectorAll(
                '#kepala_edit, #mata_edit, #leher_edit, #tht_edit, #thorax_edit, #paru_edit, #jantung_edit, #abdomen_edit, #ekstremitas_edit, #kulit_edit'
            );

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    // Gunakan rmId jika ada, atau fallback ke string kosong
                    const elementId = rmId ? (this.id.replace('_edit', '') + '_edit_' + rmId) : (
                        this.id.replace('_edit', '') + '_edit');
                    toggleChangeSoapEdit(elementId, this);
                });
            });

            // Tambahkan event listener untuk radio isian dan set status awal
            const isianRadios = document.querySelectorAll('#isian-ya_edit, #isian-tidak_edit');
            isianRadios.forEach(radio => {
                radio.addEventListener('change', () => toggleChangeSoapEdit('alasan-isian-soap_edit',
                    radio));

                // Set status awal berdasarkan radio yang sudah checked
                if (radio.checked) {
                    toggleChangeSoapEdit('alasan-isian-soap_edit', radio);
                }
            });

            // Pastikan status awal sesuai dengan data awal
            const initialValue = document.querySelector('input[name="isian"]:checked');
            if (initialValue && initialValue.value.toLowerCase() === 'aloanamnesis') {
                toggleChangeSoapEdit('alasan-isian-soap_edit', initialValue);
            }

            // Jika soapTerbaru null, nonaktifkan atau sembunyikan elemen edit sementara
            if (!rmId) {
                // Contoh: Sembunyikan form edit atau alert
                console.log('Tidak ada data SOAP terbaru, form dalam mode create baru.');
            }
        });

        // Fungsi tambahan untuk toggle section (jika diperlukan, sesuaikan dengan kebutuhan)
        function toggleSectionEdit(sectionClass) {
            const inputs = document.querySelectorAll(`.${sectionClass} .form-group`);
            inputs.forEach(input => {
                input.classList.toggle('hidden-input');
            });
        }

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

            function addDiagnosa(value, type = null) {
                if (!value.trim()) return;

                const li = document.createElement('li');
                li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                const badge = document.createElement('span');
                badge.classList.add('badge', 'me-2');

                if (type) {
                    badge.textContent = type;
                    badge.classList.add(type === 'Primer' ? 'bg-info' : 'bg-secondary');
                } else {
                    // Cek semua diagnosa yang sudah ada, termasuk hidden input
                    const existingPrimer = [...diagnosaList.querySelectorAll('span.badge')]
                        .some(b => b.textContent.trim() === 'Primer');

                    badge.textContent = existingPrimer ? 'Sekunder' : 'Primer';
                    badge.classList.add(existingPrimer ? 'bg-secondary' : 'bg-info');
                }

                li.appendChild(badge);
                li.appendChild(document.createTextNode(value));

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = badge.textContent === 'Primer' ? 'diagnosa_primer[]' : 'diagnosa_sekunder[]';
                hidden.value = value;
                li.appendChild(hidden);

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
                removeBtn.textContent = 'Hapus';
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    li.remove();
                });

                li.appendChild(removeBtn);
                diagnosaList.appendChild(li);
            }

            addBtn.addEventListener('click', function() {
                addDiagnosa(input.value.trim());
                input.value = '';
            });

            // Event listener untuk tombol hapus yang sudah ada di DOM
            diagnosaList.querySelectorAll('.remove-diagnosa').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    btn.parentElement.remove();
                });
            });
        });


        $(document).ready(function() {
            console.log('[document.ready] Script autocomplete dan jumlah dimuat untuk edit.');

            // Inisialisasi saat modal ditampilkan
            $('div[id^="editSoap"]').on('shown.bs.modal', function() {
                const modalId = this.id;
                console.log('[modal.shown] Menginisialisasi input di modal:', modalId);
                initializeAllInputs(modalId);
            });

            function initializeAllInputs(modalId) {
                $(`#${modalId} .autocomplete-input`).each(function() {
                    initializeAutocomplete($(this));
                });
                $(`#${modalId} .jumlah-input`).each(function() {
                    initializeJumlahInput($(this));
                });
            }

            function initializeAutocomplete($input) {
                const inputId = $input.attr('id');
                const url = $input.data('url');
                const dropdownId = $input.data('dropdown');
                const $dropdown = $(`#${dropdownId}`);
                const $wrapper = $input.closest('.multi-select-wrapper');
                const $tagsContainer = $wrapper.find('.selected-tags');
                const $hiddenInputsContainer = $(`#${inputId}_hidden_inputs`);
                const soapId = inputId.split('_')[1]; // Ambil soap ID dari inputId (edit-resep_{soapId}_0)
                const fieldName = inputId.replace(`edit-`, '').replace(`_${soapId}_0`, '');
                const hiddenInputName = `soap_p[${soapId}][${fieldName}][]`;

                if (!$input.length || !$dropdown.length || !$tagsContainer.length || !$hiddenInputsContainer
                    .length) {
                    console.warn(
                        `[initializeAutocomplete] Elemen input (${inputId}), dropdown (${dropdownId}), tags container, atau hidden inputs container tidak ditemukan`
                    );
                    return;
                }

                console.log(
                    `[initializeAutocomplete] Menginisialisasi autocomplete untuk ${inputId} dengan URL: ${url}`
                );

                let selectedItems = [];
                $tagsContainer.find('.tag').each(function() {
                    const value = $(this).data('value');
                    if (value && value !== 'null' && value !== '') {
                        selectedItems.push(value.toString());
                    }
                });

                function updateHiddenInput() {
                    $hiddenInputsContainer.empty();
                    selectedItems.forEach(value => {
                        if (value && value !== 'null' && value !== '') {
                            $hiddenInputsContainer.append(
                                `<input type="hidden" name="${hiddenInputName}" value="${value}">`);
                        }
                    });
                    console.log(`[updateHiddenInput] Inputs for ${hiddenInputName}:`, selectedItems);
                }

                updateHiddenInput();

                function addTag(text, value) {
                    if (value && value !== 'null' && value !== '') {
                        selectedItems.push(value.toString());
                        const tagHtml = `
                    <span class="tag" data-value="${value}" data-text="${text}">
                        ${text}
                        <span class="remove-tag">×</span>
                    </span>`;
                        $tagsContainer.append(tagHtml);
                        updateHiddenInput();
                        $input.val('');
                        console.log(`[addTag] Menambahkan tag untuk ${inputId}: ${text} (${value})`);
                    } else {
                        console.warn(`[addTag] Tag untuk ${inputId} tidak ditambahkan: nilai ${value} tidak valid`);
                    }
                }

                function removeTag(value) {
                    const index = selectedItems.indexOf(value.toString());
                    if (index !== -1) {
                        selectedItems.splice(index, 1);
                        $tagsContainer.find(`.tag[data-value="${value}"]`).first().remove();
                        updateHiddenInput();
                        console.log(`[removeTag] Menghapus tag untuk ${inputId}: ${value}`);
                    }
                }

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
                                    textStatus, errorThrown);
                                $dropdown.empty().show().append(
                                    `<div class="dropdown-item">Error: ${textStatus}</div>`);
                            }
                        });
                    } else {
                        $dropdown.hide();
                    }
                });

                $dropdown.off('click').on('click', '.dropdown-item', function() {
                    const text = $(this).data('text');
                    const value = $(this).data('value');
                    if (text !== 'Tidak ada saran' && !text.startsWith('Error:') && value && value !==
                        'null' && value !== '') {
                        addTag(text, value);
                        $dropdown.hide();
                    }
                });

                $tagsContainer.off('click').on('click', '.remove-tag', function() {
                    const $tag = $(this).parent('.tag');
                    const value = $tag.data('value');
                    removeTag(value);
                });
            }

            function initializeJumlahInput($input) {
                const inputId = $input.attr('id');
                const $wrapper = $input.closest('.multi-select-wrapper');
                const $tagsContainer = $wrapper.find('.selected-tags');
                const $hiddenInputsContainer = $(`#${inputId}_hidden_inputs`);
                const soapId = inputId.split('_')[1]; // Ambil soap ID dari inputId (edit-jumlah_{soapId}_0)
                const hiddenInputName = `soap_p[${soapId}][jumlah][]`;

                if (!$input.length || !$tagsContainer.length || !$hiddenInputsContainer.length) {
                    console.warn(
                        `[initializeJumlahInput] Elemen input (${inputId}), tags container, atau hidden inputs container tidak ditemukan`
                    );
                    return;
                }

                console.log(`[initializeJumlahInput] Menginisialisasi input jumlah untuk ${inputId}`);

                let selectedItems = [];
                $tagsContainer.find('.tag').each(function() {
                    const value = $(this).data('value');
                    if (value && value !== 'null' && value !== '' && !isNaN(value) && value > 0) {
                        selectedItems.push(value.toString());
                    }
                });

                function updateHiddenInput() {
                    $hiddenInputsContainer.empty();
                    selectedItems.forEach(value => {
                        if (value && value !== 'null' && value !== '' && !isNaN(value) && value > 0) {
                            $hiddenInputsContainer.append(
                                `<input type="hidden" name="${hiddenInputName}" value="${value}">`);
                        }
                    });
                    console.log(`[updateHiddenInput] Inputs for ${hiddenInputName}:`, selectedItems);
                }

                updateHiddenInput();

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
                        $input.val('');
                        console.log(`[addTag] Menambahkan jumlah untuk ${inputId}: ${value}`);
                    } else {
                        console.warn(`[addTag] Jumlah tidak valid untuk ${inputId}: ${value}`);
                        alert('Masukkan jumlah yang valid (angka positif).');
                    }
                }

                function removeTag(value) {
                    const index = selectedItems.indexOf(value.toString());
                    if (index !== -1) {
                        selectedItems.splice(index, 1);
                        $tagsContainer.find(`.tag[data-value="${value}"]`).first().remove();
                        updateHiddenInput();
                        console.log(`[removeTag] Menghapus jumlah untuk ${inputId}: ${value}`);
                    }
                }

                $input.off('keypress').on('keypress', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        const value = $(this).val().trim();
                        if (value && !isNaN(value) && value > 0) {
                            addTag(value);
                        } else {
                            console.warn(
                                `[initializeJumlahInput] Input tidak valid untuk ${inputId}: ${value}`);
                            alert('Masukkan jumlah yang valid (angka positif).');
                        }
                    }
                });

                $tagsContainer.off('click').on('click', '.remove-tag', function() {
                    const $tag = $(this).parent('.tag');
                    const value = $tag.data('value');
                    removeTag(value);
                });
            }

            $(document).on('click', function(e) {
                if (!$(e.target).closest(
                        '.autocomplete-input, .autocomplete-dropdown, .multi-select-wrapper, .jumlah-input')
                    .length) {
                    $('.autocomplete-dropdown').hide();
                }
            });

            $(document).on('submit', '.edit-soap-form', function(e) {
    const $form = $(this);

    // Ambil semua input hidden yang menyimpan data obat (obat[])
    const obatInputs = $form.find('input[name="obat[]"]');

    if (obatInputs.length === 0) {
        alert('Pilih minimal 1 obat.');
        e.preventDefault();
        return false;
    }

    for (let i = 0; i < obatInputs.length; i++) {
        let rawValue = obatInputs[i].value;

        // Fix untuk HTML escape (&quot; -> ")
        rawValue = rawValue.replace(/&quot;/g, '"');

        let resep;
        try {
            resep = JSON.parse(rawValue);
        } catch (err) {
            console.error('Error parsing JSON obat[]:', rawValue, err);
            alert('Format data resep salah.');
            e.preventDefault();
            return false;
        }

        // Normalisasi string dan angka
        const nama = resep.nama ? resep.nama.trim() : '';
        const jenis_sediaan = resep.jenis_sediaan ? resep.jenis_sediaan.trim() : '';
        const aturan = resep.aturan ? resep.aturan.trim() : '';
        const anjuran = resep.anjuran ? resep.anjuran.trim() : '';
        const jumlah = parseInt(resep.jumlah);

        if (!nama || !jenis_sediaan || !aturan || !anjuran || isNaN(jumlah) || jumlah <= 0) {
            alert('Data resep tidak lengkap atau jumlah tidak valid. Mohon lengkapi semua kolom dengan benar.');
            e.preventDefault();
            return false;
        }
    }

    console.log('[form.submit] Validasi resep LOLOS');
});

            $(document).on('click', '.remove-obat', function(e) {
                e.preventDefault();

                // Ambil li induk
                const $li = $(this).closest('li');

                // Hapus li dari DOM
                $li.remove();

                console.log('[remove-obat] Obat dihapus', $li);
            });

        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/dokter/modal/editSoap.blade.php ENDPATH**/ ?>