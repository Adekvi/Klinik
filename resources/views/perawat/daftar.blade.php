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
                            {{-- <li>Pasien yang sebelumnya pernah mendaftar, silahkan cari berdasarkan (Nama Pasien - Nama Kepala Keluaga - Alamat Asal).</li> --}}
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
                        <input type="text" class="form-control mt-2 mb-2 @error('noHP') is-invalid @enderror"
                            name="noHP" id="noHP" placeholder="Masukkan No. HP" required>
                        @error('noHP')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback" id="noHP-error" style="display: none;">No.HP harus berisi 10 sampai
                            13 karakter angka.</div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="no_rm">Poli</label>
                        <select name="poli" id="poli_umum" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Poli</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                            @endforeach
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
                            @foreach ($poli as $item)
                                <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                            @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-e31aEKZt0+4v+CZRwZy1VvLuR1PnKxZUEItwG5mISof8sCQ6k55s/O6Tt7V+HtGl" crossorigin="anonymous">
    </script>

    <script>
        // BUTTON KATEGORI
        document.getElementById('btnDewasa').addEventListener('click', function() {
            document.getElementById('kategori_pasien').value = 'dewasa';
            document.getElementById('msgDewasa').style.display = 'block';
            document.getElementById('msgAnak').style.display = 'none';
            document.getElementById('msgTanpaIdentitas').style.display = 'none';

            // Aktifkan field NIK dan nama KK untuk dewasa
            document.getElementById('nik').disabled = false;
            document.getElementById('nama_kk').disabled = false;
        });

        document.getElementById('btnAnak').addEventListener('click', function() {
            document.getElementById('kategori_pasien').value = 'anak';
            document.getElementById('msgAnak').style.display = 'block';
            document.getElementById('msgDewasa').style.display = 'none';
            document.getElementById('msgTanpaIdentitas').style.display = 'none';

            // Aktifkan field NIK dan nama KK untuk anak
            document.getElementById('nik').disabled = false;
            document.getElementById('nama_kk').disabled = false;
        });

        document.getElementById('btnTanpaIdentitas').addEventListener('click', function() {
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

        function showOptionalFields() {
            document.getElementById("nik-info").style.display = "block";
        }

        function showOptionalFieldsForTanpaIdentitas() {
            document.getElementById("nik-info").style.display = "block";
        }

        function hideOptionalFields() {
            document.getElementById("nik-info").style.display = "none";

            // Sembunyikan keterangan pekerjaan dan jadikan wajib isi kembali
            document.getElementById("pekerjaan-info").style.display = "none";
            document.getElementById("pekerjaan").setAttribute("required", "true");
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
            var successMessage = '{{ session('success') }}';
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

            // PASIEN BPJS Poli Untuk Dokter
            $('#poli_bpjs').change(function() {
                var poli_id = $(this).val();
                if (poli_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('get-dokter-by-poli') }}/" + poli_id,
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

            // PASIEN BARU Poli Untuk Dokter
            $('#poli_umum').change(function() {
                var poli_id = $(this).val();
                if (poli_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('get-dokter-by-poli') }}/" + poli_id,
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
                var nama = $('#id_bpjs').val().trim();
                console.log("Nilai input:", nama);

                if (!nama) {
                    alert("Harap masukkan No. RM atau No. BPJS atau NIK.");
                    return;
                }

                $('#loading').show();
                $(this).children('i').hide();

                $.ajax({
                    url: '/search_pasien_bpjs',
                    method: 'GET',
                    data: {
                        nama: nama
                    },
                    success: function(response) {
                        $('#loading').hide();
                        $('#searchBtn i').show();

                        if (response) {
                            var pasien = response;
                            $('#noRM').val(pasien.no_rm);
                            $('#namaPasien').val(pasien.nama_pasien);
                            $('#nikPasien').val(pasien.nik);
                            $('#tgllahirPasien').val(pasien.tgllahir);
                            $('#jekelPasien').val(pasien.jekel);
                            $('#namaKK').val(pasien.nama_kk);
                            $('#alamatPasien').val(pasien.alamat_asal);
                            $('#pekerjaanPasien').val(pasien.pekerjaan);
                            $('#hpPasien').val(pasien.noHP);
                            $('#alamatDomisili').val(pasien.domisili);
                            $('#jenisPasien').val(pasien.jenis_pasien);
                            $('#bpjsPasien').val(pasien.bpjs);
                            $('#infoPasien').show();
                        } else {
                            alert('Pasien tidak ditemukan.');
                            $('#infoPasien').hide();
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
                    poli: $('#poli_bpjs').val(),
                    dokter: $('#dokter_bpjs').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                var errorMessages = [];
                if (!formData.no_rm) errorMessages.push("No RM harus diisi.");
                if (!formData.nama_pasien) errorMessages.push("Nama pasien harus diisi.");
                if (!formData.nik) errorMessages.push("NIK harus diisi.");
                else if (formData.nik.length !== 16 || !/^\d+$/.test(formData.nik)) {
                    errorMessages.push("NIK harus terdiri dari 16 digit dan hanya angka.");
                } else {
                    const dayPart = parseInt(formData.nik.substr(6, 2));
                    const expectedJekel = dayPart < 40 ? 'L' : 'P';
                    if (formData.jekel !== 'L' && formData.jekel !== 'P') {
                        errorMessages.push("Jenis kelamin harus 'L' atau 'P'.");
                    } else if (formData.jekel !== expectedJekel) {
                        errorMessages.push("Jenis kelamin tidak sesuai dengan NIK.");
                    }
                }
                if (!formData.nama_kk) errorMessages.push("Nama Kepala Keluarga harus diisi.");
                if (!formData.tgllahir) errorMessages.push("Tanggal lahir harus diisi.");
                if (!formData.jekel) errorMessages.push("Jenis kelamin harus diisi.");
                if (!formData.alamat_asal) errorMessages.push("Alamat harus diisi.");
                if (!formData.noHP) errorMessages.push("No.Hp harus diisi.");
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
                            if (response.error === 'Pasien ini sudah mendaftar hari ini.') {
                                alert("Pasien ini telah mendaftar hari ini.");
                            } else {
                                alert("Gagal menyimpan: " + response.error);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
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
                            if (response.error === 'Pasien ini sudah mendaftar hari ini.') {
                                alert("Pasien ini telah mendaftar hari ini.");
                            } else {
                                alert("Validasi gagal: " + response.error);
                            }
                        } else {
                            console.error("Error Ajax:", xhr.responseText, status, error);
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
                            window.open(response.redirect, '_blank');
                            window.location.href = "{{ route('perawat.index') }}";
                        } else {
                            console.error('No redirect URL provided.');
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
@endpush
