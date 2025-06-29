@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">{{ isset($kriteria) ? 'Edit' : 'Tambah' }} Kriteria</h2>

    <form action="{{ isset($kriteria) ? route('kriteria.update', $kriteria->id) : route('kriteria.store') }}" method="POST">
        @csrf
        @if(isset($kriteria))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kriteria</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $kriteria->nama ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required>
            @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('kriteria.index') }}" class="mr-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                {{ isset($kriteria) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
