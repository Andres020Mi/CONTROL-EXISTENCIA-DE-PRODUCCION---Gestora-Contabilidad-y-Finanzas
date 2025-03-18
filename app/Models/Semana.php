<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semana extends Model
{
    use HasFactory;

    protected $table = 'semanas';

    protected $fillable = ['inicio', 'fin', 'cantidad_total'];

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
