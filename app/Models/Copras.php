<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Copras extends Model
{
    protected $fillable = [
        'alternatif_id',
        'kelompok_id',
        'nilai',
        'ranking',
    ];

    protected $casts = [
        'nilai' => 'decimal:10',
        'ranking' => 'integer',
    ];

    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(Alternatif::class);
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(
            KelompokAlternatif::class,
            'kelompok_id'
        );
    }
}
