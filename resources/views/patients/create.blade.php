@extends('layouts.app')

@section('content')
<!-- Tambahkan CSS Select2 di bagian atas -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="max-w-4xl mx-auto">
    <div class="space-y-4 md:space-y-6 bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-8">
        <!-- Form Header -->
        <div class="border-b border-gray-100 pb-4 md:pb-6">
            <h1 class="text-lg md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-user-plus text-blue-600"></i>
                Tambah Pasien Baru
            </h1>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Lengkapi informasi pasien dengan data yang valid</p>
        </div>

        <form action="{{ route('patients.store') }}" method="POST" class="space-y-6 md:space-y-8" id="patientForm">
            @csrf

            <!-- Informasi Dasar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <!-- No BPJS -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                        <i class="fas fa-id-card text-blue-500"></i>
                        No BPJS
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                               name="no_bpjs"
                               id="no_bpjs"
                               value="{{ old('no_bpjs') }}"
                               class="w-full pl-4 pr-10 py-2 md:py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 text-sm"
                               placeholder="Contoh: 0001234567890"
                               maxlength="13"
                               pattern="\d{13}"
                               title="Nomor BPJS harus 13 digit angka"
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <small>13 digit</small>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Format: 13 digit angka tanpa spasi atau karakter khusus</p>
                    @error('no_bpjs')
                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                        <i class="fas fa-user text-blue-500"></i>
                        Nama Lengkap
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 md:py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 text-sm"
                           placeholder="Masukkan nama lengkap"
                           pattern="[A-Za-z\s']+"
                           title="Nama hanya boleh berisi huruf, spasi, dan tanda petik"
                           required>
                    <p class="text-xs text-gray-500">Gunakan huruf dan spasi, hindari angka atau karakter khusus</p>
                    @error('name')
                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-blue-500"></i>
                        Tanggal Lahir
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="birth_date"
                           id="birth_date"
                           value="{{ old('birth_date') }}"
                           class="w-full px-4 py-2 md:py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 text-sm"
                           max="{{ date('Y-m-d') }}"
                           required>
                    <p class="text-xs text-gray-500">Tanggal lahir tidak boleh lebih dari hari ini</p>
                    @error('birth_date')
                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                        <i class="fas fa-venus-mars text-blue-500"></i>
                        Jenis Kelamin
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="gender"
                            id="gender"
                            class="w-full px-4 py-2 md:py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 text-sm"
                            required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Detail Alamat -->
            <div class="space-y-6">
                <div class="border-b border-gray-100 pb-2">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-blue-500"></i>
                        Detail Alamat
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Provinsi -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-map text-blue-500"></i>
                            Provinsi
                        </label>
                        <div class="relative">
                            <select id="provinceSelect" name="address_province"
                                    class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 appearance-none">
                                <option value="">Pilih Provinsi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kabupaten/Kota -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-city text-blue-500"></i>
                            Kabupaten/Kota
                        </label>
                        <div class="relative">
                            <select id="citySelect" name="address_city"
                                    class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 appearance-none" disabled>
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kecamatan -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-building text-blue-500"></i>
                            Kecamatan
                        </label>
                        <div class="relative">
                            <select id="districtSelect" name="address_district"
                                    class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 appearance-none" disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Desa/Kelurahan -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-home text-blue-500"></i>
                            Desa/Kelurahan
                        </label>
                        <div class="relative">
                            <select id="villageSelect" name="address_village"
                                    class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200 appearance-none" disabled>
                                <option value="">Pilih Desa/Kelurahan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kode Pos -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text"
                               name="address_postal_code"
                               id="address_postal_code"
                               value="{{ old('address_postal_code') }}"
                               class="w-full px-4 py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                               placeholder="12345"
                               pattern="\d{5}"
                               maxlength="5"
                               title="Kode pos harus 5 digit angka">
                        <p class="text-xs text-gray-500">Format: 5 digit angka</p>
                    </div>

                    <!-- RT/RW -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">RT</label>
                            <input type="text"
                                   name="address_rt"
                                   id="address_rt"
                                   value="{{ old('address_rt') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                   placeholder="001"
                                   pattern="\d{3}"
                                   maxlength="3"
                                   title="RT harus 3 digit angka">
                            <p class="text-xs text-gray-500">Format: 3 digit angka</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">RW</label>
                            <input type="text"
                                   name="address_rw"
                                   id="address_rw"
                                   value="{{ old('address_rw') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                   placeholder="002"
                                   pattern="\d{3}"
                                   maxlength="3"
                                   title="RW harus 3 digit angka">
                            <p class="text-xs text-gray-500">Format: 3 digit angka</p>
                        </div>
                    </div>

                    <!-- Detail Alamat -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-medium text-gray-700">Detail Alamat (Nama Jalan/Gang/No. Rumah)</label>
                        <textarea name="address_street"
                                id="address_street"
                                rows="2"
                                class="w-full px-4 py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                placeholder="Contoh: Jl. Mawar No. 123 Gang Melati">{{ old('address_street') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Hidden field untuk gabungan alamat -->
            <input type="hidden" name="address" id="fullAddress">

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('patients.index') }}"
                   class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Custom style untuk Select2 */
    .select2-container--classic {
        width: 100% !important;
    }

    .select2-container--classic .select2-selection--single {
        height: 48px !important;
        border: 1px solid rgb(209, 213, 219) !important;
        border-radius: 0.5rem !important;
        background: white !important;
        display: flex !important;
        align-items: center !important;
    }

    .select2-container--classic .select2-selection--single .select2-selection__rendered {
        color: rgb(55, 65, 81) !important;
        line-height: 48px !important;
        padding-left: 1rem !important;
        padding-right: 2.5rem !important;
        font-size: 0.875rem !important;
    }

    .select2-container--classic .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        width: 40px !important;
        border-left: none !important;
        border-radius: 0 0.5rem 0.5rem 0 !important;
        background: transparent !important;
    }

    .select2-container--classic .select2-selection--single .select2-selection__arrow b {
        border-color: #6B7280 transparent transparent transparent !important;
    }

    .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #6B7280 transparent !important;
    }

    .select2-container--classic .select2-search--dropdown {
        padding: 0.5rem !important;
        background: white !important;
    }

    .select2-container--classic .select2-search--dropdown .select2-search__field {
        border: 1px solid rgb(209, 213, 219) !important;
        border-radius: 0.375rem !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem !important;
    }

    .select2-container--classic .select2-results__option {
        padding: 0.75rem 1rem !important;
        font-size: 0.875rem !important;
        transition: all 0.2s !important;
    }

    .select2-container--classic .select2-results__option--highlighted[aria-selected] {
        background-color: rgb(59, 130, 246) !important;
    }

    .select2-container--classic.select2-container--open .select2-dropdown {
        border-color: rgb(59, 130, 246) !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        margin-top: 4px !important;
    }

    .select2-container--classic .select2-results__option[aria-disabled=true] {
        color: rgb(156, 163, 175) !important;
        background-color: rgb(249, 250, 251) !important;
    }

    .select2-container--classic.select2-container--disabled .select2-selection--single {
        background-color: rgb(249, 250, 251) !important;
        cursor: not-allowed !important;
    }

    /* Loading state */
    .select2-container--classic .select2-results__option.loading-results {
        padding: 1rem !important;
        text-align: center !important;
        color: rgb(107, 114, 128) !important;
    }

    /* Empty state */
    .select2-container--classic .select2-results__option.select2-results__message {
        padding: 1rem !important;
        text-align: center !important;
        color: rgb(107, 114, 128) !important;
        font-style: italic !important;
    }
