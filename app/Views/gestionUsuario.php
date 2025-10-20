<?php

// 2. INCLUIR EL ENCABEZADO (Usamos require_once para dependencia crítica)
require_once 'header.php';

// ==========================================================
?>
<style>
/* -------------------------------------------------------------------------- */
/* INICIO: ESTILOS MODERNOS Y OPTIMIZADOS PARA SALUD (Sobrescritura Local) */
/* -------------------------------------------------------------------------- */

:root {
    --health-primary: #004c99;
    /* Azul profesional profundo */
    --health-secondary: #28a745;
    /* Verde de acento */
}

/* 1. Botón Principal con color de salud */
.btn-health-primary {
    background-color: var(--health-primary) !important;
    border-color: var(--health-primary) !important;
    color: white !important;
    transition: background-color 0.2s, border-color 0.2s;
}

.btn-health-primary:hover {
    background-color: #003366 !important;
    border-color: #003366 !important;
}

/* 2. Cabecera de tabla con color de salud */
.table-health-header {
    background-color: var(--health-primary) !important;
    color: white !important;
}

/* 3. Estilos Base (Se elimina la fuente "Times New Roman" por una moderna) */
body {
    /* Usando la pila de fuentes moderna de Bootstrap/AdminLTE */
    background-color: #f7f7f7;
}

img.tamaño {
    max-width: 30%;
    max-height: 30%;
}

/* ESTILO PARA HACER LA TABLA MÁS COMPACTA */
.tabla-compacta-excel {
    font-size: 11px;
}

.tabla-compacta-excel td,
.tabla-compacta-excel th {
    white-space: normal !important;
    word-wrap: break-word;
    padding: 0.3rem 0.5rem !important;
    vertical-align: top;
}

.tabla-compacta-excel thead th {
    font-size: 11px;
}

/* -------------------------------------------------------------------------- */
/* FIN: ESTILOS MODERNOS Y OPTIMIZADOS PARA SALUD */
/* -------------------------------------------------------------------------- */
</style>

<div class="container my-4 p-4 bg-white rounded-3 shadow-lg">
    <h1 class="h3 mb-4 text-dark">Gestión de Usuarios</h1>

    <section>
        <div id="listado_registros">
            <button id="btnagregar" class="btn btn-health-primary mb-3 shadow-sm" onclick="mostrarform(true)">
                <i class="bi bi-person-plus-fill"></i> Agregar Usuario
            </button>

            <div id="loading-spinner" class="text-center p-5">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Cargando datos...</span>
                </div>
                <p class="mt-2 text-muted">Cargando listado de usuarios...</p>
            </div>
            <div class="panel-body table-responsive d-none" id="listadoregistros">
                <table
                    class="table caption-top table-hover table-bordered align-middle w-100 table-striped table-sm tabla-compacta-excel"
                    id="tbllistadoUsuarios">
                    <caption>
                        <b>Listado de Registros</b>
                    </caption>
                    <thead class="table-health-header">
                        <th class="p-3">Opciones</th>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">apellido</th>
                        <th class="p-3">fech_Nac</th>
                        <th class="p-3">rut</th>
                        <th class="p-3">direccion</th>
                        <th class="p-3">telefono</th>
                        <th class="p-3">email</th>
                        <th class="p-3">login</th>
                        <th class="p-3">Imagen</th>
                        <th class="p-3">descripcion</th>
                        <th class="p-3">Fecha subido</th>
                        <th class="p-3">Creado por:</th>
                        <th class="p-3">Condicion</th>
                    </thead>
                    <tbody class="table-group-divider"></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </section>
    <section>
        <div id="formularioregistros"
            class=" d-none mt-4 p-4 border border-secondary-subtle rounded-3 bg-light shadow-sm">
            <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data" novalidate>


                <input type="hidden" name="idusuario" id="idusuario" />
                <input type="hidden" name="imagenactual" id="imagenactual" />
                <input type="hidden" name="login" id="login" />
                <input type="hidden" name="descripcion" id="descripcion" />
                <input type="hidden" name="clave" id="clave" value="MOCK_CLAVE" />

                <div class="row g-3">

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="rut" class="form-label">Numero de Rut (*)</label>
                        <input type="text" name="rut" id="rut" class="form-control" required maxlength="12"
                            placeholder="Ej: 12.345.678-9" />
                        <div class="invalid-feedback">
                            El RUT ingresado no es válido. Debe tener el formato: XX.XXX.XXX-X.
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="nombre" class="form-label">Nombres (*)</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required />
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="apellido" class="form-label">Apellidos (*)</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" required />
                    </div>


                    <div class="col-12 col-md-6 col-lg-9">
                        <label for="direccion" class="form-label">Dirección (*)</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="fech_Nac" class="form-label">Fecha de Nacimiento (*)</label>
                        <input type="date" name="fech_Nac" id="fech_Nac" class="form-control" required />
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="email" class="form-label">Email (*)</label>
                        <input type="email" name="email" id="email" class="form-control" required />
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="telefono" class="form-label">Teléfono (*)</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" required />
                        <div class="invalid-feedback">
                            El teléfono debe tener el formato +569XXXXXXXX (12 dígitos).
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="imagen" class="form-label">Imagen de Perfil</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Vista Previa</label>
                        <img src="" id="imagenmuestra" class="mt-1" style="
                            height: 90px;
                            width: 90px;
                            object-fit: cover;
                            border-radius: 5%;
                            border: 2px solid #6c757d;
                            " alt="Imagen del usuario" />
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" id="btnGuardar" class="btn btn-health-primary shadow-sm">
                        <i class="bi bi-floppy-fill"></i> Guardar
                    </button>

                    <button type="button" onclick="cancelarform()" class="btn btn-outline-secondary shadow-sm">
                        <i class="bi bi-arrow-left-circle-fill"></i> Cancelar
                    </button>
                </div>

                <p class="text-muted small mt-3">
                    Los campos marcados con (*) son obligatorios.
                </p>
            </form>
        </div>
    </section>
