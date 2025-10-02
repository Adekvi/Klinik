<?php $__env->startSection('title', 'Beranda'); ?>
<?php $__env->startSection('kontent'); ?>

    <section class="banner">
        <div class="slider" style="margin-top: -62px">
            <div class="slide active">
                <img src="<?php echo e(asset('aset/img/1.jpg')); ?>" alt="" />
                <div class="left-info">
                    <div class="penetrate-blur">
                        <h1 style="font-family: Montserrat">Selamat</h1>
                    </div>
                    <div class="content">
                        <h3>KLINIK PRATAMA MULTISARI II.</h3>
                        <p>Silahkan Daftarkan dan lengkapi Identitas Anda di form Pendaftaran Jangan Sampai salah untuk
                            memasukkan identitas.</p>
                        <?php if (! (Auth::check() &&
                                (Auth::user()->role == 'dokter' || Auth::user()->role == 'obat' || Auth::user()->role == 'apoteker'))): ?>
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#pasienbaru">Pasien Baru</button>
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#pasienlama">Pasien Lama</button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right-info">
                    <h1 style="font-family: Montserrat">Datang!</h1>
                </div>
            </div>

            <div class="slide">
                <img src="<?php echo e(asset('aset/img/2.jpg')); ?>" alt="" />
                <div class="left-info">
                    <div class="penetrate-blur">
                        <h1 style="font-family: Montserrat">KLI</h1>
                        <h3 style="font-family: Montserrat">Pratama</h3>
                    </div>
                    <div class="content">
                        <h3>KLINIK PRATAMA MULTISARI II.</h3>
                        <p>Silahkan Daftarkan dan lengkapi Identitas Anda di form Pendaftaran Jangan Sampai salah untuk
                            memasukkan identitas.</p>
                        <?php if (! (Auth::check() &&
                                (Auth::user()->role == 'dokter' || Auth::user()->role == 'obat' || Auth::user()->role == 'apoteker'))): ?>
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#pasienbaru">Pasien Baru</button>
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#pasienlama">Pasien Lama</button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right-info">
                    <h1 style="font-family: Montserrat">NIK</h1>
                    <h3 style="font-family: Montserrat">Multisari II</h3>
                </div>
            </div>
        </div>
        <div class="navigation">
            <span class="prev-btn"><i class="bx bx-chevron-left"></i></span>
            <span class="next-btn"><i class="bx bx-chevron-right"></i></span>
        </div>
    </section>

    <main id="main">
        <!-- ======= Get Started Section ======= -->
        <section id="testimonials" class="testimonials section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>Alur <span style="color: #1d4580"> Pendaftaran</span></h2>
                    
                </div>

                <div class="slides-2 swiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-wrap">
                                <div class="testimonial-item" style="text-align: center;">
                                    <a>
                                        <img src="<?php echo e(asset('assetss/img/klinik1.png')); ?>" alt="Gambar Pendaftaran"
                                            style="max-width: 100%; border-radius: 10px;">
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <section id="get-started" class="get-started section-bg">
            <div class="container">
                <div class="row justify-content-between">

                    <div class="col-lg-6 d-flex align-items-center" data-aos="fade-up" style="margin-top: -100px">
                        <div class="content">
                            <h3>
                                Tentang <span style="color: #1d4580">Klinik</span>
                            </h3>
                            <p>
                                <strong>
                                    Klinik Pratama Multisari II adalah sebuah fasilitas kesehatan yang terletak di Jalan
                                    <span style="color: #1d4580">Jepara-Kudus, Desa Sengonbugel, RT. 03/01, Kecamatan
                                        Mayong, Kabupaten Jepara. </span>Klinik ini menyediakan layanan kesehatan primer
                                    bagi masyarakat sekitar dengan berbagai jenis pelayanan medis. Dengan lokasi yang
                                    strategis, klinik ini mudah diakses oleh masyarakat sekitar dan menjadi pilihan utama
                                    untuk perawatan kesehatan rutin maupun mendesak.
                                </strong>
                            </p>
                        </div>
                    </div>

                    <div class="row col-lg-6">
                        <div class="video-container position-relative">
                            <video src="<?php echo e(asset('assetss/img/profil.mp4')); ?>" loop autoplay muted></video>
                            <h3>Profil Singkat</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Get Started Section -->

        <section id="testimonials" class="testimonials">
            <div class="container" data-aos="fade-up">

                <div class="section-header" style="margin-top: -20px">
                    <h2>Berita <span style="color: #1d4580"> Terbaru</span></h2>
                    <button id="btnFoto" class="btn btn-primary rounded-pill active">Foto</button>
                    <button id="btnVideo" class="btn btn-primary rounded-pill">Video</button>
                </div>

                
                <div id="fotoContainer" class="slides-2 swiper" style="margin-top: -60px;">
                    <div class="swiper-wrapper">
                        <div id="fotoContent" class="Content">
                            <div class="swiper-slide">
                                <div class="testimonial-wrap">
                                    <?php $__currentLoopData = $poto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="testimonial-item"
                                            style="background-image: url('<?php echo e(Storage::url($item->foto)); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 10px; position: relative; width: 25%; float: left">
                                            <!-- Judul dan Tanggal -->
                                            <div
                                                style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: rgba(255, 255, 255, 0.7); padding: 10px;">
                                                <h4 id="tgl<?php echo e($item->id); ?>" style="margin: 0; text-align: center;">
                                                    <?php echo e($item->tgl); ?></h4>
                                                <p id="judul<?php echo e($item->id); ?>"
                                                    style="font-size: 16px; margin: 0; text-align: center;">
                                                    <?php echo e($item->judul); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                
                <div id="videoContainer" class="slides-2 swiper"
                    style="display: none; margin-top: -60px; margin-left: 67px">
                    <div class="swiper-wrapper">
                        <div id="videoContent" class="Content">
                            <?php $__currentLoopData = $pidio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="position: relative; width: 31%; float: left; margin-right: 20px;">
                                    <video width="100%" height="auto" autoplay muted loop
                                        style="object-fit: cover; border-radius: 10px;">
                                        <source src="<?php echo e(Storage::url($item->vidio)); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div
                                        style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: rgba(255, 255, 255, 0.7); padding: 7px;">
                                        <h4 id="tgl<?php echo e($item->id); ?>" style="margin: 0; text-align: center;">
                                            <b><?php echo e($item->tgl); ?></b>
                                        </h4>
                                        <p id="judul<?php echo e($item->id); ?>"
                                            style="font-size: 16px; margin: 0; text-align: center;">
                                            <b><?php echo e($item->judul); ?></b>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>

        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="section-header" style="margin-top: -40px; margin-bottom: -50px">
                    <h2>Kontak <span style="color: #1d4580"> Kami</span></h2>
                    
                </div>

                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center">
                            <i class="fa-solid fa-location-dot"></i>
                            <h3>Our Address</h3>
                            <p>Jalan Jepara-Kudus, Desa Sengonbugel, RT. 03/01,<br> Kecamatan Mayong, Kabupaten Jepara, Jawa
                                Tengah</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center">
                            <i class="fa-solid fa-envelope"></i>
                            <h3>Email Us</h3>
                            <p>contact@example.com</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center">
                            <i class="fa-solid fa-phone"></i>
                            <h3>Call Us</h3>
                            <p>(0291)7520234</p>
                        </div>
                    </div><!-- End Info Item -->

                </div>

                <div class="row gy-4 mt-1">

                    <div class="col-lg-12">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.2751660416316!2d110.73278357356244!3d-6.736247965862465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70ddea889431cf%3A0xc53ad31280ac5949!2sKlinik%20Pratama%20Multisari%202!5e0!3m2!1sid!2sid!4v1714118504230!5m2!1sid!2sid"
                            style="border:0; width: 100%; height: 384px; border-radius: 10px" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div><!-- End Google Maps -->

                </div>

            </div>
        </section>

        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var mySwiper = new Swiper('.slides-2', {
                    // Atur konfigurasi Swiper di sini
                    slidesPerView: 'auto',
                    spaceBetween: 30,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                const btnFoto = document.getElementById("btnFoto");
                const btnVideo = document.getElementById("btnVideo");
                const fotoContainer = document.getElementById("fotoContainer");
                const videoContainer = document.getElementById("videoContainer");

                btnFoto.addEventListener("click", function() {
                    btnFoto.classList.add("active");
                    btnVideo.classList.remove("active");
                    fotoContainer.style.display = "block";
                    videoContainer.style.display = "none";
                });

                btnVideo.addEventListener("click", function() {
                    btnFoto.classList.remove("active");
                    btnVideo.classList.add("active");
                    fotoContainer.style.display = "none";
                    videoContainer.style.display = "block";
                });
            });
        </script>

    </main>

    <!-- Modal PASIEN BARU -->
    <div class="modal fade" id="pasienbaru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Pendaftaran Pasien
                        Baru
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kategori" id="kategori_pasien">
                    <input type="hidden" name="status" id="status_pasien" value="baru">
                    <!-- Karena modal ini untuk Pasien Baru -->
                    <div style="font-size: 15px; background:  rgb(241, 241, 241); padding: 5px; border-radius: 5px">
                        <span style="color: green;">Infomasi :</span>
                        <ul style="margin-bottom: 0px">
                            <li>Pasien yang baru mendaftar silahkan mengisi lengkap untuk melanjutkan pemeriksaan.</li>
                            
                        </ul>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-outline-primary" id="btnDewasa">Dewasa</button>
                        <button type="button" class="btn btn-outline-info" id="btnAnak">Anak</button>
                        <button type="button" class="btn btn-outline-success" id="btnTanpaIdentitas">Tanpa
                            Identitas</button>
                    </div>
                    <div class="text-center mt-3" id="msgDewasa" style="display: none;">
                        <h5>Pasien Dewasa</h5>
                    </div>
                    <div class="text-center mt-3" id="msgAnak" style="display: none;">
                        <h5>Pasien Anak-anak</h5>
                    </div>
                    <div class="text-center mt-3" id="msgTanpaIdentitas" style="display: none;">
                        <h5>Pasien Tanpa Identitas</h5>
                    </div>
                    <div class="form-group">
                        <label for="no_rm">No. RM</label>
                        <input type="text" class="form-control mt-2 mb-2" name="no_rm" id="no_rm"
                            placeholder="No. RM" required readonly>
                        <div id="autocomplete-results"></div>
                    </div>
                    <div class="form-group">
                        <label for="search_pasien">Nama Pasien</label>
                        <input type="text" class="form-control mt-2 mb-2" name="search_pasien" id="search_pasien"
                            placeholder="Masukkan Nama Pasien" required>
                        <div id="autocomplete-results"></div>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control mt-2 mb-2 <?php $__errorArgs = ['nik'];
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
                        <div class="text mt-2 mb-2" id="nik-info" style="display: none">*NIK Tidak Wajib Diisi!</div>
                    </div>
                    <div class="form-group">
                        <label for="nama_kk">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk"
                            placeholder="Masukkan Nama Kepala Keluarga" required>
                    </div>
                    <div class="form-group">
                        <label for="tgllahir">Tanggal Lahir</label>
                        <input type="text" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir" required
                            placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group">
                        <label for="jekel">Jenis Kelamin</label>
                        <select class="form-control mt-2 mb-2 <?php $__errorArgs = ['jekel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="jekel"
                            id="jekel" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <?php $__errorArgs = ['jekel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="invalid-feedback" id="jekel-error" style="display: none;">Jenis kelamin tidak sesuai
                            dengan NIK.</div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Asal</label>
                        <input type="text" class="form-control mt-2 mb-2" name="alamat_asal" id="alamat_asal"
                            placeholder="Masukkan Alamat Asal" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pasien">Jenis Pasien</label>
                        <select name="jenis_pasien" id="jenis_pasien" class="form-control mt-2 mb-2" required>
                            <option value="">Pilih Jenis Pasien</option>
                            <option value="Umum">Umum</option>
                            <option value="Bpjs">Bpjs</option>
                        </select>
                    </div>
                    <div class="form-group" id="nobpjs">
                        <label for="norm">No. BPJS</label>
                        <div class="cari" style="display: flex; align-items: center">
                            <input type="text" class="form-control mt-2 mb-2" name="norm" id="norm"
                                placeholder="Masukkan No. BPJS">
                            <div id="autocompletebpjs-results"></div>
                        </div>
                        <div class="invalid-feedback" id="nobpjsError" style="display: none;">No. BPJS harus berisi 13
                            digit</div>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control mt-2 mb-2" name="pekerjaan" id="pekerjaan"
                            placeholder="Masukkan Pekerjaan">
                        <div class="text mt-2 mb-2" id="pekerjaan-info" style="display: none">*Pekerjaan Tidak Wajib
                            Diisi!</div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Domisili</label>
                        <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisili"
                            placeholder="Masukkan Alamat Domisili" required>
                    </div>
                    <div class="form-group">
                        <label for="noHP">No. HP</label>
                        <input type="text" class="form-control mt-2 mb-2 <?php $__errorArgs = ['noHP'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="noHP" id="noHP" placeholder="Masukkan No. HP" required>
                        <?php $__errorArgs = ['noHP'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="invalid-feedback" id="noHP-error" style="display: none;">No.HP harus berisi 10 sampai
                            13 karakter angka.</div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="no_rm">Poli</label>
                        <select name="poli" id="poli_umum" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Poli</option>
                            <?php $__currentLoopData = $poli; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->KdPoli); ?>"><?php echo e($item->namapoli); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Dokter</label>
                        <select name="dokter" id="dokter_umum" class="form-control mt-2 mb-2" disabled>
                            <option value="#">Pilih Dokter</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan" onclick="saveData()">
                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PASIEN LAMA -->
    <div class="modal fade" id="pasienlama" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienlama" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Pendaftaran Pasien
                        Lama
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertMessage" class="alert d-none"></div>
                    <div style="font-size: 15px; background:  rgb(241, 241, 241); padding: 5px; border-radius: 5px">
                        <span style="color: green;">Infomasi :</span>
                        <ul style="margin-bottom: 0px">
                            <li>Cari data pasien berdasarkan (No. BPJS / NIK / No. RM).</li>
                            <li>- No. Rekam Medis</li>
                            <li>- NIK berjumlah 16 digit</li>
                            <li>- No. BPJS berjumlah 13 digit</li>
                        </ul>
                    </div>
                    <div class="form-group mt-2">
                        <label for="no_rm">Poli</label>
                        <select name="poli" id="poli_bpjs" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Poli</option>
                            <?php $__currentLoopData = $poli; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->KdPoli); ?>"><?php echo e($item->namapoli); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Dokter</label>
                        <select name="dokter" id="dokter_bpjs" class="form-control mt-2 mb-2">
                            <option value="#">Pilih Dokter</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="identifier">No. RM / No. BPJS / KTP / Nama Pasien</label>
                        <div class="cari mt-2 mb-2" style="display: flex; align-items: center">
                            <input type="text" class="form-control mb-2" name="identifier" id="id_bpjs"
                                placeholder="Masukkan No. RM atau No.BPJS atau KTP atau Nama Pasien">
                            <button id="searchBtn" class="btn btn-primary search mb-2"
                                style="margin-left: 9px; height: 40px;">
                                <i class="fas fa-search"></i>
                                <span id="loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                            <div id="autocompletebpjs-results"></div>
                        </div>
                    </div>
                    <!-- Informasi Pasien -->
                    <div id="infoPasien" style="display: none">
                        <table class="table" style="width: 100%;">
                            <thead style="border-bottom: 1px solid white; text-align: center;">
                                <tr>
                                    <th style="font-size: 19px" colspan="3">Informasi Pasien</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 35%">No RM</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="no_rm" id="noRM"
                                            style="font-weight: bold;" readonly></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Nama Pasien</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="nama_pasien" id="namaPasien"
                                            placeholder="Nama Pasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Nama KK</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="nama_kk" id="namaKK"
                                            placeholder="Nama KK"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Alamat Asal</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="alamat_asal" id="alamatPasien"
                                            placeholder="Alamat Asal"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">NIK</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="nik" id="nikPasien"
                                            placeholder="NIK"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Tanggal Lahir</th>
                                    <td>:</td>
                                    <td><input type="date" class="form-control" name="tgllahir" id="tgllahirPasien">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Jenis Kelamin</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="jekel" id="jekelPasien"
                                            placeholder="Jenis Kelamin"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Pekerjaan</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="pekerjaan" id="pekerjaanPasien"
                                            placeholder="Pekerjaan"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Alamat Domisili</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="domisili" id="alamatDomisili"
                                            placeholder="Alamat Domisili"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">No. HP</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="noHP" id="hpPasien"
                                            placeholder="No. HP"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Jenis Pasien</th>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" id="jenisPasien" name="jenis_pasien">
                                            <option value="">Pilih Jenis Pasien</option>
                                            <option value="Umum">Umum</option>
                                            <option value="Bpjs">BPJS</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">No. BPJS</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="bpjs" id="bpjsPasien"
                                            placeholder="No. BPJS"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanBpjs" onclick="saveDataBpjs()">
                        <span id="loadingSpinnerLama" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienlama" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white; margin-top: -5px">Anda
                        Belum Login!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <h5 class="mt-2 mb-3">Silahkan login terlebih dahulu sebelum melanjutkan pendaftaran</h5>
                        <a href="<?php echo e(url('login/index')); ?>" class="btn btn-primary">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Login</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .btn.active {
            background-color: white !important;
            color: black !important;
            border-color: #007bff !important;
            /* Tetap menggunakan border biru */
        }

        .text {
            color: #ff9102;
            /* Warna teks abu-abu */
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Memuat JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-e31aEKZt0+4v+CZRwZy1VvLuR1PnKxZUEItwG5mISof8sCQ6k55s/O6Tt7V+HtGl" crossorigin="anonymous">
    </script>

    <script>
        function showMessage(msgId, button) {
            // Hide all messages
            document.getElementById('msgDewasa').style.display = 'none';
            document.getElementById('msgAnak').style.display = 'none';
            document.getElementById('msgTanpaIdentitas').style.display = 'none';

            // Remove active class from all buttons
            document.getElementById('btnDewasa').classList.remove('active');
            document.getElementById('btnAnak').classList.remove('active');
            document.getElementById('btnTanpaIdentitas').classList.remove('active');

            // Show the selected message
            document.getElementById(msgId).style.display = 'block';

            // Add active class to the clicked button
            button.classList.add('active');
        }

        function showOptionalFields() {
            document.getElementById('nik-info').style.display = 'block';
            document.getElementById('pekerjaan-info').style.display = 'block';
        }

        function showOptionalFieldsForTanpaIdentitas() {
            document.getElementById('nik-info').style.display = 'block';
            document.getElementById('pekerjaan-info').style.display = 'none';
        }

        function hideOptionalFields() {
            document.getElementById('nik-info').style.display = 'none';
            document.getElementById('pekerjaan-info').style.display = 'none';
        }

        function convertToDate(input) {
            var parts = input.split('/');
            return parts[2] + '-' + parts[1] + '-' + parts[0]; // Convert to yyyy-mm-dd
        }

        // Format tanggal dd/mm/yyyy
        document.getElementById('tgllahir').addEventListener('input', function(e) {
            var input = e.target.value;
            var formattedInput = input.replace(/^(\d{2})(\d{2})(\d{4})$/, '$1/$2/$3');

            if (formattedInput !== input) {
                e.target.value = formattedInput;
            }
        });

        document.getElementById('tgllahir').addEventListener('blur', function(e) {
            var input = e.target.value;
            if (!/^\d{2}\/\d{2}\/\d{4}$/.test(input)) {
                e.target.value = '';
                alert('Format tanggal harus dd/mm/yyyy');
            }
        });

        // No. RM Pasien
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/pasien/latest-no-rm')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('no_rm').value = data.no_rm;
                })
                .catch(error => {
                    console.error('Error fetching the latest No. RM:', error);
                });
        });

        // Validasi NIK
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const nikError = document.getElementById('nik-error');

            nikInput.addEventListener('input', function() {
                const nik = nikInput.value;

                // Validasi panjang NIK dan memastikan hanya angka
                if (nik.length === 16 && /^\d+$/.test(nik)) {
                    nikInput.classList.remove('is-invalid');
                    nikError.style.display = 'none';
                } else {
                    nikInput.classList.add('is-invalid');
                    nikError.style.display = 'block';
                }
            });
        });

        // Validasi Jenis Kelamin Berdasarkan NIK
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const jekelInput = document.getElementById('jekel');
            const nikError = document.getElementById('nik-error');
            const jekelError = document.getElementById('jekel-error');

            nikInput.addEventListener('input', validateNIK);
            jekelInput.addEventListener('change', validateNIK);

            function validateNIK() {
                const nik = nikInput.value;
                const jekel = jekelInput.value;

                if (nik.length > 0) {
                    const dayPart = parseInt(nik.substr(6, 2));
                    let genderFromNIK = '';
                    if (dayPart < 40) {
                        genderFromNIK = 'L';
                    } else {
                        genderFromNIK = 'P';
                    }

                    // Validasi panjang NIK dan memastikan hanya angka
                    if (nik.length === 16 && /^\d+$/.test(nik)) {
                        nikInput.classList.remove('is-invalid');
                        nikError.style.display = 'none';
                    } else {
                        nikInput.classList.add('is-invalid');
                        nikError.style.display = 'block';
                    }

                    // Validasi jenis kelamin berdasarkan NIK
                    if (jekel === genderFromNIK) {
                        jekelInput.classList.remove('is-invalid');
                        jekelError.style.display = 'none';
                    } else {
                        jekelInput.classList.add('is-invalid');
                        jekelError.style.display = 'block';
                    }
                } else {
                    // Jika NIK kosong, tidak perlu menampilkan error
                    nikInput.classList.remove('is-invalid');
                    nikError.style.display = 'none';

                    // Validasi jenis kelamin tanpa memperhitungkan NIK
                    if (jekel) {
                        jekelInput.classList.remove('is-invalid');
                        jekelError.style.display = 'none';
                    } else {
                        jekelInput.classList.add('is-invalid');
                        jekelError.style.display = 'block';
                    }
                }
            }
        });

        // Jenis pasien Bpjs
        document.addEventListener('DOMContentLoaded', function() {
            const jenisPasienSelect = document.getElementById('jenis_pasien');
            const nobpjs = document.getElementById('nobpjs');
            const normInput = document.getElementById('norm');
            const nobpjsError = document.getElementById('nobpjsError');

            jenisPasienSelect.addEventListener('change', function() {
                if (this.value === 'Bpjs') {
                    nobpjs.style.display = 'block';
                } else {
                    nobpjs.style.display = 'none';
                    nobpjsError.style.display = 'none'; // Hide error message if the field is hidden
                    normInput.classList.remove('is-invalid'); // Remove invalid class if the field is hidden
                }
            });

            // Hide the No. BPJS field by default
            nobpjs.style.display = 'none';

            normInput.addEventListener('input', function() {
                if (normInput.value.length === 13) {
                    nobpjsError.style.display = 'none';
                    normInput.classList.remove('is-invalid');
                } else {
                    nobpjsError.style.display = 'block';
                    normInput.classList.add('is-invalid');
                }
            });
        });

        // Validasi No. Hp
        document.addEventListener('DOMContentLoaded', function() {
            const noHPInput = document.getElementById('noHP');
            const noHPError = document.getElementById('noHP-error');

            noHPInput.addEventListener('input', function() {
                const noHP = noHPInput.value;

                // Validasi panjang no. hp dan memastikan hanya angka
                if ((noHP.length === 10 || noHP.length === 11 || noHP.length === 12 || noHP.length ===
                        13) && /^\d+$/.test(noHP)) {
                    noHPInput.classList.remove('is-invalid');
                    noHPError.style.display = 'none';
                } else {
                    noHPInput.classList.add('is-invalid');
                    noHPError.style.display = 'block';
                }
            });
        });

        // On the redirected page, use JavaScript to show the alert
        $(document).ready(function() {
            var successMessage = '<?php echo e(session('success')); ?>';
            if (successMessage) {
                alert(successMessage); // Or use a more user-friendly alert system
            }
        });

        // Fungsi untuk memperbarui token CSRF
        function refreshCsrfToken(callback) {
            $.ajax({
                url: '/refresh-csrf',
                method: 'GET',
                success: function(response) {
                    if (response.csrf_token) {
                        $('meta[name="csrf-token"]').attr('content', response.csrf_token);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': response.csrf_token
                            }
                        });
                        console.log('CSRF token diperbarui:', response.csrf_token);
                        if (callback) callback();
                    }
                },
                error: function(xhr) {
                    console.error('Gagal memperbarui CSRF token:', xhr.responseText);
                    alert('Gagal memperbarui sesi. Silakan refresh halaman.');
                }
            });
        }

        // Fungsi untuk menjaga sesi tetap aktif
        function keepSessionAlive() {
            setInterval(function() {
                $.ajax({
                    url: '/keep-alive',
                    method: 'GET',
                    success: function() {
                        console.log('Sesi diperbarui.');
                    },
                    error: function(xhr) {
                        console.error('Gagal menjaga sesi:', xhr.responseText);
                    }
                });
            }, 15 * 60 * 1000); // Setiap 15 menit
        }

        // Fungsi untuk menangani sesi kadaluarsa
        function handleSessionExpired() {
            alert('Sesi telah berakhir. Anda akan diarahkan ke halaman login.');
            window.location.href = '/login';
        }

        $(document).ready(function() {
            // Setup CSRF token sekali saja
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Mulai keep-alive
            keepSessionAlive();

            // Alert Pasien Daftar
            $.ajax({
                url: 'pasien/index',
                method: 'POST',
                data: {},
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        refreshCsrfToken(function() {
                            $.ajax(this);
                        });
                    } else if (xhr.status === 401) {
                        handleSessionExpired();
                    } else {
                        console.error('Error:', xhr.responseText);
                    }
                }
            });

            // PASIEN BPJS Poli
            $('#poli_bpjs').change(function() {
                var poli_id = $(this).val();
                if (poli_id) {
                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(url('get-dokter-by-poli')); ?>/" + poli_id,
                        success: function(res) {
                            $("#dokter_bpjs").empty();
                            if (res) {
                                $.each(res, function(key, value) {
                                    $("#dokter_bpjs").append('<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                refreshCsrfToken(function() {
                                    $.ajax(this);
                                });
                            } else if (xhr.status === 401) {
                                handleSessionExpired();
                            } else {
                                console.error('Error:', xhr.responseText);
                                $("#dokter_bpjs").empty();
                            }
                        }
                    });
                } else {
                    $("#dokter_bpjs").empty();
                }
            });

            // PASIEN BARU Poli
            $('#poli_umum').change(function() {
                var poli_id = $(this).val();
                if (poli_id) {
                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(url('get-dokter-by-poli')); ?>/" + poli_id,
                        success: function(res) {
                            $("#dokter_umum").empty();
                            if (res) {
                                $.each(res, function(key, value) {
                                    $("#dokter_umum").append('<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                refreshCsrfToken(function() {
                                    $.ajax(this);
                                });
                            } else if (xhr.status === 401) {
                                handleSessionExpired();
                            } else {
                                console.error('Error:', xhr.responseText);
                                $("#dokter_umum").empty();
                            }
                        }
                    });
                } else {
                    $("#dokter_umum").empty();
                }
            });

            // Pencarian Pasien BPJS
            $('#searchBtn').on('click', function(event) {
                event.preventDefault();
                var identifier = $('#id_bpjs').val().trim();
                console.log("Nilai input:", identifier);

                if (!identifier) {
                    alert("Harap masukkan No. RM, No. BPJS, NIK, atau Nama Pasien.");
                    return;
                }

                $('#loading').show();
                $(this).children('i').hide();

                $.ajax({
                    url: '/search_pasien_bpjs',
                    method: 'GET',
                    data: {
                        nama: identifier
                    },
                    success: function(response) {
                        $('#loading').hide();
                        $('#searchBtn i').show();

                        if (response.error) {
                            alert(response.error);
                            $('#infoPasien').hide();
                        } else {
                            $('#noRM').val(response.no_rm);
                            $('#namaPasien').val(response.nama_pasien);
                            $('#nikPasien').val(response.nik || '');
                            $('#tgllahirPasien').val(response.tgllahir);
                            $('#jekelPasien').val(response.jekel);
                            $('#namaKK').val(response.nama_kk);
                            $('#alamatPasien').val(response.alamat_asal);
                            $('#pekerjaanPasien').val(response.pekerjaan);
                            $('#hpPasien').val(response.noHP);
                            $('#alamatDomisili').val(response.domisili);
                            $('#jenisPasien').val(response.jenis_pasien);
                            $('#bpjsPasien').val(response.bpjs || '');
                            $('#infoPasien').show();
                        }
                    },
                    error: function(xhr) {
                        $('#loading').hide();
                        $('#searchBtn i').show();
                        if (xhr.status === 419) {
                            refreshCsrfToken(function() {
                                $.ajax(this);
                            });
                        } else if (xhr.status === 401) {
                            handleSessionExpired();
                        } else {
                            console.error("Error:", xhr.responseText);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                });
            });

            // Autocomplete Pasien BPJS
            $('#identifier').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: '/search_pasien_bpjs',
                        method: 'GET',
                        data: {
                            identifier: request.term
                        },
                        success: function(data) {
                            if (data.error) {
                                alert(data.error);
                                response([]);
                            } else {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.nama_pasien + ' - ' + item
                                            .bpjs + ' - ' + item.nik,
                                        value: item.no_rm
                                    };
                                }));
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                refreshCsrfToken(function() {
                                    $.ajax(this);
                                });
                            } else if (xhr.status === 401) {
                                handleSessionExpired();
                            } else {
                                console.error("Error:", xhr.responseText);
                                response([]);
                            }
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#identifier').val(ui.item.label.split(' - ')[0]);
                    var selected_no_rm = ui.item.value;

                    $.ajax({
                        url: '/get_pasien_bpjs',
                        method: 'GET',
                        data: {
                            no_rm: selected_no_rm
                        },
                        success: function(response) {
                            if (response.error) {
                                alert(response.error);
                            } else {
                                $('#noRM').val(response.no_rm);
                                $('#namaPasien').val(response.nama_pasien);
                                $('#nikPasien').val(response.nik);
                                $('#tgllahirPasien').val(response.tgllahir);
                                $('#jekelPasien').val(response.jekel);
                                $('#namaKK').val(response.nama_kk);
                                $('#alamatPasien').val(response.alamat_asal);
                                $('#pekerjaanPasien').val(response.pekerjaan);
                                $('#hpPasien').val(response.noHP);
                                $('#alamatDomisili').val(response.domisili);
                                $('#jenisPasien').val(response.jenis_pasien);
                                $('#bpjsPasien').val(response.bpjs);
                                $('#infoPasien').show();
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                refreshCsrfToken(function() {
                                    $.ajax(this);
                                });
                            } else if (xhr.status === 401) {
                                handleSessionExpired();
                            } else {
                                console.error("Error:", xhr.responseText);
                            }
                        }
                    });
                    return false;
                },
                appendTo: "#autocompletebpjs-results"
            });
        });

        // Fungsi Simpan Data Pasien Lama
        function saveDataBpjs() {
            $('#loadingSpinnerLama').removeClass('d-none');
            $('#simpanBpjs').prop('disabled', true);

            function attemptSave() {
                var formData = {
                    no_rm: $('#noRM').val(),
                    nama_pasien: $('#namaPasien').val(),
                    nik: $('#nikPasien').val(),
                    nama_kk: $('#namaKK').val(),
                    tgllahir: $('#tgllahirPasien').val(),
                    jekel: $('#jekelPasien').val(),
                    alamat_asal: $('#alamatPasien').val(),
                    noHP: $('#hpPasien').val(),
                    domisili: $('#alamatDomisili').val(),
                    jenis_pasien: $('#jenisPasien').val(),
                    pekerjaan: $('#pekerjaanPasien').val(),
                    bpjs: $('#bpjsPasien').val(),
                    poli: $('#poli_bpjs').val(),
                    dokter: $('#dokter_bpjs').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                var errorMessages = [];
                if (!formData.no_rm) errorMessages.push("No RM harus diisi.");
                if (!formData.nama_pasien) errorMessages.push("Nama pasien harus diisi.");
                if (formData.nik && (formData.nik.length !== 16 || !/^\d+$/.test(formData.nik))) {
                    errorMessages.push("NIK harus terdiri dari 16 digit dan hanya angka.");
                }
                if (formData.bpjs && (formData.bpjs.length !== 13 || !/^\d+$/.test(formData.bpjs))) {
                    errorMessages.push("No. BPJS harus terdiri dari 13 digit dan hanya angka.");
                }
                if (!formData.nama_kk) errorMessages.push("Nama Kepala Keluarga harus diisi.");
                if (!formData.tgllahir) errorMessages.push("Tanggal lahir harus diisi.");
                if (!formData.jekel || !['L', 'P'].includes(formData.jekel)) errorMessages.push(
                    "Jenis kelamin harus 'L' atau 'P'.");
                if (!formData.alamat_asal) errorMessages.push("Alamat harus diisi.");
                if (!formData.noHP) errorMessages.push("No. HP harus diisi.");
                if (!formData.domisili) errorMessages.push("Domisili harus diisi.");
                if (!formData.jenis_pasien) errorMessages.push("Jenis pasien harus diisi.");
                if (!formData.pekerjaan) errorMessages.push("Pekerjaan harus diisi.");
                if (!formData.poli) errorMessages.push("Poli harus diisi.");
                if (!formData.dokter) errorMessages.push("Dokter harus diisi.");

                if (errorMessages.length > 0) {
                    $('#loadingSpinnerLama').addClass('d-none');
                    $('#simpanBpjs').prop('disabled', false);
                    alert("Validasi Gagal:\n" + errorMessages.join("\n"));
                    return;
                }

                $.ajax({
                    url: '/pasien/store-bpjs',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#loadingSpinnerLama').addClass('d-none');
                        $('#simpanBpjs').prop('disabled', false);

                        if (response.redirect) {
                            alert("Data tersimpan! Data pasien berhasil disimpan.");
                            window.open(response.redirect, '_blank');
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        } else if (response.error) {
                            alert("Gagal menyimpan: " + response.error);
                        }
                    },
                    error: function(xhr) {
                        $('#loadingSpinnerLama').addClass('d-none');
                        $('#simpanBpjs').prop('disabled', false);

                        if (xhr.status === 419) {
                            console.warn('CSRF token kadaluarsa, memperbarui token...');
                            refreshCsrfToken(function() {
                                attemptSave();
                            });
                        } else if (xhr.status === 401) {
                            handleSessionExpired();
                        } else if (xhr.status === 422) {
                            const response = JSON.parse(xhr.responseText);
                            alert("Validasi gagal: " + response.error);
                        } else {
                            console.error("Error Ajax:", xhr.responseText);
                            alert("Terjadi kesalahan: Gagal menyimpan data pasien.");
                        }
                    }
                });
            }

            attemptSave();
        }

        // Fungsi Simpan Data Pasien Baru
        function saveData() {
            $('#loadingSpinner').removeClass('d-none');
            $('#btnSimpan').prop('disabled', true);

            function attemptSave() {
                var kategoriPasien = document.getElementById('kategori_pasien').value || 'dewasa';
                document.getElementById('kategori_pasien').value = kategoriPasien;

                var tgllahirInput = document.getElementById('tgllahir').value;
                var tgllahirFormatted = convertToDate(tgllahirInput);

                var formData = {
                    poli: document.getElementById('poli_umum').value,
                    dokter: document.getElementById('dokter_umum').value,
                    nama_pasien: document.getElementById('search_pasien').value,
                    no_rm: document.getElementById('no_rm').value,
                    nik: document.getElementById('nik').value || '',
                    nama_kk: document.getElementById('nama_kk').value,
                    pekerjaan: document.getElementById('pekerjaan').value || '',
                    tgllahir: tgllahirFormatted,
                    jekel: document.getElementById('jekel').value,
                    alamat_asal: document.getElementById('alamat_asal').value,
                    jenis_pasien: document.getElementById('jenis_pasien').value,
                    bpjs: document.getElementById('norm').value,
                    domisili: document.getElementById('domisili').value,
                    noHP: document.getElementById('noHP').value,
                    kategori: kategoriPasien,
                    status: document.getElementById('status_pasien').value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                var errorMessages = [];
                if (!formData.poli) errorMessages.push("- Poli harus dipilih.");
                if (!formData.dokter) errorMessages.push("- Dokter harus dipilih.");
                if (!formData.nama_pasien) errorMessages.push("- Nama Pasien harus diisi.");
                if (!formData.nama_kk) errorMessages.push("- Nama Kepala Keluarga harus diisi.");
                if (!formData.tgllahir) errorMessages.push("- Tanggal Lahir harus diisi.");
                if (!formData.jekel) errorMessages.push("- Jenis kelamin harus dipilih.");
                if (!formData.alamat_asal) errorMessages.push("- Alamat Asal harus diisi.");
                if (!formData.domisili) errorMessages.push("- Alamat Domisili harus diisi.");
                if (!formData.jenis_pasien) errorMessages.push("- Jenis Pasien harus diisi.");
                if (!formData.noHP) errorMessages.push("- No. HP harus diisi.");

                if (errorMessages.length > 0) {
                    $('#loadingSpinner').addClass('d-none');
                    $('#btnSimpan').prop('disabled', false);
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return;
                }

                console.log('Form Data:', formData);

                $.ajax({
                    url: '/pasien/store-umum',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#loadingSpinner').addClass('d-none');
                        $('#btnSimpan').prop('disabled', false);

                        if (response.redirect) {
                            // Buka bukti pendaftaran di tab baru
                            window.open(response.redirect, '_blank');

                            // Kalau mau refresh halaman lama biar form kosong lagi:
                            location.reload();
                        }

                    },
                    error: function(xhr, status, error) {
                        $('#loadingSpinner').addClass('d-none');
                        $('#btnSimpan').prop('disabled', false);

                        if (xhr.status === 419) {
                            console.warn('CSRF token kadaluarsa, memperbarui token...');
                            refreshCsrfToken(function() {
                                attemptSave();
                            });
                        } else if (xhr.status === 401) {
                            handleSessionExpired();
                        } else if (xhr.status === 422) {
                            var errors = xhr.responseJSON;
                            if (errors.error === 'Pasien ini sudah mendaftar hari ini.') {
                                alert("Pasien ini telah mendaftar hari ini.");
                            } else if (errors.error === 'Pasien dengan NIK ini sudah terdaftar.') {
                                alert("NIK ini sudah terdaftar. Silakan daftar di pasien lama.");
                            } else if (errors.error === 'No. RM ini sudah digunakan.') {
                                alert("No. RM ini sudah digunakan. Silakan daftar di pasien lama.");
                            } else {
                                alert("Validasi gagal: " + errors.error);
                            }
                        } else {
                            console.error('Error:', xhr.responseText);
                            alert("Terjadi kesalahan: Gagal menyimpan data pasien.");
                        }
                    }
                });
            }

            attemptSave();
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.ngarep', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/index.blade.php ENDPATH**/ ?>