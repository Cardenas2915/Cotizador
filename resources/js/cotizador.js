import axios from 'axios';

const btnAgregar = document.getElementById('btnAgregar');
const formulario = document.getElementById('formulario')
const btnEliminar = document.getElementById('btnEliminar');
const resultados = document.getElementById('resultados');
const alertas = document.getElementById('alertas');
const tabla = document.getElementById('tabla');

btnAgregar.addEventListener('click', agregarProducto);
btnEliminar.addEventListener('click', eliminarRow);
formulario.addEventListener('submit', submitFormulario);

function agregarProducto(e) {
        
    e.preventDefault();
        const newRow = document.createElement('tr');
        const tableHeaders = document.querySelectorAll('th');

        tableHeaders.forEach(name => {
            const campo =  name.id;
            const row = document.createElement('td');
            const input = document.createElement('input');
            input.classList.add('w-full','rounded-lg','h-8','text-black');

            input.type = "text";
            input.name = `${campo}`;

            row.appendChild(input);
            newRow.appendChild(row);
            tabla.appendChild(newRow);
        });
    
}

function submitFormulario(e) {
    e.preventDefault();
    
    const filas = tabla.querySelectorAll('tr');
    const data = [];
    
    filas.forEach(fila => {
        const inputs = fila.querySelectorAll('input');
        const rowData = {};
        
        inputs.forEach(input => {
            rowData[input.name] = input.value;
        });
        
        data.push(rowData);
    });
    
    //realizamos la cotizacion
    if (validarCampos(data)) {
        alertify.notify('Todos los campos son obligatorios', 'error', 3)
        return;
    } 
    
    cotizar(data);
    
    
}

function cotizar(data){
    //definimos las varianles a utilizar
    let sumaPesoTotal = 0
    let sumaPrecios = 0;
    let sumatotal = 0;
    let cantidadProductos = 0;
    let volumenTotal = 0;
    let volumenEntero = 0;
    var precios = {}
    
    //impuestos
    let costoImportacion = 1850000;
    let flete = 600000;

    //iteramos el array para obtener algunos valores
    data.forEach(producto =>{
        const {volumen, peso, precioSinIva, cantidad} = producto;
        let sumaVolumen = 0;
        let sumaPeso = 0;
        let volumenNumerico = parseFloat(volumen);
        let PesoNumerico = parseFloat(peso);
        let precioNumerico = parseFloat(precioSinIva);
        let cantidadNumerico = parseFloat(cantidad);

        //cantidad total de productos / producto
        cantidadProductos = cantidadProductos + cantidadNumerico;

        //volumen total de los productos
        sumaVolumen = volumenNumerico * cantidadNumerico;
        volumenTotal = volumenTotal + sumaVolumen ;

        //agregar precio con iva
        producto.precioConIva = precioNumerico ;


        //suma los pesos
        sumaPeso = PesoNumerico * cantidadNumerico;
        sumaPesoTotal = sumaPesoTotal + sumaPeso;

        //valor total de los productos antes de iba
        sumaPrecios = cantidadNumerico * precioNumerico;
        sumatotal = sumaPrecios + sumatotal;

    });
    

    //volumenTotal para calcular el costo de importacion
    volumenEntero = parseInt(volumenTotal);
    
    //calcular LIMITE
    let costoImportacionLimite;
    if (volumenTotal === 0) {
        costoImportacionLimite = costoImportacion;

    } else if (volumenTotal === volumenEntero) {
        costoImportacionLimite = volumenTotal * costoImportacion;

    } else {
        costoImportacionLimite = (volumenEntero + 1) * costoImportacion;
        
    }

    const costoTotalImportacion = volumenTotal * costoImportacion;

        //verificamos que se pueda realizar la compra en base al costo de importacion
        let diferencia = parseInt(Math.abs(costoTotalImportacion - costoImportacionLimite));
        const tolerancia = 100000;
        if (diferencia <= tolerancia || diferencia == 0) {
            mostrarDiferencia(diferencia,volumenTotal);
        } else {
            denegarCompra(diferencia,volumenTotal);
            return;
        }

    //flete
    let fleteTotal = parseInt(sumaPesoTotal * flete / 1000);
    precios.flete = fleteTotal;

    // Calcular el arancel
    const calculoArancel = cantidadProductos >= 100 ? 0.06 : 0.08;
    const arancel = sumatotal * calculoArancel;
    precios.arancel = arancel; //insertamos el arancel al objeto precios
    
    //obtenemos el totl de la compra con todos los impuestos
    let totalCompra = sumatotal + costoTotalImportacion + arancel + fleteTotal ;
    let ivaCompra = totalCompra * 0.19;
    let totalIva = parseInt(totalCompra + ivaCompra);

    //insertamos valores al objeto de precios
    precios.totalCompra = totalIva;
    precios.precioTotalSinIva = sumatotal;
    precios.costoImportacion = costoTotalImportacion;

    //dividir el flete por la cantidad
    let fleteDivido = fleteTotal / cantidadProductos;

    //dividir el arancel por la cantidad
    let arancelDivido = arancel / cantidadProductos

    // Iterar a través de cada objeto y actualizar el campo precioConIva
    data.forEach(producto => {
        const {volumen,cantidad,precioConIva} = producto

        let volumenNumerico = parseFloat(volumen);
        let cantidadNumerico = parseInt(cantidad);

        //sacar el costo de importacion para cada producto
        let volumenTotal = volumenNumerico * cantidadNumerico;
        let costoImportacionParaCadaProdcuto = (costoImportacion * volumenTotal )  / cantidadNumerico;
        
        let sumaPreciosTotal = precioConIva + arancelDivido + costoImportacionParaCadaProdcuto + fleteDivido;
        let precioIva = (sumaPreciosTotal * 0.19) + sumaPreciosTotal;
        let precioActualizado = (precioIva * 0.35) + precioIva;
        
        const precioRedondeado = redondearNumero(precioActualizado) ;
        producto.precioConIva = parseInt(precioRedondeado);
    });
    
    //mostramos los resultados 
    mostrarResultados(precios, data);
}

