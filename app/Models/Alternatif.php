<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternatif extends Model
{
    protected $fillable = [
        'kelompok_id',
        'nama',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(
            KelompokAlternatif::class,
            'kelompok_id'
        );
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function smarts(): HasMany
    {
        return $this->hasMany(Smart::class);
    }

    public function copras(): HasMany
    {
        return $this->hasMany(Copras::class);
    }
}
