<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Petunjuk']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="card-title">
            <h4 class="text-dark"><strong>Alur Penggunaan</strong></h4>
        </div>
        <div class="row">
            <small class="text-light fw-semibold mb-2">Langkah-langkah Penggunaan E-Rm</small>
            <div class="col-md-6">
                <div class="video-container position-relative">
                    <video src="<?php echo e(asset('assetss/img/profil.mp4')); ?>" loop autoplay muted
                        style="border-radius: .5rem; box-shadow: 0 .5rem 1rem rgba(255, 255, 255, 0.258); height: auto; width: 100%; object-fit: fill"></video>
                </div>
            </div>
            <?php if(Auth::check()): ?>
                <?php if(Auth::user()->role == 'perawat'): ?>
                    <div class="col-md-6">
                        <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">
                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconOne">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-1" aria-controls="accordionIcon-1">
                                        Login
                                    </button>
                                </h2>

                                <div id="accordionIcon-1" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Perawat membuka aplikasi E-RM atau mengunjungi situs web resmi rumah
                                        sakit yang menyediakan layanan E-RM. Pada halaman utama, terdapat
                                        tombol atau link menuju halaman login
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-2" aria-controls="accordionIcon-2">
                                        Dashboard
                                    </button>
                                </h2>
                                <div id="accordionIcon-2" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Setelah berhasil login, perawat diarahkan ke dashboard utama sistem
                                        E-RM. Di sini, mereka dapat mengakses berbagai fitur dan informasi
                                        yang relevan dengan tugas mereka, seperti daftar antrian pasien,
                                        rekam medis, dan jadwal janji temu
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-3" aria-expanded="true"
                                        aria-controls="accordionIcon-3">
                                        Nomor Antrian
                                    </button>
                                </h2>
                                <div id="accordionIcon-3" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Perawat membuka modul antrian pasien untuk melihat daftar pasien yang
                                        sedang menunggu giliran. Sistem ini menampilkan nomor antrian, nama
                                        pasien, dan waktu kedatangan
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-4" aria-expanded="true"
                                        aria-controls="accordionIcon-4">
                                        Panggilan Pasien
                                    </button>
                                </h2>
                                <div id="accordionIcon-4" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Perawat memanggil pasien berdasarkan nomor antrian. Pemanggilan bisa
                                        dilakukan melalui sistem antrian digital yang menampilkan nomor
                                        antrian di layar monitor ruang tunggu, atau melalui pengeras suara
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-5" aria-expanded="true"
                                        aria-controls="accordionIcon-5">
                                        Asesmen Pasien
                                    </button>
                                </h2>
                                <div id="accordionIcon-5" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Perawat membuka rekam medis pasien di sistem E-RM untuk memverifikasi
                                        data pasien dan riwayat medis. Asesmen Awal: Perawat melakukan
                                        pengukuran vital signs (tekanan darah, suhu tubuh, denyut nadi, dan
                                        pernapasan).Pencatatan Keluhan: Perawat mencatat keluhan utama dan
                                        gejala yang disampaikan oleh pasien. Riwayat Kesehatan: Perawat
                                        memperbarui informasi tentang riwayat kesehatan pasien, alergi, dan
                                        obat-obatan yang sedang dikonsumsi. Pemeriksaan Fisik: Jika
                                        diperlukan, perawat melakukan pemeriksaan fisik awal sebelum dokter
                                        melakukan pemeriksaan lebih lanjut
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-6" aria-expanded="true"
                                        aria-controls="accordionIcon-6">
                                        Pembaruan RM (Rekam Medis)
                                    </button>
                                </h2>
                                <div id="accordionIcon-6" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Perawat mencatat semua temuan asesmen dan pemeriksaan dalam rekam
                                        medis digital pasien. Ini termasuk hasil vital signs, keluhan
                                        pasien, dan observasi klinis awal
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-7" aria-expanded="true"
                                        aria-controls="accordionIcon-7">
                                        Pemeriksaan Dokter
                                    </button>
                                </h2>
                                <div id="accordionIcon-7" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Setelah asesmen awal selesai, perawat mengarahkan pasien ke dokter
                                        untuk pemeriksaan lebih lanjut atau tindakan medis lainnya sesuai
                                        dengan prosedur rumah sakit
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconOne">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#accordionIcon-1"
                                        aria-controls="accordionIcon-8">
                                        Logout
                                    </button>
                                </h2>

                                <div id="accordionIcon-8" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Setelah menyelesaikan semua tugas, perawat wajib logout dari sistem
                                        E-RM untuk memastikan keamanan data dan mencegah akses oleh pihak
                                        yang tidak berwenang. Logout juga membantu menjaga kerahasiaan
                                        informasi pasien
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif(Auth::user()->role == 'dokter'): ?>
                    <div class="col-md-6">
                        <small class="text-light fw-semibold">Langkah-langkah Penggunaan E-Rm</small>
                        <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">
                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconOne">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#accordionIcon-1"
                                        aria-controls="accordionIcon-1">
                                        Login
                                    </button>
                                </h2>

                                <div id="accordionIcon-1" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Dokter membuka aplikasi E-RM atau mengunjungi situs web resmi rumah
                                        sakit yang menyediakan layanan E-RM. Pada halaman utama, terdapat
                                        tombol atau link menuju halaman login.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconTwo">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#accordionIcon-2"
                                        aria-controls="accordionIcon-2">
                                        Kredensial Akun
                                    </button>
                                </h2>
                                <div id="accordionIcon-2" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Dokter memasukkan username dan password yang telah diberikan oleh
                                        admin sistem atau otoritas rumah sakit. Kredensial ini bersifat unik
                                        dan rahasia untuk setiap pengguna.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-3" aria-expanded="true"
                                        aria-controls="accordionIcon-3">
                                        Verifikasi Keamanan
                                    </button>
                                </h2>
                                <div id="accordionIcon-3" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Beberapa sistem E-RM mungkin memiliki langkah tambahan untuk
                                        keamanan, seperti verifikasi dua faktor (2FA) yang mengharuskan
                                        dokter memasukkan kode yang dikirimkan ke perangkat mobile atau
                                        email terdaftar mereka.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-4" aria-expanded="true"
                                        aria-controls="accordionIcon-4">
                                        Akses Dashboard
                                    </button>
                                </h2>
                                <div id="accordionIcon-4" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Setelah berhasil login, dokter diarahkan ke dashboard utama sistem
                                        E-RM. Di sini, mereka dapat mengakses berbagai fitur dan informasi,
                                        seperti daftar pasien, rekam medis, jadwal janji temu, hasil
                                        laboratorium, dan catatan medis.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-5" aria-expanded="true"
                                        aria-controls="accordionIcon-5">
                                        Pemeriksaan Pasien
                                    </button>
                                </h2>
                                <div id="accordionIcon-5" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Dokter dapat mencari dan membuka rekam medis pasien tertentu untuk
                                        melihat riwayat kesehatan, diagnosis sebelumnya, resep obat, dan
                                        informasi penting lainnya. Sistem ini juga memungkinkan dokter untuk
                                        memperbarui informasi pasien, menambahkan catatan medis baru, serta
                                        meresepkan obat.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="accordionIconThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionIcon-8" aria-expanded="true"
                                        aria-controls="accordionIcon-8">
                                        Logout
                                    </button>
                                </h2>
                                <div id="accordionIcon-8" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Setelah menyelesaikan semua tugas, perawat wajib logout dari sistem
                                        E-RM untuk memastikan keamanan data dan mencegah akses oleh pihak
                                        yang tidak berwenang. Logout juga membantu menjaga kerahasiaan
                                        informasi pasien
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif(Auth::user()->role == 'apoteker'): ?>
                    <div class="col-md-6">
                        <small class="text-light fw-semibold">Langkah-langkah Penggunaan E-RM</small>

                        <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-apotek-1">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-apotek-1">
                                        Login
                                    </button>
                                </h2>
                                <div id="collapse-apotek-1" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Apoteker masuk ke sistem E-RM menggunakan akun yang diberikan oleh admin.
                                        Sistem akan mengarahkan ke halaman dashboard setelah login berhasil.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-apotek-2">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-apotek-2">
                                        Dashboard
                                    </button>
                                </h2>
                                <div id="collapse-apotek-2" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Dashboard menampilkan daftar resep yang masuk dari dokter atau perawat,
                                        termasuk detail pasien, obat yang diresepkan, dan status pemrosesan resep.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-apotek-3">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-apotek-3">
                                        Validasi Resep
                                    </button>
                                </h2>
                                <div id="collapse-apotek-3" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Apoteker memeriksa detail resep pasien, mengecek kelengkapan,
                                        kesesuaian dosis, interaksi obat, dan memastikan obat tersedia di gudang.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-apotek-4">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-apotek-4">
                                        Penyerahan Obat
                                    </button>
                                </h2>
                                <div id="collapse-apotek-4" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Setelah resep divalidasi, apoteker menyerahkan obat kepada pasien
                                        sesuai prosedur. Sistem E-RM memungkinkan pencatatan obat keluar
                                        dan pembaruan stok secara otomatis.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-apotek-5">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-apotek-5">
                                        Logout
                                    </button>
                                </h2>
                                <div id="collapse-apotek-5" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Setelah semua proses selesai, apoteker logout untuk menjaga keamanan sistem dan
                                        data pasien.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php elseif(Auth::user()->role == 'kasir'): ?>
                    <div class="col-md-6">
                        <small class="text-light fw-semibold">Langkah-langkah Penggunaan E-RM</small>

                        <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-kasir-1">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-kasir-1">
                                        Login
                                    </button>
                                </h2>
                                <div id="collapse-kasir-1" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Kasir masuk menggunakan kredensial akun yang telah diberikan oleh admin.
                                        Setelah berhasil login, sistem menampilkan dashboard kasir.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-kasir-2">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-kasir-2">
                                        Dashboard
                                    </button>
                                </h2>
                                <div id="collapse-kasir-2" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Dashboard berisi daftar transaksi pasien, tagihan layanan, status pembayaran,
                                        dan menu untuk mencetak nota atau invoice.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-kasir-3">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-kasir-3">
                                        Verifikasi Tagihan
                                    </button>
                                </h2>
                                <div id="collapse-kasir-3" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Kasir memeriksa rincian biaya pasien: tindakan medis, resep obat,
                                        biaya administrasi, hingga layanan tambahan lain yang tercatat di E-RM.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card active">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-kasir-4">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-kasir-4">
                                        Proses Pembayaran
                                    </button>
                                </h2>
                                <div id="collapse-kasir-4" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Kasir menerima pembayaran pasien, memilih metode pembayaran,
                                        mencatat transaksi ke sistem, dan mencetak bukti pembayaran atau invoice.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header text-body d-flex justify-content-between"
                                    id="acc-kasir-5">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-kasir-5">
                                        Logout
                                    </button>
                                </h2>
                                <div id="collapse-kasir-5" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionIcon">
                                    <div class="accordion-body">
                                        Kasir logout untuk memastikan keamanan data transaksi dan informasi pasien.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('script'); ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const video = document.querySelector("video");

                if (video) {
                    video.muted = true;
                    video.play().catch(() => {
                        // fallback kalau browser tetap menolak autoplay
                        video.setAttribute("playsinline", "");
                        video.muted = true;
                        video.play();
                    });
                }
            });
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/petunjuk/index.blade.php ENDPATH**/ ?>