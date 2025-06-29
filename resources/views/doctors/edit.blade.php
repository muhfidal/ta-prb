@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-2 py-6">
    <div class="flex flex-col items-center mb-6">
        <i class="fas fa-user-md text-yellow-500 text-4xl mb-2"></i>
        <span class="px-3 py-1 rounded-full text-xs font-semibold mb-1 bg-yellow-100 text-yellow-800">Edit Dokter</span>
        <div class="text-gray-500 text-xs">Perbarui data dokter dengan lengkap dan benar</div>
    </div>
    <form action="{{ route('doctors.update', $doctor) }}" method="POST" class="bg-white rounded-2xl shadow-lg p-6 space-y-5 border relative">
        @csrf
        @method('PUT')
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
            <label for="user_id" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-user-circle text-yellow-400"></i> Pilih Akun Dokter
            </label>
            <select id="user_id" name="user_id" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-200 focus:border-yellow-500 transition" required>
                <option value="">-- Pilih Akun --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $doctor->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id')
                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="relative">
            <label for="name" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-user text-yellow-400"></i> Nama
            </label>
            <input type="text" id="name" name="name" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-200 focus:border-yellow-500 transition placeholder-gray-400" required value="{{ old('name', $doctor->name) }}" placeholder="Nama lengkap dokter">
            <span class="text-xs text-gray-400 mt-1">Masukkan nama lengkap dokter.</span>
        </div>
        <div class="relative">
            <label for="specialization" class="block font-semibold text-gray-700 mb-1 flex items-center gap-2">
                <i class="fas fa-stethoscope text-yellow-400"></i> Spesialisasi
            </label>
            <input type="text" id="specialization" name="specialization" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-200 focus:border-yellow-500 transition placeholder-gray-400" value="{{ old('specialization', $doctor->specialization) }}" placeholder="Contoh: Umum, Anak, dll">
            <span class="text-xs text-gray-400 mt-1">Boleh dikosongkan jika dokter umum.</span>
        </div>
        <div class="flex flex-col gap-2 md:flex-row md:justify-end sticky bottom-0 bg-white pt-4 z-10">
            <a href="{{ route('doctors.index') }}" class="w-full md:w-auto px-4 py-2 bg-gray-200 rounded-lg text-center font-medium hover:bg-gray-300 transition">Batal</a>
            <button type="submit" class="w-full md:w-auto px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold shadow hover:bg-yellow-600 transition border border-yellow-600">Update</button>
        </div>
    </form>
</div>
@endsection
