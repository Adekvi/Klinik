<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Kasir Antrian']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row demo-vertical-spacing">
            <div class="col-md-12">
                <div class="card-title">
                    <div class="judul">
                        <h4><strong>Pasien telah Bayar</strong></h4>
                        <div class="date-time d-flex align-items-center gap-2 text-center">
                            <div class="tanggal text-muted" id="tanggal"></div>
                            <div class="jam text-muted" id="jam"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="judul">
                                <h5 class="text-muted">
                                    <strong>
                                        <li>Pilih Tanggal</li>
                                    </strong>
                                </h5>
                            </div>
                            <hr>
                            <div class="col-md-10">
                                <div class="p-3">
                                    <h5 class="mb-3">Filter Rentang Tanggal</h5>
                                    <form method="GET" action="<?php echo e(route('kasir.check')); ?>"
                                        class="row g-3 align-items-end">
                                        <div class="col-md-4">
                                            <label for="start_date">Tanggal Awal</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                value="<?php echo e(request()->query('start_date')); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="end_date">Tanggal Akhir</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control"
                                                value="<?php echo e(request()->query('end_date')); ?>">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary" style="margin-right: 10px">
                                                <i class="fa fa-search me-1"></i> Tampilkan
                                            </button>
                                            <a href="<?php echo e(route('kasir.check')); ?>" class="btn btn-secondary ml-2">
                                                <i class="fa-solid fa-arrow-rotate-right"></i> Reset
                                            </a>
                                        </div>
                                        <div class="button mb-3">
                                            <div class="dropdown">
                                                <button class="btn btn-success dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-file-export"></i> Export
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('kasir.laporan.export.excel', [
                                                                'start_date' => request()->query('start_date'),
                                                                'end_date' => request()->query('end_date'),
                                                                'search' => request()->query('search'),
                                                            ])); ?>">Export
                                                            to Excel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="judul-judul">
                            <h5 class="text-muted">
                                <strong>
                                    <li>Daftar Pasien</li>
                                </strong>
                            </h5>

                            <form method="GET" action=""
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
                                        placeholder="Cari Nama/No. Rm/No. Transaksi">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped" style="white-space: nowrap;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl</th>
                                        <th>Waktu</th>
                                        
                                        <th>No. RM</th>
                                        <th>No. Transaksi</th>
                                        <th>Nama Pasien</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Jenis Pasien</th>
                                        <th>Alamat Domisili</th>
                                        <th>No. Bpjs</th>
                                        <th>Nama Kasir</th>
                                        <th>Total</th>
                                        <th>Sub Total Rincian</th>
                                        <th>Administrasi</th>
                                        <th>Konsul Dokter</th>
                                        <th>Embalase</th>
                                        <th>Total Obat</th>
                                        <th>Pajak(%)</th>
                                        <th>Bayar</th>
                                        <th>Kembalian</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" style="text-transform: uppercase">
                                    <?php
                                    // Fungsi untuk memformat harga ke dalam format Rupiah
                                    if (!function_exists('Rupiah')) {
                                        function Rupiah($angka)
                                        {
                                            return '' . number_format($angka, 0, ',', '.');
                                        }
                                    } ?>
                                    <?php if($antrianKasir->isEmpty()): ?>
                                        <tr>
                                            <td colspan="21" style="text-align: center; font-weight: bold;">Tidak ada
                                                data
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $antrianKasir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="row_<?php echo e($item->id); ?>">
                                                <td><?php echo e($loop->iteration + ($antrianKasir->currentPage() - 1) * $antrianKasir->perPage()); ?>

                                                </td>
                                                <td><?php echo e(\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')); ?>

                                                </td>
                                                <td><?php echo e(\Carbon\Carbon::parse($item->created_at)->format('H:i')); ?>

                                                </td>
                                                <td><?php echo e($item->no_rm); ?></td>
                                                <td><?php echo e($item->no_transaksi); ?></td>
                                                <td><?php echo e($item->nama_pasien); ?></td>
                                                <td><?php echo e($item->booking->pasien->jekel); ?></td>
                                                <td><?php echo e($item->jenis_pasien); ?></td>
                                                <td><?php echo e($item->booking->pasien->domisili); ?></td>
                                                <td><?php echo e($item->nik_bpjs ?? '-'); ?></td>
                                                <td><?php echo e($item->nama_kasir); ?></td>
                                                <td>Rp. <?php echo e(Rupiah($item->total)); ?></td>
                                                <td>Rp. <?php echo e(Rupiah($item->sub_total_rincian)); ?></td>
                                                <td>Rp. <?php echo e(Rupiah($item->administrasi)); ?></td>
                                                <td>Rp. <?php echo e(Rupiah($item->konsul_dokter)); ?></td>
                                                <td>Rp. <?php echo e(Rupiah($item->embalase)); ?></td>
                                                <td><?php echo e($item->total_obat); ?></td>
                                                <td><?php echo e($item->ppn ? number_format($item->ppn, 0, ',', '') : '-'); ?> %
                                                </td>
                                                <td>Rp. <?php echo e(Rupiah($item->bayar)); ?></td>
                                                <td>Rp. <?php echo e(Rupiah($item->kembalian)); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-info">
                                                        Telah Membayar
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Paginasi -->
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <?php echo e($antrianKasir->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        
        <script src="https://code.responsivevoice.org/responsivevoice.js?key=EbYPThWO"></script>
        <script src="<?php echo e(asset('assets/responsivevoice.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/antrian.script.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>

        <script>
            // tanggal dan jam
            function updateClock() {
                var now = new Date();
                var tanggalElement =
                    document.getElementById('tanggal');
                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamElement = document.getElementById('jam');
                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');
                jamElement.innerHTML = '<h6>' + jamString + '</h6>';
            }
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/kasir/check/index.blade.php ENDPATH**/ ?>