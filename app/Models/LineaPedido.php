<?php

namespace App\Models;

use App\Models\Item;
use App\Models\InfoPedido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LineaPedido extends Model
{
    use HasFactory;
    Protected $fillable = [
        'pedido_id',
        'item_id',
        'unidades'
    ];

    public function info_pedidos(){
        return $this->belongsTo(InfoPedido::class, 'pedido_id');
    }

    public function Item(){
        return $this->belongsTo(Item::class, 'item_id');
    }
}
