"use strict";
// ==================================================
// SALITRE - carrito.js
// Validación y confirmación del Carrito de Compras
// ==================================================

document.addEventListener("DOMContentLoaded", function () {

    // --------------------------------------------------
    // CONFIRMACIÓN PREVIA A LA SOLICITUD
    // --------------------------------------------------
    const formCheckout = document.getElementById("form-carrito-checkout");
    const btnRequest = document.getElementById("btn-request");

    if (formCheckout && btnRequest) {

        formCheckout.addEventListener("submit", function (e) {
            e.preventDefault();

            // Simular loading state en el botón
            btnRequest.disabled = true;
            btnRequest.textContent = "Procesando...";

            // Confirmación UX
            // Nota para fase 7: si se procesa pago esto abriría el modal STRIPE/Paypal.
            // Por ahora, mostrar un confirm y enviar POST
            const conf = confirm("\u00BFCofirmar y enviar reserva para las fechas seleccionadas? \n\nRecuerda que no hay cargos sorpresa.");

            if (conf) {
                // Hacer submit real hacia carrito/confirmacion.php
                formCheckout.submit();
            } else {
                // Revert
                btnRequest.disabled = false;
                btnRequest.textContent = "Solicitar Reserva";
            }
        });
    }

});
