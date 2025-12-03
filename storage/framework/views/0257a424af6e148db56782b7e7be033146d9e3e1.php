<?php $__currentLoopData = $aturan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editpoli<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-dark" id="staticBackdropLabel">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('admin/master/aturan-edit/' . $item->id)); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Aturan Minum</label>
                                    <input type="text" name="aturan_minum" id="aturan_minum"
                                        value="<?php echo e($item->aturan_minum ?? '-'); ?>" class="form-control mt-2 mb-2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Takaran</label>
                                    <input type="text" name="takaran" id="takaran"
                                        value="<?php echo e($item->takaran ?? '-'); ?>" class="form-control mt-2 mb-2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan"
                                        value="<?php echo e($item->keterangan ?? '-'); ?>" class="form-control mt-2 mb-2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="status" class="form-control mb-2 mt-2">
                                        <option value="">-- Status --</option>
                                        <option value="Aktif" <?php echo e($item->status == 'Aktif' ? 'selected' : ''); ?>>Aktif
                                        </option>
                                        <option value="Non-aktif" <?php echo e($item->status == 'Non-aktif' ? 'selected' : ''); ?>>
                                            Non-aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/master/dataaturan/edit.blade.php ENDPATH**/ ?>