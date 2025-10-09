@extends('dashboard.main')
@section('content')
    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Slider</h6>
                        </div>
                        <div class="card-body">
                            @if(count($slider) < 3)
                            <a href="{{ route('slider.create') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i> Slider</a>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Urutan</th>
                                            <th>Gambar Slider</th>
                                            <th>Caption</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Urutan</th>
                                            <th>Gambar Slider</th>
                                            <th>Caption</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($slider as $s)
                                            <tr>
                                                <td>{{ $s->order }}</td>
                                                <td><img src="{{ asset('/uploads/slider/'.$s->img_url) }}" alt="gambar slider {{ $s->caption }}" width="180px" height="100px"></td>
                                                <td>{{ $s->caption }}</td>
                                                <td>
                                                    <span><a href="/dashboard/slider/{{ $s->id }}" class="text-decoration-none text-warning"><i class="fa-solid fa-pen-to-square"></i></a></span>
                                                    @if(count($slider)!= 1)
                                                    <span>
                                                        <form class="d-inline" action="{{ route('slider.destroy', $s->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn text-danger btn-delete" type="submit" class="text-decoration-none text-danger"><i class="fa-solid fa-trash"></i></button>
                                                        </form>
                                                    </span>
                                                    @endif
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