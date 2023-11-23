<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dato extends Model
{
    use HasFactory;
    Protected $fillable = [
        'arancel',
        'flete',
        'costoImportacion',
        'totalCompra'
    ];

    public function compras()
    {
        return $this->hasOne(Compra::class);
    }
}
