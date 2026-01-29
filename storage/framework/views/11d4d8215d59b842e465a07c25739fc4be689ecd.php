<?php $__currentLoopData = $anjuran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editpoli<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-dark" id="staticBackdropLabel">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('admin/master/anjuran-edit/' . $item->id)); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Anjuran</label>
                                    <input type="text" name="kode_anjuran" id="kode_anjuran"
                                        value="<?php echo e($item->kode_anjuran); ?>" class="form-control mt-2 mb-2"
                                        placeholder="Nama Anjuran Minum">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Golongan</label>
                                    <input type="text" name="golongan" id="golongan" value="<?php echo e($item->golongan); ?>"
                                        class="form-control mt-2 mb-2" placeholder="Golongan">
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
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/dataanjuran/edit.blade.php ENDPATH**/ ?>