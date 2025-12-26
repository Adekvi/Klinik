<?php if (isset($component)) { $__componentOriginal1e84a5d9305f6227b2d9c78c854797728c150b58 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\User\Layout\Home::class, ['title' => 'Pasien']); ?>
<?php $component->withName('user.layout.home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="breadcrumbs d-flex align-items-center"
        style="background-image: url('<?php echo e(asset('assetss/img/profil.jpg')); ?>');">
    </div>

    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <section id="testimonials" class="testimonials section-bg">
            <div class="container" data-aos="fade-up">
                <div class="pendaftaran">
                    <div class="container">
                        <div class="section-header">
                            <h2>Pendaftaran</h2>
                            <p>Silahkan Daftarkan dan lengkapi Identitas Anda di form Pendaftaran dan Jangan Sampai
                                salah
                                untuk memasukkan identitas</p>
                        </div>
                        <div class="slides-2 swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-wrap"
                                        style="display: flex; justify-content: center; margin-top: 20px;">
                                        <div class="testimonial-item" style="margin-right: 100px; border-radius: 50px">
                                            
                                            <div class="pasien-baru" style="text-align: center;">
                                                <div style="margin-top: 50px; color: rgb(0, 0, 0);">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#pasienbaru">
                                                        <i class="fas fa-user-plus"
                                                            style="font-size: 80px; color:rgb(0, 0, 0)"></i>
                                                    </a>
                                                    <br>
                                                    <button class="btn" style="font-size: 20px;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#pasienbaru"><strong>Pasien
                                                            Umum</strong></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial-item" style="border-radius: 50px">
                                            
                                            <div class="pasien-lama" style="text-align: center;">
                                                <div style="margin-top: 50px; color: rgb(0, 0, 0);">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#pasienlama">
                                                        <i class="fas fa-user-check"
                                                            style="font-size: 80px; color:black"></i>
                                                    </a>
                                                    <br>
                                                    <button class="btn" style="font-size: 20px;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#pasienlama"><strong>Pasien
                                                            BPJS</strong></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal PASIEN UMUM -->
    <div class="modal fade" id="pasienbaru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Pendaftaran Pasien</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
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
                        <select name="dokter" id="dokter_umum" class="form-control mt-2 mb-2">
                            <option value="#">Pilih Dokter</option>
                            
                        </select>
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
                            name="nik" id="nik" placeholder="Masukkan NIK" required>
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
                    </div>
                    <div class="form-group">
                        <label for="nama_kk">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk"
                            placeholder="Masukkan Nama Kepala Keluarga" required>
                    </div>
                    <div class="form-group">
                        <label for="tgllahir">Tanggal Lahir</label>
                        <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="jekel">Jenis Kelamin</label>
                        <select name="jekel" id="jekel" class="form-control mt-2 mb-2" required>
                            <option value="" disabled selected>Pilih Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Asal</label>
                        <input type="text" class="form-control mt-2 mb-2" name="alamat_asal" id="alamat_asal"
                            placeholder="Masukkan Alamat Asal" required>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control mt-2 mb-2" name="pekerjaan" id="pekerjaan"
                            placeholder="Masukkan Pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Domisili</label>
                        <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisili"
                            placeholder="Masukkan Alamat Domisili" required>
                    </div>
                    <div class="form-group">
                        <label for="noHP">No. HP</label>
                        <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHP"
                            placeholder="Masukkan No. HP" required>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-primary" id="btnSimpan" onclick="saveData()">
                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PASIEN bpjs -->
    <div class="modal fade" id="pasienlama" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienlama" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Pendaftaran Pasien
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
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
                        <label for="norm">No.BPJS/NIK/Nama Pasien</label>
                        <div class="cari mt-2 mb-2" style="display: flex; align-items: center">
                            <input type="text" class="form-control mb-2" name="norm" id="norm"
                                placeholder="Masukkan No.BPJS/KTP">
                            <div id="autocompletebpjs-results"></div>
                        </div>
                    </div>
                    <div id="infoPasien" style="display: none">
                        <table class="table form-control mt-2" style="width: 100%;">
                            <thead
                                style="border-bottom: 1px solid white;
                        width: 100%;
                        text-align: center;
                        display: flex;
                        justify-content: center;">
                                <tr style="text-align: center">
                                    <th style="font-size: 19px">Informasi Pasien</th>
                                </tr>
                            </thead>
                            <tbody style="border-bottom: 1px solid white; border-top: 1px solid white">
                                <tr>
                                    <th scope="row" style="width: 35%">No RM</th>
                                    <td>:</td>
                                    <td id="noRM"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Nama Pasien</th>
                                    <td>:</td>
                                    <td id="namaPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Nama KK</th>
                                    <td>:</td>
                                    <td id="namaKK"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Alamat Asal</th>
                                    <td>:</td>
                                    <td id="alamatPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">NIK</th>
                                    <td>:</td>
                                    <td id="nikPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Tanggal Lahir</th>
                                    <td>:</td>
                                    <td id="tgllahirPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Jenis Kelamin</th>
                                    <td>:</td>
                                    <td id="jekelPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Pekerjaan</th>
                                    <td>:</td>
                                    <td id="pekerjaanPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Alamat Domisili</th>
                                    <td>:</td>
                                    <td id="alamatDomisili"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">No. HP</th>
                                    <td>:</td>
                                    <td id="hpPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Jenis Pasien</th>
                                    <td>:</td>
                                    <td id="jenisPasien"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">No. BPJS</th>
                                    <td>:</td>
                                    <td id="bpjsPasien"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpanBpjs" onclick="saveDataBpjs()">
                        <span id="loadingSpinnerLama" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <!-- Memuat JavaScript Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                // Set up CSRF token for every AJAX request
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // Menangani klik pada tombol "Daftar"
                $('#daftarBtn').on('click', function() {
                    // Mendapatkan nilai No.RM untuk dikirim ke halaman baru
                    $('#loadingSpinnerLama').removeClass('d-none');
                    $('#daftarBtn').prop('disabled', true); // Menonaktifkan tombol selama proses loading
                    var noRM = $('#norm').val();
                    // console.log(noRM);
                    $.ajax({
                        url: '/pasien-lama/store',
                        type: 'POST',
                        data: {
                            rm: noRM,
                        },
                        success: function(responseLama) {
                            $('#loadingSpinnerLama').addClass('d-none');
                            $('#daftarBtn').prop('disabled', false);

                            $('#pasienlama').modal('hide');
                            var dataBooking = responseLama.booking;
                            console.log('Booking Pasien Lama:', dataBooking);

                            showPoliModal(dataBooking);
                        },
                        error: function(error) {
                            // Menyembunyikan efek loading dan menampilkan pesan error jika ada kesalahan
                            $('#loadingSpinnerLama').addClass('d-none');
                            $('#daftarBtn').prop('disabled',
                                false); // Mengaktifkan tombol setelah proses loading

                            console.error('Error saat menyimpan data pasien: ', error);
                            // Handle error sesuai kebutuhan Anda
                        }
                    });
                });
            });

            $(document).ready(function() {
                $('#poli_bpjs').change(function() {
                    var poli_id = $(this).val();
                    if (poli_id) {
                        $.ajax({
                            type: "GET",
                            url: "<?php echo e(url('get-dokter-by-poli')); ?>/" + poli_id,
                            success: function(res) {
                                if (res) {
                                    $("#dokter_bpjs").empty();
                                    $.each(res, function(key, value) {
                                        $("#dokter_bpjs").append('<option value="' + key +
                                            '">' + value + '</option>');
                                    });
                                } else {
                                    $("#dokter_bpjs").empty();
                                }
                            }
                        });
                    } else {
                        $("#dokter_bpjs").empty();
                    }
                });
            });

            // pasien bpjs
            $(document).ready(function() {
                $('#norm').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: '/search_pasien_bpjs',
                            method: 'GET',
                            data: {
                                nama: request.term
                            },
                            success: function(data) {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.nama_pasien + ' - ' + item
                                            .bpjs + ' - ' + item.nik,
                                        value: item.no_rm
                                    };
                                }));
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX error: " + status + ' - ' + error);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        $('#norm').val(ui.item.label.split(' - ')[1]);
                        var selected_no_rm = ui.item.value;

                        $.ajax({
                            url: '/get_pasien_bpjs',
                            method: 'GET',
                            data: {
                                bpjs: selected_no_rm
                            },
                            success: function(response) {
                                // Menampilkan response dari controller di modal
                                $('#noRM').text(response.no_rm);
                                $('#namaPasien').text(response.nama_pasien);
                                $('#nikPasien').text(response.nik);
                                $('#tgllahirPasien').text(response.tgllahir);
                                $('#jekelPasien').text(response.jekel);
                                $('#namaKK').text(response.nama_kk);
                                $('#alamatPasien').text(response.alamat_asal);
                                $('#pekerjaanPasien').text(response.pekerjaan);
                                $('#hpPasien').text(response.noHP);
                                $('#alamatDomisili').text(response.domisili);
                                $('#jenisPasien').text(response.jenis_pasien);
                                $('#bpjsPasien').text(response.bpjs);

                                // Menampilkan elemen yang semula tersembunyi
                                $('#infoPasien').show();
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX error: " + status + ' - ' + error);
                            }
                        });
                        return false;
                    },
                    appendTo: "#autocompletebpjs-results" // Menetapkan elemen yang akan menampung hasil autocomplete
                });
            });

            function saveDataBpjs() {
                // Menampilkan efek loading
                $('#loadingSpinnerLama').removeClass('d-none');
                $('#simpanBpjs').prop('disabled', true); // Menonaktifkan tombol selama proses loading
                var formData = {
                    poli: document.getElementById('poli_bpjs').value,
                    dokter: document.getElementById('dokter_bpjs').value,
                    bpjs: document.getElementById('norm').value,
                };
                console.log(formData);
                // Melakukan validasi
                var errorMessages = [];

                // Validasi khusus
                if (!formData.poli) {
                    errorMessages.push("- Poli harus dipilih.");
                }
                if (!formData.dokter) {
                    errorMessages.push("- Dokter harus dipilih.");
                }
                if (!formData.bpjs) {
                    errorMessages.push("- No. BPJS harus diisi.");
                }

                // Jika ada error, menampilkan pesan kesalahan
                if (errorMessages.length > 0) {
                    $('#loadingSpinnerLama').addClass('d-none');
                    $('#simpanBpjs').prop('disabled', false);
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return; // Menghentikan eksekusi fungsi jika ada error
                }
                // console.log(formData);
                $.ajax({
                    url: '/pasien/store-bpjs', // Ganti dengan URL backend Anda
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Check if the server response contains the 'redirect' key
                        if (response.redirect) {
                            // Redirect to the specified URL
                            window.location.href = response.redirect;
                        } else {
                            // If no redirect URL is provided, you can handle it accordingly
                            console.error('No redirect URL provided in the server response.');
                        }

                    },
                    error: function(jqXHR) {
                        // Menyembunyikan efek loading
                        $('#loadingSpinnerLama').addClass('d-none');
                        $('#simpanBpjs').prop('disabled', false); // Mengaktifkan tombol setelah proses loading

                        if (jqXHR.status == 422) {
                            var errors = jqXHR.responseJSON;
                            var errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value);
                            });
                            // Menampilkan pesan kesalahan dengan alert
                            alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                        } else {
                            console.error('Error saat menyimpan data pasien: ', jqXHR);
                            // Handle error sesuai kebutuhan Anda
                        }
                    }

                });

            }

            // Kode pasien umum
            $(document).ready(function() {
                $('#poli_umum').change(function() {
                    var poli_id = $(this).val();
                    if (poli_id) {
                        $.ajax({
                            type: "GET",
                            url: "<?php echo e(url('get-dokter-by-poli')); ?>/" + poli_id,
                            success: function(res) {
                                if (res) {
                                    $("#dokter_umum").empty();
                                    $.each(res, function(key, value) {
                                        $("#dokter_umum").append('<option value="' + key +
                                            '">' + value + '</option>');
                                    });
                                } else {
                                    $("#dokter_umum").empty();
                                }
                            }
                        });
                    } else {
                        $("#dokter_umum").empty();
                    }
                });
            });

            // pasien umum
            $(document).ready(function() {
                $('#search_pasien').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: '/search_nama_pasien',
                            method: 'GET',
                            data: {
                                nama: request.term
                            },
                            success: function(data) {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.nama_pasien + ' - ' + item
                                            .nama_kk + ' - ' + item.alamat_asal,
                                        value: item.no_rm
                                    };
                                }));
                            }
                        });
                    },
                    minLength: 1,
                    select: function(event, ui) {
                        $('#search_pasien').val(ui.item.label.split(' - ')[0]);
                        var selected_no_rm = ui.item.value;

                        $.ajax({
                            url: '/get_pasien_details',
                            method: 'GET',
                            data: {
                                no_rm: selected_no_rm
                            },
                            success: function(response) {
                                $('#no_rm').val(response.no_rm);
                                $('#nik').val(response.nik);
                                $('#nama_kk').val(response.nama_kk);
                                $('#tgllahir').val(response.tgllahir);
                                $('#jekel').val(response.jekel);
                                $('#alamat_asal').val(response.alamat_asal);
                                $('#pekerjaan').val(response.pekerjaan);
                                $('#domisili').val(response.domisili);
                                $('#noHP').val(response.noHP);
                            }
                        });
                        return false;
                    },
                    appendTo: "#autocomplete-results" // Menetapkan elemen yang akan menampung hasil autocomplete
                }).focus(function() {
                    $(this).autocomplete("search", "");
                });
            });

            function saveData() {
                // Menampilkan efek loading
                $('#loadingSpinner').removeClass('d-none');
                $('#btnSimpan').prop('disabled', true); // Menonaktifkan tombol selama proses loading
                var formData = {
                    poli: document.getElementById('poli_umum').value,
                    dokter: document.getElementById('dokter_umum').value,
                    nama_pasien: document.getElementById('search_pasien').value,
                    no_rm: document.getElementById('no_rm').value,
                    nik: document.getElementById('nik').value,
                    nama_kk: document.getElementById('nama_kk').value,
                    pekerjaan: document.getElementById('pekerjaan').value,
                    tgllahir: document.getElementById('tgllahir').value,
                    jekel: document.getElementById('jekel').value,
                    alamat_asal: document.getElementById('alamat_asal').value,
                    domisili: document.getElementById('domisili').value,
                    noHP: document.getElementById('noHP').value,
                };

                // Melakukan validasi
                var errorMessages = [];

                // Validasi khusus
                if (!formData.poli) {
                    errorMessages.push("- Poli harus dipilih.");
                }
                if (!formData.dokter) {
                    errorMessages.push("- Dokter harus dipilih.");
                }
                if (!formData.no_rm) {
                    errorMessages.push("- No. RM harus diisi.");
                }
                if (!formData.nama_pasien) {
                    errorMessages.push("- Nama Pasien harus diisi.");
                }
                if (!formData.nik) {
                    errorMessages.push("- NIK harus diisi.");
                }
                if (!formData.nama_kk) {
                    errorMessages.push("- Nama Kepala Keluarga harus diisi.");
                }
                if (!formData.tgllahir) {
                    errorMessages.push("- Tanggal Lahir harus diisi.");
                }
                if (!formData.jekel) {
                    errorMessages.push("- Jenis kelamin harus dipilih.");
                }
                if (!formData.alamat_asal) {
                    errorMessages.push("- Alamat Asal harus diisi.");
                }
                if (!formData.pekerjaan) {
                    errorMessages.push("- Pekerjaan harus diisi.");
                }
                if (!formData.domisili) {
                    errorMessages.push("- Alamat Domisili harus diisi.");
                }
                if (!formData.noHP) {
                    errorMessages.push("- No. HP harus diisi.");
                }
                // Jika ada error, menampilkan pesan kesalahan
                if (errorMessages.length > 0) {
                    $('#loadingSpinner').addClass('d-none');
                    $('#btnSimpan').prop('disabled', false);
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return; // Menghentikan eksekusi fungsi jika ada error
                }

                // console.log(formData);
                $.ajax({
                    url: '/pasien/store-umum',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            console.error('No redirect URL provided in the server response.');
                        }
                    },
                    error: function(jqXHR) {
                        $('#loadingSpinner').addClass('d-none');
                        $('#btnSimpan').prop('disabled', false);

                        if (jqXHR.status == 422) {
                            var errors = jqXHR.responseJSON;
                            var errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value);
                            });
                            alert("Terjadi kesalahan: \n - " + errorMessages.join("\n"));
                        } else {
                            console.error('Error saat menyimpan data pasien: ', jqXHR);
                        }
                    }
                });

            }
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e84a5d9305f6227b2d9c78c854797728c150b58)): ?>
<?php $component = $__componentOriginal1e84a5d9305f6227b2d9c78c854797728c150b58; ?>
<?php unset($__componentOriginal1e84a5d9305f6227b2d9c78c854797728c150b58); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/pasien/index.blade.php ENDPATH**/ ?>