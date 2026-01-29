 <div class="modal fade" id="tambahpoli" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="pasienbaru" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Poli</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="<?php echo e(url('admin/tambah/datapoli')); ?>" method="post" enctype="multipart/form-data">
                 <?php echo csrf_field(); ?>
                 <div class="modal-body">
                     <div class="form-group">
                         <label for="no_rm">Nama Poli</label>
                         <input type="text" class="form-control mt-2 mb-2" name="namapoli" id="namapoli"
                             placeholder="Masukkan Nama Poli" required>
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
<?php /**PATH C:\laragon\www\Klinik\resources\views/admin/master/datapoli/modaltambah.blade.php ENDPATH**/ ?>