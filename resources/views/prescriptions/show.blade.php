@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-800">Detail Resep</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                        {{ $prescription->created_at->diffForHumans() }}
                    </span>
                </div>
                <p class="text-sm text-gray-600">Informasi lengkap resep obat untuk pasien {{ $prescription->patient?->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('prescriptions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <a href="{{ route('prescriptions.edit', $prescription) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Resep
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Informasi Resep dan Pasien -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Informasi Resep -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-prescription text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Resep</h3>
                </div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">Nomor Resep</p>
                            <button onclick="copyToClipboard('{{ $prescription->prescription_number }}')" class="text-indigo-600 hover:text-indigo-700">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $prescription->prescription_number }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Resep</p>
                            <p class="text-gray-700 mt-1">{{ $prescription->prescription_date->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Waktu Resep</p>
                            <p class="text-gray-700 mt-1">{{ $prescription->prescription_date->translatedFormat('H:i') }} WIB</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-gray-400"></i>
                            <p class="text-sm text-gray-500">Terakhir diperbarui {{ $prescription->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pasien -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-circle text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Data Pasien</h3>
                </div>
                <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <p class="text-lg font-medium text-gray-900">{{ $prescription->patient?->name ?? 'Pasien tidak ditemukan' }}</p>
                            @if($prescription->patient?->gender === 'L')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs">Laki-laki</span>
                            @else
                                <span class="px-2 py-1 bg-pink-100 text-pink-700 rounded-md text-xs">Perempuan</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-id-card"></i>
                            <span>BPJS: {{ $prescription->patient?->no_bpjs ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Lahir</p>
                            <div class="flex items-center gap-2 mt-1">
                                <i class="fas fa-birthday-cake text-gray-400"></i>
                                <p class="text-gray-900">{{ $prescription->patient?->birth_date ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Usia</p>
                            <div class="flex items-center gap-2 mt-1">
                                <i class="fas fa-user-clock text-gray-400"></i>
                                <p class="text-gray-900">{{ $prescription->patient?->birth_date ? \Carbon\Carbon::parse($prescription->patient->birth_date)->age . ' tahun' : '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Alamat</p>
                        <div class="flex items-start gap-2 mt-1">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1"></i>
                            <p class="text-gray-900">{{ $prescription->patient?->address ?? '-' }}</p>
                        </div>
                    </div>
                    <!-- Total Kunjungan -->
                    @if($prescription->patient)
                        <a href="{{ route('patients.visits', $prescription->patient_id) }}" class="w-full bg-blue-50 hover:bg-blue-100 rounded-lg p-4 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-history text-blue-600"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-gray-900">Total Kunjungan</p>
                                        <p class="text-2xl font-bold text-blue-600">{{ $prescription->patient->medicinePatientHistories->count() }}x</p>
                                        <p class="text-xs text-gray-500">Klik untuk melihat detail</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-blue-600"></i>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Diagnosa dan Resep -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Diagnosa Penyakit -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-virus text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Diagnosa Penyakit</h3>
                        <p class="text-sm text-gray-500">Daftar penyakit yang didiagnosa</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @forelse($prescription->diseases as $disease)
                        <div class="px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-virus text-yellow-500"></i>
                            {{ $disease->name }}
                        </div>
                    @empty
                        <div class="w-full text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clipboard-list text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 italic">Tidak ada data penyakit</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Resep Obat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pills text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Resep Obat</h3>
                                <p class="text-sm text-gray-500">Daftar obat yang diresepkan</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            Total: {{ $prescription->medicines->count() }} obat
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto hidden md:block">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($prescription->medicines as $medicine)
                                <tr>
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $medicine->name }}</td>
                                    <td class="px-6 py-4">{{ $medicine->pivot->dosage ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $medicine->pivot->quantity ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $medicine->pivot->notes ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Card List for Mobile -->
                <div class="block md:hidden space-y-3 mt-4">
                    @foreach($prescription->medicines as $medicine)
                        <div class="bg-white rounded-lg shadow p-3 border border-gray-100">
                            <div class="flex items-center mb-2">
                                <span class="font-bold text-green-700 mr-2">{{ $medicine->name }}</span>
                                <span class="ml-auto text-xs text-gray-400">{{ $medicine->pivot->quantity ?? '-' }}x</span>
                            </div>
                            <div class="text-xs text-gray-600 mb-1"><b>Dosis:</b> {{ $medicine->pivot->dosage ?? '-' }}</div>
                            <div class="text-xs text-gray-600 mb-1"><b>Catatan:</b> {{ $medicine->pivot->notes ?? '-' }}</div>
                            <div class="text-xs"><span class="inline-block px-2 py-1 rounded-full font-semibold bg-green-100 text-green-700">Aktif</span></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Catatan Resep -->
            @if($prescription->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Catatan Resep</h3>
                            <p class="text-sm text-gray-500">Informasi tambahan untuk resep ini</p>
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-quote-left text-blue-400 mt-1"></i>
                            <p class="text-gray-700 whitespace-pre-line">{{ $prescription->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Nomor resep berhasil disalin!');
    }).catch(err => {
        console.error('Gagal menyalin teks: ', err);
    });
}
</script>
@endpush

@endsection
