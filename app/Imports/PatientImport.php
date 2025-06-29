<?php

namespace App\Imports;

use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;

class PatientImport implements ToModel, WithHeadingRow, SkipsOnFailure, SkipsOnError, WithValidation
{
    use SkipsFailures, SkipsErrors;

    public $rowErrors = [];
    private $rowNumber = 2; // Mulai dari 2 karena 1 adalah header

    public function model(array $row)
    {
        $name = $row['name'] ?? $row['nama pasien'] ?? null;
        $no_bpjs = $row['no_bpjs'] ?? $row['no bpjs'] ?? null;
        $gender = $row['gender'] ?? null;
        $birth_date = $row['birth_date'] ?? $row['tanggal lahir'] ?? null;
        $address = $row['address'] ?? $row['alamat'] ?? null;

        // Skip baris kosong sepenuhnya
        if (empty($name) && empty($no_bpjs) && empty($gender) && empty($birth_date) && empty($address)) {
            $this->rowNumber++;
            return null;
        }

        // Hapus tanda petik satu di depan no_bpjs jika ada
        if ($no_bpjs && substr($no_bpjs, 0, 1) === "'") {
            $no_bpjs = substr($no_bpjs, 1);
        }

        // Mapping gender
        if ($gender) {
            $gender = strtolower($gender);
            if ($gender === 'laki-laki' || $gender === 'l') {
                $gender = 'L';
            } elseif ($gender === 'perempuan' || $gender === 'p') {
                $gender = 'P';
            } else {
                $this->rowErrors[] = "Baris {$this->rowNumber}: Gender tidak valid";
                $this->rowNumber++;
                return null;
            }
        }

        // Validasi sederhana
        if (empty($name) || empty($no_bpjs) || empty($gender) || empty($birth_date) || empty($address)) {
            $this->rowErrors[] = "Baris {$this->rowNumber}: Ada kolom yang kosong";
            $this->rowNumber++;
            return null;
        }

        // Cek duplikasi berdasarkan no_bpjs
        if (Patient::where('no_bpjs', (string) preg_replace('/\D/', '', $no_bpjs))->exists()) {
            $this->rowErrors[] = "Baris {$this->rowNumber}: No BPJS sudah ada di database";
            $this->rowNumber++;
            return null;
        }

        $this->rowNumber++;
        return new Patient([
            'name' => $name,
            'no_bpjs' => isset($no_bpjs) ? (string) preg_replace('/\D/', '', $no_bpjs) : '',
            'gender' => $gender,
            'birth_date' => $birth_date,
            'address' => $address,
            'created_by' => Auth::id() ?? 1,
        ]);
    }

    public function rules(): array
    {
        return [];
    }

    public function getRowErrors()
    {
        return $this->rowErrors;
    }
}