</div>
<div class="modal fade" id="modalVerImagen" tabindex="-1" aria-labelledby="modalVerImagenLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVerImagenLabel">
                    Imagen de Perfil Ampliada
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img id="imgModalGrande" src="" alt="Imagen de Perfil Ampliada" class="img-fluid img-modal-max"
                    style="border-radius: 8px" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Variables globales para la instancia de Bootstrap Modal (se mantiene)
let imagenModalInstance;

function init() {
    const modalElement = document.getElementById("modalVerImagen");
    if (
        modalElement &&
        typeof bootstrap !== "undefined" &&
        typeof bootstrap.Modal !== "undefined"
    ) {
        imagenModalInstance = new bootstrap.Modal(modalElement);
    } else {
        console.error(
            "Error: Bootstrap 5.3 JS o el elemento Modal no se ha cargado correctamente."
        );
    }
}

function verImagenGrande(ruta) {
    if (!imagenModalInstance) {
        console.error("El modal no está inicializado.");
        return;
    }
    // Asumiendo que usas jQuery si tienes $(...)
    if (typeof $ !== 'undefined') {
        $("#imgModalGrande").attr("src", ruta);
    } else {
        document.getElementById("imgModalGrande").src = ruta;
    }
    imagenModalInstance.show();
}

document.addEventListener("DOMContentLoaded", init);
// ------------------------------------------------------------------------------------------------


// -------------------------------------------------------------
// FUNCIONES DE SEGURIDAD, VALIDACIÓN Y FORMATO
// -------------------------------------------------------------

/**
 * Valida el dígito verificador (DV) de un RUT chileno.
 */
function validarRUT(rutCompleto) {
    if (!rutCompleto) return false;
    rutCompleto = rutCompleto.replace(/[^0-9kK]/g, '').toUpperCase();
    if (rutCompleto.length < 2) return false;

    const cuerpo = rutCompleto.slice(0, -1);
    const dv = rutCompleto.slice(-1);

    if (!/^\d+$/.test(cuerpo)) return false;

    let suma = 0;
    let multiplo = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += parseInt(cuerpo.charAt(i), 10) * multiplo;
        multiplo = multiplo < 7 ? multiplo + 1 : 2;
    }

    const resto = suma % 11;
    let dvEsperado = 11 - resto;

    if (dvEsperado === 11) {
        dvEsperado = '0';
    } else if (dvEsperado === 10) {
        dvEsperado = 'K';
    } else {
        dvEsperado = String(dvEsperado);
    }
    return dvEsperado === dv;
}


/**
 * Aplica la MÁSCARA CON PUNTOS y GUION para el RUT.
 */
function formatAndValidateRUT() {
    let rutInput = document.getElementById('rut');
    let valorLimpio = rutInput.value.replace(/[^0-9kK]/g, '').toUpperCase();
    let rutFormateado = '';

    const originalLength = rutInput.value.length;
    const originalCursor = rutInput.selectionStart;

    if (valorLimpio.length > 1) {
        let dv = valorLimpio.slice(-1);
        let cuerpo = valorLimpio.slice(0, -1);
        cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        rutFormateado = cuerpo + '-' + dv;
    } else {
        rutFormateado = valorLimpio;
    }

    rutInput.value = rutFormateado;

    const newLength = rutInput.value.length;
    const diff = newLength - originalLength;
    rutInput.selectionStart = rutInput.selectionEnd = originalCursor + diff;


    // Estilos de validación:
    if (valorLimpio.length >= 7) {
        if (validarRUT(valorLimpio)) {
            rutInput.classList.remove('is-invalid');
            rutInput.classList.add('is-valid');
        } else {
            rutInput.classList.remove('is-valid');
            rutInput.classList.add('is-invalid');
        }
    } else {
        rutInput.classList.remove('is-valid', 'is-invalid');
    }
}


