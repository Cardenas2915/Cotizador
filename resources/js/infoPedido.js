import ciudades from './ciudades';
import axios from 'axios';

let resumenPedido = JSON.parse( localStorage.getItem('resumenPedido') ) || []  ;
let articulosCarrito = JSON.parse( localStorage.getItem('carrito') ) || []  ;
const divResumenPedido = document.getElementById('resumenPedido');
const btnCompra = document.getElementById('realizar-compra');
const selectDepartamento = document.getElementById('departamento');
const selectCiudad = document.getElementById('ciudad');
const divBotones = document.getElementById('botones-compra');



mostrarResumen();
mostrarSelects();

btnCompra.addEventListener('click', enviarInfo);


function mostrarSelects(){
    const departamentos = ciudades.map(departamento => {
            const option = document.createElement('OPTION');
            option.textContent = departamento.departamento
            option.value = departamento.departamento
            selectDepartamento.appendChild(option);
    });


    selectDepartamento.addEventListener('change', e => {
        const idDepartamento = e.target.value;

        const departamento = ciudades.filter(departamento => departamento.departamento == idDepartamento)
        
        const ciudad =  departamento[0];
        while(selectCiudad.firstChild){
            selectCiudad.removeChild(selectCiudad.firstChild)
        }
        ciudad.ciudades.forEach(nombre => {

            const option = document.createElement('OPTION');
            option.textContent = nombre
            option.value = nombre
            selectCiudad.appendChild(option);
        });
    })

    
}

function enviarInfo(e){

    e.preventDefault()
    
    const inputs = document.querySelectorAll('input');
    const selects = document.querySelectorAll('select');
    const datos = [];

    inputs.forEach(input => {
        const valor = input.value;
        const rowData = {};
        rowData[input.name] = valor

        datos.push(rowData);
    }) 

    selects.forEach(campo => {
        const valor = campo.value;
        const rowData = {};
        rowData[campo.name] = valor

        datos.push(rowData);
    }) 
    

    if(validarCampos(datos)){
        alertify.notify('Todos los campos son obligatorios', 'error', 3)
        return;
    }

    realizarCompra(datos);
}

async function realizarCompra(datos){
    limpiarHTML(divBotones);
    Spinner();
    const idPedido = await guardarInfoPedido(datos);

    const lineaPedido = articulosCarrito.map(producto => {
        return {
            pedido_id:idPedido,
            producto_id:producto.id,
            unidades:producto.cantidad,
        }
    })

    axios.post('/register/pedido',{ datos: lineaPedido })
    .then(function(response){
        limpiarHTML(divBotones);
        //vaciar localstorage y vaciar carrito
        articulosCarrito = [];
        localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
        window.location.href = "/CompraRealizada";
    })

    .catch(function (error) {
        console.log(error);
    });
}

async function guardarInfoPedido(datos){
    
    var datosPedido = datos.reduce(function(acumulador, objetoActual) {
        // Combina el objeto actual con el acumulador
        for (var clave in objetoActual) {
            acumulador[clave] = objetoActual[clave];
        }
        return acumulador;
    }, {});
    
    const {totalCompra} = resumenPedido[0];
    datosPedido['coste'] = totalCompra;

    let idPedido ;
    try {
        const response  = await axios.post('/register/InfoPedido', { datos: datosPedido})
        const {idRegistro} = response.data
        idPedido = idRegistro;
    } catch (error) {
        console.error('Error al buscar IDs:', error);
        return false;
    }
    return idPedido;
}

function mostrarResumen(){
    resumenPedido.forEach(datos => {
        
    let {cantidad, subtotal, descuento, totalCompra} = datos;

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

    });
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

function validarCampos(array) {
    return array.some(obj => {
        return Object.values(obj).some(valor => valor === '' || valor === null || valor === undefined);
    });
}

function limpiarHTML(contenedor){
    while(contenedor.firstChild){
        contenedor.removeChild(contenedor.firstChild)
    }
}

function Spinner() {

    const divSpinner = document.createElement('div');
    divSpinner.classList.add('sk-fading-circle');

    divSpinner.innerHTML = `
        <div class="spinner">
            <div class="cube1"></div>
            <div class="cube2"></div>
        </div>
    `;
    divBotones.appendChild(divSpinner);
}


