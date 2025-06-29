<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriterias')->insert([
            [
                'nama_kriteria' => 'Efikasi Terapi',
                'deskripsi' => 'Kemampuan obat mengendalikan gejala penyakit berdasarkan bukti ilmiah. Subkriteria mencakup kecepatan mulai kerja obat, durasi kerja, dan bukti klinis.',
                'tipe_kriteria' => 'Benefit',
                'nilai_minimum' => 1,
                'nilai_maksimum' => 10,
                'fuzzy_set' => '1,5,10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kriteria' => 'Keamanan',
                'deskripsi' => 'Minimum efek samping dan toksisitas. Subkriteria: frekuensi efek samping, kontraindikasi, dan kategori risiko kehamilan.',
                'tipe_kriteria' => 'Benefit',
                'nilai_minimum' => 1,
                'nilai_maksimum' => 10,
                'fuzzy_set' => '1,4,10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kriteria' => 'Kepatuhan Penggunaan',
                'deskripsi' => 'Kemudahan pasien mematuhi regimen terapi berdasarkan frekuensi pemberian, rute administrasi, dan bentuk sediaan.',
                'tipe_kriteria' => 'Benefit',
                'nilai_minimum' => 1,
                'nilai_maksimum' => 10,
                'fuzzy_set' => '1,3,10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kriteria' => 'Kesesuaian Pedoman',
                'deskripsi' => 'Apakah obat direkomendasikan oleh pedoman nasional/BPJS dan memiliki izin edar. Subkriteria: daftar Fornas, indikasi BPOM, status generik.',
                'tipe_kriteria' => 'Benefit',
                'nilai_minimum' => 1,
                'nilai_maksimum' => 10,
                'fuzzy_set' => '1,6,10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kriteria' => 'Interaksi dan Komorbiditas',
                'deskripsi' => 'Potensi interaksi obat dan kesesuaian dengan penyakit penyerta pasien. Subkriteria: jumlah interaksi dan keselamatan untuk komorbiditas.',
                'tipe_kriteria' => 'Benefit',
                'nilai_minimum' => 1,
                'nilai_maksimum' => 10,
                'fuzzy_set' => '1,3,10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kriteria' => 'Ketersediaan dan Aksesibilitas',
                'deskripsi' => 'Ketersediaan obat di fasilitas primer berdasarkan stok Puskesmas dan Formularium Nasional.',
                'tipe_kriteria' => 'Benefit',
                'nilai_minimum' => 1,
                'nilai_maksimum' => 10,
                'fuzzy_set' => '1,4,10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
