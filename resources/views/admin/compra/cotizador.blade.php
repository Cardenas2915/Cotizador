@extends('layouts.panelAdmin')
@extends('layouts.app')

@push('styles')
    @vite('resources/css/spinner.css')
@endpush

@section('titulo')
    Cotizador
@endsection

@section('contenidoAdmin')
<div class="flex w-full flex-col p-4">
    <div class="mb-6 shadow px-6 py-4 bg-blue-100 rounded">
        <h1 class="text-2xl font-bold text-center">Realizar Cotización / Compra</h1>
    </div>

    <div class="px-6 shadow-lg py-4 bg-gray-100 mb-6">
        <form autocomplete="off" id="formulario">
            @csrf
            <div class="mb-6">
                <label for="nombreEmpresa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Empresa:</label>
                <select id="nombreEmpresa" name="nombreEmpresa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" selected disabled>Selecccione una opcion</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{$proveedor->id}}">{{$proveedor->name}}</option>
                @endforeach
                </select>

            </div> 
            <div class="mb-6 flex justify-between items-center">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Define los productos:</label>
                <div class="">
                    <button id="btnEliminar" class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                    Eliminar
                    </button>
                    <button id="btnAgregar" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                        Agregar
                    </button>
                </div>
                
            </div>
            <div class="mb-6">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th id="codigo" class="px-6 py-3">
                                Codigo
                            </th>
                            <th id="nombre" class="px-6 py-3">
                                Nombre
                            </th>
                            <th id="peso" class="px-6 py-3">
                                Peso
                            </th>
                            <th id="volumen" class="px-6 py-3">
                                Volumen
                            </th>
                            <th id="cantidad" class="px-6 py-3">
                                cantidad
                            </th>
                            <th id="precioSinIva" class="px-6 py-3">
                                Precios sin Impuestos
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tabla">
                    </tbody>
                </table>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cotizar</button>
        </form>
    </div>
    {{-- contenedor para mostrar los resultados de la cotizacion --}}
    <div class="bg-blue-100 rounded-lg shadow-lg">
        <div class="px-6 py-4 " id="alertas"> </div>
        <div class="px-6 py-4 " id="resultados"> </div>
    </div>
    
</div>

@endsection
@vite('resources/js/cotizador.js')
