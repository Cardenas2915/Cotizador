
    @foreach ($productos as $producto)
    <div class="flex flex-col p-4 border shadow rounded-lg">
        <a class="relative h-48 rounded overflow-hidden">
            <img alt="Imagen del producto {{ $producto->imagen }}" class="object-cover object-center w-full h-full block" src="{{ asset('uploads') . '/' . $producto->imagen }}">
        </a>
        <div class="mt-4">
            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{$producto->categoria->name}}</h3>
            <h2 class="text-gray-900 title-font text-lg font-medium">{{$producto->productos->name}}</h2>
            <p class="mt-1"> {!! Str::limit($producto->descripcion,100); !!}</p>
            <p class="mt-1 font-normal text-red-600 precio">$<span class="font-semibold"> {{number_format($producto->productos->precioVenta)}} </span>COP</p>
            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1 stock">Unidades disponibles: <span class="text-semibold">{{$producto->stock}}</span></h3>
        </div>
        <div class="flex flex-col justify-center mt-auto gap-1">
            <button data-id="{{$producto->productos->id}}" class="flex justify-center w-full font-semibold text-center px-3 py-2 bg-blue-500 rounded text-white hover:bg-blue-700 agregar-carrito">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Añadir al carrito
            </button>
            <button type="button" data-modal-target="ver-info" data-modal-toggle="ver-info{{$producto->id }}" class="flex justify-center w-full font-semibold text-center px-3 py-2 bg-gray-500 rounded text-white hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                Informacion
            </button>
        </div>
    </div>

    {{-- Modal para mostrar producto --}}
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
                    <div class="flex justify-center items-center">
                        <img class="h-80 w-80" src="{{ asset('uploads' . '/' . $producto->imagen) }}"
                        alt="Imagen del producto {{ $producto->imagen }}">
                    </div>
                    <div class="flex flex-col gap-6 mb-3">
                        <div class="flex flex-col mb-1">
                            <p class="text-2xl leading-relaxed text-blue-700 dark:text-blue-600">
                                $ {{number_format($producto->productos->precioVenta)}}
                            </p>
                        </div>
                        <div class="flex flex-col mb-3 ">
                            <h3 class="font-bold mb-1 text-2xl text-black">Descripcion</h3>
                            <p class="text-base leading-relaxed text-gray-700">
                                {{$producto->descripcion}} 
                            </p>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>

    @endforeach
    
