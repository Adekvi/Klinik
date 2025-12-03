<!-- Modal Resep BARU -->
<div class="modal fade" id="tambahObat<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Tambah Obat atau
                    Resep</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(url('obat/store/' . $item->id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="container" style="margin-top: -10px">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <h2><strong><?php echo e($item->booking->pasien->nama_pasien); ?></strong></h2>
                                    <hr style="margin-top: -5px">
                                    <p style="font-size: 14px; margin-top: -5px">
                                        <strong>Sengonbugel RT.01/01, Mayong, Jepara</strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                    <p style="margin-top: -5px">
                                        <strong>
                                            <?php echo e($item->booking->pasien->alamat_asal); ?>,
                                            <?php echo e($item->booking->pasien->tgllahir); ?>

                                            (<?php echo e(\Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age); ?> Tahun)
                                        </strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Tinggi Badan</label>
                                            <span>:</span>
                                            <p><?php echo e($item->isian->p_tb); ?> Cm</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Berat Badan</label>
                                            <span>:</span>
                                            <p><?php echo e($item->isian->p_bb); ?> Kg</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Kelamin</label>
                                            <span>:</span>
                                            <p>
                                                <?php if($item->booking->pasien->jekel === 'P' ?? 'Perempuan'): ?>
                                                    Perempuan
                                                <?php elseif($item->booking->pasien->jekel === 'L' ?? 'Laki-laki'): ?>
                                                    Laki-laki
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top: -20px">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Pasien</label>
                                            <span>:</span>
                                            <p><?php echo e($item->booking->pasien->jenis_pasien); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Poli</label>
                                            <span>:</span>
                                            <p><?php echo e($item->poli->namapoli); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No. NIK</label>
                                            <span>:</span>
                                            <p><?php echo e($item->booking->pasien->nik); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No. BPJS</label>
                                            <span>:</span>
                                            <p>
                                                <?php if(!empty($item->booking->pasien->bpjs)): ?>
                                                    <?php echo e($item->booking->pasien->bpjs); ?>

                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table mt-2 mb-2 table-striped table-bordered"
                                        style="overflow: auto; min-width: 150%;">
                                        <thead class="table-primary text-center text-nowrap">
                                            <tr>
                                                <th>NAMA OBAT</th>
                                                <th>ATURAN PENGGUNAAN</th>
                                                <th>JUMLAH OBAT</th>
                                                <th>HARGA/TABLET</th>
                                                <th>TOTAL HARGA</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            
                                            <td>
                                                <div class="obat-container" data-pasien-id="<?php echo e($item->id); ?>">
                                                    <?php
                                                        $semuaObat = json_decode($item->obat->obat_Ro, true) ?? [];
                                                        $aturanMinum =
                                                            json_decode($item->obat->obat_Ro_aturan, true) ?? [];
                                                        $anjuranMinum =
                                                            json_decode($item->obat->obat_Ro_anjuran, true) ?? [];
                                                        $jumlahObat =
                                                            json_decode($item->obat->obat_Ro_jumlah, true) ?? [];
                                                        $jenisObat =
                                                            json_decode($item->obat->obat_Ro_jenisObat, true) ?? [];

                                                        // Fallback nama obat
                                                        if (empty($semuaObat)) {
                                                            $semuaObat =
                                                                json_decode($item->obat->soap->soap_p, true) ?? [];
                                                        }

                                                        if (empty($jenisObat)) {
                                                            $jenisObat =
                                                                json_decode($item->obat->soap->soap_p_jenis, true) ??
                                                                [];
                                                        }

                                                        // Fallback aturan minum
                                                        if (empty($aturanMinum)) {
                                                            $aturanMinum =
                                                                json_decode($item->obat->soap->soap_p_aturan, true) ??
                                                                [];
                                                        }

                                                        // Fallback anjuran
                                                        if (empty($anjuranMinum)) {
                                                            $anjuranMinum =
                                                                json_decode($item->obat->soap->soap_p_anjuran, true) ??
                                                                [];
                                                        }

                                                        // Fallback jumlah
                                                        if (empty($jumlahObat)) {
                                                            $jumlahObat =
                                                                json_decode($item->obat->soap->soap_p_jumlah, true) ??
                                                                [];
                                                        }

                                                        // dd(
                                                        //     $item->obat->soap->soap_p,
                                                        //     $item->obat->soap->soap_p_jenis,
                                                        //     $item->obat->soap->soap_p_aturan,
                                                        //     $item->obat->soap->soap_p_anjuran,
                                                        //     $item->obat->soap->soap_p_jumlah,
                                                        // );

                                                        $olehNgombe = $anjuranMinum;

                                                        $hargaJualData = $reseps->keyBy('nama_obat');
                                                    ?>

                                                    <?php if(!empty($semuaObat)): ?>
                                                        <?php $__currentLoopData = $semuaObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $namaObat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                // Pastikan $namaObat string
                                                                $namaObat = is_array($namaObat)
                                                                    ? implode(', ', $namaObat)
                                                                    : trim($namaObat);

                                                                // Ambil anjuran dari obat_Ro_anjuran
                                                                $anjuran = $olehNgombe[$index] ?? 'AC';

                                                                // Ambil harga
                                                                $hargaPokok = $hargaJualData->contains(
                                                                    'nama_obat',
                                                                    $namaObat,
                                                                )
                                                                    ? $hargaJualData->get($namaObat)->harga_jual ?? 0
                                                                    : 0;
                                                            ?>

                                                            <div class="form-group obat-row">
                                                                <div class="nama-obat">
                                                                    <div class="input-row">
                                                                        <div class="nama-obat-container">
                                                                            <input type="text"
                                                                                name="obat_Ro[<?php echo e($index); ?>][namaObatUpdate]"
                                                                                id="obat_Ro_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                                data-pasien-id="<?php echo e($item->id); ?>"
                                                                                data-index="<?php echo e($index); ?>"
                                                                                value="<?php echo e($namaObat); ?>"
                                                                                class="form-control obat-input"
                                                                                placeholder="Cari Obat..."
                                                                                aria-autocomplete="list"
                                                                                aria-controls="results-<?php echo e($item->id); ?>-<?php echo e($index); ?>" />

                                                                            <button type="button"
                                                                                class="btn btn-danger btn-hapus"
                                                                                data-pasien-id="<?php echo e($item->id); ?>"
                                                                                data-index="<?php echo e($index); ?>"
                                                                                data-nama-obat="<?php echo e($namaObat); ?>"
                                                                                data-harga="<?php echo e($hargaPokok); ?>"
                                                                                aria-label="Hapus obat">
                                                                                <i class="fa-solid fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="search-results border-primary"
                                                                            id="results-<?php echo e($item->id); ?>-<?php echo e($index); ?>"
                                                                            role="listbox"></div>
                                                                    </div>

                                                                    <!-- Hidden input untuk anjuran (AC/PC/DC) -->
                                                                    <input type="hidden"
                                                                        name="obat_Ro[<?php echo e($index); ?>][anjuran]"
                                                                        id="anjuran_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        value="<?php echo e($anjuran); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <p class="no-data">Tidak ada obat</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- ATURAN MINUM -->
                                            <td>
                                                <div class="minum-container">
                                                    <?php if(!empty($semuaObat)): ?>
                                                        <?php $__currentLoopData = $semuaObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $namaObat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $aturanAwal = $aturanMinum[$index] ?? null; // ex: "2x1/2"
                                                                $anjuranAwal = $olehNgombe[$index] ?? '-';

                                                                // CARI aturan di $aturanList yang cocok dengan awalan
                                                                $matchedAturan = null;
                                                                $isCustom = true;

                                                                foreach ($aturanList as $opt) {
                                                                    if ($opt === $aturanAwal) {
                                                                        $matchedAturan = $opt;
                                                                        $isCustom = false;
                                                                        break;
                                                                    }
                                                                    if (str_starts_with($opt, $aturanAwal)) {
                                                                        $matchedAturan = $opt;
                                                                        $isCustom = false;
                                                                        break;
                                                                    }
                                                                }

                                                                // Jika tidak ketemu, gunakan custom
                                                                if ($isCustom && $aturanAwal) {
                                                                    $matchedAturan = $aturanAwal;
                                                                }
                                                            ?>

                                                            <div class="form-group minum-row">
                                                                <div class="input-group d-flex align-items-center">

                                                                    <!-- Dropdown Aturan -->
                                                                    <select name="obat_Ro[<?php echo e($index); ?>][aturan]"
                                                                        id="sehari_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        class="form-control sehari-select"
                                                                        onchange="toggleCustomAturan(this, '<?php echo e($item->id); ?>_<?php echo e($index); ?>')">
                                                                        <?php $__currentLoopData = $aturanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($opt); ?>"
                                                                                <?php echo e($matchedAturan === $opt ? 'selected' : ''); ?>>
                                                                                <?php echo e($opt); ?>

                                                                            </option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="custom"
                                                                            <?php echo e($isCustom ? 'selected' : ''); ?>>
                                                                            Lainnya
                                                                        </option>
                                                                    </select>

                                                                    <!-- Input Custom -->
                                                                    <input type="text"
                                                                        name="obat_Ro[<?php echo e($index); ?>][aturan_custom]"
                                                                        id="custom_sehari_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        class="form-control custom-input <?php echo e($isCustom ? '' : 'd-none'); ?>"
                                                                        placeholder="ex: 3x1 KAPSUL"
                                                                        value="<?php echo e($isCustom ? $aturanAwal : ''); ?>"
                                                                        style="<?php echo e($isCustom ? '' : 'display:none'); ?>">

                                                                    <span class="separator">-</span>

                                                                    <!-- Anjuran -->
                                                                    <select
                                                                        name="obat_Ro[<?php echo e($index); ?>][anjuran]"
                                                                        id="anjuran_select_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        class="form-control anjuran-select">
                                                                        <?php $__currentLoopData = $anjuranList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($anj->kode_anjuran); ?>"
                                                                                <?php echo e($anjuranAwal === $anj->kode_anjuran ? 'selected' : ''); ?>>
                                                                                <?php echo e($anj->kode_anjuran); ?>

                                                                            </option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="custom"
                                                                            <?php echo e($isCustom ? 'selected' : ''); ?>>
                                                                            Lainnya
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <p class="no-data">Kosong</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- JUMLAH OBAT -->
                                            <td>
                                                <div class="jumlah-container" data-pasien-id="<?php echo e($item->id); ?>">
                                                    <?php
                                                        $jumlahObat =
                                                            json_decode($item->obat->obat_Ro_jumlah, true) ?? [];
                                                        $jenisObat =
                                                            json_decode($item->obat->obat_Ro_jenisObat, true) ?? [];

                                                        if (empty($jumlahObat)) {
                                                            $jumlahObat =
                                                                json_decode($item->obat->soap->soap_p_jumlah, true) ??
                                                                [];
                                                        }

                                                        if (empty($jenisObat)) {
                                                            $jenisObat =
                                                                json_decode($item->obat->soap->soap_p_jenis, true) ??
                                                                [];
                                                        }
                                                    ?>

                                                    <?php if(!empty($semuaObat)): ?>
                                                        <?php $__currentLoopData = $semuaObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $namaObat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $jumlah = $jumlahObat[$index] ?? 0;
                                                                $jenis = $jenisObat[$index] ?? '-';

                                                                // Ambil harga dari $hargaJualData (sudah ada di atas)
                                                                $hargaSatuan = $hargaJualData->contains(
                                                                    'nama_obat',
                                                                    $namaObat,
                                                                )
                                                                    ? $hargaJualData->get($namaObat)->harga_jual ?? 0
                                                                    : 0;

                                                                $totalHarga = $jumlah * $hargaSatuan;
                                                            ?>

                                                            <div class="form-group jumlah-row">
                                                                <div class="jumlah-group d-flex align-items-center">

                                                                    <!-- Jenis Obat (Dropdown dari DB) -->
                                                                    <select
                                                                        name="obat_Ro[<?php echo e($index); ?>][jenisObat]"
                                                                        id="jenisObat_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        class="form-control jenis-obat-select me-2"
                                                                        style="width: 100px;">
                                                                        <?php $__currentLoopData = $jenisObatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($j); ?>"
                                                                                <?php echo e($jenis === $j ? 'selected' : ''); ?>>
                                                                                <?php echo e($j); ?>

                                                                            </option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>

                                                                    <span class="separator mx-1">:</span>

                                                                    <!-- Input Jumlah -->
                                                                    <input type="number"
                                                                        name="obat_Ro[<?php echo e($index); ?>][jumlah]"
                                                                        id="jumlah_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        class="form-control jumlah-input me-2"
                                                                        value="<?php echo e($jumlah); ?>" min="0"
                                                                        data-harga="<?php echo e($hargaSatuan); ?>"
                                                                        data-index="<?php echo e($index); ?>"
                                                                        data-pasien-id="<?php echo e($item->id); ?>"
                                                                        onchange="hitungTotalHarga(this)"
                                                                        style="width: 70px;">
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <p class="no-data">Kosong</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- HARGA/TABLET -->
                                            <td>
                                                <div class="harga-tablet-container"
                                                    data-pasien-id="<?php echo e($item->id); ?>" id="hargaTablet">
                                                    <?php
                                                        $hargaJualData = $reseps->keyBy('nama_obat');

                                                        $regoObat = json_decode(
                                                            $item->obat->soap->soap_p ?? '[]',
                                                            true,
                                                        );

                                                        // Kalau ingin aman, pastikan array
                                                        $regoDewedewe = is_array($regoObat) ? $regoObat : [];
                                                    ?>
                                                    <?php if(is_array($regoDewedewe) && count($regoDewedewe) > 0): ?>
                                                        <?php $__currentLoopData = $regoDewedewe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $namaObat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $hargaJual =
                                                                    $hargaJualData->get($namaObat)->harga_jual ?? '0';
                                                            ?>
                                                            <div class="form-group harga-tablet-row">
                                                                <div class="input-group">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"
                                                                            style="background: rgb(255, 255, 255)">
                                                                            <b>Rp.</b>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text"
                                                                        name="obat_Ro[<?php echo e($index); ?>][hargaTablet]"
                                                                        id="hargaTablet_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        class="form-control harga-tablet-input"
                                                                        data-pasien-id="<?php echo e($item->id); ?>"
                                                                        data-index="<?php echo e($index); ?>"
                                                                        data-nama-obat="<?php echo e($namaObat); ?>"
                                                                        value="<?php echo e(number_format($hargaJual, 0, ',', '.')); ?>"
                                                                        readonly aria-label="Harga per tablet">
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <p class="no-data">Tidak ada obat yang tersedia</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- HARGA TOTAL -->
                                            <td>
                                                <div class="harga-total-container"
                                                    data-pasien-id="<?php echo e($item->id); ?>">
                                                    <?php
                                                        $soap = $item->obat->soap ?? null;

                                                        $semuaObat = json_decode($soap->soap_p ?? '[]', true);
                                                        $allJumlah = json_decode($soap->soap_p_jumlah ?? '[]', true);
                                                    ?>
                                                    
                                                    <?php if(is_array($semuaObat) && count($semuaObat) > 0): ?>
                                                        <?php $__currentLoopData = $semuaObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $namaObat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $hargaJual =
                                                                    $hargaJualData->get($namaObat)->harga_jual ?? 0;
                                                                $jumlahObat = $allJumlah[$index] ?? 0;
                                                                $totalHarga = $hargaJual * $jumlahObat;
                                                            ?>
                                                            <div class="form-group harga-total-row">
                                                                <div class="input-group">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"
                                                                            style="background: rgb(255, 255, 255)">
                                                                            <b>Rp.</b>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text"
                                                                        name="obat_Ro[<?php echo e($index); ?>][hargaTotal]"
                                                                        id="TotalHarga_<?php echo e($item->id); ?>_<?php echo e($index); ?>"
                                                                        class="form-control harga-total-input"
                                                                        data-pasien-id="<?php echo e($item->id); ?>"
                                                                        data-index="<?php echo e($index); ?>"
                                                                        data-nama-obat="<?php echo e($namaObat); ?>"
                                                                        value="<?php echo e(number_format($totalHarga, 0, ',', '.')); ?>"
                                                                        readonly aria-label="Harga total">
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <p class="no-data">Tidak ada obat yang tersedia</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="racikan">Obat Racikan</label>
                                    <textarea name="obat_racikan" id="obat_racikan" class="form-control obat-racikan mt-2" rows="3" readonly><?php echo e($item->obat->soap->ObatRacikan ?? 'Tidak ada obat racikan'); ?></textarea>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mt-3">
                                    <label for="tambahan">Aturan Tambahan</label>
                                    <textarea name="aturan_tambahan" id="aturanTambah" class="form-control mt-2" id="aturan_tambahan" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3" style="justify-content: end">
                                <div class="form-group">
                                    <label for="totalSemuaHarga"><strong>TOTAL HARGA KESELURUHAN</strong></label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2"
                                                style="background: rgb(255, 255, 255)">
                                                <b>Rp.</b>
                                            </span>
                                        </div>
                                        <input type="text" name="totalSemuaHarga"
                                            data-pasien-id="<?php echo e($item->id); ?>"
                                            id="totalSemuaHarga_<?php echo e($item->id); ?>"
                                            class="form-control mt-2 text-end total-harga" readonly
                                            placeholder="Total Semua">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success" onclick="printCard()">Cetak</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('style'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Container utama */
        .obat-container,
        .minum-container,
        .jumlah-container,
        .harga-tablet-container,
        .harga-total-container {
            padding: 5px;
        }

        /* Form group untuk setiap baris */
        .form-group.obat-row,
        .form-group.minum-row,
        .form-group.jumlah-row,
        .form-group.harga-tablet-row,
        .form-group.harga-total-row {
            display: flex;
            align-items: center;
        }

        /* Jarak ke bawah hanya jika ada lebih dari 1 data */
        .obat-container:has(.obat-row:nth-child(n+2)) .obat-row:not(:last-child),
        .minum-container:has(.minum-row:nth-child(n+2)) .minum-row:not(:last-child),
        .jumlah-container:has(.jumlah-row:nth-child(n+2)) .jumlah-row:not(:last-child),
        .harga-tablet-container:has(.harga-tablet-row:nth-child(n+2)) .harga-tablet-row:not(:last-child),
        .harga-total-container:has(.harga-total-row:nth-child(n+2)) .harga-total-row:not(:last-child) {
            margin-bottom: 12px;
        }

        /* Container nama obat, select, dan tombol */
        .nama-obat {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            width: 50%;
        }

        /* Input row untuk input dan search results */
        .input-row {
            position: relative;
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-height: 40px;
        }

        /* Container untuk input dan tombol hapus */
        .nama-obat-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Container untuk jumlah obat */
        .jumlah-group {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        /* Styling input obat */
        .obat-input {
            width: 200px;
            font-size: 14px;
            border-radius: 4px;
            transition: border-color 0.2s ease;
            padding: 6px 12px;
        }

        .obat-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        /* Styling select anjuran */
        .anjuran-select {
            width: 50px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        /* Styling select aturan minum */
        .sehari-select {
            width: 150px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        .aturan-select {
            width: 100px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        /* Styling select dan input jumlah */
        .jenis-obat-select {
            width: 100px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        .jumlah-input {
            width: 100px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
            text-align: end;
        }

        .separator {
            font-size: 14px;
            color: #666;
            flex: 0 0 auto;
            /* width: 10px; */
            text-align: center;
        }

        /* Styling input harga */
        .harga-tablet-input,
        .harga-total-input {
            width: 120px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
            text-align: end;
        }

        .input-group-text {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px 0 0 4px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-right: none;
        }

        /* Styling tombol hapus */
        .btn-hapus {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            line-height: 1;
        }

        /* Styling search results */
        .search-results {
            width: 100%;
            min-height: 20px;
            max-height: 200px;
            overflow-y: auto;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            border: 1px solid #007bff;
            background: #ffffff;
            color: #333;
            position: static;
            margin-top: 4px;
            display: none;
            transition: opacity 0.2s ease;
            opacity: 0;
            z-index: 1000;
        }

        .search-results.show {
            display: block !important;
            opacity: 1 !important;
            overflow-x: auto;
        }

        .search-results .result-item {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s ease;
            color: #333;
            background: #ffffff;
        }

        .search-results .result-item:hover,
        .search-results .result-item.selected {
            background-color: #e9f5ff;
        }

        .search-results .result-item.loading {
            color: #888;
            font-style: italic;
            cursor: default;
        }

        .search-results .result-item.error {
            color: #d9534f;
            font-style: italic;
            cursor: default;
        }

        /* Styling untuk pesan "Tidak ada obat" atau "Kosong" */
        .no-data {
            margin: 12px 0;
            color: #666;
            font-style: italic;
        }

        /* Konsistensi untuk elemen lain di halaman */
        .info-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 24px;
            gap: 12px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1 1 200px;
        }

        .info-item label {
            font-weight: bold;
            margin: 0;
        }

        .info-item p {
            margin: 0;
        }

        /* Styling tambahan untuk input kustom */
        .input-group .custom-input {
            width: 60px;
            font-size: 14px;
            border-radius: 4px;
            padding: 6px;
        }

        /* Pastikan input-group tetap berdampingan */
        .input-group {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .harga-tablet-input,
        .harga-total-input,
        .obat-racika,
        .total-harga {
            pointer-events: none;
        }

        /* Responsivitas */
        @media (max-width: 768px) {

            .nama-obat,
            .input-group,
            .input-row,
            .nama-obat-container,
            .jumlah-group {
                flex-direction: column;
                gap: 8px;
            }

            .obat-input,
            .search-results,
            .anjuran-select,
            .sehari-select,
            .aturan-select,
            .custom-input,
            .jenis-obat-select,
            .jumlah-input,
            .harga-tablet-input,
            .harga-total-input {
                width: 100% !important;
            }

            .btn-hapus {
                width: 100%;
                margin: 8px 0 0 0;
            }

            .separator {
                display: none;
            }

            .form-group.obat-row,
            .form-group.minum-row,
            .form-group.jumlah-row,
            .form-group.harga-tablet-row,
            .form-group.harga-total-row {
                margin-bottom: 8px;
            }

            .info-container {
                margin-top: 16px;
                gap: 8px;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        // CARI OBAT DAN GANTI
        $(document).ready(function() {
            // Fungsi debounce untuk membatasi frekuensi AJAX
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            console.log('jQuery initialized. Found .obat-input:', $('.obat-input').length);

            $('.obat-input').each(function() {
                const input = $(this);
                let previousValue = input.val();
                const inputId = input.attr('id');
                console.log('Binding input:', inputId);

                // Kosongkan input saat fokus dan kembalikan nilai sebelumnya saat blur
                input.on('focus', function() {
                    previousValue = input.val();
                    input.val('');
                    console.log('Focus on input:', inputId);
                }).on('blur', function() {
                    if (input.val().trim() === '') {
                        input.val(previousValue);
                    }
                    console.log('Blur on input:', inputId);
                });

                // Pencarian dengan debounce
                input.on('input', debounce(function() {
                    const match = input.attr('id').match(/_(\d+)_(\d+)/);
                    if (!match) {
                        console.error('Invalid input ID format:', inputId);
                        return;
                    }
                    const [pasienId, index] = match.slice(1);
                    const query = input.val().trim();

                    // Jangan panggil AJAX jika query adalah 'Cari Obat' atau kosong
                    if (query === 'Cari Obat' || query.length <= 1) {
                        $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0));
                        calculateTotalHarga(pasienId, index);
                        resultsContainer.empty().removeClass('show');
                        return;
                    }

                    const resultsContainer = $(`#results-${pasienId}-${index}`);
                    if (!resultsContainer.length) {
                        console.error('Results container not found for ID:',
                            `results-${pasienId}-${index}`);
                        return;
                    }

                    console.log('Searching for query:', query, 'Pasien ID:', pasienId, 'Index:',
                        index);
                    resultsContainer.empty().removeClass('show');

                    resultsContainer.append('<div class="result-item loading">Memuat...</div>')
                        .addClass('show');
                    $.ajax({
                        url: '/cariObat-ganti',
                        method: 'GET',
                        data: {
                            term: query
                        },
                        success: function(data) {
                            console.log('AJAX /cariObat-ganti success. Data:',
                                data);
                            resultsContainer.empty();
                            if (data && Array.isArray(data) && data.length) {
                                $.each(data, function(i, item) {
                                    const itemText = item.text || item
                                        .label || item.name || 'Unknown';
                                    const itemId = item.id || i;
                                    const itemHarga = parseFloat(item
                                        .harga_jual) || 0;
                                    resultsContainer.append(
                                        `<div class="result-item" data-id="${itemId}" data-harga="${itemHarga}" role="option">${itemText}</div>`
                                    );
                                });
                                resultsContainer.addClass('show');
                            } else {
                                resultsContainer.append(
                                    '<div class="result-item">Tidak ada hasil</div>'
                                ).addClass('show');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX /cariObat-ganti error:', textStatus,
                                errorThrown);
                            resultsContainer.empty().append(
                                '<div class="result-item error">Terjadi kesalahan saat mencari</div>'
                            ).addClass('show');
                        }
                    });
                }, 300));
            });

            // Tidak perlu perubahan besar, tetapi pastikan bagian ini tetap berfungsi
            $(document).on('click', '.result-item', function() {
                const itemName = $(this).text();
                const resultsContainer = $(this).parent();
                const inputId = resultsContainer.attr('id').replace('results-', 'obat_Ro_');
                const input = $(`#${inputId}`);

                console.log('Selected item:', itemName, 'for input:', inputId);
                input.val(itemName);
                resultsContainer.removeClass('show'); // Pastikan dropdown disembunyikan setelah memilih
            });

            // Sembunyikan hasil saat klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.input-row').length) {
                    console.log('Click outside, hiding search results');
                    $('.search-results').removeClass('show');
                }
            });

            // Navigasi keyboard untuk hasil pencarian
            $('.obat-input').on('keydown', function(e) {
                const inputId = $(this).attr('id');
                const resultsContainer = $(`#results-${inputId.replace('obat_Ro_', '')}`);
                const items = resultsContainer.find('.result-item');
                let selectedIndex = items.filter('.selected').index();

                console.log('Keydown:', e.key, 'on input:', inputId);
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = selectedIndex === -1 ? items.length - 1 : (selectedIndex - 1 + items
                        .length) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'Enter' && items.hasClass('selected')) {
                    e.preventDefault();
                    items.filter('.selected').trigger('click');
                }
            });
        });

        // PERUBAHAN HARGA TABLET MENYESUAIKAN PERUBAHAN NAMA OBAT
        $(document).ready(function() {
            // Fungsi debounce
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Fungsi format angka
            function formatAngka(angka) {
                return parseInt(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function unformatAngka(angka) {
                return parseInt(angka.replace(/\./g, '')) || 0;
            }

            // Fungsi untuk menghitung total harga
            function calculateTotalHarga(pasienId, index) {
                const jumlahInput = $(`#jumlah_${pasienId}_${index}`);
                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                const totalHargaInput = $(`#TotalHarga_${pasienId}_${index}`);

                if (!jumlahInput.length || !hargaTabletInput.length || !totalHargaInput.length) {
                    console.warn(`Input missing for Pasien ${pasienId}, Index ${index}`);
                    return;
                }

                const jumlahObat = parseFloat(jumlahInput.val()) || 0;
                const hargaTablet = unformatAngka(hargaTabletInput.val());
                const totalHarga = jumlahObat * hargaTablet;

                totalHargaInput.val(formatAngka(totalHarga));
                updateTotalSemua(pasienId);
            }

            function updateTotalSemua(pasienId) {
                let totalSemua = 0;
                const hargaTotalInputs = $(`.harga-total-input[data-pasien-id="${pasienId}"]`);
                hargaTotalInputs.each(function() {
                    const harga = unformatAngka($(this).val());
                    totalSemua += harga;
                });

                const totalSemuaInput = $(`#totalSemuaHarga_${pasienId}`);
                if (totalSemuaInput.length) {
                    totalSemuaInput.val(formatAngka(totalSemua));
                }
            }

            function updateHargaObat(pasienId, index, obatId, obatName) {
                if (obatName === 'Cari Obat' || !obatName) {
                    console.log('Skipping updateHargaObat for Cari Obat');
                    const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                    if (hargaTabletInput.length) {
                        hargaTabletInput.val(formatAngka(0));
                        hargaTabletInput.attr('data-nama-obat', '');
                        hargaTabletInput.trigger('change');
                    }
                    calculateTotalHarga(pasienId, index);
                    return;
                }

                console.log(`Updating harga for: ${obatName} (ID: ${obatId})`);
                $.ajax({
                    url: '/gantiObat-RegoGanti',
                    type: 'GET',
                    data: {
                        id_obat: obatId,
                        nama_obat: obatName
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            const hargaJual = parseFloat(response.data.harga_jual) || 0;
                            const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                            if (hargaTabletInput.length) {
                                hargaTabletInput.val(formatAngka(hargaJual));
                                hargaTabletInput.attr('data-nama-obat', obatName);
                                hargaTabletInput.trigger('change');
                                calculateTotalHarga(pasienId, index);
                            }
                        } else {
                            $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0)).trigger(
                                'change');
                            calculateTotalHarga(pasienId, index);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX /gantiObat-RegoGanti error:', textStatus, errorThrown);
                        $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0)).trigger('change');
                        calculateTotalHarga(pasienId, index);
                    }
                });
            }

            $('.obat-input').each(function() {
                const input = $(this);
                let previousValue = input.val() || 'Cari Obat';
                const inputId = input.attr('id');

                input.on('focus', function() {
                    previousValue = input.val();
                    if (previousValue === 'Cari Obat') {
                        input.val('');
                    }
                    console.log('Focus on input:', inputId, 'Previous:', previousValue);
                }).on('blur', function() {
                    if (input.val().trim() === '') {
                        input.val('Cari Obat');
                        previousValue = 'Cari Obat';
                        input.trigger('change');

                        const match = inputId.match(/_(\d+)_(\d+)/);
                        if (match) {
                            const [pasienId, index] = match.slice(1);
                            const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                            if (hargaTabletInput.length) {
                                hargaTabletInput.val(formatAngka(0));
                                hargaTabletInput.attr('data-nama-obat', '');
                                hargaTabletInput.trigger('change');
                            }
                            calculateTotalHarga(pasienId, index);
                        }
                    }
                    console.log('Blur on input:', inputId, 'Value:', input.val());
                });

                input.on('input', debounce(function() {
                    const match = input.attr('id').match(/_(\d+)_(\d+)/);
                    if (!match) {
                        console.error('Invalid input ID format:', inputId);
                        return;
                    }
                    const [pasienId, index] = match.slice(1);
                    const query = input.val().trim();

                    if (query === 'Cari Obat' || query.length <= 1) {
                        const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                        if (hargaTabletInput.length) {
                            hargaTabletInput.val(formatAngka(0));
                            hargaTabletInput.attr('data-nama-obat', '');
                            hargaTabletInput.trigger('change');
                        }
                        calculateTotalHarga(pasienId, index);
                        $(`#results-${pasienId}-${index}`).empty().removeClass('show');
                        return;
                    }

                    const resultsContainer = $(`#results-${pasienId}-${index}`);
                    if (!resultsContainer.length) {
                        console.error('Results container not found for ID:',
                            `results-${pasienId}-${index}`);
                        return;
                    }

                    resultsContainer.empty().removeClass('show');
                    resultsContainer.append('<div class="result-item loading">Memuat...</div>')
                        .addClass('show');
                    $.ajax({
                        url: '/cariObat-ganti',
                        method: 'GET',
                        data: {
                            term: query
                        },
                        success: function(data) {
                            resultsContainer.empty();
                            if (data && Array.isArray(data) && data.length) {
                                $.each(data, function(i, item) {
                                    const itemText = item.text || item
                                        .label || item.name || 'Unknown';
                                    const itemId = item.id || i;
                                    const itemHarga = parseFloat(item
                                        .harga_jual) || 0;
                                    resultsContainer.append(
                                        `<div class="result-item" data-id="${itemId}" data-harga="${itemHarga}" role="option">${itemText}</div>`
                                    );
                                });
                                resultsContainer.addClass('show');
                            } else {
                                resultsContainer.append(
                                    '<div class="result-item">Tidak ada hasil</div>'
                                ).addClass('show');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX /cariObat-ganti error:', textStatus,
                                errorThrown);
                            resultsContainer.empty().append(
                                '<div class="result-item error">Terjadi kesalahan saat mencari</div>'
                            ).addClass('show');
                        }
                    });
                }, 300));
            });

            $(document).on('click', '.result-item', function() {
                const itemText = $(this).text();
                const itemId = $(this).data('id');
                const itemHarga = parseFloat($(this).data('harga')) || 0;
                const resultsContainer = $(this).parent();
                const containerId = resultsContainer.attr('id');
                const [pasienId, index] = containerId.match(/-(\d+)-(\d+)/).slice(1);

                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                if (inputObat.length) {
                    inputObat.val(itemText);
                    inputObat.attr('data-nama-obat', itemText);
                    inputObat.data('previous-value', itemText);
                    inputObat.trigger('change');
                }

                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                if (hargaTabletInput.length) {
                    hargaTabletInput.val(formatAngka(itemHarga));
                    hargaTabletInput.attr('data-nama-obat', itemText);
                    hargaTabletInput.trigger('change');
                }

                calculateTotalHarga(pasienId, index);
                resultsContainer.removeClass('show');
                updateHargaObat(pasienId, index, itemId, itemText);
            });

            $(document).on('click', '.btn-hapus', function() {
                const pasienId = $(this).data('pasien-id');
                const index = $(this).data('index');

                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                if (inputObat.length) {
                    inputObat.val('Cari Obat');
                    inputObat.attr('data-nama-obat', '');
                    inputObat.data('previous-value', 'Cari Obat');
                    inputObat.trigger('change');
                }

                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                if (hargaTabletInput.length) {
                    hargaTabletInput.val(formatAngka(0));
                    hargaTabletInput.attr('data-nama-obat', '');
                    hargaTabletInput.trigger('change');
                }

                const jumlahInput = $(`#jumlah_${pasienId}_${index}`);
                if (jumlahInput.length) {
                    jumlahInput.val('0');
                    jumlahInput.trigger('change');
                }

                const totalHargaInput = $(`#TotalHarga_${pasienId}_${index}`);
                if (totalHargaInput.length) {
                    totalHargaInput.val(formatAngka(0));
                    totalHargaInput.trigger('change');
                }

                $(`#anjuran_${pasienId}_${index}`).val('AC').trigger('change');
                $(`#aturan_${pasienId}_${index}`).val('Sebelum Makan').trigger('change');
                $(`#sehari_${pasienId}_${index}`).val('1x1/5').trigger('change');
                $(`#jenisObat_${pasienId}_${index}`).val('Tablet').trigger('change');

                calculateTotalHarga(pasienId, index);

                console.log('Reset values:', {
                    obat: inputObat.val(),
                    hargaTablet: hargaTabletInput.val(),
                    jumlah: jumlahInput.val(),
                    totalHarga: totalHargaInput.val()
                });
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.input-row').length) {
                    $('.search-results').removeClass('show');
                }
            });

            $('.obat-input').on('keydown', function(e) {
                const inputId = $(this).attr('id');
                const resultsContainer = $(`#results-${inputId.replace('obat_Ro_', '')}`);
                const items = resultsContainer.find('.result-item');
                let selectedIndex = items.filter('.selected').index();

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = selectedIndex === -1 ? items.length - 1 : (selectedIndex - 1 + items
                        .length) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'Enter' && items.hasClass('selected')) {
                    e.preventDefault();
                    items.filter('.selected').trigger('click');
                }
            });

            $('form').on('submit', function(e) {
                $('.obat-input').each(function() {
                    const input = $(this);
                    if (input.val() === 'Cari Obat') {
                        input.val('');
                    }
                });
            });

            $('.obat-container').each(function() {
                const pasienId = $(this).data('pasien-id');
                $(`.harga-total-input[data-pasien-id="${pasienId}"]`).each(function(index) {
                    calculateTotalHarga(pasienId, index);
                });
                updateTotalSemua(pasienId);
            });
        });

        // JUMLAH OBAT
        document.addEventListener("DOMContentLoaded", function() {
            function updateTotalJumlah(pasienId) {
                const jumlahObatInputs = document.querySelectorAll(`.jumlahObatt[data-pasien-id="${pasienId}"]`);
                let totalJumlah = 0;

                // Loop untuk menjumlahkan semua nilai
                jumlahObatInputs.forEach(input => {
                    const jumlah = parseFloat(input.value) || 0; // Ambil nilai dan parse
                    totalJumlah += jumlah; // Tambahkan ke total
                });

                // Update total jumlah di input dengan class 'jumlahTotal' untuk pasien yang sama
                const totalInput = document.querySelector(`.jumlah[data-pasien-id="${pasienId}"] .jumlahTotal`);
                if (totalInput) {
                    totalInput.value = totalJumlah; // Set nilai total
                }

                console.log('Total Jumlah untuk pasien', pasienId, ':', totalJumlah); // Debugging
            }

            // Tambahkan event listener pada input jumlah
            const jumlahObatInputs = document.querySelectorAll('.jumlahObatt');
            jumlahObatInputs.forEach(input => {
                const pasienId = input.dataset.pasienId; // Ambil ID pasien dari data attribute
                input.addEventListener('input', () => updateTotalJumlah(
                    pasienId)); // Panggil fungsi saat input berubah
            });

            // Hitung total saat halaman pertama kali dimuat
            jumlahObatInputs.forEach(input => {
                const pasienId = input.dataset.pasienId; // Ambil ID pasien dari data attribute
                updateTotalJumlah(pasienId);
            });
        });

        // TOTAL SEMUA
        $(document).ready(function() {
            // Fungsi debounce untuk membatasi frekuensi AJAX
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Fungsi untuk format angka dengan pemisah titik (misalnya, 1000 -> 1.000)
            function formatAngka(angka) {
                return parseInt(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Fungsi untuk menghapus format angka (menghapus titik) agar bisa diubah ke angka
            function unformatAngka(angka) {
                return parseInt(angka.replace(/\./g, '')) || 0;
            }

            // Fungsi untuk menghitung total harga per obat
            function calculateTotalHarga(pasienId, index) {
                const jumlahInput = $(`#jumlah_${pasienId}_${index}`);
                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                const totalHargaInput = $(`#TotalHarga_${pasienId}_${index}`);

                const jumlahObat = parseFloat(jumlahInput.val()) || 0;
                const hargaTablet = unformatAngka(hargaTabletInput.val());
                const totalHarga = jumlahObat * hargaTablet;

                totalHargaInput.val(formatAngka(totalHarga));
                console.log(`Calculated total: Pasien ${pasienId}, Index ${index}, Total ${totalHarga}`);

                // Update total harga keseluruhan setelah menghitung total per obat
                updateTotalSemua(pasienId);
            }

            // Fungsi untuk menghitung total harga keseluruhan untuk pasien tertentu
            function updateTotalSemua(pasienId) {
                let totalSemua = 0;

                // Pilih semua input harga_total untuk pasien yang sesuai
                const hargaTotalInputs = $(`.harga-total-input[data-pasien-id="${pasienId}"]`);
                hargaTotalInputs.each(function() {
                    const harga = unformatAngka($(this).val());
                    totalSemua += harga;
                });

                // Update input totalSemuaHarga dengan format angka
                const totalSemuaInput = $(`#totalSemuaHarga_${pasienId}`);
                if (totalSemuaInput.length) {
                    totalSemuaInput.val(formatAngka(totalSemua));
                    console.log(`Updated total semua: Pasien ${pasienId}, Total ${totalSemua}`);
                } else {
                    console.warn(`Total semua input not found for Pasien ${pasienId}`);
                }
            }

            // Fungsi untuk update harga berdasarkan obat yang dipilih
            function updateHargaObat(pasienId, index, obatId, obatName) {
                console.log(`Updating harga for: ${obatName} (ID: ${obatId})`);
                $.ajax({
                    url: '/gantiObat-RegoGanti',
                    type: 'GET',
                    data: {
                        id_obat: obatId,
                        nama_obat: obatName
                    },
                    success: function(response) {
                        console.log('AJAX /gantiObat-RegoGanti success:', response);
                        if (response.success && response.data) {
                            const hargaJual = parseFloat(response.data.harga_jual) || 0;
                            const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                            hargaTabletInput.val(formatAngka(hargaJual));
                            hargaTabletInput.attr('data-nama-obat', obatName);
                            calculateTotalHarga(pasienId, index);
                        } else {
                            console.warn('No valid harga_jual in response:', response);
                            $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0));
                            calculateTotalHarga(pasienId, index);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX /gantiObat-RegoGanti error:', textStatus, errorThrown);
                        $(`#hargaTablet_${pasienId}_${index}`).val(formatAngka(0));
                        calculateTotalHarga(pasienId, index);
                    }
                });
            }

            // Event untuk input obat
            $('.obat-input').each(function() {
                const input = $(this);
                let previousValue = input.val();
                const inputId = input.attr('id');
                console.log('Binding input:', inputId);

                input.on('focus', function() {
                    previousValue = input.val();
                    input.val('');
                    console.log('Focus on input:', inputId);
                }).on('blur', function() {
                    if (input.val().trim() === '') {
                        input.val(previousValue);
                    }
                    console.log('Blur on input:', inputId);
                });

                // Pencarian dengan debounce
                input.on('input', debounce(function() {
                    const match = input.attr('id').match(/_(\d+)_(\d+)/);
                    if (!match) {
                        console.error('Invalid input ID format:', inputId);
                        return;
                    }
                    const [pasienId, index] = match.slice(1);
                    const query = input.val().trim();

                    const resultsContainer = $(`#results-${pasienId}-${index}`);
                    if (!resultsContainer.length) {
                        console.error('Results container not found for ID:',
                            `results-${pasienId}-${index}`);
                        return;
                    }

                    console.log('Searching for query:', query, 'Pasien ID:', pasienId, 'Index:',
                        index);
                    resultsContainer.empty().removeClass('show');

                    if (query.length > 1) {
                        resultsContainer.append(
                            '<div class="result-item loading">Memuat...</div>').addClass(
                            'show');
                        $.ajax({
                            url: '/cariObat-ganti',
                            method: 'GET',
                            data: {
                                term: query
                            },
                            success: function(data) {
                                console.log('AJAX /cariObat-ganti success. Data:',
                                    data);
                                resultsContainer.empty();
                                if (data && Array.isArray(data) && data.length) {
                                    $.each(data, function(i, item) {
                                        const itemText = item.text || item
                                            .label || item.name ||
                                            'Unknown';
                                        const itemId = item.id || i;
                                        const itemHarga = parseFloat(item
                                            .harga_jual) || 0;
                                        resultsContainer.append(
                                            `<div class="result-item" data-id="${itemId}" data-harga="${itemHarga}" role="option">${itemText}</div>`
                                        );
                                    });
                                    resultsContainer.addClass('show');
                                } else {
                                    resultsContainer.append(
                                        '<div class="result-item">Tidak ada hasil</div>'
                                    ).addClass('show');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('AJAX /cariObat-ganti error:',
                                    textStatus, errorThrown);
                                resultsContainer.empty().append(
                                    '<div class="result-item error">Terjadi kesalahan saat mencari</div>'
                                ).addClass('show');
                            }
                        });
                    } else {
                        console.log('Query too short:', query);
                    }
                }, 300));
            });

            // Event klik pada hasil pencarian obat
            $(document).on('click', '.result-item', function() {
                const itemText = $(this).text();
                const itemId = $(this).data('id');
                const itemHarga = parseFloat($(this).data('harga')) || 0;
                const resultsContainer = $(this).parent();
                const containerId = resultsContainer.attr('id');
                const [pasienId, index] = containerId.match(/-(\d+)-(\d+)/).slice(1);

                console.log(`Selected item: ${itemText} (ID: ${itemId}, Harga: ${itemHarga})`);

                // Update input obat
                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                inputObat.val(itemText);
                inputObat.attr('data-nama-obat', itemText);

                // Update harga tablet
                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                hargaTabletInput.val(formatAngka(itemHarga));
                hargaTabletInput.attr('data-nama-obat', itemText);

                // Hitung total harga per obat dan update total semua
                calculateTotalHarga(pasienId, index);

                // Sembunyikan dropdown
                resultsContainer.removeClass('show');

                // Panggil AJAX untuk validasi harga dari server
                updateHargaObat(pasienId, index, itemId, itemText);
            });

            // Event perubahan jumlah obat
            $(document).on('input change', '.jumlah-input', function() {
                const pasienId = $(this).data('pasien-id');
                const index = $(this).data('index');
                console.log(`Jumlah changed: Pasien ${pasienId}, Index ${index}, Value ${$(this).val()}`);
                calculateTotalHarga(pasienId, index);
            });

            // Event tombol hapus
            $(document).on('click', '.btn-hapus', function() {
                const pasienId = $(this).data('pasien-id');
                const index = $(this).data('index');
                const namaObatAwal = $(this).data('nama-obat');
                const hargaAwal = parseFloat($(this).data('harga')) || 0;

                console.log(
                    `Resetting: Pasien ${pasienId}, Index ${index}, Obat ${namaObatAwal}, Harga ${hargaAwal}`
                );

                // Reset nilai
                const inputObat = $(`#obat_Ro_${pasienId}_${index}`);
                inputObat.val(namaObatAwal);
                inputObat.attr('data-nama-obat', namaObatAwal);

                const hargaTabletInput = $(`#hargaTablet_${pasienId}_${index}`);
                hargaTabletInput.val(formatAngka(hargaAwal));
                hargaTabletInput.attr('data-nama-obat', namaObatAwal);

                // Hitung ulang total harga per obat dan update total semua
                calculateTotalHarga(pasienId, index);
            });

            // Sembunyikan hasil saat klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.input-row').length) {
                    console.log('Click outside, hiding search results');
                    $('.search-results').removeClass('show');
                }
            });

            // Navigasi keyboard untuk hasil pencarian
            $('.obat-input').on('keydown', function(e) {
                const inputId = $(this).attr('id');
                const resultsContainer = $(`#results-${inputId.replace('obat_Ro_', '')}`);
                const items = resultsContainer.find('.result-item');
                let selectedIndex = items.filter('.selected').index();

                console.log('Keydown:', e.key, 'on input:', inputId);
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = selectedIndex === -1 ? items.length - 1 : (selectedIndex - 1 + items
                        .length) % items.length;
                    items.removeClass('selected').eq(selectedIndex).addClass('selected');
                    resultsContainer.scrollTop(items.eq(selectedIndex).position().top);
                } else if (e.key === 'Enter' && items.hasClass('selected')) {
                    e.preventDefault();
                    items.filter('.selected').trigger('click');
                }
            });

            // Inisialisasi perhitungan total saat halaman dimuat
            $('.obat-container').each(function() {
                const pasienId = $(this).data('pasien-id');
                $(`.harga-total-input[data-pasien-id="${pasienId}"]`).each(function(index) {
                    calculateTotalHarga(pasienId, index);
                });
                updateTotalSemua(pasienId);
            });
        });

        // INPUT ATURAN
        function toggleInput(selectElement, uniqueId) {
            const parent = selectElement.parentElement;
            const selectedValue = selectElement.value;
            const customInput = document.getElementById(`custom_sehari_${uniqueId}`);
            const originalSelect = document.getElementById(`sehari_${uniqueId}`);

            if (selectedValue === 'custom') {
                // Tampilkan input kustom di sebelah select
                customInput.classList.remove('d-none');
                customInput.style.display = 'block';
                customInput.focus();

                // Tambahkan event listener untuk kembali ke select
                customInput.addEventListener('blur', function revertToSelect() {
                    if (customInput.value.trim() === '') {
                        // Jika input kosong, sembunyikan input kustom
                        customInput.classList.add('d-none');
                        customInput.style.display = 'none';
                        originalSelect.value = '1x1 SENDOK'; // Reset ke opsi default
                    }
                    // Hapus event listener setelah digunakan
                    customInput.removeEventListener('blur', revertToSelect);
                });
            } else {
                // Sembunyikan input kustom
                customInput.classList.add('d-none');
                customInput.style.display = 'none';
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/obat/ModalTambahResep/ModalResep.blade.php ENDPATH**/ ?>