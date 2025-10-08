<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Klinik drg. Birna Marwikka menyediakan layanan perawatan gigi dan mulut profesional dengan dokter berpengalaman di Padang.">
    <meta name="keywords" content="klinik gigi padang pariaman, vii koto sungai sariak, buluh kasok, sungai sariak, dokter gigi padang pariaman, dokter gigi sungai sariak, klinik drg birna, klinik drg birnamarwikka, layanan gigi, perawatan gigi">
    <meta name="robots" content="index, follow">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- Custom fonts -->
    <link href="{{ asset('vendor/fontawesome-free7/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link href="{{ asset('css/dashboard/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <title>Klinik drg. Birna Marwikka</title>
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0b5ed7;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark-text);
            overflow-x: hidden;
        }

        /* Typography */
        .section-title {
            font-family: "Inria Serif", serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--dark-text);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--secondary-color);
            margin-bottom: 2rem;
        }

        /* Hero Carousel */
        #home,
        #home .carousel,
        #home .carousel-inner,
        #home .carousel-item {
            height: 100vh;
            min-height: 600px;
        }

        .carousel-image-wrapper {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        #home .carousel-item img {
            object-fit: cover;
            height: 100vh;
            width: 100%;
            filter: brightness(0.7);
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6));
            pointer-events: none;
        }

        #home .carousel-caption {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            bottom: initial;
            left: 5%;
            right: 5%;
            text-align: center;
            z-index: 10;
            pointer-events: none;
        }

        #home .carousel-caption .btn {
            pointer-events: auto;
        }

        /* Carousel controls */
        .carousel-control-prev,
        .carousel-control-next {
            z-index: 15;
            width: 5%;
            opacity: 0.8;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 3rem;
            height: 3rem;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 10px;
        }

        .caption-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .caption-text {
            font-size: 1.5rem;
            font-weight: 300;
            color: #fff;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            line-height: 1.6;
        }

        .btn-custom-primary {
            background: var(--primary-color);
            color: #fff;
            padding: 14px 32px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-custom-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid #fff;
        }

        .carousel-indicators button.active {
            background-color: #fff;
        }

        /* About Section */
        #about {
            min-height: 100vh;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .about-wrapper {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 80px 0;
        }

        .about-wrapper .container {
            width: 100%;
            max-width: 100%;
            padding-left: 15px;
            padding-right: 15px;
        }

        .about-content {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
        }

        .about-content h2 {
            color: var(--primary-color);
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--dark-text);
        }

        /* Appointment Section */
        #janjiTemu {
            background: var(--light-bg);
            padding: 80px 0;
            min-height: auto;
        }

        .table-custom {
            background: #fff;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .table-custom thead {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: #fff;
        }

        .table-custom thead th {
            padding: 18px 15px;
            font-weight: 600;
            border: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-custom tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid #f0f0f0;
        }

        .table-custom tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }

        .table-custom tbody td {
            padding: 20px 15px;
            vertical-align: middle;
        }

        .doctor-name {
            font-weight: 600;
            color: var(--dark-text);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .badge-available {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-unavailable {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-badge .fa-circle {
            font-size: 0.5rem;
        }

        .schedule-time {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .btn-appointment {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-appointment:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .btn-appointment:disabled {
            background: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
        }

        /* Modal Styles */
        .modal-custom .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: #fff;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 24px 30px;
        }

        .modal-custom .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .modal-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 4px;
        }

        .modal-custom .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-custom .modal-body {
            padding: 30px;
        }

        .form-label-custom {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control-custom {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 16px;
            transition: var(--transition);
            font-size: 1rem;
        }

        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .form-control-custom.is-invalid {
            border-color: var(--danger-color);
        }

        .selected-doctor {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            padding: 16px 20px;
            border-radius: 8px;
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 1.1rem;
        }

        .btn-submit-custom {
            background: var(--success-color);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-submit-custom:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-secondary-custom {
            background: #fff;
            color: var(--secondary-color);
            border: 2px solid #e9ecef;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-secondary-custom:hover {
            background: #f8f9fa;
            border-color: var(--secondary-color);
        }

        /* Location Section */
        #lokasi {
            padding: 80px 0;
            background: #fff;
        }

        .map-container {
            width: 100%;
            height: 500px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .caption-text {
                font-size: 1.1rem;
            }

            .btn-custom-primary {
                padding: 12px 24px;
                font-size: 1rem;
            }

            .about-content {
                padding: 30px 20px;
            }

            #janjiTemu {
                padding: 60px 0;
            }

            .table-custom {
                font-size: 0.9rem;
            }

            .table-custom thead th,
            .table-custom tbody td {
                padding: 12px 8px;
            }

            .modal-custom .modal-body {
                padding: 20px;
            }

            #home,
            #home .carousel,
            #home .carousel-inner,
            #home .carousel-item {
                height: 70vh;
                min-height: 500px;
            }

            .carousel-image-wrapper,
            #home .carousel-item img {
                height: 70vh;
            }

            .map-container {
                height: 350px;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 1.75rem;
            }

            .about-content {
                padding: 25px 15px;
            }

            .about-text {
                font-size: 1rem;
            }

            .btn-appointment {
                padding: 8px 12px;
                font-size: 0.85rem;
            }

            .status-badge {
                padding: 6px 12px;
                font-size: 0.75rem;
            }

            .modal-custom .modal-title {
                font-size: 1.25rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading state */
        .btn-appointment:disabled,
        .btn-submit-custom:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* DataTables custom styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 16px !important;
            border-radius: 6px !important;
            margin: 0 4px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color) !important;
            color: white !important;
            border: 1px solid var(--primary-color) !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 16px;
            margin-left: 8px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 6px 12px;
        }

        /* Error message styling */
        .error-msg {
            display: block;
            margin-top: 6px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Navbar enhancement (if exists in header) */
        .bg-custom-navbar,
        .bg-custom-navbar2 {
            background-color: #fff !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        /* Font classes */
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

        /* Print styles */
        @media print {
            .carousel-control-prev,
            .carousel-control-next,
            .btn-appointment {
                display: none !important;
            }
        }

        /* Accessibility improvements */
        .btn:focus,
        .form-control:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Utility classes */
        .shadow-custom {
            box-shadow: var(--box-shadow);
        }

        .rounded-custom {
            border-radius: var(--border-radius);
        }

        /* Hover effects for interactive elements */
        .table-custom tbody tr {
            cursor: default;
        }

        /* Spinner for loading states */
        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    @include('informasiLayanan.layouts.header')
    @yield('content')
    @include('informasiLayanan.layouts.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: false,
            offset: 100
        });

        // Smooth scroll with offset for navbar
        document.addEventListener("DOMContentLoaded", function () {
            if (window.location.pathname !== "/") return;

            const offset = 130;
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

            // Smooth scroll with offset
            navLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    const href = this.getAttribute("href");
                    if (href.startsWith("#") || href.startsWith("/#")) {
                        e.preventDefault();
                        const id = href.replace("/#", "").replace("#", "");
                        const target = document.getElementById(id);
                        if (target) {
                            const top = target.offsetTop - offset;
                            window.scrollTo({
                                top: top,
                                behavior: "smooth"
                            });
                        }
                    }
                });
            });
        });

        // Add loading animation to buttons on click
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-appointment:not(:disabled)');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.add('animate-fade-in-up');
                });
            });
        });

        // Reset form on modal close
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('janjiModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    const form = this.querySelector('.janjiForm');
                    if (form) {
                        form.reset();
                        form.querySelectorAll('.error-msg').forEach(el => el.textContent = '');
                        form.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>