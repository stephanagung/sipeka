<!-- resources/views/partial/sidebar.blade.php -->

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('assets/img/logo_sipeka_white.png') }}" alt="navbar brand" class="navbar-brand"
                    height="40" />
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
                <li
                    class="nav-item {{ request()->is('dashboard-qp-1') || request()->is('dashboard-qp-2') || request()->is('dashboard-qp-3') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#dashboardAdmin">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="dashboardAdmin">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('dashboard-qp-1') ? 'active' : '' }}">
                                <a href="{{ url('/dashboard-qp-1') }}">
                                    <span class="sub-item">Dashboard QP 1</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('dashboard-qp-2') ? 'active' : '' }}">
                                <a href="{{ url('/dashboard-qp-2') }}">
                                    <span class="sub-item">Dashboard QP 2</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('dashboard-qp-3') ? 'active' : '' }}">
                                <a href="{{ url('/dashboard-qp-3') }}">
                                    <span class="sub-item">Dashboard QP 3</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li
                    class="nav-item {{ request()->is('index-pengguna') || request()->is('detail-pengguna/*') || request()->is('index-kategori-absensi') || request()->is('index-departemen') || request()->is('index-plant') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#masterdata">
                        <i class="fas fa-layer-group"></i>
                        <p>Master Data</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="masterdata">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('index-pengguna') || request()->is('detail-pengguna/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-pengguna') }}">
                                    <span class="sub-item">Data Pengguna</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('index-kategori-absensi') ? 'active' : '' }}">
                                <a href="{{ url('/index-kategori-absensi') }}">
                                    <span class="sub-item">Data Kategori Absensi</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('index-departemen') ? 'active' : '' }}">
                                <a href="{{ url('/index-departemen') }}">
                                    <span class="sub-item">Data Departemen</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('index-plant') ? 'active' : '' }}">
                                <a href="{{ url('/index-plant') }}">
                                    <span class="sub-item">Data Plant</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-jatah-absensi') || request()->is('index-list-absensi/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#jatah">
                        <i class="fas fa-hand-holding-heart"></i>
                        <p>Cuti & Absensi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="jatah">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-jatah-absensi') || request()->is('index-list-absensi/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-jatah-absensi') }}">
                                    <span class="sub-item">Kuota Cuti & Absensi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-absensi') || request()->is('index-info-absensi/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#presensi">
                        <i class="fas fa-user-check"></i>
                        <p>Pelaporan Absensi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="presensi">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-absensi') || request()->is('index-info-absensi/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-absensi') }}">
                                    <span class="sub-item">Pengajuan Cuti & Absensi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-rekap-kaizen') || request()->is('index-data-kaizen/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#monitoringkaizen">
                        <i class="fas fa-lightbulb"></i>
                        <p>Data Kaizen</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="monitoringkaizen">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-rekap-kaizen') || request()->is('index-data-kaizen/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-rekap-kaizen') }}">
                                    <span class="sub-item">Rekap Kaizen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-rekap-overtime') || request()->is('index-data-overtime/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#rekapmonitoringovertime">
                        <i class="fas fa-clock"></i>
                        <p>Data Overtime</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="rekapmonitoringovertime">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-rekap-overtime') || request()->is('index-data-overtime/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-rekap-overtime') }}">
                                    <span class="sub-item">Rekap Overtime</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-rekap-asesmen-prd') || request()->is('index-data-asesmen-prd/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#rekapmonitoringasesmenprd">
                        <i class="fas fa-industry"></i>
                        <p>Data Asesmen PRD</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="rekapmonitoringasesmenprd">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-rekap-asesmen-prd') || request()->is('index-data-asesmen-prd/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-rekap-asesmen-prd') }}">
                                    <span class="sub-item">Rekap Asesmen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-rekap-kecelakaan') || request()->is('index-data-kecelakaan/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#rekapmonitoringkecelakaan">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Data Kecelakaan</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse" id="rekapmonitoringkecelakaan">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-rekap-kecelakaan') || request()->is('index-data-kecelakaan/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-rekap-kecelakaan') }}">
                                    <span class="sub-item">Rekap Kecelakaan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-rekap-pelatihan') || request()->is('index-data-pelatihan/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#rekapmonitoringpelatihan">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Data Pelatihan</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse" id="rekapmonitoringpelatihan">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-rekap-pelatihan') || request()->is('index-data-pelatihan/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-rekap-pelatihan') }}">
                                    <span class="sub-item">Rekap Pelatihan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('index-rekap-pemenuhan-tk') || request()->is('index-data-pemenuhan-tk/*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#rekapmonitoringpemenuhantk">
                        <i class="fas fa-users"></i>
                        <p>Data Pemenuhan TK</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse" id="rekapmonitoringpemenuhantk">
                        <ul class="nav nav-collapse">
                            <li
                                class="{{ request()->is('index-rekap-pemenuhan-tk') || request()->is('index-data-pemenuhan-tk/*') ? 'active' : '' }}">
                                <a href="{{ url('/index-rekap-pemenuhan-tk') }}">
                                    <span class="sub-item">Rekap Pemenuhan TK</span>
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