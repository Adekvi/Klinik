<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Perawat']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row demo-vertical-spacing">
            <div class="col-md-12">
                <div class="pendaftaran">
                    <div class="card-title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h4><strong>Antrian Pasien</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="kunjungan">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#Sehat">
                                    <i class="fa-solid fa-square-plus"></i> Kunjungan Sehat
                                </button>

                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#KunjunganOnline" style="margin-left: 10px">
                                    <i class="fa-solid fa-square-plus"></i> Kunjungan Online
                                </button>
                            </div>

                            <div class="status" style="justify-content: start">
                                <div class="col-lg-12 col-md-6">
                                    <button class="btn btn-info" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEnd" aria-controls="offcanvasBoth">
                                        <i class="fa-solid fa-house-medical-circle-check"></i> Status Pasien
                                    </button>
                                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd"
                                        aria-labelledby="offcanvasEndLabel" style="width: 600px">
                                        <div class="offcanvas-header">
                                            <h5 id="offcanvasEndLabel" class="offcanvas-title">Status Pasien</h5>
                                            <button type="button" class="btn-close text-reset"
                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                            <div class="text-center mb-3">
                                                <h4 class="mb-3"><strong>Update Pasien</strong></h4>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div class="text-center d-flex flex-column align-items-center">
                                                        <!-- Teks dan ikon di atas -->
                                                        <span class="badge border text-success fs-6 p-3">
                                                            <i class="fa-solid fa-check-circle"></i> Dilayani:
                                                            <span id="pasienDilayani" style="font-size: 25px">0</span>
                                                        </span>
                                                        <!-- Gambar di bawah -->
                                                        <img src="<?php echo e(asset('aset/img/periksa.jpg')); ?>"
                                                            alt="Pasien DIlayani" style="width: 60%; height: auto;">
                                                    </div>
                                                    <div class="text-center d-flex flex-column align-items-center">
                                                        <!-- Teks dan ikon di atas -->
                                                        <span class="badge border text-warning fs-6 p-3">
                                                            <i class="fa-solid fa-times-circle"></i> Belum Dilayani:
                                                            <span id="pasienBelumDilayani"
                                                                style="font-size: 25px">0</span>
                                                        </span>
                                                        <!-- Gambar di bawah -->
                                                        <img src="<?php echo e(asset('aset/img/check.jpg')); ?>"
                                                            alt="Pasien Belum Dilayani"
                                                            style="width: 60%; height: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">

                                                <div id="shiftPagi" class="shift-container">
                                                    <table class="table table-bordered table-responsive">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th class="text-center">SHIFT PAGI</th>
                                                                <th class="text-center">KET.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Tanggal</td>
                                                                <td id="tanggalShiftPagi" class="text-center"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                                <td id="poliUmumBpjsPagi" class="text-center">0
                                                                <td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Bpjs)</td>
                                                                <td id="laboratBpjsPagi" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Umum)</td>
                                                                <td id="laboratUmumPagi" class="text-center">0</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div id="shiftSiang" class="shift-container">
                                                    <table class="table table-bordered table-responsive">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th class="text-center">SHIFT SIANG</th>
                                                                <th class="text-center">KET.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Tanggal</td>
                                                                <td id="tanggalShiftSiang" class="text-center"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                                <td id="poliUmumBpjsSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Bpjs)</td>
                                                                <td id="laboratBpjsSiang" class="text-center">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Umum)</td>
                                                                <td id="laboratUmumSiang" class="text-center">0</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="shift-container" id="shiftReportTotal">
                                                    <table class="table table-bordered table-responsive w-100">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th class="text-center">PASIEN SHIFT PAGI DAN SIANG
                                                                </th>
                                                                <th class="text-center">KET.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                                <td id="poliUmumBpjsTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli UMUM (Umum)</td>
                                                                <td id="poliUmumUmumTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                                <td id="poliGigiBpjsTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pasien Poli GIGI (Umum)</td>
                                                                <td id="poliGigiUmumTotal" style="text-align: center">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Bpjs)</td>
                                                                <td id="laboratBpjsTotal" style="text-align: center">0
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Laborat (Umum)</td>
                                                                <td id="laboratUmumTotal" style="text-align: center">0
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <a href="<?php echo e(url('perawat/rekap/harian')); ?>"
                                                        class="btn btn-primary w-100">
                                                        <i class="menu-icon tf-icons fa-solid fa-folder"></i> Menu
                                                        Rekap
                                                        Harian
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-outline-secondary w-100"
                                                        data-bs-dismiss="offcanvas">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="<?php echo e(route('perawat.index')); ?>"
                                class="d-flex justify-content-between align-items-center mb-3">
                                <input type="hidden" name="page" value="1">
                                <div class="d-flex align-items-center">
                                    <label for="entries" class="me-2">Tampilkan:</label>
                                    <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                        style="width: 80px;" onchange="this.form.submit()">
                                        <option value="10" <?php echo e($entries == 10 ? 'selected' : ''); ?>>10
                                        </option>
                                        <option value="25" <?php echo e($entries == 25 ? 'selected' : ''); ?>>25
                                        </option>
                                        <option value="50" <?php echo e($entries == 50 ? 'selected' : ''); ?>>50
                                        </option>
                                        <option value="100" <?php echo e($entries == 100 ? 'selected' : ''); ?>>100
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center">
                                    <input type="text" name="search" value="<?php echo e($search); ?>"
                                        class="form-control form-control-sm me-2" style="width: 400px;"
                                        placeholder="Cari Nama / NIK / No. Rm">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered"
                                    style="background-color: white; white-space: nowrap;">
                                    <thead class="table-primary"
                                        style=" text-align: center; font-size: 25px; width: auto">
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>No. RM</th>
                                            <th>Nama Pasien</th>
                                            <th>No. Antrian</th>
                                            <th>Poli</th>
                                            <th>Dokter</th>
                                            <th>Alamat Domisili</th>
                                            <th>Jenis Pasien</th>
                                            <th>Umur</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center; text-transform: uppercase;" id="daftarAntrianD">
                                        <?php if(count($pasien) === 0): ?>
                                            <tr>
                                                <td colspan="10" style="text-align: center; font-size: bold">Belum
                                                    ada data
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $no = 1; ?>
                                            <?php $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php if($item->status == 'D'): ?>
                                                    <tr id="row_<?php echo e($item->id); ?>">
                                                        <td><?php echo e($no++); ?></td>
                                                        <td>
                                                            <button
                                                                data-nomor-antrian-perawat="<?php echo e($item->kode_antrian); ?>"
                                                                data-poli="<?php echo e($item->poli->namapoli); ?>"
                                                                class="btn btn-success btn-panggil-perawat mb-1"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
                                                                <i class="fas fa-bell"></i>
                                                            </button>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
                                                                <button type="button" class="btn btn-secondary mb-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#lewati<?php echo e($item->id); ?>">
                                                                    <i class="fa-solid fa-forward"></i>
                                                                </button>
                                                            </span>
                                                            <button type="button" class="btn btn-primary mb-1"
                                                                onclick="Livewire.emit('openAsesmenModal', <?php echo e($item->id); ?>)">
                                                                <i class="fas fa-pen"></i>
                                                            </button>

                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
                                                                <button type="button" class="btn btn-info mb-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#riwayatModal<?php echo e($item->id); ?>">
                                                                    <i class="fas fa-info"></i>
                                                                </button>
                                                            </span>
                                                            <a href="<?php echo e(url('cetak-antrianPerawat/' . $item->id)); ?>"
                                                                class="btn btn-warning mb-1" target="_blank"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                data-bs-placement="top" data-bs-html="true">
                                                                <i class="fas fa-print"></i>
                                                            </a>
                                                        </td>
                                                        <td><?php echo e($item->booking->pasien->no_rm); ?></td>
                                                        <td><?php echo e($item->booking->pasien->nama_pasien); ?></td>
                                                        <td><?php echo e($item->kode_antrian); ?></td>
                                                        <td><?php echo e($item->poli->namapoli); ?></td>
                                                        <td><?php echo e($item->dokter->nama_dokter); ?></td>
                                                        <td><?php echo e($item->booking->pasien->domisili); ?></td>
                                                        <td><?php echo e($item->booking->pasien->jenis_pasien); ?></td>
                                                        <td>
                                                            <?php echo e(\Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age); ?>

                                                            Tahun
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill">
                                                                Datang
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="halaman d-flex justify-content-end">
                                <?php echo e($pasien->appends(request()->only(['search', 'entries']))->links()); ?>

                            </div>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('perawat.asesmen-pasien-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('JMJkoi4')) {
    $componentId = $_instance->getRenderedChildComponentId('JMJkoi4');
    $componentTag = $_instance->getRenderedChildComponentTagName('JMJkoi4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('JMJkoi4');
} else {
    $response = \Livewire\Livewire::mount('perawat.asesmen-pasien-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('JMJkoi4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="sudah-daftar">
                <div class="card-title">
                    <h4><strong>Pasien Diperiksa</strong></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('perawat.index')); ?>"
                            class="d-flex justify-content-between align-items-center mb-3">
                            <input type="hidden" name="page" value="1">
                            <div class="d-flex align-items-center">
                                <label for="periksa_entries" class="me-2">Tampilkan:</label>
                                <select name="periksa_entries" id="periksa_entries"
                                    class="form-select form-select-sm me-3" style="width: 80px;"
                                    onchange="this.form.submit()">
                                    <option value="10"
                                        <?php echo e(request('periksa_entries', 10) == 10 ? 'selected' : ''); ?>>10
                                    </option>
                                    <option value="25" <?php echo e(request('recent_entries') == 25 ? 'selected' : ''); ?>>25
                                    </option>
                                    <option value="50" <?php echo e(request('recent_entries') == 50 ? 'selected' : ''); ?>>50
                                    </option>
                                    <option value="100" <?php echo e(request('recent_entries') == 100 ? 'selected' : ''); ?>>
                                        100
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="text" name="periksa_search" value="<?php echo e(request('periksa_search')); ?>"
                                    class="form-control form-control-sm me-2" style="width: 400px;"
                                    placeholder="Cari Nama / NIK / No. Rm">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </form>
                        <div class="isian" style="overflow-x: scroll">
                            <table class="table table-striped table-bordered"
                                style="background-color: white; white-space: nowrap;">
                                <thead class="table-secondary" style="text-align: center; width: auto">
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl/Jam</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>No. Antrian</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Pasien</th>
                                        <th>Umur</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center; text-transform: uppercase;" id="daftarAntrianM">
                                    <?php if($periksa->isEmpty()): ?>
                                        <tr>
                                            <td colspan="9" style="text-align: center">Tidak Ada Data Pasien</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; ?>
                                        <?php $__currentLoopData = $periksa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($item->status == 'M'): ?>
                                                <tr id="row_<?php echo e($item->id); ?>">
                                                    <td><?php echo e($no++); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($item->created_at)->format('d-m-Y / H:i')); ?>

                                                    </td>
                                                    <td><?php echo e($item->booking->pasien->no_rm); ?></td>
                                                    <td><?php echo e($item->booking->pasien->nama_pasien); ?></td>
                                                    <td><?php echo e($item->kode_antrian); ?></td>
                                                    <td><?php echo e($item->poli->namapoli); ?></td>
                                                    <td><?php echo e($item->dokter->nama_dokter); ?></td>
                                                    <td><?php echo e($item->booking->pasien->domisili); ?></td>
                                                    <td><?php echo e($item->booking->pasien->jenis_pasien); ?></td>
                                                    <td>
                                                        <?php echo e(\Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age); ?>

                                                        Tahun
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary rounded-pill">
                                                            Menunggu..
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="page d-flex justify-content-end">
                            <?php echo e($periksa->appends(request()->only(['periksa_search', 'periksa_entries']))->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="modal fade" id="riwayatModal<?php echo e($item->id); ?>" tabindex="-1"
            aria-labelledby="exampleModalLabel<?php echo e($item->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Riwayat
                            Asesmen
                            Pasien
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="asesmen">
                            <table class="table table-bordered">
                                <thead class="table-info">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Asesmen</th>
                                        <th>Detail Asesmen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $iteration = 1;
                                        $asesmenDitemukan = false;
                                    ?>
                                    <?php
                                        $sortedSoap = [];
                                        if (!empty($soap)) {
                                            $idPasien = $item->booking->id_pasien;
                                            $sortedSoap = $soap
                                                ->where('id_pasien', $idPasien)
                                                ->sortByDesc('created_at')
                                                ->values()
                                                ->all();
                                        }
                                        // dd($sortedSoap);
                                    ?>
                                    <?php if(!empty($sortedSoap)): ?>
                                        <?php $__currentLoopData = $sortedSoap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesmen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $asesmenDitemukan = true; ?>
                                            <tr>
                                                <td><?php echo e($iteration++); ?></td>
                                                <td><?php echo e(date_format(date_create($asesmen['created_at']), 'd-m-Y/H:i:s')); ?>

                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailAsesmen<?php echo e($asesmen['id']); ?>"
                                                        data-toggle="tooltip" data-bs-placement="top"
                                                        title="Asesmen">
                                                        <i class="fas fa-eye"></i> Lihat Asesmen
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif(!$asesmenDitemukan): ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center">Belum ada Asesmen</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <?php if(!empty($soap)): ?>
        <?php $__currentLoopData = $soap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesmen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="modal fade" id="detailAsesmen<?php echo e($asesmen->id); ?>" tabindex="-1"
                aria-labelledby="exampleModalLabelAsesmen<?php echo e($asesmen->id); ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="display: contents">
                    <div class="modal-content" style="margin-top: 20px; width: 95%; margin-left: 3%;">
                        <div class="modal-header bg-primary">
                            <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">
                                Detail Asesmen
                                Tanggal:
                                <?php echo e($asesmen->created_at ? date_format(date_create($asesmen->created_at), 'd-m-Y') : 'N/A'); ?>

                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead class="table-primary" style="text-align: center;">
                                        <tr>
                                            <th>TGL DAN JAM</th>
                                            <th>PROFESI</th>
                                            <th>ASESMEN</th>
                                            <th>EDUKASI</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        <tr>
                                            <td><?php echo e($asesmen->created_at ? date_format(date_create($asesmen->created_at), 'Y-m-d H:i:s') : 'N/A'); ?>

                                            </td>
                                            <td><?php echo e($asesmen->nama_dokter ?? 'N/A'); ?></td>
                                            <td style="text-align: left">
                                                <table class="table">
                                                    <thead>
                                                        <tr style="text-align: center; font-weight: bold">
                                                            <td>S</td>
                                                            <td>O</td>
                                                            <td>A</td>
                                                            <td>P</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo e($asesmen->keluhan_utama ?? 'N/A'); ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li>Tensi: <?php echo e($asesmen->p_tensi ?? 'N/A'); ?> mmHg
                                                                    </li>
                                                                    <li>RR: <?php echo e($asesmen->p_rr ?? 'N/A'); ?> / minute</li>
                                                                    <li>Nadi: <?php echo e($asesmen->p_nadi ?? 'N/A'); ?> / minute
                                                                    </li>
                                                                    <li>Suhu: <?php echo e($asesmen->p_suhu ?? 'N/A'); ?> °C</li>
                                                                    <li>TB: <?php echo e($asesmen->p_tb ?? 'N/A'); ?> cm</li>
                                                                    <li>BB: <?php echo e($asesmen->p_bb ?? 'N/A'); ?> kg</li>
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    $diagnosaPrimer = !empty($asesmen->soap_a_primer)
                                                                        ? json_decode($asesmen->soap_a_primer, true)
                                                                        : [];
                                                                    $diagnosaSekunder = !empty(
                                                                        $asesmen->soap_a_sekunder
                                                                    )
                                                                        ? json_decode($asesmen->soap_a_sekunder, true)
                                                                        : [];
                                                                    $diagnosaPrimer = is_array($diagnosaPrimer)
                                                                        ? array_values($diagnosaPrimer)
                                                                        : [];
                                                                    $diagnosaSekunder = is_array($diagnosaSekunder)
                                                                        ? array_values($diagnosaSekunder)
                                                                        : [];
                                                                ?>
                                                                <p style="font-weight: bold">Diagnosa Primer</p>
                                                                <?php if(!empty($diagnosaPrimer)): ?>
                                                                    <?php $__currentLoopData = $diagnosaPrimer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <ul>
                                                                            <li><?php echo e($diag); ?></li>
                                                                        </ul>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <p>-</p>
                                                                <?php endif; ?>
                                                                <p style="font-weight: bold">Diagnosa Sekunder</p>
                                                                <?php if(!empty($diagnosaSekunder)): ?>
                                                                    <?php $__currentLoopData = $diagnosaSekunder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diagn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <ul>
                                                                            <li><?php echo e($diagn); ?></li>
                                                                        </ul>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <p>-</p>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <p style="font-weight: bold; margin-bottom: 0">Resep:
                                                                </p>
                                                                <p style="font-weight: bold; margin-bottom: 0">Non
                                                                    Racikan
                                                                </p>
                                                                <?php
                                                                    $resep = !empty($asesmen->soap_p)
                                                                        ? json_decode($asesmen->soap_p, true)
                                                                        : [];
                                                                    $aturan = !empty($asesmen->soap_p_aturan)
                                                                        ? json_decode($asesmen->soap_p_aturan, true)
                                                                        : [];
                                                                ?>
                                                                <?php if(is_array($resep) && is_array($aturan) && count($resep) == count($aturan) && !empty($resep)): ?>
                                                                    <?php $__currentLoopData = $resep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obat => $namaObat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            $aturanMinum = $aturan[$obat] ?? 'N/A';
                                                                        ?>
                                                                        <ul>
                                                                            <li><?php echo e($namaObat); ?> |
                                                                                <?php echo e($aturanMinum); ?>

                                                                            </li>
                                                                        </ul>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <p>-</p>
                                                                <?php endif; ?>

                                                                <p style="font-weight: bold; margin-bottom: 0">Racikan
                                                                    (Puyer)
                                                                </p>
                                                                <?php
                                                                    $obatRacikan = !empty($asesmen->soap_r)
                                                                        ? json_decode($asesmen->soap_r, true)
                                                                        : [];
                                                                    $takaran = !empty($asesmen->soap_r_takaran)
                                                                        ? json_decode($asesmen->soap_r_takaran, true)
                                                                        : [];
                                                                ?>
                                                                <?php if(is_array($obatRacikan) && is_array($takaran) && count($obatRacikan) > 0 && count($obatRacikan) == count($takaran)): ?>
                                                                    <?php $__currentLoopData = $obatRacikan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namaObat => $jumlah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <ul>
                                                                            <li><?php echo e($namaObat); ?> -
                                                                                <?php echo e($jumlah); ?>

                                                                                (<?php echo e($takaran[$namaObat] ?? 'N/A'); ?>)
                                                                            </li>
                                                                        </ul>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <p>-</p>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td><?php echo e($asesmen->edukasi ?? 'N/A'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- Asumsikan kembali ke modal riwayat pasien yang sesuai -->
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>


    <?php $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="lewati<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Lewati
                            Pasien
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Apakah Anda yakin ingin melewati pasien ini?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <form action="<?php echo e(url('perawat/lewati/' . $item->id)); ?>" method="POST"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Lewati</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Modal PASIEN UMUM -->
    <div class="modal fade" id="pasienumum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Pendaftaran
                        Pasien
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_rm">Poli</label>
                        <select name="poli" id="poli_umum" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Poli</option>
                            <?php $__currentLoopData = $poli; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->KdPoli); ?>"><?php echo e($item->namapoli); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Dokter</label>
                        <select name="dokter" id="dokter_umum" class="form-control mt-2 mb-2">
                            <option value="#">Pilih Dokter</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="search_pasien">Nama Pasien</label>
                        <input type="text" class="form-control mt-2 mb-2" name="search_pasien" id="search_pasien"
                            placeholder="Masukkan Nama Pasien" required>
                        <div id="autocomplete-results"></div>

                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control mt-2 mb-2 <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="nik" id="nik" placeholder="Masukkan NIK" required>
                        <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="nama_kk">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk"
                            placeholder="Masukkan Nama Kepala Keluarga" required>
                    </div>
                    <div class="form-group">
                        <label for="tgllahir">Tanggal Lahir</label>
                        <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="jekel">Jenis Kelamin</label>
                        <select name="jekel" id="jekel" class="form-control mt-2 mb-2" required>
                            <option value="" disabled selected>Pilih Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Asal</label>
                        <input type="text" class="form-control mt-2 mb-2" name="alamat_asal" id="alamat_asal"
                            placeholder="Masukkan Alamat Asal" required>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control mt-2 mb-2" name="pekerjaan" id="pekerjaan"
                            placeholder="Masukkan Pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Domisili</label>
                        <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisili"
                            placeholder="Masukkan Alamat Domisili" required>
                    </div>
                    <div class="form-group">
                        <label for="noHP">No. HP</label>
                        <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHP"
                            placeholder="Masukkan No. HP" required>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="btnSimpan" onclick="saveData()">
                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PASIEN BPJS -->
    <div class="modal fade" id="pasienbpjs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienlama" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Pendaftaran Pasien
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_rm">Poli</label>
                        <select name="poli" id="poli_bpjs" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Poli</option>
                            <?php $__currentLoopData = $poli; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->KdPoli); ?>"><?php echo e($item->namapoli); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Dokter</label>
                        <select name="dokter" id="dokter_bpjs" class="form-control mt-2 mb-2">
                            <option value="#">Pilih Dokter</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="norm">No. BPJS</label>
                        <div class="cari mt-2 mb-2" style="display: flex; align-items: center">
                            <input type="text" class="form-control mb-2" name="norm" id="norm"
                                placeholder="Masukkan No.BPJS">
                            <div id="autocompletebpjs-results"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="search_pasien">Nama Pasien</label>
                        <input type="text" class="form-control mt-2 mb-2" name="search_pasien"
                            id="nama_pasienbpjs" placeholder="Masukkan Nama Pasien" required>
                        <div id="autocomplete-results"></div>

                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control mt-2 mb-2 <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="nik" id="nikbpjs" placeholder="Masukkan NIK" required>
                        <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="nama_kk">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kkbpjs"
                            placeholder="Masukkan Nama Kepala Keluarga" required>
                    </div>
                    <div class="form-group">
                        <label for="tgllahir">Tanggal Lahir</label>
                        <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahirbpjs"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="jekel">Jenis Kelamin</label>
                        <select name="jekel" id="jekelbpjs" class="form-control mt-2 mb-2" required>
                            <option value="" disabled selected>Pilih Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Asal</label>
                        <input type="text" class="form-control mt-2 mb-2" name="alamat_asal" id="alamat_asalbpjs"
                            placeholder="Masukkan Alamat Asal" required>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control mt-2 mb-2" name="pekerjaan" id="pekerjaanbpjs"
                            placeholder="Masukkan Pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Domisili</label>
                        <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisilibpjs"
                            placeholder="Masukkan Alamat Domisili" required>
                    </div>
                    <div class="form-group">
                        <label for="noHP">No. HP</label>
                        <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHPbpjs"
                            placeholder="Masukkan No. HP" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpanBpjs" onclick="saveDataBpjs()">
                        <span id="loadingSpinnerLama" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('perawat.kunjunganSehat.modalSehat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('perawat.kunjunganOnline.modalOnline', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startPush('style'); ?>
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="<?php echo e(asset('aset/js/popper/popper.min.js')); ?>"></script>

        <!-- <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script> -->
        <script src="https://code.responsivevoice.org/responsivevoice.js?key=EbYPThWO"></script>

        <script src="<?php echo e(asset('assets/js/antrian.script.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>

        <script>
            // Cache elements
            const containerD = document.getElementById('daftarAntrianD');
            const containerM = document.getElementById('daftarAntrianM');
            const entriesSelect = document.querySelector('#entries');
            const periksaEntriesSelect = document.querySelector('#periksa_entries');
            const searchInput = document.querySelector('input[name="search"]');
            const periksaSearchInput = document.querySelector('input[name="periksa_search"]');

            // Helper functions
            function hitungUmur(tanggalLahir) {
                const birth = new Date(tanggalLahir);
                const today = new Date();
                let age = today.getFullYear() - birth.getFullYear();
                const m = today.getMonth() - birth.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
                return `${age} Tahun`;
            }

            function formatTanggalJam(dateString) {
                const date = new Date(dateString);
                const pad = n => String(n).padStart(2, '0');
                return `${pad(date.getDate())}-${pad(date.getMonth() + 1)}-${date.getFullYear()} / ${pad(date.getHours())}:${pad(date.getMinutes())}`;
            }

            function getQueryParams() {
                const params = new URLSearchParams();

                // Ambil semua parameter dari URL saat ini (termasuk page & periksa_page)
                new URLSearchParams(window.location.search).forEach((value, key) => {
                    params.set(key, value);
                });

                // Override hanya parameter form yang bisa berubah oleh user
                if (entriesSelect) params.set('entries', entriesSelect.value);
                if (searchInput?.value.trim()) params.set('search', searchInput.value.trim());
                else params.delete('search'); // hapus jika kosong

                if (periksaEntriesSelect) params.set('periksa_entries', periksaEntriesSelect.value);
                if (periksaSearchInput?.value.trim()) params.set('periksa_search', periksaSearchInput.value.trim());
                else params.delete('periksa_search');

                // page & periksa_page tetap dipertahankan dari URL
                return params.toString();
            }

            // Render row helpers
            function renderRowD(item) {
                const p = item.booking.pasien;
                return `
                <tr id="row_${item.id}">
                    <td>${item.nomor_urut}</td>
                    <td>
                        <button data-nomor-antrian-perawat="${item.kode_antrian}" data-poli="${item.poli.namapoli}" class="btn btn-success btn-panggil-perawat mb-1">
                            <i class="fas fa-bell"></i>
                        </button>
                        <button type="button" class="btn btn-secondary mb-1" data-bs-toggle="modal" data-bs-target="#lewati${item.id}">
                            <i class="fa-solid fa-forward"></i>
                        </button>
                        <button type="button" class="btn btn-primary mb-1" onclick="Livewire.emit('openAsesmenModal', ${item.id})">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button type="button" class="btn btn-info mb-1" data-bs-toggle="modal" data-bs-target="#riwayatModal${item.id}">
                            <i class="fas fa-info"></i>
                        </button>
                        <a href="/cetak-antrianPerawat/${item.id}" target="_blank" class="btn btn-warning mb-1">
                            <i class="fas fa-print"></i>
                        </a>
                    </td>
                    <td>${p.no_rm}</td>
                    <td>${p.nama_pasien}</td>
                    <td>${item.kode_antrian}</td>
                    <td>${item.poli.namapoli}</td>
                    <td>${item.dokter.nama_dokter}</td>
                    <td>${p.domisili}</td>
                    <td>${p.jenis_pasien}</td>
                    <td>${hitungUmur(p.tgllahir)}</td>
                    <td><button type="button" class="btn btn-info rounded-pill">Datang</button></td>
                </tr>`;
            }

            function renderRowM(item) {
                const p = item.booking.pasien;
                return `
                <tr id="row_${item.id}">
                    <td>${item.nomor_urut}</td>
                    <td>${formatTanggalJam(item.created_at)}</td>
                    <td>${p.no_rm}</td>
                    <td>${p.nama_pasien}</td>
                    <td>${item.kode_antrian}</td>
                    <td>${item.poli.namapoli}</td>
                    <td>${item.dokter.nama_dokter}</td>
                    <td>${p.domisili}</td>
                    <td>${p.jenis_pasien}</td>
                    <td>${hitungUmur(p.tgllahir)}</td>
                    <td><button class="btn btn-secondary rounded-pill">Menunggu..</button></td>
                </tr>`;
            }

            // Main fetch antrian
            function fetchAntrian() {
                const query = getQueryParams();
                const url = `/antrian-perawat-json${query ? '?' + query : ''}`;

                fetch(url)
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(data => {
                        // Tabel Datang (D)
                        if (data.D.data.length === 0) {
                            containerD.innerHTML =
                                `<tr><td colspan="11" style="text-align:center;font-weight:bold">Belum ada data</td></tr>`;
                        } else {
                            containerD.innerHTML = data.D.data.map(renderRowD).join('');
                        }

                        // Tabel Menunggu (M)
                        if (data.M.data.length === 0) {
                            containerM.innerHTML =
                                `<tr><td colspan="11" style="text-align:center;font-weight:bold">Tidak Ada Data Pasien</td></tr>`;
                        } else {
                            containerM.innerHTML = data.M.data.map(renderRowM).join('');
                        }
                    })
                    .catch(err => console.error('Error fetching antrian:', err));
            }

            // Update statistik
            function updateStats() {
                fetch('/stats-antrian')
                    .then(res => res.json())
                    .then(data => {
                        const ids = [
                            'pasienDilayani', 'pasienBelumDilayani',
                            'poliUmumBpjsPagi', 'poliUmumUmumPagi', 'poliGigiBpjsPagi', 'poliGigiUmumPagi',
                            'laboratBpjsPagi', 'laboratUmumPagi',
                            'poliUmumBpjsSiang', 'poliUmumUmumSiang', 'poliGigiBpjsSiang', 'poliGigiUmumSiang',
                            'laboratBpjsSiang', 'laboratUmumSiang',
                            'poliUmumBpjsTotal', 'poliUmumUmumTotal', 'poliGigiBpjsTotal', 'poliGigiUmumTotal',
                            'laboratBpjsTotal', 'laboratUmumTotal'
                        ];
                        ids.forEach(id => {
                            const el = document.getElementById(id);
                            if (el && data[id] !== undefined) el.innerText = data[id];
                        });
                    })
                    .catch(err => console.error('Error fetching stats:', err));
            }

            // Jalankan saat load
            fetchAntrian();
            updateStats();

            // Polling setiap 5 detik
            setInterval(fetchAntrian, 5000);
            setInterval(updateStats, 5000);

            // SHIFT
            document.addEventListener("DOMContentLoaded", function() {
                function checkShift() {
                    let now = new Date();
                    let hours = now.getHours();

                    let shiftPagi = document.getElementById("shiftPagi");
                    let shiftSiang = document.getElementById("shiftSiang");
                    let shiftTotal = document.getElementById("shiftReportTotal");

                    // Pengecekan elemen
                    if (!shiftPagi || !shiftSiang || !shiftTotal) {
                        console.error("Elemen shift tidak ditemukan: shiftPagi, shiftSiang, atau shiftReportTotal");
                        return;
                    }

                    let tanggalHariIni = now.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    // Atur tanggal di tabel shift pagi dan siang
                    let tanggalShiftPagi = document.getElementById("tanggalShiftPagi");
                    let tanggalShiftSiang = document.getElementById("tanggalShiftSiang");
                    if (tanggalShiftPagi && tanggalShiftSiang) {
                        tanggalShiftPagi.innerText = tanggalHariIni;
                        tanggalShiftSiang.innerText = tanggalHariIni;
                    } else {
                        console.error("Elemen tanggal shift tidak ditemukan: tanggalShiftPagi atau tanggalShiftSiang");
                    }

                    // Reset tampilan semua shift
                    shiftPagi.style.display = "none";
                    shiftSiang.style.display = "none";
                    shiftTotal.style.display = "none";

                    // Tampilkan tabel sesuai shift
                    if (hours >= 7 && hours < 12) {
                        shiftPagi.style.display = "block";
                    } else if (hours >= 12 && hours < 17) {
                        shiftSiang.style.display = "block";
                    } else {
                        shiftTotal.style.display = "block";
                    }
                }

                checkShift();
                setInterval(checkShift, 60000);
            });

            // TANGGAL SHIFT
            function updateTanggal() {
                var now = new Date();
                var options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric'
                };

                var tanggalPagiElement = document.getElementById('tanggalShiftPagi');
                var tanggalSiangElement = document.getElementById('tanggalShiftSiang');

                if (tanggalPagiElement && tanggalSiangElement) {
                    var tanggalLengkap = now.toLocaleDateString('id-ID', options);
                    tanggalPagiElement.textContent = tanggalLengkap;
                    tanggalSiangElement.textContent = tanggalLengkap;
                } else {
                    console.error("Elemen tanggal shift tidak ditemukan: tanggalShiftPagi atau tanggalShiftSiang");
                }
            }

            // Panggil fungsi saat halaman dimuat
            document.addEventListener("DOMContentLoaded", updateTanggal);

            // JAM DAN TANGGAL
            function updateClock() {
                var now = new Date();
                var tanggalElement = document.getElementById('tanggal');
                var jamElement = document.getElementById('jam');

                if (!tanggalElement || !jamElement) {
                    console.error("Elemen tanggal atau jam tidak ditemukan: tanggal atau jam");
                    return;
                }

                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');
                jamElement.innerHTML = '<h6>' + jamString + '</h6>';
            }

            document.addEventListener("DOMContentLoaded", function() {
                updateClock();
                setInterval(updateClock, 1000);
            });

            // Tampilkan modal jumlah pasien
            function togglePopup() {
                if (typeof $ !== 'undefined' && $('#jmlhpasien').length) {
                    $('#jmlhpasien').modal('toggle');
                } else {
                    console.error("jQuery atau elemen jmlhpasien tidak ditemukan");
                }
            }

            // CSRF Token Setup
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
                        }
                    });
                } else {
                    console.error("jQuery tidak ditemukan untuk pengaturan CSRF");
                }
            });

            // Kode pasien umum
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#poli_umum').length) {
                    $('#poli_umum').change(function() {
                        var poli_id = $(this).val();
                        if (poli_id) {
                            $.ajax({
                                type: "GET",
                                url: "<?php echo e(url('get-dokter-by-poli')); ?>/" + poli_id,
                                success: function(res) {
                                    if (res) {
                                        $("#dokter_umum").empty();
                                        $.each(res, function(key, value) {
                                            $("#dokter_umum").append('<option value="' +
                                                key + '">' + value + '</option>');
                                        });
                                    } else {
                                        $("#dokter_umum").empty();
                                    }
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching dokter data: ", jqXHR);
                                }
                            });
                        } else {
                            $("#dokter_umum").empty();
                        }
                    });
                } else {
                    console.error("jQuery atau elemen poli_umum tidak ditemukan");
                }
            });

            // Autocomplete pasien umum
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#search_pasien').length && $.ui && $.ui.autocomplete) {
                    $('#search_pasien').autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: '/search_nama_pasien',
                                method: 'GET',
                                data: {
                                    nama: request.term
                                },
                                success: function(data) {
                                    response($.map(data, function(item) {
                                        return {
                                            label: item.nama_pasien + ' - ' + item
                                                .nama_kk + ' - ' + item.alamat_asal,
                                            value: item.no_rm
                                        };
                                    }));
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien data: ", jqXHR);
                                }
                            });
                        },
                        minLength: 1,
                        select: function(event, ui) {
                            $('#search_pasien').val(ui.item.label.split(' - ')[0]);
                            var selected_no_rm = ui.item.value;

                            $.ajax({
                                url: '/get_pasien_details',
                                method: 'GET',
                                data: {
                                    no_rm: selected_no_rm
                                },
                                success: function(response) {
                                    $('#nik').val(response.nik || '');
                                    $('#nama_kk').val(response.nama_kk || '');
                                    $('#tgllahir').val(response.tgllahir || '');
                                    $('#jekel').val(response.jekel || '');
                                    $('#alamat_asal').val(response.alamat_asal || '');
                                    $('#pekerjaan').val(response.pekerjaan || '');
                                    $('#domisili').val(response.domisili || '');
                                    $('#noHP').val(response.noHP || '');
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien details: ", jqXHR);
                                }
                            });
                            return false;
                        },
                        appendTo: "#autocomplete-results"
                    }).focus(function() {
                        $(this).autocomplete("search", "");
                    });
                } else {
                    console.error("jQuery, jQuery UI, atau elemen search_pasien tidak ditemukan");
                }
            });

            // Simpan data pasien umum
            function saveData() {
                var loadingSpinner = $('#loadingSpinner');
                var btnSimpan = $('#btnSimpan');
                if (!loadingSpinner.length || !btnSimpan.length) {
                    console.error("Elemen loadingSpinner atau btnSimpan tidak ditemukan");
                    return;
                }

                loadingSpinner.removeClass('d-none');
                btnSimpan.prop('disabled', true);

                var formData = {
                    poli: document.getElementById('poli_umum')?.value || '',
                    dokter: document.getElementById('dokter_umum')?.value || '',
                    nama_pasien: document.getElementById('search_pasien')?.value || '',
                    nik: document.getElementById('nik')?.value || '',
                    nama_kk: document.getElementById('nama_kk')?.value || '',
                    pekerjaan: document.getElementById('pekerjaan')?.value || '',
                    tgllahir: document.getElementById('tgllahir')?.value || '',
                    jekel: document.getElementById('jekel')?.value || '',
                    alamat_asal: document.getElementById('alamat_asal')?.value || '',
                    domisili: document.getElementById('domisili')?.value || '',
                    noHP: document.getElementById('noHP')?.value || ''
                };

                var errorMessages = [];
                if (!formData.poli) errorMessages.push("- Poli harus dipilih.");
                if (!formData.dokter) errorMessages.push("- Dokter harus dipilih.");
                if (!formData.nama_pasien) errorMessages.push("- Nama Pasien harus diisi.");
                if (!formData.nik) errorMessages.push("- NIK harus diisi.");
                if (!formData.nama_kk) errorMessages.push("- Nama Kepala Keluarga harus diisi.");
                if (!formData.tgllahir) errorMessages.push("- Tanggal Lahir harus diisi.");
                if (!formData.jekel) errorMessages.push("- Jenis kelamin harus dipilih.");
                if (!formData.alamat_asal) errorMessages.push("- Alamat Asal harus diisi.");
                if (!formData.pekerjaan) errorMessages.push("- Pekerjaan harus diisi.");
                if (!formData.domisili) errorMessages.push("- Alamat Domisili harus diisi.");
                if (!formData.noHP) errorMessages.push("- No. HP harus diisi.");

                if (errorMessages.length > 0) {
                    loadingSpinner.addClass('d-none');
                    btnSimpan.prop('disabled', false);
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return;
                }

                $.ajax({
                    url: '/perawat/store-umum',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            console.error('No redirect URL provided in the server response.');
                        }
                    },
                    error: function(jqXHR) {
                        loadingSpinner.addClass('d-none');
                        btnSimpan.prop('disabled', false);
                        if (jqXHR.status == 422) {
                            var errors = jqXHR.responseJSON;
                            var errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value);
                            });
                            alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                        } else {
                            console.error('Error saat menyimpan data pasien: ', jqXHR);
                        }
                    }
                });
            }

            // Kode pasien BPJS
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#poli_bpjs').length) {
                    $('#poli_bpjs').change(function() {
                        var poli_id = $(this).val();
                        if (poli_id) {
                            $.ajax({
                                type: "GET",
                                url: "<?php echo e(url('get-dokter-by-poli')); ?>/" + poli_id,
                                success: function(res) {
                                    if (res) {
                                        $("#dokter_bpjs").empty();
                                        $.each(res, function(key, value) {
                                            $("#dokter_bpjs").append('<option value="' +
                                                key + '">' + value + '</option>');
                                        });
                                    } else {
                                        $("#dokter_bpjs").empty();
                                    }
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching dokter BPJS data: ", jqXHR);
                                }
                            });
                        } else {
                            $("#dokter_bpjs").empty();
                        }
                    });
                } else {
                    console.error("jQuery atau elemen poli_bpjs tidak ditemukan");
                }
            });

            // Autocomplete pasien BPJS
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof $ !== 'undefined' && $('#norm').length && $.ui && $.ui.autocomplete) {
                    $('#norm').autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: '/search_pasien_bpjs',
                                method: 'GET',
                                data: {
                                    nama: request.term
                                },
                                success: function(data) {
                                    response($.map(data, function(item) {
                                        return {
                                            label: item.nama_pasien + ' - ' + item
                                                .bpjs + ' - ' + item.nik,
                                            value: item.no_rm
                                        };
                                    }));
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien BPJS data: ", jqXHR);
                                }
                            });
                        },
                        minLength: 2,
                        select: function(event, ui) {
                            $('#norm').val(ui.item.label.split(' - ')[1]);
                            var selected_no_rm = ui.item.value;

                            $.ajax({
                                url: '/get_pasien_bpjs',
                                method: 'GET',
                                data: {
                                    bpjs: selected_no_rm
                                },
                                success: function(response) {
                                    $('#nama_pasienbpjs').val(response.nama_pasien || '');
                                    $('#nikbpjs').val(response.nik || '');
                                    $('#nama_kkbpjs').val(response.nama_kk || '');
                                    $('#tgllahirbpjs').val(response.tgllahir || '');
                                    $('#jekelbpjs').val(response.jekel || '');
                                    $('#alamat_asalbpjs').val(response.alamat_asal || '');
                                    $('#pekerjaanbpjs').val(response.pekerjaan || '');
                                    $('#domisilibpjs').val(response.domisili || '');
                                    $('#noHPbpjs').val(response.noHP || '');
                                },
                                error: function(jqXHR) {
                                    console.error("Error fetching pasien BPJS details: ",
                                        jqXHR);
                                }
                            });
                            return false;
                        },
                        appendTo: "#autocompletebpjs-results"
                    });
                } else {
                    console.error("jQuery, jQuery UI, atau elemen norm tidak ditemukan");
                }
            });

            // Simpan data pasien BPJS
            function saveDataBpjs() {
                var loadingSpinner = $('#loadingSpinnerLama');
                var btnSimpan = $('#simpanBpjs');
                if (!loadingSpinner.length || !btnSimpan.length) {
                    console.error("Elemen loadingSpinnerLama atau simpanBpjs tidak ditemukan");
                    return;
                }

                loadingSpinner.removeClass('d-none');
                btnSimpan.prop('disabled', true);

                var formData = {
                    poli: document.getElementById('poli_bpjs')?.value || '',
                    dokter: document.getElementById('dokter_bpjs')?.value || '',
                    bpjs: document.getElementById('norm')?.value || '',
                    nama_pasien: document.getElementById('nama_pasienbpjs')?.value || '',
                    nik: document.getElementById('nikbpjs')?.value || '',
                    nama_kk: document.getElementById('nama_kkbpjs')?.value || '',
                    pekerjaan: document.getElementById('pekerjaanbpjs')?.value || '',
                    tgllahir: document.getElementById('tgllahirbpjs')?.value || '',
                    jekel: document.getElementById('jekelbpjs')?.value || '',
                    alamat_asal: document.getElementById('alamat_asalbpjs')?.value || '',
                    domisili: document.getElementById('domisilibpjs')?.value || '',
                    noHP: document.getElementById('noHPbpjs')?.value || ''
                };

                var errorMessages = [];
                if (!formData.poli) errorMessages.push("- Poli harus dipilih.");
                if (!formData.dokter) errorMessages.push("- Dokter harus dipilih.");
                if (!formData.bpjs) errorMessages.push("- No. BPJS harus diisi.");

                if (errorMessages.length > 0) {
                    loadingSpinner.addClass('d-none');
                    btnSimpan.prop('disabled', false);
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return;
                }

                $.ajax({
                    url: '/perawat/store-bpjs',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            console.error('No redirect URL provided in the server response.');
                        }
                    },
                    error: function(jqXHR) {
                        loadingSpinner.addClass('d-none');
                        btnSimpan.prop('disabled', false);
                        if (jqXHR.status == 422) {
                            var errors = jqXHR.responseJSON;
                            var errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value);
                            });
                            alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                        } else {
                            console.error('Error saat menyimpan data pasien BPJS: ', jqXHR);
                        }
                    }
                });
            }
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/perawat/index.blade.php ENDPATH**/ ?>
