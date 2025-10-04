@extends('dashboard.main')
@section('custom_csrf')
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- DataTales Example -->
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

            $disabled2 = $now->between($jamMulai, $jamSelesai);

            return $disabled1 || $disabled2;
        }

        // dd($disabled2);
        
    @endphp
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ketersediaan Dokter</h6>
                        </div>
                        <div class="card-body">
                                <input type="hidden" id="id_ketdok" name="id_ketdok" value="{{ $ketdok->id }}">
                                <div class="mb-3">
                                    <select name="ketersediaan" class="custom-select @error('ketersediaan') is-invalid @enderror" id="select_input" value="{{ old('ketersediaan') }}" {{ disabled($ketdok)? 'disabled' : '' }}>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                                    </select>
                                    @error('ketersediaan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>       
                        </div>
                    </div>
@endsection

@push('script')
    <script>
        
        let id_ketdok = document.querySelector('#id_ketdok');
        let inputSelect = document.querySelector('#select_input'); 

        inputSelect.addEventListener('change', function(){
            fetch(`/dashboard/ketdok/${id_ketdok.value}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({
                    status: inputSelect.value,
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
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
@endpush