<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    //
    public function __construct()
    {
        
        $this->middleware('admin');
    }
    
    public function index(){
        $proveedores = Proveedor::paginate(5);
        return view ('admin.proveedor.index', compact('proveedores'));
    }

    public function store(Request $request){
        Proveedor::create([
            'name'=> $request->name,
            'contacto' => $request->contacto
        ]);
        return redirect()->route('proveedores');
    }
}
