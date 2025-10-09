@extends('dashboard.main')
@section('content')
    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Rekam Medis</h6>
                        </div>
                        <div class="card-body">
                            @can('isDokter')
                            <a href="{{ route('rekmed.create') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i> Rekam Medis</a>
                            @endcan
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Pasien</th>
                                            <th>Dokter</th>
                                            <th>Poly</th>
                                            <th>Tindakan</th>
                                            <th>Dibuat pada</th>
                                            @can('isDokter')
                                            <th>Aksi</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Pasien</th>
                                            <th>Dokter</th>
                                            <th>Poly</th>
                                            <th>Tindakan</th>
                                            <th>Dibuat pada</th>
                                            @can('isDokter')
                                            <th>Aksi</th>
                                            @endcan
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($rekmed as $rek)
                                            <tr>
                                                <td>{{ $rek->pasien->nama }}</td>
                                                <td class="{{ isset($rek->dokter->nama)? '' : 'text-danger font-weight-bold'}}">{{ isset($rek->dokter->nama)? $rek->dokter->nama : 'Dokter sudah dihapus'}}</td>
                                                <td>{{ $rek->poly->nama }}</td>
                                                <td>{{ $rek->tindakan }}</td>
                                                <td>{{ $rek->created_at->format('d-m-Y') }}</td>
                                                @can('isDokter')
                                                <td>
                                                    <span><a href="/dashboard/rekmed/{{ $rek->id }}" class="text-decoration-none text-warning"><i class="fa-solid fa-pen-to-square"></i></a></span>
                                                    <span>
                                                        <form class="d-inline" action="{{ route('rekmed.destroy', $rek->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn text-danger btn-delete" type="submit" class="text-decoration-none text-danger"><i class="fa-solid fa-trash"></i></button>
                                                        </form>
                                                    </span>
                                                </td>
                                                @endcan
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