<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    {{-- font --}}
    <!-- Custom fonts for this template-->
        <link href="{{ asset('vendor/fontawesome-free7/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        {{-- endfont --}}
    <link href="{{ asset('css/dashboard/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- datatables --}}
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <title>Klinik drg. Birna Marwikka</title>
    <style>
        .btn {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .carousel-item img {
        height: 500px; 
        object-fit: cover;
        filter: blur(5px);        
        -webkit-filter: blur(5px); 
        }
        .carousel-item p{
            background-color: rgba(0, 0, 0,0.05);
            color: #fff;
        }
        .bg-custom-navbar {
            background-color: #fff;
        }
        .bg-custom-navbar2 {
            background-color: #fff;
        }
        .inria-serif-light {
            font-family: "Inria Serif", serif;
            font-weight: 300;
            font-style: normal;
        }

            .inria-serif-regular {
            font-family: "Inria Serif", serif;
            font-weight: 400;
            font-style: normal;
        }

            .inria-serif-bold {
            font-family: "Inria Serif", serif;
            font-weight: 700;
            font-style: normal;
        }

            .inria-serif-light-italic {
            font-family: "Inria Serif", serif;
            font-weight: 300;
            font-style: italic;
        }

            .inria-serif-regular-italic {
            font-family: "Inria Serif", serif;
            font-weight: 400;
            font-style: italic;
        }

            .inria-serif-bold-italic {
            font-family: "Inria Serif", serif;
            font-weight: 700;
            font-style: italic;
        }
         .text-custom-color {
                color: #4f4646;
        }
        .about p{
            background-color: rgba(0, 0, 0,0.3);
            color: #fff;
        }
        #home,
        #home .carousel,
        #home .carousel-inner,
        #home .carousel-item {
            height: 100vh; /* full 1 layar */
        }

        #home .carousel-item img {
            object-fit: cover;  /* biar gambar tidak ketarik */
            height: 100vh;
            width: 100%;
        }
        #home .carousel-caption {
            top: 50%;
            transform: translateY(-50%);
            bottom: initial; /* hapus posisi default bawah */
        }
        #lokasi{
            padding-left: 0;
            padding-right: 0;
        }
        #lokasi iframe{
            width: 100% !important;
            height: 100% !important;
        }



    </style>
  </head>
  <body>
    @include('informasiLayanan.layouts.header')
    @yield('content')
    @include('informasiLayanan.layouts.footer')
    {{-- Sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- sweet alert logic jquery --}}

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Page level custom scripts -->
        <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
       <script>
            AOS.init({
                duration: 1000,
                once: false
            });
            document.addEventListener("DOMContentLoaded", function () {
                if (window.location.pathname !== "/") return;

                const offset = 130; // tinggi navbar
                const sections = document.querySelectorAll("section[id]");
                const navLinks = document.querySelectorAll(".nav-link");

                function setActiveOnScroll() {
                    let scrollY = window.pageYOffset;
                    sections.forEach(section => {
                        const top = section.offsetTop - offset;
                        const bottom = top + section.offsetHeight;
                        if (scrollY >= top && scrollY < bottom) {
                            navLinks.forEach(link => link.classList.remove("active"));
                            navLinks.forEach(link => {
                                const href = link.getAttribute("href");
                                if (href === "#" + section.id || href === "/#" + section.id) {
                                    link.classList.add("active");
                                }
                            });
                        }
                    });
                }

                window.addEventListener("scroll", setActiveOnScroll);
                setActiveOnScroll();

                // ✅ Smooth scroll dengan offset
                navLinks.forEach(link => {
                    link.addEventListener("click", function (e) {
                        const href = this.getAttribute("href");
                        if (href.startsWith("#") || href.startsWith("/#")) {
                            e.preventDefault();
                            const id = href.replace("/#", "").replace("#", "");
                            const target = document.getElementById(id);
                            if (target) {
                                const top = target.offsetTop - offset; // pakai offset biar ga ketutup navbar
                                window.scrollTo({
                                    top: top,
                                    behavior: "smooth"
                                });
                            }
                        }
                    });
                });
            });
            </script>

    @stack('scripts')
  </body>
</html>