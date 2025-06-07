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
        const contraseñaValido = validarContraseña();
        
        // Si todo es válido, enviar formulario
        if (emailValido  && contraseñaValido) {
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
    
    function validarContraseña() {
        const contraseña = document.getElementById('contraseña').value.trim();
        
        if (contraseña === '') {
            alertaContraseña.textContent = 'La contraseña es obligatoria';
            alertaContraseña.classList = "alerta_php error";
            return false;
        } else if (contraseña.length < 3) {
            alertaContraseña.textContent = 'Mínimo 3 caracteres';
            alertaContraseña.classList = "alerta_php error";
            return false;
        } else {
            alertaContraseña.textContent = '';
            alertaContraseña.classList = ''; // Limpia todas las clases
            return true;
        }
    }
});