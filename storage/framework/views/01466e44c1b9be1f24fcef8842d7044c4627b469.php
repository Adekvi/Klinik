 <!-- Modal PERIKSA -->
 <div class="modal fade" id="periksa<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="periksa" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <form id="myForm1" action="<?php echo e(url('perawat/store/' . $item->id)); ?>" method="POST"
                 enctype="multipart/form-data">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0);">Asesmen
                         Keperawatan - Asesmen Awal</h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     
                     <?php
                         use Carbon\Carbon;

                         // Ambil waktu pembuatan data pertama kali dari RM
                         $createdAtRM = optional($item->rm)->created_at;

                         // Tentukan tanggal 3 bulan setelah data pertama kali dibuat (untuk asesmen awal)
                         $nextAsesmenDate = $createdAtRM ? Carbon::parse($createdAtRM)->addMonths(3) : null;

                         // Ambil tanggal terakhir pasien melakukan kajian awal (jika ada)
                         $lastKajianDate = optional($item->kajian)->created_at;

                         // Tentukan kapan kajian awal berikutnya berdasarkan kajian terakhir
                         $nextKajianDate = $lastKajianDate ? Carbon::parse($lastKajianDate)->addMonths(3) : null;

                         // Ambil tanggal saat ini
                         $now = Carbon::now();

                         // Cek apakah pasien belum pernah melakukan kajian awal atau sudah waktunya kajian ulang
                         $shouldShowKajianWarning =
                             !$lastKajianDate || ($nextKajianDate && $now->greaterThanOrEqualTo($nextKajianDate));

                         // Cek apakah data dari RM masih kosong atau sudah waktunya asesmen
                         $shouldShowAsesmenWarning =
                             !$createdAtRM || ($nextAsesmenDate && $now->greaterThanOrEqualTo($nextAsesmenDate));

                         // Cek apakah asesmen sudah terisi (dilihat dari tanda tangan perawat)
                         $isAsesmenFilled = !empty($item->ak_ttdperawat_bidan);

                         // Cek apakah kajian sudah terisi (dilihat dari masalah keperawatan)
                         $isKajianFilled = !empty($item->ak_nama_perawat_bidan);
                     ?>

                     <div class="periksa d-flex justify-content-between align-items-start">
                         <!-- Bagian Kiri: Tombol -->
                         <div class="d-flex gap-2">
                             <button type="button" class="btn btn-outline-primary" id="btnAsesmen<?php echo e($item->id); ?>">
                                 Asesmen Awal
                             </button>
                             <button type="button" class="btn btn-outline-info" id="btnKajian<?php echo e($item->id); ?>">
                                 Kajian Awal
                             </button>
                         </div>

                         <!-- Bagian Kanan: Status -->
                         <div class="d-flex flex-column text-end">
                             <span id="statusAsesmen<?php echo e($item->id); ?>" class="badge border text-warning bg-white">
                                 <i class="fa-solid fa-circle-exclamation"></i>
                                 <?php echo e($isAsesmenFilled ? 'Asesmen Terisi' : 'Belum Melakukan Asesmen'); ?>

                             </span>
                             <span id="statusKajian<?php echo e($item->id); ?>" class="badge border text-danger bg-white mt-1">
                                 <i class="fa-solid fa-circle-exclamation"></i>
                                 <?php echo e($isKajianFilled ? 'Kajian Terisi' : 'Belum Melakukan Kajian Awal'); ?>

                             </span>
                         </div>
                     </div>

                     <?php if($createdAtRM && $now->greaterThanOrEqualTo($nextKajianDate)): ?>
                         <input type="hidden" name="idrm" value="<?php echo e($item->rm->id); ?>">
                         <input type="hidden" name="id_pasien" value="<?php echo e($item->booking->pasien->id); ?>">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="">Nama Pasien</label>
                                 <input type="text" name="nama_pasien" id="nama_pasien"
                                     class="form-control mt-2 mb-2" value="<?php echo e($item->booking->pasien->nama_pasien); ?>">
                             </div>
                             <p class="text-danger">
                                 <strong>
                                     *Cek ulang Nama Pasien
                                 </strong>
                             </p>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="">Umur</label>
                                 <p>
                                     <?php echo e(Carbon::parse($item->booking->pasien->tgllahir)->age); ?> Tahun
                                 </p>
                             </div>
                         </div>

                         <div class="form-isian" style="margin-bottom: 30px">
                             <h5 style="font-size: 20px; text-align: center"><strong>Form Isian</strong></h5>
                             <div class="form-group mt-2 mb-2">
                                 <p onclick="toggleInput('isian')" style="margin-bottom: 3px; text-align: start">
                                     Isian
                                     Pilihan</p>
                                 <div id="isian" style="text-align: center; font-size: 20px">
                                     <label for="isian-ya">
                                         <input type="radio" name="isian" id="isian-ya" value="auto-anamnesis"
                                             onclick="toggleChange('alasan-isian', this)"
                                             style="transform: scale(1.5); margin-right: 10px;"> Auto Anamnesis
                                     </label>
                                     <label for="isian-tidak">
                                         <input type="radio" name="isian" id="isian-tidak" value="Aloanamnesis"
                                             onclick="toggleChange('alasan-isian', this)"
                                             style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                         Aloanamnesis
                                     </label>
                                 </div>
                                 <div id="alasan-isian" style="display: none;">
                                     <input type="text" id="isian_alasan" name="isian_alasan"
                                         class="form-control mt-2 mb-2" placeholder="Alasan">
                                 </div>
                             </div>
                         </div>
                         <div class="anamnesis-s">
                             <h5 style="font-size: 20px; text-align: center" onclick="anamnesisS()">Anamnesis (S)
                             </h5>
                             <div class="form-group">
                                 <label for="keluhan" onclick="toggleInput('a_keluhan_utama')">Keluhan Utama
                                 </label>
                                 <input type="text" name="a_keluhan_utama" id="a_keluhan_utama"
                                     class="form-control mt-2 mb-2 " placeholder="Isi Keluhan Utama"
                                     value="<?php echo e($item->rm->a_keluhan_utama ?? ''); ?>">
                             </div>
                         </div>
                         <div class="tanda-vital mt-4">
                             <h5 style="margin-bottom: 5px; font-size: 20px" onclick="tandaVital()">Tanda Vital</h5>
                             <div class="col-lg-12 mb-2">
                                 <div class="row">
                                     <div class="col-6">
                                         <label for="tensi">Tensi</label>
                                         <div class="input-group">
                                             <input type="text" name="tensi"
                                                 value="<?php echo e($item->isian->p_tensi ?? ''); ?>" class="form-control"
                                                 aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
                                                     <b>mmHg</b>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <label for="rr">RR</label>
                                         <div class="input-group">
                                             <input type="text" name="rr"
                                                 value="<?php echo e($item->isian->p_rr ?? ''); ?>" class="form-control"
                                                 aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
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
                                         <label for="nadi">Nadi</label>
                                         <div class="input-group">
                                             <input type="text" name="nadi"
                                                 value="<?php echo e($item->isian->p_nadi ?? ''); ?>" class="form-control"
                                                 aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
                                                     <b>/ minute</b>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <label for="spo">SpO2</label>
                                         <div class="input-group">
                                             <input type="text" name="spo2"
                                                 value="<?php echo e($item->isian->p_suhu ?? ''); ?>" class="form-control"
                                                 aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
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
                                         <label for="suhu">Suhu</label>
                                         <div class="input-group">
                                             <input type="text" name="suhu"
                                                 value="<?php echo e($item->isian->p_suhu ?? ''); ?>" class="form-control"
                                                 aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
                                                     <b>°c</b>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <label for="tb">Tinggi Badan</label>
                                         <div class="input-group">
                                             <input type="number" name="tb" id="tb"
                                                 value="<?php echo e($item->isian->p_tb ?? ''); ?>" class="form-control"
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
                             </div>
                             <div class="col-lg-12 mb-2">
                                 <div class="row">
                                     <div class="col-6">
                                         <label for="bb">Berat Badan</label>
                                         <div class="input-group">
                                             <input type="number" name="bb" id="bb"
                                                 value="<?php echo e($item->isian->p_bb ?? ''); ?>" class="form-control"
                                                 aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
                                                     <b>kg</b>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <label for="imt">IMT</label>
                                         <div class="input-group">
                                             <input type="text" name="p_imt" id="l_imt"
                                                 value="<?php echo e($item->isian->p_imt ?? ''); ?>" class="form-control"
                                                 aria-describedby="basic-addon2" readonly>
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
                                                     <b>kg/m2</b>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-12 mb-2">
                                 <div class="row">
                                     <div class="col-6">
                                         <label for="lka">Lingkar Kepala Anak</label>
                                         <div class="input-group">
                                             <input type="number" name="p_lngkr_kepala_anak"
                                                 id="p_lngkr_kepala_anak"
                                                 value="<?php echo e($item->isian->p_lngkr_kepala_anak ?? ''); ?>"
                                                 class="form-control" aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
                                                     <b>cm</b>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <label for="ll">Lingkar Lengan</label>
                                         <div class="input-group">
                                             <input type="text" name="p_lngkr_lengan_anc" id="p_lngkr_lengan_anc"
                                                 value="<?php echo e($item->isian->p_lngkr_lengan_anc ?? ''); ?>"
                                                 class="form-control" aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"
                                                     style="background: rgb(228, 228, 228)">
                                                     <b>cm</b>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="form-group">
                             <h5 for="ak_nama_perawat_bidan"
                                 style="margin-top: 30px; text-align: center; font-size: 20px">
                                 <strong>Tanda Tangan Perawat</strong>
                             </h5>
                             <select type="text" name="ak_nama_perawat_bidan" id="ak_nama_perawat_bidan"
                                 class="form-control mt-2 mb-2">
                                 <option value="">Nama Perawat</option>
                                 <!-- Iterate through your perawat data to populate the dropdown -->
                                 <?php $__currentLoopData = $ttd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <option value="<?php echo e($item->id); ?>"
                                         data-image="<?php echo e(Storage::url($item->foto)); ?>"><?php echo e($item->nama); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </select>
                             <!-- Tambahkan elemen img untuk menampilkan tanda tangan -->
                             <img id="ttd_perawat_image" src="" alt="Tanda Tangan Perawat">
                         </div>
                     <?php else: ?>
                         <div id="formAsesmen<?php echo e($item->id); ?>">
                             <input type="hidden" name="id_pasien" value="<?php echo e($item->booking->id_pasien); ?>">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="">Nama Pasien</label>
                                         <input type="text" name="nama_pasien" id="nama_pasien"
                                             class="form-control mt-2 mb-2"
                                             value="<?php echo e($item->booking->pasien->nama_pasien); ?>">
                                     </div>
                                     <p class="text-danger">
                                         <span style="font-style: italic">
                                             <strong>
                                                 <i class="fa-solid fa-circle-exclamation"></i> *Cek ulang Nama Pasien
                                             </strong>
                                         </span>
                                     </p>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="">Umur</label>
                                         <input type="text"
                                             value="<?php echo e(Carbon::parse($item->booking->pasien->tgllahir)->age . ' Tahun'); ?>"
                                             class="form-control mt-2 mb-2" readonly>
                                     </div>
                                 </div>
                                 <hr style="border: none; height: 1px">
                             </div>

                             <div class="form-isian" style="margin-bottom: 30px; margin-top: 20px">
                                 <h5 style="text-align: center; font-size: 20px"><strong>Form Isian</strong></h5>
                                 <div class="form-group mt-2 mb-2">
                                     <p onclick="toggleInput('isian')" style="margin-bottom: 3px; text-align: start">
                                         Isian Pilihan</p>
                                     <div id="isian" style="text-align: start; font-size: 20px">
                                         <label for="isian-ya">
                                             <input type="radio" name="isian" id="isian-ya"
                                                 value="Auto-anamnesis" onclick="toggleChange('alasan-isian', this) "
                                                 style="transform: scale(1.5); margin-right: 10px;"> Auto Anamnesis
                                         </label>
                                         <label for="isian-tidak">
                                             <input type="radio" name="isian" id="isian-tidak"
                                                 value="Aloanamnesis" onclick="toggleChange('alasan-isian', this)"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Aloanamnesis
                                         </label>
                                     </div>
                                     <div id="alasan-isian" style="display: none;">
                                         <input type="text" id="isian_alasan" name="isian_alasan"
                                             class="form-control mt-2 mb-2" placeholder="Alasan">
                                     </div>
                                 </div>
                             </div>

                             <div class="anamnesis-s" style="margin-bottom: 30px">
                                 <h5 style="text-align: center; font-size: 20px"><strong>Anamnesis (S)</strong>
                                 </h5>
                                 <div class="row">
                                     <div class="col-6">
                                         <div class="form-group">
                                             <label for="keluhan">Keluhan Utama </label>
                                             <input type="text" name="a_keluhan_utama" id="a_keluhan_utama"
                                                 class="form-control mt-2 mb-2 " placeholder="Isi Keluhan Utama"
                                                 value="<?php echo e($item->rm->a_keluhan_utama ?? ''); ?>">
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <div class="form-group">
                                             <label for="riwayat-penyakit-skrg">Riwayat Penyakit Sekarang</label>
                                             <input type="text" name="a_riwayat_penyakit_skrg"
                                                 id="a_riwayat_penyakit_skrg" class="form-control mt-2 mb-2 "
                                                 placeholder="Isi Riwayat Penyakit Sekarang"
                                                 value="<?php echo e($item->rm->a_riwayat_penyakit_skrg ?? ''); ?>">
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <div class="form-group">
                                             <label for="riwayat-penyakit-terdahulu">Riwayat Penyakit
                                                 Terdahulu</label>
                                             <input type="text" name="a_riwayat_penyakit_terdahulu"
                                                 id="a_riwayat_penyakit_terdahulu" class="form-control mt-2 mb-2 "
                                                 placeholder="Isi Riwayat Penyakit Terdahulu"
                                                 value="<?php echo e($item->rm->a_riwayat_penyakit_terdahulu ?? ''); ?>">
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <div class="form-group">
                                             <label for="riwayat-penyakit-keluarga">Riwayat Penyakit
                                                 Keluarga</label>
                                             <input type="text" name="a_riwayat_penyakit_keluarga"
                                                 id="a_riwayat_penyakit_keluarga" class="form-control mt-2 mb-2 "
                                                 placeholder="Isi Riwayat Penyakit Keluarga"
                                                 value="<?php echo e($item->rm->a_riwayat_penyakit_keluarga ?? ''); ?>">
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label for="riwayat-alergi">Riwayat Alergi</label>
                                         <select name="a_riwayat_alergi" id="a_riwayat_alergi"
                                             class="form-control mt-2 mb-2 ">
                                             <option value="<?php echo e($item->rm->a_riwayat_penyakit_skrg ?? 'Tidak Ada'); ?>"
                                                 selected><?php echo e($item->rm->a_riwayat_alergi ?? 'Tidak Ada'); ?></option>
                                             <option value="Ada">Ada</option>
                                             <option value="Tidak">Tidak</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>

                             <div class="tanda-vital" style="margin-bottom: 30px">
                                 <h5 style="text-align: center; font-size: 20px;"><strong>Tanda Vital</strong></h5>
                                 <div class="col-lg-12 mb-2">
                                     <div class="row">
                                         <div class="col-6">
                                             <label for="tensi">Tensi</label>
                                             <div class="input-group">
                                                 <input type="text" name="tensi"
                                                     value="<?php echo e($item->isian->p_tensi ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>mmHg</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <label for="rr">RR</label>
                                             <div class="input-group">
                                                 <input type="text" name="rr"
                                                     value="<?php echo e($item->isian->p_rr ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
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
                                             <label for="nadi">Nadi</label>
                                             <div class="input-group">
                                                 <input type="text" name="nadi"
                                                     value="<?php echo e($item->isian->p_nadi ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>/ minute</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <label for="spo">SpO2</label>
                                             <div class="input-group">
                                                 <input type="text" name="spo2"
                                                     value="<?php echo e($item->isian->p_suhu ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
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
                                             <label for="suhu">Suhu</label>
                                             <div class="input-group">
                                                 <input type="text" name="suhu"
                                                     value="<?php echo e($item->isian->p_suhu ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>°c</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <label for="tb">Tinggi Badan</label>
                                             <div class="input-group">
                                                 <input type="number" name="tb" id="p_tb"
                                                     value="<?php echo e($item->isian->p_tb ?? ''); ?>" class="form-control"
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
                                 </div>
                                 <div class="col-lg-12 mb-2">
                                     <div class="row">
                                         <div class="col-6">
                                             <label for="bb">Berat Badan</label>
                                             <div class="input-group">
                                                 <input type="number" name="bb" id="p_bb"
                                                     value="<?php echo e($item->isian->p_bb ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>kg</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <label for="imt">IMT</label>
                                             <div class="input-group">
                                                 <input type="text" name="p_imt" id="p_imt"
                                                     value="<?php echo e($item->isian->p_imt ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2" readonly>
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>kg/m2</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-12 mb-2">
                                     <div class="row">
                                         <div class="col-6">
                                             <label for="lingkar-kepala-anak">Lingkar Kepala Anak</label>
                                             <div class="input-group">
                                                 <input type="number" name="p_lngkr_kepala_anak"
                                                     id="p_lngkr_kepala_anak"
                                                     value="<?php echo e($item->isian->p_lngkr_kepala_anak ?? ''); ?>"
                                                     class="form-control" aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>cm</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <label for="lingkar-lengan">Lingkar Lengan</label>
                                             <div class="input-group">
                                                 <input type="text" name="p_lngkr_lengan_anc"
                                                     id="p_lngkr_lengan_anc"
                                                     value="<?php echo e($item->isian->p_lngkr_lengan_anc ?? ''); ?>"
                                                     class="form-control" aria-describedby="basic-addon2">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>cm</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="anamnesis-o" style="margin-bottom: 30px">
                                 <h5 style="text-align: center; font-size: 20px;"><strong>Pemeriksaan Fisik Umum
                                         (0)</strong></h5>
                                 <div class="row">
                                     <div class="col-lg-6">
                                         <div class="form-group">
                                             <label for="keadaan_umum">Keadaan Umum</label>
                                             <input type="text" name="keadaan_umum" id="keadaan_umum"
                                                 class="form-control mt-2 mb-2 " placeholder="Isi Keadaan Umum"
                                                 value="<?php echo e($item->rm->o_keadaan_umum ?? ''); ?>">
                                         </div>
                                     </div>
                                     <div class="col-lg-6">
                                         <div class="form-group mt-2 mb-2">
                                             
                                             <label for="kesadaran">Kesadaran</label>
                                             <select name="kesadaran" id="kesadaran" class="form-control">
                                                 <option value="Compos Mentis">Compos Mentis</option>
                                                 <option value="Somnolence">Somnolence</option>
                                                 <option value="Sopor">Sopor</option>
                                                 <option value="Coma">Coma</option>
                                             </select>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-6 mb-3">
                                     <div class="row">
                                         <div class="col-12">
                                             <label for="gcs">GCS</label>
                                             <div class="input-group d-flex mt-2">
                                                 <input type="text" name="gcs_e" id="gcs_e"
                                                     value="<?php echo e($item->isian->gcs_e ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2" placeholder="E">
                                                 <input type="text" name="gcs_m" id="gcs_m"
                                                     value="<?php echo e($item->isian->gcs_m ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2" placeholder="M">
                                                 <input type="text" name="gcs_v" id="gcs_v"
                                                     value="<?php echo e($item->isian->gcs_v ?? ''); ?>" class="form-control"
                                                     aria-describedby="basic-addon2" placeholder="V">
                                                 <div class="input-group-append">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         Total: &nbsp; <span id="gcs_total"> <b>0</b></span>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row" style="text-align: start">
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px">Kepala</p>
                                         <div id="kepala">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="kepala" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-kepala_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="kepala"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-kepala_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-kepala_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-kepala_<?php echo e($item->id); ?>"
                                                 name="alasan-kepala" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Mata</p>
                                         <div id="mata">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="mata" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-mata_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="mata"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-mata_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-mata_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-mata_<?php echo e($item->id); ?>"
                                                 name="alasan-mata" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Leher</p>
                                         <div id="leher">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="leher" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-leher_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="leher"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-leher_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-leher_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-leher_<?php echo e($item->id); ?>"
                                                 name="alasan-leher" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">THT (Telinga Hidung Tenggorokan)</p>
                                         <div id="tht">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="tht" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-tht_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="tht"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-tht_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-tht_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-tht_<?php echo e($item->id); ?>"
                                                 name="alasan-tht" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Thorax</p>
                                         <div id="thorax">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="thorax" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-thorax_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="thorax"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-thorax_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-thorax_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-thorax_<?php echo e($item->id); ?>"
                                                 name="alasan-thorax" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Paru</p>
                                         <div id="paru">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="paru" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-paru_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="paru"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-paru_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-paru_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-paru_<?php echo e($item->id); ?>"
                                                 name="alasan-paru" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Jantung</p>
                                         <div id="jantung">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="jantung" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-jantung_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="jantung"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-jantung_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-jantung_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-jantung_<?php echo e($item->id); ?>"
                                                 name="alasan-jantung" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Abdomen</p>
                                         <div id="abdomen">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="abdomen" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-abdomen_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="abdomen"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-abdomen_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-abdomen_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-abdomen_<?php echo e($item->id); ?>"
                                                 name="alasan-abdomen" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Ekstremitas / Anggota Gerak</p>
                                         <div id="ekstremitas">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="ekstremitas" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-ekstremitas_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="ekstremitas"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-ekstremitas_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-ekstremitas_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-ekstremitas_<?php echo e($item->id); ?>"
                                                 name="alasan-ekstremitas" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <p style="margin-bottom: 5px;">Kulit</p>
                                         <div id="kulit">
                                             <label for="jawaban-normal">
                                                 <input type="radio" name="kulit" id="jawaban-normal"
                                                     value="Normal" checked
                                                     onclick="toggleChange('alasan-kulit_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px;"> Normal
                                             </label>
                                             <label for="jawaban-abnormal">
                                                 <input class="mx-3" type="radio" name="kulit"
                                                     id="jawaban-abnormal" value="Abnormal"
                                                     onclick="toggleChange('alasan-kulit_<?php echo e($item->id); ?>', this)"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                 Abnormal
                                             </label>
                                         </div>
                                         <div id="alasan-kulit_<?php echo e($item->id); ?>" style="display: none;">
                                             <input type="text" id="alasan-kulit_<?php echo e($item->id); ?>"
                                                 name="alasan-kulit" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                     <div class="form-group mt-2 mb-2">
                                         <label for="lain-lain">Lain - Lain</label>
                                         <input type="text" name="lain" id="lain"
                                             class="form-control mt-2 mb-2" placeholder="Lain-lain">
                                     </div>
                                 </div>
                             </div>

                             <div class="form-group">
                                 <h5 for="id_ttd_medis" style="margin-top: 30px; text-align: center">
                                     <strong>Tanda Tangan Perawat</strong>
                                 </h5>
                                 <select type="text" name="id_ttd_medis" id="id_ttd_medis<?php echo e($item->id); ?>"
                                     class="form-control mt-2 mb-2" required>
                                     <option value="">Nama Perawat</option>
                                     <!-- Iterate through your perawat data to populate the dropdown -->
                                     <?php $__currentLoopData = $ttd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perawat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($perawat->id); ?>"><?php echo e($perawat->nama); ?>

                                         </option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                             </div>
                         </div>
                         <div id="formKajian<?php echo e($item->id); ?>" style="display: none">
                             <div class="kebiasaan">
                                 <h5 class="text-center"
                                     style="font-size: 20px; font-weight: bold; margin-bottom: -5px"
                                     onclick="toggleStep(this)">Kebiasaan</h5>
                                 <div class="row">
                                     <div class="col-6">
                                         <!-- Rokok -->
                                         <div class="form-group mt-3 text-center">
                                             <p style="margin-bottom: 10px; font-size: 20px;">Rokok</p>
                                             <div id="rokok" style="display: flex; gap: 20px; margin-left: 140px">
                                                 <label for="rokok-ya" style="display: flex; align-items: center;">
                                                     <input type="radio" name="rokok" id="rokok-ya"
                                                         value="Ya"
                                                         style="transform: scale(1.5); margin-right: 10px;"> Ya
                                                 </label>
                                                 <label for="rokok-tidak" style="display: flex; align-items: center;">
                                                     <input type="radio" name="rokok" id="rokok-tidak"
                                                         value="Tidak" checked
                                                         style="transform: scale(1.5); margin-right: 10px;"> Tidak
                                                 </label>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <!-- Alkohol -->
                                         <div class="form-group mt-3 text-center">
                                             <p style="margin-bottom: 10px; font-size: 20px;">Alkohol</p>
                                             <div id="alkohol" style="display: flex; gap: 20px; margin-left: 140px">
                                                 <label for="alkohol-ya" style="display: flex; align-items: center;">
                                                     <input type="radio" name="alkohol" id="alkohol-ya"
                                                         value="Ya"
                                                         style="transform: scale(1.5); margin-right: 10px;"> Ya
                                                 </label>
                                                 <label for="alkohol-tidak"
                                                     style="display: flex; align-items: center;">
                                                     <input type="radio" name="alkohol" id="alkohol-tidak"
                                                         value="Tidak" checked
                                                         style="transform: scale(1.5); margin-right: 10px;"> Tidak
                                                 </label>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <!-- Olahraga -->
                                         <div class="form-group mt-3 text-center">
                                             <p style="margin-bottom: 10px; font-size: 20px;">Olahraga</p>
                                             <div id="olahraga"
                                                 style="display: flex; gap: 20px; margin-left: 140px;">
                                                 <label for="olahraga-ya" style="display: flex; align-items: center;">
                                                     <input type="radio" name="olahraga" id="olahraga-ya"
                                                         value="Ya"
                                                         style="transform: scale(1.5); margin-right: 10px;"> Ya
                                                 </label>
                                                 <label for="olahraga-tidak"
                                                     style="display: flex; align-items: center;">
                                                     <input type="radio" name="olahraga" id="olahraga-tidak"
                                                         value="Tidak" checked
                                                         style="transform: scale(1.5); margin-right: 10px;"> Tidak
                                                 </label>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <!-- Obat Tidur -->
                                         <div class="form-group mt-3 text-center">
                                             <p style="margin-bottom: 10px; font-size: 20px;">Obat Tidur</p>
                                             <div id="obat_tidur"
                                                 style="display: flex; gap: 20px; margin-left: 140px;">
                                                 <label for="obat_tidur-ya"
                                                     style="display: flex; align-items: center;">
                                                     <input type="radio" name="obat_tidur" id="obat_tidur-ya"
                                                         value="Ya"
                                                         style="transform: scale(1.5); margin-right: 10px;"> Ya
                                                 </label>
                                                 <label for="obat_tidur-tidak"
                                                     style="display: flex; align-items: center;">
                                                     <input type="radio" name="obat_tidur" id="obat_tidur-tidak"
                                                         value="Tidak" checked
                                                         style="transform: scale(1.5); margin-right: 10px;"> Tidak
                                                 </label>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="riwayat-lahir mt-4">
                                 <h5 class="text-center" style="font-size: 20px; font-weight: bold"
                                     onclick="toggleStep(this)">Riwayat Lahir</h5>
                                 <div id="p_anak_riwayat_lahir" class="form-group mb-4 text-center"
                                     style="font-size: 20px">
                                     <label for="p_anak_riwayat_lahir_spontan">
                                         <input type="checkbox" name="p_anak_riwayat_lahir_spontan"
                                             id="p_anak_riwayat_lahir_spontan" value="Spontan"
                                             style="transform: scale(1.5); margin-right: 10px;">Spontan
                                     </label>
                                     <label for="p_anak_riwayat_lahir_operasi">
                                         <input type="checkbox" name="p_anak_riwayat_lahir_operasi"
                                             id="p_anak_riwayat_lahir_operasi" value="Operasi"
                                             style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">Operasi
                                     </label>
                                 </div>
                                 <div id="p_anak_riwayat_lahir">
                                     <label for="p_anak_riwayat_lahir"
                                         onclick="toggleInput('p_anak_riwayat_lahir)">Riwayat Lahir Bulan</label>
                                     <div class="form-group mb-2 mt-2" style="font-size: 20px">
                                         <label for="p_anak_riwayat_lahir_cukup_bulan">
                                             <input type="radio" name="p_anak_riwayat_lahir_cukup_bulan"
                                                 id="p_anak_riwayat_lahir_cukup_bulan" value="Cukup-bulan"
                                                 style="transform: scale(1.5); margin-right: 10px">Cukup Bulan
                                         </label>
                                         <label for="p_anak_riwayat_lahir_kurang_bulan">
                                             <input type="radio" name="p_anak_riwayat_lahir_kurang_bulan"
                                                 id="p_anak_riwayat_lahir_kurang_bulan" value="Kurang-bulan"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">Kurang
                                             Bulan
                                         </label>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <div class="row">
                                         <div class="col-6">
                                             <label for="p_anak_riwayat_lahir_bb">Berat Badan Lahir</label>
                                             <div class="input-group">
                                                 <input type="text" name="p_anak_riwayat_lahir_bb"
                                                     id="p_anak_riwayat_lahir_bb"
                                                     value="<?php echo e($item->isian->p_anak_riwayat_lahir_bb ?? ''); ?>"
                                                     class="form-control mb-2 mt-2" aria-describedby="basic-addon2">
                                                 <div class="input-group-append mb-2 mt-2">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>Kg</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <label for="p_anak_riwayat_lahir_pb">Panjang Badan Lahir</label>
                                             <div class="input-group">
                                                 <input type="text" name="p_anak_riwayat_lahir_pb"
                                                     id="p_anak_riwayat_lahir_pb"
                                                     value="<?php echo e($item->isian->p_anak_riwayat_lahir_pb ?? ''); ?>"
                                                     class="form-control mb-2 mt-2" aria-describedby="basic-addon2">
                                                 <div class="input-group-append mb-2 mt-2">
                                                     <span class="input-group-text" id="basic-addon2"
                                                         style="background: rgb(228, 228, 228)">
                                                         <b>cm</b>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="p_anak_riwayat_lahir_vaksin">Riwayat Vaksin</label>
                                     <div class="form-group mb-2 mt-2 text-center" style="font-size: 17px">
                                         <label for="p_anak_riwayat_lahir_bulan">
                                             <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_bcg"
                                                 id="p_anak_riwayat_lahir_vaksin_bcg" value="BCG"
                                                 style="transform: scale(1.5); margin-right: 10px">BCG
                                         </label>
                                         <label for="p_anak_riwayat_lahir_vaksin">
                                             <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_hepatitis"
                                                 id="p_anak_riwayat_lahir_vaksin_hepatitis" value="HEPATITIS"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">HEPATITIS
                                         </label>
                                         <label for="p_anak_riwayat_lahir_vaksin">
                                             <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_dpt"
                                                 id="p_anak_riwayat_lahir_vaksin_dpt" value="DPT"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">DPT
                                         </label>
                                         <label for="p_anak_riwayat_lahir_vaksin">
                                             <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_campak"
                                                 id="p_anak_riwayat_lahir_vaksin_campak" value="CAMPAK"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">CAMPAK
                                         </label>
                                         <label for="p_anak_riwayat_lahir_vaksin">
                                             <input type="checkbox" name="p_anak_riwayat_lahir_vaksin_polio"
                                                 id="p_anak_riwayat_lahir_vaksin_polio" value="POLIO"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">POLIO
                                         </label>
                                     </div>
                                 </div>
                             </div>

                             <div class="asesmen-keperawatan">
                                 <h5 style="text-align: center; margin-top: 20px; font-weight: bold; font-size: 20px"
                                     onclick="toggleStep(this)">Asesmen Keperawatan</h5>
                                 <div class="form-group">
                                     <label for="nutrisi" onclick="toggleInput('nutrisi')">Nutrisi</label>
                                     <div class="col-lg-12 mb-2">
                                         <div class="row">
                                             <div class="col-4">
                                                 <label for="berat-badan">Berat Badan</label>
                                                 <div class="input-group">
                                                     <input type="number" name="nutrisi_bb" id="nutrisi_bb"
                                                         value="<?php echo e($item->isian->nutrisi_bb ?? ''); ?>"
                                                         class="form-control mt-2 mb-2"
                                                         aria-describedby="basic-addon2">
                                                     <div class="input-group-append">
                                                         <span class="input-group-text mb-2 mt-2" id="basic-addon2"
                                                             style="background: rgb(228, 228, 228)">
                                                             <b>ons/kg</b>
                                                         </span>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-4">
                                                 <label for="tinggi-badan">Tinggi Badan</label>
                                                 <div class="input-group">
                                                     <input type="number" name="nutrisi_tb" id="nutrisi_tb"
                                                         value="<?php echo e($item->isian->nutrisi_tb ?? ''); ?>"
                                                         class="form-control mt-2 mb-2"
                                                         aria-describedby="basic-addon2">
                                                     <div class="input-group-append">
                                                         <span class="input-group-text mb-2 mt-2" id="basic-addon2"
                                                             style="background: rgb(228, 228, 228)">
                                                             <b>cm</b>
                                                         </span>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-4">
                                                 <label for="imt">IMT</label>
                                                 <div class="input-group">
                                                     <input type="text" name="nutrisi_imt" id="nutrisi_imt"
                                                         value="<?php echo e($item->isian->nutrisi_imt ?? ''); ?>"
                                                         class="form-control mt-2 mb-2"
                                                         aria-describedby="basic-addon2" readonly>
                                                     <div class="input-group-append">
                                                         <span class="input-group-text mb-2 mt-2" id="basic-addon2"
                                                             style="background: rgb(228, 228, 228)">
                                                             <b>kg/m2</b>
                                                         </span>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="ak_jenisaktivitas_mobilisasi"
                                         onclick="toggleInput('ak_jenisaktivitas_mobilisasi')">Aktivitas
                                         Latihan</label>
                                     <div class="row">
                                         <div class="col-6">
                                             <select name="ak_jenisaktivitas_mobilisasi"
                                                 id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                                 <option value="">Pilih Aktivitas Mobilisasi</option>
                                                 <option value="0 Mandiri">0 Mandiri</option>
                                                 <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                                 <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                                                     Lain
                                                 </option>
                                                 <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                                                     bantuan
                                                     Orang Lain dan Alat</option>
                                                 <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                                                     Tidak
                                                     Mampu</option>
                                             </select>
                                         </div>
                                         <div class="col-6">
                                             <select name="ak_jenisaktivitas_toileting"
                                                 id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                                 <option value="">Pilih Aktivitas Toileting</option>
                                                 <option value="0 Mandiri">0 Mandiri</option>
                                                 <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                                 <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                                                     Lain
                                                 </option>
                                                 <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                                                     bantuan
                                                     Orang Lain dan Alat</option>
                                                 <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                                                     Tidak
                                                     Mampu</option>
                                             </select>
                                         </div>
                                         <div class="col-6">
                                             <select name="ak_jenisaktivitas_makan_minum"
                                                 id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                                 <option value="">Pilih Aktivitas Makan Minum</option>
                                                 <option value="0 Mandiri">0 Mandiri</option>
                                                 <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                                 <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                                                     Lain
                                                 </option>
                                                 <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                                                     bantuan
                                                     Orang Lain dan Alat</option>
                                                 <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                                                     Tidak
                                                     Mampu</option>
                                             </select>
                                         </div>
                                         <div class="col-6">
                                             <select name="ak_jenisaktivitas_mandi"
                                                 id="ak_jenisaktivitas_mobilisasi" class="form-control mt-2 mb-2 ">
                                                 <option value="">Pilih Aktivitas Mandi</option>
                                                 <option value="0 Mandiri">0 Mandiri</option>
                                                 <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                                 <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang
                                                     Lain
                                                 </option>
                                                 <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu
                                                     bantuan
                                                     Orang Lain dan Alat</option>
                                                 <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau
                                                     Tidak
                                                     Mampu</option>
                                             </select>
                                         </div>
                                     </div>
                                     <select name="ak_jenisaktivitas_berpakaian" id="ak_jenisaktivitas_mobilisasi"
                                         class="form-control mt-2 mb-2 ">
                                         <option value="">Pilih Aktivitas Berpakaian</option>
                                         <option value="0 Mandiri">0 Mandiri</option>
                                         <option value="1 Dibantu Sebagian">1 Dibantu Sebagian</option>
                                         <option value="2 Perlu Bantuan Orang Lain">2 Perlu Bantuan Orang Lain
                                         </option>
                                         <option value="3 Perlu bantuan Orang Lain dan Alat">3 Perlu bantuan Orang
                                             Lain dan Alat</option>
                                         <option value="4 Tergantung atau Tidak Mampu">4 Tergantung atau Tidak
                                             Mampu
                                         </option>
                                     </select>
                                 </div>
                                 <div class="form-group">
                                     <label for="resikojatuh" onclick="toggleInput('resikojatuh')">Resiko
                                         Jatuh</label>
                                     <div class="form-group mb-2 mt-2 text-center" style="font-size: 17px">
                                         <label for="ak_resiko_jatuh_rendah">
                                             <input type="radio" name="ak_resiko_jatuh_rendah"
                                                 id="ak_resiko_jatuh_rendah" value="Rendah"
                                                 style="transform: scale(1.5); margin-right: 10px" checked> Rendah
                                         </label>
                                         <label for="ak_resiko_jatuh_sedang">
                                             <input type="radio" name="ak_resiko_jatuh_sedang"
                                                 id="ak_resiko_jatuh_sedang" value="Sedang"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Sedang
                                         </label>
                                         <label for="ak_resiko_jatuh_tinggi">
                                             <input type="radio" name="ak_resiko_jatuh_tinggi"
                                                 id="ak_resiko_jatuh_tinggi" value="Tinggi"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Tinggi
                                         </label>
                                     </div>
                                 </div>
                                 <div class="form-group mb-2 mt-2">
                                     <p onclick="toggleInput('psikologis')" style="margin-bottom: 5px;">
                                         Psikologis
                                     </p>
                                     <div id="psikologis" style="font-size: 15px; text-align: center">
                                         <label for="psikologis-senang">
                                             <input type="checkbox" name="ak_psikologis_senang"
                                                 id="ak_psikologis_senang" value="Senang"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Senang
                                         </label>
                                         <label for="psikologis-tenang">
                                             <input type="checkbox" name="ak_psikologis_tenang"
                                                 id="ak_psikologis_tenang" value="Tenang"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Tenang
                                         </label>
                                         <label for="psikologis-sedih">
                                             <input type="checkbox" name="ak_psikologis_sedih"
                                                 id="ak_psikologis_sedih" value="Sedih"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Sedih
                                         </label>
                                         <label for="psikologis-tegang">
                                             <input type="checkbox" name="ak_psikologis_tegang"
                                                 id="ak_psikologis_tegang" value="Tegang"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Tegang
                                         </label>
                                         <label for="psikologis-takut">
                                             <input type="checkbox" name="ak_psikologis_takut"
                                                 id="ak_psikologis_takut" value="Takut"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Takut
                                         </label>
                                         <label for="psikologis-depresi">
                                             <input type="checkbox" name="ak_psikologis_depresi"
                                                 id="ak_psikologis_depresi" value="Depresi"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Depresi
                                         </label>
                                         <label for="psikologis-lainnya">
                                             <input type="checkbox" name="alasan_ak_psikologis_lain"
                                                 id="ak_psikologis-lainnya" value="Lainnya"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                             Lainnya
                                         </label>
                                         <div id="alasan-ak_psikologis" style="display: none;">
                                             <input type="text" id="alasan-ak_psikologis"
                                                 name="alasan_ak_psikologis_lain" class="form-control mt-2 mb-2">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="ak_masalah" onclick="toggleInput('ak_masalah')">Masalah</label>
                                     <input type="text" name="ak_masalah" id="ak_masalah"
                                         class="form-control mt-2 mb-2 " placeholder="Masalah">
                                 </div>
                                 <div class="form-group">
                                     <label for="ak_rencana_tindakan"
                                         onclick="toggleInput('ak_rencana_tindakan')">Rencana Tindakan</label>
                                     <input type="text" name="ak_rencana_tindakan" id="ak_rencana_tindakan"
                                         class="form-control mt-2 mb-2" placeholder="Rencana Tindakan">
                                 </div>
                             </div>

                             <div class="psicososial-pengetahuan">
                                 <h5 class="text-center mt-4" onclick="toggleStep(this)"
                                     style="font-size: 20px; font-weight: bold">Riwayat Psicososial dan
                                     Pengetahuan
                                 </h5>
                                 <div class="form-group">
                                     <div class="row">
                                         <div class="col-6">
                                             <label for="psico_pengetahuan_ttg_penyakit_ini"
                                                 onclick="toggleInput('psico_pengetahuan_ttg_penyakit_ini')">Pengetahuan
                                                 tentang Penyakit</label>
                                             <div class="col mt-3" style="font-size: 18px; margin-left: 35px">
                                                 <input type="radio" name="psico_pengetahuan_ttg_penyakit_ini"
                                                     id="psico_pengetahuan_ttg_penyakit_ini-tahu" value="Tahu"
                                                     style="transform: scale(1.5); margin-right: 10px">Tahu
                                                 <input type="radio" name="psico_pengetahuan_ttg_penyakit_ini"
                                                     id="psico_pengetahuan_ttg_penyakit_ini-tidak_tahu"
                                                     value="Tidak-Tahu"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                                     checked>Tidak Tahu
                                             </div>
                                             
                                         </div>
                                         <div class="col-6">
                                             <label for="psico_perawatan_tindakan_yg_dlakukan"
                                                 onclick="toggleInput('psico_perawatan_tindakan_yg_dlakukan')">Perawatan/Tindakan
                                                 Yang Dilakukan</label>
                                             <div class="col mt-3" style="font-size: 18px; margin-left: 35px">
                                                 <input type="radio" name="psico_perawatan_tindakan_yg_dlakukan"
                                                     id="psico_perawatan_tindakan_yg_dlakukan-mengerti"
                                                     value="Mengerti"
                                                     style="transform: scale(1.5); margin-right: 10px">Mengerti
                                                 <input type="radio" name="psico_perawatan_tindakan_yg_dlakukan"
                                                     id="psico_perawatan_tindakan_yg_dlakukan-tidak_mengerti"
                                                     value="Tidak-mengerti"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                                     checked>Tidak Mengerti
                                             </div>
                                             
                                         </div>
                                         <div class="col-6 mt-3">
                                             <label for="psico_adakah_keyakinan_pantangan"
                                                 onclick="toggleInput('psico_adakah_keyakinan_pantangan')">Adakah
                                                 Keyakinan atau Pantangan</label>
                                             <div class="col mt-3" style="font-size: 18px; margin-left: 35px">
                                                 <input type="radio" name="psico_adakah_keyakinan_pantangan"
                                                     id="psico_adakah_keyakinan_pantangan-ada" value="Ada"
                                                     style="transform: scale(1.5); margin-right: 10px">Ada
                                                 <input type="radio" name="psico_adakah_keyakinan_pantangan"
                                                     id="psico_adakah_keyakinan_pantangan-tidak" value="Tidak"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                                     checked>Tidak
                                             </div>
                                             
                                         </div>
                                         <div class="col-6 mt-3">
                                             <label for="psico_kendala_kominukasi"
                                                 onclick="toggleInput('psico_kendala_kominukasi')">Kendala
                                                 Komunikasi</label>
                                             <div class="col mt-3" style="font-size: 18px; margin-left: 35px">
                                                 <input type="radio" name="psico_kendala_kominukasi"
                                                     id="psico_kendala_kominukasi-ada" value="Ada"
                                                     style="transform: scale(1.5); margin-right: 10px">Ada
                                                 <input type="radio" name="psico_kendala_kominukasi"
                                                     id="psico_kendala_kominukasi-tidak" value="Tidak"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                                     checked>Tidak
                                             </div>
                                             
                                         </div>
                                         <div class="col-6 mt-3">
                                             <label for="psico_yang_merawat_dirumah"
                                                 onclick="toggleInput('psico_yang_merawat_dirumah')">Yang Merawat
                                                 Dirumah</label>
                                             <div class="col mt-3" style="font-size: 18px; margin-left: 35px">
                                                 <input type="radio" name="psico_yang_merawat_dirumah"
                                                     id="psico_yang_merawat_dirumah-ada" value="Ada"
                                                     style="transform: scale(1.5); margin-right: 10px">Ada
                                                 <input type="radio" name="psico_yang_merawat_dirumah"
                                                     id="psico_yang_merawat_dirumah-tidak" value="Tidak"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                                     checked>Tidak
                                             </div>
                                             
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="asesmen-nyeri">
                                 <h5 class="text-center mt-4" style="font-size: 20px; font-weight: bold"
                                     onclick="toggleStep(this)">Asesmen Nyeri</h5>
                                 <div class="form-group">
                                     <div class="row">
                                         <div class="col-6">
                                             <label for="apakah_pasien_merasakan_nyeri"
                                                 onclick="toggleInput('apakah_pasien_merasakan_nyeri')">Apakah
                                                 pasien
                                                 merasakan nyeri</label>
                                             <div class="col mt-3" style="font-size: 18px; margin-left: 35px">
                                                 <input type="radio" name="apakah_pasien_merasakan_nyeri"
                                                     id="apakah_pasien_merasakan_nyeri-ya" value="ya"
                                                     style="transform: scale(1.5); margin-right: 10px">Ya
                                                 <input type="radio" name="apakah_pasien_merasakan_nyeri"
                                                     id="apakah_pasien_merasakan_nyeri-tidak" value="tidak"
                                                     style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                                     checked>Tidak
                                             </div>
                                             
                                         </div>
                                         <div class="col-6">
                                             <label for="nyeri_pencetus"
                                                 onclick="toggleInput('nyeri_pencetus')">Pencetus</label>
                                             <input type="text" name="nyeri_pencetus" id="nyeri_pencetus"
                                                 class="form-control mt-2 mb-2 ">
                                         </div>
                                         <div class="col-12">
                                             <label for="nyeri_kualitas"
                                                 onclick="toggleInput('nyeri_kualitas')">Kualitas</label>
                                             <div class="col mt-3 mb-3" id="nyeri"
                                                 style="font-size: 15px; text-align: center">
                                                 <label for="nyeri-tekanan">
                                                     <input type="radio" name="nyeri_kualitas"
                                                         id="nyeri_kualitas-tekanan" value="Tekanan"
                                                         style="transform: scale(1.5); margin-right: 10px;">
                                                     Tekanan
                                                 </label>
                                                 <label for="nyeri-terbakar">
                                                     <input type="radio" name="nyeri_kualitas"
                                                         id="nyeri_kualitas-terbakar" value="Terbakar"
                                                         style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                     Terbakar
                                                 </label>
                                                 <label for="nyeri-melilit">
                                                     <input type="radio" name="nyeri_kualitas"
                                                         id="nyeri_kualitas-melilit" value="Melilit"
                                                         style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                     Melilit
                                                 </label>
                                                 <label for="nyeri-tertusuk">
                                                     <input type="radio" name="nyeri_kualitas"
                                                         id="nyeri_kualitas-tertusuk" value="Tertusuk"
                                                         style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                     Tertusuk
                                                 </label>
                                                 <label for="nyeri-diiris">
                                                     <input type="radio" name="nyeri_kualitas"
                                                         id="nyeri_kualitas-diiris" value="Diiris"
                                                         style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                     Diiris
                                                 </label>
                                                 <label for="nyeri-mencengkram">
                                                     <input type="radio" name="nyeri_kualitas"
                                                         id="nyeri_kualitas-mencengkram" value="Mencengkram"
                                                         style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                                     Mencengkram
                                                 </label>
                                             </div>
                                             
                                         </div>
                                         <div class="col-6">
                                             <label for="nyeri_lokasi"
                                                 onclick="toggleInput('nyeri_lokasi')">Lokasi</label>
                                             <input type="text" name="nyeri_lokasi" id="nyeri_lokasi"
                                                 class="form-control mt-2 mb-2 ">
                                         </div>
                                         <div class="col-6">
                                             <label for="nyeri_skala"
                                                 onclick="toggleInput('nyeri_skala')">Skala</label>
                                             <input type="text" name="nyeri_skala" id="nyeri_skala"
                                                 class="form-control mt-2 mb-2 ">
                                             <p style="font-size: 13px; color: red">(*Berdasarkan Skala Nyeri)</p>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="form-group mb-4">
                                     <img src="<?php echo e(asset('assets/images/analog-scale.png')); ?>" alt=""
                                         height="auto" width="90%" style="margin-left: 30px">
                                     <div class="row mb-2" style="font-size: 18px">
                                         <div class="col">
                                             <input type="radio" name="nyeri_analog" id="nyeri_analog-0"
                                                 value="0"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 72px">0
                                             <input type="radio" name="nyeri_analog" id="nyeri_analog-2"
                                                 value="2"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 71px">2
                                             <input type="radio" name="nyeri_analog" id="nyeri_analog-4"
                                                 value="2"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 72px">4
                                             <input type="radio" name="nyeri_analog" id="nyeri_analog-6"
                                                 value="4"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 73px">6
                                             <input type="radio" name="nyeri_analog" id="nyeri_analog-8"
                                                 value="8"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 74px">8
                                             <input type="radio" name="nyeri_analog" id="nyeri_analog-10"
                                                 value="10"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 73px">10
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-6">
                                         <label for="nyeri_waktu" onclick="toggleInput('nyeri_waktu')">Waktu</label>
                                         <div class="col mt-3" style="font-size: 18px; margin-left: 35px">
                                             <input type="radio" name="nyeri_waktu" id="nyeri_waktu-intermetien"
                                                 value="Intermetien"
                                                 style="transform: scale(1.5); margin-right: 10px">Intermetien
                                             <input type="radio" name="nyeri_waktu"
                                                 id="nyeri_waktu-hilang_timbul" value="Hilang-timbul"
                                                 style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">Hilang
                                             Timbul
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="asesmen-resiko-jatuh">
                                 <h5 class="text-center mt-4" style="font-size: 20px; font-weight: bold"
                                     onclick="toggleStep(this)">Asesmen Resiko Jatuh</h5>
                                 <div class="form-group" style="font-size: 18px;">
                                     <label for="jatuh_sempoyong"
                                         onclick="toggleInput('jatuh_sempoyong')">Perhatikan cara berjalan pasien
                                         saat
                                         akan duduk dikursi apakah pasien tampak tidak seimbang / sempoyongan /
                                         libung
                                     </label>
                                     <div class="col text-center mb-2 mt-2">
                                         <input type="radio" name="jatuh_sempoyong" id="jatuh_sempoyong-ya"
                                             value="Ya" style="transform: scale(1.5); margin-right: 10px">
                                         Ya
                                         <input type="radio" name="jatuh_sempoyong" id="jatuh_sempoyong-tidak"
                                             value="Tidak"
                                             style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                             checked> Tidak
                                     </div>
                                 </div>
                                 <div class="form-group" style="font-size: 18px;">
                                     <label for="jatuh_pegangan" onclick="toggleInput('jatuh_pegangan')">Apakah
                                         pasien memegang pinggiran kursi / meja / benda lain sebagai penopang saat
                                         akan
                                         duduk</label>
                                     <div class="col text-center mb-2 mt-2">
                                         <input type="radio" name="jatuh_pegangan" id="jatuh_pegangan-ya"
                                             value="Ya" style="transform: scale(1.5); margin-right: 10px">
                                         Ya
                                         <input type="radio" name="jatuh_pegangan" id="jatuh_pegangan-tidak"
                                             value="Tidak"
                                             style="transform: scale(1.5); margin-right: 10px; margin-left: 30px"
                                             checked> Tidak
                                     </div>
                                 </div>
                                 <div class="form-group" style="font-size: 18px">
                                     <label for="jatuh_hasil_kajian"
                                         onclick="toggleInput('jatuh_hasil_kajian')">Hasil Kajian</label>
                                     <div class="col text-center mb-2 mt-2">
                                         <input type="radio" name="jatuh_hasil_kajian"
                                             id="jatuh_hasil_kajian-tidak_beresiko" value="tidak-beresiko"
                                             style="transform: scale(1.5); margin-right: 10px"> Tidak Beresiko
                                         <input type="radio" name="jatuh_hasil_kajian"
                                             id="jatuh_hasil_kajian-resiko_rendah" value="resiko-rendah"
                                             style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                         Resiko Rendah
                                         <input type="radio" name="jatuh_hasil_kajian"
                                             id="jatuh_hasil_kajian-resiko_tinggi" value="resiko-tinggi"
                                             style="transform: scale(1.5); margin-right: 10px; margin-left: 30px">
                                         Resiko Tinggi
                                     </div>
                                 </div>
                             </div>

                             <div class="masalah-keperawatan">
                                 <h5 class="text-center mt-4" style="font-size: 20px; font-weight: bold"
                                     onclick="toggleStep(this)">Analisa Masalah Keperawatan / Kebidanan</h5>
                                 <div class="form-group">
                                     <label for="ak_analisis_masalah_keperawatan"
                                         onclick="toggleInput('ak_analisis_masalah_keperawatan')">Analisa Masalah
                                         Keperawatan</label>
                                     <select name="ak_analisis_masalah_keperawatan"
                                         id="ak_analisis_masalah_keperawatan<?php echo e($item->id); ?>"
                                         class="form-control mt-2 mb-2 ">
                                         <option value="">Pilih Masalah</option>
                                         <option value="Bersihkan Jalan Nafas tidak Efektif">Bersihkan Jalan Nafas
                                             tidak Efektif</option>
                                         <option value="Perubahan Nutrisi Kurang / Lebih Cairan">Perubahan Nutrisi
                                             Kurang / Lebih Cairan</option>
                                         <option value="Keseimbangan Cairan dan Elektrolit">Keseimbangan Cairan
                                             dan
                                             Elektrolit</option>
                                         <option value="Gangguan Komunikasi Verbal">Gangguan Komunikasi Verbal
                                         </option>
                                         <option value="Pola Nafas tidak Efektif">Pola Nafas tidak Efektif
                                         </option>
                                         <option value="Resiko Infeksi / Sepsis">Resiko Infeksi / Sepsis</option>
                                         <option value="Gangguan Integritas Kulit / Jaringan">Gangguan Integritas
                                             Kulit / Jaringan</option>
                                         <option value="Gangguan Pola Tidur">Gangguan Pola Tidur</option>
                                         <option value="Nyeri">Nyeri</option>
                                         <option value="Intoleransi Aktivitas">Intoleransi Aktivitas</option>
                                         <option value="Konstipasi / Diare">Konstipasi / Diare</option>
                                         <option value="Cemas">Cemas</option>
                                         <option value="Hypertermi / Hipotermi">Hypertermi / Hipotermi</option>
                                         <option value="Lain - Lain">Lain - Lain</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                     <?php endif; ?>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <?php $__env->startPush('script'); ?>
     <script>
         document.addEventListener("DOMContentLoaded", function() {
             console.log("Script dijalankan...");

             // Ambil semua elemen asesmen dan kajian
             document.querySelectorAll("[id^='id_ttd_medis']").forEach(asesmenSelect => {
                 let id = asesmenSelect.id.replace("id_ttd_medis", ""); // Ambil ID pasien
                 let statusAsesmen = document.getElementById("statusAsesmen" + id);

                 if (asesmenSelect && statusAsesmen) {
                     asesmenSelect.addEventListener("change", function() {
                         if (this.value) {
                             statusAsesmen.classList.remove("border-warning", "text-warning");
                             statusAsesmen.classList.add("border-success", "text-success");
                             statusAsesmen.innerHTML =
                                 '<i class="fa-solid fa-check-circle"></i> Asesmen Terisi';
                         } else {
                             statusAsesmen.classList.remove("border-success", "text-success");
                             statusAsesmen.classList.add("border-warning", "text-warning");
                             statusAsesmen.innerHTML =
                                 '<i class="fa-solid fa-circle-exclamation"></i> Belum Melakukan Asesmen';
                         }
                     });
                 }
             });

             document.querySelectorAll("[id^='ak_analisis_masalah_keperawatan']").forEach(kajianSelect => {
                 let id = kajianSelect.id.replace("ak_analisis_masalah_keperawatan", ""); // Ambil ID pasien
                 let statusKajian = document.getElementById("statusKajian" + id);

                 if (kajianSelect && statusKajian) {
                     kajianSelect.addEventListener("change", function() {
                         if (this.value) {
                             statusKajian.classList.remove("border-danger", "text-danger");
                             statusKajian.classList.add("border-success", "text-success");
                             statusKajian.innerHTML =
                                 '<i class="fa-solid fa-check-circle"></i> Kajian Terisi';
                         } else {
                             statusKajian.classList.remove("border-success", "text-success");
                             statusKajian.classList.add("border-danger", "text-danger");
                             statusKajian.innerHTML =
                                 '<i class="fa-solid fa-circle-exclamation"></i> Belum Melakukan Kajian Awal';
                         }
                     });
                 }
             });

             // =================== HITUNG IMT ===================
             var bbNInput = document.getElementById("nutrisi_bb");
             var tbNInput = document.getElementById("nutrisi_tb");
             var imtNInput = document.getElementById("nutrisi_imt");

             if (bbNInput && tbNInput && imtNInput) {
                 bbNInput.addEventListener("input", hitungIMTBayi);
                 tbNInput.addEventListener("input", hitungIMTBayi);
             } else {
                 console.warn("Elemen input IMT tidak ditemukan.");
             }

             function hitungIMTBayi() {
                 var tb = parseFloat(tbNInput.value);
                 var bb = parseFloat(bbNInput.value);

                 if (!isNaN(tb) && !isNaN(bb) && tb > 0 && bb > 0) {
                     var imt = bb / ((tb / 100) * (tb / 100));
                     imtNInput.value = imt.toFixed(2);
                 } else {
                     imtNInput.value = "";
                 }
             }
         });
     </script>
 <?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/perawat/modalPerawat/ModalAnamnesis.blade.php ENDPATH**/ ?>