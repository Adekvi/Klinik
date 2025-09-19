<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendor JS Files -->
<script src="<?php echo e(asset('assetss/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assetss/vendor/isotope-layout/isotope.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(asset('assetss/vendor/swiper/swiper-bundle.min.js')); ?>"></script>

<!-- Template Main JS File -->
<script src="<?php echo e(asset('assetss/js/main.js')); ?>"></script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Sertakan Bootstrap JS dan Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="<?php echo e(asset('aset/vendor/libs/jquery/jquery.js')); ?>"></script>
<script src="<?php echo e(asset('aset/vendor/libs/popper/popper.js')); ?>"></script>
<script src="<?php echo e(asset('aset/vendor/js/bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('aset/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>

<script src="<?php echo e(asset('aset/vendor/js/menu.js')); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php echo e(asset('aset/vendor/libs/apex-charts/apexcharts.js')); ?>"></script>

<!-- Main JS -->
<script src="<?php echo e(asset('aset/js/main.js')); ?>"></script>

<!-- Page JS -->
<script src="<?php echo e(asset('aset/js/dashboards-analytics.js')); ?>"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<script src="<?php echo e(asset('aset/js/script.js')); ?>"></script>


<script>
    // Saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Menampilkan pesan dan informasi opsional yang sesuai dengan button "Dewasa"
        showMessage('msgDewasa', document.getElementById('btnDewasa'));
        hideOptionalFields(); // Sembunyikan informasi opsional untuk pekerjaan

        // Tambahkan class active ke button "Dewasa"
        document.getElementById('btnDewasa').classList.add('active');
    });

    document.getElementById('btnDewasa').addEventListener('click', function() {
        showMessage('msgDewasa', this);
        hideOptionalFields();
    });

    document.getElementById('btnAnak').addEventListener('click', function() {
        showMessage('msgAnak', this);
        showOptionalFields();
    });

    document.getElementById('btnTanpaIdentitas').addEventListener('click', function() {
        showMessage('msgTanpaIdentitas', this);
        showOptionalFieldsForTanpaIdentitas();
    });
</script>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/components/user/script.blade.php ENDPATH**/ ?>