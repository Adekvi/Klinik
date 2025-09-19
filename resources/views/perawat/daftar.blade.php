@extends('admin.layout.dasbrod')
@section('title', 'Perawat')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mt-4">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">@yield('title') /</span> Pendaftaran Pasien
            </h4>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        {{-- <li class="nav-item">
                                <a class="nav-link" href="pages-account-settings-account.html"><i
                                        class="bx bx-user me-1"></i> Account</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                        class="bx bx-bell me-1"></i> Notifications</a>
                            </li> --}}
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                Pendaftaran</a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-md-0 mb-4">
                            <div class="card">
                                <h5 class="card-header">Pasien Baru</h5>
                                <div class="card-body">
                                    <p>Selamat datang! Silakan lakukan pendaftaran sebagai pasien baru dengan mengisi data
                                        lengkap Anda untuk mendapatkan layanan terbaik dari kami.</p>
                                    <!-- Connections -->
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="text-center d-flex flex-column align-items-center">
                                            <!-- Teks dan ikon di atas -->
                                            <button
                                                class="btn btn-outline-primary d-flex align-items-center justify-content-center p-2 mb-2"
                                                data-bs-target="#pasienbaru" data-bs-toggle="modal">
                                                <i class="bx bx-plus-circle me-2"></i> Pasien Baru
                                            </button>
                                            <!-- Gambar di bawah -->
                                            <img src="{{ asset('aset/img/baru.png') }}" alt="Pasien Baru"
                                                style="width: 60%; height: auto;">
                                        </div>
                                    </div>

                                    <!-- /Connections -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <h5 class="card-header">Pasien Lama</h5>
                                <div class="card-body">
                                    <p>Halo kembali! Silakan masuk menggunakan nomor rekam medis Anda untuk mempercepat
                                        proses pendaftaran dan mendapatkan layanan yang lebih mudah.</p>
                                    <!-- Social Accounts -->
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="text-center d-flex flex-column align-items-center">
                                            <!-- Teks dan ikon di atas -->
                                            <button
                                                class="btn btn-outline-primary d-flex align-items-center justify-content-center p-2 mb-2"
                                                data-bs-target="#pasienlama" data-bs-toggle="modal">
                                                <i class="bx bx-plus-circle me-2"></i> Pasien Lama
                                            </button>
                                            <!-- Gambar di bawah -->
                                            <img src="{{ asset('aset/img/baru.png') }}" alt="Pasien Baru"
                                                style="width: 60%; height: auto;">
                                        </div>
                                    </div>

                                    <!-- /Social Accounts -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PASIEN BARU -->
    <div class="modal fade" id="pasienbaru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Pendaftaran Pasien
                        Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kategori" id="kategori_pasien">
                    <input type="hidden" name="status" id="status_pasien" value="baru">
                    <div style="font-size: 15px; background: rgb(241, 241, 241); padding: 5px; border-radius: 5px">
                        <span style="color: green;">Informasi:</span>
                        <ul style="margin-bottom: 0px">
                            <li>Pasien yang baru mendaftar silakan mengisi lengkap untuk melanjutkan pemeriksaan.</li>
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
                        <input type="text" class="form-control mt-2 mb-2 @error('nik') is-invalid @enderror"
                            name="nik" id="nik" placeholder="Masukkan NIK">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback" id="nik-error" style="display: none;">NIK harus berisi 16 karakter
                            angka.</div>
                        <div class="text mt-2 mb-2" id="nik-info" style="display: none;">*NIK Tidak Wajib Diisi!</div>
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
                        <select class="form-control mt-2 mb-2 @error('jekel') is-invalid @enderror" name="jekel"
                            id="jekel" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jekel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback" id="jekel-error" style="display: none;">Jenis kelamin tidak sesuai
                            dengan NIK.</div>
                    </div>
                    <div class="form-group">
                        <label for="alamat_asal">Alamat Asal</label>
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
                    <div class="form-group" id="nobpjs" style="display: none;">
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
                        <div class="text mt-2 mb-2" id="pekerjaan-info" style="display: none;">*Pekerjaan Tidak Wajib
                            Diisi!</div>
                    </div>
                    <div class="form-group">
                        <label for="domisili">Alamat Domisili</label>
                        <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisili"
                            placeholder="Masukkan Alamat Domisili" required>
                    </div>
                    <div class="form-group">
                        <label for="noHP">No. HP</label>
                        <input type="text" class="form-control mt-2 mb-2 @error('noHP') is-invalid @enderror"
                            name="noHP" id="noHP" placeholder="08123456789" required>
                        @error('noHP')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback" id="noHP-error" style="display: none;">No.HP harus berisi 10 sampai
                            13 karakter angka.</div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="poli_umum">Poli</label>
                        <select name="poli" id="poli_umum" class="form-control mt-2 mb-2">
                            <option value="" disabled selected>Pilih Poli</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter_umum">Dokter</label>
                        <select name="dokter" id="dokter_umum" class="form-control mt-2 mb-2" disabled>
                            <option value="">Pilih Dokter</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan">
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
                        Lama</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertMessage" class="alert d-none"></div>
                    <div style="font-size: 15px; background: rgb(241, 241, 241); padding: 5px; border-radius: 5px">
                        <span style="color: green;">Informasi :</span>
                        <ul style="margin-bottom: 0px">
                            <li>Cari data pasien berdasarkan (No. BPJS / NIK / No. RM).</li>
                            <li>- No. Rekam Medis</li>
                            <li>- NIK berjumlah 16 digit</li>
                            <li>- No. BPJS berjumlah 13 digit</li>
                        </ul>
                    </div>
                    <div class="form-group mt-2">
                        <label for="poli">Poli</label>
                        <select name="poli" id="poli_bpjs" class="form-control mt-2 mb-2" required>
                            <option value="" disabled selected>Pilih Poli</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokter">Dokter</label>
                        <select name="dokter" id="dokter_bpjs" class="form-control mt-2 mb-2" required>
                            <option value="" disabled selected>Pilih Dokter</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="identifier">No. RM / No. BPJS / KTP / Nama Pasien</label>
                        <div class="cari mt-2 mb-2" style="display: flex; align-items: center">
                            <input type="text" class="form-control mb-2" name="identifier" id="id_bpjs"
                                placeholder="Masukkan No. RM atau No.BPJS atau KTP atau Nama Pasien" required>
                            <button id="searchBtn" class="btn btn-primary search mb-2"
                                style="margin-left: 9px; height: 40px;">
                                <i class="fas fa-search"></i>
                                <span id="loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                            <div id="autocompletebpjs-results" class="autocomplete-results"></div>
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
                                            style="font-weight: bold;" readonly required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Nama Pasien</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="nama_pasien" id="namaPasien"
                                            placeholder="Nama Pasien" required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Nama KK</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="nama_kk" id="namaKK"
                                            placeholder="Nama KK" required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Alamat Asal</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="alamat_asal" id="alamatPasien"
                                            placeholder="Alamat Asal" required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">NIK</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="nik" id="nikPasien"
                                            placeholder="NIK" required maxlength="16"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Tanggal Lahir</th>
                                    <td>:</td>
                                    <td><input type="date" class="form-control" name="tgllahir" id="tgllahirPasien"
                                            required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Jenis Kelamin</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="jekel" id="jekelPasien"
                                            placeholder="Jenis Kelamin (L/P)" required maxlength="1"></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Pekerjaan</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="pekerjaan" id="pekerjaanPasien"
                                            placeholder="Pekerjaan" required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Alamat Domisili</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="domisili" id="alamatDomisili"
                                            placeholder="Alamat Domisili" required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">No. HP</th>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" name="noHP" id="hpPasien"
                                            placeholder="No. HP" required></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 35%">Jenis Pasien</th>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" id="jenisPasien" name="jenis_pasien" required>
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
                                            placeholder="No. BPJS" maxlength="13"></td>
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

