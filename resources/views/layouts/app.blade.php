<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
        
        <!-- JavaScript -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

        @vite('resources/css/app.css')
        @stack('styles')
        <title>Tienda - @yield('titulo')</title>
        
    </head>
<body>

    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center">
                <img src="{{asset('img/logoSinFondo.png')}}" class="h-20 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white uppercase">Tienda Gamer</span>
            </a>
            <div class="flex items-center md:order-2 gap-3">
                @guest
                    <a href="{{ route('login') }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:bg-indigo-500">
                        Iniciar sesion
                    </a>
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center overflow-hidden rounded border border-current px-4 py-2 text-indigo-600 focus:outline-none focus:ring active:text-indigo-500">
                        <span class="absolute -start-full transition-all group-hover:start-2">
                            <svg
                                class="h-5 w-5 rtl:rotate-180"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4">
                            Registrarse
                        </span>
                    </a>
                @endguest
                @auth
                    <h1 class="text-sm font-normal">Hola: <span class="font-semibold">{{auth()->user()->name}}</span> </h1>
                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <img class="w-8 h-8 rounded-full" src="{{asset('img/user.png')}}" alt="user photo">
                </button>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Perfil</a>
                        </li>
                        @if (auth()->user()->rol == "admin")
                            <li>
                                <a href="{{route('admin.panel')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Panel Admin</a>
                            </li>
                        @endif
                        @if (auth()->user()->rol == "cliente")
                        <li>
                            <a href="{{ route('misPedidos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mis pedidos</a>
                        </li>
                        @endif
                        <li>
                            <form action="{{route('logout')}}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                @csrf
                                <button type="submit" class="">Cerrar Sesion</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
                
                
                @if(!(request()->is('miCarrito') || request()->is('informacionPedido') || request()->is('CompraRealizada')))
                    <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="relative flex bg-indigo-100 rounded-3xl px-4 py-2" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <p class="text-indigo-800 font-bold" id="cantidad-carrito"></p>
                    </button>
                        
                        <!-- Dropdown Carrito-->
                        <div id="dropdownHover" class="hidden absolute left-0 bottom-full ml-2 w-96 p-6 z-10 bg-indigo-100 divide-y divide-gray-100 rounded-lg shadow">
                            <div class="mt-4 space-y-6" id="carrito">
                                <ul class="space-y-4" id="carrito-body">
                                </ul>
                                <div class="space-y-2 text-center">
                                    <div class="flex justify-between p-2 border-t border-gray-300">
                                        <p class="font-semibold">Total compra:</p>
                                        <p class="text-red-700 font-semibold" id="precioTotal"></p>
                                    </div>
                                    <a id="enlace-miCarrito" class="cursor-pointer block rounded border border-gray-600 py-2 text-sm text-gray-600 transition hover:ring-1 hover:ring-gray-400" >
                                        Ver mi carrito
                                    </a>
                                    <a id="vaciar-carrito" class="block rounded bg-red-500 py-2 text-sm text-white transition hover:bg-red-700 cursor-pointer">
                                        Vaciar carrito
                                    </a>
                                </div>
                            </div>
                        </div>
                @endif
                
                
            </div>

        </div>
    </nav>

    <main class="container mx-auto mt-5" id="lista-productos">
        @yield('contenido')
    </main>
    <footer class="mt-10">
        
    </footer>
@vite('resources/js/app.js')

</body>
</html>


