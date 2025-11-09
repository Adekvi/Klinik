<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php echo e(asset('../aset/')); ?>" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo e($title); ?></title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta name="description" content="" />

    <?php if (isset($component)) { $__componentOriginal997106aebac7a0c4c1acc3fba0aee31f6761cb00 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Style::class, []); ?>
<?php $component->withName('admin.style'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal997106aebac7a0c4c1acc3fba0aee31f6761cb00)): ?>
<?php $component = $__componentOriginal997106aebac7a0c4c1acc3fba0aee31f6761cb00; ?>
<?php unset($__componentOriginal997106aebac7a0c4c1acc3fba0aee31f6761cb00); ?>
<?php endif; ?>
    <?php echo $__env->yieldPushContent('style'); ?>

</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar -->
            <?php if (isset($component)) { $__componentOriginalf876cca3a28f659cd5d542fa68eb46dbaafc0d1d = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Sidebar::class, []); ?>
<?php $component->withName('admin.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf876cca3a28f659cd5d542fa68eb46dbaafc0d1d)): ?>
<?php $component = $__componentOriginalf876cca3a28f659cd5d542fa68eb46dbaafc0d1d; ?>
<?php unset($__componentOriginalf876cca3a28f659cd5d542fa68eb46dbaafc0d1d); ?>
<?php endif; ?>

            <div class="layout-page">

                <!-- Navbar -->
                <?php if (isset($component)) { $__componentOriginal16922a32012e445d83def1b667bd8c380818a472 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Navbar::class, []); ?>
<?php $component->withName('admin.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16922a32012e445d83def1b667bd8c380818a472)): ?>
<?php $component = $__componentOriginal16922a32012e445d83def1b667bd8c380818a472; ?>
<?php unset($__componentOriginal16922a32012e445d83def1b667bd8c380818a472); ?>
<?php endif; ?>

                <div class="content-wrapper">

                    <!-- Content -->
                    <?php echo e($slot); ?>


                    <!-- Chat Box -->
                    

                    <!-- Footer -->
                    <?php if (isset($component)) { $__componentOriginal273b99c895545dc613f61f0747b5dd769beb60e4 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Footer::class, []); ?>
<?php $component->withName('admin.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal273b99c895545dc613f61f0747b5dd769beb60e4)): ?>
<?php $component = $__componentOriginal273b99c895545dc613f61f0747b5dd769beb60e4; ?>
<?php unset($__componentOriginal273b99c895545dc613f61f0747b5dd769beb60e4); ?>
<?php endif; ?>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <?php echo $__env->yieldPushContent('script'); ?>
    <?php if (isset($component)) { $__componentOriginal6cfc523e18c2efee498070974d4978ae7db618e0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\Script::class, []); ?>
<?php $component->withName('admin.script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6cfc523e18c2efee498070974d4978ae7db618e0)): ?>
<?php $component = $__componentOriginal6cfc523e18c2efee498070974d4978ae7db618e0; ?>
<?php unset($__componentOriginal6cfc523e18c2efee498070974d4978ae7db618e0); ?>
<?php endif; ?>
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>

</html>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/components/admin/layout/terminal.blade.php ENDPATH**/ ?>