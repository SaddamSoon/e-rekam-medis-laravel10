@extends('layouts.auth')

@section('content')
<style>
    body {
        background: #f4f6f9; /* abu muda */
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #343a40; /* abu gelap */
    }
    .login-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        width: 100%;
        max-width: 420px;
    }
    .login-card .card-body {
        padding: 2.2rem;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #dee2e6;
    }
    .form-control:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 .15rem rgba(30,58,138,.2);
    }
    .btn-login {
        background: #1e3a8a; /* navy elegan */
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: all .2s;
    }
    .btn-login:hover {
        background: #172554; /* lebih gelap */
    }
    .extra-links a {
        color: #1e3a8a;
        text-decoration: none;
        font-weight: 500;
    }
    .extra-links a:hover {
        text-decoration: underline;
    }
</style>

<div class="card login-card">
    <div class="card-body">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Selamat Datang</h4>
            <p class="text-muted">Silakan login untuk melanjutkan</p>
        </div>

        {{-- success message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- error message --}}
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        {{-- form login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    value="{{ old('email') }}" 
                    placeholder="contoh: email@mail.com"
                    required autofocus
                >
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control" 
                    placeholder="masukkan password"
                    required
                >
            </div>
            <button class="btn btn-login w-100 text-white">Login</button>
        </form>

        {{-- extra links --}}
        <div class="extra-links text-center mt-4">
            <a href="{{ route('password.request') }}">Lupa Password?</a>
        </div>
    </div>
</div>
@endsection
