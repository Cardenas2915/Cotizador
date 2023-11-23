//Carrito de Compras

const cursos = document.getElementById('lista-productos');
const carritoBody = document.getElementById('carrito-body');
const carrito = document.getElementById('carrito');
const vaciarCarritoBtn = document.getElementById('vaciar-carrito'); 
const cantidadCarrito = document.getElementById('cantidad-carrito');
const btnVerCarrito = document.getElementById('enlace-miCarrito');


let articulosCarrito = [];
cargarEventListeners();

function cargarEventListeners() {
    
    cursos.addEventListener('click', agregarProducto);
    
    btnVerCarrito.addEventListener('click', () => {
        window.location.href = '/miCarrito';
    });

    carrito.addEventListener('click', eliminarProducto);

    vaciarCarritoBtn.addEventListener('click', () => {
        vaciarCarrito();
        articulosCarrito = [];
        sincronizarStorage();
        mostrarCantidad();
        actualizarTotal();
    });
    

    document.addEventListener('DOMContentLoaded', () => {
        // Verificar si el elemento existe antes de intentar acceder a él
        if (localStorage) {
            articulosCarrito = JSON.parse(localStorage.getItem('carrito')) || [];
        }
        
        carritoHTML();
    });
}

function agregarProducto(e){
    
    if(e.target.classList.contains('agregar-carrito')) {
        e.preventDefault();
        const producto = e.target.parentElement.parentElement;

        // Enviamos el producto seleccionado para tomar sus datos
        
        leerDatosProducto(producto);
    }
}

function leerDatosProducto(producto) {
    const infoProducto = {
        imagen: producto.querySelector('img').src,
        titulo: producto.querySelector('h2').textContent,
        precio: producto.querySelector('.precio span').textContent, 
        id: producto.querySelector('.agregar-carrito').getAttribute('data-id'), 
        cantidad: 1,
        stock: parseInt(producto.querySelector('.stock span').textContent)
    }
        //verificamos si el producto ya existe en el array
        if( articulosCarrito.some( producto => producto.id === infoProducto.id ) ) { 

            const productos = articulosCarrito.map( producto => {
                
                if( producto.id === infoProducto.id ) {
                    producto.cantidad++;
                    return producto;
                } else {
                    return producto;
                }
            })
            articulosCarrito = [...productos];
    }  else {
            articulosCarrito = [...articulosCarrito, infoProducto];
    }
    let titulo
    articulosCarrito.forEach(e => {
        titulo = e.titulo;
    });

    alertify.notify( titulo + ' Fue agregado', 'success', 3);
    carritoHTML();
}

function carritoHTML() {

    mostrarCantidad();
    vaciarCarrito();
    actualizarTotal();

    articulosCarrito.forEach(producto => {

        const row = document.createElement('LI');
        row.classList.add('flex', 'items-center', 'gap-4')
        row.innerHTML = `
        <img src="${producto.imagen}" width=100 />
        <div>
            <h3 class="font-semibold">${producto.titulo}</h3>
            <p class="text-red-700">${producto.precio}</p>
        </div>
        <div class="flex flex-1 items-center justify-end gap-2">
                <input type="number" min="1" value="${producto.cantidad}" data-producto-id="${producto.id}"
                class="cantidad font-bold h-8 w-12 rounded border-gray-200 bg-gray-50 p-0 text-center text-xs [-moz-appearance:_textfield] focus:outline-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                />

            <button class="text-gray-600 transition hover:text-red-600 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 borrar-producto" data-id="${producto.id}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        </div>
        `;
        carritoBody.appendChild(row);

        const inputCantidad = row.querySelector('.cantidad');

        inputCantidad.addEventListener('blur', e => {
            const valor = e.target.value;
            const productoId = inputCantidad.getAttribute('data-producto-id');

            if(valor == null || valor == 0) {
                inputCantidad.value = 1;
                return;
            }

            if(valor > producto.stock ) {
                inputCantidad.value = producto.stock;
                alertify.notify('No tenemos suficientes cantidades!', 'error', 5);
                return;
            }

            // Actualizar el valor en el objeto correcto basado en productoId
            const ProductoActualizado = articulosCarrito.find(producto => producto.id === productoId);
            if (ProductoActualizado) {
                ProductoActualizado.cantidad = valor;
                sincronizarStorage()
            }
            actualizarTotal();
        });

    });

    sincronizarStorage();
}

// Elimina el curso del carrito 
function eliminarProducto(e) {
    e.preventDefault();
    
    if(e.target.classList.contains('borrar-producto') ) {

        const cursoId = e.target.getAttribute('data-id')
        
        // Eliminar del arreglo del carrito
        articulosCarrito = articulosCarrito.filter(curso => curso.id !== cursoId);

        carritoHTML();
    }
}

//vacia el contenedor del carrito
function vaciarCarrito() {
    while(carritoBody.firstChild) {
        carritoBody.removeChild(carritoBody.firstChild);
    }
}

function actualizarTotal(){
    const divPrecioTotal = document.getElementById('precioTotal');
    let total = 0;
    articulosCarrito.forEach(producto => {
        const valor = parseInt(producto.precio.replace(/\D/g, ''));
        const cantidad = parseInt(producto.cantidad)

        let precioTotal = valor * cantidad
        
        total = total + precioTotal;

    });
    let precio = formatearPrecio(total)
    
    divPrecioTotal.textContent = precio;
}

function mostrarCantidad(){
    const cantidad = articulosCarrito.length;
    cantidadCarrito.textContent = cantidad;

}

function sincronizarStorage() {
    localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
}

function formatearPrecio(precio){
    //Intl.NumberFormat es una clase de javascript para formatear números según las reglas de formato locales.

    const formatoPrecio = new Intl.NumberFormat('es-CO', {
        style: 'currency', //significa que el número se formateará como una cantidad monetaria
        currency: 'COP' 
    });
    const precioFormateado = formatoPrecio.format(precio);
    return precioFormateado;
}

