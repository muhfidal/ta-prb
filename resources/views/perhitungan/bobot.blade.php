@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Perhitungan Bobot Kriteria</h1>
            <form action="{{ route('perhitungan.hitungBobot') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                    <i class="fas fa-calculator mr-2"></i>Hitung Bobot
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tabel Matriks Perbandingan -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Matriks Perbandingan Kriteria</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria</th>
                            @foreach($kriteria as $k)
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $k->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $k1)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b text-sm font-medium text-gray-900">{{ $k1->nama_kriteria }}</td>
                                @foreach($kriteria as $k2)
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-gray-500">
                                        @php
                                            $nilai = $matriks->where('kriteria1_id', $k1->id)->where('kriteria2_id', $k2->id)->first();
                                        @endphp
                                        @if($k1->id == $k2->id)
                                            (1.00, 1.00, 1.00)
                                        @elseif($nilai)
                                            ({{ number_format($nilai->nilai_l, 2) }}, {{ number_format($nilai->nilai_m, 2) }}, {{ number_format($nilai->nilai_u, 2) }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Hasil Perhitungan Bobot -->
        @if(isset($bobot))
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Hasil Perhitungan Bobot</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriteria as $k)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm font-medium text-gray-900">{{ $k->nama_kriteria }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-gray-500">{{ number_format($bobot[$k->id] ?? 0, 4) }}</td>
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
