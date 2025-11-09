<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a class="navbar-brand brand-logo-mini" href="{{ url('admin/dashboard') }}">
            <img src="{{ asset('assets/images/logo_multisari.png') }}" alt=""
                style="width: 80px; padding-block-end: inherit; margin-left: 50px; margin-top: 20px;">
        </a>
    </div>

    <ul class="menu-inner py-1">
        @if (Auth::check())
            @if (Auth::user()->role == 'admin')
                <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('admin/dashboard') }}"
                        class="menu-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <!-- Layouts -->
                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Master Data</li>
                {{-- Data Poli --}}
                <li class="menu-item {{ Request::is('admin/master/datapoli') ? 'active' : '' }}">
                    <a href="{{ url('admin/master/datapoli') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-droplet"></i>
                        <div>Data Poli</div>
                    </a>
                </li>

                {{-- Data Dokter --}}
                <li
                    class="menu-item {{ Request::is('admin/master/datadokter') || Request::is('admin/master/user') || Request::is('admin/master/master-ttd') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-hospital-user"></i>
                        <div>Data Dokter</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/master/datadokter') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/datadokter') }}" class="menu-link">Data Tenaga Medis</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/user') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/user') }}" class="menu-link">Data Akses User</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/master-ttd') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/master-ttd') }}" class="menu-link">Ttd Tenaga Medis</a>
                        </li>
                    </ul>
                </li>

                {{-- Data Pasien --}}
                <li
                    class="menu-item {{ Request::is('admin/master/semuapasien') || Request::is('admin/master/pasienumum') || Request::is('admin/master/pasienbpjs') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-user-nurse"></i>
                        <div>Data Pasien</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/master/semuapasien') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/semuapasien') }}" class="menu-link">Data Semua Pasien</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/pasienumum') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/pasienumum') }}" class="menu-link">Data Pasien Umum</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/pasienbpjs') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/pasienbpjs') }}" class="menu-link">Data Pasien BPJS</a>
                        </li>
                    </ul>
                </li>

                {{-- Data Diagnosa --}}
                <li class="menu-item {{ Request::is('admin/master/diagnosa') ? 'active' : '' }}">
                    <a href="{{ url('admin/master/diagnosa') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-book-medical"></i>
                        <div>Data Diagnosa</div>
                    </a>
                </li>

                {{-- Data Obat --}}
                <li
                    class="menu-item {{ Request::is('admin/master/obat') || Request::is('admin/master/master-jenis') || Request::is('admin/master/master-anjuran') || Request::is('admin/master/master-aturan') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-capsules"></i>
                        <div>Data Obat</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/master/obat') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/obat') }}" class="menu-link">Data Obat</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/master-jenis') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/master-jenis') }}" class="menu-link">Data Jenis Obat</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/master-anjuran') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/master-anjuran') }}" class="menu-link">Data Anjuran Minum</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/master-aturan') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/master-aturan') }}" class="menu-link">Data Aturan Minum</a>
                        </li>
                    </ul>
                </li>

                {{-- Data Margin & Pajak --}}
                <li
                    class="menu-item {{ Request::is('admin/master/master-margin') || Request::is('admin/master/ppn') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-receipt"></i>
                        <div>Data Margin & Pajak</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/master/master-margin') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/master-margin') }}" class="menu-link">Data Setting Margin</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/ppn') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/ppn') }}" class="menu-link">Data Pajak</a>
                        </li>
                    </ul>
                </li>

                {{-- Landing Page --}}
                <li
                    class="menu-item {{ Request::is('admin/master/video') || Request::is('admin/master/poto') || Request::is('admin/master/pidio') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-tv"></i>
                        <div>Landing Page</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/master/video') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/video') }}" class="menu-link">Setting Antrian</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/poto') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/poto') }}" class="menu-link">Foto Kegiatan</a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/master/pidio') ? 'active' : '' }}">
                            <a href="{{ url('admin/master/pidio') }}" class="menu-link">Video Kegiatan</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">User</li>
                <li class="menu-item {{ Request::is('admin/aktifitas-user/*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-toggle-on"></i>
                        <div>Aktifitas User</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/aktifitas-user/status-user') ? 'active' : '' }}">
                            <a href="{{ url('admin/aktifitas-user/status-user') }}" class="menu-link">
                                <div data-i18n="Without menu">Status User</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/aktiitas-user/kelola-pesan') ? 'active' : '' }}">
                            <a href="{{ url('admin/aktiitas-user/kelola-pesan') }}" class="menu-link">
                                <div data-i18n="Without menu">Kelola Pesan</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Rekap Poli Umum</li>
                <li class="menu-item {{ Request::is('admin/rekapan/umum*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-stethoscope"></i>
                        <div>Poli Umum</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/rekapan/umum-bpjs/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/umum-bpjs/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Kunjungan Pasien BPJS (Poli Umum)</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/rekapan/umum-umum/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/umum-umum/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Kunjungan Pasien Umum (Poli Umum)</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Rekap Poli Gigi</li>
                <li class="menu-item {{ Request::is('admin/rekapan/gigi*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-tooth"></i>
                        <div>Poli Gigi</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/rekapan/gigi-bpjs/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/gigi-bpjs/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Kunjungan Pasien BPJS (Poli Gigi)</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/rekapan/gigi-umum/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/gigi-umum/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Kunjungan Pasien Umum (Poli Gigi)</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">All Rekap</li>
                <li
                    class="menu-item {{ Request::is('admin/rekapan*') && !Request::is('admin/rekapan/umum*') && !Request::is('admin/rekapan/gigi*') && !Request::is('admin/rekapan-harian') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-box-archive"></i>
                        <div data-i18n="Account Settings">Rekapan Internal</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item {{ Request::is('admin/rekapan/pemeriksaan-lab/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/pemeriksaan-lab/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Pemeriksaan Laborat</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/rekapan/anc') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/anc') }}" class="menu-link">
                                <div data-i18n="Without menu">Pemeriksaan ANC</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/rekapan/kb/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/kb/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Kunjungan KB</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/rekapan/kejadian-ptm/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/kejadian-ptm/index') }}" class="menu-link">
                                <div data-i18n="Without menu">PTM (Penyakit Tidak Menular)</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ Request::is('admin/rekapan/kejadian/luarbiasa/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/kejadian/luarbiasa/index') }}" class="menu-link">
                                <div data-i18n="Without menu">KLB (Kejadian Luar Biasa)</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/rekapan/diagnosa/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/diagnosa/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Diagnosa Terbanyak</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/rekapan/rujukan/index') ? 'active' : '' }}">
                            <a href="{{ url('admin/rekapan/rujukan/index') }}" class="menu-link">
                                <div data-i18n="Without menu">Rujukan ke Rumah Sakit (FKTRL)</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ Request::is('admin/obat*') ? 'active open' : '' }}">

                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-pills"></i>
                        <div data-i18n="Authentications">Rekap Obat</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/obat-Masuk') ? 'active' : '' }} ">
                            <a href="{{ url('admin/obat-Masuk') }}" class="menu-link">
                                <div data-i18n="Without menu">Obat Masuk</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/obat-keluar') ? 'active' : '' }} ">
                            <a href="{{ url('admin/obat-keluar') }}" class="menu-link">
                                <div data-i18n="Without menu">Obat Keluar</div>
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="menu-item {{ Request::is('admin/rekapan-harian') ? 'active' : '' }}">
                    <a href="{{ url('admin/rekapan-harian') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-square-poll-vertical"></i>
                        <div data-i18n="Account Settings">Rekap Perhari</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Pasien</li>
                <li class="menu-item {{ Request::is('admin/pasien-sehat') ? 'active' : '' }}">
                    <a href="{{ url('admin/pasien-sehat') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-notes-medical"></i>
                        <div data-i18n="Account Settings">Pasien Sehat</div>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'perawat')
                <li class="menu-item {{ Request::is('perawat/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('perawat/dashboard') }}"
                        class="menu-link {{ Request::is('perawat/dashboard') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Beranda</li>
                <li class="menu-item {{ Request::is('perawat/daftar') ? 'active' : '' }}">
                    <a href="{{ url('perawat/daftar') }}"
                        class="menu-link {{ Request::is('perawat/daftar') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-id-card"></i>
                        <div data-i18n="Analytics">Pendaftaran Pasien</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('perawat/index') ? 'active' : '' }}">
                    <a href="{{ url('perawat/index') }}"
                        class="menu-link {{ Request::is('perawat/index') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-user-nurse"></i>
                        <div data-i18n="Analytics">Perawat</div>
                    </a>
                </li>

                {{-- Rekapan Harian --}}
                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Rekapan</li>
                <li class="menu-item {{ Request::is('perawat/rekap/harian') ? 'active' : '' }}">
                    <a href="{{ url('perawat/rekap/harian') }}" class="menu-link">
                        <i class="menu-icon fa-solid fa-calendar-week"></i>
                        <div data-i18n="Account Settings">Rekap Kunjungan Harian</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('perawat/diagnosa-terbanyak') ? 'active' : '' }}">
                    <a href="{{ url('perawat/diagnosa-terbanyak') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-flask"></i>
                        <div data-i18n="Account Settings">Rekap Diagnosa Tebanyak</div>
                    </a>
                </li>

                <!-- Rekap -->
                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Menu</li>
                <li class="menu-item {{ Request::is('rekap-harian') ? 'active' : '' }}">
                    <a href="{{ url('rekap-harian') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-folder"></i>
                        <div data-i18n="Account Settings">Rekap Perhari</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Rekap Poli Umum</li>
                <li
                    class="menu-item {{ Request::is('laporan-*') && !Request::is('laporan/*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-stethoscope"></i>
                        <div>Poli Umum</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('laporan-perawat-pasienBpjs') ? 'active' : '' }}">
                            <a href="{{ url('laporan-perawat-pasienBpjs') }}" class="menu-link">
                                <div data-i18n="Without menu">Pasien BPJS</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('laporan-perawat-pasienUmum') ? 'active' : '' }}">
                            <a href="{{ url('laporan-perawat-pasienUmum') }}" class="menu-link">
                                <div data-i18n="Without menu">Pasien Umum</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Rekap Poli Umum</li>
                <li class="menu-item {{ Request::is('laporan/*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-tooth"></i>
                        <div>Poli Gigi</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('laporan/poliGigi/pasienBpjs') ? 'active' : '' }}">
                            <a href="{{ url('laporan/poliGigi/pasienBpjs') }}" class="menu-link">
                                <div data-i18n="Without menu">Pasien BPJS</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('laporan/poliGigi/pasienUmum') ? 'active' : '' }}">
                            <a href="{{ url('laporan/poliGigi/pasienUmum') }}" class="menu-link">
                                <div data-i18n="Without menu">Pasien Umum</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Petunjuk</li>
                <li class="menu-item {{ Request::is('petunjuk/index') ? 'active' : '' }}">
                    <a href="{{ url('petunjuk/index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-book"></i>
                        <div data-i18n="Account Settings">Petunjuk</div>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'dokter')
                <li class="menu-item {{ Request::is('dokter/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('dokter/dashboard') }}"
                        class="menu-link {{ Request::is('dokter/dashboard') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Menu</li>
                <li class="menu-item {{ Request::is('dokter/index*') ? 'active' : '' }}">
                    <a href="{{ url('dokter/index/tampil') }}"
                        class="menu-link {{ Request::is('dokter/index') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-user-doctor"></i>
                        <div data-i18n="Analytics">Dokter</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('dokter/periksa') ? 'active' : '' }}">
                    <a href="{{ url('dokter/periksa') }}"
                        class="menu-link {{ Request::is('dokter/periksa') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-vial-circle-check"></i>
                        <div data-i18n="Analytics">Data Pasien</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Step</li>
                <li class="menu-item {{ Request::is('petunjuk/index') ? 'active' : '' }}">
                    <a href="{{ url('petunjuk/index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-book"></i>
                        <div data-i18n="Account Settings">Petunjuk</div>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'apoteker')
                <li class="menu-item {{ Request::is('apotek/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('apotek/dashboard') }}"
                        class="menu-link {{ Request::is('apotek/dashboard') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Menu</li>
                <li class="menu-item {{ Request::is('apotek/index') ? 'active' : '' }}">
                    <a href="{{ url('apotek/index') }}"
                        class="menu-link {{ Request::is('apotek/index') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-pills"></i>
                        <div data-i18n="Analytics">Obat</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('apoteker/pasien-dapat-obat') ? 'active' : '' }}">
                    <a href="{{ url('apoteker/pasien-dapat-obat') }}"
                        class="menu-link {{ Request::is('apoteker/pasien-dapat-obat') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-clipboard-user"></i>
                        <div data-i18n="Analytics">Data Pasien</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Master</li>
                <li class="menu-item {{ Request::is('apoteker/master-obat*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-folder"></i>
                        <div>Data Master Obat</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('apoteker/master-obat/obat*') ? 'active' : '' }}">
                            <a href="{{ url('apoteker/master-obat/obat') }}" class="menu-link">
                                <div data-i18n="Without menu">Data Obat</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('apoteker/master-obat/aturan*') ? 'active' : '' }}">
                            <a href="{{ url('apoteker/master-obat/aturan') }}" class="menu-link">
                                <div data-i18n="Without menu">Data Aturan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('apoteker/master-obat/anjuran*') ? 'active' : '' }}">
                            <a href="{{ url('apoteker/master-obat/anjuran') }}" class="menu-link">
                                <div data-i18n="Without menu">Data Anjuran</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('apoteker/master-obat/jenis*') ? 'active' : '' }}">
                            <a href="{{ url('apoteker/master-obat/jenis') }}" class="menu-link">
                                <div data-i18n="Without menu">Data Jenis Obat</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Rekap -->
                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Rekap</li>
                <li class="menu-item {{ Request::is('apoteker/obatMasuk') ? 'active' : '' }}">
                    <a href="{{ url('apoteker/obatMasuk') }}"
                        class="menu-link {{ Request::is('apoteker/obatMasuk') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-capsules"></i>
                        <div data-i18n="Analytics">Rekap Obat Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('apoteker/obatKeluar') ? 'active' : '' }}">
                    <a href="{{ url('apoteker/obatKeluar') }}"
                        class="menu-link {{ Request::is('apoteker/obatKeluar') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-tablets"></i>
                        <div data-i18n="Analytics">Rekap Obat Keluar</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Petunjuk</li>
                <li class="menu-item {{ Request::is('petunjuk/index') ? 'active' : '' }}">
                    <a href="{{ url('petunjuk/index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-book"></i>
                        <div data-i18n="Account Settings">Petunjuk</div>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'kasir')
                <li class="menu-item {{ Request::is('kasir/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('kasir/dashboard') }}"
                        class="menu-link {{ Request::is('kasir/dashboard') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Menu</li>
                <li class="menu-item {{ Request::is('kasir/*') ? 'active' : '' }}">
                    <a href="{{ url('kasir/index') }}"
                        class="menu-link {{ Request::is('kasir/*') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-cash-register"></i>
                        <div data-i18n="Analytics">Kasir</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('kasir/rekap') ? 'active' : '' }}">
                    <a href="{{ url('kasir/rekap') }}"
                        class="menu-link {{ Request::is('kasir/rekap') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-money-bills"></i>
                        <div data-i18n="Analytics">Rekap Pembayaran</div>
                    </a>
                </li>

                {{-- <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Report</li>
                <li class="menu-item {{ Request::is('kasir/report') ? 'active' : '' }}">
                    <a href="{{ url('kasir/report') }}"
                        class="menu-link {{ Request::is('kasir/report') ? 'active' : '' }}">
                        <i class="menu-icon tf-icons fa-solid fa-folder"></i>
                        <div data-i18n="Analytics">Rekap Pembayaran</div>
                    </a>
                </li> --}}

                <li class="sidebar-title menu-link mt-2 mb-2" style="margin-left: 35px">Petunjuk</li>
                <li class="menu-item {{ Request::is('petunjuk/index') ? 'active' : '' }}">
                    <a href="{{ url('petunjuk/index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-book"></i>
                        <div data-i18n="Account Settings">Petunjuk</div>
                    </a>
                </li>
            @endif
        @endif
    </ul>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let currentPath = window.location.pathname;

            document.querySelectorAll(".menu-item").forEach(item => {
                let link = item.querySelector("a");
                if (link && link.getAttribute("href") === currentPath) {
                    item.classList.add("active");

                    let parentSubmenu = item.closest(".menu-sub");
                    if (parentSubmenu) {
                        parentSubmenu.classList.add("open");
                        parentSubmenu.parentElement.classList.add("active");
                    }
                }
            });
        });
    </script>

</aside>
