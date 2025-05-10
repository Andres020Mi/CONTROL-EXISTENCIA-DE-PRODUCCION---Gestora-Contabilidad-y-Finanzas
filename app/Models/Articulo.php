<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'articulos';
    
    protected $fillable = ['nombre', 'unidad_medida','cantidad_inicial','precio_por_unidad','imagen'];

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
