<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Admin | Kelola Pesan']); ?>
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
                            <h4><strong>Kelola Pesan</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="#"
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
                                        placeholder="Cari Username">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <div class="tb-umum">
                                    <table class="table table-striped table-bordered" style="white-space: nowrap">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Pesan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($pesan->isEmpty()): ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">Tidak ada pesan</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $pesan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($pesan->firstItem() + $index); ?></td>
                                                        <td><?php echo e($item->user->username); ?></td>
                                                        <td><?php echo e($item->message); ?></td>
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
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="halaman d-flex justify-content-end">
                                <?php echo e($pesan->appends(request()->only(['search', 'entries']))->links()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('script'); ?>
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
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/rekapan/chat/index.blade.php ENDPATH**/ ?>