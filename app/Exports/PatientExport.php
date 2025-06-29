<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithStyles, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return Patient::select('name', 'no_bpjs', 'gender', 'birth_date', 'address')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pasien',
            'No BPJS',
            'Gender',
            'Tanggal Lahir',
            'Alamat',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            "'" . (string) $row->no_bpjs,
            $row->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            $row->birth_date,
            $row->address,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Kolom B adalah no_bpjs
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header tebal, background biru muda, dan border seluruh tabel
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DDEBF7'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        // Border seluruh data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:E'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        // Judul di atas tabel
        $sheet->insertNewRowBefore(1, 1);
        $sheet->setCellValue('A1', 'Data Pasien PRB');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        return [];
    }

    public function title(): string
    {
        return 'Data Pasien';
    }
}
