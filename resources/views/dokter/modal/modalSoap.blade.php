{{-- modal soap --}}
<div class="modal fade" id="modalSoap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Tindakan Dokter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('dokter/store/' . $id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="profesi" style="font-weight: bold">Dokter Penanggung Jawab Pasien</label>
                        <input type="text" style="font-weight: bold"
                            value="{{ $antrianDokter->dokter->nama_dokter }}" class="form-control mt-2" disabled>
                    </div>
                    <h6 class="mt-4" style="font-weight: bold; margin-bottom: 5px">ASESMEN</h6>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group mt-3">
                                <label for="keluhan" style="font-weight: bold">Keluhan (S)</label>
                                <input type="text" name="keluhan" value="{{ $antrianDokter->rm->a_keluhan_utama }}"
                                    class="form-control mt-2">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mt-3">
                                <label for="riwayat-alergi" style="font-weight: bold">Alergi</label>
                                <select name="a_riwayat_alergi" id="a_riwayat_alergi" class="form-control mt-2 mb-2 ">
                                    <option value="{{ $antrianDokter->rm->a_riwayat_alergi ?? 'Tidak Ada' }}" selected>
                                        {{ $antrianDokter->rm->a_riwayat_alergi ?? 'Tidak Ada' }}</option>
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
                                    value="{{ $antrianDokter->rm->a_riwayat_penyakit_skrg ?? '' }}">
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
                                    {{ $antrianDokter->isian->p_form_isian_pilihan === 'auto-anamnesis' ? 'checked' : '' }}>
                                Auto Anamnesis
                            </label>
                            <label for="isian-tidak">
                                <input type="radio" name="isian" id="isian-tidak"
                                    style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                    value="Aloanamnesis" onclick="toggleChangeSoap('alasan-isian-soap', this)"
                                    {{ $antrianDokter->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'checked' : '' }}>
                                Aloanamnesis
                            </label>
                        </div>
                        <div id="alasan-isian-soap"
                            style="{{ $antrianDokter->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="isian_alasan" name="isian_alasan" class="form-control mt-2 mb-2"
                                placeholder="Alasan" value="{{ $antrianDokter->isian->p_form_isian_pilihan_uraian }}">
                        </div>
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
                                    value="{{ $antrianDokter->isian->gcs_e }}" class="form-control"
                                    aria-describedby="basic-addon2" placeholder="E">
                                <input type="text" name="gcs_m" id="gcs_m"
                                    value="{{ $antrianDokter->isian->gcs_m }}" class="form-control"
                                    aria-describedby="basic-addon2" placeholder="M">
                                <input type="text" name="gcs_v" id="gcs_v"
                                    value="{{ $antrianDokter->isian->gcs_v }}" class="form-control"
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
                                onclick="toggleChangeSoap('alasan-kepala_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_kepala === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_kepala === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-kepala_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_kepala === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-kepala_{{ $antrianDokter->rm->id }}"
                                name="alasan-kepala" class="form-control mt-2 mb-2"
                                value="{{ $antrianDokter->rm->o_kepala_uraian }}"
                                placeholder="Alasan Kepala Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="mata" style="width: 30%">4. Mata</label> :
                            <select name="mata" id="mata" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-mata_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_mata === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_mata === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-mata_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_mata === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-mata_{{ $antrianDokter->rm->id }}" name="alasan-mata"
                                value="{{ $antrianDokter->rm->o_mata_uraian }}" class="form-control mt-2 mb-2"
                                placeholder="Alasan Mata Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="leher" style="width: 30%">5. Leher</label> :
                            <select name="leher" id="leher" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-leher_{{ $antrianDokter->rm->id }}', this)">
                                <option value="Normal"
                                    {{ $antrianDokter->rm->o_leher === 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="Abnormal"
                                    {{ $antrianDokter->rm->o_leher === 'Abnormal' ? 'selected' : '' }}>Abnormal
                                </option>
                            </select>
                        </div>
                        <div id="alasan-leher_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_leher === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-leher_{{ $antrianDokter->rm->id }}" name="alasan-leher"
                                value="{{ $antrianDokter->rm->o_leher_uraian }}" class="form-control mt-2 mb-2"
                                placeholder="Alasan Leher Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="tht" style="width: 30%">6. THT</label> :
                            <select name="tht" id="tht" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-tht_{{ $antrianDokter->rm->id }}', this)">
                                <option value="Normal" {{ $antrianDokter->rm->o_tht === 'Normal' ? 'selected' : '' }}>
                                    Normal</option>
                                <option value="Abnormal"
                                    {{ $antrianDokter->rm->o_tht === 'Abnormal' ? 'selected' : '' }}>Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-tht_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-tht_{{ $antrianDokter->rm->id }}" name="alasan-tht"
                                value="{{ $antrianDokter->rm->o_tht_uraian }}" class="form-control mt-2 mb-2"
                                placeholder="Alasan THT Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="thorax" style="width: 30%">7. Thorax</label> :
                            <select name="thorax" id="thorax" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-thorax_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_thorax === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_thorax === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-thorax_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-thorax_{{ $antrianDokter->rm->id }}"
                                name="alasan-thorax" value="{{ $antrianDokter->rm->o_thorax_uraian }}"
                                class="form-control mt-2 mb-2" placeholder="Alasan Thorax Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="paru" style="width: 30%">8. Paru</label> :
                            <select name="paru" id="paru" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-paru_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_paru === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_paru === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-paru_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_paru === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-paru_{{ $antrianDokter->rm->id }}" name="alasan-paru"
                                class="form-control mt-2 mb-2" value="{{ $antrianDokter->rm->o_paru_uraian }}"
                                placeholder="Alasan Paru Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="jantung" style="width: 30%">9. Jantung</label> :
                            <select name="jantung" id="jantung" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-jantung_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_jantung === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_jantung === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-jantung_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_jantung === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-jantung_{{ $antrianDokter->rm->id }}"
                                name="alasan-jantung" value="{{ $antrianDokter->rm->o_jantung_uraian }}"
                                class="form-control mt-2 mb-2" placeholder="Alasan Jantung Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="abdomen" style="width: 30%">10. Abdomen</label> :
                            <select name="abdomen" id="abdomen" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-abdomen_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_abdomen === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_abdomen === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-abdomen_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_abdomen === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-abdomen_{{ $antrianDokter->rm->id }}"
                                value="{{ $antrianDokter->rm->o_abdomen_uraian }}" name="alasan-abdomen"
                                class="form-control mt-2 mb-2" placeholder="Alasan Abdomen Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="ekstremitas" style="width: 30%">11. Ekstremitas</label> :
                            <select name="ekstremitas" id="ekstremitas" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-ekstremitas_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_ekstremitas === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_ekstremitas === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-ekstremitas_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_ekstremitas === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-ekstremitas_{{ $antrianDokter->rm->id }}"
                                name="alasan-ekstremitas" value="{{ $antrianDokter->rm->o_ekstremitas_uraian }}"
                                class="form-control mt-2 mb-2" placeholder="Alasan Ekstremitas Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="kulit" style="width: 30%">12. Kulit</label> :
                            <select name="kulit" id="kulit" class="form-control mt-3" style="width: 40%"
                                onclick="toggleChangeSoap('alasan-kulit_{{ $antrianDokter->rm->id }}', this)">
                                <option {{ $antrianDokter->rm->o_kulit === 'Normal' ? 'selected' : '' }}
                                    id="jawaban-normal" value="Normal">Normal</option>
                                <option {{ $antrianDokter->rm->o_kulit === 'Abnormal' ? 'selected' : '' }}
                                    id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                            </select>
                        </div>
                        <div id="alasan-kulit_{{ $antrianDokter->rm->id }}"
                            style="{{ $antrianDokter->rm->o_kulit === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                            <input type="text" id="alasan-kulit_{{ $antrianDokter->rm->id }}"
                                value="{{ $antrianDokter->rm->o_kulit_uraian }}" name="alasan-kulit"
                                class="form-control mt-2 mb-2" placeholder="Alasan Kulit Abnormal">
                        </div>
                        <div class="form"
                            style="display: flex; align-items: baseline; justify-content: space-between">
                            <label for="lain-lain" style="width: 30%">13. Lain-lain</label> :
                            <input type="text" id="lain" name="lain"
                                value="{{ $antrianDokter->rm->lain_lain }}" class="form-control mt-3 mb-2"
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
                                                value="{{ $antrianDokter->isian->p_tensi }}"
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
                                                value="{{ $antrianDokter->isian->p_rr }}"
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
                                                value="{{ $antrianDokter->isian->p_nadi }}"
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
                                                value="{{ $antrianDokter->isian->spo2 }}"
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
                                                value="{{ $antrianDokter->isian->p_suhu }}"
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
                                                value="{{ $antrianDokter->isian->p_tb }}"
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
                                                value="{{ $antrianDokter->isian->p_bb }}"
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
                                                value="{{ $antrianDokter->isian->p_imt }}"
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

                                @php
                                    $tgllahir = \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir);
                                    $umur = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                                    $jenis_kelamin = $antrianDokter->booking->pasien->jekel;
                                    // dd($umur, $jenis_kelamin);
                                @endphp

                                @if ($umur > 16 && $jenis_kelamin === 'P')
                                    {{-- Umur lebih dari 16 tahun dalam bulan --}}
                                    {{-- Lingkar Kepala Anak --}}
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="lingkar-kepala-anak">Lingkar Kepala Anak</label>
                                            <div class="input-group">
                                                <input type="number" name="p_lngkr_kepala_anak"
                                                    id="p_lngkr_kepala_anak"
                                                    value="{{ $antrianDokter->isian->p_lngkr_kepala_anak }}"
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

                                    {{-- Lingkar Lengan --}}
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="lingkar-lengan">Lingkar Lengan</label>
                                            <div class="input-group">
                                                <input type="text" name="p_lngkr_lengan_anc"
                                                    id="p_lngkr_lengan_anc"
                                                    value="{{ $antrianDokter->isian->p_lngkr_lengan_anc }}"
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
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="soap_a_0" style="font-weight: bold">Diagnosa (A)</label>
                        <div class="col-md-12 mt-2">
                            {{-- BARU --}}

                            <div class="row">
                                <div class="col-6">
                                    <label for="diagnosa_primer">Diagnosa Primer</label>
                                    <input type="text" id="soap_a_0" name="soap_a[0][diagnosa_primer]"
                                        class="soap_a form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                    <div id="dropdown-diagnosa-primer" class="dropdown-menu"
                                        style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 100%;">
                                    </div> <!-- Dropdown -->
                                </div>
                                <div class="col-6">
                                    <label for="diagnosa_sekunder">Diagnosa Sekunder</label>
                                    <input type="text" id="soap_a_b_0" name="soap_a_b[0][diagnosa_sekunder]"
                                        class="soap_a_b form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                    <div id="dropdown-diagnosa-sekunder" class="dropdown-menu"
                                        style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 100%;">
                                    </div> <!-- Dropdown -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="soap_p_0"
                            style="font-weight: bold; margin-top: 10px; margin-bottom: 5px; width: 100%; cursor: pointer;"
                            onclick="toggleObatContainer()">Pilih Obat (P)</label>
                        <div class="resep" id="resep">
                            <!-- Nama Obat -->
                            <div class="input-row" id="namaObatContainer"
                                style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                <label for="namaobat" style="min-width: 100px;">Nama Obat</label>
                                <span>:</span>
                                <input type="text" class="form-control soap_p" name="soap_p[0][resep]"
                                    id="resep_0" placeholder="Cari Obat" autocomplete="off">
                                <div id="dropdown-resep_0" class="dropdown-menu"
                                    style="display: none; position: absolute; z-index: 1000; cursor: pointer;"></div>
                            </div>

                            <!-- Jenis Obat -->
                            <div class="input-row" id="jenisObatContainer"
                                style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                <label for="jenisObat" style="min-width: 100px;">Jenis Obat</label>
                                <span>:</span>
                                <select name="soap_p[0][jenisobat]" id="jenis_obat_0" class="form-control">
                                    <option value="">--Pilih Jenis Obat--</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Kapsul">Kapsul</option>
                                    <option value="Bungkus">Bungkus</option>
                                    <option value="Salep">Salep</option>
                                    <option value="Sirup">Sirup</option>
                                    <option value="Mililiter">Mililiter</option>
                                    <option value="Sendok Teh">Sendok Teh</option>
                                    <option value="Sendok Makan">Sendok Makan</option>
                                    <option value="Tetes">Tetes</option>
                                    <option value="Puyer/Racikan">Puyer/Racikan</option>
                                </select>
                            </div>

                            <!-- Aturan Minum Perhari -->
                            <div class="input-row" id="aturanMinumContainer"
                                style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                <label for="aturan" style="min-width: 100px">Aturan Minum Perhari</label>
                                <span>:</span>
                                <select class="form-control" name="soap_p[0][aturan]" id="aturan_0">
                                    <option value="">--Pilih Aturan Minum--</option>
                                    <option value="1x1">1x1</option>
                                    <option value="2x1">2x1</option>
                                    <option value="3x1">3x1</option>
                                    <option value="4x1">4x1</option>
                                    <option value="5x1">5x1</option>
                                </select>
                            </div>

                            <!-- Anjuran Minum -->
                            <div class="input-row" id="anjuranMinumContainer"
                                style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                <label for="anjuran" style="min-width: 100px">Anjuran Minum</label>
                                <span>:</span>
                                <select name="soap_p[0][anjuran]" id="anjuran_0" class="form-control">
                                    <option value="">--Pilih Anjuran Minum--</option>
                                    <option value="AC">AC</option>
                                    <option value="AD">AD</option>
                                    <option value="AS">AS</option>
                                    <option value="C">C</option>
                                    <option value="CTH">CTH</option>
                                    <option value="DC">DC</option>
                                    <option value="PC">PC</option>
                                    <option value="OD">OD</option>
                                    <option value="OS">OS</option>
                                    <option value="ODS">ODS</option>
                                    <option value="PRM">PRM</option>
                                    <option value="UE">UE</option>
                                </select>
                            </div>

                            <!-- Jumlah Masing-masing Obat -->
                            <div class="input-row" id="jumlahObatContainer"
                                style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                <label for="jumlah" style="min-width: 100px">Jumlah</label>
                                <span>:</span>
                                <input type="number" name="soap_p[0][jumlah]" class="form-control"
                                    placeholder="Masukkan Jumlah Obat">
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary"
                            onclick="addColumn('jumlahObatContainer')" data-bs-toggle="tooltip" data-bs-offset="0,4"
                            data-bs-placement="top" data-bs-html="true"
                            data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Tambah Obat</span>">
                            <i class="fa-solid fa-pills"></i>
                        </button>

                        {{-- RESEP RACIKAN --}}
                        <label for=""
                            style="font-weight: bold; margin-top: 20px; margin-bottom: 5px; width: 100%; cursor: pointer"
                            onclick="toggleRacikanContainer()">Resep Racikan</label>

                        <div class="racikan" id="resepRacikan">
                            <textarea name="ObatRacikan" id="ObatRacikan" cols="30" rows="5" class="form-control mb-2 mt-2"></textarea>
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

    @push('style')
        <!-- CSS Select2 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

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

            #resep {
                display: block;
                /* Menampilkan elemen secara default */
            }

            #racikan {
                display: block;
                /* Menampilkan elemen secara default */
            }

            .input-row {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                overflow-x: auto;
                white-space: nowrap;
                max-width: 100%;
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
                align-items: center;
            }

            .input-group input {
                flex-grow: 1;
            }

            .input-group .input-group-append {
                display: flex;
                align-items: center;
            }

            .input-group .input-group-text {
                background-color: rgb(228, 228, 228);
            }
        </style>
    @endpush

    @push('script')
        <!-- JS Select2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <script>
            // RESEP
            function toggleObatContainer() {
                // Ambil elemen dengan id "resep"
                var resepContainer = document.getElementById('resep');

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
                var resepRacikanContainer = document.getElementById('resepRacikan');

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
    @endpush
