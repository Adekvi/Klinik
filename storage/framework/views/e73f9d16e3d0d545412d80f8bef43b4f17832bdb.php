<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Informasi']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card-title">
                <div class="judul d-flex justify-content-between align-items-center">
                    <h4><strong>Informasi</strong></h4>
                    <div class="date-time d-flex align-items-center gap-2 text-center">
                        <div class="tanggal text-muted" id="tanggal"></div>
                        <div class="jam text-muted" id="jam"></div>
                    </div>
                </div>
            </div>

            <!-- Basic Layout -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Informasi Perangkat</h5>
                                    <small class="text-muted float-end">Perangkat Keras</small>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">Device</label>
                                        <input type="text" class="form-control" id="basic-default-fullname"
                                            value="<?php echo e($deviceInfo['device']); ?>" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-company">OS</label>
                                        <input type="text" class="form-control" id="basic-default-company"
                                            value="<?php echo e($deviceInfo['os']); ?>" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-message">User Agent</label>
                                        <input type="text" class="form-control" id="basic-default-company"
                                            value="<?php echo e($deviceInfo['userAgent']); ?>" readonly />
                                    </div>
                                </div>
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
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/profil/info.blade.php ENDPATH**/ ?>