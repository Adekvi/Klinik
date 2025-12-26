<?php if (isset($component)) { $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Layout\Terminal::class, ['title' => 'Perawat | Rekap Pasien']); ?>
<?php $component->withName('admin.layout.terminal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <h4 class="mt-4"><strong>Rekap Kunjungan Pasien</strong></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="filter d-flex align-items-center">
                            <div class="me-3">
                                <label for="date">Pilih Tanggal:</label>
                                <input type="number" id="date" name="date" class="form-control" min="1"
                                    max="31">
                            </div>

                            <div class="me-3">
                                <label for="month">Pilih Bulan:</label>
                                <select id="month" name="month" class="form-control">
                                    <!-- Bulan akan diisi oleh JavaScript -->
                                </select>
                            </div>

                            <div class="me-3">
                                <label for="year">Pilih Tahun:</label>
                                <select id="year" name="year" class="form-control">
                                    <!-- Tahun akan diisi oleh JavaScript -->
                                </select>
                            </div>
                        </div>
                        <div class="shifts" style="text-transform: uppercase">
                            <h4>Jumlah Pasien Per Shift</h4>
                            <div class="row">
                                
                                <div class="col-4">
                                    <table id="shiftReportPagi" class="table table-bordered table-responsive">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">SHIFT PAGI</th>
                                                <th class="text-center">KET.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Tanggal</td>
                                                <td id="tanggalShiftPagi"></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                <td id="poliUmumBpjsPagi" style="text-align: center">
                                                    <?php echo e($countShiftPagiUmumBPJS); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli UMUM (Umum)</td>
                                                <td id="poliUmumUmumPagi" style="text-align: center">
                                                    <?php echo e($countShiftPagiUmumUmum); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                <td id="poliGigiBpjsPagi" style="text-align: center">
                                                    <?php echo e($countShiftPagiGigiBPJS); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli GIGI (Umum)</td>
                                                <td id="poliGigiUmumPagi" style="text-align: center">
                                                    <?php echo e($countShiftPagiGigiUmum); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Laborat (Bpjs)</td>
                                                <td id="laboratBpjsPagi" style="text-align: center">0</td>
                                            </tr>
                                            <tr>
                                                <td>Laborat (Umum)</td>
                                                <td id="laboratUmumPagi" style="text-align: center">0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-4">
                                    <table id="shiftReportSiang" class="table table-bordered table-responsive">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">SHIFT SIANG</th>
                                                <th class="text-center">KET.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Tanggal</td>
                                                <td id="tanggalShiftSiang"></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                <td id="poliUmumBpjsSiang" style="text-align: center">
                                                    <?php echo e($countShiftSiangUmumBPJS); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli UMUM (Umum)</td>
                                                <td id="poliUmumUmumSiang" style="text-align: center">
                                                    <?php echo e($countShiftSiangUmumUmum); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                <td id="poliGigiBpjsSiang" style="text-align: center">
                                                    <?php echo e($countShiftSiangGigiBpjs); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli GIGI (Umum)</td>
                                                <td id="poliGigiUmumSiang" style="text-align: center">
                                                    <?php echo e($countShiftSiangGigiUmum); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Laborat (Bpjs)</td>
                                                <td id="laboratBpjsSiang" style="text-align: center">0</td>
                                            </tr>
                                            <tr>
                                                <td>Laborat (Umum)</td>
                                                <td id="laboratUmumSiang" style="text-align: center">0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-4">
                                    <table id="shiftReportTotal" class="table table-bordered table-responsive">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">PASIEN SHIFT PAGI DAN SIANG</th>
                                                <th class="text-center">KET.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Pasien Poli UMUM (Bpjs)</td>
                                                <td id="poliUmumBpjsTotal" style="text-align: center">
                                                    <?php echo e($totalPoliUmumPasienBPJS); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli UMUM (Umum)</td>
                                                <td id="poliUmumUmumTotal" style="text-align: center">
                                                    <?php echo e($totalPoliUmumPasienUmum); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli GIGI (Bpjs)</td>
                                                <td id="poliGigiBpjsTotal" style="text-align: center">
                                                    <?php echo e($totalPoliGigiPasienBPJS); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pasien Poli GIGI (Umum)</td>
                                                <td id="poliGigiUmumTotal" style="text-align: center">
                                                    <?php echo e($totalPoliGigiPasienUmum); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Laborat (Bpjs)</td>
                                                <td id="laboratBpjsTotal" style="text-align: center">0</td>
                                            </tr>
                                            <tr>
                                                <td>Laborat (Umum)</td>
                                                <td id="laboratUmumTotal" style="text-align: center">0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-4">
                <div class="card-title">
                    <h4><strong>Daftar Pasien Harian</strong></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="isian" style="overflow-x: scroll">
                            <table class="table table-striped table-bordered"
                                style="background-color: white; white-space: nowrap;">
                                <thead class="table-primary text-center" style="width: auto">
                                    <tr>
                                        <th>No</th>
                                        <th>No. RM</th>
                                        <th>NIK</th>
                                        <th>Nama Pasien</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Pasien</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" style="text-transform: uppercase">
                                    <?php if($pasien->isEmpty()): ?>
                                        <tr>
                                            <td colspan="11" style="text-align: center">Tidak Ada Data Pasien</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($item->status == 'M'): ?>
                                                <tr id="row_<?php echo e($item->id); ?>" class="text-center">
                                                    <td><?php echo e($pasien->firstItem() + $loop->index); ?></td>
                                                    <td><?php echo e($item->booking->pasien->no_rm); ?></td>
                                                    <td><?php echo e($item->booking->pasien->nik); ?></td>
                                                    <td><?php echo e($item->booking->pasien->nama_pasien); ?></td>
                                                    <td><?php echo e($item->booking->pasien->tgllahir); ?></td>
                                                    <td>
                                                        <?php
                                                            // Parsing tanggal lahir dari data pasien menggunakan Carbon
                                                            $tgllahir = \Carbon\Carbon::parse(
                                                                $item->booking->pasien->tgllahir,
                                                            );

                                                            // Menghitung umur dalam bulan dari tanggal lahir hingga saat ini
                                                            $umurDalamBulan = $tgllahir->diffInMonths(
                                                                \Carbon\Carbon::now(),
                                                            );

                                                            // Mengubah umur ke dalam tahun dan bulan
                                                            $tahun = floor($umurDalamBulan / 12); // Hitung tahun
                                                            $bulan = $umurDalamBulan % 12; // Sisa bulan

                                                            // Format umur
                                                            $umur = $tahun . ' tahun';
                                                            if ($bulan > 0) {
                                                                $umur .= ' ' . $bulan . ' bulan';
                                                            }
                                                        ?>
                                                        <?php echo e($umur); ?>

                                                    </td>
                                                    <td><?php echo e($item->poli->namapoli); ?></td>
                                                    <td><?php echo e($item->dokter->nama_dokter); ?></td>
                                                    <td><?php echo e($item->booking->pasien->domisili); ?></td>
                                                    <td><?php echo e($item->booking->pasien->jenis_pasien); ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info mb-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#asesmen<?php echo e($item->id); ?>"
                                                            data-toggle="tooltip" data-bs-placement="top"
                                                            title="Riwayat Asesmen">
                                                            <i class="fas fa-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="page d-flex justify-content-end">
                            <?php echo e($pasien->appends(request()->only(['periksa_search', 'periksa_entries']))->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php $__currentLoopData = $pasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="asesmen<?php echo e($item->id); ?>" tabindex="-1"
            aria-labelledby="exampleModalLabel<?php echo e($item->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Riwayat Asesmen
                            Pasien
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="asesmen">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Asesmen</th>
                                        <th>Detail Asesmen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $iteration = 1;
                                        $asesmenDitemukan = false;
                                    ?>
                                    <?php
                                        $sortedSoap = [];
                                        if (!empty($soap)) {
                                            $idPasien = $item->booking->id_pasien;
                                            $sortedSoap = $soap
                                                ->where('id_pasien', $idPasien)
                                                ->sortByDesc('created_at')
                                                ->values()
                                                ->all();
                                        }
                                        // dd($sortedSoap);
                                    ?>
                                    <?php if(!empty($sortedSoap)): ?>
                                        <?php $__currentLoopData = $sortedSoap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesmen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $asesmenDitemukan = true; ?>
                                            <tr>
                                                <td><?php echo e($iteration++); ?></td>
                                                <td><?php echo e(date_format(date_create($asesmen['created_at']), 'd-m-Y/H:i:s')); ?>

                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailAsesmen<?php echo e($asesmen['id']); ?>"
                                                        data-toggle="tooltip" data-bs-placement="top"
                                                        title="Asesmen">
                                                        <i class="fas fa-eye"></i> Lihat Asesmen
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif(!$asesmenDitemukan): ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center">Belum ada Asesmen</td>
                                        </tr>
                                    <?php endif; ?>
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
            /* TANGGAL PERIODE */
            .filter {
                display: flex;
                align-items: center;
            }

            .filter>div {
                margin-right: 10px;
                /* Memberi jarak antar elemen */
            }

            label {
                display: block;
                margin-bottom: 5px;
            }

            /* TAMPILAN REPORT */


            /* TAMPILAN SHIFT */
            .container {
                width: 80%;
                margin: auto;
                padding: 20px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                text-align: center;
                color: #333;
            }

            .filter {
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            table,
            th,
            td {
                border: 1px solid #ddd;
            }

            th,
            td {
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #f4f4f4;
            }

            .table thead th {
                /* color: rgb(94, 94, 221); */
                text-align: left;
            }

            .table tbody {
                text-align: left;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const now = new Date();
                const currentDay = now.getDate();
                const currentMonth = now.getMonth() + 1; // Bulan dimulai dari 0
                const currentYear = now.getFullYear();

                // Mengisi dropdown bulan
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                const monthSelect = document.getElementById('month');
                monthNames.forEach((month, index) => {
                    const option = document.createElement('option');
                    option.value = index + 1; // Bulan dimulai dari 1
                    option.textContent = month;
                    if (index + 1 === currentMonth) {
                        option.selected = true; // Bulan saat ini dipilih
                    }
                    monthSelect.appendChild(option);
                });

                // Mengisi dropdown tahun
                const yearSelect = document.getElementById('year');
                for (let year = currentYear - 10; year <= currentYear + 10; year++) {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    if (year === currentYear) {
                        option.selected = true; // Tahun saat ini dipilih
                    }
                    yearSelect.appendChild(option);
                }

                // Menentukan tanggal default dan max tanggal
                const dateInput = document.getElementById('date');
                dateInput.value = currentDay;
                dateInput.max = new Date(currentYear, currentMonth, 0)
                    .getDate(); // Set max tanggal sesuai bulan dan tahun yang dipilih

                // Menangani perubahan pada bulan dan tahun untuk memperbarui max tanggal
                monthSelect.addEventListener('change', updateMaxDate);
                yearSelect.addEventListener('change', updateMaxDate);

                function updateMaxDate() {
                    const selectedMonth = parseInt(monthSelect.value);
                    const selectedYear = parseInt(yearSelect.value);
                    const maxDate = new Date(selectedYear, selectedMonth, 0).getDate(); // Update max tanggal
                    dateInput.max = maxDate; // Update max tanggal sesuai bulan dan tahun yang dipilih

                    if (parseInt(dateInput.value) > maxDate) {
                        dateInput.value = maxDate; // Update nilai tanggal jika lebih dari max
                    }
                }

                // Pastikan max tanggal sesuai dengan bulan dan tahun saat ini
                updateMaxDate();
            });

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
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc)): ?>
<?php $component = $__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc; ?>
<?php unset($__componentOriginal7e574ae613b9c7a71481c42282e2125e07f655dc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/perawat/rekap/index.blade.php ENDPATH**/ ?>