<!-- Modal Utama: Riwayat Pasien -->
<div class="modal fade" id="riwayat<?php echo e($antrianDokter->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Riwayat Periksa Pasien
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead class="table-primary" style="text-align: center;">
                            <tr>
                                <th>TGL DAN JAM</th>
                                <th>PROFESI</th>
                                <th>ASESMEN</th>
                                <th>EDUKASI</th>
                            </tr>
                        </thead>
                        <?php
                            $allSoapPatients = [];
                        ?>
                        <?php $__currentLoopData = $soap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $soapData = json_decode($item['soap_p'], true);
                                $allSoapPatients = array_merge($allSoapPatients, array_keys($soapData));
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $allSoapPatients = array_unique($allSoapPatients);
                        ?>
                        <tbody style="text-align: center; white-space: nowrap">
                            <?php if($soapRiwayat->isEmpty()): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center">Belum ada Asesmen</td>
                                </tr>
                            <?php else: ?>
                                <?php $__currentLoopData = $soapRiwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(date_format(date_create($item['created_at']), 'Y-m-d/H:i:s')); ?></td>
                                        <td><?php echo e($item['nama_dokter']); ?></td>
                                        <td style="text-align: left">
                                            <table class="table">
                                                <thead>
                                                    <tr style="text-align: center; font-weight: bold">
                                                        <td>S</td>
                                                        <td>O</td>
                                                        <td>A</td>
                                                        <td>P</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo e($item['keluhan_utama'] ?? '-'); ?></td>
                                                        <td>
                                                            <ul>
                                                                <li>Tensi : <?php echo e($item['p_tensi'] ?? '-'); ?> / mmHg</li>
                                                                <li>RR : <?php echo e($item['p_rr'] ?? '-'); ?> / minute</li>
                                                                <li>Nadi : <?php echo e($item['p_nadi'] ?? '-'); ?> / minute</li>
                                                                <li>Suhu : <?php echo e($item['p_suhu'] ?? '-'); ?> °c</li>
                                                                <li>TB : <?php echo e($item['p_tb'] ?? '-'); ?> / cm</li>
                                                                <li>BB : <?php echo e($item['p_bb'] ?? '-'); ?> / kg</li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $diagnosaPrimer = json_decode(
                                                                    $item['soap_a_primer'] ?? '[]',
                                                                    true,
                                                                );
                                                                $diagnosaPrimer = array_values($diagnosaPrimer);
                                                                $diagnosaSekunder = json_decode(
                                                                    $item['soap_a_sekunder'] ?? '[]',
                                                                    true,
                                                                );
                                                                $diagnosaSekunder = array_values($diagnosaSekunder);
                                                            ?>
                                                            <?php if(!empty($diagnosaPrimer) || !empty($diagnosaSekunder)): ?>
                                                                <?php $__currentLoopData = $diagnosaPrimer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <ul>
                                                                        <li><?php echo e($diag ?? '-'); ?></li>
                                                                    </ul>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $diagnosaSekunder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diagn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <ul>
                                                                        <li><?php echo e($diagn ?? '-'); ?></li>
                                                                    </ul>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <ul>
                                                                    <li>Tidak Ada Diagnosa</li>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <p style="font-weight: bold; margin-bottom: -0px">Resep :
                                                            </p>
                                                            <p style="font-weight: bold; margin-bottom: -0px"> - Non
                                                                Racikan</p>
                                                            <?php
                                                                $resep = json_decode($item['soap_p'] ?? '[]', true);
                                                                $aturan = json_decode(
                                                                    $item['soap_p_aturan'] ?? '[]',
                                                                    true,
                                                                );
                                                            ?>
                                                            <?php if(is_array($resep) && is_array($aturan) && count($resep) == count($aturan)): ?>
                                                                <?php $__currentLoopData = $resep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obat => $namaObat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php
                                                                        $aturanMinum = $aturan[$obat] ?? '-';
                                                                    ?>
                                                                    <ul>
                                                                        <li><?php echo e($namaObat ?? '-'); ?> |
                                                                            <?php echo e($aturanMinum); ?></li>
                                                                    </ul>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <p>-</p>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td><?php echo e($item['edukasi'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Klinik\resources\views/dokter/modal/riwayatPasien.blade.php ENDPATH**/ ?>