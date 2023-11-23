<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPedido extends Model
{
    use HasFactory;

    Protected $fillable = [
        'user_id',
        'direccion',
        'contacto', 
        'departamento', 
        'ciudad', 
        'estado',
        'coste'
    ];

    public function users(){
        $this->belongsTo(User::class);
    }
}
