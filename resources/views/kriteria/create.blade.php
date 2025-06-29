@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        <h1 class="text-3xl font-bold text-blue-800 mb-8 flex items-center gap-2">
            <i class="fas fa-balance-scale text-blue-500"></i>
            Tambah Kriteria
        </h1>

        <x-form action="{{ route('kriteria.store') }}" method="POST">
            <x-form.input
                name="nama_kriteria"
                label="Nama Kriteria"
                placeholder="Masukkan nama kriteria"
                required
            />

            <x-form.textarea
                name="deskripsi"
                label="Deskripsi"
                placeholder="Deskripsi kriteria..."
                rows="3"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form.input
                    type="number"
                    name="nilai_minimum"
                    label="Nilai Minimum"
                    placeholder="1"
                    step="0.01"
                />

                <x-form.input
                    type="number"
                    name="nilai_maksimum"
                    label="Nilai Maksimum"
                    placeholder="10"
                    step="0.01"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-form.input
                        name="fuzzy_set"
                        label="Fuzzy Set"
                        placeholder="Contoh: 1,5,10"
                    />
                    <span class="text-xs text-gray-500">Contoh: "1,2,3" (pisahkan dengan koma)</span>
                </div>

                <x-form.select
                    name="tipe_kriteria"
                    label="Tipe Kriteria"
                    :options="[
                        '' => '-- Pilih Tipe --',
                        'Benefit' => 'Benefit',
                        'Cost' => 'Cost'
                    ]"
                />
            </div>

            <div class="flex justify-end gap-2 mt-8">
                <a href="{{ route('kriteria.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg border border-gray-300 transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </x-form>
    </div>
</div>
@endsection
