@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 40rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Pasien</h6>
    </div>
    <div class="card card-body">
        <form method="POST" action="{{ route('pasien.store') }}">
            @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
            @error('nama')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}">
            @error('alamat')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3" style="width: 25rem;">
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
        <button type="submit" class="btn btn-primary">Submit</button>
        <button class="btn border-danger mx-3"><a class="text-decoration-none" href="{{ route('pasien') }}">Batal</a></button>
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
