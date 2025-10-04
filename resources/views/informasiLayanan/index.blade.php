@extends('informasiLayanan.layouts.main')
    @section('content')
    <section id="home">
        <div class="container-fluid p-0"> {{-- p-0 biar nggak ada jarak --}}
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    @foreach($slider as $s)
                        <div class="carousel-item {{ $s->order==1?'active':'' }}">
                            <img src="{{ asset('/uploads/slider/'.$s->img_url) }}" 
                                class="d-block w-100" alt="slide-1">

                            <div class="carousel-caption d-none d-md-block" data-aos="flip-up">
                                <h5><button class="btn btn-info shadow-lg">Selengkapnya</button></h5>
                                <p class="shadow-lg">{{ $s->caption }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Tombol prev/next -->
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

        <section id="about" style="height: 100vh"  data-aos="">
        <!-- Bagian About -->
        <div class="container-fluid text-white" 
            style="background: url('{{ asset('/uploads/about/'.$about->img_url) }}') center/cover no-repeat; height: 100vh;">
            
            <div class="row h-100 text-dark about"  data-aos="fade-right">
                <div class="col-md-7 d-flex flex-column justify-content-center p-5">
                    <h2 class="fw-bold">{{ $about->title }}</h2>
                    <div class="fs-5 shadow-lg">{!! $about->text_content !!}</div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bagian Janji Temu -->
    <section id="janjiTemu" style="height: 100vh"  data-aos="fade-up">
        <div class="container my-5" >
            <h2 class="fw-bold mb-4 text-center text-dark">Janji Temu</h2>

            <div class="table-responsive">
                <table   data-aos="fade-left" class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Nama Dokter</th>
                            <th>Spesialisasi</th>
                            <th>Ketersediaan</th>
                            <th>Jadwal</th>
                            <th>Buat Janji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokter as $index => $dr)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $dr->nama }}</td>
                            <td>{{ $dr->spesialis->nama }}</td>
                            <td><span class="badge {{ $dr->ket_dok->status == 'Tersedia'? 'bg-success':'bg-danger' }}">{{ $dr->ket_dok->status }}</span></td>
                            <td><b>{{ \Carbon\Carbon::createFromFormat('H:i:s', $dr->ket_dok->jam_mulai)->format('H:i') }}</b>
                                 - <b>{{ \Carbon\Carbon::createFromFormat('H:i:s', $dr->ket_dok->jam_selesai)->format('H:i') }}</b>
                    </td>
                            <td>
                                <button 
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#janjiModal"
                                    data-dokter="{{ $dr->nama }}"
                                    data-id="{{ $dr->id }}"
                                    data-status="{{ $dr->ket_dok->status }}"
                                    {{ $dr->ket_dok->status != 'Tersedia'? 'disabled': '' }}>
                                    <i class="fas fa-pen"></i> Buat Janji
                                </button>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        </section>
       <!-- Modal Global -->
        <div class="modal fade" id="janjiModal" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form method="POST" action="/janjitemu" class="janjiForm">
                @csrf
                <div class="modal-header">
                <h5 class="modal-title">Form Pendaftaran Janji Temu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_dokter" id="id_dokter">
                    <div class="mb-3">
                    <label class="form-label">Dokter :</label>
                    <p class="badge bg-secondary fs-5" id="nama_dokter"></p>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Nama Pasien</label>
                    <input name="nama_pasien" type="text" class="form-control">
                    <small class="text-danger error-msg"></small>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input name="tgl_lahir" type="date" class="form-control">
                    <small class="text-danger error-msg"></small>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Nomor WA</label>
                    <input name="no_hp" type="number" class="form-control">
                    <small class="text-danger error-msg"></small>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Asal Kota/Kab</label>
                    <input name="alamat" type="text" class="form-control">
                    <small class="text-danger error-msg"></small>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" class="form-control"></textarea>
                    <small class="text-danger error-msg"></small>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-submit">Kirim</button>
                </div>
            </form>
            </div>
        </div>
        </div>

        <!-- Peta Lokasi Klinik -->
        
        <section id="lokasi">
            <div class="container-fluid lokasi my-5" data-aos="fade-up">
                <h2 class="text-center fw-bold mb-4 text-dark" data-aos="fade-right">
                    Lokasi Klinik
                </h2>
                <div class="ratio ratio-16x9 shadow">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7184.649971346796!2d100.2225178965402!3d-0.5747772746088352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd51f3bc33e69f1%3A0x52a6606addd26c33!2sPraktek%20dokter%20gigi%20Birna%20marwikka!5e0!3m2!1sen!2sid!4v1755963473973!5m2!1sen!2sid"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>

        
    @endsection

       @push('scripts')
        <script>
            
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
            // JS untuk inject data ke modal
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
            document.querySelectorAll(".janjiForm").forEach(form => {
                form.addEventListener("submit", async function(e) {
                    e.preventDefault();

                    let formData = new FormData(form);
                    let submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.disabled = true; 
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
                                confirmButtonText: 'OK'
                            });
                            form.reset();
                            bootstrap.Modal.getInstance(form.closest('.modal')).hide();
                            submitBtn.disabled = false; 

                        } else {
                            // reset error dulu
                            form.querySelectorAll(".invalid-feedback").forEach(el => el.textContent = "");
                            form.querySelectorAll(".form-control").forEach(el => el.classList.remove("is-invalid"));
                            submitBtn.disabled = false; 
                            // tampilkan error dari server
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
                    }
                });
            });


        </script>
        @endpush
        
  