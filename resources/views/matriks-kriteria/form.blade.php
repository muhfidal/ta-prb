@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">{{ isset($matriksKriteria) ? 'Edit' : 'Tambah' }} Perbandingan Kriteria</h2>

    <form action="{{ isset($matriksKriteria) ? route('matriks-kriteria.update', $matriksKriteria) : route('matriks-kriteria.store') }}" method="POST">
        @csrf
        @if(isset($matriksKriteria))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="kriteria1_id" class="block text-sm font-medium text-gray-700">Kriteria 1</label>
                <select name="kriteria1_id" id="kriteria1_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                    <option value="">Pilih Kriteria</option>
                    @foreach($kriteria as $item)
                        <option value="{{ $item->id }}" {{ old('kriteria1_id', $matriksKriteria->kriteria1_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kriteria }}
                        </option>
                    @endforeach
                </select>
                @error('kriteria1_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kriteria2_id" class="block text-sm font-medium text-gray-700">Kriteria 2</label>
                <select name="kriteria2_id" id="kriteria2_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                    <option value="">Pilih Kriteria</option>
                    @foreach($kriteria as $item)
                        <option value="{{ $item->id }}" {{ old('kriteria2_id', $matriksKriteria->kriteria2_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kriteria }}
                        </option>
                    @endforeach
                </select>
                @error('kriteria2_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label for="nilai_l" class="block text-sm font-medium text-gray-700">Nilai L</label>
                <input type="number" step="0.01" name="nilai_l" id="nilai_l"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="{{ old('nilai_l', $matriksKriteria->nilai_l ?? '') }}" required>
                @error('nilai_l')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nilai_m" class="block text-sm font-medium text-gray-700">Nilai M</label>
                <input type="number" step="0.01" name="nilai_m" id="nilai_m"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="{{ old('nilai_m', $matriksKriteria->nilai_m ?? '') }}" required>
                @error('nilai_m')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nilai_u" class="block text-sm font-medium text-gray-700">Nilai U</label>
                <input type="number" step="0.01" name="nilai_u" id="nilai_u"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="{{ old('nilai_u', $matriksKriteria->nilai_u ?? '') }}" required>
                @error('nilai_u')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('matriks-kriteria.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                <i class="fas fa-save mr-2"></i>{{ isset($matriksKriteria) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
