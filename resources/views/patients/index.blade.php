@extends('layouts.app')

@section('content')
    <div class="p-4 bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-user-injured text-blue-600 mr-3"></i>
                        Manajemen Pasien PRB
                    </h1>
                    <p class="mt-2 text-gray-600">Kelola data pasien Program Rujuk Balik dengan mudah dan efisien</p>
                </div>
                <a href="{{ route('patients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center self-start sm:self-auto">
                    <i class="fas fa-plus mr-2"></i>Tambah Pasien
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-blue-100 hover:shadow-md transition-shadow h-full flex items-center">
                    <div class="p-2 md:p-3 rounded-full bg-blue-50 text-blue-600">
                        <i class="fas fa-users text-lg md:text-xl"></i>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <h2 class="text-xs md:text-sm font-semibold text-gray-600">Total Pasien</h2>
                        <p class="text-lg md:text-2xl font-bold text-gray-900">{{ $patients->total() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-indigo-100 hover:shadow-md transition-shadow h-full flex items-center">
                    <div class="p-2 md:p-3 rounded-full bg-indigo-50 text-indigo-600">
                        <i class="fas fa-mars text-lg md:text-xl"></i>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <h2 class="text-xs md:text-sm font-semibold text-gray-600">Pasien Laki-laki</h2>
                        <p class="text-lg md:text-2xl font-bold text-gray-900">{{ $patients->where('gender', 'L')->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-pink-100 hover:shadow-md transition-shadow h-full flex items-center">
                    <div class="p-2 md:p-3 rounded-full bg-pink-50 text-pink-600">
                        <i class="fas fa-venus text-lg md:text-xl"></i>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <h2 class="text-xs md:text-sm font-semibold text-gray-600">Pasien Perempuan</h2>
                        <p class="text-lg md:text-2xl font-bold text-gray-900">{{ $patients->where('gender', 'P')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Search and Filter Section -->
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex-1 w-full sm:w-auto flex flex-col sm:flex-row gap-4">
                            <!-- Search Input -->
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="searchInput"
                                    placeholder="Cari nama pasien atau nomor BPJS..."
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-150 text-sm">
                            </div>

                            <!-- Gender Filter -->
                            <div class="relative min-w-[180px]">
                                <select id="genderFilter"
                                    class="w-full appearance-none pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-150 text-sm cursor-pointer">
                                    <option value="">Semua Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                            <a href="{{ url('patients/export/excel') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                                <i class="fas fa-file-excel mr-2"></i> Ekspor Excel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <!-- Desktop Table -->
                <div class="overflow-x-auto">
                    <table id="patientsTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 md:px-6 py-2 md:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No</th>
                                <th class="px-2 md:px-6 py-2 md:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-2 md:px-6 py-2 md:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">No. BPJS</th>
                                <th class="px-2 md:px-6 py-2 md:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Gender</th>
                                <th class="px-2 md:px-6 py-2 md:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Tanggal Lahir</th>
                                <th class="px-2 md:px-6 py-2 md:py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-32 md:w-48">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($patients as $index => $patient)
                                <tr class="hover:bg-blue-50/50 transition-all duration-150 cursor-pointer">
                                    <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 md:h-10 md:w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div class="ml-2 md:ml-4">
                                                <div class="text-xs md:text-sm font-semibold text-gray-900">{{ $patient->name }}</div>
                                                <div class="md:hidden text-xs text-gray-500">No. BPJS: {{ $patient->no_bpjs }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-900 hidden sm:table-cell">
                                        <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-lg text-xs md:text-sm font-medium bg-blue-50 text-blue-800 border border-blue-100">
                                            {{ $patient->no_bpjs }}
                                        </span>
                                    </td>
                                    <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm hidden md:table-cell">
                                        <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-lg text-xs md:text-sm font-medium
                                            {{ $patient->gender == 'L'
                                                ? 'bg-indigo-50 text-indigo-800 border border-indigo-100'
                                                : 'bg-pink-50 text-pink-800 border border-pink-100' }}">
                                            <i class="fas {{ $patient->gender == 'L' ? 'fa-mars' : 'fa-venus' }} mr-1.5"></i>
                                            {{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-500 hidden lg:table-cell">
                                        <div class="flex items-center">
                                            <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                                            {{ \Carbon\Carbon::parse($patient->birth_date)->isoFormat('DD MMMM Y') }}
                                        </div>
                                    </td>
                                    <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('patients.show', $patient) }}"
                                               class="p-2 text-blue-700 hover:bg-blue-50 rounded-lg transition-colors duration-150"
                                               style="cursor:pointer">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('patients.edit', $patient) }}"
                                               class="p-2 text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors duration-150"
                                               style="cursor:pointer">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-red-700 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                                        style="cursor:pointer"
                                                        onclick="return confirm('Anda yakin ingin menghapus data pasien ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-2 md:px-6 py-8 text-center text-xs md:text-base">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <div class="bg-blue-50 p-3 rounded-full mb-4">
                                                <i class="fas fa-user-injured text-2xl md:text-4xl text-blue-500"></i>
                                            </div>
                                            <p class="text-base md:text-lg font-medium text-gray-900">Belum ada data pasien</p>
                                            <p class="text-xs md:text-sm text-gray-500 mt-1">Silakan tambah data pasien baru</p>
                                            <a href="{{ route('patients.create') }}"
                                               class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 text-xs md:text-base">
                                                <i class="fas fa-plus-circle mr-2"></i>
                                                Tambah Pasien
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($patients->hasPages())
                    <div class="bg-white px-6 py-4 border-t border-gray-200">
                        {{ $patients->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Desktop filter
        const searchInput = document.getElementById('searchInput');
        const genderFilter = document.getElementById('genderFilter');

        const debounce = (func, wait) => {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        };

        const updateRowNumbers = () => {
            const visibleRows = document.querySelectorAll('#patientsTable tbody tr:not([style*="display: none"])');
            visibleRows.forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        };

        const applyFilters = debounce(() => {
            const filter = searchInput.value.toLowerCase();
            const gender = genderFilter.value;
            const rows = document.querySelectorAll('#patientsTable tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;

                for(let i = 1; i < cells.length - 1; i++) {
                    const text = cells[i].textContent.toLowerCase();
                    if(text.includes(filter)) {
                        match = true;
                        break;
                    }
                }

                const genderCell = cells[3].textContent.trim();
                if (gender && !genderCell.includes(gender)) {
                    match = false;
                }

                row.style.display = match ? '' : 'none';
            });

            updateRowNumbers();
        }, 300);

        searchInput && searchInput.addEventListener('input', applyFilters);
        genderFilter && genderFilter.addEventListener('change', applyFilters);

        // Tambahkan animasi loading saat melakukan pencarian
        searchInput && searchInput.addEventListener('input', function() {
            const searchIcon = this.previousElementSibling.querySelector('i');
            searchIcon.classList.add('animate-spin');
            setTimeout(() => searchIcon.classList.remove('animate-spin'), 300);
        });

        // Tambahkan event click untuk baris tabel
        const tableRows = document.querySelectorAll('#patientsTable tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('a, button, form')) {
                    const detailLink = this.querySelector('a[title="Lihat Detail"]');
                    if (detailLink) {
                        detailLink.click();
                    }
                }
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .tooltip {
        @apply relative;
    }

    .tooltip:hover::after {
        content: attr(data-tooltip);
        @apply absolute bg-gray-800 text-white text-xs px-2.5 py-1.5 rounded-lg -bottom-10 left-1/2 transform -translate-x-1/2 whitespace-nowrap z-10;
    }

    .tooltip:hover::before {
        content: '';
        @apply absolute w-2 h-2 bg-gray-800 transform rotate-45 -bottom-4 left-1/2 -translate-x-1/2;
    }

    .sort-header {
        @apply transition duration-150;
    }

    .sort-header:hover {
        @apply bg-gray-100;
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /* Custom Scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        @apply bg-gray-100 rounded-full;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        @apply bg-gray-300 rounded-full;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        @apply bg-gray-400;
    }
</style>
@endpush
