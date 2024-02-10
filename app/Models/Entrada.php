<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrada extends Model
{
    use HasFactory;
    protected $fillable =[
        'frete_id',
        'motorista_id',
        'entrada_descricao',
        'entrada_data',
        'entrada_valor',
    ];

    public function frete(): BelongsTo
    {
        return $this->belongsTo(related: Frete::class);
    }
    public function motorista(): BelongsTo
    {
        return $this->belongsTo(related: Motorista::class);
    }
}
