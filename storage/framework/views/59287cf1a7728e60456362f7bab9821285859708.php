<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Admin | Data Semua Pasien']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h4><strong>Upload Data Pasien</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card upload">
                        <div class="card-body">
                            <form action="<?php echo e(route('pasien.import')); ?>" method="POST" enctype="multipart/form-data"
                                id="uploadForm">
                                <?php echo csrf_field(); ?>
                                <div class="d-flex align-items-end">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="fw-bold">Upload File Excel</label>
                                            <p style="font-size: 15px; font-style: italic; color: red">
                                                *Silahkan masukkan data pasien terbaru dengan format xlsx, xls, csv.
                                                <br>
                                                *Silahkan donwload file excelnya untuk menyesuaikan kolomnya! <br>
                                                *Nomor RM diambil dari nomor RM terakhir!
                                            </p>
                                            <input type="file" name="file" id="file" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="ms-2">
                                        <button type="submit" class="btn btn-primary" id="uploadButton">
                                            <i class="fa-solid fa-upload"></i> Upload</button>
                                        <a href="<?php echo e(route('pasien.downloadTemplate')); ?>" class="btn btn-success ms-2">
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
                    </div>

                    <div class="card diunggah mt-3">
                        <div class="card-body">
                            <h3 class="d-flex justify-content-between align-items-center">
                                <strong>Data Pasien baru diunggah</strong>
                                <span class="text-muted" style="font-size: 17px">
                                    <i class="fa-solid fa-circle-info text-success"></i> <?php echo e($uploadStatus); ?></span>
                            </h3>

                            <?php if($recentPatients->count() > 0): ?>
                                <form method="GET" action="<?php echo e(route('master.semuadata')); ?>"
                                    class="d-flex justify-content-between align-items-center mb-3">
                                    <input type="hidden" name="recent_page" value="1"> 
                                    <div class="d-flex align-items-center">
                                        <label for="recent_entries" class="me-2">Tampilkan:</label>
                                        <select name="recent_entries" id="recent_entries"
                                            class="form-select form-select-sm me-3" style="width: 80px;"
                                            onchange="this.form.submit()">
                                            <option value="10"
                                                <?php echo e(request('recent_entries', 10) == 10 ? 'selected' : ''); ?>>
                                                10
                                            </option>
                                            <option value="25"
                                                <?php echo e(request('recent_entries') == 25 ? 'selected' : ''); ?>>25
                                            </option>
                                            <option value="50"
                                                <?php echo e(request('recent_entries') == 50 ? 'selected' : ''); ?>>50
                                            </option>
                                            <option value="100"
                                                <?php echo e(request('recent_entries') == 100 ? 'selected' : ''); ?>>100
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <input type="text" name="recent_search"
                                            value="<?php echo e(request('recent_search')); ?>"
                                            class="form-control form-control-sm me-2" style="width: 400px;"
                                            placeholder="Cari Nama/NIK/No. Rm (Data Baru)">
                                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                                    </div>
                                </form>

                                <div class="table-responsive mb-2">
                                    <table id="example" class="table table-striped table-bordered"
                                        style="width:100%; margin-top: 10px;">
                                        <thead class="table-primary" style="text-align: center; white-space: nowrap">
                                            <tr>
                                                <th>No</th>
                                                <th>No. RM</th>
                                                <th>Nama Pasien</th>
                                                <th>NIK</th>
                                                <th>Nama Kepala Keluarga</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Pekerjaan</th>
                                                <th>Alamat</th>
                                                <th>No. HP</th>
                                                <th>Jenis Pasien</th>
                                                <th>No. BPJS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php $__currentLoopData = $recentPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($recentPatients->firstItem() + $index); ?></td>
                                                    <td><?php echo e($record->no_rm); ?></td>
                                                    <td><?php echo e(!empty($record->nama_pasien) ? $record->nama_pasien : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($record->nik) ? $record->nik : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->nama_kk) ? $record->nama_kk : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->tgllahir) ? $record->tgllahir : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->jekel) ? $record->jekel : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->pekerjaan) ? $record->pekerjaan : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($record->alamat_asal) ? $record->alamat_asal : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($record->noHP) ? $record->noHP : '-'); ?></td>
                                                    <td><?php echo e(!empty($record->jenis_pasien) ? $record->jenis_pasien : '-'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($record->bpjs) ? $record->bpjs : '-'); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="page d-flex justify-content-end">
                                    <?php echo e($recentPatients->appends(request()->only(['recent_search', 'recent_entries']))->links()); ?>

                                </div>
                            <?php else: ?>
                                
                                <div class="alert alert-warning mt-3 text-center">
                                    <h5 class="mt-3 mb-3">
                                        <strong>
                                            <i class="fa-solid fa-bell"></i> Belum ada data pasien yang diunggah dalam
                                            24 jam
                                            terakhir.
                                        </strong>
                                    </h5>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card semua-pasien mt-3">
                        <div class="card-body">
                            <h3><strong>Data Semua Pasien</strong></h3>
                            
                            <form method="GET" action="<?php echo e(route('master.semuadata')); ?>"
                                class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <label for="entries" class="me-2">Tampilkan:</label>
                                    <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                        style="width: 80px;" onchange="this.form.submit()">
                                        <option value="10" <?php echo e($entries == 10 ? 'selected' : ''); ?>>10</option>
                                        <option value="25" <?php echo e($entries == 25 ? 'selected' : ''); ?>>25</option>
                                        <option value="50" <?php echo e($entries == 50 ? 'selected' : ''); ?>>50</option>
                                        <option value="100" <?php echo e($entries == 100 ? 'selected' : ''); ?>>100</option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center">
                                    <input type="text" name="search" value="<?php echo e($search); ?>"
                                        class="form-control form-control-sm me-2" style="width: 400px;"
                                        placeholder="Cari Nama/NIK">
                                    <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                                </div>
                            </form>
                            <div class="table-responsive mb-2">
                                <table id="example" class="table table-striped table-bordered"
                                    style="width:100%; margin-top: 10px;">
                                    <thead class="table-primary" style="text-align: center; white-space: nowrap">
                                        <tr>
                                            <th>No</th>
                                            <th>No. RM</th>
                                            <th>Nama Pasien</th>
                                            <th>NIK</th>
                                            <th>Nama Kepala Keluarga</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Pekerjaan</th>
                                            <th>Alamat</th>
                                            <th>No. HP</th>
                                            <th>Jenis Pasien</th>
                                            <th>No. BPJS</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php $__empty_1 = true; $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($pasien->firstItem() + $index); ?></td>
                                                <td><?php echo e($item->no_rm); ?></td>
                                                <td><?php echo e(!empty($item->nama_pasien) ? $item->nama_pasien : '-'); ?></td>
                                                <td><?php echo e(!empty($item->nik) ? $item->nik : '-'); ?></td>
                                                <td><?php echo e(!empty($item->nama_kk) ? $item->nama_kk : '-'); ?></td>
                                                <td><?php echo e(!empty($item->tgllahir) ? $item->tgllahir : '-'); ?></td>
                                                <td><?php echo e(!empty($item->jekel) ? $item->jekel : '-'); ?></td>
                                                <td><?php echo e(!empty($item->pekerjaan) ? $item->pekerjaan : '-'); ?></td>
                                                <td><?php echo e(!empty($item->alamat_asal) ? $item->alamat_asal : '-'); ?></td>
                                                <td><?php echo e(!empty($item->noHP) ? $item->noHP : '-'); ?></td>
                                                <td><?php echo e(!empty($item->jenis_pasien) ? $item->jenis_pasien : '-'); ?></td>
                                                <td><?php echo e(!empty($item->bpjs) ? $item->bpjs : '-'); ?></td>
                                                <td>
                                                    <div class="aksi d-flex">
                                                        
                                                        <button type="button" class="btn btn-danger mx-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hapusbpjs<?php echo e($item->id); ?>">
                                                            <i class="fas fa-trash"></i> Hapus</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="13" class="text-center">Tidak ada data ditemukan</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="halaman mt-2 d-flex justify-content-end">
                                <?php echo e($pasien->appends(request()->only(['search', 'entries']))->links()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.master.semuapasien.modalhapus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">

        <style>
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
        <script>
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

            // jam dan tgl
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
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/master/semuapasien/index.blade.php ENDPATH**/ ?>