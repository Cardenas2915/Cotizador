
//recibimos los productos desde el storage
let articulosCarrito = JSON.parse( localStorage.getItem('carrito') ) || []  ;

const detallesBody = document.getElementById('detalles-car');
const divResumenPedido = document.getElementById('resumenPedido');
const btnCompra = document.getElementById('btnCompra');
let resumenPedido = [];

detallesCarrito();

detallesBody.addEventListener('click', eliminarProductoDetalles);


function detallesCarrito() {
    vaciarCarrito(detallesBody);

    articulosCarrito.forEach(producto => {
        const row = document.createElement('LI');
        row.classList.add('flex', 'items-center','justify-center', 'gap-4', 'bg-white', 'p-4', 'rounded-lg')
        row.innerHTML = `
                    <img class="h-16 w-16 rounded object-cover" src="${producto.imagen}">
                    <div>
                        <h3 class="text-sm text-gray-900">${producto.titulo}</h3>
                        <div>
                            <p class="inline">Precio: ${producto.precio}</p>
                        </div>
                    </div>

                    <div class="flex flex-1 items-center justify-end gap-2">
                        <input type="number" min="1" value="${producto.cantidad}" data-producto-id="${producto.id}" class="cantidad h-8 w-12 rounded border-gray-200 bg-gray-50 p-0 text-center text-xs text-gray-600 [-moz-appearance:_textfield] focus:outline-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none" />
                        <button class="text-gray-600 transition hover:text-red-600 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 borrar-producto" data-id="${producto.id}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
        `;
        detallesBody.appendChild(row);

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
                mostrarResumenPedido()
            }
            actualizarTotal();
        });

    });

    sincronizarStorage();
    mostrarResumenPedido()
}

function sincronizarStorage() {
    localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
}

function mostrarResumenPedido(){
    
    vaciarCarrito(divResumenPedido);

    const cantidad = articulosCarrito.length;
    let subtotal = 0;
    let totalCompra = 0;
    let descuento = 0;
    let cantidadProductos = 0;

    articulosCarrito.forEach(producto => {
        const valor = parseInt(producto.precio.replace(/\D/g, ''));
        const cantidad = parseInt(producto.cantidad)

        let precioTotal = valor * cantidad      
        subtotal = subtotal + precioTotal;

        cantidadProductos = cantidadProductos + cantidad

    });

    if(cantidadProductos >= 10 ){
        const porcentajeDescuento = 0.05;
        const calcularDescuento = subtotal * porcentajeDescuento; 
        descuento  = descuento + calcularDescuento;
    }

    totalCompra = subtotal - descuento;

    //desactivar boton de realizar compra si no hay articulos
    if(totalCompra == 0 && cantidadProductos == 0){
        btnCompra.addEventListener('click', e => {
            e.preventDefault();
            alertify.notify('No tienes productos en tu carrito!', 'error', 5);
            return;
        })
        
    }
    resumenPedido = [
        {
            cantidad: cantidad,
            subtotal:subtotal,
            descuento:descuento,
            totalCompra:totalCompra,
        }
    ];
    localStorage.setItem('resumenPedido', JSON.stringify(resumenPedido));

    subtotal = formatearPrecio(subtotal);
    totalCompra = formatearPrecio(totalCompra);
    descuento = formatearPrecio(descuento);
    
        const divInformacion = document.createElement('DIV');
        divInformacion.classList.add('space-y-0.5', 'text-sm', 'text-gray-700', 'resultados');

        divInformacion.innerHTML = `
            <div class="flex justify-between">
                <h2>Total Productos</h2>
                <p class="totalProductos">${cantidad}</p>
            </div>

            <div class="flex justify-between">
                <h2>Subtotal</h2>
                <p class="subtotal">${subtotal}</p>
            </div>

            <div class="flex justify-between">
                <h2>Descuento</h2>
                <p class="descuento">${descuento}</p>
            </div>
            <div class="flex justify-between !text-base font-medium">
                <h2>Total compra</h2>
                <p class="total">${totalCompra}</p>
            </div>
        `;

        
        divResumenPedido.insertBefore(divInformacion, divResumenPedido.firstChild);
    
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

function vaciarCarrito(contenedor) {
    while(contenedor.firstChild) {
        contenedor.removeChild(contenedor.firstChild);
    }
}

// Elimina el curso del carrito 
function eliminarProductoDetalles(e) {
    e.preventDefault();
    console.log(e.target.classList);
    if(e.target.classList.contains('borrar-producto') ) {
        
        const cursoId = e.target.getAttribute('data-id')
        // Eliminar del arreglo del carrito
        articulosCarrito = articulosCarrito.filter(curso => curso.id !== cursoId);

        detallesCarrito();
    }
}




