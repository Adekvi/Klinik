<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center position-relative w-100">
            <div class="nav-item d-flex align-items-center w-100">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" id="search-input" class="form-control border-0 shadow-none"
                    placeholder="Search..." aria-label="Search..." onkeyup="filterSearch()" autocomplete="off" />
            </div>
            <ul id="search-results" class="list-group position-absolute w-100 bg-white shadow rounded"
                style="top: 100%; display: none; z-index: 1050; max-height: 250px; overflow-y: auto;"></ul>
        </div>

        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->
            <?php if(Auth::user()->role === 'admin'): ?>
                <li class="nav-item" style="margin-right: 20px">
                    <a href="<?php echo e(url('/antrian')); ?>" class="antrian" target="_blank">
                        <i class="fa-solid fa-up-right-from-square"></i> &nbsp;Tampilan Antrian
                    </a>
                </li>
            <?php endif; ?>
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="<?php echo e(asset('aset/img/user.webp')); ?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="<?php echo e(asset('aset/img/user.webp')); ?>" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"><?php echo e(Auth::user()->name); ?></span>
                                    <small class="text-muted"><?php echo e(Auth::user()->name); ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <?php if(Auth::check()): ?>
                        <?php if(Auth::user()->role == 'admin'): ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(url('admin/my-profile')); ?>">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(url('admin/info')); ?>">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Informasi</span>
                                </a>
                            </li>
                        <?php elseif(Auth::user()->role == 'perawat'): ?>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Informasi</span>
                                </a>
                            </li>
                        <?php elseif(Auth::user()->role == 'dokter'): ?>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Informasi</span>
                                </a>
                            </li>
                        <?php elseif(Auth::user()->role == 'apoteker'): ?>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Informasi</span>
                                </a>
                            </li>
                        <?php elseif(Auth::user()->role == 'kasir'): ?>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Informasi</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="auth-login-basic.html"
                            style="display: flex; align-items: center">
                            <i class="bx bx-power-off me-2"></i>
                            
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-login align-middle text-muted" type="submit">
                                    Logout
                                </button>
                            </form>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<?php $__env->startPush('script'); ?>
    <script>
        const menuItems = [{
                name: "Dashboard",
                url: "/admin/dashboard"
            },
            {
                name: "Master Data",
                url: "/admin/master*"
            },
            {
                name: "Data Akses User",
                url: "/admin/master/user"
            },
            {
                name: "Data Poli",
                url: "/admin/master/datapoli"
            },
            {
                name: "Data Dokter",
                url: "/admin/master/datadokter"
            },
            {
                name: "Ttd Tenaga Medis",
                url: "/admin/master/master-ttd"
            },
            {
                name: "Data Semua Pasien",
                url: "/admin/master/semuapasien"
            },
            {
                name: "Data Pasien Umum",
                url: "/admin/master/pasienumum"
            },
            {
                name: "Data Pasien Bpjs",
                url: "/admin/master/pasienbpjs"
            },
            {
                name: "Data Diagnosa",
                url: "/admin/master/diagnosa"
            },
            {
                name: "Data Obat",
                url: "/admin/master/obat"
            },
            {
                name: "Master Margin",
                url: "/admin/master/master-margin"
            },
            {
                name: "Tindakan Dokter",
                url: "/admin/master/tindakan"
            },
            {
                name: "Data Pajak",
                url: "/admin/master/ppn"
            },
            {
                name: "Video Antrian",
                url: "/admin/master/video"
            },
            {
                name: "Galeri Foto",
                url: "/admin/master/poto"
            },
            {
                name: "Galeri Video",
                url: "/admin/master/pidio"
            },
            {
                name: "Poli Umum",
                url: "/admin/rekapan/umum*"
            },
            {
                name: "Rekapan Poli Umum - Pasien Umum",
                url: "/admin/rekapan/umum-umum/index"
            },
            {
                name: "Rekapan Poli Umum - Pasien Bpjs",
                url: "/admin/rekapan/umum-bpjs/index"
            },
            {
                name: "Poli Gigi",
                url: "/admin/rekapan/gigi*"
            },
            {
                name: "Rekapan Poli Gigi - Pasien Umum",
                url: "/admin/rekapan/gigi-umum/index"
            },
            {
                name: "Rekapan Poli Gigi - Pasien Bpjs",
                url: "/admin/rekapan/gigi-bpjs/index"
            },
            {
                name: "Rekapan Internal",
                url: "/admin/rekapan*"
            },
            {
                name: "Pemeriksaan Laborat",
                url: "/admin/rekapan/pemeriksaan-lab/index"
            },
            {
                name: "Pemeriksaan Anc",
                url: "/admin/rekapan/anc"
            },
            {
                name: "Kunjungan KB",
                url: "/admin/rekapan/kb/index"
            },
            {
                name: "PTM (Penyakit Tidak Menular)",
                url: "/admin/rekapan/kejadian-ptm/index"
            },
            {
                name: "KLB (Kejadian Luar Biasa)",
                url: "/admin/rekapan/kejadian/luarbiasa/index"
            },
            {
                name: "Diagnosa Terbanyak",
                url: "/admin/rekapan/diagnosa/index"
            },
            {
                name: "Rujukan Rumah Sakit (FTKRL)",
                url: "/admin/rekapan/rujukan/index"
            },
            {
                name: "Rekap Obat",
                url: "/admin/obat"
            },
            {
                name: "Obat Masuk",
                url: "/admin/obat-Masuk"
            },
            {
                name: "Obat Keluar",
                url: "/admin/obat-keluar"
            },
            {
                name: "Rekap Perhari",
                url: "/admin/rekapan-perhari"
            },
            {
                name: "Pasien Sehat",
                url: "/admin/pasien-sehat"
            },
            {
                name: "My Profile",
                url: "/admin/my-profile"
            },
            {
                name: "Informasi",
                url: "/admin/info"
            },
            {
                name: "Logout",
                url: "logout"
            }
        ];

        function filterSearch() {
            let input = document.getElementById("search-input").value.toLowerCase();
            let resultsContainer = document.getElementById("search-results");

            resultsContainer.innerHTML = "";
            if (input.length === 0) {
                resultsContainer.style.display = "none";
                return;
            }

            let filteredItems = menuItems.filter(item => item.name.toLowerCase().includes(input));

            if (filteredItems.length > 0) {
                resultsContainer.style.display = "block";
                filteredItems.forEach(item => {
                    let listItem = document.createElement("li");
                    listItem.className = "list-group-item list-group-item-action";
                    listItem.textContent = item.name;
                    listItem.style.cursor = "pointer";

                    listItem.onclick = () => {
                        window.location.href = item.url; // Langsung ke URL yang sesuai
                    };

                    resultsContainer.appendChild(listItem);
                });
            } else {
                resultsContainer.style.display = "none";
            }
        }

        // Tutup dropdown jika klik di luar area pencarian
        document.addEventListener("click", function(event) {
            let searchBox = document.getElementById("search-input");
            let resultsContainer = document.getElementById("search-results");

            if (!searchBox.contains(event.target) && !resultsContainer.contains(event.target)) {
                resultsContainer.style.display = "none";
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Klinik\resources\views/components/admin/navbar.blade.php ENDPATH**/ ?>