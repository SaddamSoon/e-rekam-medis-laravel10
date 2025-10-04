@extends('layouts.auth')

@section('content')
<style>
    body {
        background: #f4f6f9;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #343a40;
    }
    .auth-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        width: 100%;
        max-width: 420px;
    }
    .auth-card .card-body {
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
    .btn-auth {
        background: #0d9488; /* hijau teal */
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: all .2s;
    }
    .btn-auth:hover {
        background: #0f766e;
    }
</style>

<div class="card auth-card">
    <div class="card-body">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Lupa Password</h4>
            <p class="text-muted">Masukkan email untuk menerima link reset password</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    placeholder="contoh: email@mail.com"
                    required autofocus>
            </div>
            <button class="btn btn-auth w-100 text-white">Kirim Link Reset</button>
        </form>
    </div>
</div>
@endsection
