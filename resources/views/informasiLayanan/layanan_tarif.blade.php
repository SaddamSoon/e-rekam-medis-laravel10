@extends('informasiLayanan.layouts.main')
@section('content')
    <div class="container-fluid"  data-aos="fade-up">
            <h2 class="fw-bold mt-4 mb-4 text-center text-dark" id="janjiTemu">Tarif Layanan</h2>

         <!-- DataTales Example -->
                    <div class="card shadow mb-4 mt-4">
                        {{-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Layanan</h6>
                        </div> --}}
                        <div class="card-body">
                            <select  data-aos="fade-left" class="form-control mb-3" id="filter-kategori exampleFormControlSelect1" style="width: 30%">
                                <option>Kategori</option>
                                @foreach ($poly as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            <div class="table-responsive"  data-aos="fade-right">
                                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Keluhan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Keluhan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($layanan as $l)
                                        <tr>
                                            <td>{{ $l->caption }}</td>
                                            <td>{{ $l->poly->nama }}</td>
                                            <td>Rp. {{ number_format($l->price, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
        var table = $('#produkTable').DataTable({
            ajax: '/api/produk',
            columns: [
                { data: 'nama' },
                { data: 'kategori' },
                { data: 'harga' }
            ]
        });

        // Event saat select berubah
        $('#filter-kategori').on('change', function () {
            table.column(1)   // kolom kategori (index 1)
                .search(this.value)
                .draw();
        });
    });

    </script>
@endpush