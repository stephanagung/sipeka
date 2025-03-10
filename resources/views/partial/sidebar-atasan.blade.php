<!-- resources/views/partial/sidebar.blade.php -->

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('assets/img/logo_hris.png') }}" alt="navbar brand" class="navbar-brand"
                    height="30" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->is('dashboard-admin') ? 'active' : '' }}">
                    <a href="{{ url('dashboard-admin') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->is('index-pengguna') || request()->is('index-departemen') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#masterdata">
                        <i class="fas fa-layer-group"></i>
                        <p>Master Data</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="masterdata">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('index-pengguna') ? 'active' : '' }}">
                                <a href="{{ url('/index-pengguna') }}">
                                    <span class="sub-item">Data Pengguna</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('index-departemen') ? 'active' : '' }}">
                                <a href="{{ url('/index-departemen') }}">
                                    <span class="sub-item">Data Departemen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->is('index-jatah') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#jatah">
                        <i class="fas fa-hand-holding-heart"></i>
                        <p>Hak-Hak</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="jatah">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('index-jatah') ? 'active' : '' }}">
                                <a href="{{ url('/index-jatah') }}">
                                    <span class="sub-item">Jatah Absensi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->is('index-presensi') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#presensi">
                        <i class="fas fa-user-check"></i>
                        <p>Presensi Karyawan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="presensi">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('index-presensi') ? 'active' : '' }}">
                                <a href="{{ url('/index-presensi') }}">
                                    <span class="sub-item">Presensi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->is('index-laporan') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#laporan">
                        <i class="fas fa-address-card"></i>
                        <p>Laporan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="laporan">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('index-laporan') ? 'active' : '' }}">
                                <a href="{{ url('/index-laporan') }}">
                                    <span class="sub-item">Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- End Navbar Header -->
</div>
<!-- End Sidebar -->
