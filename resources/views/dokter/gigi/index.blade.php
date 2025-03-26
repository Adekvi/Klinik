@extends('layout.ngarep')
@section('title', 'Dokter Gigi | Periksa Odontogram')
@section('kontent')

<div class="breadcrumbs d-flex align-items-center" style="background-image: url('{{ asset('assetss/img/profil.jpg') }}');">
</div>

<section>
    <div class="container">

        <div class="judul">
            <h4><strong>@yield('title')</strong></h4>
        </div>

        @foreach ($antrianDokter as $item)
            <div class="kembali">
                <a href="{{ url('dokter/soap/' . $item->id ) }}" class="btn btn-primary" data-toggle="tooltip" data-bs-placement="top" title="Kembali">
                    <i class="fa-solid fa-backward"></i> Kembali
                </a>
            </div>
        @endforeach

        @foreach ($antrianDokter as $item)
            <form action="{{ url('dokter/tambah/' . $item->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="dokter_id" value="{{ $item->dokter_id }}">
                <input type="hidden" name="pasien_id" value="{{ $item->booking->pasien_id }}">
                
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="padding: 4px; text-align: left">
                                    Tanggal Periksa
                                </th>
                                <td style="padding: 4px; width: 20px;">:</td>
                                <td style="font-weight: bold; padding: 4px;">
                                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding: 4px; text-align: left;">No RM</th>
                                <td style="padding: 4px; width: 20px;">:</td>
                                <td style="padding: 4px;">{{ $item->booking->pasien->no_rm }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding: 4px; text-align: left;">Nama Pasien</th>
                                <td style="padding: 4px; width: 20px;">:</td>
                                <td style="padding: 4px;">{{ $item->booking->pasien->nama_pasien }}</td>
                            </tr>                                
                            <tr>
                                <th scope="row" style="padding: 4px; text-align: left;">Jenis Pasien</th>
                                <td style="padding: 4px; width: 20px;">:</td>
                                <td style="padding: 4px;">{{ $item->booking->pasien->jenis_pasien }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding: 4px; text-align: left;">Umur</th>
                                <td style="padding: 4px; width: 20px;">:</td>
                                <td style="padding: 4px;">
                                    <?php 
                                        $tgllahir = \Carbon\Carbon::parse($item->booking->pasien->tgllahir);
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
                                <td style="padding: 4px; width: 20px;">:</td>
                                <td style="padding: 4px;">{{ $item->booking->pasien->jekel == 'L'  ? 'Laki-laki' : ($item->booking->pasien->jekel == 'P' ? 'Perempuan' : '') }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding: 4px; text-align: left;">Alamat Domisili</th>
                                <td style="padding: 4px; width: 20px;">:</td>
                                <td style="padding: 4px;">{{ $item->booking->pasien->domisili }}</td>
                            </tr>
                        </tbody>
                    </table>                         
                </div>

                <p style="font-size: 20px; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">Gambar Odontogram Gigi</p>

                <div class="d-flex justify-content-center mb-4 mt-3">
                    <img id="displayedImage" src="{{ asset('assets/images/gigi.jpeg') }}" style="max-width: 70%; height: auto; border-radius: 10px" alt="Kerangka">
                </div>
                <hr>
                {{-- value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --}}
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
                            <input type="text" class="form-control" name="gigi_lain_lain" id="gigi_lain-lain" placeholder="Lain-lain">
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
                        <div class="input-row" id="tambahGigi-container" style="display: flex; align-items: center; margin-right: 10px; flex-wrap: nowrap; overflow-x: auto;">
                            <label for="no_gigi" style="min-width: 100px;">Nomor Gigi</label>
                            <span>:</span>
                            <input type="text" class="form-control mt-2 mb-2" name="no_gigi[0]" placeholder="Masukkan Nomor Gigi" style="margin-left: 7px">
                            
                            <button type="button" class="btn btn-primary tambah-gigi mt-2 mb-2" onclick="tambahKolom('tambahGigi')" style="margin-left: 10px">
                                <i class="fa-solid fa-tooth"></i>
                            </button>
                        </div>                                              
                        
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control mt-2 mb-2" name="keterangan[0]" placeholder="Keterangan">
                        </div>          
                        <div class="form-group">
                            <label for="">Tindakan</label>
                            <input type="date" class="form-control mt-2 mb-2" name="tindakan_gigi" id="tindakan_gigi" placeholder="Tindakan">
                        </div>
                        <div class="form-group">
                            <label for="">Prosedur Tindakan Tindakan</label>
                            <input type="text" class="form-control mt-2 mb-2" name="prosedur_tindakan" id="prosedur_tindakan" placeholder="Prosedur Tindakan">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Rencana</label>
                            <input type="date" class="form-control mt-2 mb-2" name="tgl_rencana" id="tgl_rencana" placeholder="Prosedur Tindakan">
                        </div>
                        <div class="form-group">
                            <label for="">Lama Tindakan</label>
                            <input type="text" class="form-control mt-2 mb-2" name="lama_tindakan" id="lama_tindakan" placeholder="Lama Tindakan">
                        </div>
                        <div class="form-group">
                            <label for="">Hasil</label>
                            <input type="text" class="form-control mt-2 mb-2" name="hasil_tindakan" id="hasil_tindakan" placeholder="Hasil">
                        </div>
                        <div class="form-group">
                            <label for="">Indikasi</label>
                            <input type="text" class="form-control mt-2 mb-2" name="indikasi_tindakan" id="indikasi_tindakan" placeholder="Indikasi">
                        </div>
                        <div class="form-group">
                            <label for="">Tujuan</label>
                            <input type="text" class="form-control mt-2 mb-2" name="tujuan_tindakan" id="tujuan_tindakan" placeholder="Tujuan">
                        </div>
                        <div class="form-group">
                            <label for="">Resiko</label>
                            <input type="text" class="form-control mt-2 mb-2" name="resiko_tindakan" id="resiko_tindakan" placeholder="Resiko">
                        </div>
                        <div class="form-group">
                            <label for="">Komplikasi</label>
                            <input type="text" class="form-control mt-2 mb-2" name="komplikasi_tindakan" id="komplikasi_tindakan" placeholder="Komplikasi">
                        </div>
                        <div class="form-group">
                            <label for="">Prognosa</label>
                            <input type="text" class="form-control mt-2 mb-2" name="prognosa_tindakan" id="prognosa_tindakan" placeholder="Prognosa">
                        </div>
                        <div class="form-group">
                            <label for="">Alternatif & Resiko</label>
                            <input type="text" class="form-control mt-2 mb-2" name="alternatif_resiko" id="alternatif_resiko" placeholder="Alternatif & Resiko">
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control mt-2 mb-2" name="keterangan_tindakan" id="keterangan_tindakan" placeholder="Keterangan">
                        </div>
                        <div class="tutup" style="margin-top: 20px; margin-bottom: 30px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
</section>

@endsection

@push('script')
    <script>
        // tambah gigi

        let kolomIndex = 1; // Inisialisasi indeks untuk kolom baru

        window.tambahKolom = function(name) {
            let newElement = '';

            if (name === "tambahGigi") {
                newElement = `
                    <div style="display: contents; align-items: center; margin-right: 10px; gap: 5px; vertical-align: top;">
                        <input type="text" name="no_gigi[${kolomIndex}]" class="form-control mt-2 mb-2" placeholder="Masukkan Nomor Gigi" style="margin-left: 10px;">
                        <button type="button" class="btn btn-danger mt-2 mb-2" style="margin-left: 10px;" onclick="$(this).parent().remove()">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                `;
                // Append kolom baru secara horizontal ke dalam container
                $('#tambahGigi-container').append(newElement);
            }

            // Increment indeks kolom setiap kali kolom baru ditambahkan
            kolomIndex++;
        };

        // Diastema elements
        const tidakAdaDiastemaRadio = document.getElementById('jawaban-tidak_ada');
        const adaDiastemaRadio = document.getElementById('jawaban-ada');
        const alasanDiastema = document.getElementById('alasan-diastema');

        // Gigi Anomali elements
        const tidakAdaAnomaliRadio = document.getElementById('anomali-tidak_ada');
        const adaAnomaliRadio = document.getElementById('anomali-ada');
        const alasanGigiAnomali = document.getElementById('alasan-gigi_anomali');

        // Function to toggle alasan for diastema
        function toggleAlasanDiastema() {
            if (adaDiastemaRadio.checked) {
                alasanDiastema.style.display = 'block';
            } else {
                alasanDiastema.style.display = 'none';
            }
        }

        // Function to toggle alasan for gigi_anomali
        function toggleAlasanGigiAnomali() {
            if (adaAnomaliRadio.checked) {
                alasanGigiAnomali.style.display = 'block';
            } else {
                alasanGigiAnomali.style.display = 'none';
            }
        }

        // Event listeners for diastema radio buttons
        tidakAdaDiastemaRadio.addEventListener('change', toggleAlasanDiastema);
        adaDiastemaRadio.addEventListener('change', toggleAlasanDiastema);

        // Event listeners for gigi_anomali radio buttons
        tidakAdaAnomaliRadio.addEventListener('change', toggleAlasanGigiAnomali);
        adaAnomaliRadio.addEventListener('change', toggleAlasanGigiAnomali);

        // Initialize on page load
        toggleAlasanDiastema();
        toggleAlasanGigiAnomali();

    </script>
@endpush