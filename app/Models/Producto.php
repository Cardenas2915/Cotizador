<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    Protected $fillable = [
        'codigo',
        'name',
        'peso',
        'volumen',
        'precioVenta',
        'precioSinIva',
        'cantidad'
    ];
    
    public function compra()
    {
        return $this->hasMany(Compra::class);
    }

    public function item()
    {
        return $this->hasOne(Compra::class);
    }
}
