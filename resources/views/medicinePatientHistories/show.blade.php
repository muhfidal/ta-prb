@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-xl shadow-md p-8">
        <h1 class="text-2xl font-bold mb-4">Detail Histori Pengambilan Obat</h1>
        @if($history)
            <table class="table-auto w-full mb-4">
                <tr>
                    <td class="font-semibold">Nama Pasien</td>
                    <td>{{ $history->patient->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Nama Obat</td>
                    <td>{{ $history->medicine->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Dokter</td>
                    <td>{{ $history->doctor->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Tanggal Ambil</td>
                    <td>{{ \Carbon\Carbon::parse($history->taken_at)->translatedFormat('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Jumlah</td>
                    <td>{{ $history->quantity }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Catatan</td>
                    <td>{{ $history->notes ?? '-' }}</td>
                </tr>
            </table>
            <a href="{{ route('medicinePatientHistories.index') }}" class="btn btn-secondary">Kembali</a>
        @else
            <div class="text-red-500">Data tidak ditemukan.</div>
        @endif
    </div>
</div>
@endsection
