@extends('dashboard.main')
@section('content')
    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data About</h6>
                        </div>
                        <div class="card-body">
                            @if ($about->count() < 1)
                                <a href="{{ route('about.create') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i> about</a>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Gambar about</th>
                                            <th>Judul</th>
                                            <th>Text</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($about as $h)
                                            <tr>
                                                <td><img src="{{ asset('/uploads/about/'.$h->img_url) }}" alt="gambar about {{ $h->title }}" width="180px" height="100px"></td>
                                                <td><b>{{ $h->title }}</b></td>
                                                <td><b>{!! $h->text_content !!}</b></td>
                                                <td>
                                                    @if($h->is_active == 1)
                                                        <p class="text-success"><b>Aktif</b></p>
                                                    @else
                                                        <p class="text-secondary disabled">Non Aktif</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span><a href="/dashboard/about/{{ $h->id }}" class="text-decoration-none text-warning"><i class="fa-solid fa-pen-to-square"></i></a></span>
                                                    <span>
                                                        <form class="d-inline" action="{{ route('about.destroy', $h->id) }}" method="POST">
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