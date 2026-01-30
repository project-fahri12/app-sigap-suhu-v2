<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SiswaExport implements WithMultipleSheets
{
    protected $sekolah_id;

    public function __construct($sekolah_id)
    {
        $this->sekolah_id = $sekolah_id;
    }

    public function sheets(): array
    {
        return [
            new Sheets\DataPendaftarSheet($this->sekolah_id),
            new Sheets\DataOrangTuaSheet($this->sekolah_id),
            new Sheets\DataWaliSheet($this->sekolah_id),
        ];
    }
}