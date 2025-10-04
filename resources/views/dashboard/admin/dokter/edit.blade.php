@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 50rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Dokter</h6>
    </div>
    <div class="card card-body">
        <form method="POST" action="{{ route('dokter.update', $dokter->id) }}">
            @csrf
            @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Dokter</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $dokter->nama) }}">
            @error('nama')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $dokter->user->email) }}">
            @error('email')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        @php    
            $jam_mulai = $dokter->ket_dok->jam_mulai?? '';
            $jam_selesai = $dokter->ket_dok->jam_selesai?? '';
        @endphp
        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai</label>
            <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $jam_mulai) }}">
            @error('jam_mulai')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jam_selesai" class="form-label">Jam Selesai</label>
            <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $jam_selesai) }}">
            @error('jam_selesai')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="spesialis" class="form-label">Spesialisasi</label>
            <select name="id_spesialis" class="custom-select @error('id_spesialis') is-invalid @enderror" id="inputGroupSelect04" value="{{ old('id_spesialis', $dokter->id_spesialis) }}">
                <option>Pilih</option>
                @foreach ($spesialis as $sp)
                    @if($sp->id === $dokter->id_spesialis)
                    <option value="{{ $sp->id }}" selected>{{ $sp->nama }}</option>
                    @else
                    <option value="{{ $sp->id }}">{{ $sp->nama }}</option>
                    @endif
                @endforeach
            </select>
            @error('id_spesialis')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="str" class="form-label">No STR</label>
            <input type="number" class="form-control @error('no_str') is-invalid @enderror" id="str" name="no_str" value="{{ old('no_str', $dokter->no_str) }}">
            @error('no_str')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"value="{{ old('no_hp', $dokter->user->no_hp) }}">
            @error('no_hp')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
        <p>Ubah password? <a href="" class="text-decoration-none">klik disini!</a></p>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button class="btn border-danger mx-3"><a class="text-decoration-none" href="{{ route('dokter') }}">Batal</a></button>
    </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        let idPass = document.querySelector('#password');
        let idVisibility = document.querySelector('#visibility');
        let idEye = document.querySelector('#iconEye');
    

        idVisibility.addEventListener('click', function(){
            idEye.classList.toggle('fa-eye-slash');
            if(idPass.type == 'password'){
                idPass.type = 'text';
            }else{
                idPass.type = 'password';
            }
        });
    </script>
@endpush
