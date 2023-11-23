@extends('layouts.panelAdmin')
@extends('layouts.app')

@section('titulo')
    Panel Administrativo
@endsection

@section('contenidoAdmin')
<div class="flex flex-col w-full px-6">
    @if ($datos->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 grid-rows-3 px-6">
        @foreach ($datos as $datoId => $compras)
            <div class="inline-block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                @foreach ($compras as $compra)
                    @if ($loop->first)
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $compra->proveedor->name }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Total Compra ${{ $compra->dato->totalCompra }}</p>
                        <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Fecha de compra: {{ $compra->created_at->format('d/m/Y') }}</p>
                    @endif
                @endforeach
                <a href="{{route('detalles.compra', $compra->dato_id)}}" class="inline-flex items-center text-blue-600 hover:underline">
                    Ver detalles
                    <svg class="w-3 h-3 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                    </svg>
                </a>
            </div>
        @endforeach
    </div>
    
    @else
        <p class="block text-black font-bold px-6 py-4 bg-blue-400 text-center shadow">No hay Compras registradas</p>
    @endif
</div>
@endsection




