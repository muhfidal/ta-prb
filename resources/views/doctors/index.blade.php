@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Dokter</h1>
            <p class="text-gray-500 text-sm mt-1">Total dokter: <span class="font-semibold">{{ $doctors->total() }}</span></p>
        </div>
        <a href="{{ route('doctors.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl shadow-lg font-semibold text-base transition-all duration-200">
            <i class="fas fa-user-md text-lg"></i> Tambah Dokter
        </a>
    </div>
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 rounded-xl flex items-start gap-3">
        <i class="fas fa-info-circle text-green-500 text-2xl mt-1"></i>
        <div>
            <div class="font-semibold text-green-800 mb-1">Tentang Kelola Dokter</div>
            <ul class="list-disc pl-5 text-sm text-green-900 space-y-1">
                <li>Menu ini digunakan untuk <b>mengelola data dokter</b> di aplikasi.</li>
                <li>Anda dapat <b>menambah, mengedit, dan menghapus</b> data dokter sesuai kebutuhan.</li>
                <li>Pastikan nama dan spesialisasi dokter diisi dengan benar.</li>
            </ul>
        </div>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 flex items-center bg-green-50 border border-green-200 rounded-lg">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <span class="text-green-700">{{ session('success') }}</span>
        </div>
    @endif
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-green-700 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-green-700 uppercase tracking-wider">Spesialisasi</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-green-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($doctors as $doctor)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3 font-semibold text-gray-900">{{ $doctor->name }}</td>
                    <td class="px-6 py-3">{{ $doctor->specialization ?: '-' }}</td>
                    <td class="px-6 py-3 text-center">
                        <a href="{{ route('doctors.edit', $doctor) }}" class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg mr-1" title="Edit Dokter">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus dokter ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg" title="Hapus Dokter">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-user-md fa-2x mb-2"></i>
                        <div class="text-gray-500 font-medium">Belum ada data dokter</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $doctors->links() }}</div>
    </div>
</div>
@endsection
