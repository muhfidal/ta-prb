@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold text-gray-800">Edit Resep</h2>
                <p class="text-sm text-gray-600">Ubah informasi resep sesuai kebutuhan</p>
            </div>
            <a href="{{ route('prescriptions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('prescriptions.update', $prescription) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        @method('PUT')
        <div class="p-6 space-y-6">
            <!-- Nomor Resep -->
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-file-medical text-blue-500 mr-2"></i>
                        Nomor Resep
                    </h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Otomatis
                    </span>
                </div>
                <div class="max-w-xl">
                    <input type="text" value="{{ $prescription->prescription_number }}"
                           class="w-full bg-gray-50 rounded-lg border-gray-200 text-gray-600 cursor-not-allowed font-medium"
                           disabled>
                </div>
            </div>

            <!-- Informasi Pasien -->
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user-circle text-indigo-500 mr-2"></i>
                        Informasi Pasien
                    </h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Data Terkunci
                    </span>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Informasi pasien tidak dapat diubah pada halaman edit resep. Jika ingin membuat resep untuk pasien lain, silakan buat resep baru.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="max-w-xl bg-gray-50 rounded-lg p-4">
                    <input type="hidden" name="patient_id" value="{{ $prescription->patient_id }}">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama Lengkap</p>
                            <p class="font-medium text-gray-900">{{ $prescription->patient->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nomor BPJS</p>
                            <p class="font-medium text-gray-900">{{ $prescription->patient->no_bpjs ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Kelamin</p>
                            <p class="font-medium text-gray-900">{{ $prescription->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Lahir</p>
                            <p class="font-medium text-gray-900">{{ $prescription->patient->birth_date ?: '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Alamat</p>
                            <p class="font-medium text-gray-900">{{ $prescription->patient->address ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Diagnosa Penyakit -->
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-virus text-yellow-500 mr-2"></i>
                        Diagnosa Penyakit
                    </h3>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Minimal 1 diagnosa
                    </span>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Anda dapat menambah atau mengurangi diagnosa penyakit sesuai kebutuhan.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="disease-list" class="space-y-4">
                    @foreach($prescription->diseases as $prescriptionDisease)
                        <div class="disease-item bg-gray-50 rounded-lg p-3 md:p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                                <div>
                                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                        <i class="fas fa-file-medical text-gray-400 mr-1"></i>
                                        Nama Penyakit
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <select name="disease_id[]"
                                                class="disease-select w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-xs md:text-sm">
                                            <option value="">Pilih Penyakit</option>
                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}" {{ $prescriptionDisease->id == $disease->id ? 'selected' : '' }}>
                                                    {{ $disease->name }}
                                                </option>
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
                    @endforeach
                </div>
                <div class="mt-4">
                    <button type="button" onclick="addDiseaseField()"
                            class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Penyakit
                    </button>
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
                    @foreach($prescription->medicines as $prescriptionMedicine)
                        <div class="medicine-item bg-gray-50 rounded-lg p-3 md:p-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4">
                                <div>
                                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                        <i class="fas fa-capsules text-gray-400 mr-1"></i>
                                        Nama Obat
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <select name="medicines[{{ $loop->index }}][id]" class="medicine-select w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-xs md:text-sm">
                                            <option value="">Pilih Obat</option>
                                            @foreach($medicines as $medicine)
                                                <option value="{{ $medicine->id }}" {{ $prescriptionMedicine->medicine_id == $medicine->id ? 'selected' : '' }}>
                                                    {{ $medicine->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" onclick="removeMedicineField(this)"
                                                class="remove-medicine-btn inline-flex items-center p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Dosis</label>
                                    <input type="text" name="medicines[{{ $loop->index }}][dosage]" value="{{ $prescriptionMedicine->pivot->dosage }}" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-xs md:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Jumlah</label>
                                    <input type="number" name="medicines[{{ $loop->index }}][quantity]" value="{{ $prescriptionMedicine->pivot->quantity }}" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-xs md:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Catatan</label>
                                    <input type="text" name="medicines[{{ $loop->index }}][notes]" value="{{ $prescriptionMedicine->pivot->notes }}" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-xs md:text-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                          class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ old('notes', $prescription->notes) }}</textarea>
            </div>

            <!-- Prescription Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="prescription_date" class="block text-sm font-medium text-gray-700">Tanggal Resep</label>
                    <input type="datetime-local" name="prescription_date" id="prescription_date"
                        value="{{ old('prescription_date', \Carbon\Carbon::parse($prescription->prescription_date)->format('Y-m-d\TH:i')) }}"
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
        color: #4b5563; /* text-gray-700, warna teks input */
        line-height: inherit; /* Biarkan inherit atau 1.5rem (24px) untuk Tailwind default */
        padding-left: 0 !important;
        padding-right: 0 !important;
        flex-grow: 1;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        position: absolute;
        top: 0;
        right: 0.75rem; /* Sesuaikan posisi panah agar sama dengan padding input */
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #6b7280 transparent transparent transparent; /* Warna panah, text-gray-500 */
        border-style: solid;
        border-width: 5px 4px 0 4px;
        height: 0;
        left: 50%;
        margin-left: -4px;
        margin-top: 0; /* Ubah ke 0, karena align-items: center di parent */
        position: absolute;
        top: 50%;
        width: 0;
    }

    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #6b7280 transparent; /* Warna panah saat terbuka */
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
    let medicineCount = {{ count($prescription->medicines) }};
    let diseaseCount = {{ count($prescription->diseases) }};

    function addDiseaseField() {
        const template = `
            <div class="disease-item bg-gray-50 rounded-lg p-3 md:p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            <i class="fas fa-file-medical text-gray-400 mr-1"></i>
                            Nama Penyakit
                        </label>
                        <div class="flex items-center gap-2">
                            <select name="disease_id[]" class="disease-select w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-xs md:text-sm">
                                <option value="">Pilih Penyakit</option>
                                @foreach($diseases as $disease)
                                    <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="removeDiseaseField(this)"
                                    class="remove-disease-btn inline-flex items-center p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors text-xs md:text-sm">
                                <i class="fas fa-trash text-sm"></i>
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

    function addMedicineField() {
        const template = `
            <div class="medicine-item bg-gray-50 rounded-lg p-3 md:p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4">
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            <i class="fas fa-capsules text-gray-400 mr-1"></i>
                            Nama Obat
                        </label>
                        <div class="flex items-center gap-2">
                            <select name="medicines[${medicineCount}][id]" class="medicine-select w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-xs md:text-sm">
                                <option value="">Pilih Obat</option>
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="removeMedicineField(this)"
                                    class="remove-medicine-btn inline-flex items-center p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Dosis</label>
                        <input type="text" name="medicines[${medicineCount}][dosage]" placeholder="Contoh: 3x1 sehari"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-xs md:text-sm">
                    </div>
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Jumlah</label>
                        <input type="number" name="medicines[${medicineCount}][quantity]" placeholder="Masukkan jumlah"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-xs md:text-sm">
                    </div>
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Catatan</label>
                        <input type="text" name="medicines[${medicineCount}][notes]" placeholder="Contoh: Diminum setelah makan"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-xs md:text-sm">
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

    function updateRemoveButtons() {
        const diseaseItems = document.querySelectorAll('.disease-item');
        const medicineItems = document.querySelectorAll('.medicine-item');

        diseaseItems.forEach(item => {
            const removeBtn = item.querySelector('.remove-disease-btn');
            if (removeBtn) { // Pastikan tombol ada sebelum mengakses propertinya
                if (diseaseItems.length === 1) {
                    removeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    removeBtn.disabled = true;
                } else {
                    removeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    removeBtn.disabled = false;
                }
            }
        });

        medicineItems.forEach(item => {
            const removeBtn = item.querySelector('.remove-medicine-btn');
            if (removeBtn) { // Pastikan tombol ada sebelum mengakses propertinya
                if (medicineItems.length === 1) {
                    removeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    removeBtn.disabled = true;
                } else {
                    removeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    removeBtn.disabled = false;
                }
            }
        });
    }

    $(document).ready(function() {
        // Inisialisasi Select2 untuk pemilihan Penyakit
        $('.disease-select').each(function() {
            $(this).select2({
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
            // Pemicu perubahan untuk memastikan nilai yang sudah terpilih ditampilkan
            $(this).val($(this).find('option[selected]').val()).trigger('change');
        });

        // Inisialisasi Select2 untuk pemilihan Obat
        $('.medicine-select').each(function() {
            $(this).select2({
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
            // Pemicu perubahan untuk memastikan nilai yang sudah terpilih ditampilkan
            $(this).val($(this).find('option[selected]').val()).trigger('change');
        });

        // Panggil fungsi updateRemoveButtons saat halaman dimuat
        updateRemoveButtons();
    });
</script>
@endpush
@endsection
