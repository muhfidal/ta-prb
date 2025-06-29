@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-2">
            <h2 class="text-3xl font-bold text-blue-800 flex items-center gap-2">
                <i class="fas fa-balance-scale text-blue-500"></i>
                Matriks Perbandingan Kriteria
            </h2>
            <a href="{{ route('matriks-kriteria.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg flex items-center gap-2 shadow transition">
                <i class="fas fa-plus"></i>
                <span>Tambah Perbandingan</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg text-base">
                <thead class="bg-blue-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Kriteria 1</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Kriteria 2</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Nilai L</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Nilai M</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Nilai U</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($matriks as $item)
                    <tr class="hover:bg-blue-50 transition text-gray-800">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->kriteria1->nama_kriteria }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->kriteria2->nama_kriteria }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->nilai_l, 4) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->nilai_m, 4) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->nilai_u, 4) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-3">
                                <a href="/matriks-kriteria/{{ $item->id }}/edit" class="text-blue-600 hover:text-blue-800 text-xl transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('matriks-kriteria.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xl transition" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus perbandingan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
