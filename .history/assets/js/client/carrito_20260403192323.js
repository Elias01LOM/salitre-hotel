"use strict";
/* Carrito de Compras - Confirmación de Solicitud */
document.addEventListener("DOMContentLoaded", function () {

    // --------------------------------------------------
    // CONFIRMACIÓN PREVIA A LA SOLICITUD
    // --------------------------------------------------
    const formCheckout = document.getElementById("form-carrito-checkout");
    const btnRequest = document.getElementById("btn-request");

    if (formCheckout && btnRequest) {

        formCheckout.addEventListener("submit", function(e) {
            /* 
             * Confirmación UX antes de enviar la reserva.
             * Si el usuario cancela, se previene el submit.
             * Si acepta, el form se envía normalmente (sin preventDefault).
             * Referencia: Documentación Sección 05.2
             */
            var conf = confirm("¿Confirmar y enviar reserva para las fechas seleccionadas?\n\nRecuerda que no hay cargos sorpresa.");

            if (!conf) {
                e.preventDefault();
                return;
            }

            // El form se envía normalmente si el usuario confirma
            btnRequest.disabled = true;
            btnRequest.textContent = "Procesando...";
        });
    }

});
