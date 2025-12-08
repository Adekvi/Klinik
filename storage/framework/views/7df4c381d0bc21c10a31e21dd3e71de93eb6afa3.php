<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Apoteker | Data Aturan Obat']); ?>
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
                            <h5 class="mb-4"><strong>Data Aturan Obat</strong></h5>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#poto"><i class="fas fa-plus"></i> Tambah</button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tb-umum">
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
                                            class="form-control form-control-sm me-2" style="width: 200px;"
                                            placeholder="Cari ...">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                    </div>
                                </form>
                                <table class="table table-striped table-responsive"
                                    style="width:100%; text-align: center">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Aturan Minum</th>
                                            <th>Takaran</th>
                                            
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($aturan) == 0): ?>
                                            <tr>
                                                <td class="text-center" colspan="5">Tidak ada data</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $aturan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($aturan->firstItem() + $index); ?></td>
                                                    <td><?php echo e($item->aturan_minum); ?></td>
                                                    <td><?php echo e($item->takaran ?? '-'); ?></td>
                                                    
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
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="halaman d-flex justify-content-end mt-2">
                                <?php echo e($aturan->appends(request()->only(['search', 'entries']))->links()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('obat.master.aturanMinum.tambah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('obat.master.aturanMinum.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('obat.master.aturanMinum.hapus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
        <style>
            .status-toggle {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }

            .toggle-label {
                position: relative;
                width: 60px;
                height: 28px;
                background-color: #ccc;
                border-radius: 50px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                display: block;
            }

            .toggle-label::before {
                content: "";
                position: absolute;
                top: 4px;
                left: 4px;
                width: 20px;
                height: 20px;
                background-color: white;
                border-radius: 50%;
                transition: transform 0.3s ease;
            }

            input[type="checkbox"] {
                display: none;
            }

            input[type="checkbox"]:checked+.toggle-label {
                background-color: #007bff;
            }

            input[type="checkbox"]:checked+.toggle-label::before {
                transform: translateX(32px);
            }

            .status-text {
                font-weight: bold;
                font-size: 14px;
                color: #777;
            }

            .status-text.active {
                color: green;
            }

            .status-text.inactive {
                color: #888;
            }

            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script>
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
<?php /**PATH C:\xampp\htdocs\Klinik\resources\views/obat/master/aturanMinum/index.blade.php ENDPATH**/ ?>