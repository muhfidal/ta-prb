<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\MedicineRecommendationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\MedicinePatientHistoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MatriksKriteriaController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PenilaianAlternatifController;
use App\Http\Controllers\Spk\PenilaianAlternatifController as SPKPenilaianAlternatifController;
use App\Http\Controllers\PenilaianObatGlobalController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PrbGejalaController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Route untuk Pasien
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
    Route::resource('patients', PatientController::class);
    Route::get('/patients/export/excel', [PatientController::class, 'exportExcel'])->name('patients.export.excel');
    Route::post('/patients/import/excel', [PatientController::class, 'importExcel'])->name('patients.import.excel');

    // Route untuk Resep
    Route::resource('prescriptions', PrescriptionController::class);
    Route::get('/prescriptions/{prescription}/print', [PrescriptionController::class, 'print'])->name('prescriptions.print');
    Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');

    // Route untuk Obat
    Route::resource('medicines', MedicineController::class)->except(['show']);

    // Route untuk Gejala
    Route::resource('symptoms', SymptomController::class);

    // Route untuk Rekomendasi Obat
    Route::post('/recommend', [MedicineRecommendationController::class, 'recommend'])
        ->name('medicines.recommend');

    // Route untuk Penyakit
    Route::resource('diseases', DiseaseController::class);

    // Route untuk Pengambilan Obat
    Route::resource('medicinePatientHistories', MedicinePatientHistoryController::class);
    Route::get('medicines/take', [MedicinePatientHistoryController::class, 'create'])->name('medicines.take');
    Route::post('medicines/take', [MedicinePatientHistoryController::class, 'store'])->name('medicines.take.store');
    Route::post('medicines/take/print', [MedicinePatientHistoryController::class, 'storeAndPrint'])->name('medicines.take.storeAndPrint');
    Route::get('medicinePatientHistories/search', [MedicinePatientHistoryController::class, 'search'])->name('medicinePatientHistories.search');

    // Route untuk Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/patients', [ReportController::class, 'patients'])->name('reports.patients');
    Route::get('/reports/prescriptions', [ReportController::class, 'prescriptions'])->name('reports.prescriptions');
    Route::get('/reports/medicines', [ReportController::class, 'medicines'])->name('reports.medicines');
    Route::get('/reports/diseases', [ReportController::class, 'diseases'])->name('reports.diseases');
    Route::get('/reports/doctors', [ReportController::class, 'doctors'])->name('reports.doctors');
    Route::get('/reports/patients/download/{format}', [ReportController::class, 'downloadPatients'])->name('reports.patients.download');

    // Route untuk detail kunjungan pasien
    Route::get('/patients/{patient}/visits', [PatientController::class, 'visits'])->name('patients.visits');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/settings/password', [UserController::class, 'updatePassword'])->name('settings.password');

    // Kriteria Routes
    Route::resource('kriteria', KriteriaController::class)->parameters(['kriteria' => 'kriteria']);

    // Matriks Perbandingan Kriteria Routes
    Route::resource('matriks-kriteria', MatriksKriteriaController::class)->except(['show']);
    Route::get('matriks-kriteria/cek-kelengkapan', [MatriksKriteriaController::class, 'cekKelengkapan'])->name('matriks-kriteria.cek-kelengkapan');

    // Perhitungan Routes
    Route::get('/perhitungan/bobot', [PerhitunganController::class, 'bobot'])->name('perhitungan.bobot');
    Route::post('/perhitungan/bobot', [PerhitunganController::class, 'hitungBobot'])->name('perhitungan.hitungBobot');
    Route::get('/perhitungan/skor', [PerhitunganController::class, 'skor'])->name('perhitungan.skor');
    Route::post('/perhitungan/skor', [PerhitunganController::class, 'hitungSkor'])->name('perhitungan.hitungSkor');

    // Routes untuk Alternatif
    Route::resource('alternatif', AlternatifController::class);

    // SPK Routes
    Route::prefix('spk')->name('spk.')->group(function () {
        // Penilaian Alternatif Routes
        // Route::resource('penilaian-alternatif', \App\Http\Controllers\Spk\PenilaianAlternatifController::class);
        // Route perhitungan skor otomatis
        Route::get('perhitungan-skor', [\App\Http\Controllers\PerhitunganController::class, 'skor'])->name('perhitungan-skor');
        Route::get('riwayat-rekomendasi', [App\Http\Controllers\PerhitunganController::class, 'riwayatRekomendasi'])->name('riwayat-rekomendasi');
    });

    // Penyakit Gejala Tambahan (SPK)
    Route::resource('penyakits', App\Http\Controllers\PenyakitController::class)->except(['show']);

    // Mapping Obat ke Penyakit (SPK)
    Route::get('penyakits/mapping', [App\Http\Controllers\PenyakitObatController::class, 'index'])->name('penyakits.mapping');
    Route::post('penyakits/mapping', [App\Http\Controllers\PenyakitObatController::class, 'store'])->name('penyakits.mapping.store');
    Route::get('penyakits/mapping/create', [App\Http\Controllers\PenyakitObatController::class, 'create'])->name('penyakits.mapping.create');
    Route::get('penyakits/mapping/{id}/edit', [App\Http\Controllers\PenyakitObatController::class, 'edit'])->name('penyakits.mapping.edit');

    // Penilaian Obat Global Routes
    Route::resource('penilaian-obat-global', PenilaianObatGlobalController::class);
    Route::get('penilaian-obat-global/create-mass', [PenilaianObatGlobalController::class, 'createMass'])->name('penilaian-obat-global.create-mass');
    Route::post('penilaian-obat-global/store-mass', [PenilaianObatGlobalController::class, 'storeMass'])->name('penilaian-obat-global.store-mass');

    // PRB Gejala Routes
    Route::get('/prb-gejala/resep', [PrbGejalaController::class, 'resep'])->name('prb-gejala.resep');
    Route::post('/prb-gejala/rekomendasi-ajax', [PrbGejalaController::class, 'rekomendasiAjax'])->name('prb-gejala.rekomendasiAjax');
    Route::post('/prb-gejala/simpan-riwayat-rekomendasi', [PrbGejalaController::class, 'simpanRiwayatRekomendasi'])->name('prb-gejala.simpanRiwayatRekomendasi');
    Route::post('/prb-gejala/print', [PrbGejalaController::class, 'printView'])->name('prb-gejala.print');
});

Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('doctors', DoctorController::class);
});
