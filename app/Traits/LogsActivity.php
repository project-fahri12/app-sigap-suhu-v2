<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot trait ini secara otomatis pada Model.
     * Laravel akan memanggil fungsi boot[NamaTrait] secara otomatis.
     */
    protected static function bootLogsActivity()
    {
        // 1. Saat Data Dibuat
        static::created(function ($model) {
            $model->logToDatabase('CREATE');
        });

        // 2. Saat Data Diubah
        static::updated(function ($model) {
            $model->logToDatabase('UPDATE');
        });

        // 3. Saat Data Dihapus
        static::deleted(function ($model) {
            $model->logToDatabase('DELETE');
        });
    }

    /**
     * Fungsi untuk menyimpan ke tabel audit_logs
     */
    protected function logToDatabase($action)
    {
        // Ambil nama model tanpa namespace (Contoh: App\Models\Sekolah -> Sekolah)
        $modelName = class_basename($this);
        
        // Ambil label/nama dari model jika ada (untuk deskripsi yang lebih manusiawi)
        // Kita coba ambil dari kolom 'nama', 'label', atau 'username'
        $identifier = $this->nama ?? $this->label ?? $this->username ?? $this->id;

        AuditLog::create([
            'user_id'     => Auth::id() ?? 1, 
            'action'      => $action,
            'model'       => $modelName,
            'model_id'    => $this->id,
            'description' => "Melakukan $action pada data $modelName: ($identifier)",
            'ip_address'  => request()->ip(),
        ]);
    }
}