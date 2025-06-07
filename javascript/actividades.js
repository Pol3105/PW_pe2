document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.querySelector('.formulario');

    // Elementos para mensajes de error
    const alertaTipo = document.getElementById('alerta_tipo');
    const alertaModalidad = document.getElementById('alerta_modalidad');
    const alertaPistas = document.getElementById('alerta_pista');

    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir envío para validar primero

        // Validar todos los campos
        const tipoValido = validarTipo();
        const modalidadValida = validarModalidad();
        const pistasValida = validarPistas();

        // Si todo es válido, enviar formulario
        if (tipoValido && modalidadValida && pistasValida) {
            this.submit();
        }
    });

    // Funciones de validación

    function validarTipo() {
        const tipo = document.getElementById('tipo');

        if (!tipo || tipo.value.trim() === '') {
            alertaTipo.textContent = 'El tipo es obligatorio';
            alertaTipo.className = "alerta_php error";
            return false;
        }

        const valorTipo = tipo.value.trim();
        const tiposValidos = ['Futbol', 'Natacion', 'Tenis'];

        if (!tiposValidos.includes(valorTipo)) {
            alertaTipo.textContent = 'El tipo debe ser Futbol, Natacion o Tenis';
            alertaTipo.className = "alerta_php error";
            return false;
        }

        alertaTipo.textContent = '';
        alertaTipo.className = '';
        return true;
    }


    function validarModalidad() {
        const modalidad = document.getElementById('modalidad');

        if (!modalidad || modalidad.value.trim() === '') {
            alertaModalidad.textContent = 'La modalidad es obligatoria';
            alertaModalidad.className = "alerta_php error";
            return false;
        } else {
            alertaModalidad.textContent = '';
            alertaModalidad.className = '';
            return true;
        }
    }

    function validarPistas() {
    const pistasInput = document.getElementById('pistas');

    if (!pistasInput) return true; // En caso de que no exista el input, no validar

    const pistas = pistasInput.value.trim();
    const numPista = parseInt(pistas);

    if (pistas === '') {
        alertaPistas.textContent = 'Las pistas son obligatorias';
        alertaPistas.className = "alerta_php error";
        return false;
    } else if (isNaN(numPista) || numPista < 0 || numPista > 12) {
        alertaPistas.textContent = 'Introduce un número de pista válido (0 a 12)';
        alertaPistas.className = "alerta_php error";
        return false;
    } else {
        alertaPistas.textContent = '';
        alertaPistas.className = '';
        return true;
    }
    }

});
