@extends('layouts.app')
@section('content')
<div class="w-full px-2 md:px-8 py-4 md:py-10">
    <div class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-8 items-start">
        <!-- Left Column - Form Section -->
        <div class="bg-white p-6 md:p-10 rounded-2xl shadow-xl border border-gray-100">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <i class="fas fa-prescription-bottle text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Rekomendasi Obat Cerdas</h1>
                        <p class="text-gray-500 mt-1">Berdasarkan gejala dan riwayat pasien</p>
                    </div>
                </div>
                <!-- Patient Selection Autocomplete -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-user-injured text-blue-500"></i>
                        Pilih Pasien
                    </label>
                    <div class="relative group max-w-xl">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="patientSearch" placeholder="Ketik nama atau nomor BPJS pasien..."
                               class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                               autocomplete="off">
                        <input type="hidden" name="patient_id" id="patientId">
                        <!-- Dropdown Results -->
                        <div id="patientResults" class="hidden absolute w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <div class="overflow-y-auto" style="max-height: 240px;">
                                <!-- Hasil pencarian akan ditampilkan di sini -->
                            </div>
                        </div>
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
                                        <span id="previewPatientBirth" class="text-gray-900"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Symptoms Section -->
            <div class="space-y-6">
                <!-- Symptoms List -->
                <div id="list-gejala-wrapper" class="space-y-4">
                    <div class="gejala-row group relative bg-white rounded-xl p-4 transition-all border-2 border-dashed border-blue-100 hover:border-blue-200 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-thermometer text-blue-500"></i>
                                    <label class="block text-sm font-medium text-gray-700">Gejala/Penyakit</label>
                                </div>
                                <select class="select-gejala w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-white">
                                    <option value="">Pilih gejala...</option>
                                    @foreach($penyakits as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_penyakit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="btn-hapus-gejala mt-7 p-2 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-times-circle text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add Symptom Button -->
                <button type="button" id="btn-tambah-gejala"
                    class="w-full py-3 bg-blue-50 text-blue-600 rounded-xl font-medium flex items-center justify-center gap-2 hover:bg-blue-100 transition-all border-2 border-dashed border-blue-200 hover:border-blue-300">
                    <i class="fas fa-plus-circle"></i> Tambah Gejala
                </button>
            </div>

            <!-- Prescription Form -->
            <div id="form-tambah-obat-wrapper" class="mt-8 hidden">
                <div class="bg-white rounded-xl shadow-md p-6 border border-blue-100">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fas fa-pills text-blue-500 text-xl"></i>
                        <h3 class="text-lg font-semibold text-gray-800">Tambah ke Resep</h3>
                    </div>
                    <form id="form-tambah-obat" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Obat</label>
                            <input list="daftar-obat" id="input-nama-obat" name="nama_obat" class="w-full px-4 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500" required>
                            <datalist id="daftar-obat"></datalist>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dosis</label>
                            <input type="text" id="input-dosis" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="number" id="input-jumlah" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <input type="text" id="input-catatan" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-4 mt-2">
                            <div class="flex gap-3 justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium shadow-md transition-all flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> Simpan
                                </button>
                                <button type="button" class="btn-cancel-form bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2 rounded-lg transition-all">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Prescription Table -->
            <div id="tabel-obat-wrapper" class="hidden">
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-blue-100 bg-blue-50 flex items-center gap-3">
                        <i class="fas fa-prescription text-blue-500"></i>
                        <h4 class="font-semibold text-blue-700">Resep Aktif</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px]">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Obat</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Dosis</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Catatan</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody id="tabel-obat-body" class="divide-y divide-blue-100">
                                <!-- Data akan diisi secara dinamis -->
                            </tbody>
                        </table>
                    </div>
                    <div id="cetak-resep-wrapper" class="p-4 text-right hidden">
                        <button id="btn-cetak-resep" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition mt-4">
                            <i class="fas fa-print"></i> Cetak Resep
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Recommendation Section -->
        <div class="sticky top-6 bg-white border border-gray-200 rounded-2xl p-6 shadow-xl transition-all">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-star text-yellow-500 text-xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Rekomendasi Terbaik</h2>
            </div>
            <div id="hasil-rekomendasi" class="space-y-4">
                <div class="p-4 text-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                    <i class="fas fa-info-circle mr-2"></i> Pilih gejala untuk melihat rekomendasi
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Dummy data
const gejalaLabel = {1: 'Hipertensi', 2: 'Diabetes', 3: 'Asma'};
const rekomendasiDummy = {
    1: [
        { nama: 'Amlodipine', dosis: '1x sehari', terbaik: true },
        { nama: 'Captopril', dosis: '2x sehari', terbaik: false }
    ],
    2: [
        { nama: 'Metformin', dosis: '2x sehari', terbaik: true },
        { nama: 'Glibenclamide', dosis: '1x sehari', terbaik: false }
    ],
    3: [
        { nama: 'Salbutamol', dosis: 'Jika perlu', terbaik: true },
        { nama: 'Budesonide', dosis: '2x sehari', terbaik: false }
    ]
};

