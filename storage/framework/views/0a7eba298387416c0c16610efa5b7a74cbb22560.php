<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Apoteker | Master Data Obat']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 class="text-muted mb-3">
                            <strong><?php echo $__env->yieldContent('title'); ?></strong>
                        </h5>
                        <h5 style="margin-bottom: 20px"><strong>Uploud Data Obat</strong></h5>
                        <form action="<?php echo e(route('resep.import')); ?>" method="POST" enctype="multipart/form-data"
                            id="uploadForm">
                            <?php echo csrf_field(); ?>
                            <div class="d-flex align-items-end">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Upload File Excel</label>
                                        <p style="font-size: 15px; font-style: italic; color: red">
                                            *Silahkan masukkan data obat terbaru dengan format xlsx, xls, csv. <br>
                                            *Silahkan donwload file excelnya untuk menyesuaikan format kolomnya! <br>
                                        </p>
                                        <input type="file" name="file" id="file" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <button type="submit" class="btn btn-primary" id="uploadButton">
                                        <i class="fa-solid fa-upload"></i> Upload</button>
                                    <a href="<?php echo e(route('resep.downloadTemplate')); ?>" class="btn btn-success ms-2">
                                        <i class="fa-solid fa-file-excel"></i> Download Format Excel
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Animasi Loading -->
                        <div id="loading" class="mt-3 text-primary d-none">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Mengunggah...</span>
                            </div>
                            <span class="ms-2">Mengunggah file, mohon tunggu...</span>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-flex justify-content-between align-items-center">
                                <strong>Data Obat baru diunggah</strong>
                                <span class="text-muted" style="font-size: 17px">
                                    <i class="fa-solid fa-circle-info text-success"></i> <?php echo e($uploadStatus); ?></span>
                            </h5>
                            <hr>

                            <?php if($obatUploud->count() > 0): ?>
                                <form method="GET" action="<?php echo e(route('apoteker.master.obat')); ?>"
                                    class="d-flex justify-content-between align-items-center mb-3">
                                    <input type="hidden" name="recent_page" value="1"> 
                                    <div class="d-flex align-items-center">
                                        <label for="entries" class="me-2">Tampilkan:</label>
                                        <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" <?php echo e(request('entries', 10) == 10 ? 'selected' : ''); ?>>
                                                10
                                            </option>
                                            <option value="25" <?php echo e(request('entries', 10) == 25 ? 'selected' : ''); ?>>
                                                25
                                            </option>
                                            <option value="50" <?php echo e(request('entries', 10) == 50 ? 'selected' : ''); ?>>
                                                50
                                            </option>
                                            <option value="100"
                                                <?php echo e(request('entries', 10) == 100 ? 'selected' : ''); ?>>100
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                            class="form-control form-control-sm me-2" style="width: 400px;"
                                            placeholder="Cari Obat">
                                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                                    </div>
                                </form>

                                <div class="table-responsive mb-2">
                                    <table id="example" class="table table-striped table-bordered"
                                        style="width:100%; margin-top: 10px;">
                                        <thead class="table-primary" style="text-align: center; white-space: nowrap">
                                            <tr>
                                                <th>NO</th>
                                                <th>GOLONGAN</th>
                                                <th>JENIS SEDIAAN</th>
                                                <th>NAMA OBAT</th>
                                                <th>HARGA BELI</th>
                                                <th>HARGA JUAL</th>
                                                <th>OBAT MASUK</th>
                                                <th>OBAT KELUAR</th>
                                                <th>RETUR</th>
                                                <th>JUMLAH STOK</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            if (!function_exists('Rupiah')) {
                                                function Rupiah($angka)
                                                {
                                                    return 'Rp ' . number_format($angka, 0, ',', '.');
                                                }
                                            }
                                            ?>
                                            <?php $__currentLoopData = $obatUploud; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($obatUploud->firstItem() + $index); ?></td>
                                                    <td><?php echo e(!empty($record->golongan) ? $record->golongan : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->jenis_sediaan) ? $record->jenis_sediaan : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($record->nama_obat) ? $record->nama_obat : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty(Rupiah($record->harga_pokok)) ? Rupiah($record->harga_pokok) : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty(Rupiah($record->harga_jual)) ? Rupiah($record->harga_jual) : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($record->stok_awal) ? $record->stok_awal : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($record->masuk) ? $record->masuk : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->keluar) ? $record->noHP : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->stok) ? $record->stok : '-'); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="page d-flex justify-content-end">
                                    <?php echo e($obatUploud->appends(request()->only(['search', 'entries']))->links()); ?>

                                </div>
                            <?php else: ?>
                                
                                <div class="alert alert-warning mt-3 text-center">
                                    <h5 class="mt-3 mb-3">
                                        <strong>
                                            <i class="fa-solid fa-bell"></i> Belum ada data obat yang diunggah dalam 24
                                            jam
                                            terakhir.
                                        </strong>
                                    </h5>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h5>
                                    <strong>Data Semua Obat</strong>
                                </h5>
                                <hr>
                                <div class="mb-1" style="display: flex; justify-content: space-between">
                                    <div class="tambah">
                                        <button type="button" class="btn btn-primary rounded-pill"
                                            data-bs-toggle="modal" data-bs-target="#tambahobat"><i
                                                class="fas fa-plus"></i> Tambah Obat</button>
                                    </div>
                                    <div class="cari" style="display: flex; align-items: center; gap: 5px;">
                                        <input type="text" name="search" id="search" class="form-control"
                                            placeholder="Cari..." style="width: 200px;">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div class="tb-umum">
                                    <table id="example" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead class="table-primary text-center" style="white-space: nowrap">
                                            <tr>
                                                <th>NO</th>
                                                <th>GOLONGAN</th>
                                                <th>JENIS SEDIAAN</th>
                                                <th>NAMA OBAT</th>
                                                <th>HARGA BELI</th>
                                                <th>HARGA JUAL</th>
                                                <th>OBAT MASUK</th>
                                                <th>OBAT KELUAR</th>
                                                <th>RETUR</th>
                                                <th>JUMLAH STOK</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody id="obat-table">
                                            <?php echo $__env->make('obat.master.dataobat.table', ['obat' => $obat], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="pagination d-flex justify-content-end mt-2">
                                <?php echo e($obat->appends(request()->input())->onEachSide(1)->links()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('obat.master.dataobat.tambah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('obat.master.dataobat.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('obat.master.dataobat.hapus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">

        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }

            #stok_warning {
                background-color: #ffe5e5;
                border: 1px solid red;
                padding: 10px;
                border-radius: 5px;
            }

            .tooltip-icon {
                position: relative;
                cursor: pointer;
            }

            .tooltip-icon:hover::after {
                content: 'Stok berada di bawah 50! Segera tambahkan stok.';
                position: absolute;
                background-color: #f8d7da;
                color: #721c24;
                padding: 5px;
                border-radius: 5px;
                top: -30px;
                left: 50%;
                transform: translateX(-50%);
                white-space: nowrap;
                font-size: 12px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
                z-index: 10;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // new DataTable('#example');
            $('#search').on('input', function() {
                var query = $(this).val();

                if (query == "") {
                    location.reload();
                    return;
                }

                $.ajax({
                    url: "<?php echo e(route('apoteker.obat.cari')); ?>",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#obat-table').html(data.html);
                        $('.pagination').hide();
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                <?php if($lowStockObat->isNotEmpty()): ?>
                    Swal.fire({
                        title: 'Peringatan Stok Rendah!',
                        html: `
                            <div style="text-align: left;">
                                <strong>*Obat dengan stok di bawah 50 :</strong>
                                <ul style="list-style: none; padding: 0; margin-top: 10px">
                                    <?php $__currentLoopData = $lowStockObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                            <label style="flex: 1; word-wrap: break-word; margin-right: 10px;"><?php echo e($item->nama_obat); ?></label>
                                            <span style="min-width: 50px; text-align: right;">:</span>
                                            <strong style="min-width: 100px; text-align: right;"><?php echo e($item->stok); ?></strong>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        `,
                        icon: 'warning',
                        confirmButtonText: 'Tutup',
                        customClass: {
                            popup: 'swal-wide'
                        }
                    });
                <?php endif; ?>
            });

            document.getElementById('uploadForm').addEventListener('submit', function() {
                // Nonaktifkan tombol upload agar tidak diklik berulang
                document.getElementById('uploadButton').disabled = true;

                // Tampilkan animasi loading
                document.getElementById('loading').classList.remove('d-none');
            });

            // Simulasi notifikasi sukses setelah upload (Opsional)
            setTimeout(() => {
                document.getElementById('loading').classList.add('d-none');
                document.getElementById('notifSuccess').classList.remove('d-none');
            }, 5000); // Simulasi 5 detik setelah upload dimulai
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/obat/master/dataobat/dataObatApoteker.blade.php ENDPATH**/ ?>