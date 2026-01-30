<?php

namespace App\Exports\Sheets;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataWaliSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected int $sekolah_id;

    public function __construct($sekolah_id)
    {
        $this->sekolah_id = $sekolah_id;
    }

    public function collection()
    {
        return Siswa::with(['pendaftar.wali'])
            ->whereHas('pendaftar', function ($q) {
                $q->where('sekolah_id', $this->sekolah_id);
            })
            ->get();
    }

    public function title(): string
    {
        return 'Data Wali';
    }

    public function headings(): array
    {
        return [
            ['DATA WALI SISWA'],
            ['NIS', 'NAMA SISWA', 'NAMA WALI', 'NIK WALI', 'HUBUNGAN', 'PEKERJAAN', 'ALAMAT WALI'],
        ];
    }

    public function map($siswa): array
    {
        $pendaftar = $siswa->pendaftar;
        $wali = $pendaftar?->wali;

        return [
            $siswa->nis ?? '-',
            $pendaftar?->nama_lengkap ?? '-',
            $wali?->nama_wali ?? '-',
            "'".($wali?->nik_wali ?? ''),
            $wali?->hubungan ?? '-',
            $wali?->pekerjaan_wali ?? '-',
            $wali?->alamat_lengkap ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->mergeCells('A1:G1');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 14],
            ],
            2 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E65100'],
                ],
            ],
        ];
    }
}
