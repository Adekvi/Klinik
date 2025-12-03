<div class="modal fade" id="tambahobat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Tambah Obat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(url('apoteker/master-obat/obat-tambah')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Golongan</label>
                                <input type="text" name="golongan" id="golongan" class="form-control mt-2 mb-2"
                                    placeholder="Golongan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jenis Sediaan</label>
                                <input type="text" name="jenis_sediaan" id="jenis_sediaan"
                                    class="form-control mt-2 mb-2" placeholder="Jenis Sediaan">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_obat">Nama Obat</label>
                                <input type="text" class="form-control mt-2 mb-2" name="nama_obat" id="nama_obat"
                                    placeholder="Masukkan Nama Obat" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Margin</label>
                                <div class="input-group">
                                    <input type="text" id="id_margin_display" class="form-control" readonly
                                        value="<?php echo e($margen ? $margen->margin : '0'); ?>">

                                    <!-- Input hidden untuk menyimpan id_margin -->
                                    <input type="hidden" name="id_margin" id="id_margin"
                                        value="<?php echo e($margen ? $margen->id : ''); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="background: rgb(228, 228, 228)">
                                            <b>%</b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="harga_pokok">Harga Pokok</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                            <b>Rp.</b>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control mt-2 mb-2" name="harga_pokok"
                                        id="harga_pokok" placeholder="Masukkan Harga Pokok Obat"
                                        oninput="calculateHargaJual()">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                            <b>Rp.</b>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control mt-2 mb-2" name="harga_jual"
                                        id="harga_jual" placeholder="Harga Jual" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Stok Awal</label>
                                <div class="input-group">
                                    <input type="number" class="form-control mt-2 mb-2" name="stok_awal"
                                        id="stok_awal">
                                    <div class="input-group-append">
                                        <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                            <b>Total</b>
                                        </span>
                                    </div>
                                </div>
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

<?php $__env->startPush('script'); ?>
    <script>
        function calculateHargaJual() {
            // Ambil nilai harga pokok
            let hargaPokok = parseFloat(document.getElementById('harga_pokok').value);
            // Ambil nilai margin dari input yang hanya untuk menampilkan
            let margin = parseFloat(document.getElementById('id_margin_display').value);

            console.log("Harga Pokok:", hargaPokok); // Debugging
            console.log("Margin:", margin); // Debugging

            if (!isNaN(hargaPokok) && !isNaN(margin)) {
                // Hitung harga jual
                let hargaJual = hargaPokok * (1 + margin / 100);
                // Tampilkan hasil pada input harga jual
                document.getElementById('harga_jual').value = hargaJual.toFixed(0); // Tanpa desimal
                console.log("Harga Jual:", hargaJual); // Debugging
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/obat/master/dataobat/tambah.blade.php ENDPATH**/ ?>