@extends('layouts.app')

@section('content')
<x-card title="Edit Obat" class="rounded-xl shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div class="space-y-2">
            <h2 class="text-2xl font-bold text-gray-800">Edit Data Obat</h2>
            <p class="text-gray-600">Ubah informasi obat sesuai kebutuhan</p>
        </div>
    </div>

    <form action="{{ route('medicines.update', $medicine) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Obat</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-barcode text-gray-400"></i>
                        </div>
                        <input type="text"
                               name="code"
                               value="{{ old('code', $medicine->code) }}"
                               class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                               placeholder="Masukkan kode obat">
                    </div>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Obat</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-pills text-gray-400"></i>
                        </div>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $medicine->name) }}"
                               class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                               placeholder="Masukkan nama obat">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-box text-gray-400"></i>
                        </div>
                        <select name="unit"
                                class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                            <option value="">Pilih satuan</option>
                            <option value="Tablet" {{ old('unit', $medicine->unit) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Kapsul" {{ old('unit', $medicine->unit) == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                            <option value="Sirup" {{ old('unit', $medicine->unit) == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                            <option value="Salep" {{ old('unit', $medicine->unit) == 'Salep' ? 'selected' : '' }}>Salep</option>
                            <option value="Ampul" {{ old('unit', $medicine->unit) == 'Ampul' ? 'selected' : '' }}>Ampul</option>
                            <option value="Vial" {{ old('unit', $medicine->unit) == 'Vial' ? 'selected' : '' }}>Vial</option>
                        </select>
                    </div>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <div class="relative">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <i class="fas fa-align-left text-gray-400"></i>
                        </div>
                        <textarea name="description"
                                  rows="4"
                                  class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                  placeholder="Masukkan deskripsi obat">{{ old('description', $medicine->description) }}</textarea>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="is_prb" class="block mb-2 font-semibold text-gray-700">Obat untuk Gejala Tambahan?</label>
                    <select name="is_prb" id="is_prb" class="form-select w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="0" {{ old('is_prb', $medicine->is_prb) == '0' ? 'selected' : '' }}>Bukan Obat Gejala Tambahan</option>
                        <option value="1" {{ old('is_prb', $medicine->is_prb) == '1' ? 'selected' : '' }}>Obat Gejala Tambahan</option>
                    </select>
                </div>
                <div id="dosis-jumlah-group" style="display: {{ old('is_prb', $medicine->is_prb) == '1' ? '' : 'none' }};">
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dosis</label>
                            <input type="text" name="dose" id="dose"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                   placeholder="Masukkan dosis, contoh: 3x10mg"
                                   value="{{ old('dose', $medicine->dose) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="number" name="quantity" id="quantity"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                   placeholder="Masukkan jumlah, contoh: 10"
                                   value="{{ old('quantity', $medicine->quantity) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t">
            <x-button variant="secondary" href="{{ route('medicines.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700">
                <i class="fas fa-times mr-2"></i> Batal
            </x-button>
            <x-button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </x-button>
        </div>
    </form>
</x-card>

@push('styles')
<style>
    .form-input:focus, .form-textarea:focus, .form-select:focus {
        @apply ring-2 ring-blue-200 border-blue-500;
    }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('is_prb').addEventListener('change', function() {
    var value = this.value;
    var group = document.getElementById('dosis-jumlah-group');
    if (value === '1') {
        group.style.display = '';
    } else {
        group.style.display = 'none';
        document.getElementById('dose').value = '';
        document.getElementById('quantity').value = '';
    }
});
</script>
@endpush
@endsection
