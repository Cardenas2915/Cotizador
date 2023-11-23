@extends('layouts.app')
@push('script')
    <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
@endpush
@section('titulo')
    Registrarse
@endsection

@section('contenido')
<div class="relative">
    <img src="{{asset('img/login.jpg')}}" class="absolute inset-0 object-cover w-full h-full" alt="" />
    <div class="relative bg-gray-900 bg-opacity-75">
    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
        <div class="flex flex-col items-center justify-between xl:flex-row">
        <div class="w-full max-w-xl mb-12 xl:mb-0 xl:pr-16 xl:w-7/12">
            <h2 class="max-w-lg mb-6 font-sans text-3xl font-bold tracking-tight text-white sm:text-4xl sm:leading-none">
            The quick, brown fox <br class="hidden md:block" />
            jumps over a <span class="text-teal-accent-400">lazy dog</span>
            </h2>
            <p class="max-w-xl mb-4 text-base text-gray-400 md:text-lg">
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudan, totam rem aperiam, eaque ipsa quae.
            </p>
            <a href="/" aria-label="" class="inline-flex items-center font-semibold tracking-wider transition-colors duration-200 text-teal-accent-400 hover:text-teal-accent-700">
            Learn more
            <svg class="inline-block w-3 ml-2" fill="currentColor" viewBox="0 0 12 12">
                <path d="M9.707,5.293l-5-5A1,1,0,0,0,3.293,1.707L7.586,6,3.293,10.293a1,1,0,1,0,1.414,1.414l5-5A1,1,0,0,0,9.707,5.293Z"></path>
            </svg>
            </a>
        </div>
        <div class="w-full max-w-xl xl:px-8 xl:w-5/12">
            <div class="bg-white rounded shadow-2xl p-7 sm:p-10">
            <h3 class="mb-4 text-xl font-semibold sm:text-center sm:mb-6 sm:text-2xl">
                Registrate!
            </h3>
            <form action="{{ route('register') }}" method="POST" class="flex flex-col">
                @csrf

                <div class="mb-1 sm:mb-2">
                    <label for="name" class="inline-block mb-1 font-medium">Nombre:</label>
                    <input type="text" id="name" name="name" value="{{old('name')}}"
                    class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline  @error('name') border-red-500 @enderror"
                    />
                @error('name')
                    <p class="flex mt-1 items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">{{$message}}</p>
                @enderror
                </div>

                <div class="mb-1 sm:mb-2">
                    <label for="email" class="inline-block mb-1 font-medium">Email:</label>
                    <input type="email" id="email" name="email" value="{{old('email')}}"
                    class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline  @error('email') border-red-500 @enderror"
                    />
                @error('email')
                    <p class="flex mt-1 items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">{{$message}}</p>
                @enderror
                </div>

                <div class="mb-1 sm:mb-2">
                    <label for="password" class="inline-block mb-1 font-medium">Contraseña:</label>
                    <input type="password" id="password" name="password"
                        class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline  @error('password') border-red-500 @enderror"
                    />
                @error('password')
                    <p class="flex mt-1 items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">{{$message}}</p>
                @enderror
                </div>
                <div class="mb-1 sm:mb-2">
                    <label for="password_confirmation" class="inline-block mb-1 font-medium">Confirmar contraseña:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline"
                    />
                </div>

                <div class="mt-4 mb-2 sm:mb-4">
                    <input type="submit" value="Registrarse" class="cursor-pointer block w-full text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2" />
                </div>
                <div class="mt-6">
                    <h2 class="text-gray-600 text-xs font-bold">Ya tienes Cuenta. Ingresa Ahora!</h2>
                    <a class="text-blue-600 font-normal text-sm underline" href="{{route('login')}}">Iniciar Sesion</a>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection