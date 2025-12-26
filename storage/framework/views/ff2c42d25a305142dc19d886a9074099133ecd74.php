<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Admin | Tanda Tangan Medis']); ?>
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
                            <h4><strong>TTD Tenaga Medis</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#poto"><i class="fas fa-plus"></i> Tambah TTD</button>
                            <hr>
                            <div class="tb-umum">
                                <table id="example" class="table table-striped table-bordered"
                                    style="width:100%; text-align: center">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $ttd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td class="text-center">
                                                    <?php if(!$item->foto): ?>
                                                        -
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($item->nama); ?></td>
                                                <td>
                                                    <form method="POST" action="<?php echo e(url('status-ttd')); ?>"
                                                        style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="id"
                                                            value="<?php echo e($item->id); ?>">
                                                        <div class="piket">
                                                            <label class="switch">
                                                                <input type="checkbox" name="status"
                                                                    id="status_<?php echo e($item->id); ?>"
                                                                    onchange="this.form.submit()"
                                                                    <?php if($item->status): ?> checked <?php endif; ?>>
                                                                <span class="slider"></span>
                                                            </label>
                                                            <div class="status-text">
                                                                <span
                                                                    id="statusText"><?php echo e($item->status ? 'Aktif' : 'Non-Aktif'); ?></span>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <div class="aksi d-flex justify-content-center">
                                                        <button class="btn btn-primary"
                                                            data-bs-target="#editpoli<?php echo e($item->id); ?>"
                                                            data-bs-toggle="modal"><i class="fas fa-info"></i>
                                                            Edit</button>
                                                        <button type="button" class="btn btn-danger mx-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hapuspoli<?php echo e($item->id); ?>"><i
                                                                class="fa fa-trash"></i> Hapus</button>
                                                    </div>
                                                </td>
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

    <?php echo $__env->make('admin.master.ttdMedis.modaltambah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.master.ttdMedis.modaledit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.master.ttdMedis.modalhapus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Modal -->
    <div id="imageModal"
        style="display: none; position: fixed; z-index: 1; left: 0; top: 15%; width: 100%; height: auto%; overflow: auto;">
        <span onclick="closeModal()"
            style="position: absolute; top: 10px; right: 25px; color: #fff; font-size: 35px; font-weight: bold; cursor: pointer;">&times;</span>
        <img id="modalImage" style="margin: auto; display: block; width: 80%; max-width: 700px;">
    </div>

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
        <style>
            /* Flexbox untuk vertical center */
            .piket {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* Switch wrapper */
            .switch {
                position: relative;
                display: inline-block;
                width: 55px;
                height: 28px;
            }

            /* Hide checkbox */
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            /* Slider */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #d2d2d2;
                transition: 0.4s;
                border-radius: 34px;
            }

            /* Slider circle */
            .slider::before {
                position: absolute;
                content: "";
                height: 20px;
                width: 20px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: 0.4s;
                border-radius: 50%;
            }

            /* When checked */
            .switch input:checked+.slider {
                background-color: #007bff;
                /* Biru lebih enak */
            }

            /* Geser bulatan */
            .switch input:checked+.slider::before {
                transform: translateX(26px);
            }

            /* Status text */
            .status-text {
                margin-top: 8px;
                font-weight: 600;
                color: #555;
                font-size: 14px;
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

            // Ambil elemen input file
            var inputFoto = document.getElementById('exampleInputFoto');

            // Tambahkan event listener untuk 'change' event
            inputFoto.addEventListener('change', function(event) {
                // Ambil nama file yang dipilih
                var namaFile = event.target.files[0].name;

                // Tampilkan nama file di dalam elemen dengan id 'namaFoto'
                document.getElementById('foto').textContent = namaFile;
            });

            // foto
            function openModal(imageSrc) {
                var modal = document.getElementById('imageModal');
                var modalImg = document.getElementById('modalImage');
                modal.style.display = 'block';
                modalImg.src = imageSrc;
            }

            function closeModal() {
                var modal = document.getElementById('imageModal');
                modal.style.display = 'none';
            }

            // Close the modal when clicking outside of the image
            window.onclick = function(event) {
                var modal = document.getElementById('imageModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/ttdMedis/index.blade.php ENDPATH**/ ?>