function mostrarResultados(precios,data){
    limpiarHTML(resultados);

    const preciosFormateados = {...precios};
    for (const precio in preciosFormateados) {
        preciosFormateados[precio] = formatearPrecio(preciosFormateados[precio]);
    }
    const {totalCompra, arancel, costoImportacion, flete, precioTotalSinIva} = preciosFormateados;
    const contResultado = document.createElement('div');
    contResultado.classList.add('mt-2')
    contResultado.innerHTML = `
        <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Impuestos
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Valores
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Total Compra sin Impuestos
                    </th>
                    <td class="px-6 py-4 text-blue-700 font-semibold">
                        ${precioTotalSinIva}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Arancel
                    </th>
                    <td class="px-6 py-4 text-blue-700 font-semibold">
                        ${arancel}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Flete
                    </th>
                    <td class="px-6 py-4 text-blue-700 font-semibold">
                        ${flete}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Costo de importacion
                    </th>
                    <td class="px-6 py-4 text-blue-700 font-semibold">
                        ${costoImportacion}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Total Compra
                    </th>
                    <td class="px-6 py-4 text-blue-700 font-bold">
                        ${totalCompra}
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    `; 

    const btnGuardar = document.createElement('BUTTON')
    btnGuardar.classList.add('mt-2','text-white', 'bg-green-700', 'hover:bg-green-800', 'font-medium', 'rounded-lg', 'text-sm', 'px-5', 'py-2.5', 'text-center');
    btnGuardar.textContent = "Realizar Compra"
    btnGuardar.onclick = () =>  guardarProductos(precios, data);

    resultados.appendChild(contResultado);
    resultados.appendChild(btnGuardar);
}

function guardarProductos(precios,datos){

    const idEmpresa = document.getElementById('nombreEmpresa').value;

    if(idEmpresa === null || idEmpresa ===""){
        alertify.notify('Define el proveedor o empresa', 'error', 3)
        return;
    }

    alertify.confirm('Desea realizar la compra.?', function(){ 


        //array que ultilizamos para guardar los productos en la base de datos
        const datosSeleccionados = datos.map(producto => {
            return {
                codigo: producto.codigo,
                nombre: producto.nombre,
                peso: producto.peso,
                volumen: producto.volumen,
                precioVenta: producto.precioConIva,
                precioSinIva: producto.precioSinIva,
                cantidad:producto.cantidad
            };
        });
        //array que ultilizamos para obtener los id de los productos guardados
        const codigos = datos.map(producto => {
            return {
                codigo:producto.codigo
            }
        });

        limpiarHTML(resultados);
        limpiarHTML(alertas);
        Spinner();

        //se envian los datos de la compra
        const {totalCompra, arancel, costoImportacion, flete} = precios;
        axios.post('/registerDatos', {
            arancel: arancel,
            flete: flete,
            costoImportacion: costoImportacion,
            totalCompra: totalCompra
        })
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.log(error);
        });
        
        //se envian los productos para ser guardados en la base de datos
        axios.post('/registerProducto', { productos: datosSeleccionados })
            .then(async response => {
                const {message} = response.data;
                const productos = await buscarIdsProductos(codigos);
                const idCompra = await obtenerUltimoId();
                const resultado = await guardarCompra(productos, idCompra, idEmpresa);
                const resultadoItem = await guardarItem(productos);

                if(resultado && resultadoItem){
                    limpiarHTML(tabla)
                    limpiarHTML(alertas)
                    alertify.notify(message, 'success', 5);
                }
                
            })
            .catch(error => {
                limpiarHTML(alertas)
                alertify.notify('Hubo un problema, Por favor Intenta nuevamente', 'error', 5)
            });
        
    })
}

