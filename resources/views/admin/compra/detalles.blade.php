@extends('layouts.panelAdmin')
@extends('layouts.app')


@section('titulo')
    Detalles
@endsection

@section('contenidoAdmin')
<div class="flex w-full flex-col px-6">
    @foreach ($compras as $compra => $item)
    @if ($loop->first)
        <div class="text-black px-6 py-4 bg-blue-400 text-center shadow mb-6">
            <h1 class="text-xl font-bold mb-5">{{$item->proveedor->name}}</h1>
            <div class="flex justify-between gap-5 items-center">
                <p>Flete ${{$item->dato->flete}}</p>
                <p>Arancel ${{$item->dato->arancel}}</p>
                <p>Costo de importacion ${{$item->dato->costoImportacion}}</p>
                <p>Total Compra ${{$item->dato->totalCompra}}</p>
            </div>
        </div>
    @endif
    @endforeach
    
    <div class="px-6">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">
                            Serial
                        </th>
                        <th class="px-6 py-3">
                            Producto
                        </th>
                        <th class="px-6 py-3">
                            Precio sin impuestos
                        </th>
                        <th class="px-6 py-3">
                            cantidad
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$compra->productos->codigo}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$compra->productos->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$compra->precio}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$compra->cantidad}}
                        </th>
                    </tr>
                    @endforeach  
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection