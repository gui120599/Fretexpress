<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Frete extends Model
{
    use HasFactory;
    protected $fillable =[
        'frete_descricao_carga',
        'motorista_id',
        'frete_empresa',
        'frete_municipio_saida',
        'frete_municipio_destino',
        'frete_valor_km',
        'frete_distancia_percorrida',
        'frete_valor_total',
        'frete_data_saida',
        'frete_data_chegada',
        'frete_data',
    ];
    public function motorista(): BelongsTo //Relacionamento chave estrangeira
    {
        return $this->belongsTo(related: Motorista::class);
    }

}
