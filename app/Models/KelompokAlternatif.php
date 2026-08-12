<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokAlternatif extends Model
{
    protected $fillable = [
        'dusun',
        'tanggal',
    ];

    public function alternatifs(): HasMany
    {
        return $this->hasMany(Alternatif::class, 'kelompok_id');
    }

    public function smarts(): HasMany
    {
        return $this->hasMany(Smart::class, 'kelompok_id');
    }

    public function copras(): HasMany
    {
        return $this->hasMany(Copras::class, 'kelompok_id');
    }
}
