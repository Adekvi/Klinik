<div class="modal fade" id="editperiksa{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="periksa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <form id="myForm1" action="#" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-header bg-primary">
            <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white;">Asesmen Keperawatan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <button type="button" class="btn btn-primary" id="btnAsesmen{{ $item->id }}" style="margin-bottom: 20px">Asesmen Awal</button>
              <button type="button" class="btn btn-primary" id="btnKajian{{ $item->id }}" style="margin-bottom: 20px">Kajian Awal</button>
              
              @php
                  use Carbon\Carbon;
  
                  // Ambil waktu pembuatan data
                  $createdAt = optional($item->rm)->created_at;
                  $thirtyMinutesLater = $createdAt ? Carbon::parse($createdAt)->addMinutes(30) : null;
                  $now = Carbon::now();
              @endphp
  
              @if($createdAt && $now->lessThanOrEqualTo($thirtyMinutesLater))
                  <input type="hidden" name="idrm" value="{{ $item->rm->id }}">
                  <div class="anamnesis-s">
                      <h5 style="section-title" onclick="anamnesisS()">Anamnesis (S)</h5>
                      <div class="form-group">
                      <label for="keluhan" onclick="toggleInput('a_keluhan_utama')">1. Keluhan Utama </label>
                      <input type="text" name="a_keluhan_utama" id="a_keluhan_utama" class="form-control mt-2 mb-2 " placeholder="Isi Keluhan Utama"  value="{{ $item->rm->a_keluhan_utama ?? '' }}">
                      </div>
                  </div>
                  <div class="tanda-vital mt-4">
                      <h5 style="section-title; margin-bottom: 5px" onclick="tandaVital()">Tanda Vital</h5>
                      <div class="col-lg-12 mb-2">
                          <div class="row">
                              <div class="col-6">
                                  <label for="tensi">Tensi</label>
                                  <div class="input-group">
                                      <input type="text" name="tensi" value="{{ $item->isian->p_tensi ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>mmHg</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <label for="tensi">RR</label>
                                  <div class="input-group">
                                      <input type="text" name="rr" value="{{ $item->isian->p_rr ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>/ minute</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-12 mb-2">
                          <div class="row">
                              <div class="col-6">
                                  <label for="tensi">Nadi</label>
                                  <div class="input-group">
                                      <input type="text" name="nadi" value="{{ $item->isian->p_nadi ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>/ minute</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <label for="spo">SpO2</label>
                                  <div class="input-group">
                                      <input type="text" name="spo2" value="{{ $item->isian->p_suhu ?? '' }}"  class="form-control" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>%</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-12 mb-2">
                          <div class="row">
                              <div class="col-6">
                                  <label for="tensi">Suhu</label>
                                  <div class="input-group">
                                      <input type="text" name="suhu" value="{{ $item->isian->p_suhu ?? '' }}"  class="form-control" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>°c</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <label for="tensi">Tinggi Badan</label>
                                  <div class="input-group">
                                      <input type="number" name="tb" id="tb" value="{{ $item->isian->p_tb ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>cm</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-12 mb-2">
                          <div class="row">
                              <div class="col-6">
                                  <label for="tensi">Berat Badan</label>
                                  <div class="input-group">
                                      <input type="number" name="bb" id="bb" value="{{ $item->isian->p_bb ?? '' }}"  class="form-control" aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>kg</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <label for="tensi">IMT</label>
                                  <div class="input-group">
                                      <input type="text" name="p_imt" id="l_imt" value="{{ $item->isian->p_imt ?? '' }}" class="form-control" aria-describedby="basic-addon2" readonly>
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                            <b>kg/m2</b>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <h5 for="ak_nama_perawat_bidan" style="margin-top: 30px; text-align: center"><strong>Tanda Tangan Perawat</strong></h5>
                      <select type="text" name="ak_nama_perawat_bidan" id="ak_nama_perawat_bidan" class="form-control mt-2 mb-2">
                          <option value="">Nama Perawat</option>
                          <!-- Iterate through your perawat data to populate the dropdown -->
                          @foreach ($ttd as $item)
                              <option value="{{ $item->id }}" data-image="{{ Storage::url($item->foto) }}">{{ $item->nama }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="">TTD</label>
                      <img id="ttd_perawat_image" src="" alt="Tanda Tangan Perawat" style="border-radius: 5px;margin-top: 10px;width: 200px; height: 150px; display: none;">
                  </div>
              @else
                  <div id="formAsesmen{{ $item->id }}" style="display: none">
                      <div class="anamnesis-s" style="margin-bottom: 30px">
                          <h5 style="section-title; text-align: center"><strong>1. Anamnesis (S)</strong></h5>
                          <div class="form-group">
                              <label for="keluhan">1. Keluhan Utama </label>
                              <input type="text" name="a_keluhan_utama" id="a_keluhan_utama" class="form-control mt-2 mb-2 " placeholder="Isi Keluhan Utama" value="{{ $item->rm->a_keluhan_utama ?? '' }}">
                          </div>
                          <div class="form-group">
                              <label for="riwayat-penyakit-skrg">2. Riwayat Penyakit Sekarang</label>
                              <input type="text" name="a_riwayat_penyakit_skrg" id="a_riwayat_penyakit_skrg" class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Sekarang"  value="{{ $item->rm->a_riwayat_penyakit_skrg ?? '' }}">
                          </div>
                          <div class="form-group">
                              <label for="riwayat-penyakit-terdahulu">3. Riwayat Penyakit Terdahulu</label>
                              <input type="text" name="a_riwayat_penyakit_terdahulu" id="a_riwayat_penyakit_terdahulu" class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Terdahulu" value="{{ $item->rm->a_riwayat_penyakit_terdahulu ?? '' }}">
                          </div>
                          <div class="form-group">
                              <label for="riwayat-penyakit-keluarga">4. Riwayat Penyakit Keluarga</label>
                              <input type="text" name="a_riwayat_penyakit_keluarga" id="a_riwayat_penyakit_keluarga" class="form-control mt-2 mb-2 " placeholder="Isi Riwayat Penyakit Keluarga" value="{{ $item->rm->a_riwayat_penyakit_keluarga ?? '' }}">
                          </div>
                          <div class="form-group">
                              <label for="riwayat-alergi">5. Riwayat Alergi</label>
                              <select name="a_riwayat_alergi" id="a_riwayat_alergi" class="form-control mt-2 mb-2 " >
                              <option value="{{ $item->rm->a_riwayat_penyakit_skrg ?? 'Tidak Ada' }}" selected>{{ $item->rm->a_riwayat_alergi ?? 'Tidak Ada' }}</option>
                              <option value="Ada">Ada</option>
                              <option value="Tidak">Tidak</option>
                              </select>
                          </div>
                      </div>
      
                      <div class="tanda-vital" style="margin-bottom: 30px">
                          <h5 style="section-title; text-align: center;"><strong>2. Tanda Vital</strong></h5>
                              <div class="col-lg-12 mb-2">
                                  <div class="row">
                                      <div class="col-6">
                                          <label for="tensi">Tensi</label>
                                          <div class="input-group">
                                              <input type="text" name="tensi" value="{{ $item->isian->p_tensi ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>mmHg</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <label for="tensi">RR</label>
                                          <div class="input-group">
                                              <input type="text" name="rr" value="{{ $item->isian->p_rr ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>/ minute</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-12 mb-2">
                                  <div class="row">
                                      <div class="col-6">
                                          <label for="tensi">Nadi</label>
                                          <div class="input-group">
                                              <input type="text" name="nadi" value="{{ $item->isian->p_nadi ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>/ minute</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <label for="spo">SpO2</label>
                                          <div class="input-group">
                                              <input type="text" name="spo2" value="{{ $item->isian->p_suhu ?? '' }}"  class="form-control" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>%</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-12 mb-2">
                                  <div class="row">
                                      <div class="col-6">
                                          <label for="tensi">Suhu</label>
                                          <div class="input-group">
                                              <input type="text" name="suhu" value="{{ $item->isian->p_suhu ?? '' }}"  class="form-control" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>°c</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <label for="tensi">Tinggi Badan</label>
                                          <div class="input-group">
                                              <input type="number" name="tb" id="p_tb" value="{{ $item->isian->p_tb ?? '' }}" class="form-control" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>cm</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-12 mb-2">
                                  <div class="row">
                                      <div class="col-6">
                                          <label for="tensi">Berat Badan</label>
                                          <div class="input-group">
                                              <input type="number" name="bb" id="p_bb" value="{{ $item->isian->p_bb ?? '' }}"  class="form-control" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>kg</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <label for="tensi">IMT</label>
                                          <div class="input-group">
                                              <input type="text" name="p_imt" id="p_imt" value="{{ $item->isian->p_imt ?? '' }}" class="form-control" aria-describedby="basic-addon2" readonly>
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                  <b>kg/m2</b>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                      </div>
      
                      <div class="anamnesis-o" style="margin-bottom: 30px">
                          <h5 style="section-title; text-align: center;"><strong>3. Pemeriksaan Fisik Umum (0)</strong></h5>
                              <div class="form-group">
                                  <label for="keadaan_umum">1. Keadaan Umum</label>
                                  <input type="text" name="keadaan_umum" id="keadaan_umum" class="form-control mt-2 mb-2 " placeholder="Isi Keadaan Umum" value="{{ $item->rm->o_keadaan_umum ?? '' }}">
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  {{-- <p onclick="toggleInput('kesadaran')" style="margin-bottom: 5px;">6. Kesadaran</p> --}}
                                  <label for="kesadaran">2. Kesadaran</label>
                                  <select name="kesadaran" id="kesadaran" class="form-control">
                                      <option value="Compos Mentis">Compos Mentis</option>
                                      <option value="Somnolence">Somnolence</option>
                                      <option value="Sopor">Sopor</option>
                                      <option value="Coma">Coma</option>
                                  </select>
                              </div>
                              <div class="col-lg-6 mb-3">
                                  <div class="row">
                                      <div class="col-12">
                                          <label for="gcs">3. GCS</label>
                                          <div class="input-group d-flex mt-2">
                                              <input type="text" name="gcs_e" id="gcs_e" value="{{ $item->isian->gcs_e ?? '' }}" class="form-control" aria-describedby="basic-addon2" placeholder="E">
                                              <input type="text" name="gcs_m" id="gcs_m" value="{{ $item->isian->gcs_m ?? '' }}" class="form-control" aria-describedby="basic-addon2" placeholder="M">
                                              <input type="text" name="gcs_v" id="gcs_v" value="{{ $item->isian->gcs_v ?? '' }}" class="form-control" aria-describedby="basic-addon2" placeholder="V">
                                              <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                                      Total: &nbsp; <span id="gcs_total"> <b>0</b></span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px">4. Kepala</p>
                                  <div id="kepala">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="kepala" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-kepala_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="kepala" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-kepala_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-kepala_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-kepala_{{ $item->id }}" name="alasan-kepala" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">5. Mata</p>
                                  <div id="mata">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="mata" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-mata_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="mata" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-mata_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-mata_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-mata_{{ $item->id }}" name="alasan-mata" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">6. Leher</p>
                                  <div id="leher">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="leher" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-leher_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="leher" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-leher_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-leher_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-leher_{{ $item->id }}" name="alasan-leher" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">7. THT (Telinga Hidung Tenggorokan)</p>
                                  <div id="tht">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="tht" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-tht_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="tht" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-tht_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-tht_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-tht_{{ $item->id }}" name="alasan-tht" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">8. Thorax</p>
                                  <div id="thorax">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="thorax" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-thorax_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="thorax" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-thorax_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-thorax_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-thorax_{{ $item->id }}" name="alasan-thorax" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">9. Paru</p>
                                  <div id="paru">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="paru" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-paru_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="paru" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-paru_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-paru_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-paru_{{ $item->id }}" name="alasan-paru" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">10. Jantung</p>
                                  <div id="jantung">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="jantung" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-jantung_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="jantung" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-jantung_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-jantung_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-jantung_{{ $item->id }}" name="alasan-jantung" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">11. Abdomen</p>
                                  <div id="abdomen">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="abdomen" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-abdomen_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="abdomen" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-abdomen_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-abdomen_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-abdomen_{{ $item->id }}" name="alasan-abdomen" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">12. Ekstremitas / Anggota Gerak</p>
                                  <div id="ekstremitas">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="ekstremitas" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-ekstremitas_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="ekstremitas" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-ekstremitas_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-ekstremitas_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-ekstremitas_{{ $item->id }}" name="alasan-ekstremitas" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <p style="margin-bottom: 5px;">13. Kulit</p>
                                  <div id="kulit">
                                  <label for="jawaban-normal">
                                      <input type="radio" name="kulit" id="jawaban-normal" value="Normal" checked onclick="toggleChange('alasan-kulit_{{ $item->id }}', this)"> Normal
                                  </label>
                                  <label for="jawaban-abnormal">
                                      <input class="mx-3" type="radio" name="kulit" id="jawaban-abnormal" value="Abnormal" onclick="toggleChange('alasan-kulit_{{ $item->id }}', this)"> Abnormal
                                  </label>
                                  </div>
                                  <div id="alasan-kulit_{{ $item->id }}" style="display: none;">
                                  <input type="text" id="alasan-kulit_{{ $item->id }}" name="alasan-kulit" class="form-control mt-2 mb-2">
                                  </div>
                              </div>
                              <div class="form-group mt-2 mb-2">
                                  <label for="lain-lain"> 14. Lain - Lain</label>
                                  <input type="text" name="lain" id="lain" class="form-control mt-2 mb-2" placeholder="Lain-lain">
                              </div>
                      </div>
                  
                      <div class="form-isian" style="margin-bottom: 30px">
                          <h5 style="section-title; text-align: center"><strong>4. Form Isian</strong></h5>
                          <div class="form-group mt-2 mb-2">
                              <p onclick="toggleInput('isian')" style="margin-bottom: 3px; text-align: center">Isian Pilihan</p>
                              <div id="isian" style="text-align: center">
                                  <label for="isian-ya">
                                      <input type="radio" name="isian" id="isian-ya" value="auto-anamnesis" onclick="toggleChange('alasan-isian', this)"> Auto Anamnesis
                                  </label>
                                  <label for="isian-tidak">
                                      <input type="radio" name="isian" id="isian-tidak" value="Aloanamnesis" onclick="toggleChange('alasan-isian', this)"> Aloanamnesis
                                  </label>
                              </div>
                              <div id="alasan-isian" style="display: none;">
                              <input type="text" id="isian_alasan" name="isian_alasan" class="form-control mt-2 mb-2" placeholder="Alasan">
                              </div>
                          </div>
                      </div>
      
                      <div class="form-group">
                          <h5 for="ak_ttdperawat_bidan" style="margin-top: 30px; text-align: center"><strong>Tanda Tangan Perawat</strong></h5>
                          <select type="text" name="ak_ttdperawat_bidan" id="ak_ttdperawat_bidan" class="form-control mt-2 mb-2" required>
                              <option value="">Nama Perawat</option>
                              <!-- Iterate through your perawat data to populate the dropdown -->
                              @foreach ($ttd as $item)
                                  <option value="{{ $item->id }}" data-image="{{ Storage::url($item->foto) }}">{{ $item->nama }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="">TTD</label>
                          <img id="ttd_perawat_image" src="" alt="Tanda Tangan Perawat" style="border-radius: 5px;margin-top: 10px;width: 200px; height: 150px; display: none;">
                      </div>
                  </div>
                  <div id="formKajian{{ $item->id }}" style="display: none">
                      <div class="accordion">
                          <div class="step">
                              <div class="kebiasaan" style="margin-top: 20px">
                                  <h5 class="step-title" style="section-title" onclick="toggleStep(this)">5. Kebiasaan</h5>
                                  <div class="step-content">
                                      <div class="form-group mt-2 mb-2">
                                          <p style="margin-bottom: 5px;">1. Rokok</p>
                                          <div id="rokok">
                                              <label for="rokok-ya">
                                                  <input type="radio" name="rokok" id="rokok-ya" value="Ya"> Ya
                                              </label>
                                              <label for="rokok-tidak">
                                                  <input type="radio" name="rokok" id="rokok-tidak" value="Tidak" checked> Tidak
                                              </label>
                                          </div>
                                      </div>
                                      <div class="form-group mt-2 mb-2">
                                          <p style="margin-bottom: 5px;">2. Alkohol</p>
                                          <div id="alkohol">
                                          <label for="alkohol-ya">
                                              <input type="radio" name="alkohol" id="alkohol-ya" value="Ya"> Ya
                                          </label>
                                          <label for="alkohol-tidak">
                                              <input type="radio" name="alkohol" id="alkohol-tidak" value="Tidak" checked> Tidak
                                          </label>
                                          </div>
                                      </div>
                                      <div class="form-group mt-2 mb-2">
                                          <p style="margin-bottom: 5px;">3. Obat Tidur</p>
                                          <div id="obat_tidur">
                                          <label for="obat_tidur-ya">
                                              <input type="radio" name="obat_tidur" id="obat_tidur-ya" value="Ya"> Ya
                                          </label>
                                          <label for="obat_tidur-tidak">
                                              <input type="radio" name="obat_tidur" id="obat_tidur-tidak" value="Tidak" checked> Tidak
                                          </label>
                                          </div>
                                      </div>
                                      <div class="form-group mt-2 mb-2">
                                          <p style="margin-bottom: 5px;">4. Olahraga</p>
                                          <div id="olahraga">
                                          <label for="olahraga-ya">
                                              <input type="radio" name="olahraga" id="olahraga-ya" value="Ya"> Ya
                                          </label>
                                          <label for="olahraga-tidak">
                                              <input type="radio" name="olahraga" id="olahraga-tidak" value="Tidak"  checked> Tidak
                                          </label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
  
                          <div class="step">
                              <div class="riwayat-lahir">
                                  <h5 class="step-title" style="section-title" onclick="toggleStep(this)">6. Riwayat Lahir</h5>
                                  <div class="step-content">
                                      <div class="form-group">
                                          <label for="p_anak_riwayat_lahir">1. Riwayat Lahir</label>
                                          <select name="p_anak_riwayat_lahir" id="p_anak_riwayat_lahir" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih Riwayat</option>
                                          <option value="Spontan">Spontan</option>
                                          <option value="Operasi">Operasi</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="p_anak_riwayat_lahir_bulan" onclick="toggleInput('p_anak_riwayat_lahir_bulan')">2. Riwayat Lahir Bulan</label>
                                          <select name="p_anak_riwayat_lahir_bulan" id="p_anak_riwayat_lahir_bulan" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih Riwayat</option>
                                          <option value="Cukup Bulan">Cukup Bulan</option>
                                          <option value="Kurang Bulan">Kurang Bulan</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="p_anak_riwayat_lahir_bb">3. Berat Badan Lahir</label>
                                          <input type="text" name="p_anak_riwayat_lahir_bb" id="p_anak_riwayat_lahir_bb" class="form-control mt-2 mb-2 " placeholder="Berat Badan Lahir">
                                      </div>
                                      <div class="form-group">
                                          <label for="p_anak_riwayat_lahir_pb">4. Panjang Badan Lahir</label>
                                          <input type="text" name="p_anak_riwayat_lahir_pb" id="p_anak_riwayat_lahir_pb" class="form-control mt-2 mb-2 " placeholder="Panjang Badan Lahir">
                                      </div>
                                      <div class="form-group">
                                          <label for="p_anak_riwayat_lahir_vaksin">5. Riwayat Vaksin</label>
                                          <select name="p_anak_riwayat_lahir_vaksin" id="p_anak_riwayat_lahir_vaksin" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih Riwayat</option>
                                          <option value="BCG">BCG</option>
                                          <option value="Hepatitis">Hepatitis</option>
                                          <option value="DPT">DPT</option>
                                          <option value="Campak">Campak</option>
                                          <option value="Polio">Polio</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
  
                          <div class="step">
                              <div class="asesmen-keperawatan">
                                  <h5 class="step-title" style="section-title" onclick="toggleStep(this)">7. Asesmen Keperawatan</h5>
                                  <div class="step-content">
                                      <div class="form-group">
                                          <label for="nutrisi" onclick="toggleInput('nutrisi')">1. Nutrisi</label>
                                          <input type="text" name="nutrisi_bb" id="nutrisi_bb" class="form-control mt-2 mb-2 " placeholder="Berat Badan">
                                          <input type="text" name="nutrisi_tb" id="nutrisi_tb" class="form-control mt-2 mb-2 " placeholder="Tinggi Badan">
                                          <input type="text" name="imt" id="nutrisi" class="form-control mt-2 mb-2 " placeholder="IMT">
                                      </div>
                                      <div class="form-group">
                                          <label for="ak_jenisaktivitas_mobilisasi" onclick="toggleInput('ak_jenisaktivitas_mobilisasi')">2. Aktivitas Latihan</label>
                                          <select name="ak_jenisaktivitas_mobilisasi" id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Aktivitas Mobilisasi</option>
                                              <option value="0 Mandiri">0 Mandiri</option>
                                              <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                              <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang Lain</option>
                                              <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu bantuan Orang Lain dan Alat</option>
                                              <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau Tidak Mampu</option>
                                          </select>
                                          <select name="ak_jenisaktivitas_toileting" id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Aktivitas Toileting</option>
                                              <option value="0 Mandiri">0 Mandiri</option>
                                              <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                              <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang Lain</option>
                                              <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu bantuan Orang Lain dan Alat</option>
                                              <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau Tidak Mampu</option>
                                          </select>
                                          <select name="ak_jenisaktivitas_makan_minum" id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Aktivitas Makan Minum</option>
                                              <option value="0 Mandiri">0 Mandiri</option>
                                              <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                              <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang Lain</option>
                                              <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu bantuan Orang Lain dan Alat</option>
                                              <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau Tidak Mampu</option>
                                          </select>
                                          <select name="ak_jenisaktivitas_mandi" id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Aktivitas Mandi</option>
                                              <option value="0 Mandiri">0 Mandiri</option>
                                              <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                              <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang Lain</option>
                                              <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu bantuan Orang Lain dan Alat</option>
                                              <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau Tidak Mampu</option>
                                          </select>
                                          <select name="ak_jenisaktivitas_berpakaian" id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Aktivitas Berpakaian</option>
                                              <option value="0 Mandiri">0 Mandiri</option>
                                              <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                              <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang Lain</option>
                                              <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu bantuan Orang Lain dan Alat</option>
                                              <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau Tidak Mampu</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="resikojatuh" onclick="toggleInput('resikojatuh')">3. Resiko Jatuh</label>
                                          <select name="ak_resiko_jatuh" id="ak_resiko_jatuh" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Resiko</option>
                                              <option value="Rendah" selected>Rendah</option>
                                              <option value="Rendah">Rendah</option>
                                              <option value="Sedang">Sedang</option>
                                              <option value="Tinggi">Tinggi</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <p onclick="toggleInput('psikologis')" style="margin-bottom: 5px;">4. Psikologis</p>
                                          <div id="psikologis">
                                          <label for="psikologis-senang">
                                              <input type="radio" name="ak_psikologis" id="psikologis-senang" value="Senang" onclick="toggleChange('alasan-ak_psikologis', this)"> Senang
                                          </label>
                                          <label for="psikologis-tenang">
                                              <input type="radio" name="ak_psikologis" id="psikologis-tenang" value="Tenang" onclick="toggleChange('alasan-ak_psikologis', this)"> Tenang
                                          </label>
                                          <label for="psikologis-sedih">
                                              <input type="radio" name="ak_psikologis" id="psikologis-sedih" value="Sedih" onclick="toggleChange('alasan-ak_psikologis', this)"> Sedih
                                          </label>
                                          <label for="psikologis-tegang">
                                              <input type="radio" name="ak_psikologis" id="psikologis-tegang" value="Tegang" onclick="toggleChange('alasan-ak_psikologis', this)"> Tegang
                                          </label>
                                          <label for="psikologis-takut">
                                              <input type="radio" name="ak_psikologis" id="psikologis-takut" value="Takut" onclick="toggleChange('alasan-ak_psikologis', this)"> Takut
                                          </label>
                                          <label for="psikologis-depresi">
                                              <input type="radio" name="ak_psikologis" id="psikologis-depresi" value="Depresi" onclick="toggleChange('alasan-ak_psikologis', this)"> Depresi
                                          </label>
                                          <label for="psikologis-lainnya">
                                              <input type="radio" name="ak_psikologis" id="psikologis-lainnya" value="Lainnya" onclick="toggleChange('alasan-ak_psikologis', this)"> Lainnya
                                          </label>
                                          </div>
                                          <div id="alasan-ak_psikologis" style="display: none;">
                                          <input type="text" id="alasan-ak_psikologis" name="alasan_ak_psikologis_lain" class="form-control mt-2 mb-2">
                                          </div>
                                      </div>
                                      {{-- <div class="form-group">
                                          <label for="sosial_ekonomi" onclick="toggleInput('sosial_ekonomi')">5. Sosial Ekonomi</label>
                                          <select name="ak_sosial_ekonomi" id="ak_sosial_ekonomi" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih Sosial Ekonomi</option>
                                          <option value="baik">Baik</option>
                                          <option value="cukup">Cukup</option>
                                          <option value="kurang">Kurang</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="penjamin" onclick="toggleInput('penjamin')">6. Penjamin</label>
                                          <select name="ak_rencana_tindakan" id="ak_rencana_tindakan" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih Sosial Ekonomi</option>
                                          <option value="umum">Umum</option>
                                          <option value="asuransi">Asuransi</option>
                                          <option value="bpjs">BPJS</option>
                                          </select>
                                      </div> --}}
                                      <div class="form-group">
                                          <label for="ak_masalah" onclick="toggleInput('ak_masalah')">5. Masalah</label>
                                          <input type="text" name="ak_masalah" id="ak_masalah" class="form-control mt-2 mb-2 " placeholder="Masalah">
                                      </div>
                                      <div class="form-group">
                                          <label for="ak_rencana_tindakan" onclick="toggleInput('ak_rencana_tindakan')">6. Rencana Tindakan</label>
                                          <input type="text" name="ak_rencana_tindakan" id="ak_rencana_tindakan" class="form-control mt-2 mb-2 " placeholder="Rencana Tindakan">
                                      </div>
                                  </div>
                              </div>
                          </div>
  
                          <div class="step">
                              <div class="psicososial-pengetahuan">
                                  <h5 class="step-title" onclick="toggleStep(this)" style="section-title">8. Riwayat Psicososial dan Pengetahuan</h5>
                                  <div class="step-content">
                                      <div class="form-group">
                                          <label for="psico_pengetahuan_ttg_penyakit_ini" onclick="toggleInput('psico_pengetahuan_ttg_penyakit_ini')">1. Pengetahuan tentang Penyakit</label>
                                          <select name="psico_pengetahuan_ttg_penyakit_ini" id="psico_pengetahuan_ttg_penyakit_ini" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Pengetahuan Penyakit</option>
                                              <option value="Tidak Tahu" selected>Tidak Tahu</option>
                                              <option value="Tahu">Tahu</option>
                                              <option value="Tidak Tahu">Tidak Tahu</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="psico_perawatan_tindakan_yg_dlakukan" onclick="toggleInput('psico_perawatan_tindakan_yg_dlakukan')">2. Perawatan/Tindakan Yang Dilakukan</label>
                                          <select name="psico_perawatan_tindakan_yg_dlakukan" id="psico_perawatan_tindakan_yg_dlakukan" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Perawatan</option>
                                              <option value="Mengerti" selected>Mengerti</option>
                                              <option value="Tidak Mengerti">Tidak Mengerti</option>
                                              <option value="Mengerti">Mengerti</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="psico_adakah_keyakinan_pantangan" onclick="toggleInput('psico_adakah_keyakinan_pantangan')">3. Adakah Keyakinan atau Pantangan</label>
                                          <select name="psico_adakah_keyakinan_pantangan" id="psico_adakah_keyakinan_pantangan" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Keyakinan</option>
                                              <option value="Tidak" selected>Tidak</option>
                                              <option value="Ada">Ada</option>
                                              <option value="Tidak">Tidak</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="psico_kendala_kominukasi" onclick="toggleInput('psico_kendala_kominukasi')">4. Kendala Komunikasi</label>
                                          <select name="psico_kendala_kominukasi" id="psico_kendala_kominukasi" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Kendala</option>
                                              <option value="Tidak" selected>Tidak</option>
                                              <option value="Ada">Ada</option>
                                              <option value="Tidak">Tidak</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="psico_yang_merawat_dirumah" onclick="toggleInput('psico_yang_merawat_dirumah')">5. Yang Merawat Dirumah</label>
                                          <select name="psico_yang_merawat_dirumah" id="psico_yang_merawat_dirumah" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Merawat</option>
                                              <option value="Tidak" selected>Tidak</option>
                                              <option value="Ada">Ada</option>
                                              <option value="Tidak">Tidak</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
  
                          <div class="step">
                              <div class="asesmen-nyeri">
                                  <h5 style="section-title" class="step-title" onclick="toggleStep(this)">9. Asesmen nyeri</h5>
                                  <div class="step-content">
                                      <div class="form-group">
                                          <label for="nyeri_apakah_pasien_merasakan_nyeri" onclick="toggleInput('nyeri_apakah_pasien_merasakan_nyeri')">1. Apakah pasien merasakan nyeri</label>
                                          <select name="nyeri_apakah_pasien_merasakan_nyeri" id="nyeri_apakah_pasien_merasakan_nyeri" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih Merawat</option>
                                          <option value="Ya">Ya</option>
                                          <option value="Tidak">Tidak</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="nyeri_pencetus" onclick="toggleInput('nyeri_pencetus')">2. Pencetus</label>
                                          <input type="text" name="nyeri_pencetus" id="nyeri_pencetus" class="form-control mt-2 mb-2 ">
                                      </div>
                                      <div class="form-group">
                                          <label for="nyeri_kualitas" onclick="toggleInput('nyeri_kualitas')">3. Kualitas</label>
                                          <select name="nyeri_kualitas" id="nyeri_kualitas" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Kualitas</option>
                                              <option value="Tekanan">Tekanan</option>
                                              <option value="Terbakar">Terbakar</option>
                                              <option value="Melilit">Melilit</option>
                                              <option value="Tertusuk">Tertusuk</option>
                                              <option value="Diiris">Diiris</option>
                                              <option value="Mencengkram">Mencengkram</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="nyeri_lokasi" onclick="toggleInput('nyeri_lokasi')">4. Lokasi</label>
                                          <input type="text" name="nyeri_lokasi" id="nyeri_lokasi" class="form-control mt-2 mb-2 ">
                                      </div>
                                      <div class="form-group">
                                          <label for="nyeri_skala" onclick="toggleInput('nyeri_skala')">5. Skala</label>
                                          <input type="text" name="nyeri_skala" id="nyeri_skala" class="form-control mt-2 mb-2 ">
                                      </div>
                                      <div class="form-group">
                                          <label for="nyeri_waktu" onclick="toggleInput('nyeri_waktu')">6. Waktu</label>
                                          <select name="nyeri_waktu" id="nyeri_waktu" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Waktu</option>
                                              <option value="Intermiten">Intermiten</option>
                                              <option value="Hilang Timbul">Hilang Timbul</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
  
                          <div class="step">
                              <div class="asesmen-resiko-jatuh">
                                  <h5 style="section-title" class="step-title" onclick="toggleStep(this)">10. Asesmen Resiko Jatuh</h5>
                                  <div class="step-content">
                                      <div class="form-group">
                                          <label for="jatuh_sempoyong" onclick="toggleInput('jatuh_sempoyong')">1. Perhatikan cara berjalan pasien saat akan duduk dikursi apakah pasien tampak tidak seimbang / sempoyongan / libung </label>
                                          <select name="jatuh_sempoyong" id="jatuh_sempoyong" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih</option>
                                          <option value="Ya">Ya</option>
                                          <option value="Tidak">Tidak</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="jatuh_pegangan" onclick="toggleInput('jatuh_pegangan')">2. Apakah pasien memegang pinggiran kursi / meja / benda lain sebagai penopang saat akan duduk</label>
                                          <select name="jatuh_pegangan" id="jatuh_pegangan" class="form-control mt-2 mb-2 ">
                                          <option value="">Pilih</option>
                                          <option value="Ya">Ya</option>
                                          <option value="Tidak">Tidak</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="jatuh_hasil_kajian" onclick="toggleInput('jatuh_hasil_kajian')">3. Hasil Kajian</label>
                                          <select name="jatuh_hasil_kajian" id="jatuh_hasil_kajian" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Kajian</option>
                                              <option value="Tidak Beresiko">Tidak Beresiko</option>
                                              <option value="Resiko Rendah">Resiko Rendah</option>
                                              <option value="Resiko Tinggi">Resiko Tinggi</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
  
                          <div class="step">
                              <div class="masalah-keperawatan">
                                  <h5 style="section-title" class="step-title" onclick="toggleStep(this)">11. Analisa Masalah Keperawatan / Kebidanan</h5>
                                  <div class="step-content">
                                      <div class="form-group">
                                          <label for="ak_nama_perawat_bidan" onclick="toggleInput('ak_nama_perawat_bidan')">1. Analisa Masalah Keperawatan</label>
                                          <select name="ak_nama_perawat_bidan" id="ak_nama_perawat_bidan" class="form-control mt-2 mb-2 ">
                                              <option value="">Pilih Masalah</option>
                                              <option value="Bersihkan Jalan Nafas tidak Efektif">Bersihkan Jalan Nafas tidak Efektif</option>
                                              <option value="Perubahan Nutrisi Kurang / Lebih Cairan">Perubahan Nutrisi Kurang / Lebih Cairan</option>
                                              <option value="Keseimbangan Cairan dan Elektrolit">Keseimbangan Cairan dan Elektrolit</option>
                                              <option value="Gangguan Komunikasi Verbal">Gangguan Komunikasi Verbal</option>
                                              <option value="Pola Nafas tidak Efektif">Pola Nafas tidak Efektif</option>
                                              <option value="Resiko Infeksi / Sepsis">Resiko Infeksi / Sepsis</option>
                                              <option value="Gangguan Integritas Kulit / Jaringan">Gangguan Integritas Kulit / Jaringan</option>
                                              <option value="Gangguan Pola Tidur">Gangguan Pola Tidur</option>
                                              <option value="Nyeri">Nyeri</option>
                                              <option value="Intoleransi Aktivitas">Intoleransi Aktivitas</option>
                                              <option value="Konstipasi / Diare">Konstipasi / Diare</option>
                                              <option value="Cemas">Cemas</option>
                                              <option value="Hypertermi / Hipotermi">Hypertermi / Hipotermi</option>
                                              <option value="Lain - Lain">Lain - Lain</option>
                                          {{-- <option value="Menganjurkan Pasien untuk Minum Obat Teratur">Menganjurkan Pasien untuk Minum Obat Teratur</option>
                                          <option value="Menganjurkan Pasien untuk Makan Teratur">Menganjurkan Pasien untuk Makan Teratur</option>
                                          <option value="Menganjurkan Pasien untuk Minum Hangat">Menganjurkan Pasien untuk Minum Hangat</option>
                                          <option value="Menganjurkan Pasien untuk Minum Lebih Kurang 8 Gelas">Menganjurkan Pasien untuk Minum Lebih Kurang 8 Gelas</option>
                                          <option value="Menganjurkan Pasien untuk Tidak Minum Dingin">Menganjurkan Pasien untuk Tidak Minum Dingin</option>
                                          <option value="Menganjurkan Pasien untuk Membatasi Minum">Menganjurkan Pasien untuk Membatasi Minum</option>
                                          <option value="Menganjurkan Pasien untuk Cukup Istirahat">Menganjurkan Pasien untuk Cukup Istirahat</option>
                                          <option value=">Menganjurkan Pasien untuk Kontrol Teratur Setelah Obat Habis">Menganjurkan Pasien untuk Kontrol Teratur Setelah Obat Habis</option>
                                          <option value="Menganjurkan Pasien untuk Membatasi Aktivitas">Menganjurkan Pasien untuk Membatasi Aktivitas</option> --}}
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              @endif
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>