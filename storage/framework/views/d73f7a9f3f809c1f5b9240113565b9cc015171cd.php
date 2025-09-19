
<?php $__env->startSection('title', 'Perawat | Rekap Pasien'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <h4 class="mt-4"><strong>Rekap Pasien Telah Diperiksa</strong></h4>
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
                        <div class="shifts">
                            <h4>Total Pasien</h4>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-bordered table-responsive w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">TOTAL PASIEN SUDAH DIPERIKSA
                                                </th>
                                                <th class="text-center">KET.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($groupedAntrian->isEmpty()): ?>
                                                <tr>
                                                    <td colspan="2" class="text-center">Belum ada data</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $groupedAntrian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namapoli => $antrian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($namapoli === 'Umum'): ?>
                                                        <tr>
                                                            <td>Pasien Poli UMUM (Bpjs)</td>
                                                            <td id="poliUmumBpjsTotal" style="text-align: center">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pasien Poli UMUM (Umum)</td>
                                                            <td id="poliUmumUmumTotal" style="text-align: center">0</td>
                                                        </tr>
                                                    <?php elseif($namapoli === 'Gigi'): ?>
                                                        <tr>
                                                            <td>Pasien Poli GIGI (Bpjs)</td>
                                                            <td id="poliGigiBpjsTotal" style="text-align: center">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pasien Poli GIGI (Umum)</td>
                                                            <td id="poliGigiUmumTotal" style="text-align: center">0</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

<?php $__env->stopSection(); ?>

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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.dasbrod', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/dokter/periksa.blade.php ENDPATH**/ ?>