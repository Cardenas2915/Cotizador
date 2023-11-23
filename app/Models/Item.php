<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    Protected $fillable = [
        'producto_id',
        'categoria_id',
        'imagen',
        'descripcion',
        'stock',
        'estado'
    ];

    // Relación con producto
    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Relación con categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

}
