{{-- MODAL ISIAN PERAWAT --}}
    <div class="modal fade" id="periksa2{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="periksa" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
          <form id="myForm2">
              @csrf
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Isian Perawat</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="pasien" value="{{ $item->id }}">
                <div class="form-isian">
                    <h5 style="text-decoration: underline" onclick="formIsian()">Form Isian</h5>
                        <div class="form-group mt-2 mb-2">
                            <p onclick="toggleInput('isian')" style="margin-bottom: 5px;">1. Isian Pilihan</p>
                            <div id="isian">
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
                <div class="kebiasaan">
                    <h5 style="text-decoration: underline" onclick="kebiasaan()">Kebiasaan</h5>
                        <div class="form-group mt-2 mb-2">
                            <p onclick="toggleInput('rokok')" style="margin-bottom: 5px;">1. Rokok</p>
                            <div id="rokok">
                                <label for="rokok-ya">
                                    <input type="radio" name="rokok" id="rokok-ya" value="Ya"> Ya
                                </label>
                                <label for="rokok-tidak">
                                    <input type="radio" name="rokok" id="rokok-tidak" value="Tidak" checked > Tidak
                                </label>
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <p onclick="toggleInput('alkohol')" style="margin-bottom: 5px;">2. Alkohol</p>
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
                            <p onclick="toggleInput('obat_tidur')" style="margin-bottom: 5px;">3. Obat Tidur</p>
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
                            <p onclick="toggleInput('olahraga')" style="margin-bottom: 5px;">4. Olahraga</p>
                            <div id="olahraga">
                            <label for="olahraga-ya">
                                <input type="radio" name="olahraga" id="olahraga-ya" value="Ya" checked> Ya
                            </label>
                            <label for="olahraga-tidak">
                                <input type="radio" name="olahraga" id="olahraga-tidak" value="Tidak"> Tidak
                            </label>
                            </div>
                        </div>
                </div>
                <div class="riwayat-lahir">
                    <h5 style="text-decoration: underline" onclick="riwayatLahir()">Riwayat Lahir</h5>
                        <div class="form-group">
                            <label for="p_anak_riwayat_lahir" onclick="toggleInput('p_anak_riwayat_lahir')">1. Riwayat Lahir</label>
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
                            <label for="p_anak_riwayat_lahir_bb" onclick="toggleInput('p_anak_riwayat_lahir_bb')">3. Berat Badan Lahir</label>
                            <input type="text" name="p_anak_riwayat_lahir_bb" id="p_anak_riwayat_lahir_bb" class="form-control mt-2 mb-2 " placeholder="Berat Badan Lahir">
                        </div>
                        <div class="form-group">
                            <label for="p_anak_riwayat_lahir_pb" onclick="toggleInput('p_anak_riwayat_lahir_pb')">4. Panjang Badan Lahir</label>
                            <input type="text" name="p_anak_riwayat_lahir_pb" id="p_anak_riwayat_lahir_pb" class="form-control mt-2 mb-2 " placeholder="Panjang Badan Lahir">
                        </div>
                        <div class="form-group">
                            <label for="p_anak_riwayat_lahir_vaksin" onclick="toggleInput('p_anak_riwayat_lahir_vaksin')">5. Riwayat Vaksin</label>
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
                <div class="tanda-vital">
                  <h5 style="text-decoration: underline" onclick="tandaVital()">Tanda Vital</h5>
                      <div class="form-group">
                          <label for="tensi" onclick="toggleInput('tensi')">1. Tensi</label>
                          <input type="text" name="tensi" id="tensi" class="form-control mt-2 mb-2 " placeholder="Tensi">
                      </div>
                      <div class="form-group">
                          <label for="rr" onclick="toggleInput('rr')">2. RR</label>
                          <input type="text" name="rr" id="rr" class="form-control mt-2 mb-2 " placeholder="RR">
                      </div>
                      <div class="form-group">
                          <label for="suhu" onclick="toggleInput('suhu')">3. Suhu</label>
                          <input type="text" name="suhu" id="suhu" class="form-control mt-2 mb-2 " placeholder="Suhu">
                      </div>
                      <div class="form-group">
                          <label for="nadi" onclick="toggleInput('nadi')">4. Nadi</label>
                          <input type="text" name="nadi" id="nadi" class="form-control mt-2 mb-2 " placeholder="Nadi">
                      </div>
                      <div class="form-group">
                          <label for="tb" onclick="toggleInput('tb')">5. TB</label>
                          <input type="text" name="tb" id="tb" class="form-control mt-2 mb-2 " placeholder="Tinggi Badan">
                      </div>
                      <div class="form-group">
                          <label for="bb" onclick="toggleInput('bb')">6. BB</label>
                          <input type="text" name="bb" id="bb" class="form-control mt-2 mb-2 " placeholder="Berat Badan">
                      </div>
                </div>
                <div class="asesmen-keperawatan">
                  <h5 style="text-decoration: underline" onclick="asesmenKeperawatan()">Asesmen Keperawatan</h5>
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
                        <label for="ak_masalah" onclick="toggleInput('ak_masalah')">7. Masalah</label>
                        <input type="text" name="ak_masalah" id="ak_masalah" class="form-control mt-2 mb-2 " placeholder="Masalah">
                      </div>
                      <div class="form-group">
                        <label for="ak_rencana_tindakan" onclick="toggleInput('ak_rencana_tindakan')">8. Rencana Tindakan</label>
                        <input type="text" name="ak_rencana_tindakan" id="ak_rencana_tindakan" class="form-control mt-2 mb-2 " placeholder="Rencana Tindakan">
                      </div>
                </div>
                <div class="psicososial-pengetahuan">
                  <h5 style="text-decoration: underline" onclick="psicoPengetahuan()">Riwayat Psicososial dan Pengetahuan</h5>
                      <div class="form-group">
                          <label for="psico_pengetahuan_ttg_penyakit_ini" onclick="toggleInput('psico_pengetahuan_ttg_penyakit_ini')">1. Pengetahuan tentang Penyakit</label>
                          <select name="psico_pengetahuan_ttg_penyakit_ini" id="psico_pengetahuan_ttg_penyakit_ini" class="form-control mt-2 mb-2 ">
                            <option value="">Pilih Pengetahuan Penyakit</option>
                            <option value="Tahu">Tahu</option>
                            <option value="Tidak Tahu">Tidak Tahu</option>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="psico_perawatan_tindakan_yg_dlakukan" onclick="toggleInput('psico_perawatan_tindakan_yg_dlakukan')">2. Perawatan/Tindakan Yang Dilakukan</label>
                        <select name="psico_perawatan_tindakan_yg_dlakukan" id="psico_perawatan_tindakan_yg_dlakukan" class="form-control mt-2 mb-2 ">
                          <option value="">Pilih Perawatan</option>
                          <option value="Mengerti">Mengerti</option>
                          <option value="Tidak Mengerti">Tidak Mengerti</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="psico_adakah_keyakinan_pantangan" onclick="toggleInput('psico_adakah_keyakinan_pantangan')">3. Adakah Keyakinan atau Pantangan</label>
                        <select name="psico_adakah_keyakinan_pantangan" id="psico_adakah_keyakinan_pantangan" class="form-control mt-2 mb-2 ">
                          <option value="">Pilih Keyakinan</option>
                          <option value="Tidak">Tidak</option>
                          <option value="Ada">Ada</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="psico_kendala_kominukasi" onclick="toggleInput('psico_kendala_kominukasi')">4. Kendala Komunikasi</label>
                        <select name="psico_kendala_kominukasi" id="psico_kendala_kominukasi" class="form-control mt-2 mb-2 ">
                          <option value="">Pilih Kendala</option>
                          <option value="Ada">Ada</option>
                          <option value="Tidak">Tidak</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="psico_yang_merawat_dirumah" onclick="toggleInput('psico_yang_merawat_dirumah')">5. Yang Merawat Dirumah</label>
                        <select name="psico_yang_merawat_dirumah" id="psico_yang_merawat_dirumah" class="form-control mt-2 mb-2 ">
                          <option value="">Pilih Merawat</option>
                          <option value="Ada">Ada</option>
                          <option value="Tidak">Tidak</option>
                        </select>
                      </div>
                </div>
                <div class="asesmen-nyeri">
                  <h5 style="text-decoration: underline" onclick="asesmenNyeri()">Asesmen nyeri</h5>
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
                <div class="asesmen-resiko-jatuh">
                  <h5 style="text-decoration: underline" onclick="asesmenResikoJatuh()">Asesmen Resiko Jatuh</h5>
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
                <div class="masalah-keperawatan">
                  <h5 style="text-decoration: underline" onclick="masalahKeperawatan()">Analisa Masalah Keperawatan / Kebidanan</h5>
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
                          <option value="Menganjurkan Pasien untuk Minum Obat Teratur">Menganjurkan Pasien untuk Minum Obat Teratur</option>
                          <option value="Menganjurkan Pasien untuk Makan Teratur">Menganjurkan Pasien untuk Makan Teratur</option>
                          <option value="Menganjurkan Pasien untuk Minum Hangat">Menganjurkan Pasien untuk Minum Hangat</option>
                          <option value="Menganjurkan Pasien untuk Minum Lebih Kurang 8 Gelas">Menganjurkan Pasien untuk Minum Lebih Kurang 8 Gelas</option>
                          <option value="Menganjurkan Pasien untuk Tidak Minum Dingin">Menganjurkan Pasien untuk Tidak Minum Dingin</option>
                          <option value="Menganjurkan Pasien untuk Membatasi Minum">Menganjurkan Pasien untuk Membatasi Minum</option>
                          <option value="Menganjurkan Pasien untuk Cukup Istirahat">Menganjurkan Pasien untuk Cukup Istirahat</option>
                          <option value=">Menganjurkan Pasien untuk Kontrol Teratur Setelah Obat Habis">Menganjurkan Pasien untuk Kontrol Teratur Setelah Obat Habis</option>
                          <option value="Menganjurkan Pasien untuk Membatasi Aktivitas">Menganjurkan Pasien untuk Membatasi Aktivitas</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="ak_ttdperawat_bidan" onclick="toggleInput('ak_ttdperawat_bidan')">Tanda Tangan Perawat</label>
                        <input type="text" name="ak_ttdperawat_bidan" id="ak_ttdperawat_bidan" class="form-control mt-2 mb-2 ">
                      </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
              <button type="button" onclick="saveData()">Simpan</button>
            </div>
          </form>
          </div>
        </div>
    </div>