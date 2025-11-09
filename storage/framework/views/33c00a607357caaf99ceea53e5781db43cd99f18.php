<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="<?php echo e(asset('assets/images/logo_multisari.png')); ?>" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <title>Antrian Klinik Multisari II</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            font-family: 'Open Sans', sans-serif;
            background: rgba(31, 125, 108, 0.95);
        }

        .app-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            width: 100vw;
        }

        /* HEADER */
        .header {
            position: sticky;
            top: 0;
            background: linear-gradient(to right, #008B8B, #62E7CF);
            color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            flex-shrink: 0;
        }

        .header .logo img {
            height: 45px;
        }

        .header h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .header h4 span {
            color: #FFE033;
        }

        .date-time {
            text-align: right;
            font-size: 0.9rem;
        }

        .date-time .tanggal {
            font-weight: 600;
        }

        .date-time .jam h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 15px;
            gap: 15px;
            overflow: hidden;
        }

        .top-row {
            display: flex;
            gap: 15px;
            flex: 1;
            min-height: 0;
        }

        .video-section,
        .info-section {
            background: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .video-section {
            flex: 1;
            max-width: 55%;
        }

        .info-section {
            flex: 1;
            max-width: 45%;
            gap: 15px;
            display: flex;
            flex-direction: column;
        }

        .media-item {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
            display: none;
        }

        .media-item.active {
            display: block;
        }

        /* INFO BOX */
        .info-box {
            background: #008B8B;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            flex-shrink: 0;
        }

        .info-box h4 {
            margin: 0;
            font-size: 1.3rem;
        }

        .info-box h4 span {
            color: #FFE033;
        }

        /* TABLE */
        .table-container {
            flex: 1;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .table-title {
            background: #008B8B;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .table-title span {
            color: #FFE033;
        }

        .table-wrapper {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .info-table thead {
            background: #008B8B;
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .info-table th,
        .info-table td {
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
            border-bottom: 1px solid #eee;
        }

        .info-table tbody tr {
            background: #f8f9fa;
        }

        .info-table tbody tr:nth-child(even) {
            background: #eef2f7;
        }

        /* Auto Scroll */
        @keyframes  scrollTable {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-100%);
            }
        }

        .scrolling tbody {
            display: block;
            animation: scrollTable 15s linear infinite;
        }

        .scrolling tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        /* STATS */
        .stats-row {
            display: flex;
            gap: 15px;
            padding: 0 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .stat-card {
            flex: 1;
            min-width: 180px;
            max-width: 250px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-8px);
        }

        .stat-card p:first-child {
            font-size: 3.5rem;
            font-weight: 700;
            color: #008B8B;
            margin: 0 0 8px 0;
            line-height: 1;
        }

        .stat-card p:last-child {
            margin: 0;
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }

        /* FOOTER */
        .footer {
            background: #008B8B;
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .marquee {
            overflow: hidden;
            white-space: nowrap;
        }

        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 20s linear infinite;
        }

        @keyframes  marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .top-row {
                flex-direction: column;
            }

            .video-section,
            .info-section {
                max-width: 100%;
            }

            .video-section {
                min-height: 300px;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 8px;
                padding: 10px;
            }

            .header h4 {
                font-size: 1.2rem;
            }

            .date-time .jam h1 {
                font-size: 1.5rem;
            }

            .stats-row {
                gap: 10px;
            }

            .stat-card p:first-child {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 480px) {
            .stat-card {
                min-width: 140px;
                padding: 15px;
            }

            .info-table th,
            .info-table td {
                font-size: 0.8rem;
                padding: 8px 4px;
            }
        }
    </style>
</head>

<body>
    <div class="app-container">
        <!-- HEADER -->
        <header class="header">
            <div class="logo">
                <img src="<?php echo e(asset('assets/images/logo_multisari.png')); ?>" alt="Logo">
            </div>
            <h4>KLINIK PRATAMA <span>MULTISARI II</span></h4>
            <div class="date-time">
                <div class="tanggal" id="tanggal"></div>
                <div class="jam">
                    <h1 id="jam"></h1>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="top-row">
                <!-- VIDEO SECTION -->
                <div class="video-section">
                    <div id="videoContainer"
                        style="height: 100%; display: flex; align-items: center; justify-content: center;">
                        <?php if($video->isNotEmpty()): ?>
                            <?php $__currentLoopData = $video; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $ext = pathinfo($item->video_path, PATHINFO_EXTENSION); ?>
                                <?php if(in_array($ext, ['mp4', 'webm', 'ogg'])): ?>
                                    <video class="media-item" controls loop>
                                        <source src="<?php echo e(asset('storage/' . $item->video_path)); ?>" type="video/mp4">
                                        Browser tidak mendukung video.
                                    </video>
                                <?php else: ?>
                                    <img src="<?php echo e(asset('storage/' . $item->video_path)); ?>" class="media-item"
                                        alt="Gambar">
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p style="color: #666; font-style: italic;">Belum ada media</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- INFO SECTION -->
                <div class="info-section">
                    <div class="info-box">
                        <h4>Informasi <span>Terkini</span></h4>
                    </div>

                    <div class="table-container">
                        <div class="table-title">Daftar <span>Antrian Pasien</span></div>
                        <div class="table-wrapper">
                            <table class="info-table" style="white-space: nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Antrian</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="antrianBody">
                                    <?php if($data->isEmpty()): ?>
                                        <tr>
                                            <td colspan="4">-</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($item->kode_antrian); ?></td>
                                                <td><?php echo e($item->booking->pasien->nama_pasien); ?></td>
                                                <td><?php echo e($item->booking->pasien->jekel == 'L' ? 'Laki-laki' : 'Perempuan'); ?>

                                                </td>
                                                <td><?php echo e($item->booking->pasien->alamat_asal); ?></td>
                                                <td>
                                                    <?php switch($item->status):
                                                        case ('D'): ?>
                                                            Datang
                                                        <?php break; ?>

                                                        <?php case ('M'): ?>
                                                            Menunggu
                                                        <?php break; ?>

                                                        <?php case ('P'): ?>
                                                            Periksa
                                                        <?php break; ?>

                                                        <?php case ('B'): ?>
                                                            Apotek
                                                        <?php break; ?>

                                                        <?php case ('K'): ?>
                                                            Kasir
                                                        <?php break; ?>

                                                        <?php case ('WS'): ?>
                                                            Selesai
                                                        <?php break; ?>

                                                        <?php default: ?>
                                                            -
                                                    <?php endswitch; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATS -->
            <div class="stats-row">
                <div class="stat-card">
                    <p class="totalPasien"><?php echo e($totalHariIni); ?></p>
                    <p>Total Pasien</p>
                </div>
                <div class="stat-card" data-poli="umum">
                    <p id="nomorAntrianUmum"><?php echo e($nomorAntrianUmum); ?></p>
                    <p>Poli Umum</p>
                </div>
                <div class="stat-card" data-poli="gigi">
                    <p id="nomorAntrianGigi"><?php echo e($nomorAntrianGigi); ?></p>
                    <p>Poli Gigi</p>
                </div>
                <div class="stat-card" data-poli="obat">
                    <p id="nomorAntrianObat"><?php echo e($nomorAntrianObat); ?></p>
                    <p>Ruang Farmasi</p>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="footer">
            <div class="marquee">
                <span>Selamat datang di Klinik Pratama Multisari II | Jl. Raya Jepara - Kudus | Pelayanan Prima untuk
                    Kesehatan Anda</span>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/antrian.script.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            // Jam & Tanggal
            function updateClock() {
                const now = new Date();
                $('#tanggal').text(now.toLocaleDateString('id-ID', {
                    weekday: 'short',
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                }));
                const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString()
                    .padStart(2, '0');
                $('#jam').text(time);
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Auto Reload Antrian
            function reloadAntrian() {
                $.get(location.href, function(data) {
                    const $new = $(data);
                    $('#nomorAntrianUmum').text($new.find('#nomorAntrianUmum').text());
                    $('#nomorAntrianGigi').text($new.find('#nomorAntrianGigi').text());
                    $('#nomorAntrianObat').text($new.find('#nomorAntrianObat').text());
                    $('.totalPasien').text($new.find('.totalPasien').text());
                    $('#antrianBody').html($new.find('#antrianBody').html());
                });
            }
            setInterval(reloadAntrian, 2000);

            // Auto Scroll Tabel
            const $tbody = $('#antrianBody');
            if ($tbody.find('tr').length > 5) {
                $tbody.addClass('scrolling');
            }

            // Video Slider
            let currentIndex = 0;
            const $items = $('.media-item');
            if ($items.length > 0) {
                function showNext() {
                    $items.eq(currentIndex).removeClass('active');
                    if ($items.eq(currentIndex).is('video')) $items.eq(currentIndex)[0].pause();

                    currentIndex = (currentIndex + 1) % $items.length;
                    const $next = $items.eq(currentIndex).addClass('active');
                    if ($next.is('video')) {
                        $next[0].play().catch(() => {});
                        $next.one('ended', showNext);
                    } else {
                        setTimeout(showNext, 5000);
                    }
                }
                $items.first().addClass('active');
                if ($items.first().is('video')) {
                    $items.first()[0].play().catch(() => {});
                    $items.first().one('ended', showNext);
                } else {
                    setTimeout(showNext, 5000);
                }
            }

            // Panggil Antrian (Testing)
            $('.stat-card[data-poli]').on('click', function() {
                const poli = $(this).data('poli');
                const url = poli === 'obat' ? '<?php echo e(route('antrian.panggil-obat')); ?>' :
                    '<?php echo e(route('antrian.panggil')); ?>';
                const data = {
                    _token: '<?php echo e(csrf_token()); ?>',
                    ...(poli !== 'obat' && {
                        poli
                    })
                };

                $.post(url, data, function(res) {
                    if (res.success) {
                        const id = poli === 'obat' ? '#nomorAntrianObat' :
                            `#nomorAntrian${poli.charAt(0).toUpperCase() + poli.slice(1)}`;
                        $(id).text(res.nomor);
                    } else {
                        alert(res.message || 'Antrian kosong');
                    }
                });
            });
        });
    </script>
</body>

</html>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/antrian/antrian.blade.php ENDPATH**/ ?>