<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Admin | Rekap Pasien Poli Umum']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h5>Poli Umum / <strong>Laporan Kunjungan Pasien BPJS</strong></h5>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="width: 40%; margin-bottom: 20px">
                        <div class="card-body">
                            <h5>Filter Pencarian</h5>
                            <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                <input class="form-check-input" type="radio" name="filter_option"
                                    id="filter_by_full_date">
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    style="width: 45%; margin-left: 20px">
                            </div>
                            <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                <input class="form-check-input" type="radio" name="filter_option"
                                    id="filter_by_month_year">
                                <div class="month_year" style="display: flex; margin-left: 20px">
                                    <select name="month" id="month" class="form-control" style="width: 62%">
                                        <!-- Opsi bulan akan ditambahkan secara dinamis oleh JavaScript -->
                                    </select>
                                    <select name="tahun" id="tahun" class="form-control"
                                        style="width: 40%; margin-left: 5px">
                                        <!-- Opsi tahun akan ditambahkan secara dinamis oleh JavaScript -->
                                    </select>
                                </div>
                            </div>
                            <p style="font-size: 14px; margin-bottom: 0px"><span style="color: red">* </span>Pilih salah
                                satu atau cetak semua data tanpa memilih</p>
                            <div class="button" style="display: flex; align-items: baseline">
                                <button type="button" id="btnSearch" class="btn btn-primary mt-3"><i
                                        class="fas fa-search"></i> Cari</button>
                                <button type="button" id="btnCetak" class="btn btn-warning mt-3"
                                    style="margin-left: 10px"><i class="fas fa-print"></i> Cetak</button>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle"
                                        style="margin-top: -3px; margin-left: 10px" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-file-excel"></i>
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="<?php echo e(url('/pasien-bpjs/export-excel')); ?>">Export to
                                            Excel</a>
                                        <a class="dropdown-item" href="#">Export to PDF</a>
                                        <a class="dropdown-item" href="#">Export to Word</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table mt-2 mb-2 table-striped table-bordered"
                                    style="width:100%">
                                    <thead class="table-primary" style="align-items: center">
                                        <tr>
                                            <th class="custom-th">NO.</th>
                                            <th class="custom-th">TANGGAL</th>
                                            <th class="custom-th">JAM</th>
                                            <th class="custom-th">NO. RM</th>
                                            <th class="custom-th">NAMA PASIEN</th>
                                            <th class="custom-th">JENIS PASIEN</th>
                                            <th class="custom-th">TANGGAL LAHIR</th>
                                            <th class="custom-th">NOMOR BPJS</th>
                                            <th class="custom-th">NOMOR NIK</th>
                                            <th class="custom-th">NOMOR HP</th>
                                            <th class="custom-th">PEKERJAAN</th>
                                            <th class="custom-th">NAMA KK</th>
                                            <th class="custom-th">ALAMAT</th>
                                            <th class="custom-th">KELUHAN (S)</th>
                                            <th class="custom-th">PEMERIKSAAN (O)</th>
                                            <th class="custom-th">DIAGNOSA (A)</th>
                                            <th class="custom-th">TINDAKAN (P)</th>
                                            <th class="custom-th">KETERANGAN</th>
                                            <th class="custom-th">AKSI</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                            $pasienCounts = [];
                                        ?>

                                        <?php $__currentLoopData = $umumBpjs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($item->pasien->jenis_pasien == 'Bpjs'): ?>
                                                <?php
                                                    $pasienId = $item->pasien->id;
                                                    if (!isset($pasienCounts[$pasienId])) {
                                                        $pasienCounts[$pasienId] = 1;
                                                    } else {
                                                        $pasienCounts[$pasienId]++;
                                                    }
                                                ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php $counter = 1; ?>

                                        <?php $__currentLoopData = $umumBpjs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($item->pasien->jenis_pasien == 'Bpjs'): ?>
                                                <?php
                                                    $pasienId = $item->pasien->id;
                                                    $statusPasien = $pasienCounts[$pasienId] > 1 ? 'Lama' : 'Baru';
                                                ?>
                                                <tr>
                                                    <td><?php echo e($counter++); ?></td>
                                                    <td><?php echo e(date('d/m/Y', strtotime($item->created_at))); ?></td>
                                                    <td><?php echo e(date('H:i:s', strtotime($item->created_at))); ?></td>
                                                    <td><?php echo e($item->pasien->no_rm); ?></td>
                                                    <td><?php echo e($item->pasien->nama_pasien); ?></td>
                                                    <td><?php echo e($statusPasien); ?></td>
                                                    <td><?php echo e(date('d/m/Y', strtotime($item->pasien->tgllahir))); ?></td>
                                                    <td><?php echo e($item->pasien->bpjs); ?></td>
                                                    <td><?php echo e($item->pasien->nik); ?></td>
                                                    <td><?php echo e($item->pasien->noHP); ?></td>
                                                    <td><?php echo e($item->pasien->pekerjaan); ?></td>
                                                    <td><?php echo e($item->pasien->nama_kk); ?></td>
                                                    <td><?php echo e($item->pasien->alamat_asal); ?></td>
                                                    <td><?php echo e($item->keluhan_utama); ?></td>
                                                    <td>Td : <?php echo e($item->p_tensi); ?> mmHg, <br> N : <?php echo e($item->p_nadi); ?>

                                                        x/m,
                                                        <br> R : <?php echo e($item->p_rr); ?> x/m, <br> S : <?php echo e($item->p_suhu); ?>

                                                        C,
                                                        <br> SpO2 : <?php echo e($item->spo2); ?> %, <br> BB :
                                                        <?php echo e($item->p_bb); ?>

                                                        kg, <br> TB : <?php echo e($item->p_tb); ?> cm
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $diagnosa = json_decode($item->soap_a_primer, true);
                                                        ?>
                                                        <?php $__currentLoopData = $diagnosa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diagno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            - <?php echo e($diagno); ?> <br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $resep = json_decode($item->soap_p, true);
                                                        ?>
                                                        <?php $__currentLoopData = $resep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            - <?php echo e($key); ?> <br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <td><?php echo e($item->rujuk ?? '-'); ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hapuspoli<?php echo e($item->id); ?>">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
        <style>
            .custom-th {
                min-width: 80px;
                /* Atur lebar minimum */
                max-width: 200px;
                /* Atur lebar maksimum */
                white-space: nowrap;
                /* Mencegah teks untuk melipat jika panjang */
                overflow: hidden;
                /* Menyembunyikan teks yang melebihi lebar maksimum */
                text-overflow: ellipsis;
                /* Menampilkan elipsis (...) jika teks melebihi lebar maksimum */
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>

        <script>
            new DataTable('#example');
            // jam dan tgl
            function updateClock() {
                var now = new Date();
                var tanggalElement =
                    document.getElementById('tanggal');
                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamElement = document.getElementById('jam');
                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');
                jamElement.innerHTML = '<h6>' + jamString + '</h6>';
            }
            setInterval(updateClock, 1000);
            updateClock();

            document.addEventListener('DOMContentLoaded', function() {
                const tanggalInput = document.getElementById('tanggal');
                const monthSelect = document.getElementById('month');
                const tahunSelect = document.getElementById('tahun');
                const filterByFullDate = document.getElementById('filter_by_full_date');
                const filterByMonthYear = document.getElementById('filter_by_month_year');
                const btnSearch = document.getElementById('btnSearch');
                const btnCetak = document.getElementById('btnCetak');

                // Tambahkan event listener untuk radio button 'Tanggal'
                filterByFullDate.addEventListener('change', function() {
                    if (this.checked) {
                        tanggalInput.disabled = false;
                        monthSelect.disabled = true;
                        tahunSelect.disabled = true;
                    }
                });

                // Tambahkan event listener untuk radio button 'Bulan dan Tahun'
                filterByMonthYear.addEventListener('change', function() {
                    if (this.checked) {
                        tanggalInput.disabled = true;
                        monthSelect.disabled = false;
                        tahunSelect.disabled = false;
                    }
                });

                btnSearch.addEventListener('click', function() {
                    let searchData;
                    if (filterByMonthYear.checked) {
                        const selectedMonth = monthSelect.value;
                        const selectedYear = tahunSelect.value;
                        searchData = {
                            type: 'month_year',
                            month: selectedMonth,
                            year: selectedYear
                        };
                    } else if (filterByFullDate.checked) {
                        const selectedDate = tanggalInput.value;
                        searchData = {
                            type: 'full_date',
                            date: selectedDate
                        };
                    } else {
                        console.log('Harap pilih opsi pencarian terlebih dahulu');
                        return;
                    }

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('/rekapan/bpjs/search', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(searchData),
                        })
                        .then(response => response.json())
                        .then(data => {
                            updateTable(data);
                        })
                        .catch(error => {
                            console.error('Terjadi kesalahan saat melakukan pencarian:', error);
                        });
                });
                btnCetak.addEventListener('click', function() {
                    // Panggil fungsi cetak tabel saat tombol cetak diklik
                    cetakHasilFilter();
                });

                function updateTable(data) {
                    const tableBody = document.querySelector('#example tbody');
                    // Kosongkan tabel
                    tableBody.innerHTML = '';

                    // Periksa apakah data kosong atau null
                    if (!data || data.length === 0) {
                        // Tambahkan pesan bahwa data tidak ada
                        const row = document.createElement('tr');
                        row.innerHTML = '<td colspan="20" style="text-align: center">Data tidak ada</td>';
                        tableBody.appendChild(row);
                        return; // Keluar dari fungsi setelah menambahkan pesan
                    }
                    // Jika ada data, tambahkan baris-baris baru berdasarkan data
                    var no = 1;
                    data.forEach(item => {
                        if (!item) return;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${no++}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.jam}</td>
                        <td>${item.no_rm}</td>
                        <td>${item.nama_pasien}</td>
                        <td>${item.jenis_pasien}</td>
                        <td>${item.tgllahir}</td>
                        <td>${item.nomor_bpjs}</td>
                        <td>${item.nik}</td>
                        <td>${item.noHP}</td>
                        <td>${item.pekerjaan}</td>
                        <td>${item.nama_kk}</td>
                        <td>${item.alamat_asal}</td>
                        <td>${item.keluhan_utama}</td>
                        <td>
                        Td : ${item.p_tensi} mmHg, <br>
                            N : ${item.p_nadi} x/m, <br>
                            R : ${item.p_rr} x/m, <br>
                            S : ${item.p_suhu} C, <br>
                            SpO2 :${item.spo2} %<br>
                            BB : ${item.p_bb} kg, <br>
                            TB : ${item.p_tb} cm, <br>
                        </td>
                        <td>
                            ${item.soap_a_primer}
                        </td>
                        <td>
                            ${item.soap_p}
                        </td>
                        <td style="text-align: center;">
                            ${item.rujuk ?? ' - '}
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#hapuspoli${item.id}">
                                <i class="fas fa-trash"></i> Hapus</button>
                        </td>
                    `;
                        tableBody.appendChild(row);
                    });

                }

                function cetakHasilFilter() {
                    // Data filter yang akan dikirim
                    let searchData;
                    if (filterByMonthYear.checked) {
                        const selectedMonth = monthSelect.value;
                        const selectedYear = tahunSelect.value;
                        searchData = {
                            type: 'month_year',
                            month: selectedMonth,
                            year: selectedYear
                        };
                    } else if (filterByFullDate.checked) {
                        const selectedDate = tanggalInput.value;
                        searchData = {
                            type: 'full_date',
                            date: selectedDate
                        };
                    } else {
                        // Jika tidak ada filter yang dipilih, kirim permintaan pencetakan tanpa data filter
                        searchData = {
                            type: 'no_filter'
                        };
                    }
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    // Kirim data filter ke route pencetakan menggunakan AJAX
                    fetch('/rekapan/bpjs/cetak', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken // Sesuaikan dengan cara Anda mendapatkan token CSRF
                            },
                            body: JSON.stringify(searchData),
                        })
                        .then(response => response.text())
                        .then(html => {
                            // Membuka jendela baru dan menuliskan HTML ke dalamnya untuk pencetakan
                            const newWindow = window.open('', '_blank');
                            newWindow.document.write(html);
                            newWindow.document.close();
                            newWindow.print(); // Melakukan pencetakan pada jendela baru
                        })
                        .catch(error => {
                            console.error('Terjadi kesalahan saat mencetak:', error);
                        });
                }

                // Dapatkan tahun saat ini
                const currentYear = new Date().getFullYear();
                const startYear = currentYear - 10;
                const endYear = currentYear;

                // Buat opsi tahun secara dinamis
                for (let year = endYear; year >= startYear; year--) {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    tahunSelect.appendChild(option);
                }

                // Buat opsi bulan secara dinamis
                const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                    "Oktober", "November", "Desember"
                ];
                months.forEach((month, index) => {
                    const option = document.createElement('option');
                    option.value = index + 1;
                    option.textContent = month;
                    monthSelect.appendChild(option);
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/admin/rekapan/pasien-bpjs/index.blade.php ENDPATH**/ ?>