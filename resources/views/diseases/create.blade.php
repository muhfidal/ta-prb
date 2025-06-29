@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div class="space-y-2">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Penyakit</h2>
            <p class="text-gray-600">Tambahkan data penyakit baru ke dalam sistem</p>
        </div>
        <div class="flex items-center">
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-disease text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Form Tambah Penyakit
            </h3>
        </div>

        <div class="p-6">
            <form action="{{ route('diseases.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Nama Penyakit -->
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-tag text-gray-400 mr-1"></i>
                            Nama Penyakit
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="block w-full rounded-lg border-gray-300 pl-4 pr-12 focus:ring-blue-500 focus:border-blue-500 text-gray-700"
                                   placeholder="Masukkan nama penyakit">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-pen text-gray-400"></i>
                            </div>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-align-left text-gray-400 mr-1"></i>
                            Deskripsi
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <textarea name="description"
                                      rows="4"
                                      class="block w-full rounded-lg border-gray-300 pl-4 pr-12 focus:ring-blue-500 focus:border-blue-500 text-gray-700"
                                      placeholder="Masukkan deskripsi penyakit">{{ old('description') }}</textarea>
                            <div class="absolute top-0 right-0 mt-2 mr-3">
                                <i class="fas fa-paragraph text-gray-400"></i>
                            </div>
                        </div>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                    <a href="{{ route('diseases.index') }}"
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-colors flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Form Styles */
    .form-group {
        position: relative;
    }

    .form-group input:focus ~ .icon,
    .form-group textarea:focus ~ .icon {
        color: #3b82f6;
    }

    /* Input Focus Styles */
    .focus-within\:ring-2:focus-within {
        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
        --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
    }

    /* Transition Styles */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
@endpush
@endsection
