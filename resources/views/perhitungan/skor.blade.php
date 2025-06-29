@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Hitung Skor Obat</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{!! session('success') !!}</span>
            </div>
        @endif

        <!-- Form Pilih Penyakit -->
        <div class="mb-8">
            <form action="{{ route('perhitungan.hitungSkor') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="disease_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Penyakit</label>
                    <select name="disease_id" id="disease_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">-- Pilih Penyakit --</option>
                        @foreach($diseases as $disease)
                            <option value="{{ $disease->id }}" {{ request('disease_id') == $disease->id ? 'selected' : '' }}>
                                {{ $disease->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                        <i class="fas fa-calculator mr-2"></i>Hitung Skor
                    </button>
                </div>
            </form>
        </div>

        <!-- Hasil Perhitungan Skor -->
        @if(isset($skor))
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Hasil Perhitungan Skor</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead>
                            <tr class="bg-blue-50">
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Obat</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Skor</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                arsort($skor);
                                $rank = 1;
                            @endphp
                            @foreach($skor as $medicineId => $nilai)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm font-medium text-gray-900">
                                        {{ $medicines->find($medicineId)->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-gray-700">
                                        {{ number_format($nilai, 4) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-blue-700 font-bold">
                                        {{ $rank++ }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Matriks Perbandingan -->
        @if(isset($matriks) && $matriks->isNotEmpty())
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Matriks Perbandingan Obat</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead>
                            <tr class="bg-blue-50">
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kriteria</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Obat 1</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Obat 2</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nilai (L,M,U)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matriks as $m)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm font-medium text-gray-900">
                                        {{ $m->kriteria->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-gray-700">
                                        {{ $m->medicine1->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-gray-700">
                                        {{ $m->medicine2->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-gray-700">
                                        ({{ number_format($m->nilai_l, 2) }}, {{ number_format($m->nilai_m, 2) }}, {{ number_format($m->nilai_u, 2) }})
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
