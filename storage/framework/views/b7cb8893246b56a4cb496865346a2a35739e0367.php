    <?php
    if (!function_exists('Rupiah')) {
        function Rupiah($angka)
        {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }
    }
    ?>

<?php $__currentLoopData = $obat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $stokTerakhir = $item->stok;
?>
<tr class="text-center align-middle" style="white-space: nowrap;">
    <td><?php echo e(($obat->currentPage() - 1) * $obat->perPage() + $loop->iteration); ?></td>
    <td><?php echo e($item->golongan ?? '-'); ?></td>
    <td><?php echo e($item->jenis_sediaan); ?></td>
    <td><?php echo e($item->nama_obat); ?></td>
    <td><?php echo e($item->harga_pokok ? Rupiah($item->harga_pokok) : '0'); ?></td>
    <td><?php echo e(Rupiah($item->harga_jual)); ?></td>
    <td><?php echo e($item->keluar ?? '0'); ?></td>
    <td><?php echo e($item->retur ?? '0'); ?></td>
    <td><?php echo e($stokTerakhir); ?></td>
    <td>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <!-- Detail Obat -->
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailObat<?php echo e($item->id); ?>">
                <i class="fa-solid fa-info-circle"></i> Detail
            </button>

            <!-- Edit & Hapus -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editobat<?php echo e($item->id); ?>">
                <i class="fa-solid fa-cart-shopping"></i> Stok
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusobat<?php echo e($item->id); ?>">
                <i class="fa-solid fa-trash"></i> Hapus
            </button>
        </div>

        <!-- Modal Detail Obat -->
      <!-- Modal Detail Obat -->
<div class="modal fade" id="detailObat<?php echo e($item->id); ?>" tabindex="-1"
    aria-labelledby="detailObatLabel<?php echo e($item->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailObatLabel<?php echo e($item->id); ?>">
                    Detail Obat: <?php echo e($item->nama_obat); ?>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row gy-3">
                    <!-- Kiri: Info Obat & Distributor -->
                    <div class="col-md-8">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted">No. Faktur</dt>
                            <dd class="col-sm-8"><?php echo e($item->no_faktur ?? '-'); ?></dd>

                            <dt class="col-sm-4 text-muted">Distributor</dt>
                            <dd class="col-sm-8"><?php echo e($item->nama_distributor ?? '-'); ?></dd>

                            <dt class="col-sm-4 text-muted">Telepon</dt>
                            <dd class="col-sm-8"><?php echo e($item->hp_distributor ?? '-'); ?></dd>


                            <dt class="col-sm-4 text-muted">Nama Obat</dt>
                            <dd class="col-sm-8 fw-semibold"><?php echo e($item->nama_obat); ?></dd>

                            <dt class="col-sm-4 text-muted">Golongan / Sediaan</dt>
                            <dd class="col-sm-8"><?php echo e($item->golongan ?? '-'); ?> / <?php echo e($item->jenis_sediaan ?? '-'); ?></dd>

                            <dt class="col-sm-4 text-muted">Harga Beli</dt>
                            <dd class="col-sm-8"><?php echo e(Rupiah($item->harga_pokok ?? 0)); ?></dd>

                            <dt class="col-sm-4 text-muted">Harga Jual</dt>
                            <dd class="col-sm-8"><?php echo e(Rupiah($item->harga_jual ?? 0)); ?></dd>
                        </dl>
                    </div>

                    <!-- Kanan: Stok Total -->
                    <div class="col-md-4 d-flex flex-column justify-content-center align-items-center border rounded p-3 bg-light">
                        <h6 class="text-secondary mb-2">Stok Total</h6>
                        <span class="display-4 fw-bold text-primary"><?php echo e($item->stok ?? 0); ?></span>
                    </div>
                </div>

                <!-- Batch Detail -->
                <h6 class="border-bottom pb-2 mt-4 mb-3 text-secondary fw-semibold">Batch Detail</h6>
                <?php if($item->details->count()): ?>
                    <div class="table-responsive rounded-3" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-sm table-bordered align-middle text-center mb-0">
                            <thead class="table-light text-uppercase small">
                                <tr>
                                    <th>Tanggal Terima</th>
                                    <th>Expired Date</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $item->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="align-middle">
                                    <td><?php echo e(\Carbon\Carbon::parse($detail->etd)->format('d M Y') ?? '-'); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($detail->expired_date)->format('d M Y') ?? '-'); ?></td>
                                    <td><?php echo e($detail->jumlah_expired ?? 0); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted fst-italic mt-3">Belum ada batch untuk obat ini.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/obat/table.blade.php ENDPATH**/ ?>