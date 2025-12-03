<?php $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editumum<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Edit Data
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('admin/edit/pasienumum/' . $item->id)); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_rm">No. RM</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="no_rm" id="no_rm"
                                        value="<?php echo e($item->no_rm); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pasien">Nama Pasien</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="nama_pasien"
                                        id="nama_pasien" value="<?php echo e($item->nama_pasien); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="nik" id="nik"
                                        value="<?php echo e($item->nik); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_kk">Nama Kepala Keluarga</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk"
                                        value="<?php echo e($item->nama_kk); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgllahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir"
                                        value="<?php echo e($item->tgllahir); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jekel">Jenis Kelamin</label>
                                    <select name="jekel" id="jekel" class="form-control mt-2 mb-2">
                                        <option value="L" <?php echo e($item->jekel == 'L' ? 'selected' : ''); ?>>Laki-Laki
                                        </option>
                                        <option value="P" <?php echo e($item->jekel == 'P' ? 'selected' : ''); ?>>Perempuan
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat_asal">Alamat Asal</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="alamat_asal"
                                        id="alamat_asal" value="<?php echo e($item->alamat_asal); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="noHP">No. HP</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHP"
                                        value="<?php echo e($item->noHP); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="domisili">Domisili</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisili"
                                        value="<?php echo e($item->domisili); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_pasien">Jenis Pasien</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="jenis_pasien"
                                        id="jenis_pasien" value="<?php echo e($item->jenis_pasien); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="pekerjaan"
                                        id="pekerjaan" value="<?php echo e($item->pekerjaan); ?>">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/master/pasienumum/modaledit.blade.php ENDPATH**/ ?>