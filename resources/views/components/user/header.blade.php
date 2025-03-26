<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="image">
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                @if (Auth::check())
                    <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Beranda</a></li>
                    @if (Auth::user()->role === 'perawat')
                        <li><a href="{{ url('perawat/index') }}"
                                class="{{ Request::is('perawat/index') ? 'active' : '' }}">Perawat</a></li>
                        {{-- <li><a href="{{ url('rekap-harian') }}"
                                class="{{ Request::is('rekap-harian') ? 'active' : '' }}">Rekap Harian</a></li>
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                Laporan Kunjungan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <!-- Dropdown untuk Poli Umum -->
                                <li class="dropdown">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="poliUmumDropdown"
                                        data-bs-toggle="dropdown">
                                        Poli Umum
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ url('laporan-perawat-pasienBpjs') }}">Pasien BPJS</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ url('laporan-perawat-pasienUmum') }}">Pasien Umum</a></li>
                                    </ul>
                                </li>

                                <!-- Dropdown untuk Poli Gigi -->
                                <li class="dropdown">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="poliGigiDropdown"
                                        data-bs-toggle="dropdown">
                                        Poli Gigi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ url('laporan/poliGigi/pasienBpjs') }}">Pasien BPJS</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ url('laporan/poliGigi/pasienUmum') }}">Pasien Umum</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}
                    @endif
                    @if (Auth::user()->role === 'dokter')
                        <li><a href="{{ url('dokter/index') }}"
                                class="{{ Request::is('dokter/index') ? 'active' : '' }}">Dokter</a></li>
                    @endif
                    @if (Auth::user()->role === 'apoteker')
                        <li><a href="{{ url('apotek/index') }}"
                                class="{{ Request::is('apotek/index') ? 'active' : '' }}">Ambil Obat</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Request::is('apoteker/masterObat') ? 'active' : '' }}"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Data Master
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="nav-item dropdown">
                                <li><a href="{{ url('apoteker/masterObat') }}"
                                        class="{{ Request::is('apoteker/masterObat') ? 'active' : '' }}">Data Obat</a>
                                </li>
                                {{-- <li><a href="{{ url('apoteker/stok-Obat') }}" class="{{ Request::is('apoteker/stok-Obat') ? 'active' : '' }}">Stok Obat</a></li> --}}
                                <li><a href="{{ url('apoteker/obatMasuk') }}"
                                        class="{{ Request::is('apoteker/obatMasuk') ? 'active' : '' }}">Obat Masuk</a>
                                </li>
                                <li><a href="{{ url('apoteker/obatKeluar') }}"
                                        class="{{ Request::is('apoteker/obatKeluar') ? 'active' : '' }}">Obat
                                        Keluar</a></li>
                        </li>
                    @endif
                    @if (Auth::user()->role === 'kasir')
                        <li><a href="{{ url('kasir/index') }}"
                                class="{{ Request::is('kasir/index') ? 'active' : '' }}">Kasir</a></li>
                    @endif
                    @if (Auth::user()->role === 'admin')
                        <li><a href="{{ url('admin/dashboard') }}" style="color: #ffffff;"
                                class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"><strong>Laporan</strong></a>
                        </li>
                    @endif
                    {{-- @if (in_array(Auth::user()->role, ['perawat', 'dokter', 'apoteker', 'admin']))
                        <li><a href="{{ url('petunjuk/index') }}"
                                class="{{ Request::is('petunjuk/index') ? 'active' : '' }}">Petunjuk</a></li>
                    @endif --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu mt-3" aria-labelledby="userDropdown">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-login dropdown-item" type="submit">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ffffff;"
                            href="{{ url('login/index') }}">{{ __('Login') }}</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</header>
