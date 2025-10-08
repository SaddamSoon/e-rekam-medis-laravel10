@extends('informasiLayanan.layouts.main')
@section('content')
<!-- Hero Carousel Section -->
<section id="home">
    <div class="container-fluid p-0">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($slider as $index => $s)
                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{ $index }}" 
                    class="{{ $s->order==1?'active':'' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            
            <div class="carousel-inner">
                @foreach($slider as $s)
                <div class="carousel-item {{ $s->order==1?'active':'' }}">
                    <div class="carousel-image-wrapper">
                        <img src="{{ asset('/uploads/slider/'.$s->img_url) }}" 
                            class="d-block w-100" alt="slide-{{ $s->order }}">
                        <div class="carousel-overlay"></div>
                    </div>
                    
                    <div class="carousel-caption" data-aos="fade-up" data-aos-delay="200">
                        <div class="caption-content">
                            <p class="caption-text mb-4">{{ $s->caption }}</p>
                            <button class="btn btn-custom-primary">
                                Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about">
    <div class="about-wrapper" 
        style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('/uploads/about/'.$about->img_url) }}') center/cover no-repeat;">
        
        <div class="container-fluid px-md-5">
            <div class="row h-100 align-items-center justify-content-center justify-content-md-start">
                <div class="col-12 col-lg-8 col-xl-7" data-aos="fade-right">
                    <div class="about-content">
                        <h2 class="section-title mb-4">{{ $about->title }}</h2>
                        <div class="about-text">{!! $about->text_content !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Appointment Section -->
<section id="janjiTemu">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Janji Temu</h2>
            <p class="section-subtitle">Buat janji temu dengan dokter pilihan Anda</p>
        </div>

        <div class="table-responsive" data-aos="fade-up" data-aos-delay="100">
            <table class="table table-custom" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Spesialisasi</th>
                        <th>Ketersediaan</th>
                        <th>Jadwal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dokter as $index => $dr)
                    <tr>
                        <td class="align-middle">{{ $index+1 }}</td>
                        <td class="align-middle">
                            <div class="doctor-name">
                                <i class="fas fa-user-md text-primary me-2"></i>
                                {{ $dr->nama }}
                            </div>
                        </td>
                        <td class="align-middle">{{ $dr->spesialis->nama }}</td>
                        <td class="align-middle">
                            <span class="badge status-badge {{ $dr->ket_dok->status == 'Tersedia'? 'badge-available':'badge-unavailable' }}">
                                <i class="fas fa-circle me-1"></i>
                                {{ $dr->ket_dok->status }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <span class="schedule-time">
                                <i class="far fa-clock me-1"></i>
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $dr->ket_dok->jam_mulai)->format('H:i') }}
                                - 
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $dr->ket_dok->jam_selesai)->format('H:i') }}
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            <button 
                                class="btn btn-appointment"
                                data-bs-toggle="modal"
                                data-bs-target="#janjiModal"
                                data-dokter="{{ $dr->nama }}"
                                data-id="{{ $dr->id }}"
                                data-status="{{ $dr->ket_dok->status }}"
                                {{ $dr->ket_dok->status != 'Tersedia'? 'disabled': '' }}>
                                <i class="fas fa-calendar-plus me-1"></i> Buat Janji
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Appointment Modal -->
<div class="modal fade" id="janjiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-custom">
            <form method="POST" action="/janjitemu" class="janjiForm">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Form Pendaftaran Janji Temu</h5>
                        <p class="modal-subtitle mb-0">Lengkapi data di bawah ini</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="id_dokter" id="id_dokter">
                    
                    <div class="mb-4">
                        <label class="form-label-custom">Dokter Terpilih</label>
                        <div class="selected-doctor">
                            <i class="fas fa-user-md me-2"></i>
                            <span id="nama_dokter"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Nama Pasien <span class="text-danger">*</span></label>
                            <input name="nama_pasien" type="text" class="form-control form-control-custom" placeholder="Masukkan nama lengkap">
                            <small class="text-danger error-msg"></small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input name="tgl_lahir" type="date" class="form-control form-control-custom">
                            <small class="text-danger error-msg"></small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input name="no_hp" type="number" class="form-control form-control-custom" placeholder="08xxxxxxxxxx">
                            <small class="text-danger error-msg"></small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Asal Kota/Kabupaten <span class="text-danger">*</span></label>
                            <input name="alamat" type="text" class="form-control form-control-custom" placeholder="Contoh: Bukittinggi">
                            <small class="text-danger error-msg"></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Keluhan <span class="text-danger">*</span></label>
                        <textarea name="keluhan" class="form-control form-control-custom" rows="4" placeholder="Jelaskan keluhan Anda..."></textarea>
                        <small class="text-danger error-msg"></small>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-submit-custom">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Location Section -->
<section id="lokasi">
    <div class="container-fluid px-0">
        <div class="location-wrapper" data-aos="fade-up">
            <div class="container py-5">
                <div class="text-center mb-4">
                    <h2 class="section-title" data-aos="fade-down">Lokasi Klinik</h2>
                    <p class="section-subtitle">Temukan kami di lokasi berikut</p>
                </div>
            </div>
            
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7184.649971346796!2d100.2225178965402!3d-0.5747772746088352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd51f3bc33e69f1%3A0x52a6606addd26c33!2sPraktek%20dokter%20gigi%20Birna%20marwikka!5e0!3m2!1sen!2sid!4v1755963473973!5m2!1sen!2sid"
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Modal data injection
    document.addEventListener('DOMContentLoaded', function () {
        const janjiModal = document.getElementById('janjiModal');
        janjiModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const nama = button.getAttribute('data-dokter'); 
            const id = button.getAttribute('data-id');
            const status = button.getAttribute('data-status');

            if (status === 'Tidak Tersedia') {
                let inputs = janjiModal.getElementsByTagName('input');
                for (let input of inputs) {
                    input.style.display = 'none';
                }
                document.getElementById('nama_dokter').innerText = nama;
                document.getElementById('id_dokter').value = id;
            } else {
                let inputs = janjiModal.getElementsByTagName('input');
                for (let input of inputs) {
                    input.style.display = 'block';
                }
                document.getElementById('nama_dokter').innerText = nama;
                document.getElementById('id_dokter').value = id;
            }
        });
    });

    // Form submission handler
    document.querySelectorAll(".janjiForm").forEach(form => {
        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            let formData = new FormData(form);
            let submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true; 
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengirim...';

            try {
                let res = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                let data = await res.json();

                if (res.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745'
                    });
                    form.reset();
                    bootstrap.Modal.getInstance(form.closest('.modal')).hide();
                } else {
                    form.querySelectorAll(".error-msg").forEach(el => el.textContent = "");
                    form.querySelectorAll(".form-control").forEach(el => el.classList.remove("is-invalid"));
                    
                    for (let key in data.errors) {
                        let input = form.querySelector(`[name="${key}"]`);
                        if (input) {
                            input.classList.add("is-invalid");
                            input.nextElementSibling.textContent = data.errors[key][0];
                        }
                    }
                    
                    if(res.status == 400){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Heyy!',
                            text: data.gagal,
                            confirmButtonText: 'OK'
                        });
                    }
                    if(res.status == 405){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Maaf, Limit Janji Temu Untuk Hari ini Telah Habis',
                            text: data.gagal,
                            confirmButtonText: 'OK'
                        });
                    }
                }
            } catch (err) {
                console.error("Error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Mohon coba lagi nanti',
                    confirmButtonText: 'OK'
                });
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Kirim Pendaftaran';
            }
        });
    });
</script>
@endpush