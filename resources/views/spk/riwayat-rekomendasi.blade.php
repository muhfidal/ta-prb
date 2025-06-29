@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 py-4 md:py-8">
    <div class="w-full mb-4 md:mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-4 md:p-8 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-4">
                <div class="flex items-center gap-2 md:gap-4">
                    <div class="p-2 md:p-4 bg-white/10 rounded-2xl shadow">
                        <i class="fas fa-history text-2xl md:text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-4xl font-bold text-white tracking-tight mb-1">Riwayat Rekomendasi SPK</h1>
                        <p class="text-blue-100/90 text-sm md:text-lg font-normal">Semua riwayat rekomendasi yang pernah dicetak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full">
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100/60 p-4 md:p-10">
            <div class="overflow-x-auto rounded-xl border border-blue-100">
                <table class="min-w-full text-sm md:text-base">
                    <thead class="bg-blue-600/5">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-blue-900">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold text-blue-900">Pasien</th>
                            <th class="px-4 py-3 text-left font-semibold text-blue-900">Gejala/Penyakit</th>
                            <th class="px-4 py-3 text-left font-semibold text-blue-900">Rekomendasi Sistem</th>
                            <th class="px-4 py-3 text-left font-semibold text-blue-900">Obat Diambil</th>
                            <th class="px-4 py-3 text-left font-semibold text-blue-900">User</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100/50">
                        @forelse($riwayat as $item)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-4 py-3">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->patient->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @foreach($item->penyakit_ids as $pid)
                                    <span class="inline-block bg-blue-100 text-blue-700 rounded-full px-3 py-1 text-xs font-semibold mr-1 mb-1">
                                        {{ optional(\App\Models\Penyakit::find($pid))->nama_penyakit ?? $pid }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $takenMedicineNames = collect($item->taken_medicines ?? [])->pluck('nama')->toArray();
                                @endphp
                                @foreach($item->rekomendasi as $r)
                                    <div class="flex items-center gap-2 mb-1 {{ in_array($r['obat'], $takenMedicineNames) ? 'text-green-700 font-bold' : '' }}">
                                        <i class="fas {{ in_array($r['obat'], $takenMedicineNames) ? 'fa-check-circle' : 'fa-info-circle text-gray-400' }} mr-1"></i>
                                        <span class="font-semibold">{{ $r['obat'] }}</span>
                                        <span class="text-xs bg-blue-50 text-blue-600 rounded px-2 py-0.5">Skor: {{ number_format($r['skor'], 4) }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-3">
                                @if(empty($item->taken_medicines))
                                    <span class="text-gray-500 italic">Tidak ada obat diambil</span>
                                @else
                                    @foreach($item->taken_medicines as $tm)
                                        <div class="mb-1">
                                            <span class="font-semibold text-purple-700">{{ $tm['nama'] }}</span>
                                            <span class="text-xs bg-purple-50 text-purple-600 rounded px-2 py-0.5">{{ $tm['dosis'] }} / {{ $tm['jumlah'] }}</span>
                                            @if($tm['catatan'])
                                                <span class="text-xs text-gray-500">({{ $tm['catatan'] }})</span>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $item->user->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-gray-400 py-6">Belum ada riwayat rekomendasi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $riwayat->links() }}</div>
        </div>
    </div>
</div>
@endsection
