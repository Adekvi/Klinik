@if ($soapTerbaru)
    <div class="modal fade" id="editSoap{{ $soapTerbaru->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Ubah Tindakan
                        Dokter
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('soap/update/' . $soapTerbaru->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="profesi" style="font-weight: bold">Dokter Penanggung Jawab
                                        Pasien</label>
                                    <input type="text" style="font-weight: bold"
                                        value="{{ $soapTerbaru->dokter->nama_dokter }}" class="form-control mt-2"
                                        disabled>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label for="">Nama Pasien</label>
                                    <input type="text" name="nama_pasien" id="nama_pasien" class="form-control mt-2"
                                        value="{{ $soapTerbaru->pasien->nama_pasien }}" readonly>
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-4" style="font-weight: bold; margin-bottom: 5px">ASESMEN</h6>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="keluhan" style="font-weight: bold">Keluhan (S)</label>
                                    <input type="text" name="keluhan" value="{{ $soapTerbaru->rm->a_keluhan_utama }}"
                                        class="form-control mt-2">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="riwayat-alergi" style="font-weight: bold">Alergi</label>
                                    <select name="a_riwayat_alergi" id="a_riwayat_alergi"
                                        class="form-control mt-2 mb-2 ">
                                        <option value="{{ $soapTerbaru->rm->a_riwayat_alergi ?? 'Tidak Ada' }}"
                                            selected>
                                            {{ $soapTerbaru->rm->a_riwayat_alergi ?? 'Tidak Ada' }}</option>
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
                                        value="{{ $soapTerbaru->rm->a_riwayat_penyakit_skrg ?? '' }}">
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
                                        {{ $soapTerbaru->isian->p_form_isian_pilihan === 'auto-anamnesis' ? 'checked' : '' }}>
                                    Auto Anamnesis
                                </label>
                                <label for="isian-tidak">
                                    <input type="radio" name="isian" id="isian-tidak"
                                        style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                        value="Aloanamnesis" onclick="toggleChangeSoap('alasan-isian-soap', this)"
                                        {{ $soapTerbaru->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'checked' : '' }}>
                                    Aloanamnesis
                                </label>
                            </div>
                            <div id="alasan-isian-soap"
                                style="{{ $soapTerbaru->isian->p_form_isian_pilihan === 'Aloanamnesis' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="isian_alasan" name="isian_alasan"
                                    class="form-control mt-2 mb-2" placeholder="Alasan"
                                    value="{{ $soapTerbaru->isian->p_form_isian_pilihan_uraian }}">
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
                                        value="{{ $soapTerbaru->isian->gcs_e }}" class="form-control"
                                        aria-describedby="basic-addon2" placeholder="E">
                                    <input type="text" name="gcs_m" id="gcs_m"
                                        value="{{ $soapTerbaru->isian->gcs_m }}" class="form-control"
                                        aria-describedby="basic-addon2" placeholder="M">
                                    <input type="text" name="gcs_v" id="gcs_v"
                                        value="{{ $soapTerbaru->isian->gcs_v }}" class="form-control"
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
                                    onclick="toggleChangeSoap('alasan-kepala_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_kepala === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_kepala === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-kepala_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_kepala === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-kepala_{{ $soapTerbaru->rm->id }}"
                                    name="alasan-kepala" class="form-control mt-2 mb-2"
                                    value="{{ $soapTerbaru->rm->o_kepala_uraian }}"
                                    placeholder="Alasan Kepala Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="mata" style="width: 30%">4. Mata</label> :
                                <select name="mata" id="mata" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-mata_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_mata === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_mata === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-mata_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_mata === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-mata_{{ $soapTerbaru->rm->id }}" name="alasan-mata"
                                    value="{{ $soapTerbaru->rm->o_mata_uraian }}" class="form-control mt-2 mb-2"
                                    placeholder="Alasan Mata Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="leher" style="width: 30%">5. Leher</label> :
                                <select name="leher" id="leher" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-leher_{{ $soapTerbaru->rm->id }}', this)">
                                    <option value="Normal"
                                        {{ $soapTerbaru->rm->o_leher === 'Normal' ? 'selected' : '' }}>
                                        Normal
                                    </option>
                                    <option value="Abnormal"
                                        {{ $soapTerbaru->rm->o_leher === 'Abnormal' ? 'selected' : '' }}>Abnormal
                                    </option>
                                </select>
                            </div>
                            <div id="alasan-leher_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_leher === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-leher_{{ $soapTerbaru->rm->id }}"
                                    name="alasan-leher" value="{{ $soapTerbaru->rm->o_leher_uraian }}"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Leher Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="tht" style="width: 30%">6. THT</label> :
                                <select name="tht" id="tht" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-tht_{{ $soapTerbaru->rm->id }}', this)">
                                    <option value="Normal"
                                        {{ $soapTerbaru->rm->o_tht === 'Normal' ? 'selected' : '' }}>
                                        Normal</option>
                                    <option value="Abnormal"
                                        {{ $soapTerbaru->rm->o_tht === 'Abnormal' ? 'selected' : '' }}>
                                        Abnormal
                                    </option>
                                </select>
                            </div>
                            <div id="alasan-tht_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-tht_{{ $soapTerbaru->rm->id }}" name="alasan-tht"
                                    value="{{ $soapTerbaru->rm->o_tht_uraian }}" class="form-control mt-2 mb-2"
                                    placeholder="Alasan THT Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="thorax" style="width: 30%">7. Thorax</label> :
                                <select name="thorax" id="thorax" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-thorax_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_thorax === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_thorax === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-thorax_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_tht === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-thorax_{{ $soapTerbaru->rm->id }}"
                                    name="alasan-thorax" value="{{ $soapTerbaru->rm->o_thorax_uraian }}"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Thorax Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="paru" style="width: 30%">8. Paru</label> :
                                <select name="paru" id="paru" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-paru_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_paru === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_paru === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-paru_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_paru === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-paru_{{ $soapTerbaru->rm->id }}" name="alasan-paru"
                                    class="form-control mt-2 mb-2" value="{{ $soapTerbaru->rm->o_paru_uraian }}"
                                    placeholder="Alasan Paru Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="jantung" style="width: 30%">9. Jantung</label> :
                                <select name="jantung" id="jantung" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-jantung_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_jantung === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_jantung === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-jantung_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_jantung === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-jantung_{{ $soapTerbaru->rm->id }}"
                                    name="alasan-jantung" value="{{ $soapTerbaru->rm->o_jantung_uraian }}"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Jantung Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="abdomen" style="width: 30%">10. Abdomen</label> :
                                <select name="abdomen" id="abdomen" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-abdomen_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_abdomen === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_abdomen === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-abdomen_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_abdomen === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-abdomen_{{ $soapTerbaru->rm->id }}"
                                    value="{{ $soapTerbaru->rm->o_abdomen_uraian }}" name="alasan-abdomen"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Abdomen Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="ekstremitas" style="width: 30%">11. Ekstremitas</label> :
                                <select name="ekstremitas" id="ekstremitas" class="form-control mt-3"
                                    style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-ekstremitas_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_ekstremitas === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_ekstremitas === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-ekstremitas_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_ekstremitas === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-ekstremitas_{{ $soapTerbaru->rm->id }}"
                                    name="alasan-ekstremitas" value="{{ $soapTerbaru->rm->o_ekstremitas_uraian }}"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Ekstremitas Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="kulit" style="width: 30%">12. Kulit</label> :
                                <select name="kulit" id="kulit" class="form-control mt-3" style="width: 40%"
                                    onclick="toggleChangeSoap('alasan-kulit_{{ $soapTerbaru->rm->id }}', this)">
                                    <option {{ $soapTerbaru->rm->o_kulit === 'Normal' ? 'selected' : '' }}
                                        id="jawaban-normal" value="Normal">Normal</option>
                                    <option {{ $soapTerbaru->rm->o_kulit === 'Abnormal' ? 'selected' : '' }}
                                        id="jawaban-abnormal" value="Abnormal">Abnormal</option>
                                </select>
                            </div>
                            <div id="alasan-kulit_{{ $soapTerbaru->rm->id }}"
                                style="{{ $soapTerbaru->rm->o_kulit === 'Abnormal' ? 'display: block;' : 'display: none;' }}">
                                <input type="text" id="alasan-kulit_{{ $soapTerbaru->rm->id }}"
                                    value="{{ $soapTerbaru->rm->o_kulit_uraian }}" name="alasan-kulit"
                                    class="form-control mt-2 mb-2" placeholder="Alasan Kulit Abnormal">
                            </div>
                            <div class="form"
                                style="display: flex; align-soapTerbarus: baseline; justify-content: space-between">
                                <label for="lain-lain" style="width: 30%">13. Lain-lain</label> :
                                <input type="text" id="lain" name="lain"
                                    value="{{ $soapTerbaru->rm->lain_lain }}" class="form-control mt-3 mb-2"
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
                                                    value="{{ $soapTerbaru->isian->p_tensi }}"
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
                                                    value="{{ $soapTerbaru->isian->p_rr }}"
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
                                                    value="{{ $soapTerbaru->isian->p_nadi }}"
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
                                                    value="{{ $soapTerbaru->isian->spo2 }}"
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
                                                    value="{{ $soapTerbaru->isian->p_suhu }}"
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
                                                    value="{{ $soapTerbaru->isian->p_tb }}"
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
                                                    value="{{ $soapTerbaru->isian->p_bb }}"
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
                                                    value="{{ $soapTerbaru->isian->p_imt }}"
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
                                        $tgllahir = \Carbon\Carbon::parse($soapTerbaru->pasien->tgllahir);
                                        $umur = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                                        $jenis_kelamin = $soapTerbaru->pasien->jekel;
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
                                                        value="{{ $soapTerbaru->isian->p_lngkr_kepala_anak }}"
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

                                        {{-- Lingkar Lengan --}}
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="lingkar-lengan">Lingkar Lengan</label>
                                                <div class="input-group">
                                                    <input type="text" name="p_lngkr_lengan_anc"
                                                        id="p_lngkr_lengan_anc"
                                                        value="{{ $soapTerbaru->isian->p_lngkr_lengan_anc }}"
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
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label for="soap_a_0" style="font-weight: bold">Diagnosa (A)</label>
                            <div class="col-md-12 mt-2">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Diagnosa Primer</label>
                                        @forelse ($diagnosaPrimer as $index => $diag)
                                            <input type="text" id="soap_a_{{ $index }}"
                                                name="soap_a[{{ $index }}][diagnosa_primer]"
                                                class="soap_a form-control mt-2 mb-2" value="{{ $diag }}"
                                                placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-primer-{{ $index }}"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        @empty
                                            <input type="text" id="soap_a_0" name="soap_a[0][diagnosa_primer]"
                                                class="soap_a form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-primer-0"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="col-6">
                                        <label>Diagnosa Sekunder</label>
                                        @forelse ($diagnosaSekunder as $index => $diag)
                                            <input type="text" id="soap_a_b_{{ $index }}"
                                                name="soap_a_b[{{ $index }}][diagnosa_sekunder]"
                                                class="soap_a_b form-control mt-2 mb-2" value="{{ $diag }}"
                                                placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-sekunder-{{ $index }}"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        @empty
                                            <input type="text" id="soap_a_b_0"
                                                name="soap_a_b[0][diagnosa_sekunder]"
                                                class="soap_a_b form-control mt-2 mb-2" placeholder="Cari Diagnosa">
                                            <div id="dropdown-diagnosa-sekunder-0"
                                                class="dropdown-menu diagnosa-dropdown"
                                                style="position: absolute; z-index: 1000; display: none; cursor: pointer; width: 50%;">
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3 mb-2">
                            <label for="soap_p_0"
                                style="font-weight: bold; margin-top: 10px; margin-bottom: 5px; width: 100%; cursor: pointer;">
                                Pilih Obat (P)
                            </label>
                            <div class="resep" id="resep">
                                @if (!empty($resep))
                                    @foreach ($resep as $index => $obat)
                                        <!-- Nama Obat -->
                                        <div class="input-row" id="namaObatContainer_{{ $index }}"
                                            style="display: flex; align-items: center; gap: 5px; overflow: visible !important;">
                                            <label for="namaobat" style="min-width: 100px;">Nama Obat</label>
                                            <span>:</span>
                                            <div class="input-wrapper" style="position: relative; flex-grow: 1;">
                                                <input type="text" class="form-control soap_p"
                                                    name="soap_p[{{ $index }}][resep]"
                                                    id="resep_{{ $index }}" value="{{ $obat }}"
                                                    placeholder="Cari Obat" autocomplete="off">
                                                <!-- Dropdown dipindahkan ke sini -->
                                                <ul id="dropdown-resep_{{ $index }}"
                                                    class="dropdown-menu-autocomplete"
                                                    style="cursor: pointer; display: none;">
                                                    <!-- Item akan di-append di sini -->
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Jenis Obat -->
                                        <div class="input-row" id="jenisObatContainer_{{ $index }}"
                                            style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                            <label for="jenisObat" style="min-width: 100px;">Jenis Obat</label>
                                            <span>:</span>
                                            <select name="soap_p[{{ $index }}][jenisobat]"
                                                id="jenis_obat_{{ $index }}" class="form-control">
                                                <option value="">--Pilih Jenis Obat--</option>
                                                <option value="Tablet"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Tablet' ? 'selected' : '' }}>
                                                    Tablet</option>
                                                <option value="Kapsul"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Kapsul' ? 'selected' : '' }}>
                                                    Kapsul</option>
                                                <option value="Bungkus"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Bungkus' ? 'selected' : '' }}>
                                                    Bungkus</option>
                                                <option value="Salep"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Salep' ? 'selected' : '' }}>
                                                    Salep</option>
                                                <option value="Sirup"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Sirup' ? 'selected' : '' }}>
                                                    Sirup</option>
                                                <option value="Mililiter"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Mililiter' ? 'selected' : '' }}>
                                                    Mililiter</option>
                                                <option value="Sendok Teh"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Sendok Teh' ? 'selected' : '' }}>
                                                    Sendok Teh</option>
                                                <option value="Sendok Makan"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Sendok Makan' ? 'selected' : '' }}>
                                                    Sendok Makan</option>
                                                <option value="Tetes"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Tetes' ? 'selected' : '' }}>
                                                    Tetes</option>
                                                <option value="Puyer/Racikan"
                                                    {{ isset($resepJenis[$index]) && $resepJenis[$index] == 'Puyer/Racikan' ? 'selected' : '' }}>
                                                    Puyer/Racikan</option>
                                            </select>
                                        </div>

                                        <!-- Aturan Minum Perhari -->
                                        <div class="input-row" id="aturanMinumContainer_{{ $index }}"
                                            style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                            <label for="aturan" style="min-width: 100px">Aturan Minum
                                                Perhari</label>
                                            <span>:</span>
                                            <select class="form-control" name="soap_p[{{ $index }}][aturan]"
                                                id="aturan_{{ $index }}">
                                                <option value="">--Pilih Aturan Minum--</option>
                                                <option value="1x1/5"
                                                    {{ isset($resepAturan[$index]) && $resepAturan[$index] == '1x1/5' ? 'selected' : '' }}>
                                                    1x1/5</option>
                                                <option value="2x1/5"
                                                    {{ isset($resepAturan[$index]) && $resepAturan[$index] == '2x1/5' ? 'selected' : '' }}>
                                                    2x1/5</option>
                                                <option value="3x1/5"
                                                    {{ isset($resepAturan[$index]) && $resepAturan[$index] == '3x1/5' ? 'selected' : '' }}>
                                                    3x1/5</option>
                                                <option value="3x2"
                                                    {{ isset($resepAturan[$index]) && $resepAturan[$index] == '3x2' ? 'selected' : '' }}>
                                                    3x2</option>
                                                <!-- Opsi lainnya -->
                                            </select>
                                        </div>

                                        <!-- Anjuran Minum -->
                                        <div class="input-row" id="anjuranMinumContainer_{{ $index }}"
                                            style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                            <label for="anjuran" style="min-width: 100px">Anjuran Minum</label>
                                            <span>:</span>
                                            <select name="soap_p[{{ $index }}][anjuran]"
                                                id="anjuran_{{ $index }}" class="form-control">
                                                <option value="">--Pilih Anjuran Minum--</option>
                                                <option value="AC"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'AC' ? 'selected' : '' }}>
                                                    AC</option>
                                                <option value="AD"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'AD' ? 'selected' : '' }}>
                                                    AD</option>
                                                <option value="AS"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'AS' ? 'selected' : '' }}>
                                                    AS</option>
                                                <option value="C"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'C' ? 'selected' : '' }}>
                                                    C</option>
                                                <option value="CTH"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'CTH' ? 'selected' : '' }}>
                                                    CTH</option>
                                                <option value="DC"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'DC' ? 'selected' : '' }}>
                                                    DC</option>
                                                <option value="PC"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'PC' ? 'selected' : '' }}>
                                                    PC</option>
                                                <option value="OD"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'OD' ? 'selected' : '' }}>
                                                    OD</option>
                                                <option value="OS"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'OS' ? 'selected' : '' }}>
                                                    OS</option>
                                                <option value="ODS"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'ODS' ? 'selected' : '' }}>
                                                    ODS</option>
                                                <option value="PRM"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'PRM' ? 'selected' : '' }}>
                                                    PRM</option>
                                                <option value="UE"
                                                    {{ isset($resepAnjuran[$index]) && $resepAnjuran[$index] == 'UE' ? 'selected' : '' }}>
                                                    UE</option>
                                                <!-- Opsi lainnya -->
                                            </select>
                                        </div>

                                        <!-- Jumlah Masing-masing Obat -->
                                        <div class="input-row" id="jumlahObatContainer_{{ $index }}"
                                            style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                                            <label for="jumlah" style="min-width: 100px">Jumlah</label>
                                            <span>:</span>
                                            <input type="number" name="soap_p[{{ $index }}][jumlah]"
                                                class="form-control" value="{{ $resepJumlah[$index] ?? '' }}"
                                                placeholder="Masukkan Jumlah Obat">
                                        </div>

                                        <hr>
                                    @endforeach
                                @else
                                    <!-- Untuk form kosong (jika tidak ada resep) -->
                                    <div class="input-row" id="namaObatContainer_0"
                                        style="display: flex; align-items: center; gap: 5px;">
                                        <label for="namaobat" style="min-width: 100px;">Nama Obat</label>
                                        <span>:</span>
                                        <div class="input-wrapper" style="position: relative; flex-grow: 1;">
                                            <input type="text" class="form-control soap_p" name="soap_p[0][resep]"
                                                id="resep_0" placeholder="Cari Obat" autocomplete="off">
                                            <ul id="dropdown-resep_0" class="dropdown-menu-autocomplete"
                                                style="cursor: pointer; display: none;">
                                                <!-- Item akan di-append di sini -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Lanjutkan dengan field lainnya -->
                                @endif
                            </div>

                            <button type="button" class="btn btn-outline-primary"
                                onclick="addColumn('jumlahObatContainer')" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Tambah Obat</span>">
                                <i class="fa-solid fa-pills"></i>
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="edukasi" style="font-weight: bold">Edukasi</label>
                            <input type="text" class="form-control mt-2 mb-2" name="edukasi" id="edukasi"
                                placeholder="Edukasi" value="{{ $soapTerbaru->edukasi }}">
                        </div>
                        <div class="form-group">
                            <label for="rujuk" style="font-weight: bold">Rencana Tindak Lanjut</label>
                            <select name="rujuk" id="rujuk" class="form-control mt-2 mb-2">
                                <option value="Tidak Ada" {{ $soapTerbaru->rujuk == 'Tidak Ada' ? 'selected' : '' }}>
                                    Tidak Ada</option>
                                <option value="Rumah Sakit"
                                    {{ $soapTerbaru->rujuk == 'Rumah Sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                                <option value="Laborat" {{ $soapTerbaru->rujuk == 'Laborat' ? 'selected' : '' }}>
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
@endif

@push('style')
    <!-- CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        #resep,
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

        #racikan {
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
@endpush

@push('script')
    <!-- JS Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
        // document.addEventListener('DOMContentLoaded', function() {
        //     // Fungsi untuk menampilkan dropdown diagnosa
        //     function showDiagnosaDropdown(inputElement, dropdownElement, results) {
        //         dropdownElement.innerHTML = '';
        //         if (results.length === 0) {
        //             dropdownElement.style.display = 'none';
        //             return;
        //         }

        //         results.forEach(function(result) {
        //             const option = document.createElement('div');
        //             option.classList.add('dropdown-item');
        //             option.textContent = result.text;
        //             option.dataset.id = result.id;

        //             option.addEventListener('click', function() {
        //                 inputElement.value = result.text;
        //                 dropdownElement.style.display = 'none';
        //             });

        //             dropdownElement.appendChild(option);
        //         });
        //         dropdownElement.style.display = 'block';
        //     }

        //     // Fungsi pencarian diagnosa
        //     function searchDiagnosa(term, callback) {
        //         if (term.length < 3) {
        //             callback([]);
        //             return;
        //         }

        //         fetch(`/search-diagnosa?term=${encodeURIComponent(term)}`)
        //             .then(response => response.json())
        //             .then(data => callback(data))
        //             .catch(error => console.error('Error:', error));
        //     }

        //     // Inisialisasi autocomplete untuk semua input diagnosa
        //     function initDiagnosaAutocomplete() {
        //         // Untuk diagnosa primer
        //         document.querySelectorAll('[id^="soap_a_"]').forEach(input => {
        //             const dropdownId = input.id.replace('soap_a_', 'dropdown-diagnosa-primer-');
        //             const dropdownElement = document.getElementById(dropdownId);

        //             if (dropdownElement) {
        //                 input.addEventListener('input', function() {
        //                     searchDiagnosa(this.value, function(results) {
        //                         showDiagnosaDropdown(input, dropdownElement, results);
        //                     });
        //                 });

        //                 // Sembunyikan dropdown saat klik di luar
        //                 document.addEventListener('click', function(e) {
        //                     if (!input.contains(e.target) && !dropdownElement.contains(e.target)) {
        //                         dropdownElement.style.display = 'none';
        //                     }
        //                 });
        //             }
        //         });

        //         // Untuk diagnosa sekunder
        //         document.querySelectorAll('[id^="soap_a_b_"]').forEach(input => {
        //             const dropdownId = input.id.replace('soap_a_b_', 'dropdown-diagnosa-sekunder-');
        //             const dropdownElement = document.getElementById(dropdownId);

        //             if (dropdownElement) {
        //                 input.addEventListener('input', function() {
        //                     searchDiagnosa(this.value, function(results) {
        //                         showDiagnosaDropdown(input, dropdownElement, results);
        //                     });
        //                 });

        //                 // Sembunyikan dropdown saat klik di luar
        //                 document.addEventListener('click', function(e) {
        //                     if (!input.contains(e.target) && !dropdownElement.contains(e.target)) {
        //                         dropdownElement.style.display = 'none';
        //                     }
        //                 });
        //             }
        //         });
        //     }

        //     // Panggil inisialisasi saat halaman dimuat
        //     initDiagnosaAutocomplete();
        // });

        // RESEP OBAT
        $(document).ready(function() {
            function initObatAutocomplete(inputElement) {
                const inputId = inputElement.attr('id');
                const dropdownId = `dropdown-${inputId}`;

                console.log(`Initializing autocomplete for ${inputId}`); // Debug

                // Cari dropdown yang terkait dengan input
                let dropdownElement = $(`#${dropdownId}`);

                // Minimalkan manipulasi DOM - jangan mengubah struktur yang sudah ada
                if (!dropdownElement.length) {
                    console.log(`Creating new dropdown for ${inputId}`); // Debug

                    // Cek apakah input sudah dalam wrapper
                    if (!inputElement.parent().hasClass('input-wrapper')) {
                        // Buat wrapper baru jika belum ada
                        const parent = inputElement.parent();
                        const inputWrapper = $(
                            '<div class="input-wrapper" style="position: relative; flex-grow: 1;"></div>');
                        inputElement.wrap(inputWrapper);
                    }

                    // Buat dropdown baru
                    dropdownElement = $(
                        `<ul id="${dropdownId}" class="dropdown-menu-autocomplete" style="cursor: pointer; display: none;"></ul>`
                    );
                    inputElement.after(dropdownElement);
                } else {
                    console.log(`Dropdown exists for ${inputId}`); // Debug

                    // Pastikan dropdown menggunakan kelas yang benar
                    dropdownElement.removeClass('dropdown-menu').addClass('dropdown-menu-autocomplete');

                    // Pastikan dropdown terletak setelah input dalam DOM
                    const currentParent = dropdownElement.parent();
                    if (!currentParent.is(inputElement.parent())) {
                        inputElement.after(dropdownElement);
                    }
                }

                // Event handler untuk input - tangkap input dengan debounce
                let debounceTimer;
                inputElement.off('input').on('input', function() {
                    const query = $(this).val().trim();

                    // Clear debounce timer
                    clearTimeout(debounceTimer);

                    if (query.length < 2) {
                        dropdownElement.hide().removeClass('show');
                        return;
                    }

                    // Set debounce timer untuk mengurangi jumlah request
                    debounceTimer = setTimeout(function() {
                        console.log(`Searching for: ${query}`); // Debug

                        $.ajax({
                            url: '/resep-autocomplete',
                            data: {
                                term: query
                            },
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                console.log(
                                    `Received ${data.length} results for ${inputId}`
                                ); // Debug

                                dropdownElement.empty();
                                if (data.length > 0) {
                                    data.forEach(item => {
                                        dropdownElement.append(
                                            `<li class="dropdown-item">${item.text}</li>`
                                        );
                                    });
                                    // Menampilkan dropdown dengan animasi
                                    dropdownElement.show().addClass('show');

                                    // Pastikan dropdown tidak melebihi batas layar
                                    positionDropdown(inputElement, dropdownElement);
                                } else {
                                    dropdownElement.append(
                                        '<li class="dropdown-item disabled">Tidak ada hasil</li>'
                                    );
                                    // Menampilkan dropdown dengan animasi
                                    dropdownElement.show().addClass('show');

                                    // Pastikan dropdown tidak melebihi batas layar
                                    positionDropdown(inputElement, dropdownElement);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(`Error in autocomplete: ${error}`); // Debug
                                dropdownElement.hide().removeClass('show');
                            }
                        });
                    }, 300); // 300ms debounce
                });

                // Pilih item dropdown - perhatikan selector yang digunakan
                dropdownElement.off('click').on('click', '.dropdown-item:not(.disabled)', function() {
                    const selectedValue = $(this).text();
                    console.log(`Selected: ${selectedValue} for ${inputId}`); // Debug
                    inputElement.val(selectedValue);
                    dropdownElement.hide().removeClass('show');
                });

                // Sembunyikan saat klik di luar
                $(document).off('click.autocomplete').on('click.autocomplete', function(e) {
                    if (!inputElement.is(e.target) && !dropdownElement.is(e.target) &&
                        dropdownElement.has(e.target).length === 0) {
                        dropdownElement.hide().removeClass('show');
                    }
                });

                // Tangkap event focus untuk menunjukkan dropdown jika ada pencarian sebelumnya
                inputElement.off('focus').on('focus', function() {
                    const query = $(this).val().trim();
                    if (query.length >= 2) {
                        // Trigger input event untuk menampilkan dropdown
                        inputElement.trigger('input');
                    }
                });
            }

            // Fungsi untuk memposisikan dropdown secara optimal
            function positionDropdown(inputElement, dropdownElement) {
                const inputRect = inputElement[0].getBoundingClientRect();
                const windowHeight = $(window).height();
                const dropdownHeight = dropdownElement.outerHeight();

                // Hitung posisi top dan left
                const left = 0; // Relatif terhadap parent
                const top = inputElement.outerHeight() + 2; // 2px margin dari input

                // Cek apakah ada cukup ruang di bawah input
                const spaceBelow = windowHeight - (inputRect.top + inputRect.height);

                if (spaceBelow < dropdownHeight && inputRect.top > dropdownHeight) {
                    // Jika tidak cukup ruang di bawah tapi cukup di atas, tampilkan di atas
                    dropdownElement.css({
                        top: 'auto',
                        bottom: '100%',
                        marginBottom: '5px',
                        marginTop: '0'
                    });
                } else {
                    // Tampilkan di bawah (default)
                    dropdownElement.css({
                        top: top + 'px',
                        bottom: 'auto',
                        left: left + 'px',
                        width: '100%'
                    });
                }
            }

            // Inisialisasi autocomplete untuk semua input awal - dengan delay untuk memastikan DOM sudah siap
            setTimeout(function() {
                console.log('Initializing all existing autocomplete fields'); // Debug
                $('input[id^="resep_"]').each(function() {
                    // Pastikan nilai input dipertahankan
                    const currentValue = $(this).val();

                    // Pastikan input berada di dalam container yang benar
                    const inputId = $(this).attr('id');
                    const container = $(this).closest('.input-row');

                    // Jika tidak berada dalam struktur yang benar, sesuaikan struktur
                    if (!$(this).parent().hasClass('input-wrapper')) {
                        // Bungkus dalam input-wrapper dengan posisi relative
                        $(this).wrap(
                            '<div class="input-wrapper" style="position: relative; flex-grow: 1;"></div>'
                        );

                        // Periksa apakah dropdown sudah ada
                        const dropdownId = `dropdown-${inputId}`;
                        let dropdownElement = $(`#${dropdownId}`);

                        if (!dropdownElement.length) {
                            // Buat dropdown baru jika belum ada
                            dropdownElement = $(
                                `<ul id="${dropdownId}" class="dropdown-menu-autocomplete" style="cursor: pointer; display: none;"></ul>`
                            );
                            $(this).after(dropdownElement);
                        } else {
                            // Pastikan dropdown berada di posisi yang benar
                            $(this).after(dropdownElement);
                        }
                    }

                    // Inisialisasi autocomplete
                    initObatAutocomplete($(this));

                    // Kembalikan nilai setelah inisialisasi
                    if (currentValue) $(this).val(currentValue);
                });
            }, 500);

            // Tambah kolom baru dengan autocomplete
            let kolomIndex = {{ !empty($resep) ? count($resep) : 1 }};
            window.addColumn = function() {
                const newElement = `
                <div class="input-package new-package" id="package_${kolomIndex}" style="display: contents; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
                    <label for="soap_p_${kolomIndex}" style="font-weight: bold; margin-top: 20px;">Pilih Obat Baru (P)</label>

                    <!-- Nama Obat -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="resep_${kolomIndex}" style="min-width: 100px;">Nama Obat</label>
                        <span>:</span>
                        <div class="input-wrapper" style="position: relative; flex-grow: 1;">
                            <input type="text" class="form-control soap_p" name="soap_p[${kolomIndex}][resep]" id="resep_${kolomIndex}" placeholder="Cari Obat" autocomplete="off">
                            <ul id="dropdown-resep_${kolomIndex}" class="dropdown-menu-autocomplete" style="cursor: pointer; display: none;"></ul>
                        </div>
                    </div>

                    <!-- Jenis Obat -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="jenis_obat_${kolomIndex}" style="min-width: 100px;">Jenis Obat</label>
                        <span>:</span>
                        <select name="soap_p[${kolomIndex}][jenisobat]" id="jenis_obat_${kolomIndex}" class="form-control" required>
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
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="aturan_${kolomIndex}" style="min-width: 100px;">Aturan Minum Perhari</label>
                        <span>:</span>
                        <select class="form-control" name="soap_p[${kolomIndex}][aturan]" id="aturan_${kolomIndex}" required>
                            <option value="">--Pilih Aturan Minum--</option>
                            <option value="1x1/5">1x1/5</option>
                            <option value="2x1/5">2x1/5</option>
                            <option value="3x1/5">3x1/5</option>
                            <option value="3x2">3x2</option>
                        </select>
                    </div>

                    <!-- Anjuran Minum -->
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="anjuran_${kolomIndex}" style="min-width: 100px;">Anjuran Minum</label>
                        <span>:</span>
                        <select name="soap_p[${kolomIndex}][anjuran]" id="anjuran_${kolomIndex}" class="form-control" required>
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
                    <div class="input-row" style="display: flex; align-items: center; gap: 5px; margin-right: 10px;">
                        <label for="jumlah_${kolomIndex}" style="min-width: 100px;">Jumlah</label>
                        <span>:</span>
                        <input type="number" name="soap_p[${kolomIndex}][jumlah]" id="jumlah_${kolomIndex}" class="form-control" placeholder="Masukkan Jumlah Obat" required>
                    </div>

                    <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-danger btn-wide" style="width: 50px; padding: 5px 10px; margin-bottom: 5px" onclick="$(this).closest('.input-package').remove()">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;

                $('#resep').append(newElement);
                // Tunggu sebentar untuk memastikan DOM sudah diperbarui
                setTimeout(function() {
                    console.log(
                        `Initializing autocomplete for new field: resep_${kolomIndex}`); // Debug
                    initObatAutocomplete($(`#resep_${kolomIndex}`));
                    kolomIndex++;
                }, 100);
            }

            // Tambahkan fungsi troubleshooting untuk memudahkan debugging
            window.checkAutocomplete = function() {
                $('input[id^="resep_"]').each(function() {
                    const inputId = $(this).attr('id');
                    const dropdownId = `dropdown-${inputId}`;
                    console.log(
                        `Input: ${inputId}, Value: "${$(this).val()}", Dropdown exists: ${$(`#${dropdownId}`).length > 0}`
                    );
                });
            }

            // Panggil fungsi pengecekan setelah halaman dimuat
            setTimeout(checkAutocomplete, 1000);
        });

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
