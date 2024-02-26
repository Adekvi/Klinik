@extends('layout.home')

@section('content')
    <div class="pendaftaran">
      <div class="container">
        <div class="judul">
          <h2>Daftar Pasien</h2>
        </div>
        <div class="isian">
          <table class="table">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>No. Antrian</th>
                      <th>Status</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>1</td>
                      <td>2638582</td>
                      <td>Mr. A</td>
                      <td>B011</td>
                      <td>Belum Periksa</td>
                      <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periksa">
                          Periksa
                        </button>
                          <button id="hapus" class="btn btn-danger">
                              Hapus
                          </button>
                      </td>
                  </tr>
                  <tr>
                      <td>1</td>
                      <td>2638582</td>
                      <td>Mr. A</td>
                      <td>B011</td>
                      <td>Belum Periksa</td>
                      <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periksa">
                          Periksa
                        </button>
                          <button id="hapus" class="btn btn-danger">
                              Hapus
                          </button>
                      </td>
                  </tr>
                  <tr>
                      <td>1</td>
                      <td>2638582</td>
                      <td>Mr. A</td>
                      <td>B011</td>
                      <td>Belum Periksa</td>
                      <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periksa">
                          Periksa
                        </button>
                          <button id="hapus" class="btn btn-danger">
                              Hapus
                          </button>
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>

  <!-- Modal PERIKSA -->
