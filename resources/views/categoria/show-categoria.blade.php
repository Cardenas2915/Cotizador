@extends('layouts.app')

@section('titulo')
    @foreach ($productos as $item)
        {{$item->categoria->name}}
    @endforeach
@endsection

@section('contenido')
    <x-banner />
    <section class="text-gray-600 body-font">
        <div class="container px-5 mt-6 mx-auto">
            @if ($productos->count())
                <h1 class="text-white text-2xl text-center m-auto uppercase py-3 mb-6 bg-indigo-700">Obten los productos que necesitas para tu setup</h1>
                <div id="lista-productos" class="grid md:grid-cols-3 xl:grid-cols-4 gap-4">
                    <x-show-categoria :productos="$productos" />
                </div>
            @else
                <div class="w-full p-6 bg-blue-400 shadow">
                    <h1 class="text-black text-2xl font-bold text-center mb-4">Oopss..</h1>
                    <p class="text-black font-semibold text-center ">En el momento no hay productos para la venta.</p>
                </div>
            @endif
        </div>
    </section>
@endsection