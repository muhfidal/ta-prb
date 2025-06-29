@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section with Progress Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold text-gray-800">Buat Resep Baru</h2>
                <p class="text-sm text-gray-600">Isi informasi resep dengan lengkap dan benar</p>
            </div>
            <a href="{{ route('prescriptions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Progress Steps -->
        <div class="mt-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Pasien</p>
                    </div>
                </div>
                <div class="flex-1 mx-4">
                    <div class="h-1 bg-indigo-500"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center">
                        <i class="fas fa-virus"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Diagnosa</p>
                    </div>
                </div>
                <div class="flex-1 mx-4">
                    <div class="h-1 bg-indigo-500"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Obat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <form action="{{ route('prescriptions.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        <div class="p-6 space-y-6">
            <!-- Informasi Pasien -->
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user-circle text-indigo-500 mr-2"></i>
                        Informasi Pasien
                    </h3>
                    @if(request()->has('patient_id'))
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            Data Terkunci
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            Wajib diisi
                        </span>
                    @endif
                </div>

                @if(request()->has('patient_id'))
                    @php
                        $patient = App\Models\Patient::find(request()->get('patient_id'));
                    @endphp
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Data pasien telah dipilih dan tidak dapat diubah. Jika ingin membuat resep untuk pasien lain, silakan kembali ke halaman sebelumnya.
                                </p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-user text-blue-500"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 block">Nama Pasien:</span>
                                    <span class="text-gray-900">{{ $patient->name }}</span>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-id-card text-blue-500"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 block">No BPJS:</span>
                                    <span class="text-gray-900">{{ $patient->no_bpjs ?: '-' }}</span>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-map-marker-alt text-blue-500"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 block">Alamat:</span>
                                    <span class="text-gray-900">{{ $patient->address ?: '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-venus-mars text-blue-500"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 block">Jenis Kelamin:</span>
                                    <span class="text-gray-900">{{ $patient->gender ?: '-' }}</span>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-birthday-cake text-blue-500"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 block">Tanggal Lahir:</span>
                                    <span class="text-gray-900">{{ $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Cari pasien berdasarkan nama atau nomor BPJS. Pastikan data pasien yang dipilih sudah benar.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-xl">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="patientSearch" placeholder="Ketik nama atau nomor BPJS pasien..."
                                   class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                   onkeyup="searchPatients()">
                            <input type="hidden" name="patient_id" id="patientId">
                            <!-- Dropdown Results -->
                            <div id="patientResults" class="hidden absolute w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="overflow-y-auto" style="max-height: 240px;">
                                    <!-- Hasil pencarian akan ditampilkan di sini -->
                                </div>
                            </div>
                        </div>
                        @error('patient_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preview Section -->
                    <div id="patientPreview" class="hidden mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-user text-blue-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 block">Nama Pasien:</span>
                                        <span id="previewPatientName" class="text-gray-900"></span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-id-card text-blue-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 block">No BPJS:</span>
                                        <span id="previewPatientBPJS" class="text-gray-900"></span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-map-marker-alt text-blue-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 block">Alamat:</span>
                                        <span id="previewPatientAddress" class="text-gray-900"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-venus-mars text-blue-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 block">Jenis Kelamin:</span>
                                        <span id="previewPatientGender" class="text-gray-900"></span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-birthday-cake text-blue-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700 block">Tanggal Lahir:</span>
                                        <span id="previewPatientDOB" class="text-gray-900"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Diagnosa Penyakit -->
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-virus text-yellow-500 mr-2"></i>
                        Diagnosa Penyakit
                    </h3>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Wajib diisi
                    </span>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Pilih penyakit yang diderita pasien.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="max-w-xl">
                    <div id="disease-list" class="space-y-4">
                        <div class="disease-item bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-virus text-gray-400 mr-1"></i>
                                        Nama Penyakit
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <select name="disease_id[]" class="disease-select w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                            <option value="">Pilih Penyakit</option>
                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" onclick="removeDiseaseField(this)"
                                                class="remove-disease-btn inline-flex items-center p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" onclick="addDiseaseField()"
                                class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Penyakit
                        </button>
                    </div>
                    @error('disease_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Resep Obat -->
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-pills text-green-500 mr-2"></i>
                        Resep Obat
                    </h3>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Minimal 1 obat
                    </span>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm text-blue-700">
                                <p class="mb-1">Panduan pengisian resep obat:</p>
                                <ul class="list-disc pl-4 space-y-1">
                                    <li>Pilih obat dari daftar yang tersedia</li>
                                    <li>Isi dosis dengan format yang benar (misal: 3x1 sehari)</li>
                                    <li>Masukkan jumlah obat dalam angka</li>
                                    <li>Tambahkan catatan jika ada (misal: diminum setelah makan)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="medicine-list" class="space-y-4">
                    <div class="medicine-item bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-capsules text-gray-400 mr-1"></i>
                                    Nama Obat
                                </label>
                                <select name="medicines[0][id]" class="medicine-select w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                    <option value="">Pilih Obat</option>
                                    @foreach($medicines as $medicine)
                                        <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-prescription text-gray-400 mr-1"></i>
                                    Dosis
                                </label>
                                <input type="text" name="medicines[0][dosage]" placeholder="Contoh: 3x1 sehari"
                                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-sort-numeric-up text-gray-400 mr-1"></i>
                                    Jumlah
                                </label>
                                <input type="number" name="medicines[0][quantity]" placeholder="Masukkan jumlah"
                                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-sticky-note text-gray-400 mr-1"></i>
                                    Catatan
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text" name="medicines[0][notes]" placeholder="Contoh: Diminum setelah makan"
                                           class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                    <button type="button" onclick="removeMedicineField(this)"
                                            class="remove-medicine-btn inline-flex items-center p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" onclick="addMedicineField()"
                            class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Obat
                    </button>
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clipboard text-blue-500 mr-2"></i>
                        Catatan Tambahan
                    </h3>
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Opsional
                    </span>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Tambahkan catatan khusus atau instruksi tambahan untuk resep ini jika diperlukan.
                            </p>
                        </div>
                    </div>
                </div>

                <textarea name="notes" rows="3" placeholder="Tambahkan catatan untuk resep ini (opsional)"
                          class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ old('notes') }}</textarea>
            </div>

            <!-- Prescription Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="prescription_date" class="block text-sm font-medium text-gray-700">Tanggal Resep</label>
                    <input type="datetime-local" name="prescription_date" id="prescription_date"
                        value="{{ old('prescription_date', now()->format('Y-m-d\TH:i')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('prescription_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="window.location.href='{{ route('prescriptions.index') }}'"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Resep
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        border-color: #d1d5db !important;
        border-radius: 0.5rem !important;
        min-height: 42px !important;
        padding: 0.5rem 0.75rem !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 150ms ease-in-out !important;
        display: flex !important;
        align-items: center !important;
        box-sizing: border-box !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #4b5563;
        line-height: inherit;
        padding-left: 0 !important;
        padding-right: 0 !important;
        flex-grow: 1;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        position: absolute;
        top: 0;
        right: 0.75rem;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #6b7280 transparent transparent transparent;
        border-style: solid;
        border-width: 5px 4px 0 4px;
        height: 0;
        left: 50%;
        margin-left: -4px;
        margin-top: 0;
        position: absolute;
        top: 50%;
        width: 0;
    }

    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #6b7280 transparent;
        border-width: 0 4px 5px 4px;
    }

    .select2-container--default .select2-selection--multiple {
        border-color: #d1d5db !important;
        border-radius: 0.5rem !important;
        min-height: 42px !important;
        padding: 2px 8px !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 150ms ease-in-out !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2) !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #eef2ff !important;
        border: 1px solid #e0e7ff !important;
        border-radius: 0.375rem !important;
        padding: 2px 8px !important;
        margin: 4px 4px !important;
        color: #4f46e5 !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #4f46e5 !important;
        margin-right: 5px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        background-color: #4f46e5 !important;
        color: white !important;
    }

    .select2-dropdown {
        border-color: #e5e7eb !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #eef2ff !important;
        color: #4f46e5 !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.375rem !important;
        padding: 8px !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #6366f1 !important;
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2) !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let medicineCount = 1;
    let diseaseCount = 1;

    function searchPatients() {
        const searchTerm = document.getElementById('patientSearch').value;
        const resultsDiv = document.getElementById('patientResults');

        if (searchTerm.length < 2) {
            resultsDiv.classList.add('hidden');
            return;
        }

        // Tampilkan loading state
        resultsDiv.innerHTML = `
            <div class="p-3 text-center text-gray-500">
                <i class="fas fa-spinner fa-spin mr-2"></i> Mencari...
            </div>
        `;
        resultsDiv.classList.remove('hidden');

        // Lakukan pencarian
        fetch(`/patients/search?q=${encodeURIComponent(searchTerm)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            resultsDiv.innerHTML = '';

            if (data.length === 0) {
                resultsDiv.innerHTML = `
                    <div class="p-3 text-center text-gray-500">
                        <p>Tidak ada hasil ditemukan</p>
                    </div>
                `;
                return;
            }

            data.forEach(patient => {
                const div = document.createElement('div');
                div.className = 'patient-item p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0';
                div.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">${patient.name}</p>
                            <p class="text-sm text-gray-500">BPJS: ${patient.no_bpjs || 'Tidak ada BPJS'}</p>
                        </div>
                        ${patient.has_prescription ?
                            '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Sudah memiliki resep</span>' :
                            '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Belum memiliki resep</span>'
                        }
                    </div>
                `;

                div.onclick = () => {
                    if (patient.has_prescription) {
                        alert('Pasien ini sudah memiliki resep. Silakan edit resep yang sudah ada atau hapus resep lama terlebih dahulu.');
                        return;
                    }
                    selectPatient(patient);
                };

                resultsDiv.appendChild(div);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.innerHTML = `
                <div class="p-3 text-center text-red-500">
                    <p>Terjadi kesalahan saat mencari data</p>
                </div>
            `;
        });
    }

    function selectPatient(patient) {
        document.getElementById('patientId').value = patient.id;
        document.getElementById('patientSearch').value = patient.name;
        document.getElementById('patientResults').classList.add('hidden');

        // Update preview
        document.getElementById('previewPatientName').textContent = patient.name;
        document.getElementById('previewPatientBPJS').textContent = patient.no_bpjs || '-';
        document.getElementById('previewPatientGender').textContent = patient.gender === 'L' ? 'Laki-laki' : 'Perempuan';
        document.getElementById('previewPatientAddress').textContent = patient.address || '-';
        document.getElementById('previewPatientDOB').textContent = patient.birth_date ? new Date(patient.birth_date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }) : '-';

        document.getElementById('patientPreview').classList.remove('hidden');
    }

    // Close patient results when clicking outside
    document.addEventListener('click', function(e) {
        const resultsDiv = document.getElementById('patientResults');
        const searchInput = document.getElementById('patientSearch');

        if (e.target !== searchInput && !resultsDiv.contains(e.target)) {
            resultsDiv.classList.add('hidden');
        }
    });

    function addMedicineField() {
        const template = `
            <div class="medicine-item bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-capsules text-gray-400 mr-1"></i>
                            Nama Obat
                        </label>
                        <select name="medicines[${medicineCount}][id]" class="medicine-select w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                            <option value="">Pilih Obat</option>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-prescription text-gray-400 mr-1"></i>
                            Dosis
                        </label>
                        <input type="text" name="medicines[${medicineCount}][dosage]" placeholder="Contoh: 3x1 sehari"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sort-numeric-up text-gray-400 mr-1"></i>
                            Jumlah
                        </label>
                        <input type="number" name="medicines[${medicineCount}][quantity]" placeholder="Masukkan jumlah"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note text-gray-400 mr-1"></i>
                            Catatan
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="medicines[${medicineCount}][notes]" placeholder="Contoh: Diminum setelah makan"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                            <button type="button" onclick="removeMedicineField(this)"
                                    class="remove-medicine-btn inline-flex items-center p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('medicine-list').insertAdjacentHTML('beforeend', template);
        // Inisialisasi Select2 untuk select baru
        $('.medicine-select:last').select2({
            placeholder: 'Pilih Obat',
            allowClear: true,
            language: {
                noResults: function() {
                    return "Tidak ada obat yang ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        });
        medicineCount++;
        updateRemoveButtons();
    }

    function removeMedicineField(button) {
        button.closest('.medicine-item').remove();
        updateRemoveButtons();
    }

    function addDiseaseField() {
        const template = `
            <div class="disease-item bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-virus text-gray-400 mr-1"></i>
                            Nama Penyakit
                        </label>
                        <div class="flex items-center gap-2">
                            <select name="disease_id[]" class="disease-select w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                <option value="">Pilih Penyakit</option>
                                @foreach($diseases as $disease)
                                    <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="removeDiseaseField(this)"
                                    class="remove-disease-btn inline-flex items-center p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('disease-list').insertAdjacentHTML('beforeend', template);
        // Inisialisasi Select2 untuk select baru
        $('.disease-select:last').select2({
            placeholder: 'Pilih Penyakit',
            allowClear: true,
            closeOnSelect: false,
            language: {
                noResults: function() {
                    return "Tidak ada penyakit yang ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        });
        diseaseCount++;
        updateRemoveButtons();
    }

    function removeDiseaseField(button) {
        button.closest('.disease-item').remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const diseaseItems = document.querySelectorAll('.disease-item');
        const medicineItems = document.querySelectorAll('.medicine-item');

        diseaseItems.forEach(item => {
            const removeBtn = item.querySelector('.remove-disease-btn');
            if (diseaseItems.length === 1) {
                removeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                removeBtn.disabled = true;
            } else {
                removeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                removeBtn.disabled = false;
            }
        });

        medicineItems.forEach(item => {
            const removeBtn = item.querySelector('.remove-medicine-btn');
            if (medicineItems.length === 1) {
                removeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                removeBtn.disabled = true;
            } else {
                removeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                removeBtn.disabled = false;
            }
        });
    }

    $(document).ready(function() {
        // Inisialisasi Select2 untuk pemilihan Penyakit
        $('.disease-select').select2({
            placeholder: 'Pilih Penyakit',
            allowClear: true,
            closeOnSelect: false,
            language: {
                noResults: function() {
                    return "Tidak ada penyakit yang ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        });

        // Inisialisasi Select2 untuk pemilihan Obat
        $('.medicine-select').select2({
            placeholder: 'Pilih Obat',
            allowClear: true,
            language: {
                noResults: function() {
                    return "Tidak ada obat yang ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        });

        // Panggil fungsi updateRemoveButtons saat halaman dimuat
        updateRemoveButtons();
    });
</script>
@endpush
@endsection
