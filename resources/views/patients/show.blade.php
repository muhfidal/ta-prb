@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-4 sm:p-6 md:p-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 mt-2 mr-2 sm:mt-4 sm:mr-4 bg-white bg-opacity-20 rounded-lg p-1 sm:p-2">
            <i class="fas fa-calendar-alt text-white mr-1 sm:mr-2 text-xs sm:text-sm"></i>
            <span class="text-white text-xs sm:text-sm">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
        </div>
        <div class="relative z-10">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-1 sm:mb-2">Detail Pasien</h1>
            <p class="text-blue-100 text-sm sm:text-base">Informasi lengkap dan riwayat pasien PRB</p>
        </div>
        <div class="absolute bottom-0 right-0 opacity-10">
            <i class="fas fa-user-md text-white text-6xl sm:text-8xl md:text-9xl transform -rotate-12"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-3">
        <!-- Informasi Pasien -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl p-3 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-600 text-xl sm:text-2xl"></i>
                        Profil Pasien
                    </h3>
                    <span class="bg-blue-100 text-blue-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-0.5 sm:py-1 rounded-full">
                        ID: {{ $patient->id }}
                    </span>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center gap-3 sm:gap-4 p-2 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-signature text-blue-500 text-base sm:text-lg w-5 sm:w-6"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium text-gray-800 text-sm sm:text-base">{{ $patient->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 p-2 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-id-card text-blue-500 text-base sm:text-lg w-5 sm:w-6"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500">Nomor BPJS</p>
                            <p class="font-medium text-gray-800 text-sm sm:text-base">{{ $patient->no_bpjs ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 p-2 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-venus-mars text-blue-500 text-base sm:text-lg w-5 sm:w-6"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500">Jenis Kelamin</p>
                            <p class="font-medium text-gray-800 text-sm sm:text-base">{{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 p-2 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-calendar-alt text-blue-500 text-base sm:text-lg w-5 sm:w-6"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500">Tanggal Lahir</p>
                            <p class="font-medium text-gray-800 text-sm sm:text-base">
                                {{ \Carbon\Carbon::parse($patient->birth_date)->format('d M Y') }}
                                <span class="text-xs sm:text-sm text-gray-500 ml-1 sm:ml-2">
                                    ({{ \Carbon\Carbon::parse($patient->birth_date)->age }} tahun)
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 p-2 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-map-marker-alt text-blue-500 text-base sm:text-lg w-5 sm:w-6"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500">Alamat</p>
                            <p class="font-medium text-gray-800 text-sm sm:text-base">{{ $patient->address ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 p-2 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-history text-blue-500 text-base sm:text-lg w-5 sm:w-6"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500">Total Kunjungan</p>
                            <a href="{{ route('patients.visits', $patient->id) }}"
                               class="font-medium text-gray-800 text-sm sm:text-base underline hover:text-blue-600 transition-colors cursor-pointer"
                               title="Lihat riwayat kunjungan pasien">
                                {{ $patient->medicinePatientHistories->unique('taken_at')->count() }}x
                                <span class="text-xs sm:text-sm text-gray-500 ml-1 sm:ml-2">
                                    (Terakhir: {{ $patient->medicinePatientHistories->max('taken_at') ? \Carbon\Carbon::parse($patient->medicinePatientHistories->max('taken_at'))->format('d M Y') : 'Belum ada' }})
                                </span>
                            </a>
                            <p class="text-xs text-gray-500 mt-1">
                                @php
                                    $thisMonth = $patient->medicinePatientHistories
                                        ->where('taken_at', '>=', now()->startOfMonth())
                                        ->where('taken_at', '<=', now()->endOfMonth())
                                        ->unique('taken_at')
                                        ->count();
                                @endphp
                                {{ $thisMonth }} kali pengambilan bulan ini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Daftar Penyakit dan Obat -->
            <div class="bg-white rounded-xl p-3 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 gap-2 sm:gap-0">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-notes-medical text-red-600 text-lg sm:text-xl"></i>
                        Daftar Penyakit dan Obat
                    </h3>
                </div>
                <div class="space-y-4 sm:space-y-6">
                    @forelse($patient->prescriptions as $prescription)
                        <div class="p-2 sm:p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 sm:mb-3 gap-2 sm:gap-0">
                                <h4 class="font-semibold text-gray-700 flex items-center gap-2 text-sm sm:text-base">
                                    <i class="fas fa-file-prescription text-blue-500 text-base sm:text-lg"></i>
                                    Resep: {{ $prescription->prescription_number }}
                                </h4>
                                <span class="text-xs sm:text-sm text-gray-500">{{ $prescription->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 md:gap-4">
                                <div>
                                    <p class="font-medium text-gray-800 mb-1 sm:mb-2 flex items-center gap-2 text-sm sm:text-base">
                                        <i class="fas fa-disease text-red-500"></i>
                                        Penyakit:
                                    </p>
                                    <ul class="space-y-1">
                                        @foreach($prescription->diseases as $disease)
                                            <li class="flex items-center gap-2 text-gray-600 text-xs sm:text-sm">
                                                <i class="fas fa-circle text-xs text-red-400"></i>
                                                {{ $disease->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 mb-1 sm:mb-2 flex items-center gap-2 text-sm sm:text-base">
                                        <i class="fas fa-pills text-green-500"></i>
                                        Obat:
                                    </p>
                                    <ul class="space-y-1">
                                        @foreach($prescription->medicines as $medicine)
                                            <li class="flex items-center gap-2 text-gray-600 text-xs sm:text-sm">
                                                <i class="fas fa-circle text-xs text-green-400"></i>
                                                {{ $medicine->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 sm:py-8">
                            <div class="mb-2 sm:mb-4">
                                <i class="fas fa-folder-open text-gray-400 text-3xl sm:text-5xl"></i>
                            </div>
                            <h3 class="text-gray-500 font-medium text-sm sm:text-base">Belum ada resep</h3>
                            <p class="text-gray-400 text-xs sm:text-sm">Pasien belum memiliki resep yang tercatat</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Pengambilan Obat -->
            <div class="bg-white rounded-xl p-3 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 gap-2 sm:gap-0">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-capsules text-blue-600 text-lg sm:text-xl"></i>
                        Riwayat Pengambilan Obat
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="text-xs sm:text-sm text-gray-500">Tahun:</span>
                        <span class="bg-blue-100 text-blue-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-0.5 sm:py-1 rounded-full">
                            {{ now()->year }}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 sm:gap-3 lg:grid-cols-6">
                    @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'] as $index => $month)
                        @php
                            $currentMonth = now()->month;
                            $isPastMonth = $index + 1 < $currentMonth;
                        @endphp
                        <div class="p-2 sm:p-3 rounded-lg border transition-all duration-200 hover:shadow-md
                                  {{ isset($groupedHistories[$index + 1])
                                      ? 'bg-green-50 border-green-200 hover:bg-green-100'
                                      : ($isPastMonth
                                          ? 'bg-red-50 border-red-200 hover:bg-red-100'
                                          : 'bg-gray-50 border-gray-200 hover:bg-gray-100') }}">
                            <div class="text-center">
                                <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1 sm:mb-2">{{ $month }}</p>
                                <div class="flex justify-center">
                                    @if(isset($groupedHistories[$index + 1]))
                                        <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                            <i class="fas fa-check text-white text-sm"></i>
                                        </div>
                                    @elseif($isPastMonth)
                                        <div class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center">
                                            <i class="fas fa-times text-white text-sm"></i>
                                        </div>
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-clock text-white text-sm"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        <span>Telah Mengambil</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                        <span>Belum Mengambil (Lewat)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-gray-300"></div>
                        <span>Belum Waktunya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end gap-3">
        <a href="{{ route('patients.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <a href="{{ route('patients.edit', $patient->id) }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Pasien
        </a>
    </div>
</div>

@push('styles')
<style>
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .transition-shadow {
        transition: box-shadow 0.3s ease-in-out;
    }

    .transition-colors {
        transition: background-color 0.2s ease-in-out;
    }
</style>
@endpush
@endsection
