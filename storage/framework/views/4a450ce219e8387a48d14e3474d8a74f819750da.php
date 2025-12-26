<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Perawat | Rekap Diagnosa']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="diagnosa-banyak">
                    <div class="title">
                        <h5><strong>Daftar 30 Diagnosa Terbayak</strong></h5>
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
                                        <form method="GET" action="" class="row g-3 align-items-end">
                                            <div class="col-md-4">
                                                <label for="start_date">Tanggal Awal</label>
                                                <input type="date" name="start_date" id="start_date"
                                                    class="form-control" value="<?php echo e(request()->query('start_date')); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="end_date">Tanggal Akhir</label>
                                                <input type="date" name="end_date" id="end_date"
                                                    class="form-control" value="<?php echo e(request()->query('end_date')); ?>">
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary"
                                                    style="margin-right: 10px">
                                                    <i class="fa fa-search me-1"></i> Tampilkan
                                                </button>
                                                <a href="<?php echo e(route('perawat.diagnosa')); ?>"
                                                    class="btn btn-secondary ml-2">
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
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('perawat.diagnosa.export', [
                                                                'start_date' => request()->query('start_date'),
                                                                'end_date' => request()->query('end_date'),
                                                            ])); ?>">Export
                                                            to Excel</a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <h5 class="mb-3 text-muted">
                                <strong>
                                    <li>Data Diagnosa</li>
                                </strong>
                            </h5>
                            <div class="sortir">
                                <div class="row">
                                    <form method="GET" action="<?php echo e(route('perawat.diagnosa')); ?>"
                                        class="d-flex justify-content-between align-items-center mb-3">
                                        <input type="hidden" name="page" value="1">
                                        <!-- Reset ke halaman 1 saat filter -->
                                        <div class="d-flex align-items-center">
                                            <label for="entries" class="me-2">Tampilkan:</label>
                                            <select name="entries" id="entries"
                                                class="form-select form-select-sm me-3" style="width: 80px;"
                                                onchange="this.form.submit()">
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
                                            <input type="text" name="search"
                                                class="form-control form-control-sm me-2" value="<?php echo e($search ?? ''); ?>"
                                                placeholder="Cari Diagnosa" style="width: 200px;">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-magnifying-glass"></i> Cari
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table mt-2 mb-2 table-striped table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle">NO
                                            </th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle">
                                                TANGGAL
                                            </th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle">JAM
                                            </th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle">
                                                PENYAKIT
                                            </th>
                                            <th colspan="3" style="text-align: center">JUMLAH KASUS BARU</th>
                                        </tr>
                                        <tr>
                                            <th style="white-space: nowrap">LAKI-LAKI</th>
                                            <th>PEREMPUAN</th>
                                            <th>JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php $__currentLoopData = $groupedDiagnoses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td style="white-space: nowrap">
                                                    <?php echo e(\Carbon\Carbon::parse($item['created_at'])->format('d-m-Y')); ?>

                                                </td>
                                                <td><?php echo e(\Carbon\Carbon::parse($item['created_at'])->format('H:i')); ?>

                                                </td>
                                                <td><?php echo e($item['diagnosa']); ?></td>
                                                <td><?php echo e($item['laki_laki']); ?></td>
                                                <td><?php echo e($item['perempuan']); ?></td>
                                                <td><?php echo e($item['jumlah']); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/perawat/rekap/diagnosa.blade.php ENDPATH**/ ?>