@endsection

@push('style')
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

        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Memuat JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // BUTTON KATEGORI
            const btnDewasa = document.getElementById('btnDewasa');
            const btnAnak = document.getElementById('btnAnak');
            const btnTanpaIdentitas = document.getElementById('btnTanpaIdentitas');

            if (btnDewasa) {
                btnDewasa.addEventListener('click', function() {
                    document.getElementById('kategori_pasien').value = 'dewasa';
                    document.getElementById('msgDewasa').style.display = 'block';
                    document.getElementById('msgAnak').style.display = 'none';
                    document.getElementById('msgTanpaIdentitas').style.display = 'none';

                    // Aktifkan field NIK dan nama KK untuk dewasa
                    document.getElementById('nik').disabled = false;
                    document.getElementById('nama_kk').disabled = false;
                });
            } else {
                console.error('Elemen btnDewasa tidak ditemukan');
            }

            if (btnAnak) {
                btnAnak.addEventListener('click', function() {
                    document.getElementById('kategori_pasien').value = 'anak';
                    document.getElementById('msgAnak').style.display = 'block';
                    document.getElementById('msgDewasa').style.display = 'none';
                    document.getElementById('msgTanpaIdentitas').style.display = 'none';

                    // Aktifkan field NIK dan nama KK untuk anak
                    document.getElementById('nik').disabled = false;
                    document.getElementById('nama_kk').disabled = false;
                });
            } else {
                console.error('Elemen btnAnak tidak ditemukan');
            }

            if (btnTanpaIdentitas) {
                btnTanpaIdentitas.addEventListener('click', function() {
                    document.getElementById('kategori_pasien').value = 'tanpa_identitas';
                    document.getElementById('msgTanpaIdentitas').style.display = 'block';
                    document.getElementById('msgDewasa').style.display = 'none';
                    document.getElementById('msgAnak').style.display = 'none';

                    // Nonaktifkan field NIK dan kosongkan nilainya
                    document.getElementById('nik').disabled = true;
                    document.getElementById('nik').value = '';

                    // Nonaktifkan nama KK dan set default
                    document.getElementById('nama_kk').disabled = true;
                    document.getElementById('nama_kk').value = 'TIDAK DIKETAHUI';
                });
            } else {
                console.error('Elemen btnTanpaIdentitas tidak ditemukan');
            }

            // Format tanggal dd/mm/yyyy
            const tgllahirInput = document.getElementById('tgllahir');
            if (tgllahirInput) {
                tgllahirInput.addEventListener('input', function(e) {
                    let input = e.target.value.replace(/[^0-9]/g, '');
                    if (input.length >= 8) {
                        const formattedInput = input.replace(/^(\d{2})(\d{2})(\d{4})$/, '$1/$2/$3');
                        e.target.value = formattedInput;
                    } else {
                        e.target.value = input;
                    }
                });

                tgllahirInput.addEventListener('blur', function(e) {
                    const input = e.target.value;
                    if (!/^\d{2}\/\d{2}\/\d{4}$/.test(input)) {
                        e.target.value = '';
                        alert('Format tanggal harus dd/mm/yyyy');
                    }
                });
            } else {
                console.error('Elemen tgllahir tidak ditemukan');
            }

            // No. RM Pasien
            fetch('/pasien/latest-no-rm')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('no_rm').value = data.no_rm;
                })
                .catch(error => {
                    console.error('Error fetching the latest No. RM:', error);
                });

            // Validasi NIK
            const nikInput = document.getElementById('nik');
            const nikError = document.getElementById('nik-error');
            if (nikInput && nikError) {
                nikInput.addEventListener('input', function() {
                    const nik = nikInput.value;
                    if (nik.length === 16 && /^\d+$/.test(nik)) {
                        nikInput.classList.remove('is-invalid');
                        nikError.style.display = 'none';
                    } else {
                        nikInput.classList.add('is-invalid');
                        nikError.style.display = 'block';
                    }
                });
            } else {
                console.error('Elemen nik atau nik-error tidak ditemukan');
            }

            // Validasi Jenis Kelamin Berdasarkan NIK
            const jekelInput = document.getElementById('jekel');
            const jekelError = document.getElementById('jekel-error');
            if (nikInput && jekelInput && nikError && jekelError) {
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

                        if (nik.length === 16 && /^\d+$/.test(nik)) {
                            nikInput.classList.remove('is-invalid');
                            nikError.style.display = 'none';
                        } else {
                            nikInput.classList.add('is-invalid');
                            nikError.style.display = 'block';
                        }

                        if (jekel === genderFromNIK) {
                            jekelInput.classList.remove('is-invalid');
                            jekelError.style.display = 'none';
                        } else {
                            jekelInput.classList.add('is-invalid');
                            jekelError.style.display = 'block';
                        }
                    } else {
                        nikInput.classList.remove('is-invalid');
                        nikError.style.display = 'none';
                        if (jekel) {
                            jekelInput.classList.remove('is-invalid');
                            jekelError.style.display = 'none';
                        } else {
                            jekelInput.classList.add('is-invalid');
                            jekelError.style.display = 'block';
                        }
                    }
                }
            } else {
                console.error('Elemen untuk validasi NIK atau jenis kelamin tidak ditemukan');
            }

            // Jenis pasien Bpjs
            const jenisPasienSelect = document.getElementById('jenis_pasien');
            const nobpjs = document.getElementById('nobpjs');
            const normInput = document.getElementById('norm');
            const nobpjsError = document.getElementById('nobpjsError');
            if (jenisPasienSelect && nobpjs && normInput && nobpjsError) {
                console.log('Elemen jenis_pasien ditemukan, menambahkan event listener');
                jenisPasienSelect.addEventListener('change', function() {
                    console.log('Jenis pasien dipilih:', this.value);
                    if (this.value === 'Bpjs') {
                        console.log('Menampilkan field No. BPJS');
                        nobpjs.style.display = 'block';
                    } else {
                        console.log('Menyembunyikan field No. BPJS');
                        nobpjs.style.display = 'none';
                        nobpjsError.style.display = 'none';
                        normInput.classList.remove('is-invalid');
                    }
                });

                nobpjs.style.display = 'none';

                normInput.addEventListener('input', function() {
                    const bpjs = normInput.value;
                    if (bpjs.length === 13 && /^\d+$/.test(bpjs)) {
                        nobpjsError.style.display = 'none';
                        normInput.classList.remove('is-invalid');
                    } else {
                        nobpjsError.style.display = 'block';
                        normInput.classList.add('is-invalid');
                    }
                });
            } else {
                console.error('Elemen jenis_pasien, nobpjs, norm, atau nobpjsError tidak ditemukan');
            }

            // Validasi No. HP
            const noHPInput = document.getElementById('noHP');
            const noHPError = document.getElementById('noHP-error');
            if (noHPInput && noHPError) {
                noHPInput.addEventListener('input', function() {
                    const noHP = noHPInput.value;
                    if ((noHP.length >= 10 && noHP.length <= 13) && /^\d+$/.test(noHP)) {
                        noHPInput.classList.remove('is-invalid');
                        noHPError.style.display = 'none';
                    } else {
                        noHPInput.classList.add('is-invalid');
                        noHPError.style.display = 'block';
                    }
                });
            } else {
                console.error('Elemen noHP atau noHP-error tidak ditemukan');
            }

            // Event listener untuk tombol Simpan
            const btnSimpan = document.getElementById('btnSimpan');
            if (btnSimpan) {
                btnSimpan.addEventListener('click', function() {
                    console.log('Tombol Simpan diklik');
                    saveData();
                });
            } else {
                console.error('Elemen btnSimpan tidak ditemukan');
            }
        });

        function showOptionalFields() {
            const nikInfo = document.getElementById('nik-info');
            if (nikInfo) nikInfo.style.display = 'block';
        }

        function showOptionalFieldsForTanpaIdentitas() {
            const nikInfo = document.getElementById('nik-info');
            if (nikInfo) nikInfo.style.display = 'block';
        }

        function hideOptionalFields() {
            const nikInfo = document.getElementById('nik-info');
            const pekerjaanInfo = document.getElementById('pekerjaan-info');
            const pekerjaan = document.getElementById('pekerjaan');
            if (nikInfo) nikInfo.style.display = 'none';
            if (pekerjaanInfo && pekerjaan) {
                pekerjaanInfo.style.display = 'none';
                pekerjaan.setAttribute('required', 'true');
            }
        }

        function convertToDate(input) {
            const parts = input.split('/');
            return parts[2] + '-' + parts[1] + '-' + parts[0]; // Convert to yyyy-mm-dd
        }

        function refreshCsrfToken(callback) {
            if (!window.jQuery) {
                console.error('jQuery tidak dimuat');
                alert('Terjadi kesalahan: jQuery tidak dimuat.');
                return;
            }
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

        function keepSessionAlive() {
            if (!window.jQuery) {
                console.error('jQuery tidak dimuat');
                return;
            }
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
            }, 15 * 60 * 1000);
        }

        function handleSessionExpired() {
            alert('Sesi telah berakhir. Anda akan diarahkan ke halaman login.');
            window.location.href = '/login';
        }

        $(document).ready(function() {
            if (!window.jQuery) {
                console.error('jQuery tidak dimuat');
                alert('Terjadi kesalahan: jQuery tidak dimuat.');
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            keepSessionAlive();

            const poliBpjs = document.getElementById('poli_bpjs');
            if (poliBpjs) {
                poliBpjs.addEventListener('change', function() {
                    const poli_id = this.value;
                    if (poli_id) {
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('get-dokter-by-poli') }}/" + poli_id,
                            success: function(res) {
                                const dokterBpjs = document.getElementById('dokter_bpjs');
                                if (dokterBpjs) {
                                    dokterBpjs.innerHTML =
                                        '<option value="">Pilih Dokter</option>';
                                    if (res) {
                                        $.each(res, function(key, value) {
                                            dokterBpjs.insertAdjacentHTML('beforeend',
                                                '<option value="' + key + '">' +
                                                value + '</option>');
                                        });
                                    }
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
                                    const dokterBpjs = document.getElementById('dokter_bpjs');
                                    if (dokterBpjs) dokterBpjs.innerHTML =
                                        '<option value="">Pilih Dokter</option>';
                                }
                            }
                        });
                    } else {
                        const dokterBpjs = document.getElementById('dokter_bpjs');
                        if (dokterBpjs) dokterBpjs.innerHTML = '<option value="">Pilih Dokter</option>';
                    }
                });
            }

            const poliUmum = document.getElementById('poli_umum');
            if (poliUmum) {
                poliUmum.addEventListener('change', function() {
                    const poli_id = this.value;
                    if (poli_id) {
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('get-dokter-by-poli') }}/" + poli_id,
                            success: function(res) {
                                const dokterUmum = document.getElementById('dokter_umum');
                                if (dokterUmum) {
                                    dokterUmum.innerHTML =
                                        '<option value="">Pilih Dokter</option>';
                                    dokterUmum.disabled = false;
                                    if (res) {
                                        $.each(res, function(key, value) {
                                            dokterUmum.insertAdjacentHTML('beforeend',
                                                '<option value="' + key + '">' +
                                                value + '</option>');
                                        });
                                    }
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
                                    const dokterUmum = document.getElementById('dokter_umum');
                                    if (dokterUmum) {
                                        dokterUmum.innerHTML =
                                            '<option value="">Pilih Dokter</option>';
                                        dokterUmum.disabled = true;
                                    }
                                }
                            }
                        });
                    } else {
                        const dokterUmum = document.getElementById('dokter_umum');
                        if (dokterUmum) {
                            dokterUmum.innerHTML = '<option value="">Pilih Dokter</option>';
                            dokterUmum.disabled = true;
                        }
                    }
                });
            }

            const searchBtn = document.getElementById('searchBtn');
            if (searchBtn) {
                searchBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const identifier = document.getElementById('id_bpjs') ? document.getElementById(
                        'id_bpjs').value.trim() : '';
                    console.log("Nilai input:", identifier);

                    if (!identifier) {
                        alert("Harap masukkan No. RM, No. BPJS, NIK, atau Nama Pasien.");
                        return;
                    }

                    const loading = document.getElementById('loading');
                    if (loading) loading.style.display = 'block';
                    this.querySelector('i').style.display = 'none';

                    $.ajax({
                        url: '/search_pasien_bpjs',
                        method: 'GET',
                        data: {
                            nama: identifier
                        },
                        success: function(response) {
                            if (loading) loading.style.display = 'none';
                            const searchBtnIcon = document.querySelector('#searchBtn i');
                            if (searchBtnIcon) searchBtnIcon.style.display = 'inline';

                            if (response.error) {
                                alert(response.error);
                                const infoPasien = document.getElementById('infoPasien');
                                if (infoPasien) infoPasien.style.display = 'none';
                            } else {
                                const fields = {
                                    noRM: 'no_rm',
                                    namaPasien: 'nama_pasien',
                                    nikPasien: 'nik',
                                    tgllahirPasien: 'tgllahir',
                                    jekelPasien: 'jekel',
                                    namaKK: 'nama_kk',
                                    alamatPasien: 'alamat_asal',
                                    pekerjaanPasien: 'pekerjaan',
                                    hpPasien: 'noHP',
                                    alamatDomisili: 'domisili',
                                    jenisPasien: 'jenis_pasien',
                                    bpjsPasien: 'bpjs'
                                };
                                Object.keys(fields).forEach(id => {
                                    const element = document.getElementById(id);
                                    if (element) {
                                        element.value = response[fields[id]] || '';
                                    }
                                });
                                const infoPasien = document.getElementById('infoPasien');
                                if (infoPasien) infoPasien.style.display = 'block';
                            }
                        },
                        error: function(xhr) {
                            if (loading) loading.style.display = 'none';
                            const searchBtnIcon = document.querySelector('#searchBtn i');
                            if (searchBtnIcon) searchBtnIcon.style.display = 'inline';
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
            }

            if (jQuery().autocomplete) {
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
                                            label: item.nama_pasien + ' - ' + (
                                                item.bpjs || '') + ' - ' + (
                                                item.nik || ''),
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
                        const selected_no_rm = ui.item.value;

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
                                    const fields = {
                                        noRM: 'no_rm',
                                        namaPasien: 'nama_pasien',
                                        nikPasien: 'nik',
                                        tgllahirPasien: 'tgllahir',
                                        jekelPasien: 'jekel',
                                        namaKK: 'nama_kk',
                                        alamatPasien: 'alamat_asal',
                                        pekerjaanPasien: 'pekerjaan',
                                        hpPasien: 'noHP',
                                        alamatDomisili: 'domisili',
                                        jenisPasien: 'jenis_pasien',
                                        bpjsPasien: 'bpjs'
                                    };
                                    Object.keys(fields).forEach(id => {
                                        const element = document.getElementById(id);
                                        if (element) {
                                            element.value = response[fields[id]] ||
                                                '';
                                        }
                                    });
                                    const infoPasien = document.getElementById(
                                    'infoPasien');
                                    if (infoPasien) infoPasien.style.display = 'block';
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
            } else {
                console.error('jQuery UI Autocomplete tidak dimuat');
            }
        });

        function saveDataBpjs() {
            const loadingSpinnerLama = document.getElementById('loadingSpinnerLama');
            const simpanBpjs = document.getElementById('simpanBpjs');
            if (loadingSpinnerLama) loadingSpinnerLama.classList.remove('d-none');
            if (simpanBpjs) simpanBpjs.disabled = true;

            function attemptSave() {
                const formData = {
                    no_rm: document.getElementById('noRM') ? document.getElementById('noRM').value : '',
                    nama_pasien: document.getElementById('namaPasien') ? document.getElementById('namaPasien').value :
                        '',
                    nik: document.getElementById('nikPasien') ? document.getElementById('nikPasien').value : '',
                    nama_kk: document.getElementById('namaKK') ? document.getElementById('namaKK').value : '',
                    tgllahir: document.getElementById('tgllahirPasien') ? document.getElementById('tgllahirPasien')
                        .value : '',
                    jekel: document.getElementById('jekelPasien') ? document.getElementById('jekelPasien').value : '',
                    alamat_asal: document.getElementById('alamatPasien') ? document.getElementById('alamatPasien')
                        .value : '',
                    noHP: document.getElementById('hpPasien') ? document.getElementById('hpPasien').value : '',
                    domisili: document.getElementById('alamatDomisili') ? document.getElementById('alamatDomisili')
                        .value : '',
                    jenis_pasien: document.getElementById('jenisPasien') ? document.getElementById('jenisPasien')
                        .value : '',
                    pekerjaan: document.getElementById('pekerjaanPasien') ? document.getElementById('pekerjaanPasien')
                        .value : '',
                    bpjs: document.getElementById('bpjsPasien') ? document.getElementById('bpjsPasien').value : '',
                    poli: document.getElementById('poli_bpjs') ? document.getElementById('poli_bpjs').value : '',
                    dokter: document.getElementById('dokter_bpjs') ? document.getElementById('dokter_bpjs').value : '',
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                const errorMessages = [];
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
                    if (loadingSpinnerLama) loadingSpinnerLama.classList.add('d-none');
                    if (simpanBpjs) simpanBpjs.disabled = false;
                    alert("Validasi Gagal:\n" + errorMessages.join("\n"));
                    return;
                }

                $.ajax({
                    url: '/pasien/store-bpjs',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (loadingSpinnerLama) loadingSpinnerLama.classList.add('d-none');
                        if (simpanBpjs) simpanBpjs.disabled = false;

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
                        if (loadingSpinnerLama) loadingSpinnerLama.classList.add('d-none');
                        if (simpanBpjs) simpanBpjs.disabled = false;

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

        function saveData() {
            console.log('Fungsi saveData dipanggil');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const btnSimpan = document.getElementById('btnSimpan');
            if (loadingSpinner) loadingSpinner.classList.remove('d-none');
            if (btnSimpan) btnSimpan.disabled = true;

            function attemptSave() {
                const kategoriPasien = document.getElementById('kategori_pasien') ? document.getElementById(
                    'kategori_pasien').value || 'dewasa' : 'dewasa';
                if (document.getElementById('kategori_pasien')) {
                    document.getElementById('kategori_pasien').value = kategoriPasien;
                }

                const tgllahirInput = document.getElementById('tgllahir') ? document.getElementById('tgllahir').value : '';
                const tgllahirFormatted = tgllahirInput ? convertToDate(tgllahirInput) : '';

                const formData = {
                    poli: document.getElementById('poli_umum') ? document.getElementById('poli_umum').value : '',
                    dokter: document.getElementById('dokter_umum') ? document.getElementById('dokter_umum').value : '',
                    nama_pasien: document.getElementById('search_pasien') ? document.getElementById('search_pasien')
                        .value : '',
                    no_rm: document.getElementById('no_rm') ? document.getElementById('no_rm').value : '',
                    nik: document.getElementById('nik') ? document.getElementById('nik').value || '' : '',
                    nama_kk: document.getElementById('nama_kk') ? document.getElementById('nama_kk').value : '',
                    pekerjaan: document.getElementById('pekerjaan') ? document.getElementById('pekerjaan').value || '' :
                        '',
                    tgllahir: tgllahirFormatted,
                    jekel: document.getElementById('jekel') ? document.getElementById('jekel').value : '',
                    alamat_asal: document.getElementById('alamat_asal') ? document.getElementById('alamat_asal').value :
                        '',
                    jenis_pasien: document.getElementById('jenis_pasien') ? document.getElementById('jenis_pasien')
                        .value : '',
                    bpjs: document.getElementById('norm') ? document.getElementById('norm').value : '',
                    domisili: document.getElementById('domisili') ? document.getElementById('domisili').value : '',
                    noHP: document.getElementById('noHP') ? document.getElementById('noHP').value : '',
                    kategori: kategoriPasien,
                    status: document.getElementById('status_pasien') ? document.getElementById('status_pasien').value :
                        'baru',
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                const errorMessages = [];
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
                if (formData.jenis_pasien === 'Bpjs' && (!formData.bpjs || formData.bpjs.length !== 13 || !/^\d+$/.test(
                        formData.bpjs))) {
                    errorMessages.push("- No. BPJS harus berisi 13 digit angka.");
                }

                if (errorMessages.length > 0) {
                    if (loadingSpinner) loadingSpinner.classList.add('d-none');
                    if (btnSimpan) btnSimpan.disabled = false;
                    alert("Terjadi kesalahan: \n" + errorMessages.join("\n"));
                    return;
                }

                console.log('Mengirim data:', formData);

                $.ajax({
                    url: '/pasien/store-umum',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Sukses menyimpan data:', response);
                        if (loadingSpinner) loadingSpinner.classList.add('d-none');
                        if (btnSimpan) btnSimpan.disabled = false;

                        if (response.redirect) {
                            alert("Data tersimpan! Data pasien berhasil disimpan.");
                            window.open(response.redirect, '_blank');
                            window.location.href = "{{ route('perawat.index') }}";
                        } else if (response.error) {
                            console.error('Gagal menyimpan:', response.error);
                            alert("Gagal menyimpan: " + response.error);
                        } else {
                            console.error('No redirect URL provided.');
                            alert("Gagal menyimpan: Tidak ada URL redirect.");
                        }
                    },
                    error: function(xhr) {
                        console.error('Error AJAX:', xhr.responseText);
                        if (loadingSpinner) loadingSpinner.classList.add('d-none');
                        if (btnSimpan) btnSimpan.disabled = false;

                        if (xhr.status === 419) {
                            console.warn('CSRF token kadaluarsa, memperbarui token...');
                            refreshCsrfToken(function() {
                                attemptSave();
                            });
                        } else if (xhr.status === 401) {
                            handleSessionExpired();
                        } else if (xhr.status === 422) {
                            const errors = xhr.responseJSON;
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
                            alert("Terjadi kesalahan: Gagal menyimpan data pasien. Status: " + xhr.status);
                        }
                    }
                });
            }

            attemptSave();
        }
    </script>
@endpush
