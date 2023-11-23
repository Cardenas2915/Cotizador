<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ItemController extends Controller
{
     //
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        $productos = Item::with('productos','categoria')->get();
        $categorias = Categoria::all();
        return view ('admin.productos.producto', compact('productos','categorias'));
    }
    
    public function store(Request $request)
    {
        $datos = $request->input('datos');
        
        foreach ($datos as $dato) {
            $id = $dato['idProducto'];
            $productoEncontrado = Item::where('producto_id', $id)->first();
            
            if($productoEncontrado){

                $stock = $productoEncontrado->stock;
                $stockActualizado = $stock + $dato['stock'];
                $productoEncontrado->update([
                    'stock' => $stockActualizado
                ]);

            }else{

                Item::create([
                    'producto_id' => $dato['idProducto'],
                    'categoria_id' => $dato['idCategoria'],
                    'imagen' => $dato['imagen'],
                    'descripcion' => $dato['descripcion'],
                    'stock' => $dato['stock'],
                    'estado' => $dato['estado']
                ]);
            }

        }
        return response()->json(['message' => 'Items Actualizados']);
    }

    public function update(Request $request)
    {
        if($request->imagen){
            $imagen= $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);

            $imagenPath = public_path('uploads') . "/" . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios del item

        $item = Item::find($request->idItem);
        $NombreActualImagen = $item->imagen;
        $item->descripcion = $request->descripcion;
        $item->imagen = $nombreImagen ?? $NombreActualImagen ?? 'default.jpg';
        $item->estado = $request->estado;
        $item->categoria_id = $request->categoria ?? 1;
        $item->save();

        //Guardar cambios del producto
        $producto = Producto::find($request->idProducto);
        $producto->precioVenta = $request->precio;
        $producto->name = $request->name;
        $producto->save();


        //Redireccionar
        return back()->with('mensaje','Producto Actualizado');
    }
}
