@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2 mb-8">
            <i class="fas fa-plus-circle text-blue-500"></i>
            Tambah Penyakit (Gejala Tambahan)
        </h1>
        <form action="{{ route('penyakits.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="mb-5">
                <label for="nama_penyakit" class="block mb-2 font-semibold text-gray-700">Nama Penyakit</label>
                <input type="text" name="nama_penyakit" id="nama_penyakit" value="{{ old('nama_penyakit') }}" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                @error('nama_penyakit')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('penyakits.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
