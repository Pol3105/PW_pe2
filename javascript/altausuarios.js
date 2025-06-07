document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector('.formulario');
    
    // Elementos para mensajes de error
    const alertaEmail = document.getElementById('alerta_email');
    const alertaNombre = document.getElementById('alerta_nombre');
    const alertaEdad = document.getElementById('alerta_edad');
    const alertaContraseña = document.getElementById('alerta_contraseña');
    

    
    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir envío para validar primero
        
        // Validar todos los campos
        const emailValido = validarEmail();
        
        const nombreValido = validarNombre();

        const edadValido = validarEdad();
        const contraseñaValido = validarContraseña();
        
        // Si todo es válido, enviar formulario
        if (emailValido && nombreValido && edadValido && contraseñaValido) {
            this.submit();
        }
    });
    
    // Funciones de validación
    function validarEmail() {
        const email = document.getElementById('email').value.trim();
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email === '') {
            alertaEmail.textContent = 'El email es obligatorio';
            alertaEmail.classList = "alerta_php error";
            return false;
        } else if (!re.test(email)) {
            alertaEmail.textContent = 'Por favor ingresa un email válido';
            alertaEmail.classList = "alerta_php error";
            return false;
        } else {
            alertaEmail.textContent = '';
            alertaEmail.classList = ''; // Limpia todas las clases
            return true;
        }
    }
    
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
    
    function validarEdad() {
        const edad = document.getElementById('edad').value.trim();
        const numEdad = parseInt(edad);
        
        if (edad === '') {
            alertaEdad.textContent = 'La edad es obligatoria';
            alertaEdad.classList = "alerta_php error";
            return false;
        } else if (isNaN(numEdad)) {
            alertaEdad.textContent = 'Debe ser un número válido';
            alertaEdad.classList = "alerta_php error";
            return false;
        } else if (numEdad <= 12) {
            alertaEdad.textContent = 'Debe ser mayor de 12 para registrarse';
            alertaEdad.classList = "alerta_php error";
            return false;
        } else {
            alertaEdad.textContent = '';
            alertaEdad.classList = ''; // Limpia todas las clases
            return true;
        }
    }
    
    function validarContraseña() {
        const contraseña = document.getElementById('contraseña').value.trim();
        
        if (contraseña === '') {
            alertaContraseña.textContent = 'La contraseña es obligatoria';
            alertaContraseña.classList = "alerta_php error";
            return false;
        } else if (contraseña.length < 6) {
            alertaContraseña.textContent = 'Mínimo 6 caracteres';
            alertaContraseña.classList = "alerta_php error";
            return false;
        } else {
            alertaContraseña.textContent = '';
            alertaContraseña.classList = ''; // Limpia todas las clases
            return true;
        }
    }
});