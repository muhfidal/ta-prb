@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 md:px-4 py-6 md:py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-8 space-y-2 md:space-y-0">
        <div class="space-y-1 md:space-y-2">
            <h2 class="text-lg md:text-2xl font-bold text-gray-800">Pengambilan Obat</h2>
            <p class="text-gray-600 text-sm md:text-base">Pilih pasien dan dokter untuk pengambilan obat</p>
        </div>
        <div class="flex items-center mt-2 md:mt-0">
            <div class="bg-blue-100 p-2 md:p-3 rounded-full mr-2 md:mr-3">
                <i class="fas fa-pills text-blue-500 text-lg md:text-xl"></i>
            </div>
            <div class="bg-green-100 p-2 md:p-3 rounded-full">
                <i class="fas fa-clipboard-check text-green-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg md:rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 md:px-6 py-3 md:py-4">
                    <h3 class="text-base md:text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-search mr-2"></i> Cari Pasien
                    </h3>
                </div>
                <div class="p-4 md:p-6">
                    <form id="prescriptionForm" method="POST" action="{{ route('medicines.take.storeAndPrint') }}" class="space-y-4 md:space-y-6">
                        @csrf
                        <div class="space-y-4 md:space-y-6">
                            <!-- Search Input -->
                            <div class="form-group">
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Cari Pasien</label>
                                <div class="relative search-container">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400 text-sm md:text-base"></i>
                                    </div>
                                    <input type="text"
                                           id="patientSearch"
                                           placeholder="Ketik nama atau nomor BPJS pasien..."
                                           class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm md:text-base py-2 md:py-2.5"
                                           autocomplete="off">
                                    <input type="hidden" name="patient_id" id="patientId">

                                    <!-- Dropdown Results -->
                                    <div id="patientResults" class="hidden absolute w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                        <div class="overflow-y-auto max-h-60">
                                            <!-- Hasil pencarian akan ditampilkan di sini -->
                                        </div>
                                    </div>
                                </div>
                                @error('patient_id')
                                    <p class="mt-2 text-xs md:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tanggal Pengambilan</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400 text-sm md:text-base"></i>
                                    </div>
                                    <input type="datetime-local" name="taken_at" id="takenAt" value="{{ now()->format('Y-m-d\TH:i') }}"
                                           class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm md:text-base py-2 md:py-2.5">
                                </div>
                                @error('taken_at')
                                    <p class="mt-2 text-xs md:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Pilih Dokter</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-md text-gray-400 text-sm md:text-base"></i>
                                    </div>
                                    <select name="doctor_id" id="doctorSelect"
                                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm md:text-base py-2 md:py-2.5">
                                        <option value="">Pilih Dokter</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->user_id }}">
                                                {{ $doctor->name }}
                                                @if($doctor->user)
                                                    ({{ $doctor->user->name }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('doctor_id')
                                    <p class="mt-2 text-xs md:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="lg:col-span-1 mt-4 lg:mt-0">
            <div class="bg-white rounded-lg md:rounded-xl shadow-lg overflow-hidden h-full">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-4 md:px-6 py-3 md:py-4">
                    <h3 class="text-base md:text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-info-circle mr-2"></i> Informasi
                    </h3>
                </div>
                <div class="p-4 md:p-6">
                    <div class="space-y-3 md:space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-2 md:mr-3">
                                <i class="fas fa-user-check text-blue-500 text-base md:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm md:text-base">Pilih Pasien</h4>
                                <p class="text-xs md:text-sm text-gray-600">Cari pasien berdasarkan nama untuk melihat resep yang tersedia</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-2 md:mr-3">
                                <i class="fas fa-calendar-check text-blue-500 text-base md:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm md:text-base">Tanggal Pengambilan</h4>
                                <p class="text-xs md:text-sm text-gray-600">Tentukan tanggal pengambilan obat</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-2 md:mr-3">
                                <i class="fas fa-user-md text-blue-500 text-base md:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm md:text-base">Pilih Dokter</h4>
                                <p class="text-xs md:text-sm text-gray-600">Pilih dokter yang menangani pasien</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-2 md:mr-3">
                                <i class="fas fa-print text-blue-500 text-base md:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm md:text-base">Cetak Resep</h4>
                                <p class="text-xs md:text-sm text-gray-600">Cetak resep untuk pengambilan obat</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 md:mt-6 p-3 md:p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <h4 class="font-medium text-blue-800 mb-2 text-sm md:text-base">Petunjuk</h4>
                        <ul class="text-xs md:text-sm text-gray-700 space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Pastikan pasien sudah memiliki resep yang aktif</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Pilih dokter yang menangani pasien</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Cetak resep untuk pengambilan obat</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Section -->
    <div id="preview" class="mt-8 hidden">
        <div class="bg-white rounded-lg md:rounded-xl shadow-lg overflow-hidden relative">
            <div class="bg-blue-600 px-4 md:px-6 py-2 md:py-3">
                <h3 class="text-base md:text-lg font-bold text-white flex items-center">
                <i class="fas fa-user-circle mr-2"></i> Informasi Pasien
            </h3>
        </div>
            <div class="p-3 md:p-6 space-y-3 md:space-y-4">
                <div class="flex items-start gap-2 text-sm md:text-base">
                    <i class="fas fa-user text-blue-500 mt-1"></i>
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-700">Nama Pasien:</span>
                        <span id="previewPatientName" class="ml-0 md:ml-1"></span>
                    </div>
                        </div>
                <div class="flex items-start gap-2 text-sm md:text-base">
                    <i class="fas fa-id-card text-blue-500 mt-1"></i>
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-700">No BPJS:</span>
                        <span id="previewPatientBPJS" class="ml-0 md:ml-1"></span>
                    </div>
                        </div>
                <div class="flex items-start gap-2 text-sm md:text-base">
                    <i class="fas fa-map-marker-alt text-blue-500 mt-1"></i>
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-700">Alamat:</span>
                        <span id="previewPatientAddress" class="ml-0 md:ml-1"></span>
                    </div>
                </div>
                <div class="flex items-start gap-2 text-sm md:text-base">
                    <i class="fas fa-calendar-alt text-blue-500 mt-1"></i>
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-700">Tanggal Lahir:</span>
                        <span id="previewPatientBirthDate" class="ml-0 md:ml-1"></span>
                    </div>
                        </div>
                <div class="flex items-start gap-2 text-sm md:text-base">
                    <i class="fas fa-prescription-bottle-alt text-blue-500 mt-1"></i>
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-700">Resep Obat:</span>
                        <span id="previewPrescriptionInfo" class="ml-0 md:ml-1">Tidak ada resep</span>
                    </div>
                </div>
                <div class="flex items-start gap-2 text-sm md:text-base">
                    <i class="fas fa-history text-blue-500 mt-1"></i>
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-700">Pengambilan Sebelumnya:</span>
                        <span id="previewPatientHistoryInfo" class="ml-0 md:ml-1">Tidak ada pengambilan sebelumnya</span>
                    </div>
                </div>
                <div class="mt-4" id="actionResepBtn"></div>
            </div>
            <div id="noPrescriptionAlert" class="w-full bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mt-4 flex items-center" style="display:none;">
                <i class="fas fa-exclamation-circle mr-2"></i> Pasien belum memiliki resep, harap tambahkan resep terlebih dahulu.
        </div>
    </div>
</div>

<!-- Modal Peringatan Pasien Tanpa Resep -->
<div id="noPrescriptionModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        </div>

        <div class="inline-block align-middle my-8 p-6 w-full max-w-md text-left overflow-hidden transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Peringatan</h3>
                <p class="text-gray-600 text-center mb-6">Pasien belum memiliki resep, harap tambahkan resep terlebih dahulu.</p>

                <div class="flex justify-center space-x-3 w-full">
                    <button onclick="closeModal('noPrescriptionModal')"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-times mr-2"></i> Tutup
                    </button>
                    <a href="/prescriptions/create"
                       class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Resep
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Cetak Resep -->
<div id="confirmPrintModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        </div>

        <div class="inline-block align-middle my-8 p-6 w-full max-w-md text-left overflow-hidden transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-print text-blue-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Cetak Resep</h3>
                <p id="confirmPrintMessage" class="text-gray-600 text-center mb-6">Apakah Anda akan mencetak resep untuk pasien ini?</p>

                <div class="flex justify-center space-x-3 w-full">
                    <button onclick="closeModal('confirmPrintModal')"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button onclick="submitForm()"
                            class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-print mr-2"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div id="afterSuccess" class="hidden mt-6 text-center">
        <p class="mb-4 text-green-700 font-semibold">Pengambilan obat berhasil disimpan!</p>
        <a id="printPdfBtn" href="#" target="_blank"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-semibold shadow transition-all">
            <i class='fas fa-print mr-2'></i> Cetak PDF Resep
        </a>
    </div>
</div>

@push('styles')
<style>
    /* Dropdown Styles */
    #patientResults {
        top: 100%;
        width: 100%;
        background: white;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .patient-result-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .patient-result-item:last-child {
        border-bottom: none;
    }

    .patient-result-item:hover {
        background-color: #f3f4f6;
    }

    .patient-result-item.selected {
        background-color: #ebf5ff;
    }

    /* Scrollbar Styles */
    #patientResults .max-h-60::-webkit-scrollbar {
        width: 6px;
    }

    #patientResults .max-h-60::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    #patientResults .max-h-60::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    /* Modal Animation */
    #noPrescriptionModal, #confirmPrintModal {
        transition: opacity 0.3s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const patients = @json($patients);
    const prescriptions = @json($prescriptions);
    let selectedIndex = -1;
    let selectedPatient = null;
    let selectedPatientPrescriptions = [];

    function displayResults(patientsList, searchInput = '') {
        const resultsDiv = document.getElementById('patientResults');
        resultsDiv.classList.remove('hidden');
        const resultsContainer = resultsDiv.querySelector('.overflow-y-auto');

        if (patientsList.length === 0) {
            resultsContainer.innerHTML = `
                <div class="p-3 text-gray-500 text-center">
                    Tidak ada pasien yang ditemukan
                </div>
            `;
            return;
        }

        resultsContainer.innerHTML = patientsList.map((patient, index) => {
            const nameHighlight = patient.name.toLowerCase().includes(searchInput.toLowerCase())
                ? patient.name.replace(new RegExp(searchInput, 'gi'), match => `<mark class="bg-yellow-200">${match}</mark>`)
                : patient.name;

            const bpjsHighlight = patient.no_bpjs && patient.no_bpjs.toLowerCase().includes(searchInput.toLowerCase())
                ? patient.no_bpjs.replace(new RegExp(searchInput, 'gi'), match => `<mark class="bg-yellow-200">${match}</mark>`)
                : patient.no_bpjs;

            return `
                <div class="patient-result-item ${index === selectedIndex ? 'selected' : ''}"
                     onclick='selectPatient(${JSON.stringify(patient)})'>
                    <div class="flex items-center">
                        <div class="flex-1">
                    <div class="font-medium">${nameHighlight}</div>
                    ${bpjsHighlight ? `<div class="text-sm text-gray-600">No. BPJS: ${bpjsHighlight}</div>` : ''}
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                </div>
            `;
        }).join('');
    }

    function searchPatients() {
        const searchInput = document.getElementById('patientSearch').value.trim().toLowerCase();
        if (searchInput.length < 3) {
            document.getElementById('patientResults').classList.add('hidden');
            return;
        }
        const filteredPatients = patients.filter(patient =>
            patient.name.toLowerCase().includes(searchInput) ||
            (patient.no_bpjs && patient.no_bpjs.toLowerCase().includes(searchInput))
        );
        displayResults(filteredPatients, searchInput);
        selectedIndex = -1;
    }

    // Event listeners for search input
    const searchInput = document.getElementById('patientSearch');
    searchInput.addEventListener('input', searchPatients);
    searchInput.addEventListener('keydown', (e) => {
        const results = document.querySelectorAll('.patient-result-item');
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, results.length - 1);
                updateSelection();
                break;
            case 'ArrowUp':
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, 0);
                updateSelection();
                break;
            case 'Enter':
                e.preventDefault();
                if (selectedIndex >= 0 && results[selectedIndex]) {
                    results[selectedIndex].click();
                }
                break;
            case 'Escape':
                e.preventDefault();
                document.getElementById('patientResults').classList.add('hidden');
                break;
        }
    });

    function updateSelection() {
        const results = document.querySelectorAll('.patient-result-item');
        results.forEach((item, index) => {
            if (index === selectedIndex) {
                item.classList.add('selected');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('selected');
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        const searchContainer = document.querySelector('.search-container');
        const patientResults = document.getElementById('patientResults');
        if (searchContainer && !searchContainer.contains(e.target)) {
            patientResults.classList.add('hidden');
        }
    });

    async function selectPatient(patient) {
        console.log('DATA PASIEN:', patient);
        selectedPatient = patient;
        document.getElementById('patientSearch').value = patient.name;
        document.getElementById('patientId').value = patient.id;
        document.getElementById('patientResults').classList.add('hidden');
        document.getElementById('preview').classList.remove('hidden');
        document.getElementById('previewPatientName').textContent = patient.name;
        document.getElementById('previewPatientBPJS').textContent = patient.no_bpjs || '-';
        document.getElementById('previewPatientAddress').textContent = patient.address || '-';
        document.getElementById('previewPatientBirthDate').textContent = patient.birth_date || '-';
        selectedPatientPrescriptions = prescriptions.filter(p => p.patient_id === patient.id);
        const actionBtn = document.getElementById('actionResepBtn');
        const histories = patient.medicine_patient_histories || [];
        let pengambilanTerakhir = 'Tidak ada pengambilan sebelumnya';
        if (histories.length > 0) {
            const sorted = histories.slice().sort((a, b) => new Date(b.taken_at) - new Date(a.taken_at));
            const last = sorted[0];
            const tgl = last.taken_at ? new Date(last.taken_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
            pengambilanTerakhir = tgl;
        }
        document.getElementById('previewPatientHistoryInfo').textContent = pengambilanTerakhir;
        if (selectedPatientPrescriptions.length > 0) {
            const resep = selectedPatientPrescriptions[0];
            document.getElementById('previewPrescriptionInfo').textContent = resep.prescription_number || '-';
            document.getElementById('noPrescriptionAlert').style.display = 'none';
            actionBtn.innerHTML = `<button onclick="handlePrintClick()" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg flex items-center text-base font-semibold shadow transition-all"><i class='fas fa-print mr-2'></i> Cetak Resep</button>`;
        } else {
            document.getElementById('previewPrescriptionInfo').textContent = 'Tidak ada resep';
            document.getElementById('noPrescriptionAlert').style.display = '';
            actionBtn.innerHTML = `<a href="/prescriptions/create?patient_id=${patient.id}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg flex items-center text-base font-semibold shadow transition-all"><i class='fas fa-plus-circle mr-2'></i> Buat Resep</a>`;
        }
        toggleCetakResepBtn();
    }

    function getAge(birthDate) {
        const today = new Date();
        const birth = new Date(birthDate);
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        return age;
    }

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function updatePrescriptionPreview(prescription) {
        document.getElementById('previewPrescriptionDate').textContent = prescription.prescription_date ? formatDate(prescription.prescription_date) : '-';
        document.getElementById('previewPrescriptionNumber').textContent = prescription.prescription_number || '-';
        document.getElementById('previewDiseases').textContent = (prescription.diseases && prescription.diseases.length > 0) ? prescription.diseases.map(d => d.name).join(', ') : '-';
        const meds = prescription.medicines && prescription.medicines.length > 0 ? prescription.medicines.map(m => `<li>${m.name} ${m.pivot && m.pivot.dosage ? m.pivot.dosage : ''}</li>`).join('') : '<li>-</li>';
        document.getElementById('previewMedicines').innerHTML = meds;
    }

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        modal.offsetHeight;
        modal.classList.add('show');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function handlePrintClick() {
        if (!selectedPatientPrescriptions || selectedPatientPrescriptions.length === 0) {
            alert('Pasien belum memiliki resep.');
            return;
        }
        const doctorId = document.getElementById('doctorSelect').value;
        const takenAt = document.getElementById('takenAt').value;
        if (!doctorId || !takenAt) {
            alert('Mohon lengkapi semua data yang diperlukan');
            return;
        }
        let latestPrescription = selectedPatientPrescriptions[0];
        if (selectedPatientPrescriptions.length > 1) {
            latestPrescription = selectedPatientPrescriptions.reduce((a, b) => {
                return new Date(a.prescription_date) > new Date(b.prescription_date) ? a : b;
            });
        }
        const prescriptionId = latestPrescription.id;
        const url = `/prescriptions/${prescriptionId}/print?doctor_id=${doctorId}&taken_at=${encodeURIComponent(takenAt)}`;
        window.open(url, '_blank');
    }

    function submitForm() {
        document.getElementById('prescriptionForm').submit();
        window.location.reload();
    }

    function checkFormFilled() {
        return $('#patientId').val() && $('#doctorSelect').val() && $('#takenAt').val();
    }

    function toggleCetakResepBtn() {
        if (checkFormFilled()) {
            $('#cetakResepBtnWrapper').removeClass('hidden');
        } else {
            $('#cetakResepBtnWrapper').addClass('hidden');
        }
    }

    $('#patientId, #doctorSelect, #takenAt').on('change input', toggleCetakResepBtn);

    // Hapus atau comment handler berikut:
    // $('#prescriptionForm').on('submit', function(e) { ... });
    // Pastikan hanya handler berikut yang aktif:
    $('#cetakResepBtn').on('click', function() {
        if (!checkFormFilled()) {
            Swal.fire('Gagal', 'Semua field wajib diisi!', 'error');
            return;
        }
        var form = $('#prescriptionForm');
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...');
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fas fa-print mr-2"></i> Cetak Resep');
                if(res.success && res.print_url) {
                    window.open(res.print_url, '_blank');
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil melakukan cetak resep!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = window.location.pathname;
                        }
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-print mr-2"></i> Cetak Resep');
                let msg = 'Terjadi kesalahan. Mohon cek kembali data.';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal', msg, 'error');
            }
        });
    });
</script>
@endpush
@endsection
