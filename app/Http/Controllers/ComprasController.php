<?php

namespace App\Http\Controllers;

use App\Models\Dato;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $consulta = Compra::with('dato', 'proveedor')->get();
        
        // Agrupa las compras por dato_id
        $datos = $consulta->groupBy('dato_id');

        return view('admin.compra.compras', compact('datos'));
    }
    
    public function cotizar()
    {
        $proveedores = Proveedor::all();
        return view ('admin.compra.cotizador',['proveedores'=> $proveedores]);
    }

    public function store(Request $request)
    {
        
        $datos = $request->input('datos');
        
        foreach ($datos as $dato) {

                Compra::create([
                    'proveedor_id' => $dato['idEmpresa'],
                    'producto_id' => $dato['idProducto'],
                    'dato_id' => $dato['idCompra'],
                    'cantidad' => $dato['cantidad'],
                    'precio' => $dato['precio']
                ]);
            
        }
        return response()->json(['message' => 'Compra Registrada']);
    }

    public function detalles($datoId)
    {
        // Obtener las compras con el dato_id deseado y cargar las relaciones
        $compras = Compra::where('dato_id', $datoId)->get();
        $compras->load('productos', 'proveedor','dato');
        
        return view('admin.compra.detalles', compact('compras'));
    }
}
