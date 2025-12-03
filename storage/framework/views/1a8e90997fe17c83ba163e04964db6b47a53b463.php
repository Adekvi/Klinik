<?php $__currentLoopData = $obat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editobat<?php echo e($item->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Edit Data Stok
                        Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('apoteker/master-obat/obat-edit/' . $item->id)); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Golongan</label>
                                    <input type="text" name="golongan" id="golongan" class="form-control mt-2 mb-2"
                                        placeholder="Golongan" value="<?php echo e($item->golongan); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Jenis Sediaan</label>
                                    <input type="text" name="jenis_sediaan" id="jenis_sediaan"
                                        class="form-control mt-2 mb-2" placeholder="Jenis Sediaan"
                                        value="<?php echo e($item->jenis_sediaan); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_obat">Nama Obat</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="nama_obat" id="nama_obat"
                                        placeholder="Masukkan Nama Obat" required value="<?php echo e($item->nama_obat); ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="harga_pokok">Harga Pokok</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2"
                                                style="background: rgb(228, 228, 228)"><b>Rp.</b></span>
                                        </div>
                                        <input type="number" class="form-control mt-2 mb-2" name="harga_pokok"
                                            id="harga_pokok" placeholder="Masukkan Harga Pokok Obat"
                                            value="<?php echo e($item->harga_pokok ? $item->harga_pokok : ''); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="stok_akhir">Jumlah Stok</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control mt-2 mb-2" name="stok"
                                            id="stok_akhir<?php echo e($item->id); ?>" value="<?php echo e($item->stok); ?>" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                                <b>Total</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="harga_jual">Harga Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2"
                                                style="background: rgb(228, 228, 228)"><b>Rp.</b></span>
                                        </div>
                                        <input type="number" class="form-control mt-2 mb-2" name="harga_jual"
                                            id="harga_jual" placeholder="Masukkan Harga Jual Obat"
                                            value="<?php echo e($item->harga_jual ? $item->harga_jual : ''); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="stok_masuk">Stok Masuk</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control mt-2 mb-2" name="masuk"
                                            id="stok_masuk<?php echo e($item->id); ?>" placeholder="Masukkan Stok Masuk">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                                <b>Total</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="stok_keluar">Stok Keluar</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control mt-2 mb-2" name="keluar"
                                            id="stok_keluar<?php echo e($item->id); ?>" placeholder="Masukkan Stok Keluar">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2"
                                                style="background: rgb(228, 228, 228)">
                                                <b>Total</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="stok_retur">Retur</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control mt-2 mb-2" name="retur"
                                            id="stok_retur<?php echo e($item->id); ?>" placeholder="Masukkan Retur">
                                        <div class="input-group-append">
                                            <span class="input-group-text mt-2"
                                                style="background: rgb(228, 228, 228)">
                                                <b>Total</b>
                                            </span>
                                        </div>
                                    </div>
                                    <p style="color: blue; font-size: 12px">
                                        *Jika ada pengembalian obat, bisa diisi
                                    </p>
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

