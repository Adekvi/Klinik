<?php $__currentLoopData = $diagnosa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e(($diagnosa->currentPage() - 1) * $diagnosa->perPage() + $loop->iteration); ?></td>
        <td><?php echo e($item->kd_diagno); ?></td>
        <td><?php echo e($item->nm_diagno); ?></td>
        <td>
            <div class="aksi d-flex justify-content-center">
                <button data-bs-target="#editdiagnosa<?php echo e($item->id); ?>" data-bs-toggle="modal" class="btn btn-primary"><i
                        class="fas fa-info"></i> Edit</button>
                <button type="button" data-bs-target="#hapusdiagnosa<?php echo e($item->id); ?>" data-bs-toggle="modal"
                    class="btn btn-danger mx-2"><i class="fas fa-trash"></i> Hapus</button>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/diagnosa/table.blade.php ENDPATH**/ ?>