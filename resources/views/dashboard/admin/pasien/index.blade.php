@extends('dashboard.main')
@section('content')
    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i> Pasien</a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Input By</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Input By</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($pasien as $ps)
                                            <tr>
                                                <td>{{ $ps->nama }}</td>
                                                <td>{{ $ps->alamat }}</td>
                                                <td>{{ $ps->tanggal_lahir }}</td>
                                                <td>{{ $ps->user->name }}</td>
                                                <td>
                                                    <span><a href="/dashboard/pasien/{{ $ps->id }}" class="text-decoration-none text-warning"><i class="fa-solid fa-pen-to-square"></i></a></span>
                                                    <span>
                                                        <form class="d-inline" action="{{ route('pasien.destroy', $ps->id) }}" method="POST">
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
    </script>
@endpush