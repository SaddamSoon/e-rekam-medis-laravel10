<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-tooth"></i>
                </div>
                <div class="sidebar-brand-text mx-3">E-Rekam Medis</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @auth
            <li class="nav-item {{ Request::is('dashboard')? 'active' : '' }}">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            @endauth
            @can('isAdmin')
            <!-- Nav Item - Dokter -->
            <li class="nav-item {{ Request::is('dashboard/dokter*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dokter') }}">
                    <i class="fa-solid fa-user-doctor"></i>
                    <span>Dokter</span></a>
            </li>
            <!-- Nav Item - ketersediaan_dokter -->
            {{-- <li class="nav-item {{ Request::is('dashboard/ketdok*')? 'active' : '' }}">
                <a class="nav-link" href=
                "{{ route('ketdok') }}"
                >
                <i class="fa-solid fa-person-walking-luggage"></i>
                <span>Ketersediaan Dokter</span></a>
            </li> --}}
            @endcan
            <!-- Nav Item - Rekam Medis -->
            <li class="nav-item {{ Request::is('dashboard/rekmed*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('rekmed') }}">
                    <i class="fa-solid fa-book-medical"></i>
                    <span>Rekam Medis</span></a>
            </li>
            {{-- @can('isDokter')
            
             <!-- Nav Item - janji temu -->
            <li class="nav-item {{ Request::is('dashboard/janjitemuDok*')? 'active' : '' }}">
                <a class="nav-link" href=
                "{{ route('janjitemuDok') }}"
                >
                    <i class="fa-regular fa-alarm-clock"></i>
                    <span>Janji Temu</span></a>
            </li>
            @endcan --}}
            <!-- Nav Item - janji temu -->
            <li class="nav-item {{ Request::is('dashboard/janjitemu*')? 'active' : '' }}">
                <a class="nav-link" href=
                "{{ route('janjitemu') }}"
                >
                    <i class="fa-regular fa-alarm-clock"></i>
                    <span>Janji Temu</span></a>
            </li>
            @can('isAdmin')
            <!-- Nav Item - Obat -->
            <li class="nav-item {{ Request::is('dashboard/obat*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('obat') }}">
                    <i class="fa-solid fa-pills"></i>
                    <span>Obat</span></a>
            </li>
            <!-- Nav Item - Spesialis Dokter -->
            <li class="nav-item {{ Request::is('dashboard/spes*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('spes') }}">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>Spesialis Dokter</span></a>
            </li>
            <!-- Nav Item - Pasien -->
            <li class="nav-item {{ Request::is('dashboard/pasien*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pasien') }}">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span>Pasien</span></a>
            </li>
            @endcan
            @can('isDokter')
            <!-- Nav Item - Pasien -->
            <li class="nav-item {{ Request::is('dashboard/pasien*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pasien') }}">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span>Pasien</span></a>
            </li>
            @endcan
            <!-- Divider -->
            <hr class="sidebar-divider">

            @can('isAdmin')
            <!-- Heading -->
            <div class="sidebar-heading">
                Informasi Layanan
            </div>

            <!-- Slider -->
            <li class="nav-item {{ Request::is('dashboard/slider*')? 'active' : '' }}"">
                <a class="nav-link" href="{{ route('slider') }}">
                    <i class="fa-solid fa-images"></i>
                    <span>Slider</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item {{ Request::is('dashboard/about*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('about') }}">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>About</span></a>
            </li>
            <!-- Nav Item - Tables -->
            <li class="nav-item {{ Request::is('dashboard/layanan*')? 'active' : '' }}">
                <a class="nav-link" href="{{ route('layanan') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Layanan Tarif</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            @endcan

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->