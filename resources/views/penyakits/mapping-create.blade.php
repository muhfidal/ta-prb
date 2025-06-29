@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 max-w-5xl w-full mx-auto">
        <div class="flex items-center gap-2 mb-8">
            <i class="fas fa-link text-blue-500 text-2xl"></i>
            <h1 class="text-2xl font-bold text-blue-800">Tambah Mapping Obat ke Penyakit</h1>
        </div>
        <form method="POST" action="{{ route('penyakits.mapping.store') }}">
            @csrf
            <div class="mb-6">
                <label for="penyakit_id" class="block mb-2 font-semibold text-gray-700">Pilih Penyakit</label>
                <select name="penyakit_id" id="penyakit_id" class="form-select w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">-- Pilih Penyakit --</option>
                    @foreach($penyakits as $penyakit)
                        <option value="{{ $penyakit->id }}" {{ old('penyakit_id') == $penyakit->id ? 'selected' : '' }}>{{ $penyakit->nama_penyakit }}</option>
                    @endforeach
                </select>
                @error('penyakit_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Pilih Obat</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($medicines as $medicine)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="medicine_ids[]" value="{{ $medicine->id }}" {{ in_array($medicine->id, old('medicine_ids', [])) ? 'checked' : '' }}>
                        {{ $medicine->name }}
                    </label>
                    @endforeach
                </div>
                @error('medicine_ids')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('penyakits.mapping') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Mapping
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
