@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto py-8">
    <div class="flex flex-col items-center mb-6">
        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-2 shadow">
            <i class="fas fa-user-circle text-blue-500 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-blue-800 mb-1">Profil Pengguna</h2>
        <div class="text-gray-500 text-sm">Informasi akun Anda</div>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-2xl shadow-lg p-6 space-y-5 border">
        <div class="flex items-center mb-4">
            <i class="fas fa-user text-blue-400 text-xl mr-3"></i>
            <div>
                <div class="text-xs text-gray-500">Nama</div>
                <div class="font-semibold text-gray-800">{{ $user->name }}</div>
            </div>
        </div>
        <div class="flex items-center mb-4">
            <i class="fas fa-envelope text-blue-400 text-xl mr-3"></i>
            <div>
                <div class="text-xs text-gray-500">Email</div>
                <div class="font-semibold text-gray-800">{{ $user->email }}</div>
            </div>
        </div>
        <div class="flex items-center mb-4">
            <i class="fas fa-user-shield text-blue-400 text-xl mr-3"></i>
            <div>
                <div class="text-xs text-gray-500">Role</div>
                <div class="font-semibold text-gray-800">{{ ucfirst($user->role) }}</div>
            </div>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4 mt-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Nama</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name', $user->name) }}" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold shadow mt-2"><i class="fas fa-save mr-2"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
