<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Saida extends Model
{
    use HasFactory;
    protected $fillable =[
        'motorista_id',
        'saida_descricao',
        'saida_data',
        'saida_valor',
    ];

    public function motorista(): BelongsTo
    {
        return $this->belongsTo(related: Motorista::class);
    }
}
