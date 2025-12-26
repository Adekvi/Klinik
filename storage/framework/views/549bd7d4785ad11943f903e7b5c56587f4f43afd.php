<?php $__currentLoopData = $ttd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editpoli<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Foto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('admin/edit/master-ttd/' . $item->id)); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Tenaga Medis</label>
                            <input type="text" class="form-control mt-2 mb-2" name="id_medis" id="id_medis"
                                placeholder="Masukkan Nama Tenaga Medis" value="<?php echo e($item->nama); ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFoto">Foto</label>
                            <input type="file" class="form-control mb-2 mt-2" name="foto" id="exampleInputFoto">
                            <small class="form-text text-muted" id="foto"></small>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Status</label>
                            <select name="status" id="status" class="form-control mb-2 mt-2">
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
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
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/ttdMedis/modaledit.blade.php ENDPATH**/ ?>