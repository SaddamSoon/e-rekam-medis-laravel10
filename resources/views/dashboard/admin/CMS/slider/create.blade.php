@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 50rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Slider</h6>
    </div>
    <div class="card card-body">
        <form id="myForm" method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
            @csrf
            <label class="" for="img_url">Gambar</label>
            <div class="row">
                <div class="col-5 d-block">
                    <img id="img-preview" class="img-fluid" alt="...">
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
            <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption') }}">
            @error('caption')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <select name="link" class="custom-select @error('link') is-invalid @enderror" id="link" value="{{ old('link') }}">
                <option class="{{ !in_array('about', $link)?'': 'text-danger'}}" value="about" {{ !in_array('about', $link)?'': 'disabled'}}>about</option>
                <option class="{{ !in_array('janjiTemu', $link)?'': 'text-danger'}}" value="janjiTemu" {{ !in_array('janjiTemu', $link)?'': 'disabled'}}>janjiTemu</option>
                <option class="{{ !in_array('layanan-tarif', $link)?'': 'text-danger'}}" value="layanan-tarif" {{ !in_array('layanan-tarif', $link)?'': 'disabled'}}>layanan-tarif</option>
            </select>
            @error('link')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Urutan</label>
            <select name="order" class="custom-select @error('order') is-invalid @enderror" id="order" value="{{ old('order') }}">
                @if($order[0] == 0)
                    @for($i=1;$i<count($order);$i++)
                    <option value="{{ $order[$i] }}" selected>{{ $order[$i] }}</option>
                    @endfor
                @else
                    @for($i=0;$i<count($order);$i++)
                    <option value="{{ $order[$i] }}" selected>{{ $order[$i] }}</option>
                    @endfor
                @endif
            </select>
            @error('order')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" class="custom-select @error('is_active') is-invalid @enderror" id="is_active" value="{{ old('is_active') }}">
                    <option value=1>Aktif</option>
                    <option value=0>Non-Aktif</option>
            </select>
            @error('is_active')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
        <a class="btn border-danger text-decoration-none" href="{{ route('slider') }}">Batal</a>
    </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        let image = document.querySelector('#img_url');
        let imagePrev = document.querySelector('#img-preview');
        
        document.addEventListener('DOMContentLoaded', function () {
            imagePrev.src = '{{ asset("uploads/Image_not_available.png") }}';
            document.querySelectorAll('.custom-file-input').forEach(function (input) {
            input.addEventListener('change', function (e) {
                let reader = new FileReader();
                reader.readAsDataURL(image.files[0]);
                reader.onload = function(readerEvent){
                    imagePrev.src = readerEvent.target.result;
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
            document.getElementById('submitBtn').innerText = 'Menyimpan...'; 
        });
    </script>
@endpush
