@extends('layouts.app')

@section('content')
<x-card title="Laporan Pengambilan Obat">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nama Pasien
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Obat
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tanggal Pengambilan
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($patients as $patient)
                @foreach($patient->medicineHistories as $history)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $patient->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $history->medicine->name ?? 'Nama obat tidak tersedia' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($history->taken_at)->format('d M Y') ?? 'Tanggal tidak tersedia' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</x-card>
@endsection
