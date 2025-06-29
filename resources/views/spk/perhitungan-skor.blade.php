@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 py-4 md:py-8">
    <!-- Header -->
    <div class="w-full mb-4 md:mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-4 md:p-8 relative overflow-hidden">
            <div class="absolute right-0 top-0 mt-4 md:mt-6 mr-4 md:mr-6 bg-white/20 backdrop-blur-sm rounded-xl p-2 md:p-3 flex items-center shadow">
                <i class="fas fa-calendar-alt text-white/90 text-sm md:text-base mr-2"></i>
                <span class="text-white/90 text-sm md:text-base font-medium">{{ now()->format('d M Y, H:i') }}</span>
            </div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-4">
                <div class="flex items-center gap-2 md:gap-4">
                    <div class="p-2 md:p-4 bg-white/10 rounded-2xl shadow">
                        <i class="fas fa-capsules text-2xl md:text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-4xl font-bold text-white tracking-tight mb-1">Analisis Rekomendasi Obat</h1>
                        <p class="text-blue-100/90 text-sm md:text-lg font-normal">Sistem pendukung keputusan berbasis Fuzzy AHP</p>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-10 -right-10 opacity-10 pointer-events-none select-none">
                <i class="fas fa-pills text-white text-[120px] md:text-[220px] rotate-12"></i>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full">
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100/60 p-4 md:p-10">
            <!-- Disease Selection Form -->
            @if(!$selectedPenyakit)
            <div class="mb-6 md:mb-10">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4 flex items-center gap-2">
                    <i class="fas fa-search-medical text-blue-600"></i>
                    Pilih Penyakit untuk Analisis
                </h2>
                <form method="GET" action="{{ route('spk.perhitungan-skor') }}">
                    <div class="flex flex-col sm:flex-row gap-4 md:gap-6 items-start sm:items-end">
                        <div class="flex-1 w-full">
                            <label class="block text-sm md:text-base font-medium text-gray-700 mb-1 md:mb-2">Jenis Penyakit</label>
                            <select name="penyakit_id" class="w-full rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 py-2 md:py-3 px-3 md:px-4 text-sm md:text-base transition-all">
                                <option value="">-- Pilih Penyakit --</option>
                                @foreach($penyakits as $penyakit)
                                    <option value="{{ $penyakit->id }}" {{ request('penyakit_id') == $penyakit->id ? 'selected' : '' }}>
                                        {{ $penyakit->nama_penyakit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 md:px-8 py-2 md:py-3 rounded-xl font-semibold flex items-center gap-2 shadow transition-transform hover:scale-105">
                            <i class="fas fa-chart-line"></i>
                            Mulai Analisis
                        </button>
                    </div>
                </form>
            </div>
            @endif

            @if($selectedPenyakit)
            <!-- Analysis Steps -->
            <div class="space-y-8 md:space-y-14">
                <!-- Step 1: Input Fuzzy -->
                <div class="analysis-step">
                    <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                        <span class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-base md:text-lg shadow">1</span>
                        <h3 class="text-xl md:text-2xl font-semibold text-blue-800">Data Input Fuzzy</h3>
                        <i class="fas fa-wave-square text-blue-600 text-lg md:text-xl"></i>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-blue-100">
                        <table class="min-w-full text-sm md:text-base">
                            <thead class="bg-blue-600/5">
                                <tr>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-blue-900">Obat</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-blue-900">Kriteria</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-blue-900">Nilai Fuzzy (L, M, U)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100/50">
                                @foreach($crisp as $obat => $kriteriaArr)
                                    @foreach($kriteriaArr as $kriteria => $def)
                                        @php
                                            $p = $penilaian->first(fn($x) => $x->medicine->name == $obat && $x->kriteria->nama_kriteria == $kriteria);
                                        @endphp
                                        <tr class="hover:bg-blue-50/30 transition-colors">
                                            <td class="px-4 md:px-6 py-3 md:py-4 font-medium text-gray-800">{{ $obat }}</td>
                                            <td class="px-4 md:px-6 py-3 md:py-4 text-gray-600">{{ $kriteria }}</td>
                                            <td class="px-4 md:px-6 py-3 md:py-4 font-mono text-blue-800">
                                                (<span class="text-blue-600">{{ $p->nilai_l ?? '-' }}</span>,
                                                <span class="text-blue-600">{{ $p->nilai_m ?? '-' }}</span>,
                                                <span class="text-blue-600">{{ $p->nilai_u ?? '-' }}</span>)
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Step 2: Defuzzifikasi -->
                <div class="analysis-step">
                    <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                        <span class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-base md:text-lg shadow">2</span>
                        <h3 class="text-xl md:text-2xl font-semibold text-green-800">Defuzzifikasi</h3>
                        <i class="fas fa-calculator text-green-600 text-lg md:text-xl"></i>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-green-100 mb-4 md:mb-6">
                        <table class="min-w-full text-sm md:text-base">
                            <thead class="bg-green-600/5">
                                <tr>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-green-900">Obat</th>
                                    @foreach($bobotNama as $kriteria => $bobot)
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-green-900">{{ $kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-green-100/50">
                                @foreach($crisp as $obat => $kriteriaArr)
                                    <tr class="hover:bg-green-50/30 transition-colors">
                                        <td class="px-4 md:px-6 py-3 md:py-4 font-medium text-gray-800">{{ $obat }}</td>
                                        @foreach($bobotNama as $kriteria => $bobot)
                                        <td class="px-4 md:px-6 py-3 md:py-4 text-green-800">{{ isset($kriteriaArr[$kriteria]) ? number_format($kriteriaArr[$kriteria], 4) : '-' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white p-4 md:p-8 rounded-xl border border-green-100 shadow-sm">
                        <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                            <i class="fas fa-chart-area text-green-600"></i>
                            <h4 class="font-semibold text-green-800">Visualisasi Defuzzifikasi</h4>
                        </div>
                        @if(isset($crisp) && count($crisp))
                            <div style="height:300px md:height:350px"><canvas id="defuzzChart"></canvas></div>
                        @else
                            <div class="text-center text-gray-400 py-4 md:py-8">Data tidak tersedia untuk visualisasi defuzzifikasi.</div>
                        @endif
                    </div>
                </div>
                <!-- Step 3: Normalisasi -->
                <div class="analysis-step">
                    <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                        <span class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold text-base md:text-lg shadow">3</span>
                        <h3 class="text-xl md:text-2xl font-semibold text-yellow-700">Normalisasi Nilai</h3>
                        <i class="fas fa-equals text-yellow-500 text-lg md:text-xl"></i>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-yellow-100">
                        <table class="min-w-full text-sm md:text-base">
                            <thead class="bg-yellow-100/60">
                                <tr>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-yellow-900">Obat</th>
                                    @foreach($bobotNama as $kriteria => $bobot)
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-yellow-900">{{ $kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-yellow-100/50">
                                @foreach($normal as $obat => $kriteriaArr)
                                    <tr class="hover:bg-yellow-50/30 transition-colors">
                                        <td class="px-4 md:px-6 py-3 md:py-4 font-medium text-gray-800">{{ $obat }}</td>
                                        @foreach($bobotNama as $kriteria => $bobot)
                                        <td class="px-4 md:px-6 py-3 md:py-4 text-yellow-800">{{ isset($kriteriaArr[$kriteria]) ? number_format($kriteriaArr[$kriteria], 4) : '-' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Step 4: Skor Akhir -->
                <div class="analysis-step">
                    <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                        <span class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-base md:text-lg shadow">4</span>
                        <h3 class="text-xl md:text-2xl font-semibold text-indigo-800">Perhitungan Skor Akhir</h3>
                        <i class="fas fa-calculator text-indigo-600 text-lg md:text-xl"></i>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-indigo-100 mb-4 md:mb-6">
                        <table class="min-w-full text-sm md:text-base">
                            <thead class="bg-indigo-600/5">
                                <tr>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-indigo-900">Obat</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-indigo-900">Skor Akhir</th>
                                    <th class="px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-indigo-900">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-indigo-100/50">
                                @foreach($skor as $obat => $nilai)
                                    <tr class="hover:bg-indigo-50/30 transition-colors">
                                        <td class="px-4 md:px-6 py-3 md:py-4 font-semibold text-gray-800">{{ $obat }}</td>
                                        <td class="px-4 md:px-6 py-3 md:py-4 text-indigo-800">{{ number_format($nilai, 4) }}</td>
                                        <td class="px-4 md:px-6 py-3 md:py-4 text-xs text-gray-600">
                                            @php
                                                $detail = [];
                                                foreach($bobotNama as $kriteria => $bobot) {
                                                    $n = $normal[$obat][$kriteria] ?? 0;
                                                    $detail[] = "($n × $bobot)";
                                                }
                                            @endphp
                                            {{ implode(' + ', $detail) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white p-4 md:p-8 rounded-xl border border-indigo-100 shadow-sm">
                        <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                            <i class="fas fa-chart-pie text-indigo-600"></i>
                            <h4 class="font-semibold text-indigo-800">Grafik Skor Akhir</h4>
                        </div>
                        <div style="height:300px md:height:350px"><canvas id="skorChart"></canvas></div>
                    </div>
                </div>
                <!-- Step 5: Rekomendasi -->
                <div class="analysis-step">
                    <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                        <span class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-base md:text-lg shadow">5</span>
                        <h3 class="text-xl md:text-2xl font-semibold text-purple-800">Rekomendasi Obat</h3>
                        <i class="fas fa-award text-purple-600 text-lg md:text-xl"></i>
                    </div>
                    <!-- Top Recommendation -->
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl p-4 md:p-6 mb-6 md:mb-8 shadow-lg flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="p-2 md:p-3 bg-white/10 rounded-2xl">
                                <i class="fas fa-crown text-xl md:text-2xl text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm md:text-base font-medium opacity-90 text-white mb-1">Rekomendasi Utama</p>
                                <h2 class="text-xl md:text-2xl font-bold text-white">{{ array_key_first($skor) }}</h2>
                                <p class="text-xs md:text-sm opacity-90 text-white">Skor: {{ number_format($skor[array_key_first($skor)], 4) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl md:text-3xl font-bold text-white drop-shadow">#1</div>
                            <p class="text-xs md:text-sm opacity-90 mt-1 text-white">Ranking Tertinggi</p>
                        </div>
                    </div>
                    <!-- Ranking Table -->
                    <div class="overflow-x-auto rounded-xl border border-purple-100 shadow-md px-4 mb-4">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-purple-600/5">
                                <tr>
                                    <th class="px-3 md:px-4 py-2 md:py-3 text-center font-semibold text-purple-900">Rank</th>
                                    <th class="px-3 md:px-4 py-2 md:py-3 text-left font-semibold text-purple-900">Nama Obat</th>
                                    <th class="px-3 md:px-4 py-2 md:py-3 text-left font-semibold text-purple-900">Skor Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-purple-100/50">
                                @php $rank = 1; @endphp
                                @foreach($skor as $obat => $nilai)
                                <tr class="hover:bg-purple-50/30 transition-colors">
                                    <td class="px-3 md:px-4 py-2 md:py-3 align-middle">
                                        <div class="flex items-center justify-center h-full">
                                            <span class="inline-block w-6 h-6 md:w-8 md:h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-xs md:text-base shadow">{{ $rank++ }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-4 py-2 md:py-3 font-medium text-gray-800 flex items-center gap-2 align-middle">
                                        <i class="fas fa-capsules text-purple-600 text-xs md:text-base"></i>
                                        {{ $obat }}
                                    </td>
                                    <td class="px-3 md:px-4 py-2 md:py-3 text-purple-800 font-medium align-middle">
                                        {{ number_format($nilai, 4) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- Card Kesimpulan -->
        @if($selectedPenyakit)
        <div class="w-full mt-6 md:mt-8 mb-6 md:mb-8 p-4 md:p-6 px-4 bg-gradient-to-r from-green-100 to-blue-100 rounded-xl shadow-md flex items-start gap-3 md:gap-4 border border-green-200">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-green-500 text-2xl md:text-3xl"></i>
            </div>
            <div>
                <h3 class="text-base md:text-xl font-bold text-green-800 mb-1 md:mb-2">Kesimpulan</h3>
                <p class="text-sm md:text-base text-gray-700 mb-1 leading-relaxed text-justify">Berdasarkan hasil perhitungan Fuzzy AHP, <span class="font-semibold text-green-700">{{ array_key_first($skor) }}</span> memperoleh skor tertinggi (<span class="font-mono">{{ number_format($skor[array_key_first($skor)], 4) }}</span>) dan direkomendasikan sebagai pilihan utama untuk <span class="font-semibold text-green-700">Penyakit {{ $selectedPenyakit->nama_penyakit ?? '-' }}</span>.</p>
            </div>
        </div>
        @endif
        <!-- Footer Note -->
        <div class="w-full mt-6 md:mt-10 p-4 md:p-6 px-4 bg-blue-50/60 rounded-xl text-sm md:text-base text-blue-800 flex items-start gap-3 md:gap-4 border border-blue-100 shadow-md">
            <i class="fas fa-info-circle text-blue-600 mt-1 text-xl md:text-2xl"></i>
            <div>
                <span class="font-semibold">Penting:</span> <span class="leading-relaxed text-justify">Hasil analisis bersifat rekomendasi sistem. Selalu konsultasikan dengan tenaga medis profesional sebelum menentukan pengobatan.</span>
                <a href="{{ route('spk.perhitungan-skor') }}" class="mt-2 inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Analisis Penyakit Lain
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Enhanced Chart Styling
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top', labels: { font: { size: 13 } } },
            tooltip: { bodyFont: { size: 13 }, titleFont: { size: 14 } }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#e5e7eb' }, ticks: { font: { size: 12 } } },
            x: { grid: { display: false }, ticks: { font: { size: 12 } } }
        }
    };
    @if(isset($crisp) && count($crisp))
    const defuzzData = @json(array_map(function($arr) { return count($arr) ? array_sum($arr)/count($arr) : 0; }, $crisp));
    new Chart(document.getElementById('defuzzChart'), {
        type: 'bar',
        data: {
            labels: @json(array_keys($crisp)),
            datasets: [{
                label: 'Nilai Defuzzifikasi',
                data: defuzzData,
                backgroundColor: '#3B82F6',
                borderRadius: 8,
                hoverBackgroundColor: '#2563EB'
            }]
        },
        options: chartOptions
    });
    @endif
    @if(isset($skor))
    new Chart(document.getElementById('skorChart'), {
        type: 'pie',
        data: {
            labels: @json(array_keys($skor)),
            datasets: [{
                data: @json(array_values($skor)),
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#6366F1', '#EC4899', '#14B8A6'],
                borderWidth: 0
            }]
        },
        options: {
            ...chartOptions,
            plugins: {
                legend: { position: 'right', labels: { font: { size: 13 } } },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw.toFixed(4)}` }, bodyFont: { size: 13 }, titleFont: { size: 14 } }
            }
        }
    });
    @endif
</script>
@endsection