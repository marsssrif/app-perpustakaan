@extends('layouts.app')

@section('title', 'Profil Pengguna - Perpustakaan Digital Kampus')

@section('content')
    <h1>Profil Pengguna</h1>

    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h2 style="margin-top: 0; font-size: 18px; color: #1e3a8a;">Informasi Akun</h2>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> <span class="badge-aktif">{{ ucfirst($user->role) }}</span></p>
    </div>

    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; max-width: 480px;">
        <h2 style="margin-top: 0; font-size: 18px; color: #1e3a8a;">Ganti Password</h2>

        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <label for="current_password">Password Lama</label>
            <input type="password" name="current_password" id="current_password" required>
            @error('current_password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Password Baru</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit" class="btn" style="margin-top: 16px;">Perbarui Password</button>
        </form>
    </div>
@endsection
