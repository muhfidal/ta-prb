@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Laporan Pasien</h2>
    <div class="overflow-x-auto mb-4">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nomor BPJS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Usia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Riwayat Penyakit</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($patients as $patient)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $patient->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $patient->no_bpjs }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($patient->birth_date)->age }} tahun</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $patient->gender }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @forelse($patient->prescriptions as $prescription)
                            @foreach($prescription->diseases as $disease)
                                <div>{{ $disease->name }}</div>
                            @endforeach
                        @empty
                            <div>Tidak ada data penyakit</div>
                        @endforelse
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-end mt-4">
        <a href="{{ route('reports.patients.download', 'pdf') }}" class="bg-indigo-500 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-600 transition duration-150 ease-in-out">
            Download PDF
        </a>
        <a href="{{ route('reports.patients.download', 'excel') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition duration-150 ease-in-out ml-2">
            Download Excel
        </a>
    </div>
</div>
@endsection
