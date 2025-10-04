@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 50rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Obat</h6>
    </div>
    <div class="card card-body">
        <form method="POST" action="{{ route('obat.store') }}">
            @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Obat</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
            @error('nama')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}">
            @error('harga')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button class="btn border-danger mx-3"><a class="text-decoration-none" href="{{ route('obat') }}">Batal</a></button>
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
