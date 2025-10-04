@extends('layouts.auth')

@section('content')
<div class="container mt-5">
    <h3>Reset Password</h3>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Reset Password</button>
    </form>
</div>
@endsection
