@extends('layouts.panelAdmin')
@extends('layouts.app')

@section('titulo')
    Productos
@endsection

@section('contenidoAdmin')

<div class="flex w-full flex-col px-2">
    @if(session('mensaje'))
        <div class="bg-green-500 rounded-lg mb-6 text-white uppercase font-bold p-4">
            {{session('mensaje')}}
        </div>
    @endif

    <div class="px-6">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if ($productos->count())
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Serial
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Precio Venta
                        </th>
                        <th scope="col" class="px-6 py-3">
                            estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $producto->productos->codigo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $producto->productos->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $producto->stock }}
                            </td>
                            <td class="px-6 py-4">
                                $ {{ number_format($producto->productos->precioVenta) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1 items-center">
                                    <img class="h-4" src="{{$producto->estado == "Sin verificar" ? asset('img/cancelar.png') : asset('img/check.png')}}" alt="">
                                    {{ $producto->estado }}
                                </div>
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-5 items-center">
                                <button type="button" data-modal-target="ver-info" data-modal-toggle="ver-info{{$producto->id }}" class="text-blue-700 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                    Ver
                                </button>
                                <button type="button" data-modal-target="crypto-modal" data-modal-toggle="crypto-modal{{$producto->id }}" class="text-blue-700 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                    Editar
                                </button>
                                <button class="border border-gray-200 rounded-lg p-3 font-medium text-red-600 dark:text-red-500 hover:bg-gray-100 hover:border-gray-200"><a href="">Eliminar</a></button>
                            </td>
    
                        </tr>
                        
                        <!-- Main modal para editar el producto-->
                            <div id="crypto-modal{{$producto->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="crypto-modal{{$producto->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <!-- Modal header -->

                                        <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                                                {{$producto->productos->name}}
                                            </h3>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6">
                                            <ul class="my-4 space-y-3">
                                                
                                                <form id="formProductos" method="POST" action="{{route('update.producto.item')}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="idProducto" value="{{$producto->productos->id}}">
                                                    <input type="hidden" name="idItem" value="{{$producto->id}}">
                                                    <div>
                                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                                                        <input type="text" value="{{$producto->productos->name}}" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    </div>
                                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                                        <div>
                                                            <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial</label>
                                                            <input type="text" value="{{$producto->productos->codigo}}" id="codigo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                                                        </div>
                                                        <div>
                                                            <label for="categoria" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
                                                            <select id="categoria" name="categoria" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                @foreach ($categorias as $categoria)
                                                                    <option  value="{{ $categoria->id }}" {{ $categoria->id == $producto->categoria->id ? 'selected' : '' }}>
                                                                        {{ $categoria->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>  
                                                        <div>
                                                            <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                                                            <input type="hidden" name="precio" value="{{$producto->productos->precioVenta}}">
                                                            <input type="text" value="{{number_format($producto->productos->precioVenta)}}" id="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        </div>
                                                        <div>
                                                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                                            <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                <option value="Sin verificar" {{ $producto->estado == 'Sin verificar' ? 'selected' : '' }}>Sin verificar</option>
                                                                <option value="Verificado" {{ $producto->estado == 'Verificado' ? 'selected' : '' }}>Verificado</option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                    <div class="mb-6">
                                                        <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion:</label>
                                                        <textarea id="descripcion" name="descripcion" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Describe tu producto">{{$producto->descripcion}}</textarea>
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Imagen:</label>
                                                        <input name="imagen" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or JPG (MAX. 800x400px).</p>
                                                    </div>
                                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Editar</button>
                                                </form>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- Main modal para ver el producto-->
                            <div id="ver-info{{$producto->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                            <div class="flex flex-col">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    {{$producto->productos->name}}
                                                </h3>
                                                <p class="font-normal text-sm text-gray-500"><span class="text-gray-700">Serial:</span> {{$producto->productos->codigo}}</p>
                                            </div>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="ver-info{{$producto->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6 space-y-6">
                                            <div class="flex gap-6">
                                                <img class="h-40" src="{{ asset('uploads' . '/' . $producto->imagen) }}"
                                                alt="Imagen del producto {{ $producto->imagen }}">
                                                <div class="flex flex-col mb-3 ">
                                                    <h3 class="font-bold mb-1">Descripcion</h3>
                                                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-600">
                                                        {{$producto->descripcion}} 
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                                <div class="flex flex-col mb-1 ">
                                                    <h3 class="font-bold">Volumen</h3>
                                                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-600">
                                                        {{$producto->productos->volumen}} m3
                                                    </p>
                                                </div>
                                                <div class="flex flex-col mb-1">
                                                    <h3 class="font-bold">Peso</h3>
                                                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-600">
                                                        {{$producto->productos->peso}} kg
                                                    </p>
                                                </div>
                                                <div class="flex flex-col mb-1">
                                                    <h3 class="font-bold">Precio de venta</h3>
                                                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-600">
                                                        $ {{number_format($producto->productos->precioVenta)}}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col mb-1">
                                                    <h3 class="font-bold">Estado</h3>
                                                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-600">
                                                        {{$producto->estado}}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col mb-1">
                                                    <h3 class="font-bold">Categoria</h3>
                                                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-600">
                                                        {{$producto->categoria->name}}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col mb-1">
                                                    <h3 class="font-bold">precio Sin impuestos</h3>
                                                    <p class="text-base leading-relaxed text-gray-700 dark:text-gray-600">
                                                        $ {{number_format($producto->productos->precioSinIva)}}
                                                    </p>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
            @else
                <p class="text-black font-bold px-6 py-4 bg-blue-400 text-center shadow">No hay productos registrados</p>
            @endif
        </div>
    </div>
</div>
@endsection

@vite('resources/js/productos.js')



