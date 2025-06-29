@extends('layouts.app')

@section('content')
@if(!$patient)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">Data pasien tidak ditemukan.</span>
        <a href="{{ route('prescriptions.index') }}" class="underline">Kembali ke halaman resep</a>
    </div>
@else
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
            <div class="space-y-1">
                <div class="flex items-center gap-2 sm:gap-3">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Riwayat Kunjungan</h2>
                    <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-blue-100 text-blue-700 rounded-full text-xs sm:text-sm font-medium">
                        {{ $patient->medicinePatientHistories->count() }}x kunjungan
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-gray-600">Detail riwayat pengambilan obat untuk {{ $patient->name }}</p>
            </div>
            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                <select id="yearSelect" onchange="changeYear(this.value)" class="rounded-lg border-gray-300 text-gray-700 text-xs sm:text-sm w-full sm:w-auto">
                    @for($year = now()->year; $year >= $patient->created_at->format('Y'); $year--)
                        <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                            Tahun {{ $year }}
                        </option>
                    @endfor
                </select>
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-4">
        @foreach($months as $month)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-2 sm:p-4 {{ $month['date'] === now()->format('Y-m') ? 'bg-blue-50' : '' }}">
                    <div class="flex items-center justify-between mb-2 sm:mb-3">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">{{ $month['name'] }}</h3>
                        @switch($month['status'])
                            @case('completed')
                                <span class="px-2 py-0.5 sm:py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Sudah Ambil
                                </span>
                                @break
                            @case('missed')
                                <span class="px-2 py-0.5 sm:py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Terlewat
                                </span>
                                @break
                            @case('upcoming')
                                <span class="px-2 py-0.5 sm:py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                    <i class="fas fa-clock mr-1"></i>
                                    Akan Datang
                                </span>
                                @break
                            @default
                                <span class="px-2 py-0.5 sm:py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Belum Ambil
                                </span>
                        @endswitch
                    </div>

                    @if($month['histories']->isNotEmpty())
                        <div class="space-y-1 sm:space-y-2">
                            @foreach($month['histories'] as $history)
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-3">
                                    <div class="flex items-center justify-between mb-0.5 sm:mb-1">
                                        <span class="text-xs sm:text-sm font-medium text-gray-900">
                                            {{ Carbon\Carbon::parse($history->taken_at)->translatedFormat('d F') }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ Carbon\Carbon::parse($history->taken_at)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-600">
                                        <p>Resep: #{{ $history->prescription->prescription_number ?? 'Tidak ada' }}</p>
                                        <p>Dokter: {{ $history->doctor->name ?? 'Tidak diketahui' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-2 sm:py-4">
                            <p class="text-xs sm:text-sm text-gray-500">Tidak ada kunjungan</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

@push('scripts')
<script>
function changeYear(year) {
    window.location.href = `{{ route('patients.visits', $patient->id ?? 0) }}?year=${year}`;
}
</script>
@endpush
@endsection
