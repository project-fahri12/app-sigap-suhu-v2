<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Santri extends Model
{
    use LogsActivity;
    protected $fillable = [
        'pondok_id',
        'pendaftar_id',
        'sekolah_id',
        'romkam_id',
        'nis',
        'status_santri',
    ];

    // =====================
    // RELATIONS
    // =====================

    public function pondok(): BelongsTo
    {
        return $this->belongsTo(Pondok::class);
    }

    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function romkam(): BelongsTo
    {
        return $this->belongsTo(Romkam::class);
    }

    
}
