<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo e($title); ?></title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php if (isset($component)) { $__componentOriginala48887673e9ddb2ccd8721d1b1194b39cf7616f0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\User\Gaya::class, []); ?>
<?php $component->withName('user.gaya'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala48887673e9ddb2ccd8721d1b1194b39cf7616f0)): ?>
<?php $component = $__componentOriginala48887673e9ddb2ccd8721d1b1194b39cf7616f0; ?>
<?php unset($__componentOriginala48887673e9ddb2ccd8721d1b1194b39cf7616f0); ?>
<?php endif; ?>
    <?php echo $__env->yieldPushContent('style'); ?>

    <style>
        /* Mengatur skala tampilan pada laptop dan desktop */
        /* @media  screen and (min-width: 1024px) {
        body {
            zoom: 90%;
        }
      } */
        /* Terapkan animasi fade ke kelas .fade-in */
        .fade-in {
            animation: fadeIn 8s infinite;
        }

        .select2-container--default {
            width: 100% !important;
            margin-bottom: 10px;
        }

        .select2-container .select2-selection--single {
            height: 40px;
            /* Atur tinggi sesuai kebutuhan Anda */
            padding-top: 5px;
        }

        #errorAlert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }

        .btn-primary.active {
            background-color: #ffffff;
            /* Warna latar belakang tombol saat aktif */
            color: rgb(0, 0, 0);
            /* Warna teks tombol saat aktif */
        }

        /* Terapkan animasi fade ke kelas .fade-in */
        .fade-in {
            animation: fadeIn 8s infinite;
        }

        .select2-container--default {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 40px;
            /* Atur tinggi sesuai kebutuhan Anda */
            padding-top: 5px;
        }

        #errorAlert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }

        .step-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding: 0 20px;
        }

        .opened .step-content {
            max-height: 1000px;
            padding: 10px 20px;
        }

        .step-title {
            cursor: pointer;
            padding: 10px 20px;
            background: #fffefe;
            border-radius: 3px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        .step-title i {
            float: right;
        }

        .accordion h5 {
            margin-bottom: 20px;
        }
    </style>

</head>

<body>

    <!-- ======= Header ======= -->
    <?php if (isset($component)) { $__componentOriginalde7054382dc0fbff2a581703922201c4ac7909cd = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\User\Header::class, []); ?>
<?php $component->withName('user.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalde7054382dc0fbff2a581703922201c4ac7909cd)): ?>
<?php $component = $__componentOriginalde7054382dc0fbff2a581703922201c4ac7909cd; ?>
<?php unset($__componentOriginalde7054382dc0fbff2a581703922201c4ac7909cd); ?>
<?php endif; ?>
    <!-- End Header -->

    <!-- ======= Main Content ======= -->
    <?php echo e($slot); ?>

    <!-- End Main Content -->

    <!-- ======= Footer ======= -->
    <?php if (isset($component)) { $__componentOriginal513f25cd918602396247ff009d914634449fa58e = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\User\Footer::class, []); ?>
<?php $component->withName('user.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal513f25cd918602396247ff009d914634449fa58e)): ?>
<?php $component = $__componentOriginal513f25cd918602396247ff009d914634449fa58e; ?>
<?php unset($__componentOriginal513f25cd918602396247ff009d914634449fa58e); ?>
<?php endif; ?>
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <?php if (isset($component)) { $__componentOriginal6be7e67f9c581f6e0c983cfd5b269ca938cdbf43 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\User\Script::class, []); ?>
<?php $component->withName('user.script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6be7e67f9c581f6e0c983cfd5b269ca938cdbf43)): ?>
<?php $component = $__componentOriginal6be7e67f9c581f6e0c983cfd5b269ca938cdbf43; ?>
<?php unset($__componentOriginal6be7e67f9c581f6e0c983cfd5b269ca938cdbf43); ?>
<?php endif; ?>
    <?php echo $__env->yieldPushContent('script'); ?>
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>

</html>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/components/user/layout/home.blade.php ENDPATH**/ ?>