</style>
@endpush

@push('scripts')
<!-- Tambahkan jQuery dan Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi Select2 dengan konfigurasi yang lebih baik
    $('#provinceSelect, #citySelect, #districtSelect, #villageSelect').select2({
        theme: 'classic',
        width: '100%',
        placeholder: {
            id: '',
            text: "Ketik untuk mencari..."
        },
        allowClear: true,
        language: {
            noResults: function() {
                return "Data tidak ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        },
        templateResult: formatResult,
        templateSelection: formatSelection
    });

    // Format tampilan hasil pencarian
    function formatResult(result) {
        if (!result.id) return result.text;
        return $('<span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-blue-500"></i>' + result.text + '</span>');
    }

    // Format tampilan item yang dipilih
    function formatSelection(result) {
        if (!result.id) return result.text;
        return $('<span class="flex items-center gap-2">' + result.text + '</span>');
    }

    // Load data provinsi saat halaman dimuat
    $.ajax({
        url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
        method: 'GET',
        success: function(provinces) {
            $('#provinceSelect').empty().append('<option value="">Pilih Provinsi</option>');
            provinces.forEach(function(province) {
                $('#provinceSelect').append(new Option(province.name, province.id));
            });
        }
    });

    // Event handler untuk perubahan provinsi
    $('#provinceSelect').on('change', function() {
        const provinceId = $(this).val();
        const provinceName = $('#provinceSelect option:selected').text();
        $('#provinceName').val(provinceName);

        if (provinceId) {
            // Reset dan enable select kabupaten
            $('#citySelect').prop('disabled', false).empty().append('<option value="">Pilih Kabupaten/Kota</option>');
            // Reset select kecamatan dan desa
            $('#districtSelect, #villageSelect').prop('disabled', true).empty()
                .append('<option value="">Pilih...</option>');

            // Load data kabupaten
            $.ajax({
                url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                method: 'GET',
                success: function(cities) {
                    cities.forEach(function(city) {
                        $('#citySelect').append(new Option(city.name, city.id));
                    });
                }
            });
        } else {
            // Reset semua select di bawahnya
            $('#citySelect, #districtSelect, #villageSelect').prop('disabled', true).empty()
                .append('<option value="">Pilih...</option>');
        }
        updateFullAddress();
    });

    // Event handler untuk perubahan kabupaten
    $('#citySelect').on('change', function() {
        const cityId = $(this).val();
        const cityName = $('#citySelect option:selected').text();
        $('#cityName').val(cityName);

        if (cityId) {
            // Reset dan enable select kecamatan
            $('#districtSelect').prop('disabled', false).empty().append('<option value="">Pilih Kecamatan</option>');
            // Reset select desa
            $('#villageSelect').prop('disabled', true).empty().append('<option value="">Pilih Desa/Kelurahan</option>');

            // Load data kecamatan
            $.ajax({
                url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`,
                method: 'GET',
                success: function(districts) {
                    districts.forEach(function(district) {
                        $('#districtSelect').append(new Option(district.name, district.id));
                    });
                }
            });
        } else {
            // Reset semua select di bawahnya
            $('#districtSelect, #villageSelect').prop('disabled', true).empty()
                .append('<option value="">Pilih...</option>');
        }
        updateFullAddress();
    });

    // Event handler untuk perubahan kecamatan
    $('#districtSelect').on('change', function() {
        const districtId = $(this).val();
        const districtName = $('#districtSelect option:selected').text();
        $('#districtName').val(districtName);

        if (districtId) {
            // Reset dan enable select desa
            $('#villageSelect').prop('disabled', false).empty().append('<option value="">Pilih Desa/Kelurahan</option>');

            // Load data desa
            $.ajax({
                url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`,
                method: 'GET',
                success: function(villages) {
                    villages.forEach(function(village) {
                        $('#villageSelect').append(new Option(village.name, village.id));
                    });
                }
            });
        } else {
            // Reset select desa
            $('#villageSelect').prop('disabled', true).empty()
                .append('<option value="">Pilih Desa/Kelurahan</option>');
        }
        updateFullAddress();
    });

    // Event handler untuk perubahan desa
    $('#villageSelect').on('change', function() {
        const villageName = $('#villageSelect option:selected').text();
        $('#villageName').val(villageName);
        updateFullAddress();
    });

    // Event handler untuk perubahan input alamat lainnya
    $('[name="address_street"], [name="address_rt"], [name="address_rw"], [name="address_postal_code"]').on('input', function() {
        updateFullAddress();
    });

    // Fungsi untuk mengupdate alamat lengkap
    function updateFullAddress() {
        const street = $('[name="address_street"]').val().trim();
        const rt = $('[name="address_rt"]').val().trim();
        const rw = $('[name="address_rw"]').val().trim();
        const postalCode = $('[name="address_postal_code"]').val().trim();
        const village = $('#villageSelect option:selected').text();
        const district = $('#districtSelect option:selected').text();
        const city = $('#citySelect option:selected').text();
        const province = $('#provinceSelect option:selected').text();

        const addressParts = [];

        // Tambahkan alamat jalan jika ada
        if (street) {
            addressParts.push(street);
        }

        // Tambahkan RT/RW jika ada
        if (rt || rw) {
            addressParts.push(`RT ${rt || '-'}/RW ${rw || '-'}`);
        }

        // Tambahkan Desa/Kelurahan jika dipilih
        if (village && village !== 'Pilih Desa/Kelurahan') {
            addressParts.push(`Desa/Kel. ${village}`);
        }

        // Tambahkan Kecamatan jika dipilih
        if (district && district !== 'Pilih Kecamatan') {
            addressParts.push(`Kec. ${district}`);
        }

        // Tambahkan Kabupaten/Kota jika dipilih
        if (city && city !== 'Pilih Kabupaten/Kota') {
            addressParts.push(`${city}`);
        }

        // Tambahkan Provinsi jika dipilih
        if (province && province !== 'Pilih Provinsi') {
            addressParts.push(`${province}`);
        }

        // Tambahkan Kode Pos jika ada
        if (postalCode) {
            addressParts.push(postalCode);
        }

        // Gabungkan semua bagian alamat
        const fullAddress = addressParts.join(', ');
        $('#fullAddress').val(fullAddress);
    }

    // Validasi No BPJS hanya angka
    $('#no_bpjs').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi nama hanya huruf dan spasi
    $('#name').on('input', function() {
        this.value = this.value.replace(/[^A-Za-z\s']/g, '');
    });

    // Validasi RT/RW hanya angka
    $('#address_rt, #address_rw').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi kode pos hanya angka
    $('#address_postal_code').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Form validation before submit
    $('#patientForm').on('submit', function(e) {
        const noBpjs = $('#no_bpjs').val();
        const name = $('#name').val();
        const birthDate = $('#birth_date').val();
        const gender = $('#gender').val();

        let isValid = true;
        let errorMessage = '';

        // Validasi No BPJS
        if (noBpjs.length !== 13) {
            isValid = false;
            errorMessage += 'Nomor BPJS harus 13 digit\n';
        }

        // Validasi Nama
        if (name.length < 3) {
            isValid = false;
            errorMessage += 'Nama harus minimal 3 karakter\n';
        }

        // Validasi Tanggal Lahir
        if (!birthDate) {
            isValid = false;
            errorMessage += 'Tanggal lahir harus diisi\n';
        }

        // Validasi Jenis Kelamin
        if (!gender) {
            isValid = false;
            errorMessage += 'Jenis kelamin harus dipilih\n';
        }

        if (!isValid) {
            e.preventDefault();
            alert('Mohon perbaiki data berikut:\n' + errorMessage);
            return false;
        }

        // Update alamat lengkap sebelum submit
        // Tambahkan leading zero pada RT/RW jika sudah diisi
        let rt = $('#address_rt').val();
        let rw = $('#address_rw').val();
        if(rt) $('#address_rt').val(rt.padStart(3, '0'));
        if(rw) $('#address_rw').val(rw.padStart(3, '0'));
        updateFullAddress();
    });
});
</script>
@endpush

@endsection
