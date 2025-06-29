@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold text-gray-800">Daftar Resep</h2>
                <p class="text-sm text-gray-600">Kelola resep pasien Program Rujuk Balik</p>
            </div>
            <a href="{{ route('prescriptions.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 group">
                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-200"></i>
                Buat Resep Baru
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <!-- Filter & Search Section -->
        <form action="{{ route('prescriptions.index') }}" method="GET" class="p-6 border-b border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div class="relative">
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari berdasarkan nomor resep atau nama pasien..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <i class="fas fa-search absolute left-3.5 top-3 text-gray-400"></i>
                </div>

                <!-- Filter by Month -->
                <div class="relative">
                    <select name="period"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none transition-colors"
                            onchange="this.form.submit()">
                        <option value="">Pilih Periode</option>
                        @php
                            $currentYear = date('Y');
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        @foreach($months as $value => $month)
                            <option value="{{ $currentYear }}-{{ str_pad($value, 2, '0', STR_PAD_LEFT) }}"
                                    {{ request('period') == "$currentYear-" . str_pad($value, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ $month }} {{ $currentYear }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-calendar-alt absolute left-3.5 top-3 text-gray-400"></i>
                    <i class="fas fa-chevron-down absolute right-3.5 top-3 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </form>

        <!-- Card List for Mobile -->
        <div class="block md:hidden p-4">
            @forelse($prescriptions as $prescription)
                <div class="bg-white rounded-lg shadow p-4 mb-3 border border-gray-100">
                    <div class="flex items-center mb-2">
                        <span class="font-mono text-indigo-600 font-medium mr-2">#{{ $prescription->prescription_number }}</span>
                        <span class="text-xs text-gray-400 ml-auto">{{ $prescription->created_at->isoFormat('DD MMM YYYY') }}</span>
                    </div>
                    <div class="flex items-center mb-1">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ optional($prescription->patient)->name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ optional($prescription->patient)->no_bpjs ?? 'Tanpa BPJS' }}</div>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap mb-2">
                        @foreach($prescription->diseases as $disease)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-virus mr-1 text-xs"></i>{{ $disease->name }}
                            </span>
                        @endforeach
                        @foreach($prescription->medicines as $medicine)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-pills mr-1 text-xs"></i>{{ $medicine->name }}
                            </span>
                        @endforeach
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('prescriptions.show', $prescription) }}" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('prescriptions.edit', $prescription) }}" class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus resep ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">Belum ada data resep</div>
            @endforelse
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No Resep
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pasien
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Diagnosis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">
                            Obat
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-40">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($prescriptions as $prescription)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="font-mono text-indigo-600 font-medium">#{{ $prescription->prescription_number }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-9 w-9">
                                    <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i class="fas fa-user text-indigo-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ optional($prescription->patient)->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ optional($prescription->patient)->no_bpjs ?? 'Tanpa BPJS' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                {{ $prescription->created_at->isoFormat('DD MMM YYYY') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($prescription->diseases as $disease)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-virus mr-1.5 text-xs"></i>
                                    {{ $disease->name }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden xl:table-cell">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($prescription->medicines as $medicine)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-pills mr-1.5 text-xs"></i>
                                    {{ $medicine->name }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <a href="{{ route('prescriptions.show', $prescription) }}"
                               class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('prescriptions.edit', $prescription) }}"
                               class="text-yellow-600 hover:text-yellow-900 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus resep ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-prescription text-gray-400 text-lg"></i>
                                </div>
                                <div class="text-sm text-gray-500">Belum ada data resep</div>
                                <a href="{{ route('prescriptions.create') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Resep Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($prescriptions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $prescriptions->onEachSide(1)->links() }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    /* Tooltip */
    [data-tooltip] {
        position: relative;
    }
    [data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: -2rem;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.5rem 0.75rem;
        background-color: #1f2937;
        color: white;
        font-size: 0.75rem;
        border-radius: 0.375rem;
        white-space: nowrap;
        z-index: 10;
    }

    /* Pagination Styling */
    .pagination {
        @apply flex justify-center items-center space-x-1;
    }
    .pagination .page-item.active .page-link {
        @apply bg-indigo-600 text-white border-indigo-600;
    }
    .pagination .page-link {
        @apply px-3 py-1.5 border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md transition-colors;
    }
    .pagination .page-item.disabled .page-link {
        @apply opacity-50 cursor-not-allowed;
    }
</style>
@endpush
@endsection
