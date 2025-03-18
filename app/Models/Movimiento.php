<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = ['articulo_id', 'cantidad', 'tipo', 'fecha', 'semana_id'];
    protected $dates = ['fecha'];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }

    public function semana()
    {
        return $this->belongsTo(Semana::class);
    }
}