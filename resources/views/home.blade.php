@extends('layouts.app')

@section('title', 'Dashboard - Sistem PRB')

@section('content')
@php
    function hariIndonesia($date) {
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        $tanggal = $date->format('l, d F Y');
        return strtr($tanggal, array_merge($hari, $bulan));
    }

    function waktuIndonesia($time) {
        return $time->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB';
    }

    function diffForHumansIndonesia($date) {
        $time = $date->diffForHumans();

        $translations = [
            'ago' => 'yang lalu',
            'from now' => 'dari sekarang',
            'years' => 'tahun',
            'year' => 'tahun',
            'months' => 'bulan',
            'month' => 'bulan',
            'weeks' => 'minggu',
            'week' => 'minggu',
            'days' => 'hari',
            'day' => 'hari',
            'hours' => 'jam',
            'hour' => 'jam',
            'minutes' => 'menit',
            'minute' => 'menit',
            'seconds' => 'detik',
            'second' => 'detik',
            'just now' => 'baru saja'
        ];

        return str_replace(array_keys($translations), array_values($translations), $time);
    }
@endphp
<div class="space-y-6">
    <!-- Tanggal & waktu untuk mobile -->
    <div class="flex md:hidden items-center space-x-2 mb-2">
        <i class="fas fa-calendar-alt text-blue-700"></i>
        <span class="text-blue-900 text-sm">{{ hariIndonesia(now()) }}</span>
        <span class="text-blue-900 text-sm">{{ waktuIndonesia(now()) }}</span>
    </div>
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-8 relative overflow-hidden">
        <!-- Tanggal & waktu untuk desktop -->
        <div class="absolute right-0 top-0 mt-4 mr-4 bg-white bg-opacity-20 rounded-lg p-2 hidden md:flex flex-row items-center space-x-2">
            <i class="fas fa-calendar-alt text-white mr-2"></i>
            <span class="text-white text-sm">{{ hariIndonesia(now()) }}</span>
            <span class="text-white text-sm ml-2">{{ waktuIndonesia(now()) }}</span>
        </div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-blue-100 text-lg">Dashboard Sistem PRB (Program Rujuk Balik) - Puskesmas Purwanegara 1</p>
        </div>
        <div class="absolute bottom-0 right-0 opacity-10">
            <i class="fas fa-hospital text-white text-9xl transform -rotate-12"></i>
        </div>
    </div>

    <!-- Stats Cards with Trends -->
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 px-2 md:px-6">
        <!-- Total Pasien -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-6 flex items-center group hover:shadow-lg transition-all">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-blue-100 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('patients.index') }}" class="text-blue-500 hover:text-blue-600 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ number_format($totalPatients ?? 0) }}</h2>
                <p class="text-sm font-medium text-gray-500">Total Pasien</p>
            </div>
        </div>

        <!-- Total Resep -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-6 flex items-center group hover:shadow-lg transition-all">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-green-100 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-prescription text-green-600 text-2xl"></i>
            </div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('prescriptions.index') }}" class="text-green-500 hover:text-green-600 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ number_format($totalPrescriptions ?? 0) }}</h2>
                <p class="text-sm font-medium text-gray-500">Total Resep</p>
            </div>
        </div>

        <!-- Data Obat -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-6 flex items-center group hover:shadow-lg transition-all">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-yellow-100 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-pills text-yellow-600 text-2xl"></i>
            </div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('medicines.index') }}" class="text-yellow-500 hover:text-yellow-600 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ number_format($totalMedicines ?? 0) }}</h2>
                <p class="text-sm font-medium text-gray-500">Data Obat</p>
            </div>
        </div>

        <!-- Total Gejala -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-6 flex items-center group hover:shadow-lg transition-all">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-red-100 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-stethoscope text-red-600 text-2xl"></i>
            </div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('penyakits.index') }}" class="text-red-500 hover:text-red-600 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-1">{{ number_format($totalPrbDiseases ?? 0) }}</h2>
                <p class="text-sm font-medium text-gray-500">Total Penyakit Gejala Tambahan</p>
            </div>
        </div>
    </div>

    <!-- Progress Section with Enhanced UI -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 md:mb-6">
            <div>
                <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                    Statistik Pengambilan Obat
                </h2>
                <p class="text-gray-500 mt-1 text-sm md:text-base">Persentase pasien yang telah mengambil obat</p>
            </div>
            <a href="{{ route('medicinePatientHistories.index') }}"
               class="inline-flex items-center px-3 py-1.5 md:px-4 md:py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs md:text-sm mt-2 md:mt-0">
                <i class="fas fa-chart-bar mr-2"></i>
                Detail Statistik
            </a>
        </div>
        <div class="bg-gray-50 rounded-xl p-3 md:p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-4 mb-4 md:mb-6">
                <div class="bg-white p-2 md:p-4 rounded-lg shadow-sm">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Pengambilan</p>
                    <h4 class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($totalPatientsWithMedicine ?? 0) }}</h4>
                </div>
                <div class="bg-white p-2 md:p-4 rounded-lg shadow-sm">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Persentase</p>
                    <h4 class="text-lg md:text-2xl font-bold {{ $percentagePatientsWithMedicine >= 70 ? 'text-green-600' : ($percentagePatientsWithMedicine >= 40 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ number_format($percentagePatientsWithMedicine, 1) }}%
                    </h4>
                </div>
                <div class="bg-white p-2 md:p-4 rounded-lg shadow-sm col-span-2 md:col-span-1">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Status</p>
                    <h4 class="text-lg md:text-2xl font-bold {{ $percentagePatientsWithMedicine >= 70 ? 'text-green-600' : ($percentagePatientsWithMedicine >= 40 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $percentagePatientsWithMedicine >= 70 ? 'Baik' : ($percentagePatientsWithMedicine >= 40 ? 'Sedang' : 'Perlu Perhatian') }}
                    </h4>
                </div>
            </div>
            <div class="relative pt-1">
                <div class="overflow-hidden h-3 md:h-4 rounded-full bg-gray-200">
                    <div class="h-full rounded-full transition-all duration-500 {{ $percentagePatientsWithMedicine >= 70 ? 'bg-green-500' : ($percentagePatientsWithMedicine >= 40 ? 'bg-yellow-500' : 'bg-red-500') }}"
                         style="width: {{ $percentagePatientsWithMedicine }}%">
                    </div>
                </div>
                <div class="mt-2 flex justify-between text-xs text-gray-500">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Charts with Enhanced UI -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 px-2 md:px-0">
        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-sm p-2 md:p-6">
            <div class="flex items-center justify-between mb-4 md:mb-6">
                <div>
                    <h2 class="text-base md:text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-history text-blue-500 mr-2"></i>
                        Aktivitas Terbaru
                    </h2>
                    <p class="text-gray-500 mt-1 text-xs md:text-base">Aktivitas sistem hari ini</p>
                </div>
                <div class="bg-green-50 text-green-600 px-2 py-0.5 md:px-3 md:py-1 rounded-full text-xs md:text-sm font-medium">
                    Live Updates
                </div>
            </div>
            <div class="space-y-2 md:space-y-4 max-h-[200px] md:max-h-[400px] overflow-y-auto custom-scrollbar">
                @forelse($recentActivities as $activity)
                <div class="flex items-start p-2 md:p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-pills text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-2 md:ml-4 flex-grow">
                        <div class="flex items-center justify-between">
                            <p class="text-xs md:text-sm font-medium text-gray-900">{{ $activity['type'] }}</p>
                            <span class="text-xs text-blue-500">{{ diffForHumansIndonesia(\Carbon\Carbon::parse($activity['time'])) }}</span>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">
                            @php
                                $description = $activity['description'];
                                $description = str_replace('mengambil obat dari Unknown', 'telah mengambil obat', $description);
                            @endphp
                            {{ $description }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-4 md:py-8 text-gray-500">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-100 rounded-full flex items-center justify-center mb-2 md:mb-3">
                        <i class="fas fa-inbox text-2xl md:text-4xl text-gray-400"></i>
                    </div>
                    <p class="font-medium text-xs md:text-base">Belum ada aktivitas terbaru</p>
                    <p class="text-xs md:text-sm text-gray-400 mt-1">Aktivitas akan muncul di sini</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Chart with Enhanced UI -->
        <div class="bg-white rounded-xl shadow-sm p-3 md:p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                        Statistik Bulanan
                    </h2>
                    <p class="text-gray-500 mt-1">Pengambilan obat dalam 6 bulan terakhir</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Download PDF">
                        <i class="fas fa-download text-gray-500"></i>
                    </button>
                    <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Refresh Data">
                        <i class="fas fa-sync-alt text-gray-500"></i>
                    </button>
                </div>
            </div>
            <div class="relative h-[250px] md:h-[400px] w-full">
                <canvas id="monthlyStats"></canvas>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Enhanced Card hover animation */
    .hover\:shadow-lg {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Custom scrollbar */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #E5E7EB transparent;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E5E7EB;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #D1D5DB;
    }

    /* Progress bar animation */
    .transition-all {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Chart container */
    #monthlyStats {
        width: 100% !important;
        height: 100% !important;
    }

    /* Card decorative elements */
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlyStats').getContext('2d');

        // Create gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.1)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels ?? []) !!},
                datasets: [{
                    label: 'Pengambilan Obat',
                    data: {!! json_encode($chartData ?? []) !!},
                    borderColor: '#2563EB',
                    backgroundColor: gradient,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563EB',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#2563EB',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1F2937',
                        bodyColor: '#1F2937',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y} pengambilan`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6B7280',
                            padding: 10,
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6B7280',
                            padding: 10
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                elements: {
                    line: {
                        borderJoinStyle: 'round'
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
