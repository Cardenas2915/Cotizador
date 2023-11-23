<div class="grid md:grid-cols-4 xl:grid-cols-6 p-3 items-center mt-6 gap-6">
    @foreach ($categorias as $categoria)
        <a  href="{{ route('show.categoria', ['id' => $categoria->id, 'name' => $categoria->name]) }}"
            class="px-3 mr-3 py-6 cursor-pointer text-white flex flex-col items-center justify-center bg-purple-600 border-solid border-2 border-purple-800 rounded-lg">
            <img class="h-12" src="{{asset('categorias' . '/' . $categoria->imagen)}}" alt="">
            {{$categoria->name}}
        </a>
    @endforeach
</div>

