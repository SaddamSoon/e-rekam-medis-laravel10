@extends('dashboard.main')
@section('custom_csrf')
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Janji Temu</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Pasien</th>
                                            <th>No WA</th>
                                            <th>Alamat</th>
                                            <th>Keluhan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama Pasien</th>
                                            <th>No WA</th>
                                            <th>Alamat</th>
                                            <th>Keluhan</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($janji_temu as $jt)
                                            <tr>
                                                <td>{{ $jt->nama_pasien }}</td>
                                                <td>{{ $jt->no_hp }}</td>
                                                <td>{{ $jt->alamat }}</td>
                                                <td>{{ $jt->keluhan }}</td>
                                                <td><span class="col-status">{{ $jt->status }}</span></td>
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

        let approve = document.querySelectorAll('#approve'); 
        let clear = document.querySelectorAll('#clear'); 
        let batal = document.querySelectorAll('#batal'); 
        let table = $('#dataTable').DataTable(); //  inisialisasi data tables
        // tombol approve/konfirmasi
        approve.forEach(function(appr, index){
        appr.addEventListener('click', function(e){
            e.preventDefault();
            let row = appr.closest('tr'); 
            let col_status = row.querySelector('.col-status');
            let nama_pasien = appr.getAttribute('data-nama-pasien'); 
            let id_janji = appr.getAttribute('data-idj'); 

            Swal.fire({
                    title: `Konfrimasi janji temu ${nama_pasien} ?`,
                    text: "Janji tidak bisa disemulakan setelah dikonfirmasi",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Approve!"
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/dashboard/janjitemu_appr/${id_janji}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                            },
                            body: JSON.stringify({
                                status: 'dikonfirmasi',
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
                            appr.parentElement.innerHTML = data.button;
                            col_status.innerHTML = data.col_status;
                            let dtRow = table.row(row);
                            dtRow.data()[4] = data.col_status; // misal kolom ke-5 = status
                            dtRow.invalidate(); // kasih tahu datatables ada perubahan
                             window.open('https://wa.me/'+data.no_hp+'?text='+data.pesan, '_blank')
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                });
            
        });
        });
        
        // tombol batal
        batal.forEach(function(batal, index){
        batal.addEventListener('click', function(e){
            e.preventDefault();
            let row = batal.closest('tr'); 
            let col_status = row.querySelector('.col-status');
            let nama_pasien = batal.getAttribute('data-nama-pasien'); 
            let id_janji = batal.getAttribute('data-idj'); 

            Swal.fire({
                    title: `Konfrimasi janji temu ${nama_pasien} ?`,
                    text: "Janji tidak bisa disemulakan setelah dibatalkan",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Batal!"
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/dashboard/janjitemu_batal/${id_janji}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                            },
                            body: JSON.stringify({
                                status: 'batal',
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
                            batal.parentElement.innerHTML = '';
                            col_status.innerHTML = data.col_status;
                            let dtRow = table.row(row);
                            dtRow.data()[4] = data.col_status; // misal kolom ke-5 = status
                            dtRow.invalidate(); // kasih tahu datatables ada perubahan
                             window.open('https://wa.me/'+data.no_hp+'?text='+data.pesan, '_blank')
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                });
            
        });
        });
        // tombol selesai
        clear.forEach(function(clr, index){
        clr.addEventListener('click', function(e){
            e.preventDefault();
            let row = clr.closest('tr'); 
            let col_status = row.querySelector('.col-status');
            let nama_pasien = clr.getAttribute('data-nama-pasien'); 
            let id_janji = clr.getAttribute('data-idj'); 

            Swal.fire({
                    title: `Konfrimasi janji temu ${nama_pasien} ?`,
                    text: "Janji tidak bisa disemulakan setelah diselesaikan",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Selesai"
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/dashboard/janjitemu_selesai/${id_janji}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                            },
                            body: JSON.stringify({
                                status: 'selesai',
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
                            clr.parentElement.innerHTML = data.button;
                            clr.parentElement.nextElementSibling.textContent = '';
                            col_status.innerHTML = data.col_status;
                            let dtRow = table.row(row);
                            dtRow.data()[4] = data.col_status; // misal kolom ke-5 = status
                            dtRow.invalidate(); // kasih tahu datatables ada perubahan
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                });
            
        });
        });
    </script>
@endpush