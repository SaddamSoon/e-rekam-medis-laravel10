@extends('dashboard.main')
@section('content')
<div class="card shadow mb-4" style="width: 50rem;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Dokter</h6>
    </div>
    <div class="card card-body">
        <form id="myForm" method="POST" action="{{ route('slider.update', $slider->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <label class="form-label" for="img_url">Gambar Slider</label>
        <div class="input-group mb-3">
            <div class="row">
                 <div class="col-5 d-block">
                    <img id="img-preview" src="{{ asset('uploads/slider/'.$slider->img_url) }}" class="img-fluid">
                </div>
                <div class="col-6">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="img_url" name="img_url">
                        <label class="custom-file-label" for="img_url">Choose file</label>
                    </div>
                    @error('img_url')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="caption" class="form-label">Caption</label>
            <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption', $slider->caption) }}">
            @error('caption')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Urutan</label>
            <select name="order" class="custom-select @error('order') is-invalid @enderror" id="order" value="{{ old('order', $slider->order) }}">
                    @for($i=0;$i<count($order);$i++)
                        @if($order[$i] === $slider->order)
                        <option value="{{ $order[$i] }}" selected>{{ $order[$i] }}</option>
                        @else
                        <option value="{{ $order[$i] }}">{{ $order[$i] }}</option>
                        @endif
                    @endfor
                
            </select>
            @error('order')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" class="custom-select @error('is_active') is-invalid @enderror" id="is_active" value="{{ old('is_active', $slider->is_active) }}">
                    <option value=1>Aktif</option>
                    <option value=0>Non-Aktif</option>
            </select>
            @error('is_active')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
        <button class="btn border-danger mx-3"><a class="text-decoration-none" href="{{ route('slider') }}">Batal</a></button>
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
