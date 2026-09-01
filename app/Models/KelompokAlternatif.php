<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokAlternatif extends Model
{
    protected $fillable = [
        'dusun',
        'tanggal',
        'smart_processed_at',
        'copras_processed_at',
    ];

    protected $casts = [
        'smart_processed_at' => 'datetime',
        'copras_processed_at' => 'datetime',
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
