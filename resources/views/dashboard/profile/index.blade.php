@extends('dashboard.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Card Profile --}}
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body text-center p-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=fff&size=120"
                        class="rounded-circle mb-3 shadow-sm" alt="User Avatar">
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $dokter }}</p>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge bg-gradient-info text-light fs-6">{{ $user->roles }}</span>
                </div>
            </div>

            {{-- Card Update Password --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Ubah Password</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('profile.updatePassword') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Password Lama</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                            @error('new_password') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df, #224abe);
    }
    .btn-gradient-primary {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #224abe, #1e3a8a);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
</style>
@endsection
