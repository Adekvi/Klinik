<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Apoteker | Rekap Obat Keluar']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="title text-start">
                <div class="judul d-flex justify-content-between align-items-center">
                    <h4><strong>Rekap Obat Keluar</strong></h4>
                    <div class="date-time d-flex align-items-center gap-2 text-center">
                        <div class="tanggal text-muted" id="tanggal"></div>
                        <div class="jam text-muted" id="jam"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
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
                            <div class="button" style="display: flex; align-items: baseline">
                                <button type="button" id="btnSearch" class="btn btn-primary mt-3"><i
                                        class="fas fa-search"></i> Cari</button>
                                <button type="button" id="btnCetak" class="btn btn-warning mt-3"
                                    style="margin-left: 10px"><i class="fas fa-download"></i> Unduh</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action=""
                                class="d-flex justify-content-between align-items-center mb-3">
                                <input type="hidden" name="page" value="1"> 
                                <div class="d-flex align-items-center">
                                    <label for="entries" class="me-2">Tampilkan:</label>
                                    <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                        style="width: 80px;" onchange="this.form.submit()">
                                        <option value="10" <?php echo e($entries == 10 ? 'selected' : ''); ?>>10
                                        </option>
                                        <option value="25" <?php echo e($entries == 25 ? 'selected' : ''); ?>>25
                                        </option>
                                        <option value="50" <?php echo e($entries == 50 ? 'selected' : ''); ?>>50
                                        </option>
                                        <option value="100" <?php echo e($entries == 100 ? 'selected' : ''); ?>>100
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center">
                                    <input type="text" name="search" value="<?php echo e($search); ?>"
                                        class="form-control form-control-sm me-2" style="width: 400px;"
                                        placeholder="Cari Nama Obat / Jumlah">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary text-center">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Obat</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $all = []; ?>

                                        <?php if($obat->isEmpty()): ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-3">
                                                    <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                    Tidak ada data obat yang tersedia
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $obat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $soapData = json_decode($item->resep, true);
                                                    // Pastikan $soapData adalah array sebelum melakukan array_keys
                                                    if (is_array($soapData)) {
                                                        $all = array_merge($all, array_keys($soapData));
                                                    }
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php $all = array_unique($all); ?>

                                            <?php $__currentLoopData = $obat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $namaObat = json_decode($item->obat_Ro_namaObatUpdate, true) ?? [];
                                                    $aturan = json_decode($item->obat_Ro_jumlah, true) ?? [];
                                                ?>

                                                <tr>
                                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                                    <td class="text-center">
                                                        <?php echo e(\Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y / H:i')); ?>

                                                    </td>
                                                    <td>
                                                        <?php $__empty_1 = true; $__currentLoopData = $namaObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <ul>
                                                                <li><?php echo e($resep); ?></li>
                                                            </ul>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <span class="text-muted">Tidak ada data</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php $__empty_1 = true; $__currentLoopData = $aturan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jumlah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <ul>
                                                                <li><?php echo e($jumlah); ?></li>
                                                            </ul>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <span class="text-muted">Tidak ada data</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-success">
                                                            <i class="fa-solid fa-circle-check"></i> Success
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                                <div class="halaman mt-3 d-flex justify-content-end">
                                    <?php echo e($obat->appends(request()->only(['search', 'entries']))->links()); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php $__currentLoopData = $obat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="riwayat<?php echo e($item['id']); ?>" tabindex="-1"
            aria-labelledby="exampleModalLabelAsesmen<?php echo e($item['id']); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" style="display: contents">
                <div class="modal-content" style="margin-top: 20px; width: 95%; margin-left: 3%;">
                    <div class="modal-header bg-primary">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Rincian Obat
                            Keluar
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container" style="margin-top: -10px">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <h2><strong><?php echo e($item->booking->pasien->nama_pasien); ?></strong></h2>
                                    <hr style="margin-top: -5px">
                                    <p style="font-size: 14px; margin-top: -5px">
                                        <strong>Sengonbugel RT.01/01, Mayong, Jepara</strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                    <p style="margin-top: -5px">
                                        <strong>
                                            <?php echo e($item->booking->pasien->alamat_asal); ?>,
                                            <?php echo e($item->booking->pasien->tgllahir); ?>

                                            (<?php echo e(\Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age); ?> Tahun)
                                        </strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Tinggi Badan</label>
                                            <span>:</span>
                                            <p><?php echo e($item->soap->p_tb); ?> Cm</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Berat Badan</label>
                                            <span>:</span>
                                            <p><?php echo e($item->soap->p_bb); ?> Kg</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Kelamin</label>
                                            <span>:</span>
                                            <p>
                                                <?php if($item->booking->pasien->jekel === 'P' ?? 'Perempuan'): ?>
                                                    Perempuan
                                                <?php elseif($item->booking->pasien->jekel === 'L' ?? 'Laki-laki'): ?>
                                                    Laki-laki
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top: -20px">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Pasien</label>
                                            <span>:</span>
                                            <p><?php echo e($item->booking->pasien->jenis_pasien); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Poli</label>
                                            <span>:</span>
                                            <p><?php echo e($item->soap->poli->namapoli); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No NIK</label>
                                            <span>:</span>
                                            <p><?php echo e($item->booking->pasien->nik); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No BPJS</label>
                                            <span>:</span>
                                            <p>
                                                <?php if(!empty($item->pasien->booking->bpjs)): ?>
                                                    <?php echo e($item->pasien->booking->bpjs); ?>

                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead class="table-primary" style="text-align: center;">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Obat</th>
                                        <th>Aturan Minum</th>
                                        <th>Anjuran Minum</th>
                                        <th>Jenis Obat</th>
                                        <th>Jumlah</th>
                                        <th>Aturan Tambahan</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align: center;">
                                    <?php
                                        $jenengObat = json_decode($item->obat_Ro_namaObatUpdate, true) ?? [];
                                        $aturanNgombe = json_decode($item->obat_Ro_aturan, true) ?? [];
                                        $anjuranNgombe = json_decode($item->obat_Ro_anjuran, true) ?? [];
                                        $jenisNgombe = json_decode($item->obat_Ro_jenisObat, true) ?? [];
                                        $jumlahNgombe = json_decode($item->obat_Ro_jumlah, true) ?? [];
                                    ?>
                                    <tr>
                                        <td><?php echo e(date_format(date_create($item->created_at), 'Y-m-d / H:i:s')); ?></td>
                                        <td style="text-align: left">
                                            <?php $__currentLoopData = $jenengObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jeneng): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <ul>
                                                    <li><?php echo e($jeneng); ?></li>
                                                </ul>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td style="text-align: left">
                                            <?php $__currentLoopData = $aturanNgombe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <ul>
                                                    <li><?php echo e($tata); ?></li>
                                                </ul>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td style="text-align: left">
                                            <?php $__currentLoopData = $anjuranNgombe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anjur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <ul>
                                                    <li><?php echo e($anjur); ?></li>
                                                </ul>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td style="text-align: left">
                                            <?php $__currentLoopData = $jenisNgombe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <ul>
                                                    <li><?php echo e($jenis); ?></li>
                                                </ul>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td style="text-align: left">
                                            <?php $__currentLoopData = $jumlahNgombe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jmlh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <ul>
                                                    <li><?php echo e($jmlh); ?></li>
                                                </ul>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td style="text-align: center">
                                            <?php echo e($item->aturan_tambahan ?? '-'); ?>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__env->startPush('style'); ?>
        <style>
            .info-container {
                display: flex;
                flex-wrap: wrap;
                margin-top: 40px;
                gap: 1rem;
            }

            .info-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-left: 50px;
                flex: 1 1 200px;
                /* Adjust the flex-basis if needed */
            }

            .info-item label {
                font-weight: bold;
                margin-right: 0.5rem;
            }

            .info-item p {
                margin: 0;
            }

            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // TANGGAL SHIFT
                function updateTanggal() {
                    var now = new Date();

                    // Opsi format tanggal dan hari
                    var options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    };

                    // Mengambil elemen HTML untuk shift pagi dan siang
                    var tanggalPagiElement = document.getElementById('tanggalShiftPagi');
                    var tanggalSiangElement = document.getElementById('tanggalShiftSiang');

                    // Format tanggal lengkap dengan nama hari
                    var tanggalLengkap = now.toLocaleDateString('id-ID', options);

                    // Menampilkan tanggal pada elemen yang sesuai
                    tanggalPagiElement.textContent = tanggalLengkap;
                    tanggalSiangElement.textContent = tanggalLengkap;
                }

                // Panggil fungsi saat halaman dimuat
                updateTanggal();

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
                    tanggalElement.innerHTML = '<p>' + now.toLocaleDateString('id-ID', options) + '</p>';

                    var jamElement = document.getElementById('jam');
                    var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                        now.getMinutes().toString().padStart(2, '0');
                    jamElement.innerHTML = '<p>' + jamString + '</p>';
                }
                setInterval(updateClock, 1000);
                updateClock();
            });

            // new DataTable('#example');
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
                    fetch('apoteker-cari-obatKeluar', {
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

                    // Tambahkan baris-baris baru berdasarkan data
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${item.tanggal}</td>
                        <td>${item.no_rm}</td>
                        <td>${item.nama_pasien}</td>
                        <td>${item.jenis_pasien}</td>
                        <td>${item.nama_poli}</td>
                        <td>
                            <button type="button" class="btn btn-info mb-1"  data-bs-toggle="modal" data-bs-target="#riwayat${item.id}">
                                <i class="fas fa-info"></i> Keterangan Obat</button>
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
                    fetch('/cetak', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken // Sesuaikan dengan cara Anda mendapatkan token CSRF
                            },
                            body: JSON.stringify(searchData),
                        })
                        .then(response => response.blob())
                        .then(blob => {
                            const url = window.URL.createObjectURL(new Blob([blob]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', 'Rekap Obat.pdf'); // Nama file untuk diunduh
                            document.body.appendChild(link);
                            link.click();
                            link.parentNode.removeChild(link);
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
<?php /**PATH C:\laragon\www\Klinik\resources\views/obat/rekapObat/ObatKeluar.blade.php ENDPATH**/ ?>