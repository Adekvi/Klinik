<?php $__currentLoopData = $video; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editpoli<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Edit Poli</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('admin/edit/video/' . $item->id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_rm">Judul</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="title" id="title"
                                        value="<?php echo e($item->title ?? '-'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_rm">Status</label>
                                    <select name="status" id="status" class="form-control mt-2 mb-2">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Aktif" <?php echo e($item->status == 'Aktif' ? 'selected' : ''); ?>>Aktif
                                        </option>
                                        <option value="Nonaktif <?php echo e($item->status == 'Nonaktif' ? 'selected' : ''); ?>">
                                            Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="video">Upload Video</label>

                                    
                                    <?php if(!empty($item->video)): ?>
                                        <div class="mb-2">
                                            <video width="320" height="240" controls>
                                                <source src="<?php echo e(Storage::url('video/' . $item->video)); ?>"
                                                    type="video/mp4">
                                                Browser kamu tidak mendukung tag video.
                                            </video>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <input type="file" class="form-control mt-2 mb-2" name="video" id="video"
                                        accept="video/*">
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
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/master/datavideo/modaledit.blade.php ENDPATH**/ ?>