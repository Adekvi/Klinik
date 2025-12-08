<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Admin | Rekap Pasien Poli Gigi']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-umum">
                    <div class="title">
                        <h5>Poli Gigi / <strong>Laporan Kunjungan Pasien Umum</strong></h5>
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
                                        
                                        <button id="btnExportExcel" class="dropdown-item">Export to Excel</button>

                                        
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
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="custom-th">NO.</th>
                                            <th class="custom-th">TANGGAL</th>
                                            <th class="custom-th">JAM</th>
                                            <th class="custom-th">NO. RM</th>
                                            <th class="custom-th">NAMA PASIEN</th>
                                            <th class="custom-th">JENIS PASIEN</th>
                                            <th class="custom-th">TANGGAL LAHIR</th>
                                            <th class="custom-th">PASIEN UMUM</th>
                                            <th class="custom-th">HARGA</th>
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
                    fetch('/rekapan/gigi-umum/search', {
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

                    // Periksa apakah data kosong
                    if (data.length === 0) {
                        // Jika data kosong, tambahkan satu baris dengan pesan "data tidak ada"
                        const row = document.createElement('tr');
                        row.innerHTML =
                            '<td colspan="20" style="text-align: center">Data tidak ada</td>'; // colspan diset ke 6 karena ada 6 kolom
                        tableBody.appendChild(row);
                    } else {
                        // Jika ada data, tambahkan baris-baris baru berdasarkan data
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
                    fetch('/rekapan/gigi-umum/cetak', {
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
          <script>
            document.getElementById('btnExportExcel').addEventListener('click', function () {

                let search = document.getElementById('search')?.value || "";
                let filterOption = document.querySelector('input[name="filter_option"]:checked')?.id || "";
                let tanggal = document.getElementById('tanggal')?.value || "";
                let month = document.getElementById('month')?.value || "";
                let tahun = document.getElementById('tahun')?.value || "";

                let url = `/gigi-umum/export-excel?search=${search}&filter_option=${filterOption}&tanggal=${tanggal}&month=${month}&tahun=${tahun}`;

                window.location.href = url;
            });

        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Klinik\resources\views/admin/rekapan/pasien-gigi/gigi-umum/index.blade.php ENDPATH**/ ?>