// --- Tambahkan ini untuk push data pasien dari backend ke JS ---
window.patients = @json($patients);
window.penyakits = @json($penyakits);
window.medicines = @json($medicines);

document.addEventListener('DOMContentLoaded', function() {
    // Tambah gejala dinamis
    document.getElementById('btn-tambah-gejala').addEventListener('click', function(e) {
        // Cek apakah select-gejala aktif sudah dipilihkan obat (sudah di-disable)
        const selects = document.querySelectorAll('.select-gejala');
        if (selects.length > 0 && !selects[selects.length-1].disabled) {
            alert('Silakan pilih dan simpan rekomendasi obat untuk gejala/penyakit ini terlebih dahulu sebelum menambah gejala baru.');
            return;
        }
        // Disable semua select-gejala sebelumnya
        document.querySelectorAll('.select-gejala').forEach(sel => sel.disabled = true);
        // Tambahkan field gejala baru (aktif)
        const newRow = document.createElement('div');
        newRow.className = 'gejala-row group relative bg-white rounded-xl p-4 transition-all border-2 border-dashed border-blue-100 hover:border-blue-200 shadow-sm';
        let options = '<option value="">Pilih gejala...</option>';
        window.penyakits.forEach(function(p) {
            options += `<option value="${p.id}">${p.nama_penyakit}</option>`;
        });
        newRow.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-thermometer text-blue-500"></i>
                        <label class="block text-sm font-medium text-gray-700">Gejala/Penyakit</label>
                    </div>
                    <select class="select-gejala w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-white">${options}</select>
                </div>
                <button type="button" class="btn-hapus-gejala mt-7 p-2 text-red-400 hover:text-red-600 opacity-100 transition-opacity">
                    <i class="fas fa-times-circle text-lg"></i>
                </button>
            </div>
        `;
        document.getElementById('list-gejala-wrapper').appendChild(newRow);
        // Update rekomendasi hanya untuk field baru
        updateRecommendations();
        // Nonaktifkan tombol tambah gejala sampai obat untuk gejala ini disimpan
        document.getElementById('btn-tambah-gejala').disabled = true;
    });

    // Event delegation untuk hapus gejala & update rekomendasi
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-hapus-gejala')) {
            e.target.closest('.gejala-row').remove();
            // Aktifkan select-gejala terakhir jika ada
            const selects = document.querySelectorAll('.select-gejala');
            if (selects.length > 0) {
                selects[selects.length-1].disabled = false;
                updateRecommendations();
            } else {
                // Jika tidak ada gejala, kosongkan rekomendasi
                document.getElementById('hasil-rekomendasi').innerHTML = `<div class="p-4 text-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200"><i class="fas fa-info-circle mr-2"></i> Pilih gejala untuk melihat rekomendasi</div>`;
            }
            // Aktifkan tombol tambah gejala
            document.getElementById('btn-tambah-gejala').disabled = false;
        }
    });

    // Event delegation untuk update rekomendasi saat select berubah
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('select-gejala')) {
            // Hanya update rekomendasi untuk select-gejala yang aktif (tidak disabled)
            if (!e.target.disabled) {
                updateRecommendations();
            }
        }
    });

    // Render rekomendasi hanya untuk gejala aktif/terakhir
    function updateRecommendations() {
        // Ambil select-gejala yang aktif (tidak disabled)
        const selects = Array.from(document.querySelectorAll('.select-gejala'));
        const activeSelect = selects.find(sel => !sel.disabled);
        const selected = activeSelect && activeSelect.value ? [activeSelect.value] : [];
        const target = document.getElementById('hasil-rekomendasi');
        if (selected.length === 0) {
            target.innerHTML = `<div class="p-4 text-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200"><i class="fas fa-info-circle mr-2"></i> Pilih gejala untuk melihat rekomendasi</div>`;
            return;
        }
        // Loading state
        target.innerHTML = `<div class='p-4 text-center text-blue-400 bg-blue-50 rounded-xl border-2 border-dashed border-blue-200 animate-pulse'><i class='fas fa-spinner fa-spin mr-2'></i> Menghitung rekomendasi terbaik...</div>`;
        fetch('/prb-gejala/rekomendasi-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ penyakit_ids: selected })
        })
        .then(res => res.json())
        .then(res => {
            if (!res.success || !res.data.length) {
                target.innerHTML = `<div class='p-4 text-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200'><i class='fas fa-info-circle mr-2'></i> Tidak ada rekomendasi ditemukan</div>`;
                return;
            }
            let html = '';
            res.data.forEach((item, idx) => {
                // Cari keterangan dari window.medicines
                const dataObat = window.medicines.find(m => m.name === item.obat);
                const keterangan = dataObat && dataObat.description ? dataObat.description : '-';
                if(idx === 0) {
                    html += `
                    <div class=\"recommendation-card bg-gradient-to-r from-blue-400 to-purple-400 text-white rounded-2xl shadow-xl border-0 mb-2 flex items-stretch p-0\" style=\"position:relative;\">
                        <div class=\"flex-1 p-6 flex flex-col justify-between\">
                            <div class=\"flex items-center gap-2 mb-2\">
                                <span class=\"w-3 h-3 rounded-full bg-white/40 mr-2\"></span>
                                <span class=\"font-bold text-sm\">Rekomendasi Utama</span>
                            </div>
                            <div class=\"text-2xl font-bold mb-1\">${item.obat}</div>
                            <div class=\"text-base font-medium\">Skor: ${item.skor.toFixed(4)}</div>
                            <div class=\"text-sm mt-2\"><span class=\"font-normal\">${keterangan}</span></div>
                        </div>
                        <div class=\"flex flex-col justify-between items-end p-6\">
                            <div class=\"text-xs text-white/80 text-right\">Ranking Tertinggi</div>
                            <div class=\"text-4xl font-extrabold drop-shadow\">#1</div>
                            <button type=\"button\" class=\"btn-ambil-obat mt-4 px-5 py-2 text-base bg-white text-blue-700 font-bold rounded-lg hover:bg-blue-100 transition flex items-center gap-2\" data-nama=\"${item.obat}\"><i class=\"fas fa-cart-plus\"></i> Ambil</button>
                        </div>
                    </div>`;
                } else {
                    html += `
                    <div class=\"recommendation-card bg-white rounded-2xl shadow border border-gray-100 mb-3 flex items-stretch p-0\" style=\"position:relative;\">
                        <div class=\"flex-1 p-6 flex flex-col justify-between\">
                            <div class=\"flex items-center gap-2 mb-2\">
                                <span class=\"w-3 h-3 rounded-full bg-blue-100 mr-2\"></span>
                                <span class=\"font-bold text-sm text-blue-600\">Rekomendasi</span>
                            </div>
                            <div class=\"text-xl font-bold text-blue-800 mb-1\">${item.obat}</div>
                            <div class=\"text-base font-medium text-blue-700\">Skor: ${item.skor.toFixed(4)}</div>
                            <div class=\"text-sm mt-2 text-blue-700\"><span class=\"font-normal\">${keterangan}</span></div>
                        </div>
                        <div class=\"flex flex-col justify-between items-end p-6\">
                            <div class=\"text-xs text-blue-400 text-right\">Ranking</div>
                            <div class=\"text-3xl font-extrabold text-blue-600\">#${idx+1}</div>
                            <button type=\"button\" class=\"btn-ambil-obat mt-4 px-5 py-2 text-base bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition flex items-center gap-2\" data-nama=\"${item.obat}\"><i class=\"fas fa-cart-plus\"></i> Ambil</button>
                        </div>
                    </div>`;
                }
            });
            target.innerHTML = html;
        })
        .catch(() => {
            target.innerHTML = `<div class='p-4 text-center text-red-400 bg-red-50 rounded-xl border-2 border-dashed border-red-200'><i class='fas fa-exclamation-circle mr-2'></i> Gagal mengambil rekomendasi</div>`;
        });
    }

    // Inisialisasi pertama kali: hanya satu field gejala aktif
    // Disable tombol tambah gejala jika belum ada resep
    if (document.querySelectorAll('.select-gejala').length === 1) {
        document.getElementById('btn-tambah-gejala').disabled = true;
    }

    let resepList = [];

    // Event delegation untuk tombol Ambil Obat
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-ambil-obat')) {
            const btn = e.target.closest('.btn-ambil-obat');
            const namaObat = btn.getAttribute('data-nama');
            document.getElementById('input-nama-obat').value = namaObat;
            // Ambil data dosis & jumlah dari window.medicines
            const dataObat = window.medicines.find(m => m.name === namaObat);
            document.getElementById('input-dosis').value = dataObat && dataObat.dose ? dataObat.dose : '';
            document.getElementById('input-jumlah').value = dataObat && dataObat.quantity ? dataObat.quantity : '';
            document.getElementById('input-catatan').value = '';
            document.getElementById('form-tambah-obat-wrapper').classList.remove('hidden');
            document.getElementById('form-tambah-obat').scrollIntoView({behavior:'smooth'});
        }
    });

    // Event untuk batal form resep
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-cancel-form')) {
            document.getElementById('form-tambah-obat-wrapper').classList.add('hidden');
        }
    });

    // Event submit form resep
    document.getElementById('form-tambah-obat').addEventListener('submit', function(e) {
        e.preventDefault();
        const nama = document.getElementById('input-nama-obat').value;
        const dosis = document.getElementById('input-dosis').value;
        const jumlah = document.getElementById('input-jumlah').value;
        const catatan = document.getElementById('input-catatan').value;
        resepList.push({nama, dosis, jumlah, catatan});
        renderTabelResep();
        document.getElementById('form-tambah-obat-wrapper').classList.add('hidden');
        // Setelah simpan obat, aktifkan tombol tambah gejala dan disable select-gejala aktif
        const selects = document.querySelectorAll('.select-gejala');
        if (selects.length > 0) {
            selects[selects.length-1].disabled = true;
        }
        document.getElementById('btn-tambah-gejala').disabled = false;
        // Kosongkan rekomendasi
        document.getElementById('hasil-rekomendasi').innerHTML = `<div class=\"p-4 text-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200\"><i class=\"fas fa-info-circle mr-2\"></i> Pilih gejala untuk melihat rekomendasi</div>`;
    });

    function renderTabelResep() {
        const wrapper = document.getElementById('tabel-obat-wrapper');
        const tbody = document.getElementById('tabel-obat-body');
        const cetakWrapper = document.getElementById('cetak-resep-wrapper');
        if (resepList.length === 0) {
            wrapper.classList.add('hidden');
            cetakWrapper.classList.add('hidden');
            return;
        }
        wrapper.classList.remove('hidden');
        tbody.innerHTML = '';
        resepList.forEach((item, idx) => {
            tbody.innerHTML += `<tr>
                <td class='px-4 py-2'>${item.nama}</td>
                <td class='px-4 py-2'>${item.dosis}</td>
                <td class='px-4 py-2'>${item.jumlah}</td>
                <td class='px-4 py-2'>${item.catatan}</td>
                <td class='px-4 py-2 text-right'><button type='button' class='btn-hapus-resep text-red-500 hover:text-red-700' data-idx='${idx}'><i class='fas fa-trash'></i></button></td>
            </tr>`;
        });
        cetakWrapper.classList.remove('hidden');
    }

    // Event hapus resep
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-hapus-resep')) {
            const idx = e.target.closest('.btn-hapus-resep').dataset.idx;
            resepList.splice(idx, 1);
            renderTabelResep();
        }
    });

    // Event klik tombol cetak resep
    document.getElementById('btn-cetak-resep').addEventListener('click', function() {
        // Ambil data pasien
        const patientId = document.getElementById('patientId').value;
        if (!patientId) {
            alert('Pilih pasien terlebih dahulu!');
            return;
        }
        // Ambil data gejala/penyakit
        const penyakitIds = Array.from(document.querySelectorAll('.select-gejala'))
            .map(sel => sel.value)
            .filter(Boolean);
        if (penyakitIds.length === 0) {
            alert('Pilih minimal satu gejala/penyakit!');
            return;
        }
        // Ambil data rekomendasi (dari card rekomendasi)
        const rekomendasi = Array.from(document.querySelectorAll('.recommendation-card')).map(card => {
            const nama = card.querySelector('.font-semibold.text-blue-600').textContent.trim();
            const skor = card.querySelector('.text-mono, .font-mono')?.textContent?.trim() || '';
            return { obat: nama, skor: skor };
        });
        // Ambil data resep aktif
        const resepAktif = resepList;
        // Simpan riwayat rekomendasi ke backend
        fetch('/prb-gejala/simpan-riwayat-rekomendasi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                patient_id: patientId,
                penyakit_ids: penyakitIds,
                rekomendasi: rekomendasi,
                taken_medicines: resepAktif
            })
        })
        .then(res => res.json())
        .then(res => {
            // Setelah sukses, buka halaman print
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/prb-gejala/print';
            form.target = '_blank';
            form.style.display = 'none';
            // Data yang dikirim ke print
            form.innerHTML = `
                <input type='hidden' name='patient_id' value='${patientId}'>
                <input type='hidden' name='penyakit_ids' value='${JSON.stringify(penyakitIds)}'>
                <input type='hidden' name='rekomendasi' value='${JSON.stringify(rekomendasi)}'>
                <input type='hidden' name='resep' value='${JSON.stringify(resepAktif)}'>
                <input type='hidden' name='_token' value='${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}'>
            `;
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        })
        .catch(() => {
            alert('Gagal menyimpan riwayat rekomendasi!');
        });
    });

    // --- Ganti bagian autocomplete pasien ---
    const patientSearch = document.getElementById('patientSearch');
    const patientResults = document.getElementById('patientResults');
    const patientIdInput = document.getElementById('patientId');
    const patientPreview = document.getElementById('patientPreview');
    const patients = window.patients;

    patientSearch.addEventListener('input', function() {
        const q = this.value.trim().toLowerCase();
        if (!q) {
            patientResults.classList.add('hidden');
            return;
        }
        const filtered = patients.filter(p =>
            (p.name && p.name.toLowerCase().includes(q)) ||
            (p.no_bpjs && p.no_bpjs.toLowerCase().includes(q))
        );
        const resultBox = patientResults.querySelector('div');
        resultBox.innerHTML = filtered.length ? filtered.map(p => `
            <div class='autocomplete-item' data-id='${p.id}' data-name='${p.name}' data-no_bpjs='${p.no_bpjs ?? ''}' data-address='${p.address ?? ''}' data-gender='${p.gender ?? ''}' data-birth='${p.birth_date ?? ''}'>
                <span class='autocomplete-icon'><i class="fas fa-user"></i></span>
                <span class='autocomplete-info'>
                    <span class='autocomplete-name'>${p.name}</span>
                    <span class='autocomplete-bpjs'>${p.no_bpjs ?? '-'}</span>
                </span>
            </div>
        `).join('') : `<div class='px-4 py-2 text-gray-400'>Tidak ditemukan</div>`;
        patientResults.classList.remove('hidden');
    });

    patientResults.addEventListener('click', function(e) {
        const row = e.target.closest('[data-id]');
        if (!row) return;
        patientSearch.value = row.dataset.name + ' (' + row.dataset.no_bpjs + ')';
        patientIdInput.value = row.dataset.id;
        // Preview
        document.getElementById('previewPatientName').textContent = row.dataset.name;
        document.getElementById('previewPatientBPJS').textContent = row.dataset.no_bpjs;
        document.getElementById('previewPatientAddress').textContent = row.dataset.address;
        document.getElementById('previewPatientGender').textContent = row.dataset.gender;
        document.getElementById('previewPatientBirth').textContent = row.dataset.birth;
        patientPreview.classList.remove('hidden');
        patientResults.classList.add('hidden');
    });
    // Hide dropdown jika klik di luar
    window.addEventListener('click', function(e) {
        if (!patientResults.contains(e.target) && e.target !== patientSearch) {
            patientResults.classList.add('hidden');
        }
    });
});
</script>

