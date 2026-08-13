<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smart extends Model
{
    protected $fillable = [
        'alternatif_id',
        'kelompok_id',
        'nilai',
        'ranking'
    ];

    protected $table = 'smarts';

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}