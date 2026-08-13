<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Copras extends Model
{
    protected $fillable = [
        'alternatif_id',
        'kelompok_id',
        'nilai',
        'ranking'
    ];

    protected $table = 'copras';

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
