<?php

namespace App\Http\Controllers;

use App\Models\InfoPedido;
use Illuminate\Http\Request;

class InfoPedidoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        
        return view('pedidos.infoPedido');
    }

    public function store(Request $request){

        $datos = $request->input('datos');
        
        InfoPedido::create([
            'user_id' => auth()->user()->id,
            'direccion' => $datos['direccion'],
            'contacto' => $datos['contacto'],
            'departamento' => $datos['departamento'],
            'ciudad' => $datos['ciudad'],
            'estado' => "Pendiente",
            'coste' => $datos['coste']
        ]);

        $ultimoRegistro = InfoPedido::orderBy('id', 'desc')->first();
        
        return response()->json(['idRegistro' => $ultimoRegistro->id]);
    }

    
}
