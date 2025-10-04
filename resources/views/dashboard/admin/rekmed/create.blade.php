@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 50rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Rekam Medis</h6>
    </div>
    <div class="card card-body">
        <form method="POST" action="{{ route('rekmed.store') }}">
            @csrf
            <div class="mb-3 checkbox_pasien">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                    <input type="checkbox"  id="pasien_tersedia" {{ $pasienOld!=null?'checked':''  }} {{ old('nama_select')? 'checked':'' }}>
                    </div>
                    <div class="input-group mx-2">
                        <label for="pasien_tersedia">Pasien Lama?</label>
                    </div>
                </div>
            </div>
        <div class="mb-3">
            <label for="nama_text" class="form-label">Nama Pasien</label>
            <input type="text" class="text_pasien form-control @error('nama_text') is-invalid @enderror" id="nama_text" name="nama_text" value="{{ old('nama_text') }}">
            <select class="form-control select_pasien" name="nama_select" id="nama_select" name="nama_select">
                    <option readonly>Pilih Pasien</option>
                @foreach ($pasien as $ps)
                    <option value="{{ $ps->id }}" {{ old('nama_select') == $ps->id || $pasienOld !== null && $pasienOld->id == $ps->id? 'selected':'' }}>{{ $ps->nama }}</option>
                @endforeach
            </select>
            @error('nama_text')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
            @error('nama_select')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="asal" class="form-label">Asal</label>
            <input type="text" class="form-control @error('asal') is-invalid @enderror" id="asal" name="asal" value="{{ old('asal') }}">
            @error('asal')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
            @error('tanggal_lahir')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"value="{{ old('no_hp') }}">
            @error('no_hp')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="diagnosa" class="form-label">Diagnosa</label>
            <input type="text" class="form-control @error('diagnosa') is-invalid @enderror" id="diagnosa" name="diagnosa" value="{{ old('diagnosa') }}">
            @error('diagnosa')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="tindakan" class="form-label">Tindakan</label>
            <input type="text" class="form-control @error('tindakan') is-invalid @enderror" id="tindakan" name="tindakan" value="{{ old('tindakan') }}">
            @error('tindakan')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3 resep">
            <label for="resep" class="form-label">Resep Obat</label>

            @php
                $jumlahOld = old('jumlah', []);
                $namaObatOld = old('nama_obat', []);
                $ketDosisOld = old('ket_dosis', []);
                $count = max(count($jumlahOld), count($namaObatOld), count($ketDosisOld), 1);
            @endphp

            @for ($i = 0; $i < $count; $i++)
            <div class="row mt-3">
                <div class="col-md-2">
                    <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah"
                        value="{{ old('jumlah.'.$i) }}">
                    @error('jumlah.'.$i)
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="nama_obat[]">
                        <option value="" readonly>Pilih Obat</option>
                        @foreach ($obat as $ob)
                            <option value="{{ $ob->id }}" {{ old('nama_obat.'.$i) == $ob->id ? 'selected' : '' }}>
                                {{ $ob->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('nama_obat.'.$i)
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ket_dosis[]" placeholder="Keterangan Dosis"
                        value="{{ old('ket_dosis.'.$i) }}">
                    @error('ket_dosis.'.$i)
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            @endfor

            <span class="btn btn-success tambah-resep mx-2 mt-3" onclick="tambahInputResep()">+</span>
            <span class="btn btn-danger hapus-resep mt-3" onclick="hapusInputResep()">-</span><br>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button class="btn border-danger mx-3"><a class="text-decoration-none" href="{{ route('rekmed') }}">Batal</a></button>
    </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        let textPasien = document.querySelector('.text_pasien');
        let selectPasien = document.querySelector('.select_pasien');
        let checkbox_pasien = document.querySelector('#pasien_tersedia');
        let asal = document.querySelector('#asal');
        let tanggal_lahir = document.querySelector('#tanggal_lahir');
        let no_hp = document.querySelector('#no_hp');
        let tambah_resep = document.querySelector('.tambah-resep');
        let hapus_resep = document.querySelector('.hapus-resep');
        let angka_resep = 1;

        function toggleTextOrSelect(){
            selectPasien.style.display = 'none'; 
             selectPasien.disabled = true;
            if(checkbox_pasien.checked){
                selectPasien.style.display = 'block'; 
                textPasien.style.display = 'none'; 
                textPasien.disabled = true; 
                selectPasien.disabled = false; 
            }else{
                selectPasien.style.display = 'none';  
                textPasien.style.display = 'block'; 
                textPasien.disabled = false; 
                selectPasien.disabled = true; 
                asal.readOnly = false;
                tanggal_lahir.readOnly = false;
                no_hp.readOnly = false;
                asal.value = '';
                tanggal_lahir.value =  '';
                no_hp.value = '';
            }
        }
        function tambahInputResep(){
            const div = document.createElement("div");
            let angka_row = document.querySelector('.resep').querySelectorAll('.row').length;
            // console.log(angka_row);
            div.className = 'row mt-3';
            div.innerHTML = `
                        <div class="col-md-2">
                    <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah" value="{{ old('jumlah.${angka_row}') }}">
                    @error('jumlah.${angka_row}')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                     <select class="form-control " name="nama_obat[]" id="nama_select">
                    <option readonly>Pilih Obat</option>
                    @foreach ($obat as $ob)
                        <option value="{{ $ob->id }}" {{ old('nama_obat.${angka_row}') == $ob->id? 'selected': '' }}>{{ $ob->nama }}</option>
                    @endforeach
                    </select>
                    @error('nama_obat.${angka_row}')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ket_dosis[]" placeholder="Keterangan Dosis"  value="{{ old('ket_dosis.${angka_row}') }}">
                    @error('ket_dosis.${angka_row}')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            `;
            tambah_resep.before(div);
            let resep = document.querySelector('.resep');
            let rows = resep.querySelectorAll('.row');
            if(rows.length > 1){
                hapus_resep.style.display = 'inline-block';
           }
        }
        hapus_resep.style.display = 'none';
        function hapusInputResep(){
            let resep = document.querySelector('.resep');
            let rows = resep.querySelectorAll('.row');
            if(rows.length > 1){
                tambah_resep.previousElementSibling.remove();
                hapus_resep.style.display = 'inline-block';
            }
            let rowsAfter = resep.querySelectorAll('.row');
            if(rowsAfter.length == 1){
               hapus_resep.style.display = 'none';
           }
        }
        // tambah_resep[0].addEventListener('click', tambahInputResep)
        // tambah_resep[angka_resep].addEventListener('click', tambahInputResep)
         if(checkbox_pasien.checked){
            fetch(`/dashboard/rekmed/selectpasien?id_pasien=${selectPasien.value}`)
            .then(response => response.json())
            .then(data => {
                asal.value = data.asal;
                tanggal_lahir.value = data.tanggal_lahir;
                no_hp.value = data.no_hp;
                asal.readOnly = true;
                tanggal_lahir.readOnly = true;
                no_hp.readOnly = true;
            });
         }
        checkbox_pasien.addEventListener('change', toggleTextOrSelect);
        toggleTextOrSelect();
        selectPasien.addEventListener('change', function(){
            fetch(`/dashboard/rekmed/selectpasien?id_pasien=${selectPasien.value}`)
            .then(response => response.json())
            .then(data => {
                asal.value = data.asal;
                tanggal_lahir.value = data.tanggal_lahir;
                no_hp.value = data.no_hp;
                asal.readOnly = true;
                tanggal_lahir.readOnly = true;
                no_hp.readOnly = true;
            });
        });
        
    </script>
@endpush
