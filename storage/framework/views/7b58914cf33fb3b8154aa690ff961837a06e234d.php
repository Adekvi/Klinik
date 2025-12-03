<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Admin | Data Diagnosa']); ?>
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
                            <h4><strong>Data Diagnosa</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#tambahdiagnosa"><i class="fas fa-plus"></i> Tambah Data
                                Diagnosa</button>
                            <hr>
                            <div class="page d-flex" style="justify-content: space-between">
                                <form method="GET" action="<?php echo e(route('master.diagnosa')); ?>"
                                    class="d-flex justify-content-between align-items-center mb-3">
                                    <input type="hidden" name="page" value="1"> 
                                    <div class="d-flex align-items-center">
                                        <label for="entries" class="me-2">Tampilkan:</label>
                                        <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" <?php echo e(request('entries', 10) == 10 ? 'selected' : ''); ?>>
                                                10
                                            </option>
                                            <option value="25" <?php echo e(request('entries') == 25 ? 'selected' : ''); ?>>25
                                            </option>
                                            <option value="50" <?php echo e(request('entries') == 50 ? 'selected' : ''); ?>>50
                                            </option>
                                            <option value="100" <?php echo e(request('entries') == 100 ? 'selected' : ''); ?>>100
                                            </option>
                                        </select>
                                    </div>
                                </form>

                                <div class="cari mb-2">
                                    <input type="text" name="search" id="search" class="form-control"
                                        placeholder="Cari..." style="width: 100%">
                                </div>
                            </div>

                            <div class="tb-umum">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Diagnosa</th>
                                            <th>Nama Diagnosa</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="diagnosa-table">
                                        <?php echo $__env->make('admin.master.diagnosa.table', ['diagnosa' => $diagnosa], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </tbody>
                                </table>

                                <div class="halaman mt-2 d-flex justify-content-end">
                                    <?php echo e($diagnosa->appends(['entries' => $entries])->links()); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.master.diagnosa.modaltambah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.master.diagnosa.modaledit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.master.diagnosa.modalhapus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startPush('style'); ?>
        
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
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
            $(document).ready(function() {
                $('#search').on('input', function() {
                    var query = $(this).val();
                    $.ajax({
                        url: "<?php echo e(route('diagnosa.search')); ?>",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#diagnosa-table').html(data);
                        }
                    });
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
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/master/diagnosa/index.blade.php ENDPATH**/ ?>