/**
 * Aplica la máscara +569 al teléfono y limita la entrada a 8 dígitos.
 */
function formatTelefono() {
    const telefonoInput = document.getElementById('telefono');
    const prefijo = '+569';

    let valor = telefonoInput.value.replace(/[^0-9]/g, ''); // Deja solo números

    // Quitar cualquier +569 existente en el valor numérico (569)
    let sinPrefijo = valor.replace(/^569/, '');

    // Limitar el cuerpo a 8 dígitos.
    let cuerpo = sinPrefijo.substring(0, 8);

    // Aplicar el nuevo valor con la máscara
    telefonoInput.value = prefijo + cuerpo;

    // Limitar el tamaño máximo (prefijo 4 + cuerpo 8 = 12)
    telefonoInput.maxLength = 12;

    // Estilos de validación para el teléfono
    if (cuerpo.length === 8) {
        telefonoInput.classList.remove('is-invalid');
        telefonoInput.classList.add('is-valid');
    } else {
        telefonoInput.classList.remove('is-valid', 'is-invalid');
    }
}


/**
 * FUNCIÓN DE SEGURIDAD: Limpia una cadena de caracteres (Sanitización XSS).
 */
function sanitizeInput(str) {
    if (!str) return '';
    // 1. Eliminar etiquetas HTML comunes y scripts
    let cleanStr = str.replace(/<script\b[^>]*>([\s\S]*?)<\/script>/gm, "")
        .replace(/<[^>]*>?/gm, "");
    // 2. Escapar caracteres que podrían usarse para inyección
    cleanStr = cleanStr.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    return cleanStr.trim();
}


/**
 * Maneja el envío del formulario: valida, sanitiza y limpia el RUT para el envío.
 */
function handleFormSubmit(e) {
    const formulario = document.getElementById('formulario');
    const rutInput = document.getElementById('rut');
    const telefonoInput = document.getElementById('telefono');

    // Campos de texto libre a SANITIZAR (para XSS)
    const camposASanitizar = [
        'nombre',
        'apellido',
        'direccion',
        'email'
    ];

    // 1. Forzar validación final de RUT y Teléfono
    formatAndValidateRUT();
    formatTelefono();

    // 2. Validación de RUT y Teléfono
    if (!validarRUT(rutInput.value) || telefonoInput.value.length !== 12) {
        e.preventDefault();
        // Asegurarse de que Bootstrap muestre los errores
        formulario.classList.add('was-validated');
        if (!validarRUT(rutInput.value)) {
            rutInput.focus();
        } else if (telefonoInput.value.length !== 12) {
            telefonoInput.focus();
        }
        return;
    }

    // 3. Detener envío si los campos 'required' de HTML5 no son válidos (fech_Nac, email, etc.)
    if (!formulario.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        formulario.classList.add('was-validated');
        return;
    }

    // 4. *** APLICAR SANITIZACIÓN A LOS CAMPOS DE TEXTO LIBRE (SEGURIDAD XSS) ***
    camposASanitizar.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.value = sanitizeInput(input.value);
        }
    });

    // 5. *** LIMPIEZA FINAL DEL RUT PARA EL ENVÍO ***
    // Valor enviado: XXXXXXXX-X (solo guion)
    const maskedValue = rutInput.value;
    const cleanRutToSend = maskedValue.replace(/\./g, '');
    rutInput.value = cleanRutToSend;

    // El formulario continuará con el envío: RUT limpio, Teléfono con +569, campos sanitizados.
}


// -------------------------------------------------------------
// ENLAZAR EVENTOS
// -------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function() {
    const rutInput = document.getElementById('rut');
    const telefonoInput = document.getElementById('telefono');
    const formulario = document.getElementById('formulario');

    if (rutInput) {
        rutInput.addEventListener('input', formatAndValidateRUT);
    }

    if (telefonoInput) {
        telefonoInput.addEventListener('input', formatTelefono);
        formatTelefono(); // Inicializa la máscara si hay un valor previo
    }

    if (formulario) {
        formulario.addEventListener('submit', handleFormSubmit);
        // Mostrar los errores de validación de Bootstrap al interactuar
        formulario.addEventListener('blur', (event) => {
            if (event.target.required) {
                formulario.classList.add('was-validated');
            }
        }, true);
    }
});
</script>
<?php
// 4. INCLUIR EL PIE DE PÁGINA
require_once 'footer.php';
// Liberación del buffer al final del archivo
ob_end_flush();
?>