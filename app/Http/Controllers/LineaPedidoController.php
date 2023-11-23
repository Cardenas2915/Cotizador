<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\Producto;
use App\Models\LineaPedido;
use Illuminate\Http\Request;

class LineaPedidoController extends Controller
{
    //
    public function index()
    {
        return view('pedidos.index');
    }

    public function compraRealizada(){
        return view('pedidos.confirmacion');
    }

    public function show(){
        
        $pedidos = LineaPedido::with(['item.productos', 'info_pedidos'])
        ->join('info_pedidos', 'linea_pedidos.pedido_id', '=', 'info_pedidos.id')
        ->join('users', 'info_pedidos.user_id', '=', 'users.id')
        ->select('linea_pedidos.*')
        ->where('users.id', '=', auth()->user()->id)
        ->get();

    // Agrupa los resultados por pedido_id
        $pedidosAgrupados = $pedidos->groupBy('pedido_id');

        return view('pedidos.show', [
            'pedidosAgrupados' => $pedidosAgrupados
        ]);
    }
    
    public function store(Request $request){

        $datos = $request->input('datos');

        foreach($datos as $dato){

            LineaPedido::create([
            'pedido_id' => $dato['pedido_id'], 
            'item_id' => $dato['producto_id'],
            'unidades' => $dato['unidades']
            ]);

            $producto = Item::find($dato['producto_id']);
            $stock = $producto['stock'];
            $stockActualizado = $stock - $dato['unidades'];
            
            $producto['stock'] = $stockActualizado;
            $producto->update(); 
        }



        return response()->json(['idRegistro' => $stockActualizado]);
    }
}
