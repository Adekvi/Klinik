<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Admin | Data Tenaga Medis']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="datadokter">
                    <div class="card-title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h4><strong>Data Tenaga Medis</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#tambahdokter"><i class="fas fa-plus"></i> Tambah Tenaga Medis</button>
                            <hr>
                            <div class="table-responsive">
                                <div class="tb-umum">
                                    <table class="table table-striped table-bordered" style="white-space: nowrap">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Poli</th>
                                                <th>Nik</th>
                                                <th>Nama Tenaga Medis</th>
                                                <th>Profesi</th>
                                                <th>Tarif Jasa</th>
                                                <th>Status Akun</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!function_exists('Rupiah')) {
                                                function Rupiah($angka)
                                                {
                                                    return 'Rp ' . number_format($angka, 2, ',', '.');
                                                }
                                            }
                                            ?>
                                            <?php $__currentLoopData = $dokter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <?php if(!empty($item->poli->namapoli)): ?>
                                                        <td><?php echo e($item->poli->namapoli); ?></td>
                                                    <?php else: ?>
                                                        <td style="text-align: center"> - </td>
                                                    <?php endif; ?>
                                                    <?php if(!empty($item->nik)): ?>
                                                        <td><?php echo e($item->nik); ?></td>
                                                    <?php else: ?>
                                                        <td style="text-align: center"> - </td>
                                                    <?php endif; ?>
                                                    <td><?php echo e($item->nama_dokter); ?></td>
                                                    <td><?php echo e($item->profesi); ?></td>
                                                    <?php if(!empty($item->tarif)): ?>
                                                        <td><?php echo e(Rupiah($item->tarif)); ?></td>
                                                    <?php else: ?>
                                                        <td style="text-align: center"> - </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <form method="POST" action="<?php echo e(url('updateStatus-dokter')); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="id"
                                                                value="<?php echo e($item->id); ?>">
                                                            <div class="piket">
                                                                <input type="checkbox" name="status"
                                                                    id="status_<?php echo e($item->id); ?>"
                                                                    onchange="this.form.submit()"
                                                                    <?php if($item->status): ?> checked <?php endif; ?>>
                                                                <label for="status_<?php echo e($item->id); ?>"
                                                                    class="button"></label>

                                                                <!-- Status text berada di bawah tombol toggle -->
                                                                <div class="status-text">
                                                                    <span
                                                                        id="statusText"><?php echo e($item->status ? 'Aktif' : 'Non-Aktif'); ?></span>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <div class="aksi d-flex">
                                                            <button class="btn btn-primary"
                                                                data-bs-target="#editdokter<?php echo e($item->id); ?>"
                                                                data-bs-toggle="modal"><i class="fas fa-info"></i>
                                                                Edit</button>
                                                            <button type="button" class="btn btn-danger mx-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#hapusdokter<?php echo e($item->id); ?>"><i
                                                                    class="fas fa-trash"></i> Hapus</button>
                                                        </div>
                                                    </td>
                                                    <?php echo $__env->make('admin.master.datadokter.modaledit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
    </div>

    <?php echo $__env->make('admin.master.datadokter.modaltambah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.master.datadokter.modaledit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.master.datadokter.modalhapus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startPush('style'); ?>
        
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
        <style>
            /* Menyusun elemen dengan flexbox secara vertikal */
            .piket {
                display: flex;
                flex-direction: column;
                /* Menyusun elemen secara vertikal */
                align-items: center;
                /* Menyusun elemen di tengah secara horizontal */
            }

            /* Tampilan tombol */
            .button {
                width: 55px;
                height: 25px;
                background-color: #d2d2d2;
                border-radius: 200px;
                cursor: pointer;
                position: relative;
            }

            .button::before {
                position: absolute;
                content: "";
                width: 15px;
                height: 15px;
                background-color: #fff;
                border-radius: 200px;
                margin: 5px;
                transition: 0.2s;
            }

            input:checked+.button {
                background-color: blue;
            }

            input:checked+.button::before {
                transform: translateX(30px);
            }

            /* Menyembunyikan input checkbox */
            input {
                display: none;
            }

            /* Status text berada di bawah tombol */
            .status-text {
                margin-top: 10px;
                /* Memberikan jarak antara tombol dan status text */
                font-weight: bold;
                color: #333;
            }

            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
        <script>
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

            new DataTable('#example');

            // Validasi Nik
            document.addEventListener('DOMContentLoaded', function() {
                const nikInput = document.getElementById('nik');
                const nikError = document.getElementById('nik-error');

                nikInput.addEventListener('input', function() {
                    const nik = nikInput.value;

                    // Validasi panjang NIK dan memastikan hanya angka
                    if (nik.length === 16 && /^\d+$/.test(nik)) {
                        nikInput.classList.remove('is-invalid');
                        nikError.style.display = 'none';
                    } else {
                        nikInput.classList.add('is-invalid');
                        nikError.style.display = 'block';
                    }
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/datadokter/index.blade.php ENDPATH**/ ?>