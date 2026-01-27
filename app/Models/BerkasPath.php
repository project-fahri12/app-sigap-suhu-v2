<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BerkasPath extends Model
{
    use LogsActivity;

    protected $guarded = ['id'];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}
