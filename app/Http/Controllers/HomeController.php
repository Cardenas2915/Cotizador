<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    //
    public function index()
    {
        $productos = Item::where('estado', 'Verificado')->where('stock','>',0)->get();
        $productos->load('productos', 'categoria');
        
        $categorias = Categoria::where('id','!=',1)->get();

        return view ('home', [
            'categorias' => $categorias,
            'productos' => $productos
        ]);
    }

    public function showCategoria($id)
    {
        $productos = Item::where('categoria_id', $id)->where('stock','>',0)->get();

        return view('categoria.show-categoria', [
            'productos' => $productos
        ]);
    }
}
