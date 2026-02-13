<?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editperawat<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Akses User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('admin/edit/user/' . $item->id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Tenaga Medis</label>
                            <select name="name" id="name" class="form-control mt-2 mb-2">
                                <option value="<?php echo e($item->name); ?>" selected><?php echo e($item->name); ?></option>
                                <?php $__currentLoopData = $dokter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dok->id); ?>"><?php echo e($dok->nama_dokter); ?> -
                                        <?php echo e($dok->profesi); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control mt-2 mb-2" name="username" id="username"
                                value="<?php echo e($item->username); ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Email</label>
                            <input type="text" class="form-control mt-2 mb-2" name="email" id="email"
                                value="<?php echo e($item->email ?? '-'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control mt-2 mb-2" name="password" id="password"
                                value="<?php echo e($item->password); ?>">
                        </div>
                        <div class="form-group">
                            <label for="role">Role Akses</label>
                            <input type="text" class="form-control mt-2 mb-2" name="role" id="role"
                                value="<?php echo e($item->role); ?>" readonly>
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
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/user/edit/modaleditPerawat.blade.php ENDPATH**/ ?>