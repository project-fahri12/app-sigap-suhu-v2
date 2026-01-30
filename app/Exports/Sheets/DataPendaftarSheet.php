<?php

namespace App\Exports\Sheets;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataPendaftarSheet implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected int $sekolah_id;

    public function __construct($sekolah_id)
    {
        $this->sekolah_id = $sekolah_id;
    }

    public function query()
    {
        return Siswa::with('pendaftar')
            ->whereHas('pendaftar', function ($q) {
                $q->where('sekolah_id', $this->sekolah_id);
            });
    }

    public function title(): string
    {
        return 'Data Pendaftar';
    }

    public function headings(): array
    {
        return [
            ['DATA SISWA BARU TAHUN AJARAN '.date('Y')],
            [
                'NIS',
                'KODE DAFTAR',
                'NAMA LENGKAP',
                'NIK',
                'JK',
                'TEMPAT LAHIR',
                'TGL LAHIR',
                'ALAMAT',
                'ASAL SEKOLAH',
            ],
        ];
    }

    public function map($siswa): array
    {
        $p = $siswa->pendaftar;

        return [
            $siswa->nis ?? '-',
            $p?->kode_pendaftaran ?? '-',
            $p?->nama_lengkap ?? '-',
            "'".($p?->nik ?? ''),
            $p?->jenis_kelamin ?? '-',
            $p?->tempat_lahir ?? '-',
            $p?->tanggal_lahir ?? '-',
            trim(
                ($p?->alamat_lengkap ?? '').
                ', '.($p?->desa ?? '').
                ', '.($p?->kecamatan ?? ''), ', '),
            $p?->sekolah_asal ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
                    'startColor' => ['rgb' => '2E7D32'],
                ],
            ],
        ];
    }
}
