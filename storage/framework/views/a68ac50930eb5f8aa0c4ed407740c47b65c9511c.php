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
<script src="<?php echo e(asset('aset/js/config.js')); ?>"></script>

<!-- Bootstrap JS -->
<script src="<?php echo e(asset('aset/js/bootstrap/bootstrap.bundle.js')); ?>"></script>


<!-- Tambahkan GLightbox sebelum main.js -->
<script src="<?php echo e(asset('aset/js/glightbox/glightbox.min.js')); ?>"></script>
<script src="<?php echo e(asset('aset/js/purecounter/purecounter_vanilla.js')); ?>"></script>
<script src="<?php echo e(asset('aset/js/aos/aos.js')); ?>"></script>




<!-- Main JS -->
<script src="<?php echo e(asset('aset/js/main.js')); ?>"></script>

<!-- Vendor JS Files -->
<script src="<?php echo e(asset('assetss/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assetss/vendor/isotope-layout/isotope.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(asset('assetss/vendor/swiper/swiper-bundle.min.js')); ?>"></script>

<!-- Template Main JS File -->
<script src="<?php echo e(asset('assetss/js/main.js')); ?>"></script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Sertakan Bootstrap JS dan Popper.js -->
<script src="<?php echo e(asset('aset/js/popper/popper.min.js')); ?>"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo e(asset('aset/js/select2/select2.min.js')); ?>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>





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
<?php /**PATH C:\laragon\www\Klinik\resources\views/components/user/script.blade.php ENDPATH**/ ?>