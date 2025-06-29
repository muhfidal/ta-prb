@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Penilaian Obat Global</h1>
        <form action="{{ route('penilaian-obat-global.update', $penilaianObatGlobal->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="medicine_id" class="block text-sm font-medium text-gray-700 mb-1">Obat</label>
                <select name="medicine_id" id="medicine_id" class="block w-full rounded-md border-gray-300" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}" {{ old('medicine_id', $penilaianObatGlobal->medicine_id) == $medicine->id ? 'selected' : '' }}>{{ $medicine->name }}</option>
                    @endforeach
                </select>
                @error('medicine_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kriteria_id" class="block text-sm font-medium text-gray-700 mb-1">Kriteria</label>
                <select name="kriteria_id" id="kriteria_id" class="block w-full rounded-md border-gray-300" required>
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach($kriterias as $kriteria)
                        <option value="{{ $kriteria->id }}" {{ old('kriteria_id', $penilaianObatGlobal->kriteria_id) == $kriteria->id ? 'selected' : '' }}>{{ $kriteria->nama_kriteria }}</option>
                    @endforeach
                </select>
                @error('kriteria_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="nilai_l" class="block text-sm font-medium text-gray-700">Nilai L</label>
                    <input type="number" step="0.01" name="nilai_l" id="nilai_l" class="mt-1 block w-full rounded-md border-gray-300" value="{{ old('nilai_l', $penilaianObatGlobal->nilai_l) }}" required min="1" max="10">
                    @error('nilai_l')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nilai_m" class="block text-sm font-medium text-gray-700">Nilai M</label>
                    <input type="number" step="0.01" name="nilai_m" id="nilai_m" class="mt-1 block w-full rounded-md border-gray-300" value="{{ old('nilai_m', $penilaianObatGlobal->nilai_m) }}" required min="1" max="10">
                    @error('nilai_m')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nilai_u" class="block text-sm font-medium text-gray-700">Nilai U</label>
                    <input type="number" step="0.01" name="nilai_u" id="nilai_u" class="mt-1 block w-full rounded-md border-gray-300" value="{{ old('nilai_u', $penilaianObatGlobal->nilai_u) }}" required min="1" max="10">
                    @error('nilai_u')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-8">
                <a href="{{ route('penilaian-obat-global.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg border border-gray-300 transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