<?php $__env->startPush('script'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>

    <script>
        // Fungsi untuk mendapatkan Stok Akhir
        // document.addEventListener('DOMContentLoaded', function () {
        //     // Objek untuk menyimpan stok awal dan nilai terakhir dari masing-masing input
        //     const stokAkhirSebelumnya = {};
        //     const nilaiTerakhir = {};

        //     // Fungsi untuk menghitung stok akhir
        //     function hitungStokAkhir(modalId) {
        //         const stokAwal = stokAkhirSebelumnya[modalId] || parseFloat(document.getElementById('stok_akhir' + modalId).value) || 0;

        //         const stokMasukElem = document.getElementById('stok_masuk' + modalId);
        //         const stokKeluarElem = document.getElementById('stok_keluar' + modalId);
        //         const stokReturElem = document.getElementById('stok_retur' + modalId);
        //         const stokAkhirElem = document.getElementById('stok_akhir' + modalId);

        //         // Ambil nilai terakhir dari input, jika tidak ada set ke 0
        //         const stokMasukTerakhir = nilaiTerakhir[modalId]?.stokMasuk || 0;
        //         const stokKeluarTerakhir = nilaiTerakhir[modalId]?.stokKeluar || 0;
        //         const stokReturTerakhir = nilaiTerakhir[modalId]?.stokRetur || 0;

        //         // Ambil nilai saat ini dari input, jika tidak ada set ke 0
        //         const stokMasuk = parseFloat(stokMasukElem.value) || 0;
        //         const stokKeluar = parseFloat(stokKeluarElem.value) || 0;
        //         const stokRetur = parseFloat(stokReturElem.value) || 0;

        //         // Hitung stok akhir: stok awal + (stok masuk baru - stok masuk terakhir) - (stok keluar baru - stok keluar terakhir) + (stok retur baru - stok retur terakhir)
        //         const stokAkhirSaatIni = stokAwal + (stokMasuk - stokMasukTerakhir) - (stokKeluar - stokKeluarTerakhir) + (stokRetur - stokReturTerakhir);

        //         // Simpan nilai saat ini sebagai nilai terakhir
        //         nilaiTerakhir[modalId] = {
        //             stokMasuk,
        //             stokKeluar,
        //             stokRetur,
        //         };

        //         // Tampilkan hasil pada input stok_akhir
        //         stokAkhirElem.value = stokAkhirSaatIni;

        //         // Perbarui stok awal ke stok akhir saat ini
        //         stokAkhirSebelumnya[modalId] = stokAkhirSaatIni;
        //     }

        //     // Event listener untuk perubahan input
        //     document.addEventListener('input', function (event) {
        //         if (
        //             event.target.id.startsWith('stok_masuk') ||
        //             event.target.id.startsWith('stok_keluar') ||
        //             event.target.id.startsWith('stok_retur')
        //         ) {
        //             const modalId = event.target.id.replace(/\D/g, ''); // Ambil ID unik modal
        //             hitungStokAkhir(modalId); // Perbarui stok akhir
        //         }
        //     });

        //     // Panggil fungsi saat halaman pertama kali dimuat
        //     window.addEventListener('load', function () {
        //         const modals = document.querySelectorAll('.modal');
        //         modals.forEach(modal => {
        //             const modalId = modal.id.replace(/\D/g, ''); // Ambil ID unik modal
        //             const stokAwal = parseFloat(document.getElementById('stok_awal' + modalId)?.value) || 0;

        //             // Simpan stok awal dan nilai awal untuk modal ini
        //             stokAkhirSebelumnya[modalId] = stokAwal;
        //             nilaiTerakhir[modalId] = {
        //                 stokMasuk: 0,
        //                 stokKeluar: 0,
        //                 stokRetur: 0,
        //             };

        //             // Tampilkan stok awal di input stok_akhir
        //             document.getElementById('stok_akhir' + modalId).value = stokAwal;
        //         });
        //     });
        // });

        document.addEventListener('DOMContentLoaded', function() {
            // Objek untuk menyimpan stok awal dan nilai terakhir dari masing-masing input
            const stokAkhirSebelumnya = {};
            const nilaiTerakhir = {};

            // Fungsi untuk menghitung stok akhir
            function hitungStokAkhir(modalId) {
                const stokAwal = stokAkhirSebelumnya[modalId] || parseFloat(document.getElementById('stok_akhir' +
                    modalId).value) || 0;

                const stokMasukElem = document.getElementById('stok_masuk' + modalId);
                const stokKeluarElem = document.getElementById('stok_keluar' + modalId);
                const stokReturElem = document.getElementById('stok_retur' + modalId);
                const stokAkhirElem = document.getElementById('stok_akhir' + modalId);

                // Ambil nilai terakhir dari input, jika tidak ada set ke 0
                const stokMasukTerakhir = nilaiTerakhir[modalId]?.stokMasuk || 0;
                const stokKeluarTerakhir = nilaiTerakhir[modalId]?.stokKeluar || 0;
                const stokReturTerakhir = nilaiTerakhir[modalId]?.stokRetur || 0;

                // Ambil nilai saat ini dari input, jika tidak ada set ke 0
                const stokMasuk = parseFloat(stokMasukElem.value) || 0;
                const stokKeluar = parseFloat(stokKeluarElem.value) || 0;
                const stokRetur = parseFloat(stokReturElem.value) || 0;

                // Hitung stok akhir: stok awal + (stok masuk baru - stok masuk terakhir) - (stok keluar baru - stok keluar terakhir) + (stok retur baru - stok retur terakhir)
                const stokAkhirSaatIni = stokAwal + (stokMasuk - stokMasukTerakhir) - (stokKeluar -
                    stokKeluarTerakhir) + (stokRetur - stokReturTerakhir);

                // Simpan nilai saat ini sebagai nilai terakhir
                nilaiTerakhir[modalId] = {
                    stokMasuk,
                    stokKeluar,
                    stokRetur,
                };

                // Tampilkan hasil pada input stok_akhir
                stokAkhirElem.value = stokAkhirSaatIni;

                // Perbarui stok awal ke stok akhir saat ini
                stokAkhirSebelumnya[modalId] = stokAkhirSaatIni;
            }

            // Event listener untuk perubahan input
            document.addEventListener('input', function(event) {
                if (
                    event.target.id.startsWith('stok_masuk') ||
                    event.target.id.startsWith('stok_keluar') ||
                    event.target.id.startsWith('stok_retur')
                ) {
                    const modalId = event.target.id.replace(/\D/g, ''); // Ambil ID unik modal
                    hitungStokAkhir(modalId); // Perbarui stok akhir
                }
            });

            // Panggil fungsi saat halaman pertama kali dimuat
            window.addEventListener('load', function() {
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    const modalId = modal.id.replace(/\D/g, ''); // Ambil ID unik modal
                    const stokAwal = parseFloat(document.getElementById('stok_awal' + modalId)
                        ?.value) || 0;

                    // Simpan stok awal dan nilai awal untuk modal ini
                    stokAkhirSebelumnya[modalId] = stokAwal;
                    nilaiTerakhir[modalId] = {
                        stokMasuk: 0,
                        stokKeluar: 0,
                        stokRetur: 0,
                    };

                    // Tampilkan stok awal di input stok_akhir
                    document.getElementById('stok_akhir' + modalId).value = stokAwal;
                });
            });
        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     // Fungsi untuk menghitung stok akhir
        //     function hitungStokAkhir(modalId) {
        //         // Ambil stok akhir terakhir, jika ada, atau set ke 0 jika tidak ada
        //         const stokAkhirTerakhir = parseFloat(document.getElementById('stok_akhir' + modalId).value) || 0;
        //         const stokMasuk = parseFloat(document.getElementById('stok_masuk' + modalId).value) || 0;
        //         const stokKeluar = parseFloat(document.getElementById('stok_keluar' + modalId).value) || 0;
        //         const stokRetur = parseFloat(document.getElementById('stok_retur' + modalId).value) || 0;

        //         // Menghitung stok akhir berdasarkan stok akhir terakhir dan input yang baru
        //         // - Tambahkan stok masuk ke stok akhir terakhir
        //         // - Kurangi stok keluar dari stok akhir terakhir
        //         // - Tambahkan stok retur ke stok akhir terakhir
        //         let stokAkhir = stokAkhirTerakhir;

        //         // Menambahkan stok masuk
        //         if (stokMasuk > 0) {
        //             stokAkhir += stokMasuk;
        //         }

        //         // Mengurangi stok keluar
        //         if (stokKeluar > 0) {
        //             stokAkhir -= stokKeluar;
        //         }

        //         // Menambahkan stok retur
        //         if (stokRetur > 0) {
        //             stokAkhir += stokRetur;
        //         }

        //         // Menampilkan hasil pada input stok_akhir
        //         document.getElementById('stok_akhir' + modalId).value = stokAkhir;
        //     }

        //     // Event listener untuk setiap input perubahan (dengan id unik per modal)
        //     document.addEventListener('input', function(event) {
        //         // Cek apakah input berada di dalam modal dengan ID tertentu
        //         if (event.target.id.startsWith('stok_masuk') || event.target.id.startsWith('stok_keluar') || event.target.id.startsWith('stok_retur')) {
        //             const modalId = event.target.id.replace(/\D/g, ''); // Ambil ID unik dari modal (misalnya: stok_masuk123 -> 123)
        //             hitungStokAkhir(modalId);   // Update stok akhir untuk modal yang sesuai
        //         }
        //     });

        //     // Panggil fungsi saat halaman pertama kali dimuat
        //     window.addEventListener('load', function() {
        //         // Cek apakah elemen modal sudah tersedia dan panggil hitungStokAkhir jika perlu
        //         const modals = document.querySelectorAll('.modal');
        //         modals.forEach(modal => {
        //             const modalId = modal.id; // Ambil ID modal jika ada
        //             hitungStokAkhir(modalId);  // Panggil fungsi untuk modal ini
        //         });
        //     });
        // });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/obat/master/dataobat/edit.blade.php ENDPATH**/ ?>