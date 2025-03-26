<!-- modal pemeriksaan -->
<div class="modal fade" id="modalFisik" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFisik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Tambah Rekam Medis Tubuh/Gigi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('dokter/tambah/' . $antrianDokter->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="dokter_id" value="{{ $antrianDokter->dokter_id }}">
                <input type="hidden" name="pasien_id" value="{{ $antrianDokter->booking->pasien_id }}">
                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                    <div class="row" style="width: 100%">
                        <div class="card-body">
                            <table class="table" style="width: 50%; margin-top: -30px; border-collapse: separate">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left">
                                            Tanggal Periksa
                                        </th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="font-weight: bold; padding: 4px;">
                                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">No RM</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Nama Pasien</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->nama_pasien }}</td>
                                    </tr>                                
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Jenis Pasien</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->jenis_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Umur</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">
                                            <?php 
                                                $tgllahir = \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir);
                                                $umur = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                            
                                                if ($umur < 12) {
                                                    echo $tgllahir->diff(\Carbon\Carbon::now())->format('%m&nbsp;bulan&nbsp;%d&nbsp;hari');
                                                } else {
                                                    echo $tgllahir->age . '&nbsp;Tahun';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Jenis Kelamin</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->jekel == 'L'  ? 'Laki-laki' : ($antrianDokter->booking->pasien->jekel == 'P' ? 'Perempuan' : '') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="padding: 4px; text-align: left;">Alamat Domisili</th>
                                        <td style="padding: 4px; width: 10px;">:</td>
                                        <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->domisili }}</td>
                                    </tr>
                                </tbody>
                            </table>                         
                        </div>
                        <!-- Kolom Kiri: Gambar -->
                        @if($antrianDokter->poli->namapoli === 'Umum')
                            <div class="col-md-6" style="margin-top: -20px;">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="showImage('depan')">Depan</button>
                                    <input name="depan" class="form-control mt-2 mb-2" id="depan" rows="2" placeholder="Belum Ada Catatan">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="showImage('samping')">Samping</button>
                                    <input name="samping" class="form-control mt-2 mb-2" id="samping" rows="2" placeholder="Belum Ada Catatan">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="showImage('belakang')">Belakang</button>
                                    <input name="belakang" class="form-control mt-2 mb-2" id="belakang" rows="2" placeholder="Belum Ada Catatan">
                                </div>
                                <div class="tutup" style="margin-top: 10px; margin-left: 150px">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                                </div>
                            </div>
                            <div class="col-md-6 text-center" style="padding: 20px; margin-top: -250px">
                                <img id="displayedImage" src="{{ asset('assets/images/depan.png') }}" style="max-width: 70%; height: auto; border-radius: 10px;" alt="Kerangka">
                            </div>
                        {{-- @elseif($antrianDokter->poli->namapoli === 'Gigi')
                            <div style="max-height: 400px; overflow-y: auto;">
                                <div class="d-flex justify-content-center mb-4">
                                    <img id="displayedImage" src="{{ asset('assets/images/gigi.jpeg') }}" style="max-width: 100%; height: auto; border-radius: 10px" alt="Kerangka">
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Keadaan">Keadaan Gigi</label>
                                            <select class="form-control mt-2 mb-2" name="keadaan_gigi" id="keadaan_gigi">
                                                <option value="">--Pilih Keadaan--</option>
                                                <option value="SOU">SOU</option>
                                                <option value="NVT">NVT</option>
                                                <option value="NON">NON</option>
                                                <option value="UNE">UNE</option>
                                                <option value="PRE">PRE</option>
                                                <option value="ANO">ANO</option>
                                                <option value="CFR">CFR</option>
                                                <option value="RRX">RRX</option>
                                                <option value="MIS">MIS</option>
                                                <option value="IMV">IMV</option>
                                                <option value="DIA">DIA</option>
                                                <option value="ATT">ATT</option>
                                                <option value="ABR">ABR</option>
                                                <option value="CAR">CAR</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <p style="margin-bottom: 5px;">Occlusi</p>
                                            <div id="occlusi_gigi" class="d-flex flex-wrap; margin-top: 20px">
                                                <label for="jawaban-normal" class="mr-3">
                                                    <input type="radio" name="occlusi_gigi" id="jawaban-normal" value="Normal-bite" checked style="transform: scale(1.5); margin-right: 10px;"> Normal Bite
                                                </label>
                                                <label for="jawaban-crossbite" class="mx-3">
                                                    <input type="radio" name="occlusi_gigi" id="jawaban-crossbite" value="Cross-bite" style="transform: scale(1.5); margin-right: 10px;"> Cross Bite
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="occlusi_gigi" id="jawaban-steepbite" value="Steep-bite" style="transform: scale(1.5); margin-right: 10px;"> Steep Bite
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p style="margin-bottom: 5px; margin-top: 15px">Torus Palatinus</p>
                                            <div id="torus_palatinus" class="d-flex flex-wrap; margin-top: 10px">
                                                <label for="jawaban-normal" class="mr-3">
                                                    <input type="radio" name="torus_palatinus" id="jawaban-tidak-ada" value="Tidak-ada" checked style="transform: scale(1.5); margin-right: 10px;"> Tidak Ada
                                                </label>
                                                <label for="jawaban-crossbite" class="mx-3">
                                                    <input type="radio" name="torus_palatinus" id="jawaban-kecil" value="Kecil" style="transform: scale(1.5); margin-right: 10px;"> Kecil
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="torus_palatinus" id="jawaban-sedang" value="Sedang" style="transform: scale(1.5); margin-right: 10px;"> Sedang
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="torus_palatinus" id="jawaban-besar" value="Besar" style="transform: scale(1.5); margin-right: 10px; margin-left: 20px"> Besar
                                                </label>
                                                <label for="jawaban-steepbite" style="margin-left: 12px">
                                                    <input type="radio" name="torus_palatinus" id="jawaban-multiple" value="Multiple" style="transform: scale(1.5); margin-right: 10px;"> Multiple
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p style="margin-bottom: 5px; margin-top: 15px">Torus Mandibularis</p>
                                            <div id="torus_mandibularis" class="d-flex flex-wrap; margin-top: 10px">
                                                <label for="jawaban-normal" class="mr-3">
                                                    <input type="radio" name="torus_mandibularis" id="jawaban-tidak-ada" value="Tidak-ada" checked style="transform: scale(1.5); margin-right: 10px;"> Tidak Ada
                                                </label>
                                                <label for="jawaban-crossbite" class="mx-3">
                                                    <input type="radio" name="torus_mandibularis" id="jawaban-sisi_kiri" value="Sisi_kiri" style="transform: scale(1.5); margin-right: 10px;"> Sisi Kiri
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="torus_mandibularis" id="jawaban-sisi_kanan" value="Sisi_kanan" style="transform: scale(1.5); margin-right: 10px;"> Sisi Kanan
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="torus_mandibularis" id="jawaban-kedua_sisi" value="Kedua_sisi" style="transform: scale(1.5); margin-right: 10px; margin-left: 20px"> Kedua Sisi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p style="margin-bottom: 5px; margin-top: 15px">Palatum</p>
                                            <div id="palatum" class="d-flex flex-wrap; margin-top: 10px">
                                                <label for="jawaban-normal" class="mr-3">
                                                    <input type="radio" name="palatum" id="jawaban-dalam" value="dalam" checked style="transform: scale(1.5); margin-right: 10px;"> Dalam
                                                </label>
                                                <label for="jawaban-crossbite" class="mx-3">
                                                    <input type="radio" name="palatum" id="jawaban-sedang" value="sedang" style="transform: scale(1.5); margin-right: 10px;"> Sedang
                                                </label>
                                                <label for="jawaban-steepbite" class="ml-3">
                                                    <input type="radio" name="palatum" id="jawaban-rendah" value="rendah" style="transform: scale(1.5); margin-right: 10px;"> Rendah
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p style="margin-bottom: 5px; margin-top: 15px">Diastema</p>
                                            <div id="diastema" class="d-flex flex-wrap; margin-top: 10px">
                                                <label for="jawaban-tidak_ada" class="mr-3">
                                                    <input type="radio" name="diastema" id="jawaban-tidak_ada" value="tidak-ada" checked style="transform: scale(1.5); margin-right: 10px;"> Tidak Ada
                                                </label>
                                                <label for="jawaban-ada" class="mx-3">
                                                    <input type="radio" name="diastema" id="jawaban-ada" value="ada" style="transform: scale(1.5); margin-right: 10px;"> Ada
                                                </label>
                                            </div>
                                            <div id="alasan-diastema" style="display: none;">
                                                <input type="text" id="diastema_alasan" name="diastema_alasan" class="form-control mt-2 mb-2" placeholder="Penjelasan">
                                                <p style="font-size: 14px; margin-top: -7px">(dijelaskan dimana dan berapa lebarnya)</p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <p style="margin-bottom: 5px; margin-top: 15px">Gigi Anomali</p>
                                            <div id="gigi_anomali" class="d-flex flex-wrap; margin-top: 10px">
                                                <label for="anomali-tidak_ada" class="mr-3">
                                                    <input type="radio" name="gigi_anomali" id="anomali-tidak_ada" value="tidak-ada" checked style="transform: scale(1.5); margin-right: 10px;"> Tidak Ada
                                                </label>
                                                <label for="anomali-ada" class="mx-3">
                                                    <input type="radio" name="gigi_anomali" id="anomali-ada" value="ada" style="transform: scale(1.5); margin-right: 10px;"> Ada
                                                </label>
                                            </div>
                                            <div id="alasan-gigi_anomali" style="display: none;">
                                                <input type="text" id="gigi_anomali_alasan" name="gigi_anomali_alasan" class="form-control mt-2 mb-2" placeholder="Penjelasan">
                                                <p style="font-size: 14px; margin-top: -7px">(dijelaskan gigi yang mana dan, dan bentuknya)</p>
                                            </div>
                                        </div>

                                        <div class="fomr-group">
                                            <label for="lain-lain" style="margin-bottom: 5px; margin-top: 15px">Lain-lain</label>
                                            <input type="text" class="form-control" name="gigi_lain-lain" id="gigi_lain-lain" placeholder="Lain-lain">
                                            <p style="font-size: 14px">(hal-hal yang tidak tercakup diatas)</p>
                                        </div>

                                        <div class="form-group">
                                            <p style="margin-bottom: 5px; margin-top: 15px">Jumlah Foto yang diambil</p>
                                            <div id="foto_ambil" class="d-flex flex-wrap; margin-top: 10px">
                                                <label for="digital" class="mr-3">
                                                    <input type="radio" name="foto_yg_diambil" id="digital" value="Digital" checked style="transform: scale(1.5); margin-right: 10px;"> Digital
                                                </label>
                                                <label for="intraoral" class="mx-3">
                                                    <input type="radio" name="foto_yg_diambil" id="Intraoral" value="Intraoral" style="transform: scale(1.5); margin-right: 10px;"> Intraoral
                                                </label>
                                            </div>
                                            <div id="foto_jumlah">
                                                <input type="text" id="jumlah" name="foto_jumlah" class="form-control mt-2 mb-2" placeholder="Jumlah">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <p style="margin-bottom: 5px; margin-top: 15px">Jumlah rontgen photo yang diambil</p>
                                            <div id="foto_ambil" class="d-flex flex-wrap; margin-top: 10px">
                                                <label for="Dental" class="mr-3">
                                                    <input type="radio" name="foto_rontgen_ambil" id="Dental" value="Dental" checked style="transform: scale(1.5); margin-right: 10px;"> Dental
                                                </label>
                                                <label for="PA" class="mx-3">
                                                    <input type="radio" name="foto_rontgen_ambil" id="PA" value="PA" style="transform: scale(1.5); margin-right: 10px;"> PA
                                                </label>
                                                <label for="OPG" class="mx-3">
                                                    <input type="radio" name="foto_rontgen_ambil" id="OPG" value="OPG" style="transform: scale(1.5); margin-right: 10px;"> OPG
                                                </label>
                                                <label for="Ceph" class="mx-3">
                                                    <input type="radio" name="foto_rontgen_ambil" id="Ceph" value="Ceph" style="transform: scale(1.5); margin-right: 10px;"> Ceph
                                                </label>
                                            </div>
                                            <div id="foto_rontgen_jumlah">
                                                <input type="text" id="rontgen_jumlah" name="foto_rontgen_jumlah" class="form-control mt-2 mb-2" placeholder="Jumlah">
                                            </div>

                                            <div class="form-group">
                                                <p style="margin-bottom: 5px; margin-top: 15px">Keterangan</p>
                                                <textarea name="gigi_keterangan" id="gigi_keterangan" cols="57" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                
                                    <div class="col-lg-6">
                                        <div id="keterangan-container">
                                            <div class="form-group keterangan-item">
                                                <label for="no_gigi">Nomor Gigi</label>
                                                <input type="number" class="form-control mt-2 mb-2" name="no_gigi[]" placeholder="Masukkan Nomor Gigi">
                                                <label for="keterangan">Keterangan</label>
                                                <input type="text" class="form-control mt-2 mb-2" name="keterangan[]" placeholder="Keterangan">
                                            </div>
                                        </div>
                                        <div class="button-group mt-2">
                                            <button type="button" class="btn btn-primary tambah-keterangan">Tambah Keterangan</button>
                                            <button type="button" class="btn btn-danger hapus-keterangan">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tutup" style="margin-top: 20px; margin-bottom: 30px;">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                                </div>
                            
                            </div> --}}
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>