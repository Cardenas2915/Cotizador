<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('admin');
    }

    public function store(Request $request){
        
        $productos = $request->input('productos');
        
        foreach ($productos as $producto) {
            $code = $producto['codigo'];
            $existeProducto = Producto::where('codigo', $code)->first();
            
            if ($existeProducto) {
                // El producto ya existe, actualiza sus datos con los valores proporcionados
                $existeProducto->update([
                    'codigo' => $producto['codigo'],
                    'name' => $producto['nombre'],
                    'peso' => $producto['peso'],
                    'volumen' => $producto['volumen'],
                    'precioVenta' => $producto['precioVenta'],
                    'precioSinIva' => $producto['precioSinIva'],
                    'cantidad' => $producto['cantidad']
                ]);
            } else {
                // El producto no existe, crea un nuevo producto con los valores proporcionados
                Producto::create([
                    'codigo' => $producto['codigo'],
                    'name' => $producto['nombre'],
                    'peso' => $producto['peso'],
                    'volumen' => $producto['volumen'],
                    'precioVenta' => $producto['precioVenta'],
                    'precioSinIva' => $producto['precioSinIva'],
                    'cantidad' => $producto['cantidad']
                ]);
            }
        }
        
        return response()->json(['message' => 'Productos guardados con éxito']);
    }

    public function buscarCodigos(Request $request)
    {
        // Obtén los códigos del objeto enviado
        $codigos = $request->input('codigos');

        // Inicializa un array para almacenar la información de los productos encontrados
        $productosEncontrados = [];

        foreach ($codigos as $codigo) {
            $codigoActual = $codigo['codigo'];
            $productoEncontrado = Producto::where('codigo', $codigoActual)->first();

            if (!is_null($productoEncontrado)) {
                $producto = [
                    'id' => $productoEncontrado->id,
                    'cantidad' => $productoEncontrado->cantidad, // Reemplaza 'cantidad' por el nombre correcto del campo en tu base de datos
                    'precio' => $productoEncontrado->precioSinIva // Reemplaza 'precio' por el nombre correcto del campo en tu base de datos
                ];
                $productosEncontrados[] = $producto;
            }
        }

        return response()->json(['productos_encontrados' => $productosEncontrados]);
    }

}
