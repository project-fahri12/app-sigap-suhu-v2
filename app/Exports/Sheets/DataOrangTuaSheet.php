<?php

namespace App\Exports\Sheets;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataOrangTuaSheet implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $sekolah_id;

    public function __construct($sekolah_id)
    {
        $this->sekolah_id = $sekolah_id;
    }

    public function query()
    {
        return Siswa::with(['pendaftar.orangTua']) // Asumsi relasi di model Pendaftar adalah ortu()
            ->whereHas('pendaftar', fn ($q) => $q->where('sekolah_id', $this->sekolah_id));
    }

    public function title(): string
    {
        return 'Data Orang Tua';
    }

    public function headings(): array
    {
        return [
            ['DATA ORANG TUA SISWA BARU'],
            ['NIS', 'NAMA SISWA', 'NAMA AYAH', 'NIK AYAH', 'PEKERJAAN AYAH', 'NAMA IBU', 'NIK IBU', 'PEKERJAAN IBU'],
        ];
    }

    public function map($siswa): array
    {
        $p = $siswa->pendaftar;
        $ortu = $p->ortu; // Sesuaikan dengan nama method relasi di model Pendaftar Anda

        return [
            $siswa->nis,
            $p->nama_lengkap,
            $ortu->nama_ayah ?? '-',
            "'".($ortu->nik_ayah ?? ''),
            $ortu->pekerjaan_ayah ?? '-',
            $ortu->nama_ibu ?? '-',
            "'".($ortu->nik_ibu ?? ''),
            $ortu->pekerjaan_ibu ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:H1');

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1565C0']], // Biru
            ],
        ];
    }
}
