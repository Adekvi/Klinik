<script src="<?php echo e(asset('aset/vendor/libs/jquery/jquery.js')); ?>"></script>
<script src="<?php echo e(asset('aset/vendor/libs/popper/popper.js')); ?>"></script>
<script src="<?php echo e(asset('aset/vendor/js/bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('aset/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>

<script src="<?php echo e(asset('aset/vendor/js/menu.js')); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php echo e(asset('aset/vendor/libs/apex-charts/apexcharts.js')); ?>"></script>

<!-- Helpers -->
<script src="<?php echo e(asset('aset/vendor/js/helpers.js')); ?>"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->


<!-- Main JS -->
<script src="<?php echo e(asset('aset/js/main.js')); ?>"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="<?php echo e(asset('aset/js/script.js')); ?>"></script>

<script src="<?php echo e(asset('aset/js/select2/select2.min.js')); ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<script src="https://code.responsivevoice.org/responsivevoice.js"></script>




<script>
    window.addEventListener('open-periksa-modal', function() {
        const modalEl = document.getElementById('periksaModal');
        if (!modalEl) {
            console.error('Modal #periksaModal tidak ditemukan');
            return;
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });
</script>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/components/admin/script.blade.php ENDPATH**/ ?>