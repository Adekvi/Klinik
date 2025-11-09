<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="<?php echo e(url('/')); ?>" class="logo">
            <img src="<?php echo e(asset('assets/images/logo_multisari.png')); ?>" alt="image">
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <?php if(Auth::check()): ?>
                    <li><a href="<?php echo e(url('/')); ?>" class="<?php echo e(Request::is('/') ? 'active' : ''); ?>">Beranda</a></li>
                    <?php if(Auth::user()->role === 'perawat'): ?>
                        <li>
                            <a href="<?php echo e(url('perawat/index')); ?>"
                                class="<?php echo e(Request::is('perawat/index') ? 'active' : ''); ?>">Perawat
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Auth::user()->role === 'dokter'): ?>
                        <li>
                            <a href="<?php echo e(url('dokter/index/tampil')); ?>"
                                class="<?php echo e(Request::is('dokter/index/tampil') ? 'active' : ''); ?>">Dokter
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Auth::user()->role === 'apoteker'): ?>
                        <li>
                            <a href="<?php echo e(url('apotek/index')); ?>"
                                class="<?php echo e(Request::is('apotek/index') ? 'active' : ''); ?>">Ambil Obat
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?php echo e(Request::is('apoteker/masterObat') ? 'active' : ''); ?>"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Data Master
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="nav-item dropdown">
                                <li>
                                    <a href="<?php echo e(url('apoteker/masterObat')); ?>"
                                        class="<?php echo e(Request::is('apoteker/masterObat') ? 'active' : ''); ?>">Data Obat
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(url('apoteker/obatMasuk')); ?>"
                                        class="<?php echo e(Request::is('apoteker/obatMasuk') ? 'active' : ''); ?>">Obat Masuk
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(url('apoteker/obatKeluar')); ?>"
                                        class="<?php echo e(Request::is('apoteker/obatKeluar') ? 'active' : ''); ?>">Obat
                                        Keluar
                                    </a>
                                </li>
                        </li>
                    <?php endif; ?>
                    <?php if(Auth::user()->role === 'kasir'): ?>
                        <li>
                            <a href="<?php echo e(url('kasir/index')); ?>"
                                class="<?php echo e(Request::is('kasir/index') ? 'active' : ''); ?>">Kasir
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <li>
                            <a href="<?php echo e(url('admin/dashboard')); ?>" style="color: #ffffff;"
                                class="<?php echo e(Request::is('admin/dashboard') ? 'active' : ''); ?>"><strong>Dashboard
                                </strong>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu mt-3" aria-labelledby="userDropdown">
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-login dropdown-item" type="submit">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ffffff;"
                            href="<?php echo e(url('login/index')); ?>"><?php echo e(__('Login')); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<?php /**PATH E:\xampp\htdocs\Job_Rs_Master\resources\views/components/user/header.blade.php ENDPATH**/ ?>