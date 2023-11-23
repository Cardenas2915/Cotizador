@extends('layouts.app')

@section('titulo')
    Compra Exitosa!
@endsection

@section('contenido')
    {{-- barra de progreso --}}
    <div class="mb-5 p-10 bg-indigo-100 rounded-lg">
        <div>
        <div class="overflow-hidden rounded-full bg-gray-200">
            <div class="h-2 w-full rounded-full bg-blue-500"></div>
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

            <li class="flex items-center justify-center sm:gap-1.5 text-blue-600">
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

            <li class="flex items-center justify-end sm:gap-1.5 text-blue-600">
                <span class="hidden sm:inline"> Compra exitosa! </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </li>
        </ol>
        </div>
    </div>

<section class="flex p-6 bg-indigo-100 rounded-lg justify-center items-center">
    <div class="lg:col-span-2">
        <h1 class="text-xl font-bold text-gray-900 sm:text-3xl mb-6">Tu compra fue exitosa!</h1>
        <a class="group relative inline-flex w-full text-center uppercase text-2xl items-center overflow-hidden rounded bg-indigo-600 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500"
        href="{{ route('home') }}">
            <span class="absolute -end-full transition-all group-hover:end-4">
                <svg class="h-5 w-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                    />
                </svg>
            </span>
            <span class="text-sm font-medium transition-all group-hover:me-4">
                volver a inicio
            </span>
            </a>
    </div>


</section>
@endsection