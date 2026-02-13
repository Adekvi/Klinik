{{-- modal soap --}}
<div class="modal fade" id="modalSoap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Tindakan Dokter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('dokter/store/' . $id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profesi" style="font-weight: bold">Dokter Penanggung Jawab Pasien</label>
                                <input type="text" style="font-weight: bold"
                                    value="{{ $antrianDokter->dokter->nama_dokter }}" class="form-control mt-2"
                                    disabled>
                            </div>
                        </div>
                    </div>
                     {{-- Info Pasien --}}
                    <div class="card shadow-sm mb-4 mt-4">
                        <div class="card-header bg-info text-white fw-bold p-2">
                            Info Pasien
                        </div>
                        <div class="card-body">
                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <div><strong>Nama :</strong> {{ $antrianDokter->booking->pasien->nama_pasien }}</div>
                                </div>
                                <div class="col-6">
                                    <div><strong>Tanggal Lahir :</strong>  {{ \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir)->translatedFormat('d F Y') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>Umur :</strong> {{ \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir)->age }} Tahun</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>No. RM :</strong> {{ $antrianDokter->booking->pasien->no_rm }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>Jenis Kelamin :</strong> {{ $antrianDokter->booking->pasien->jekel ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>Alamat Asal :</strong> {{ $antrianDokter->booking->pasien->alamat_asal ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>Domisili :</strong> {{ $antrianDokter->booking->pasien->domisili ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
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
                        @php
                            $isianPilihan = trim(optional($antrianDokter->isian)->p_form_isian_pilihan ?? '');
                        @endphp

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
                            style="{{ $isianPilihan === 'Aloanamnesis' ? 'display:block' : 'display:none' }}">
                            <input type="text" class="form-control" value="{{ optional($antrianDokter->isian)->p_form_isian_pilihan_uraian }}">
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const value = @json($isianPilihan);

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
                    {{-- DIAGNOSA --}}
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
                        <label class="fw-bold mb-2">Pilih Obat (P)</label>

                        <div id="obat-form" class="mb-3">

                            <!-- Nama Obat (Full) -->
                            <div class="mb-2">
                                <input type="text"
                                    id="nama-obat-input"
                                    class="form-control"
                                    placeholder="Cari Nama Obat"
                                    autocomplete="off"
                                    data-url="{{ url('/resep-autocomplete') }}">
                            </div>

                            <!-- Field Pendek -->
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <input type="text"
                                        id="jenis-sediaan-input"
                                        class="form-control"
                                        placeholder="Jenis Sediaan"
                                        autocomplete="off"
                                        data-url="{{ url('/jenis-autocomplete') }}">
                                </div>

                                <div class="col-md-3">
                                    <input type="text"
                                        id="aturan-pakai-input"
                                        class="form-control"
                                        placeholder="Aturan Pakai"
                                        autocomplete="off"
                                        data-url="{{ url('/aturan-autocomplete') }}">
                                </div>

                                <div class="col-md-3">
                                    <input type="text"
                                        id="anjuran-minum-input"
                                        class="form-control"
                                        placeholder="Anjuran Minum"
                                        autocomplete="off"
                                        data-url="{{ url('/anjuran-autocomplete') }}">
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
                                class="form-control mb-3" name="ObatRacikan"></textarea>

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

@push('style')
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
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
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

    function updateBadges() {
        diagnosaList.querySelectorAll('li').forEach((li) => {
            const badge = li.querySelector('span.badge');
            badge.textContent = li.classList.contains('primer') ? 'Primer' : 'Sekunder';
        });
    }

    function addDiagnosa(value) {
        if (!value.trim()) return;

        const li = document.createElement('li');
        li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

        // Tandai primer otomatis kalau list kosong
        if (diagnosaList.children.length === 0) li.classList.add('primer');

        const badge = document.createElement('span');
        badge.classList.add('badge', 'bg-info', 'me-2');
        li.appendChild(badge);

        const textNode = document.createTextNode(value);
        li.appendChild(textNode);

        // Input hidden
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'diagnosa[]';
        hidden.value = value;
        li.appendChild(hidden);

        // Tombol hapus
        const removeBtn = document.createElement('button');
        removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
        removeBtn.textContent = 'Hapus';
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            li.remove();
            updateBadges();
        });
        li.appendChild(removeBtn);

        // Klik pada nama diagnosa → toggle primer/sekunder
        li.addEventListener('click', function(e) {
            if (e.target === removeBtn) return; // jangan toggle kalau klik hapus
            if (li.classList.contains('primer')) {
                li.classList.remove('primer'); // primer → sekunder
            } else {
                // jadikan ini primer, sekunder lainnya
                diagnosaList.querySelectorAll('li').forEach(item => item.classList.remove('primer'));
                li.classList.add('primer');
            }
            updateBadges();
        });

        diagnosaList.appendChild(li);
        updateBadges();
    }

    addBtn.addEventListener('click', function() {
        addDiagnosa(input.value.trim());
        input.value = '';
    });
});
</script>

    <script>
          // RESEP
        document.addEventListener('DOMContentLoaded', function () {

            /* ===============================
            AUTOCOMPLETE GENERIC
            =============================== */
            function setupAutocomplete(input) {
                const url = input.dataset.url;
                if (!url) return;

                const dropdown = document.createElement('div');
                dropdown.className = 'autocomplete-dropdown list-group position-absolute w-100';
                dropdown.style.zIndex = 1000;

                input.parentElement.style.position = 'relative';
                input.parentElement.appendChild(dropdown);

                let controller;

                input.addEventListener('input', function () {
                    const term = this.value.trim();

                    if (term.length < 2) {
                        dropdown.innerHTML = '';
                        dropdown.style.display = 'none';
                        return;
                    }

                    if (controller) controller.abort();
                    controller = new AbortController();

                    fetch(`${url}?term=${encodeURIComponent(term)}`, {
                        signal: controller.signal
                    })
                    .then(res => res.json())
                    .then(data => {
                        dropdown.innerHTML = '';

                        if (!Array.isArray(data) || data.length === 0) {
                            dropdown.innerHTML =
                                `<div class="list-group-item disabled">Tidak ada data</div>`;
                        } else {
                            data.forEach(item => {
                                const option = document.createElement('button');
                                option.type = 'button';
                                option.className = 'list-group-item list-group-item-action';
                                option.textContent = item.text ?? item.nama ?? item.nama_obat ?? '-';

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
                        dropdown.innerHTML =
                            `<div class="list-group-item disabled">Gagal mengambil data</div>`;
                        dropdown.style.display = 'block';
                    });
                });

                document.addEventListener('click', e => {
                    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.style.display = 'none';
                    }
                });
            }

            /* ===============================
            INIT AUTOCOMPLETE
            =============================== */
            [
                'nama-obat-input',
                'jenis-sediaan-input',
                'aturan-pakai-input',
                'anjuran-minum-input'
            ].forEach(id => {
                const el = document.getElementById(id);
                if (el) setupAutocomplete(el);
            });

            /* ===============================
            FORM ELEMENT
            =============================== */
            const namaObatInput     = document.getElementById('nama-obat-input');
            const jenisSediaanInput = document.getElementById('jenis-sediaan-input');
            const aturanPakaiInput  = document.getElementById('aturan-pakai-input');
            const anjuranMinumInput = document.getElementById('anjuran-minum-input');
            const jumlahInput       = document.getElementById('jumlah-input');
            const addBtn            = document.getElementById('add-obat-btn');
            const obatList          = document.getElementById('obat-list');

            /* ===============================
            HELPER
            =============================== */
            function clearInputs() {
                namaObatInput.value = '';
                jenisSediaanInput.value = '';
                aturanPakaiInput.value = '';
                anjuranMinumInput.value = '';
                jumlahInput.value = '';
            }

            /* ===============================
            ADD OBAT
            =============================== */
            function addObat() {
                const namaObat = namaObatInput.value.trim();
                const jumlah   = jumlahInput.value.trim();

                if (!namaObat) return;

                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-start';

                const detail = `${namaObat} | ${jenisSediaanInput.value || '-'} | ${aturanPakaiInput.value || '-'} | ${anjuranMinumInput.value || '-'} | QTY: ${jumlah}`;

                li.innerHTML = `
                    <div>
                        ${detail}
                    </div>
                    <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                `;

                // Hidden input untuk form
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'obat[]';
                hidden.value = JSON.stringify({
                    nama: namaObat,
                    jenis_sediaan: jenisSediaanInput.value,
                    aturan: aturanPakaiInput.value,
                    anjuran: anjuranMinumInput.value,
                    jumlah: jumlah
                });
                li.appendChild(hidden);

                li.querySelector('button').addEventListener('click', () => li.remove());

                obatList.appendChild(li);
                clearInputs();
            }


            /* ===============================
            EVENTS
            =============================== */
            addBtn.addEventListener('click', addObat);

            jumlahInput.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addObat();
                }
            });

        });
    </script>

@endpush
