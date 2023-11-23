const formProductos = document.getElementById('formProductos');


formProductos.addEventListener('submit', e => {
    
    const categoria = document.getElementById('categoria').value;
    const estado = document.getElementById('estado').value;
    
    if(categoria === '1' && estado === 'Verificado'){
        e.preventDefault();
        
        const alerta = document.querySelector('.alerta');
        if(!alerta){
            const alerta = document.createElement('P');
            alerta.classList.add('alerta','flex', 'mt-1', 'items-center', 'p-4', 'mb-4', 'text-sm', 'text-red-800', 'border', 'border-red-300', 'rounded-lg', 'bg-red-50', 'dark:bg-gray-800', 'dark:text-red-400', 'dark:border-red-800')
            alerta.textContent = "No puedes verificar un producto sin estar categorizado!";
            formProductos.appendChild(alerta);
            setTimeout(() => {
                alerta.remove()
            }, 4000);
            return;
        }
    }

})