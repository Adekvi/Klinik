<div>
    <div wire:ignore.self class="modal fade" id="periksaModal" tabindex="-1" data-bs-backdrop="static">

        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                
                <div class="modal-header text-dark">
                    <h5 class="modal-title text-capitalize">
                        Asesmen Keperawatan -
                        <?php echo e(strtolower($booking?->pasien?->nama_pasien ?? 'Memuat...')); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="card">
                    <div class="card-body">
                        <?php if($antrian && $booking): ?>

                            <div class="sticky-top bg-white border-bottom pb-3" style="top:0; z-index:10;">
                                <?php echo $__env->make('perawat.modalPerawat.partials.header-pasien', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="tombol">
                                    
                                    <ul class="nav nav-tabs nav-fill">
                                        <li class="nav-item">
                                            <button type="button" wire:click="setTab('asesmen')"
                                                class="nav-link <?php echo e($activeTab === 'asesmen' ? 'active bg-primary text-white' : ''); ?>">
                                                <i class="fa-solid fa-file-pen"></i> Asesmen Awal
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" wire:click="setTab('kajian')"
                                                class="nav-link <?php echo e($activeTab === 'kajian' ? 'active bg-info text-white' : ''); ?>">
                                                <i class="fa-solid fa-file-signature"></i> Kajian Awal
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" wire:click="setTab('hamil')"
                                                class="nav-link <?php echo e($activeTab === 'hamil' ? 'active bg-secondary text-white' : ''); ?>">
                                                <i class="fa-solid fa-person-breastfeeding"></i> Hamil
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            
                            <form action="<?php echo e(url('perawat/store/' . $antrianId)); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>

                                <div class="modal-body" style="max-height:70vh;overflow-y:auto">

                                    <?php if($activeTab === 'asesmen'): ?>
                                        <?php echo $__env->make('perawat.modalPerawat.tabs.tab-asesmen-awal', [
                                            'antrian' => $antrian,
                                            'booking' => $booking,
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php elseif($activeTab === 'kajian'): ?>
                                        <?php echo $__env->make('perawat.modalPerawat.tabs.tab-kajian-awal', [
                                            'antrian' => $antrian,
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php elseif($activeTab === 'hamil'): ?>
                                        <?php echo $__env->make('perawat.modalPerawat.tabs.tab-hamil', [
                                            'antrian' => $antrian,
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                </div>

                                <?php echo $__env->make('perawat.modalPerawat.partials.footer-pasien', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </form>
                        <?php else: ?>
                            <div class="modal-body text-center py-5">
                                <div class="spinner-border text-primary"></div>
                                <p class="mt-3">Memuat data pasien...</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/perawat/modalPerawat/livewire/asesmen-pasien-modal.blade.php ENDPATH**/ ?>