@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div x-data="{ openModal: {{ request('penyakit_id') ? 'true' : 'false' }}, selectedPenyakitId: {{ request('penyakit_id') ?? 'null' }} }" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 w-full mx-auto">
        <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2 mb-8">
            <i class="fas fa-link text-blue-500"></i>
            Mapping Obat ke Penyakit (Gejala Tambahan)
        </h1>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tabel Mapping Penyakit - Obat -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-table text-blue-500 text-xl"></i>
                    <h2 class="text-xl font-bold text-blue-800">Daftar Mapping Penyakit & Obat</h2>
                </div>
                <a href="{{ route('penyakits.mapping.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Mapping
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-xl">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase">Nama Penyakit</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase">Obat yang Sudah di-mapping</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penyakits as $i => $penyakit)
                        <tr class="hover:bg-blue-50 transition text-gray-800">
                            <td class="px-4 py-3 border-b align-top">{{ $i+1 }}</td>
                            <td class="px-4 py-3 border-b font-semibold align-top">{{ $penyakit->nama_penyakit }}</td>
                            <td class="px-4 py-3 border-b align-top">
                                @if($penyakit->medicines->count())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($penyakit->medicines as $medicine)
                                            <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-semibold rounded px-2 py-1">
                                                <i class="fas fa-capsules mr-1"></i>{{ $medicine->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Belum ada mapping</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border-b align-top">
                                <a href="{{ route('penyakits.mapping.edit', $penyakit->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded transition">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
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
