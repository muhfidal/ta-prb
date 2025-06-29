@extends('layouts.app')

@section('title', 'Laporan - Sistem PRB')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-2 md:px-0">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Laporan & Statistik Sistem PRB</h1>
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <!-- Pasien -->
        <div class="relative bg-white rounded-2xl shadow p-6 flex flex-col items-start min-h-[140px]">
            <span class="absolute top-4 right-4 text-blue-500"><i class="fas fa-arrow-right"></i></span>
            <div class="flex items-center mb-4">
                <span class="bg-blue-100 text-blue-600 rounded-xl p-3 mr-3 flex items-center justify-center">
                    <i class="fas fa-users text-2xl"></i>
                </span>
                <span class="sr-only">Pasien</span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $totalPatients }}</div>
            <div class="text-sm text-gray-500 mt-1">Total Pasien</div>
        </div>
        <!-- Resep -->
        <div class="relative bg-white rounded-2xl shadow p-6 flex flex-col items-start min-h-[140px]">
            <span class="absolute top-4 right-4 text-green-500"><i class="fas fa-arrow-right"></i></span>
            <div class="flex items-center mb-4">
                <span class="bg-green-100 text-green-600 rounded-xl p-3 mr-3 flex items-center justify-center">
                    <i class="fas fa-prescription text-2xl"></i>
                </span>
                <span class="sr-only">Resep</span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $totalPrescriptions }}</div>
            <div class="text-sm text-gray-500 mt-1">Total Resep</div>
        </div>
        <!-- Obat -->
        <div class="relative bg-white rounded-2xl shadow p-6 flex flex-col items-start min-h-[140px]">
            <span class="absolute top-4 right-4 text-yellow-500"><i class="fas fa-arrow-right"></i></span>
            <div class="flex items-center mb-4">
                <span class="bg-yellow-100 text-yellow-600 rounded-xl p-3 mr-3 flex items-center justify-center">
                    <i class="fas fa-capsules text-2xl"></i>
                </span>
                <span class="sr-only">Obat</span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $totalMedicines }}</div>
            <div class="text-sm text-gray-500 mt-1">Data Obat</div>
        </div>
        <!-- Gejala -->
        <div class="relative bg-white rounded-2xl shadow p-6 flex flex-col items-start min-h-[140px]">
            <span class="absolute top-4 right-4 text-red-500"><i class="fas fa-arrow-right"></i></span>
            <div class="flex items-center mb-4">
                <span class="bg-red-100 text-red-600 rounded-xl p-3 mr-3 flex items-center justify-center">
                    <i class="fas fa-stethoscope text-2xl"></i>
                </span>
                <span class="sr-only">Gejala</span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $totalSymptoms ?? 0 }}</div>
            <div class="text-sm text-gray-500 mt-1">Total Gejala</div>
        </div>
    </div>

    <!-- Detail Data Terbaru -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Pasien Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-blue-700 flex items-center"><i class="fas fa-users mr-2"></i>Pasien Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50">
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">No. BPJS</th>
                            <th class="px-4 py-2 text-left">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPatients as $p)
                        <tr class="hover:bg-blue-50">
                            <td class="px-4 py-2 font-semibold flex items-center gap-2">
                                <span class="inline-block w-7 h-7 rounded-full bg-blue-200 text-blue-800 flex items-center justify-center font-bold">{{ strtoupper(substr($p->name,0,1)) }}</span>
                                {{ $p->name }}
                            </td>
                            <td class="px-4 py-2">{{ $p->no_bpjs }}</td>
                            <td class="px-4 py-2">{{ $p->address }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Resep Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-green-700 flex items-center"><i class="fas fa-prescription mr-2"></i>Resep Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-green-50">
                            <th class="px-4 py-2 text-left">No. Resep</th>
                            <th class="px-4 py-2 text-left">Pasien</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPrescriptions as $r)
                        <tr class="hover:bg-green-50">
                            <td class="px-4 py-2 font-semibold">{{ $r->prescription_number }}</td>
                            <td class="px-4 py-2">{{ $r->patient->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($r->prescription_date)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Obat Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-yellow-700 flex items-center"><i class="fas fa-capsules mr-2"></i>Obat Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-yellow-50">
                            <th class="px-4 py-2 text-left">Nama Obat</th>
                            <th class="px-4 py-2 text-left">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentMedicines as $m)
                        <tr class="hover:bg-yellow-50">
                            <td class="px-4 py-2 font-semibold">{{ $m->name }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">{{ $m->unit }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Penyakit Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-pink-700 flex items-center"><i class="fas fa-virus mr-2"></i>Penyakit Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-pink-50">
                            <th class="px-4 py-2 text-left">Nama Penyakit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentDiseases as $d)
                        <tr class="hover:bg-pink-50">
                            <td class="px-4 py-2 font-semibold">{{ $d->name ?? $d->nama_penyakit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Dokter Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-purple-700 flex items-center"><i class="fas fa-user-md mr-2"></i>Dokter Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-purple-50">
                            <th class="px-4 py-2 text-left">Nama Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentDoctors as $doc)
                        <tr class="hover:bg-purple-50">
                            <td class="px-4 py-2 font-semibold flex items-center gap-2">
                                <span class="inline-block w-7 h-7 rounded-full bg-purple-200 text-purple-800 flex items-center justify-center font-bold">{{ strtoupper(substr($doc->user->name ?? '-',0,1)) }}</span>
                                {{ $doc->user->name ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
