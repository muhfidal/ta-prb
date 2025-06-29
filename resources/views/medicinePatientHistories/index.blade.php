@extends('layouts.app')

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
@endphp
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 mt-4 mr-4 bg-white bg-opacity-20 rounded-lg p-2">
            <i class="fas fa-calendar-alt text-white mr-2"></i>
            <span class="text-white text-sm">{{ hariIndonesia(now()) }}</span>
            <span class="text-white text-sm ml-2">{{ waktuIndonesia(now()) }}</span>
        </div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Riwayat Pengambilan Obat</h1>
            <p class="text-blue-100 text-lg">Pencatatan dan monitoring pengambilan obat pasien PRB</p>
        </div>
        <div class="absolute bottom-0 right-0 opacity-10">
            <i class="fas fa-pills text-white text-9xl transform -rotate-12"></i>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Histori Pengambilan Obat</h1>
        </div>
    </div>

    <!-- Patient List Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Riwayat Pengambilan</h3>
                <span class="text-sm text-gray-500">Total: {{ $patients->total() ?? 0 }} data</span>
            </div>
        </div>
        <div id="patient-list" class="overflow-x-auto">
            @include('medicinePatientHistories.partials.patient_list', ['patients' => $patients])
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('patient_name').addEventListener('input', function() {
        let query = this.value;
        fetch(`{{ route('medicinePatientHistories.search') }}?query=${query}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('patient-list').innerHTML = html;
            });
    });
</script>
@endpush
@endsection
