"use strict";
/* Espacios - Funcionalidades comunes para el catálogo y detalle */
document.addEventListener("DOMContentLoaded", function () {
    /* Filtros del catálogo */
    const filterBtns = document.querySelectorAll(".filter-btn");
    const cards = document.querySelectorAll(".catalog-card");

    if (filterBtns.length > 0 && cards.length > 0) {
        filterBtns.forEach(function (btn) {
            btn.addEventListener("click", function () {
                // Quitar clase active
                filterBtns.forEach(b => {
                    b.classList.remove("active");
                    b.setAttribute("aria-selected", "false");
                });
                // Ponemos el active al botón clickeado
                this.classList.add("active");
                this.setAttribute("aria-selected", "true");
                
                const type = this.getAttribute("data-tipo").toLowerCase();

                // Filtramos las cards según el tipo seleccionado
                cards.forEach(card => {
                    const cardType = card.getAttribute("data-tipo").toLowerCase();
                    // Reiniciamos las animaciones de 'fade'
                    card.classList.remove('is-visible');
                    card.style.display = "none";
                    
                    if (type === "todos" || cardType === type) {
                        card.style.display = "flex";
                        // Declaramos un pequeño timeout para forzar re-flow y reactivar transición de la card
                        setTimeout(() => {
                            card.classList.add("is-visible");
                        }, 50);
                    }
                });
            });
        });
    }
    /* 
    const thumbs = document.querySelectorAll(".detalle-galeria__thumb");
    const mainImg = document.getElementById("main-gallery-img");

    if (thumbs.length > 0 && mainImg) {
        thumbs.forEach(thumb => {
            thumb.addEventListener("click", function () {
                // Remover active class
                thumbs.forEach(t => t.classList.remove("active"));
                this.classList.add("active");

                // Actualizar imagen principal
                const imgElement = this.querySelector("img");
                const fullSrc = imgElement.getAttribute("data-full");
                
                // Transición sutil usando fade
                mainImg.style.opacity = 0;
                setTimeout(() => {
                    mainImg.src = fullSrc;
                    mainImg.style.opacity = 1;
                }, 150);
            });
        });
    }

    // --------------------------------------------------
    // 3. CÁLCULO DE FECHAS DE RESERVA (detalle.php)
    // --------------------------------------------------
    const fechaEntrada = document.getElementById("fecha_entrada");
    const fechaSalida = document.getElementById("fecha_salida");
    const btnCart = document.getElementById("btn-add-cart");
    
    // UI elements del preview
    const previewBox = document.getElementById("booking-total-preview");
    const labelNights = document.getElementById("booking-nights");
    const labelSubtotal = document.getElementById("booking-subtotal");

    // Prevent past dates en fechaSalida 
    if (fechaEntrada && fechaSalida) {
        
        // Al interactuar con la fecha de entrada
        fechaEntrada.addEventListener("change", function() {
            if (this.value) {
                // Habilitar salida y setear como MIN el día siguiente
                const entDate = new Date(this.value);
                
                // Sumamos 1 dia para la salida base
                const minSalida = new Date(entDate);
                minSalida.setDate(minSalida.getDate() + 1);
                
                // Formato YYYY-MM-DD
                const minString = minSalida.toISOString().split("T")[0];
                fechaSalida.min = minString;
                fechaSalida.disabled = false;
                
                // Si la salida guardada previamente es ilógica, la resetamos
                if (fechaSalida.value && fechaSalida.value <= this.value) {
                    fechaSalida.value = minString;
                }
            } else {
                fechaSalida.disabled = true;
                fechaSalida.value = "";
            }
            calcularTotal();
        });

        fechaSalida.addEventListener("change", calcularTotal);

        function calcularTotal() {
            if (!fechaEntrada.value || !fechaSalida.value) {
                btnCart.disabled = true;
                previewBox.style.display = "none";
                return;
            }

            const inDate = new Date(fechaEntrada.value);
            const outDate = new Date(fechaSalida.value);

            // Evitamos timezones mess 
            const diffTime = outDate.getTime() - inDate.getTime();
            const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (days > 0 && window.ESPACIO_PRECIO) {
                const subT = days * parseFloat(window.ESPACIO_PRECIO);
                
                // Actualizar interfaz
                labelNights.textContent = days;
                // Formateamos num
                labelSubtotal.textContent = subT.toLocaleString("en-US", {minimumFractionDigits: 2});
                
                previewBox.style.display = "block";
                btnCart.disabled = false;
            } else {
                btnCart.disabled = true;
                previewBox.style.display = "none";
            }
        }
    }
});
