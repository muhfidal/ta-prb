@extends('layouts.app')

@section('content')
<x-card title="Daftar Obat" class="rounded-xl shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div class="space-y-2">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Data Obat</h2>
            <p class="text-gray-600">Total {{ $medicines->total() }} obat terdaftar</p>
        </div>
        <x-button href="{{ route('medicines.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Obat
        </x-button>
    </div>

    <!-- Filter Section -->
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 mb-4 md:mb-6">
        <div class="relative">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari obat..."
                   class="w-full pl-10 pr-3 py-2 md:py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 bg-gray-50 text-sm md:text-base transition-all">
            <i class="fas fa-search absolute left-3 top-2.5 md:left-4 md:top-4 text-gray-400"></i>
        </div>
        <select name="unit" class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 bg-gray-50 text-sm md:text-base" onchange="this.form.submit()">
            <option value="all">Filter Satuan</option>
            @foreach(\App\Models\Medicine::select('unit')->distinct()->pluck('unit') as $unit)
                <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
            @endforeach
        </select>
        <select name="is_prb" class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 bg-gray-50 text-sm md:text-base" onchange="this.form.submit()">
            <option value="">Semua Obat</option>
            <option value="1" {{ request('is_prb') === '1' ? 'selected' : '' }}>Obat Gejala Tambahan</option>
            <option value="0" {{ request('is_prb') === '0' ? 'selected' : '' }}>Bukan Obat Gejala Tambahan</option>
        </select>
        <select name="sort" class="w-full px-3 py-2 md:px-4 md:py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 bg-gray-50 text-sm md:text-base" onchange="this.form.submit()">
            <option value="">Urutkan</option>
            <option value="code" {{ request('sort') == 'code' ? 'selected' : '' }}>Kode (A-Z)</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
        </select>
    </form>

    <!-- MOBILE: Card/List View -->
    <div class="md:hidden space-y-3">
      @forelse($medicines as $medicine)
        <div class="bg-white rounded-lg shadow p-3 flex flex-col space-y-1 border">
          <div class="flex items-center space-x-2">
            <span class="font-mono text-blue-500 font-bold">{{ $medicine->code }}</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">{{ $medicine->unit }}</span>
          </div>
          <div class="flex items-center mt-1">
            <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
              <i class="fas fa-pills text-blue-500"></i>
            </div>
            <div class="ml-2 text-sm font-semibold text-gray-900">{{ $medicine->name }}</div>
          </div>
          @if($medicine->description)
          <div class="text-xs text-gray-600 mt-1">{{ Str::limit($medicine->description, 60) }}</div>
          @endif
          <div class="flex space-x-2 mt-2">
            <a href="{{ route('medicines.edit', $medicine) }}" class="text-yellow-600 hover:text-yellow-800"><i class="fas fa-edit"></i></a>
            <button type="button" class="text-red-600 hover:text-red-800" onclick="openDeleteModal('{{ $medicine->id }}', '{{ $medicine->name }}')"><i class="fas fa-trash"></i></button>
          </div>
        </div>
      @empty
        <div class="text-center text-gray-400 py-8">
          <i class="fas fa-pills fa-2x mb-2"></i>
          <div class="text-gray-500 font-medium">Belum ada data obat</div>
          <div class="text-xs mt-1">Klik tombol "Tambah Obat" untuk menambahkan obat pertama</div>
        </div>
      @endforelse
      <!-- Pagination Mobile -->
      @if($medicines->hasPages())
        <div class="bg-gray-50 px-3 py-2 border-t mt-2">
          {{ $medicines->onEachSide(1)->links() }}
        </div>
      @endif
    </div>

    <!-- DESKTOP: Table View -->
    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">
                            Kode Obat
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">
                            Nama Obat
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider hidden md:table-cell">
                            Deskripsi
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">
                            Satuan
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">
                            Gejala Tambahan
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-blue-600 uppercase tracking-wider w-40">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($medicines as $medicine)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-blue-500 font-medium">
                                {{ $medicine->code }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-pills text-blue-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $medicine->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="text-sm text-gray-600">
                                    {{ Str::limit($medicine->description, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $medicine->unit }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($medicine->is_prb)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Obat Gejala Tambahan</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700">Bukan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('medicines.edit', $medicine) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <button type="button"
                                        class="text-red-600 hover:text-red-800"
                                        onclick="openDeleteModal('{{ $medicine->id }}', '{{ $medicine->name }}')">
                                    <i class="fas fa-trash fa-lg"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-pills fa-3x mb-4"></i>
                                    <p class="text-gray-500 font-medium">Belum ada data obat</p>
                                    <p class="text-sm mt-2">Klik tombol "Tambah Obat" untuk menambahkan obat pertama</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($medicines->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t">
                {{ $medicines->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</x-card>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out">
    <div class="min-h-screen px-4 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-middle my-8 p-6 w-full max-w-md text-left overflow-hidden transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus obat <span id="medicineName" class="font-semibold"></span>?</p>

                <form id="deleteForm" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                                onclick="closeDeleteModal()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-colors">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    [data-tooltip] {
        @apply relative;
    }
    [data-tooltip]:hover::after {
        @apply absolute bg-gray-800 text-white px-3 py-1.5 rounded-lg text-sm -bottom-9 left-1/2 -translate-x-1/2 whitespace-nowrap;
        content: attr(data-tooltip);
    }
    .pagination .page-item.active .page-link {
        @apply bg-blue-500 text-white border-blue-500;
    }
    .pagination .page-link {
        @apply px-3.5 py-2 border rounded-lg hover:bg-gray-50 transition-colors;
    }
    /* Modal Animation */
    #deleteModal {
        transition: opacity 0.3s ease-in-out;
    }
    #deleteModal.show {
        opacity: 1;
    }
    #deleteModal .transform {
        transition: all 0.3s ease-in-out;
    }
    #deleteModal.show .transform {
        transform: scale(1);
        opacity: 1;
    }
    #deleteModal:not(.show) .transform {
        transform: scale(0.95);
        opacity: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    function openDeleteModal(id, name) {
        const modal = document.getElementById('deleteModal');
        document.getElementById('medicineName').textContent = name;
        document.getElementById('deleteForm').action = `/medicines/${id}`;

        // Show modal with animation
        modal.classList.remove('hidden');
        // Trigger reflow
        modal.offsetHeight;
        modal.classList.add('show');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('show');
        // Wait for animation to complete before hiding
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection
