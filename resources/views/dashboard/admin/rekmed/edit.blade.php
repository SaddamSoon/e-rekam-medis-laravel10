@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 50rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Rekam Medis</h6>
    </div>
    <div class="card card-body">
        <form method="POST" action="{{ route('rekmed.update', $rekmed->id) }}">
            @csrf
            @method('PUT')

            {{-- Id pasien (tidak diedit, hanya dikirimkan kalau dibutuhkan di controller) --}}
            <input type="hidden" name="id_pasien" value="{{ $rekmed->id_pasien }}">

            {{-- Informasi Pasien (LOCKED / tidak bisa diedit di sini) --}}
            <div class="mb-3">
                <label class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" value="{{ $rekmed->pasien->nama ?? '-' }}" disabled>
                <small>
                    Ingin ubah data pasien?
                    <a href=
                    "/dashboard/pasien/{{ $rekmed->id_pasien }}"
                        >Edit di halaman pasien</a>
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal</label>
                <input type="text" class="form-control" value="{{ $rekmed->pasien->alamat ?? '-' }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control"
                       value="{{ $rekmed->pasien->tanggal_lahir ?? '' }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" class="form-control" value="{{ $rekmed->pasien->no_hp ?? '-' }}" disabled>
            </div>

            {{-- Kolom yang bisa diedit --}}
            <div class="mb-3">
                <label for="diagnosa" class="form-label">Diagnosa</label>
                <input type="text" class="form-control @error('diagnosa') is-invalid @enderror"
                       id="diagnosa" name="diagnosa" value="{{ old('diagnosa', $rekmed->diagnosa) }}">
                @error('diagnosa') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>

            <div class="mb-3">
                <label for="tindakan" class="form-label">Tindakan</label>
                <input type="text" class="form-control @error('tindakan') is-invalid @enderror"
                       id="tindakan" name="tindakan" value="{{ old('tindakan', $rekmed->tindakan) }}">
                @error('tindakan') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>

            {{-- Resep Obat --}}
            <div class="mb-3 resep">
                <label class="form-label">Resep Obat</label>
                @php
                    // Ambil dari old() dulu, fallback ke data DB, fallback 1 baris kosong
                    $jumlahOld   = old('jumlah', $rekmed->resep->pluck('jumlah')->toArray() ?? []);
                    $namaObatOld = old('nama_obat', $rekmed->resep->pluck('id_obat')->toArray() ?? []);
                    $ketDosisOld = old('ket_dosis', $rekmed->resep->pluck('ket_dosis')->toArray() ?? []);
                    $count = max(count($jumlahOld), count($namaObatOld), count($ketDosisOld), 1);
                @endphp

                @for ($i = 0; $i < $count; $i++)
                <div class="row mt-3">
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah"
                               value="{{ $jumlahOld[$i] ?? '' }}">
                        @error('jumlah.'.$i) <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="nama_obat[]">
                            <option value="">Pilih Obat</option>
                            @foreach ($obat as $ob)
                                <option value="{{ $ob->id }}"
                                    {{ ($namaObatOld[$i] ?? '') == $ob->id ? 'selected' : '' }}>
                                    {{ $ob->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_obat.'.$i) <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="ket_dosis[]" placeholder="Keterangan Dosis"
                               value="{{ $ketDosisOld[$i] ?? '' }}">
                        @error('ket_dosis.'.$i) <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endfor

                <span class="btn btn-success tambah-resep mx-2 mt-3" onclick="tambahInputResep()">+</span>
                <span class="btn btn-danger hapus-resep mt-3" onclick="hapusInputResep()">-</span><br>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
            <button class="btn border-danger mx-3">
              <a class="text-decoration-none" href="{{ route('rekmed') }}">Batal</a>
            </button>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    const tambah_resep = document.querySelector('.tambah-resep');
    const hapus_resep  = document.querySelector('.hapus-resep');

    function refreshMinusButton() {
        const rows = document.querySelector('.resep').querySelectorAll('.row');
        hapus_resep.style.display = (rows.length > 1) ? 'inline-block' : 'none';
    }

    function tambahInputResep(){
        const div = document.createElement("div");
        div.className = 'row mt-3';
        div.innerHTML = `
            <div class="col-md-2">
                <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah">
            </div>
            <div class="col-md-4">
                <select class="form-control" name="nama_obat[]">
                    <option value="">Pilih Obat</option>
                    @foreach ($obat as $ob)
                        <option value="{{ $ob->id }}">{{ $ob->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="ket_dosis[]" placeholder="Keterangan Dosis">
            </div>
        `;
        tambah_resep.before(div);
        refreshMinusButton();
    }

    function hapusInputResep(){
        const resep = document.querySelector('.resep');
        const rows = resep.querySelectorAll('.row');
        if(rows.length > 1){
            tambah_resep.previousElementSibling.remove();
        }
        refreshMinusButton();
    }

    // set state awal tombol minus
    refreshMinusButton();
</script>
@endpush
