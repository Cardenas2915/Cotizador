const formCategoria = document.getElementById('formProveedor');

formCategoria.addEventListener('submit', e => {
    
    const input = document.querySelector('#name').value;
    const contacto = document.getElementById('contacto').value;
    const contenedorInput = document.getElementById('contenedorInput');

    if(input === "" || contacto == ""){
        e.preventDefault();
        const alerta = document.querySelector('.alerta');
        if(!alerta){
            const alerta = document.createElement('P');
            alerta.classList.add('alerta','flex', 'mt-1', 'items-center', 'p-4', 'mb-4', 'text-sm', 'text-red-800', 'border', 'border-red-300', 'rounded-lg', 'bg-red-50', 'dark:bg-gray-800', 'dark:text-red-400', 'dark:border-red-800')
            alerta.textContent = "Todos los campos son obligatorios";
            contenedorInput.appendChild(alerta);
            setTimeout(() => {
                alerta.remove()
            }, 4000);
            return;
        }
    }

});