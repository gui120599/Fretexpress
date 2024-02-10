<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use HasFactory;
    protected $fillable = [
        'motorista_primeiro_nome',
        'motorista_sobrenome',
        'motorista_apelido',
        'motorista_celular',
    ];
}
