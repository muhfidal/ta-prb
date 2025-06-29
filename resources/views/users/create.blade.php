@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-2 py-6">
    <div class="flex flex-col items-center mb-6">
        <img src="https://ui-avatars.com/api/?name=User+Baru&background=6366f1&color=fff&size=96" alt="avatar" class="w-20 h-20 rounded-full ring-4 ring-blue-200 shadow mb-2">
        <span class="px-3 py-1 rounded-full text-xs font-semibold mb-1 bg-gray-100 text-gray-800">User Baru</span>
        <div class="text-gray-500 text-xs">Isi data user baru dengan lengkap dan benar</div>
    </div>
    <form action="{{ route('users.store') }}" method="POST" class="bg-white rounded-2xl shadow-lg p-6 space-y-5 border relative">
        @csrf
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="relative">
            <label for="name" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-user text-blue-400"></i> Nama
            </label>
            <input type="text" id="name" name="name" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition placeholder-gray-400" required value="{{ old('name') }}" placeholder="Nama lengkap user">
            <span class="text-xs text-gray-400 mt-1">Masukkan nama lengkap user.</span>
        </div>
        <div class="relative">
            <label for="email" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-envelope text-blue-400"></i> Email
            </label>
            <input type="email" id="email" name="email" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition placeholder-gray-400" required value="{{ old('email') }}" placeholder="Email user">
            <span class="text-xs text-gray-400 mt-1">Gunakan email aktif user.</span>
        </div>
        <div class="relative">
            <label for="password" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-lock text-blue-400"></i> Password
            </label>
            <input type="password" id="password" name="password" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition placeholder-gray-400" required placeholder="Password user">
            <span class="text-xs text-gray-400 mt-1">Minimal 6 karakter.</span>
        </div>
        <div class="relative">
            <label for="password_confirmation" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-lock text-blue-200"></i> Konfirmasi Password
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition placeholder-gray-400" required placeholder="Ulangi password">
        </div>
        <div class="relative">
            <label for="role" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-user-tag text-blue-400"></i> Role
            </label>
            <select id="role" name="role" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>
        <div class="flex flex-col gap-2 md:flex-row md:justify-end sticky bottom-0 bg-white pt-4 z-10">
            <a href="{{ route('users.index') }}" class="w-full md:w-auto px-4 py-2 bg-gray-200 rounded-lg text-center font-medium hover:bg-gray-300 transition">Batal</a>
            <button type="submit" class="w-full md:w-auto px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
