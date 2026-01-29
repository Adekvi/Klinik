
<div class="modal fade" id="tambahdokter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Tenaga Medis</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(url('admin/tambah/datadokter')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="poli">Poli</label>
                        <select name="poli" id="poli" class="form-control mt-2 mb-2" required>
                            <option value="#" disabled selected>Pilih Poli</option>
                            <?php $__currentLoopData = $poli; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->KdPoli); ?>"><?php echo e($item->namapoli); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p style="font-size: 14px"><span style="color: green; font-weight: bold">Info.</span> Selain
                            dokter silahkan lewati untuk bagian pilih poli</p>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control mb-2 mt-2 <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="nik" id="nik" placeholder="Masukkan NIK">
                        <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="invalid-feedback" id="nik-error" style="display: none;">NIK harus berisi 16 karakter
                            angka.</div>
                        <p style="font-size: 14px"><span style="color: green; font-weight: bold">Info.</span> Selain
                            Dokter NIK tidak wajib diisi!</p>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Nama Tenaga Medis</label>
                        <input type="text" class="form-control mb-2 mt-2" name="dokter" id="dokter"
                            placeholder="Masukkan Nama Tenaga Medis">
                    </div>
                    <div class="form-group">
                        <label for="profesi">Profesi</label>
                        <input type="text" class="form-control mt-2 mb-2" name="profesi" id="profesi"
                            placeholder="Masukkan Profesi">
                    </div>
                    <div class="form-group">
                        <label for="tarif">Tarif Jasa</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                    <b>Rp.</b>
                                </span>
                            </div>
                            <input type="number" name="tarif" id="tarif" class="form-control mb-2 mt-2"
                                placeholder="Masukkan Tarif Jasa">
                        </div>
                    </div>
                    <p style="font-size: 14px"><span style="color: green; font-weight: bold">Info.</span> Selain Dokter
                        Tarif tidak wajib diisi!</p>
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

<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/datadokter/modaltambah.blade.php ENDPATH**/ ?>