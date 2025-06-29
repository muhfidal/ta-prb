@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Input Penilaian Obat Global per Obat</h1>
        @if(!$medicine_id)
        <form method="GET" action="{{ route('penilaian-obat-global.create') }}">
            <div class="max-w-xs mb-6">
                <label for="medicine_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Obat</label>
                <select name="medicine_id" id="medicine_id" class="block w-full rounded-md border-gray-300" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-arrow-right"></i> Lanjut
            </button>
        </form>
        @else
        <form action="{{ route('penilaian-obat-global.store-mass') }}" method="POST">
            @csrf
            <input type="hidden" name="medicine_id" value="{{ $medicine_id }}">
            <div class="mb-4">
                <span class="font-bold text-lg text-blue-800">Obat: {{ $selectedMedicine->name }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-blue-50">
                            <th class="px-4 py-2 border-b text-xs font-bold text-gray-600 uppercase">Kriteria</th>
                            <th class="px-4 py-2 border-b text-xs font-bold text-gray-600 uppercase text-center">Nilai L</th>
                            <th class="px-4 py-2 border-b text-xs font-bold text-gray-600 uppercase text-center">Nilai M</th>
                            <th class="px-4 py-2 border-b text-xs font-bold text-gray-600 uppercase text-center">Nilai U</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriterias as $kriteria)
                        @php $val = $existing[$kriteria->id] ?? null; @endphp
                        <tr>
                            <td class="px-4 py-2 border-b font-bold text-gray-800">{{ $kriteria->nama_kriteria }}</td>
                            <td class="px-2 py-2 border-b text-center">
                                <input type="number" step="0.01" name="nilai[{{ $kriteria->id }}][l]" value="{{ $val->nilai_l ?? '' }}" placeholder="L" class="w-16 rounded border-gray-300 text-center" min="1" max="10">
                            </td>
                            <td class="px-2 py-2 border-b text-center">
                                <input type="number" step="0.01" name="nilai[{{ $kriteria->id }}][m]" value="{{ $val->nilai_m ?? '' }}" placeholder="M" class="w-16 rounded border-gray-300 text-center" min="1" max="10">
                            </td>
                            <td class="px-2 py-2 border-b text-center">
                                <input type="number" step="0.01" name="nilai[{{ $kriteria->id }}][u]" value="{{ $val->nilai_u ?? '' }}" placeholder="U" class="w-16 rounded border-gray-300 text-center" min="1" max="10">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex justify-end gap-2 mt-8">
                <a href="{{ route('penilaian-obat-global.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg border border-gray-300 transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection
