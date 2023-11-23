<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    Protected $fillable = [
        'proveedor_id',
        'producto_id',
        'dato_id',
        'cantidad',
        'precio'
    ];


    // Relación con proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Relación con producto
    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Relación con dato
    public function dato()
    {
        return $this->belongsTo(Dato::class, 'dato_id');
    }
}
