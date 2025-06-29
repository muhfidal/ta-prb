@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        <h1 class="text-3xl font-bold text-blue-800 mb-8 flex items-center gap-2">
            <i class="fas fa-balance-scale text-blue-500"></i>
            Edit Kriteria
        </h1>
        <form action="{{ route('kriteria.update', ['kriteria' => $kriteria->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="nama_kriteria" class="block text-base font-semibold text-gray-700 mb-1">Nama Kriteria</label>
                <input type="text" name="nama_kriteria" id="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base px-4 py-2 @error('nama_kriteria') border-red-500 @enderror" placeholder="Masukkan nama kriteria">
                @error('nama_kriteria')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="deskripsi" class="block text-base font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base px-4 py-2 @error('deskripsi') border-red-500 @enderror" placeholder="Deskripsi kriteria...">{{ old('deskripsi', $kriteria->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nilai_minimum" class="block text-base font-semibold text-gray-700 mb-1">Nilai Minimum</label>
                    <input type="number" step="0.01" name="nilai_minimum" id="nilai_minimum" value="{{ old('nilai_minimum', $kriteria->nilai_minimum) }}" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base px-4 py-2 @error('nilai_minimum') border-red-500 @enderror" placeholder="1">
                    @error('nilai_minimum')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nilai_maksimum" class="block text-base font-semibold text-gray-700 mb-1">Nilai Maksimum</label>
                    <input type="number" step="0.01" name="nilai_maksimum" id="nilai_maksimum" value="{{ old('nilai_maksimum', $kriteria->nilai_maksimum) }}" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base px-4 py-2 @error('nilai_maksimum') border-red-500 @enderror" placeholder="10">
                    @error('nilai_maksimum')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fuzzy_set" class="block text-base font-semibold text-gray-700 mb-1">Fuzzy Set</label>
                    <input type="text" name="fuzzy_set" id="fuzzy_set" value="{{ old('fuzzy_set', $kriteria->fuzzy_set) }}" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base px-4 py-2 @error('fuzzy_set') border-red-500 @enderror" placeholder="Contoh: 1,5,10">
                    @error('fuzzy_set')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tipe_kriteria" class="block text-base font-semibold text-gray-700 mb-1">Tipe Kriteria</label>
                    <select name="tipe_kriteria" id="tipe_kriteria" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base px-4 py-2 @error('tipe_kriteria') border-red-500 @enderror">
                        <option value="Benefit" {{ old('tipe_kriteria', $kriteria->tipe_kriteria) == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="Cost" {{ old('tipe_kriteria', $kriteria->tipe_kriteria) == 'Cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                    @error('tipe_kriteria')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-8">
                <a href="{{ route('kriteria.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg border border-gray-300 transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
