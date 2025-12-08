<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pasien BPJS</title>
    
    <style>
        .container .top {
            display: flex;
            align-items: center;
        }

        .container .top .left {
            flex: 0 0 auto;
            margin-right: 10px; /* Atur jarak antara logo dan teks */
        }

        .container .top .right {
            flex: 1;
        }

        .container .top .image img {
            width: 100px;
            margin-left : 20px;
        }

        .container .top .clinic p,
        .container .top .clinic p {
            margin: 0; /* Hapus margin default */
            font-size: 25px;
            font-weight: bold;
        }

        .container .top .address p,
        .container .top .tel p {
            margin: 0; /* Hapus margin default */
            font-size: 12px;
        }

        .divider {
            border-top: 5px solid #000; /* Warna garis dan ketebalan dapat disesuaikan */
            margin-top: -5px; /* Atur jarak antara garis dan teks */
        }
        .divider-2 {
            border-top: 1px solid #000; /* Warna garis dan ketebalan dapat disesuaikan */
            margin-top: -5px;
        }

        .container .judul p {
            font-weight: bold;
            text-align: center;
            font-size: 20px;
        }

        .container .judul .kalimat p {
            text-align: start;
            margin-top: -10px;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <div class="left">
                <div class="image">
                    <img src="<?php echo e(asset('assets/images/logo_multisari.png')); ?>" alt="">
                </div>
            </div>
            <div class="right">
                <div class="clinic">
                    <p>
                        KLINIK PRATAMA MULTISARI II <br>
                    </p>
                </div>
                <div class="addres" style="margin-top: -10px">
                    <p>
                        Jl. Jepara-Kudus, Ruko Safira Regency
                        Desa Sengonbugel RT. 03 RW. 01,
                        Kec. Mayong, Kab. Jepara
                    </p>
                </div>
                <div class="telp" style="margin-top: -10px">
                    <p>(0291) 7520234, e-mail : klinikmultisari@gmail.com</p>
                </div>
            </div>
        </div>
        <hr class="divider">
        <hr class="divider-2">
        
        <div class="judul">
            <p>Laporan Data Kunjungan Pasien BPJS</p>
            <div class="kalimat">
                <p>FASKES : KLINIK PRATAMA MULTISARI II</p>
                <p style="margin-top: -10px"><?php echo e($filterInfo); ?></p>
            </div>
        </div>
    
        <table border="1">
            <thead style="text-transform: uppercase">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Pasien</th>
                    <th>Tanggal Lahir</th>
                    <th>Nomor BPJS</th>
                    <th>Nomor NIK</th>
                    <th>Nomor HP</th>
                    <th>Pekerjaan</th>
                    <th>Nama Kepala Keluarga</th>
                    <th>Alamat</th>
                    <th>Keluhan</th>
                    <th>Pemeriksaan</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($data) === 0): ?>
                <tr>
                    <td colspan="19" style="text-align: center">Data tidak ada</td>
                </tr>
                <?php else: ?>
                <?php
                    $bpjsDataExist = false;
                ?>
    
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item->pasien->jenis_pasien === 'Bpjs'): ?>
                        <?php
                            $bpjsDataExist = true;
                        ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e(date_format(date_create($item->created_at), 'd-m-Y')); ?></td>
                            <td><?php echo e(date_format(date_create($item->created_at), 'H:i:s')); ?></td>
                            <td><?php echo e($item->pasien->no_rm); ?></td>
                            <td><?php echo e($item->pasien->nama_pasien); ?></td>
                            <td><?php echo e($item->pasien->jenis_pasien); ?></td>
                            <td><?php echo e($item->pasien->nomor_bpjs); ?></td>
                            <td><?php echo e($item->pasien->nik); ?></td>
                            <td><?php echo e($item->pasien->noHP); ?></td>
                            <td><?php echo e($item->pasien->pekerjaan); ?></td>
                            <td><?php echo e($item->pasien->nama_kk); ?></td>
                            <td><?php echo e($item->pasien->alamat); ?></td>
                            <td><?php echo e($item->a_keluhan_utama); ?></td>
                            <td>
                                Tensi: <?php echo e($item->p_tensi); ?>,
                                RR: <?php echo e($item->p_rr); ?>,
                                Nadi: <?php echo e($item->p_nadi); ?>,
                                SpO2: <?php echo e($item->spo2); ?>,
                                Suhu: <?php echo e($item->p_suhu); ?>,
                                TB: <?php echo e($item->p_tb); ?>,
                                BB: <?php echo e($item->p_bb); ?>

                            </td>
                            <td>
                                Diagnosa Primer : <?php echo e($item->soap_a_primer); ?>,
                                Diagnosa Sekunder : <?php echo e($item->soap_a_sekunder); ?>

                            </td>
                            <td><?php echo e($item->edukasi); ?></td>
                            <td><?php echo e($item->rujuk); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Klinik\resources\views/admin/rekapan/pasien-bpjs/cetak.blade.php ENDPATH**/ ?>