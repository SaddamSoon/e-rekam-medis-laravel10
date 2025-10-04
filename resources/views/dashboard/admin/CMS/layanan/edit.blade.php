@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 50rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Layanan</h6>
    </div>
    <div class="card card-body">
        <form id="myForm" method="POST" action="{{ route('layanan.update', $layanan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <label class="" for="img_url">Gambar</label>
            <div class="row">
                <div class="col-5 d-block">
                    <img id="img-preview" class="img-fluid" alt="..." src="{{ asset('uploads/layanan/'.$layanan->img_url) }}">
                </div>
                <div class="col-5">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                         <input type="file" class="custom-file-input" id="img_url" name="img_url">
                         <label class="custom-file-label" for="img_url">Pilih Gambar</label>
                        </div>
                    @error('img_url')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                    </div>
                </div>
             </div>
        <div class="mb-3">
            <label for="caption" class="form-label">Caption</label>
            <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption', $layanan->caption) }}">
            @error('caption')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="poly" class="form-label">Poly</label>
            <select name="poly" class="form-control" id="exampleFormControlSelect1">
                @foreach($poly as $p)
                    @if($p->id === $layanan->id_poly)
                    <option value="{{ $p->id }}" selected>{{ $p->nama }}</option>
                    @else
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                    @endif
                @endforeach
            </select>
            @error('poly')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control @error('caption') is-invalid @enderror" value="{{ old('price', $layanan->price) }}">
            @error('price')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" class="custom-select @error('is_active') is-invalid @enderror" id="is_active" value="{{ old('is_active', $layanan->is_active) }}">
                @if($layanan->is_active == 1)
                    <option value=1 selected>Aktif</option>
                    <option value=0>Non-Aktif</option>
                @else
                    <option value=1>Aktif</option>
                    <option value=0 selected>Non-Aktif</option>
                @endif
            </select>
            @error('is_active')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
        <a class="btn border-danger text-decoration-none" href="{{ route('layanan') }}">Batal</a>
    </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        let image = document.querySelector('#img_url');
        let imagePrev = document.querySelector('#img-preview');
        

        function prevImg(){

        }


        document.addEventListener('DOMContentLoaded', function () {
            // imagePrev.src = '{{ asset("uploads/Image_not_available.png") }}';
            document.querySelectorAll('.custom-file-input').forEach(function (input) {
            input.addEventListener('change', function (e) {
                let reader = new FileReader();
                reader.readAsDataURL(image.files[0]);
                reader.onload = function(readerEvent){
                    imagePrev.src = readerEvent.target.result;
                    imagePrev.style.display = 'block';
                };
                var fileName = e.target.files[0]?.name;
                if (fileName) {
                e.target.nextElementSibling.innerText = fileName;
                }
            });
            });
        });

        document.getElementById('myForm').addEventListener('submit', function() {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerText = 'Menyimpan...'; // opsional
        });
    </script>
@endpush
