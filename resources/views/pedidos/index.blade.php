@extends('layouts.app')

@section('titulo')
    Mi carrito
@endsection

@section('contenido')

    {{-- barra de progreso --}}
    <div class="mb-5 p-10 bg-indigo-100 rounded-lg">
        <div>
        <div class="overflow-hidden rounded-full bg-gray-200">
            <div class="h-2 w-6 rounded-full bg-blue-500"></div>
        </div>

        <ol class="mt-4 grid grid-cols-3 text-sm font-medium text-gray-500">
            <li class="flex items-center justify-start text-blue-600 sm:gap-1.5">
            <span class="hidden sm:inline"> Detalles </span>

            <svg
                class="h-6 w-6 sm:h-5 sm:w-5"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"
                />
            </svg>
            </li>

            <li class="flex items-center justify-center sm:gap-1.5">
            <span class="hidden sm:inline"> Direccion </span>

            <svg
                class="h-6 w-6 sm:h-5 sm:w-5"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                />
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                />
            </svg>
            </li>

            <li class="flex items-center justify-end sm:gap-1.5">
                <span class="hidden sm:inline"> Compra exitosa! </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </li>
        </ol>
        </div>
    </div>

<section class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8 p-6 bg-indigo-100 rounded-lg ">
    <div class="lg:col-span-2">
        <header class="text-center">
            <h1 class="text-xl font-bold text-gray-900 sm:text-3xl">Tus productos</h1>
        </header>

        <div class="mt-4 p-3">
            <ul class="space-y-4" id="detalles-car">
                
            </ul>
        </div>
    </div>

    <div class="h-80 bg-white p-6 rounded-lg mt-16">
        <h1 class="text-xl font-bold text-gray-900 ">Resumen del pedido</h1>
        <div class="mt-4 flex justify-end border-t-2 border-gray-100 pt-4">
            <div class="w-screen max-w-lg space-y-4" >
                <div class="" id="resumenPedido"></div>
                <div class="flex flex-col justify-center">
                    <a
                    href="{{ route('info.pedido') }}" id="btnCompra"
                    class="w-full text-center rounded bg-indigo-600 px-5 py-3 text-white transition hover:bg-indigo-700 font-semibold"
                    >
                    Realizar compra
                    </a>
                    <a class="flex text-gray-600 text-center m-auto mt-5 hover:text-indigo-700 font-semibold" href="{{route('home')}}">Continuar comprando</a>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@vite('resources/js/detallesCar.js')