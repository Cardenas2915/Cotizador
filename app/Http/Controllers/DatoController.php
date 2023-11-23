<?php

namespace App\Http\Controllers;

use App\Models\Dato;
use Illuminate\Http\Request;

class DatoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function store(Request $request){
        Dato::create([
            'arancel' => $request->input('arancel'),
            'flete' => $request->input('flete'),
            'costoImportacion' => $request->input('costoImportacion'),
            'totalCompra' => $request->input('totalCompra')
        ]);
        return response()->json(['message' => 'resultados correcto']);
    }

    public function obtenerUltimoId()
    {
        $ultimoRegistro = Dato::orderBy('id', 'desc')->first();
        
        if ($ultimoRegistro) {
            return response()->json(['ultimo_id' => $ultimoRegistro->id]);
        } 
    }
}