<div class="modal fade" id="periksa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="periksa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Anamnesis</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="anamnesis-s">
            <h3 onclick="anamnesisS()">(S)</h3>
            <div class="form-group">
              <label for="keluhan" onclick="toggleInput('a_keluhan_utama')">Keluhan Utama</label>
              <input type="text" name="a_keluhan_utama" id="a_keluhan_utama" class="form-control mt-2 mb-2 ">
            </div>
            <div class="form-group">
              <label for="riwayat-penyakit-skrg" onclick="toggleInput('a_riwayat_penyakit_skrg')">Riwayat Penyakit Sekarang</label>
              <input type="text" name="a_riwayat_penyakit_skrg" id="a_riwayat_penyakit_skrg" class="form-control mt-2 mb-2 ">
            </div>
            <div class="form-group">
              <label for="riwayat-penyakit-terdahulu" onclick="toggleInput('a_riwayat_penyakit_terdahulu')">Riwayat Penyakit Terdahulu</label>
              <input type="text" name="a_riwayat_penyakit_terdahulu" id="a_riwayat_penyakit_terdahulu" class="form-control mt-2 mb-2 ">
            </div>
            <div class="form-group">
              <label for="riwayat-penyakit-keluarga" onclick="toggleInput('a_riwayat_penyakit_keluarga')">Riwayat Penyakit Keluarga</label>
              <input type="text" name="a_riwayat_penyakit_keluarga" id="a_riwayat_penyakit_keluarga" class="form-control mt-2 mb-2 ">
            </div>
            <div class="form-group">
              <label for="riwayat-alergi" onclick="toggleInput('a_riwayat_alergi')">Riwayat Alergi</label>
              <select name="a_riwayat_alergi" id="a_riwayat_alergi" class="form-control mt-2 mb-2 ">
                <option value="">Pilih Riwayat</option>
                <option value="">Ada</option>
                <option value="">Tidak</option>
              </select>
            </div>
          </div>
          <div class="anamnesis-o">
            <h3 onclick="anamnesisO()">(0)</h3>
            <div class="form-group">
              <label for="keadaan_umum" onclick="toggleInput('keadaan_umum')">Keadaan Umum</label>
              <input type="text" name="keadaan_umum" id="keadaan_umum" class="form-control mt-2 mb-2 ">
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('kesadaran')" style="margin-bottom: 5px;">Kesadaran</p>
              <div id="kesadaran">
                <label for="jawaban-ya">
                  <input type="radio" name="kesadaran" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-kesadaran', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="kesadaran" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-kesadaran', this)"> Tidak
                </label>
              </div>
              <div id="alasan-kesadaran" style="display: none;">
                <input type="text" id="alasan-kesadaran" name="alasan-kesadaran" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('kepala')" style="margin-bottom: 5px;">Kepala</p>
              <div id="kepala">
                <label for="jawaban-ya">
                  <input type="radio" name="kepala" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-kepala', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="kepala" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-kepala', this)"> Tidak
                </label>
              </div>
              <div id="alasan-kepala" style="display: none;">
                <input type="text" id="alasan-kepala" name="alasan-kepala" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('mata')" style="margin-bottom: 5px;">Mata</p>
              <div id="mata">
                <label for="jawaban-ya">
                  <input type="radio" name="mata" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-mata', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="mata" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-mata', this)"> Tidak
                </label>
              </div>
              <div id="alasan-mata" style="display: none;">
                <input type="text" id="alasan-mata" name="alasan-mata" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('leher')" style="margin-bottom: 5px;">Leher</p>
              <div id="leher">
                <label for="jawaban-ya">
                  <input type="radio" name="leher" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-leher', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="leher" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-leher', this)"> Tidak
                </label>
              </div>
              <div id="alasan-leher" style="display: none;">
                <input type="text" id="alasan-leher" name="alasan-leher" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('tht')" style="margin-bottom: 5px;">THT</p>
              <div id="tht">
                <label for="jawaban-ya">
                  <input type="radio" name="tht" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-tht', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="tht" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-tht', this)"> Tidak
                </label>
              </div>
              <div id="alasan-tht" style="display: none;">
                <input type="text" id="alasan-tht" name="alasan-tht" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('paru')" style="margin-bottom: 5px;">Paru</p>
              <div id="paru">
                <label for="jawaban-ya">
                  <input type="radio" name="paru" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-paru', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="paru" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-paru', this)"> Tidak
                </label>
              </div>
              <div id="alasan-paru" style="display: none;">
                <input type="text" id="alasan-paru" name="alasan-paru" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('jantung')" style="margin-bottom: 5px;">Jantung</p>
              <div id="jantung">
                <label for="jawaban-ya">
                  <input type="radio" name="jantung" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-jantung', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="jantung" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-jantung', this)"> Tidak
                </label>
              </div>
              <div id="alasan-jantung" style="display: none;">
                <input type="text" id="alasan-jantung" name="alasan-jantung" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('abdomen')" style="margin-bottom: 5px;">Abdomen / Otot Perut</p>
              <div id="abdomen">
                <label for="jawaban-ya">
                  <input type="radio" name="abdomen" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-abdomen', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="abdomen" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-abdomen', this)"> Tidak
                </label>
              </div>
              <div id="alasan-abdomen" style="display: none;">
                <input type="text" id="alasan-abdomen" name="alasan-abdomen" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('ekstremitas')" style="margin-bottom: 5px;">Ekstremitas / Anggota Gerak</p>
              <div id="ekstremitas">
                <label for="jawaban-ya">
                  <input type="radio" name="ekstremitas" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-ekstremitas', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="ekstremitas" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-ekstremitas', this)"> Tidak
                </label>
              </div>
              <div id="alasan-ekstremitas" style="display: none;">
                <input type="text" id="alasan-ekstremitas" name="alasan-ekstremitas" class="form-control mt-2 mb-2">
              </div>
            </div>
            <div class="form-group mt-2 mb-2">
              <p onclick="toggleInput('kulit')" style="margin-bottom: 5px;">Kulit</p>
              <div id="kulit">
                <label for="jawaban-ya">
                  <input type="radio" name="kulit" id="jawaban-ya" value="ya" onclick="toggleChange('alasan-kulit', this)"> Ya
                </label>
                <label for="jawaban-tidak">
                  <input type="radio" name="kulit" id="jawaban-tidak" value="tidak" onclick="toggleChange('alasan-kulit', this)"> Tidak
                </label>
              </div>
              <div id="alasan-kulit" style="display: none;">
                <input type="text" id="alasan-kulit" name="alasan-kulit" class="form-control mt-2 mb-2">
              </div>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Daftar</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function anamnesisS() {
      var inputs = document.querySelectorAll('.anamnesis-s .form-group');
      inputs.forEach(function(input) {
        input.classList.toggle('hidden-input');
      });
    }
    function anamnesisO() {
      var inputs = document.querySelectorAll('.anamnesis-o .form-group');
      inputs.forEach(function(input) {
        input.classList.toggle('hidden-input');
      });
    }
    function toggleInput(inputId) {
      var inputElement = document.getElementById(inputId);
      inputElement.classList.toggle('hidden-input');
    }

    hideInputs();

    function toggleChange(elementId, radio) {
      var element = document.getElementById(elementId);

      if (radio.value === 'tidak') {
        element.style.display = (element.style.display === 'none' || element.style.display === '') ? 'block' : 'none';
      } else {
        element.style.display = 'none';
      }
    }
  </script>
@endpush
