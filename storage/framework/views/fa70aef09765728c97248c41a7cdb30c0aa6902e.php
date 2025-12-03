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
        // Ambil stok terakhir dari database
        $stokTerakhir = $item->stok;

        // Hitung stok akhir berdasarkan nilai database
        $stokAkhirBaru = $stokTerakhir;
    ?>
    <tr class="text-center" style="white-space: nowrap">
        <td><?php echo e(($obat->currentPage() - 1) * $obat->perPage() + $loop->iteration); ?></td>
        <td><?php echo e($item->golongan ?? '-'); ?></td>
        <td><?php echo e($item->jenis_sediaan); ?></td>
        <td><?php echo e($item->nama_obat); ?></td>
        <td><?php echo e($item->harga_pokok ? Rupiah($item->harga_pokok) : '0'); ?></td>
        <td><?php echo e(Rupiah($item->harga_jual)); ?></td>
        
        <td><?php echo e($item->masuk ?? '0'); ?></td>
        <td><?php echo e($item->keluar ?? '0'); ?></td>
        <td><?php echo e($item->retur ?? '0'); ?></td>
        <td>
            <?php echo e($stokAkhirBaru); ?>

            <?php if($stokAkhirBaru < 50): ?>
                <span class="tooltip-icon" style="color: red; margin-left: 5px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
            <?php endif; ?>
        </td>
        <td>
            <div class="aksi d-flex" style="white-space: nowrap">
                <button type="button" data-bs-target="#editobat<?php echo e($item->id); ?>" data-bs-toggle="modal"
                    class="btn btn-primary mx-2">
                    <i class="fa-solid fa-cart-shopping"></i> Stok
                </button>
                <button type="button" data-bs-target="#hapusobat<?php echo e($item->id); ?>" data-bs-toggle="modal"
                    class="btn btn-danger mx-2">
                    <i class="fa-solid fa-trash "></i> Hapus
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/master/obat/table.blade.php ENDPATH**/ ?>