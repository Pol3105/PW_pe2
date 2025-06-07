document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector('.formulario');
    
    // Elementos para mensajes de error
    const alertaNombre = document.getElementById('alerta_nombre');
    const alertaContraseña = document.getElementById('alerta_sugerencia');
    

    
    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir envío para validar primero
        
        // Validar todos los campos
        const nombreValido = validarNombre();
        const sugerenciaValida = validarSugerencia();
        
        // Si todo es válido, enviar formulario
        if (nombreValido && sugerenciaValida) {
            this.submit();
        }
    });
    
    // Funciones de validación

    function validarNombre() {
        const nombre = document.getElementById('nombre').value.trim();
        
        if (nombre === '') {
            alertaNombre.textContent = 'El nombre es obligatorio';
            alertaNombre.classList = "alerta_php error";
            return false;
        } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/.test(nombre)) {
            alertaNombre.textContent = 'Solo se permiten letras';
             alertaNombre.classList = "alerta_php error";
            return false;
        } else {
            alertaNombre.textContent = '';
            alertaNombre.classList = ''; // Limpia todas las clases
            return true;
        }
    }
    

    function validarSugerencia() {
        const contraseña = document.getElementById('sugerencia').value.trim();
        
        if (contraseña === '') {
            alertaContraseña.textContent = 'La sugerencia es obligatoria';
            alertaContraseña.classList = "alerta_php error";
            return false;
        } else if (contraseña.length < 50) {
            alertaContraseña.textContent = 'No supera la extension minima';
            alertaContraseña.classList = "alerta_php error";
            return false;
        } else {
            alertaContraseña.textContent = '';
            alertaContraseña.classList = ''; // Limpia todas las clases
            return true;
        }
    }
});