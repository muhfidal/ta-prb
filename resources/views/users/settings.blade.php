@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto py-8">
    <div class="flex flex-col items-center mb-6">
        <div class="w-20 h-20 rounded-full bg-yellow-100 flex items-center justify-center mb-2 shadow">
            <i class="fas fa-cog text-yellow-500 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-yellow-700 mb-1">Pengaturan Akun</h2>
        <div class="text-gray-500 text-sm">Ubah password dan pengaturan akun Anda</div>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-2xl shadow-lg p-6 space-y-5 border">
        <div class="flex items-center mb-4">
            <i class="fas fa-user text-yellow-400 text-xl mr-3"></i>
            <div>
                <div class="text-xs text-gray-500">Nama</div>
                <div class="font-semibold text-gray-800">{{ $user->name }}</div>
            </div>
        </div>
        <div class="flex items-center mb-4">
            <i class="fas fa-envelope text-yellow-400 text-xl mr-3"></i>
            <div>
                <div class="text-xs text-gray-500">Email</div>
                <div class="font-semibold text-gray-800">{{ $user->email }}</div>
            </div>
        </div>
        <form action="{{ route('settings.password') }}" method="POST" class="space-y-4 mt-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Password Baru</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded font-semibold shadow mt-2"><i class="fas fa-key mr-2"></i> Ubah Password</button>
        </form>
    </div>
</div>
@endsection