<style>
/* Custom Animations */
@keyframes slideIn {
    from { transform: translateY(10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.recommendation-card {
    animation: slideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-ambil-obat:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}
.bg-gradient-medical {
    background: linear-gradient(135deg, #f0f4ff 0%, #f7fafc 100%);
}
@media (max-width: 768px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}

/* --- Tambahan untuk Autocomplete Pasien --- */
#patientResults {
    box-shadow: 0 8px 32px rgba(0, 60, 180, 0.10), 0 1.5px 4px rgba(0,0,0,0.04);
    border-radius: 1rem;
    border: 1.5px solid #e0e7ef;
    padding: 0.25rem 0;
    margin-top: 0.25rem;
    z-index: 100;
    min-width: 220px;
    font-size: 1rem;
    animation: slideIn 0.2s;
}
#patientResults .autocomplete-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    cursor: pointer;
    border-radius: 0.75rem;
    transition: background 0.15s;
    font-size: 1rem;
}
#patientResults .autocomplete-item:hover, #patientResults .autocomplete-item.active {
    background: linear-gradient(90deg, #e0eaff 0%, #f3f8ff 100%);
}
#patientResults .autocomplete-icon {
    background: #e0eaff;
    color: #2563eb;
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
#patientResults .autocomplete-info {
    display: flex;
    flex-direction: column;
}
#patientResults .autocomplete-name {
    font-weight: 600;
    color: #1e293b;
}
#patientResults .autocomplete-bpjs {
    font-size: 0.92rem;
    color: #64748b;
}
@media (max-width: 600px) {
    #patientResults {
        min-width: 100%;
        left: 0;
        right: 0;
    }
    #patientResults .autocomplete-item {
        padding: 0.7rem 0.7rem;
        font-size: 0.98rem;
    }
}
</style>
@endsection
