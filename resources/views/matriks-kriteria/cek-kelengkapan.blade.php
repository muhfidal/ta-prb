@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Cek Kelengkapan Matriks Perbandingan Kriteria</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-blue-50">
                        <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kriteria</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Belum Dibandingkan Dengan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelengkapan as $kriteria => $missing)
                        <tr>
                            <td class="px-6 py-4 border-b text-sm font-medium text-gray-900">{{ $kriteria }}</td>
                            <td class="px-6 py-4 border-b text-sm text-gray-700">
                                @if(count($missing))
                                    {{ implode(', ', $missing) }}
                                @else
                                    <span class="text-green-600 font-semibold">Lengkap</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
