@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Matriks Perbandingan Kriteria</h1>
        <form action="{{ route('matriks-kriteria.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="kriteria1_id" class="block text-sm font-medium text-gray-700 mb-1">Kriteria 1</label>
                <select name="kriteria1_id" id="kriteria1_id" class="block w-full rounded-md border-gray-300">
                    <option value="">-- Pilih Kriteria 1 --</option>
                    @foreach($kriteria as $k1)
                        @foreach($kriteria as $k2)
                            @if($k1->id != $k2->id)
                                @php
                                    $exists = \App\Models\MatriksKriteria::where('kriteria1_id', $k1->id)->where('kriteria2_id', $k2->id)->exists();
                                @endphp
                                @if(!$exists)
                                    <option value="{{ $k1->id }}-{{ $k2->id }}">{{ $k1->nama_kriteria }} vs {{ $k2->nama_kriteria }}</option>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div>
                <label for="nilai_l" class="block text-sm font-medium text-gray-700 mb-1">Nilai L</label>
                <input type="number" step="0.01" name="nilai_l" id="nilai_l" class="block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label for="nilai_m" class="block text-sm font-medium text-gray-700 mb-1">Nilai M</label>
                <input type="number" step="0.01" name="nilai_m" id="nilai_m" class="block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label for="nilai_u" class="block text-sm font-medium text-gray-700 mb-1">Nilai U</label>
                <input type="number" step="0.01" name="nilai_u" id="nilai_u" class="block w-full rounded-md border-gray-300" required>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('matriks-kriteria.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
