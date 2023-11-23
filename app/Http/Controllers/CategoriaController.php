<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    //
    public function index(){
        $categorias = Categoria::where('id','!=',1)->paginate(8);
        return view ('admin.categorias.categoria', [
            'categorias' => $categorias
        ]);
    }

    public function store(Request $request){

        if($request->imagen){
            $imagen= $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);

            $imagenPath = public_path('categorias') . "/" . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        Categoria::create([
            'name'=> $request->name,
            'imagen' => $nombreImagen
        ]);
        return redirect()->route('categoria');
    }

}
