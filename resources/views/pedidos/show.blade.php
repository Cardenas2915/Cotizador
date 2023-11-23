@extends('layouts.app')

@section('titulo')
    Mis pedidos
@endsection

@section('contenido')
<div class="mb-5 p-10 bg-indigo-100 rounded-lg">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Tus pedidos
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Los productos tienen un plazo de 8 dias para ser enviados</p>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Direccion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        contacto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ciudad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Productos
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pedidosAgrupados as $pedidoId => $lineasPedido)
                    @php
                        $primerPedido = $lineasPedido->first();
                    @endphp
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $primerPedido->info_pedidos->direccion }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $primerPedido->info_pedidos->contacto }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $primerPedido->info_pedidos->ciudad }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $primerPedido->info_pedidos->coste }}
                        </td>
                        <td class="flex m-auto px-6 py-4 text-right">
                            <button data-modal-target="default-modal" data-modal-toggle="default-modal{{ $pedidoId }}" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                Ver
                            </button>
                        </td>
                    </tr>

                    <!-- Main modal -->
                    <div id="default-modal{{ $pedidoId }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Productos del pedido {{ $pedidoId }}
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal{{ $pedidoId }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <h1 class="font-semibold uppercase">Nombre</h1>
                                    @foreach ($lineasPedido as $lineaPedido)
                                        <div class="flex gap-5 items-center border-b border-gray-400">
                                            <div class="">
                                                <img class="w-16" src="{{ asset('uploads/' . $lineaPedido->item->imagen) }}" alt="">
                                            </div>
                                            <div class="">
                                                <p>{{ $lineaPedido->item->productos->name }}</p>
                                                <p><span class="text-sm font-semibold">Unidades: </span>{{ $lineaPedido->unidades }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-indigo-600 text-xl font-semibold text-center uppercase">Actualmente no tienes pedidos!</p>
                @endforelse

            </tbody>
        </table>
    </div>
</div>    
@endsection