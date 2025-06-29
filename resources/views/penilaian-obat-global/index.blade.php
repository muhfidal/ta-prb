@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Penilaian Obat Global</h1>
            <a href="{{ route('penilaian-obat-global.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Penilaian
            </a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-blue-50">
                        <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Obat</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status Penilaian</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($medicines as $medicine)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap border-b text-sm text-gray-700 font-bold">{{ $medicine->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b text-sm">
                            @if(in_array($medicine->id, $penilaian))
                                <span class="text-green-600 font-semibold">Sudah Dinilai</span>
                            @else
                                <span class="text-red-600 font-semibold">Belum Dinilai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b">
                            @if(in_array($medicine->id, $penilaian))
                                <a href="{{ route('penilaian-obat-global.create', ['medicine_id' => $medicine->id]) }}" class="text-blue-600 font-semibold">Edit</a>
                            @else
                                <a href="{{ route('penilaian-obat-global.create', ['medicine_id' => $medicine->id]) }}" class="text-green-600 font-semibold">Tambah</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
