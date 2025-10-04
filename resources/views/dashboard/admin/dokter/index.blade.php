@extends('dashboard.main')
@section('custom_csrf')
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

@php
    function disabled($ketdok)
{
    $now = Carbon\Carbon::now('Asia/Jakarta');

    $jamMulai = Carbon\Carbon::createFromTimeString($ketdok->jam_mulai)->copy()->subHour(); 
    $jamSelesai = Carbon\Carbon::createFromTimeString($ketdok->jam_selesai)->copy()->subHours(2);

    $disabled1 = !$now->between(
        Carbon\Carbon::createFromTimeString('07:30:00'),
        Carbon\Carbon::createFromTimeString('17:00:00')
    );

    // $disabled2 = $now->between($jamMulai, $jamSelesai);

    // return $disabled1 || $disabled2;
    // return $disabled1;
    return;
}

@endphp
    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Dokter</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('dokter.create') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i> Dokter</a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Spesialisasi</th>
                                            <th>No STR</th>
                                            <th>Ketersediaan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Spesialisasi</th>
                                            <th>No STR</th>
                                            <th>Ketersediaan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($dokter as $dok)
                                            <tr>
                                                <td>{{ $dok->nama }}</td>
                                                <td>{{ $dok->user->email }}</td>
                                                <td>{{ $dok->spesialis->nama }}</td>
                                                <td>{{ $dok->no_str }}</td>
                                                <td id="ketdok" class="{{ $dok->ket_dok->status == 'Tersedia'? 'text-success':'text-danger' }}">
                                                <input type="hidden" id="id_ketdok" class="id_ketdok" name="id_ketdok" value="{{ $dok->ket_dok->id }}">
                                                    <select name="ketersediaan" class="{{ $dok->ket_dok->status == 'Tersedia'? 'text-success':'text-danger' }} select_input custom-select @error('ketersediaan') is-invalid @enderror"  value="{{ old('ketersediaan') }}" {{ disabled($dok->ket_dok)? 'disabled' : '' }}>
                                                        @if($dok->ket_dok->status === 'Tersedia')
                                                        <option class="text-success" value="Tersedia" selected>Tersedia</option>
                                                        <option class="text-danger" value="Tidak Tersedia">Tidak Tersedia</option>
                                                        @else
                                                        <option class="text-success" value="Tersedia">Tersedia</option>
                                                        <option class="text-danger" value="Tidak Tersedia" selected>Tidak Tersedia</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>
                                                    <span><a href="/dashboard/dokter/{{ $dok->id }}" class="text-decoration-none text-warning"><i class="fa-solid fa-pen-to-square"></i></a></span>
                                                    <span>
                                                        <form class="d-inline" action="{{ route('dokter.destroy', $dok->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn text-danger btn-delete" type="submit" class="text-decoration-none text-danger"><i class="fa-solid fa-trash"></i></button>
                                                        </form>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
@endsection

@push('script')
    <script>
        let delBtns = document.querySelectorAll('.btn-delete');

        delBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e){
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        // Submit form parent jika tombol berada dalam <form>
                        btn.closest('form').submit();
                    }
                });
            });
        });

        let id_ketdok = document.querySelectorAll('.id_ketdok');
        let inputSelect = document.querySelectorAll('.select_input'); 

        inputSelect.forEach(function(slc, index){
            slc.addEventListener('change', function(){
                
            fetch(`/dashboard/ketdok/${id_ketdok[index].value}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({
                    status: slc.value,
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
                if(slc.value == 'Tersedia'){
                    slc.classList.remove('text-danger');
                    slc.classList.add('text-success');
                }else if(slc.value == 'Tidak Tersedia'){
                    slc.classList.remove('text-success');
                    slc.classList.add('text-danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });});
    </script>
@endpush