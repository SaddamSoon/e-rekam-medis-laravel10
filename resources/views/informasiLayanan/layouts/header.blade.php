<header>
            <navp class="navbar navbar-expand-lg navbar-light bg-custom-navbar shadow" style="height:100%">
            <div class="container-fluid inria-serif-regular">
                <div class="navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <p  data-aos="fade-right" class="inria-serif-bold mx-3 text-dark" style="font-size: 0.9em">Selamat datang di layanan Klinik drg. Birna Marwikka</p>
                    </li>
                </ul>
                <i class="fa-solid fa-calendar-check text-success"></i>
                <span class="navbar-text mx-4"  data-aos="fade-left">
                    <b class="row" style="font-size:0.8rem">17:00-21:00 (Senin-Jum'at)</b>
                    <b class="row" style="font-size:0.8rem">10:00-20:30 (Sabtu-Minggu)</b>
                </span>
                <i class="fa-solid fa-phone text-success"></i>
                <span class="navbar-text mx-2"  data-aos="fade-left">
                    <b style="font-size:0.8rem">0832323232</b>
                </span>
                <i class="fa-solid fa-envelope text-success mx-2"></i>
                <span class="navbar-text mx-1"  data-aos="fade-left">
                    <b style="font-size:0.8rem">birnamarwikka@gmail.com</b>
                </span>
                </div>
            </div>
            </navp>
    </header>
        <div class="sticky-top">
            <nav class="navbar navbar-expand-lg navbar-light bg-custom-navbar2" style="height:4rem">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="/" class="navbar-brand justify-content-start"><img src="{{ asset('img/logo_clinic.png') }}" alt="" width="220rem"></a>
                    <div class="collapse navbar-collapse justify-content-end me-5" id="navbarText">
                    <ul class="navbar-nav mb-2 mb-lg-0 me-5 text-muted">
                            <li class="nav-item me-5">
                            <a class="nav-link text-custom-color inria-serif-regular {{ Request::is('/') ? 'active' : '' }}" href="/#home">Home</a>
                            </li>
                            <li class="nav-item me-5">
                            <a class="nav-link text-custom-color inria-serif-regular" href="/#about">Tentang Kami</a>
                            </li>
                            <li class="nav-item me-5">
                            <a class="nav-link text-custom-color inria-serif-regular" href="/#janjiTemu">Janji Temu</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link text-custom-color inria-serif-regular {{ Request::routeIs('layanan-tarif') ? 'active' : '' }}" href="{{ route('layanan-tarif') }}">Tarif Layanan</a>
                            </li>
                    </ul>
                    </div>
            </div>
            </nav>
        </div>