function eliminarRow(){
    const filas = tabla.getElementsByTagName('tr');
    if (filas.length > 1) { 
    tabla.removeChild(filas[filas.length - 1]); 
    }
}

//funcion para mostrar alerta si no se cumple el metro cubico de compra
function denegarCompra(valor,volumen){
    limpiarHTML(alertas);
    const precio = formatearPrecio(valor);

    const div = document.createElement('DIV');
    div.classList.add('bg-red-500','px-6','py-4','flex','w-full','text-white','flex','flex-col','rounded');
    div.innerHTML = `
    <h1 class="font-semibold text-lg"> No puedes realizar esta compra! </h1>
    <p> Volumen total de <span class="font-bold text-black">${volumen}</span> m3</p>
    <p> Tienes cupo de <span class="font-bold text-black">${precio}</span> para completar el valor por metro cubico</p>
    `;
    alertas.appendChild(div);
    limpiarHTML(resultados)
}
//funcion para mostrar alerta si se cumple lo requerido para realizar la compra
function mostrarDiferencia(valor,volumen){
    limpiarHTML(alertas);
    const precio = formatearPrecio(valor);

    const div = document.createElement('DIV');
    div.classList.add('bg-green-500','px-4','py-2','flex','w-full','text-white','flex','flex-col','rounded');
    div.innerHTML = `
    <h1 class="font-semibold text-lg">Realiza tu compra! </h1>
    <p> Volumen total de <span class="font-bold text-black">${volumen}</span> m3</p>
    <p> Tienes una diferencia de $ <span class="font-bold text-black">${precio}</span></p>
    `;
    alertas.appendChild(div);
}

function limpiarHTML(contenedor){
    while(contenedor.firstChild){
        contenedor.removeChild(contenedor.firstChild)
    }
}

function redondearNumero(numero) {
    // Extraer las cifras anteriores (las primeras)
    const cifrasAnteriores = Math.floor(numero / 10000);
    // Extraer las últimas cuatro cifras tomando el residuo del numero
    const cifrasUltimas = numero % 10000;
    // Redondear las cifras últimas al múltiplo de 10000 más cercano
    const cifrasUltimasRedondeadas = Math.round(cifrasUltimas / 10000) * 10000;
    // Reconstruir el número completo
    const numeroRedondeado = cifrasAnteriores * 10000 + cifrasUltimasRedondeadas;

    return numeroRedondeado;
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
    alertas.appendChild(divSpinner);
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

// Definimos buscarIds como una función asíncrona y pedimos los id requeridos
async function buscarIdsProductos(codigos) {
    try {
        const response = await axios.post('/buscarCodigos', { codigos });
        const { productos_encontrados } = response.data;
        console.log(response);
        return productos_encontrados;
    } catch (error) {
        console.error('Error al buscar IDs:', error);
        return false;
    }
}

// Definimos buscarIds como una función asíncrona
async function obtenerUltimoId() {
    try {
        const response = await axios.get('/ultimaCompra')
        const ultimoId = response.data.ultimo_id;
        return ultimoId;

    } catch(error) {
            console.error('Error al obtener el ID del último registro:', error);
    };
}

async function guardarCompra(productos, idCompra, idEmpresa) {
    // Crear un array para almacenar objetos por cada idProducto
    const datosCompra = productos.map(producto => {
        return {
            idEmpresa: idEmpresa,
            idProducto: producto.id,
            idCompra: idCompra,
            precio: producto.precio,
            cantidad: producto.cantidad
        };
    });

    try {
        // Se envían los productos para ser guardados en la base de datos
        const response = await axios.post('/registerCompra', { datos: datosCompra });
        let resultado = true;
        return resultado; 
    } catch (error) {
        let resultado = false;
        return resultado;  
    }
}

async function guardarItem(productos){

    // Crear un array para almacenar los datos de cada item 
    const datosItem = productos.map(producto => {
        return {
            idProducto: producto.id,
            idCategoria: 1,
            imagen: "default.jpg",
            descripcion: "Describe tu producto...",
            stock: producto.cantidad,
            estado: 'Sin verificar'
        };
    });

    try {
        // Se envían los productos para ser guardados en la base de datos
        const response = await axios.post('/registerItem', { datos: datosItem});
        let resultado = true;
        return resultado; 
    } catch (error) {
        let resultado = false;
        return resultado;  
    }
}



