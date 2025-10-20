/*
 * Lógica de Frontend para la gestión de Usuarios
 * Implementa las funciones AJAX para interactuar con UsuarioController.php
 * Requiere jQuery, DataTables y SweetAlert2 (Swal.fire).
 */

var tabla; // Variable global para DataTables

// Función para inicializar
function init() {
    // Ocultar formulario al inicio
    mostrarform(false);
    // Carga inicial de la tabla (y asignación a la variable global 'tabla')
    listar();

    // Nota: El botón Agregar en tu HTML usa onclick="mostrarform(true)". Si usas un ID, sería:
    // $("#btnagregar").on("click", function () {
    //     mostrarform(true);
    // });

    // Inicializa los eventos: Escucha el submit del formulario con ID #formulario
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

    $("#imagen").change(function () {
        mostrar_vista_previa(this);
    });

    $("#imagenmuestra").attr(
        "src",
        "../../public/assets/img/huevo.jpg"
    );
}

// -----------------------------------------------------------
// 🔥 FUNCIÓN CLAVE MODIFICADA 🔥
// -----------------------------------------------------------

/**
 * Muestra u oculta la sección del formulario, usando CLASES DE BOOTSTRAP.
 * @param {boolean} flag - True para mostrar el formulario, False para mostrar el listado.
 */
function mostrarform(flag) {
    if (flag) {
        // MOSTRAR FORMULARIO
        $("#listado_registros").addClass("d-none");         // ⬅️ Oculta la sección completa del listado
        $("#formularioregistros").removeClass("d-none");    // ⬅️ Muestra el formulario

        // Otras acciones (manteniendo la coherencia, aunque #btnagregar ya está dentro de #listado_registros)
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide(); // Oculta el botón por si hay algún conflicto visual
        $("#rut").focus();

    } else {
        // MOSTRAR LISTADO
        $("#listado_registros").removeClass("d-none");     // ⬅️ Muestra la sección completa del listado
        $("#formularioregistros").addClass("d-none");      // ⬅️ Oculta el formulario

        // Otras acciones
        $("#btnagregar").show(); // Muestra el botón por si hay algún conflicto visual

        // Recargar la tabla al volver al listado (buena práctica)
        if ($.fn.DataTable.isDataTable('#tbllistadoUsuarios')) {
            tabla.ajax.reload(null, false);
        }
    }
}

// -----------------------------------------------------------
// 🧠 LÓGICA DE LIMPIEZA DEL FORMULARIO 🧠
// -----------------------------------------------------------

/**
 * Limpia los campos del formulario.
 */
function limpiar() {
    // 🔥 USAR EL RESET NATIVO PARA LIMPIAR CORRECTAMENTE EL CAMPO FILE 🔥
    $('#formulario')[0].reset();

    // Limpia campos ocultos que reset() no toca
    $("#idusuario").val("");
    $("#login").val("");
    $("#imagenactual").val("");

    // Restablecer vista previa de la imagen
    $("#imagenmuestra").attr(
        "src",
        "../../public/assets/img/huevo.jpg"
    );
}


/**
 * Cancela la operación y vuelve al listado.
 */
function cancelarform() {
    limpiar();
    // Llama a la función que ahora funciona correctamente
    mostrarform(false);
}

// -----------------------------------------------------------
// (RESTO DE TUS FUNCIONES SIN MODIFICAR)
// -----------------------------------------------------------

/**
 * Muestra mensajes de notificación (reemplazo de alert() por console.log para entorno Canvas).
 * @param {string} mensaje - El mensaje a mostrar.
 * @param {string} tipo - 'success', 'error', 'info', 'warning'.
 */
function bootboxAlert(mensaje, tipo = 'success') {
    // Usamos console.log ya que alert() no es permitido en este entorno
    console.log(`[Mensaje ${tipo.toUpperCase()}]: ${mensaje}`);
}

/**
 * Carga los datos en el DataTables.
 * IMPORTANTE: Asigna la instancia de DataTables a la variable global 'tabla'.
 */
function listar() {

    const spinner = document.getElementById('loading-spinner');
    const listadoRegistros = document.getElementById('listadoregistros');

    if (spinner && listadoRegistros) {
        spinner.classList.remove('d-none'); // Muestra el spinner
        listadoRegistros.classList.add('d-none'); // Oculta el contenedor de la tabla
    }

    // Destruye la instancia anterior si existe (asegurado por bDestroy: true)
    if ($.fn.DataTable.isDataTable('#tbllistadoUsuarios')) {
        $('#tbllistadoUsuarios').DataTable().destroy();
    }

    tabla = $('#tbllistadoUsuarios').DataTable({
        lengthMenu: [5, 10, 25, 75, 100], //mostramos el menú de registros
        aProcessing: true, // Activamos el procesamiento de DataTables
        aServerSide: true, // Paginación y filtrado realizados por el servidor
        dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
        buttons: [
            "copyHtml5",
            "excelHtml5",
            "csvHtml5",
            "pdf"],
        ajax: {
            // RUTA CORRECTA (La misma usada por listar)
            url: "../../app/Controllers/UsuarioController.php?op=listar",
            type: "post",
            dataType: "json",
            // Agregamos un parámetro anti-cache para peticiones posteriores
            data: function (d) {
                d.nocache = new Date().getTime();
            },
            error: function (e) {
                console.log(e.responseText);
            }
        },
        language: {
            processing: "Trabajando ...",
            search: "Buscar&nbsp;:",
            info: "Mostrando Pagina _PAGE_ of _PAGES_",
            infoEmpty: "No hay Registros Disponibles",
            infoFiltered: "(filtered from _MAX_ total records)",
            lengthMenu: "Mostrar _MENU_ Registros",
            zeroRecords: "No Existen Registros para Mostrar",
            paginate: {
                first: "Primera",
                previous: "Anterior",
                next: "Proxima",
                last: "Ultima",
            },
            buttons: {
                copyTitle: "Tabla Copiada",
                copySuccess: {
                    _: "%d líneas copiadas",
                    1: "1 línea copiada",
                },
            },
        },

        bDestroy: true, // Permite que la tabla se reinicialice si se llama de nuevo a listar()
        iDisplayLength: 5, // Paginación
        order: [[0, "desc"]], // Ordenar por la columna 0 (idusuario) de forma descendente
        columnDefs: [
            { width: "15%", targets: 0 }, // Opciones
            { orderable: false, targets: [0, 6] }, // Deshabilitar ordenar en Opciones e Imagen
        ],


        initComplete: function (settings, json) {
            if (spinner && listadoRegistros) {
                spinner.classList.add('d-none'); // Oculta el spinner
                listadoRegistros.classList.remove('d-none'); // Muestra el contenedor de la tabla
            }
        }




    });
}

/**
 * Muestra los datos de un usuario en el formulario para su edición.
 * @param {number} idusuario - ID del usuario a mostrar.
 */
function mostrar(idusuario) {
    // RUTA UNIFICADA
    $.post("../../app/Controllers/UsuarioController.php?op=mostrar", {
        idusuario: idusuario
    }, function (data, status) {
        // Manejo de error de JSON en mostrar
        try {
            data = JSON.parse(data);
        } catch (error) {
            bootboxAlert("Error de Formato JSON al cargar datos. Revise la consola.", 'error');
            console.error("Respuesta cruda de 'mostrar':", data);
            console.error("Error de parseo:", error);
            return;
        }

        if (data.status) {
            mostrarform(true); // Mostrar formulario

            // Cargar datos en los campos
            $("#idusuario").val(data.data.idusuario);
            $("#nombre").val(data.data.nombre);
            $("#tipoDoc").val(data.data.tipo_documento);
            $("#numDoc").val(data.data.num_documento);
            $("#direccion").val(data.data.direccion);
            $("#telefono").val(data.data.telefono);
            $("#email").val(data.data.email);
            $("#login").val(data.data.login);
            // La clave no se carga por seguridad

            $("#descripcion").val(data.data.descripcion);
            $("#imagenactual").val(data.data.imagen);
            $("#imagenmuestra").attr("src", "../files/usuarios/" + data.data.imagen);

        } else {
            bootboxAlert(data.mensaje, 'error');
        }
    });
}

/**
 * Envía los datos del formulario para guardar o editar.
 * @param {Event} e - Evento de submit del formulario.
 */
function guardaryeditar(e) {
    e.preventDefault(); // Evitar el envío normal del formulario
    $("#btnGuardar").prop("disabled", true);

    // Usamos el ID #formulario
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        // RUTA UNIFICADA
        url: "../../app/Controllers/UsuarioController.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            // INICIO: Manejo de error de JSON robusto
            try {
                // Si el servidor envía HTML o un error de PHP, esto falla
                data = JSON.parse(data);
            } catch (error) {
                bootboxAlert("Error de Formato JSON en la respuesta al guardar. Revise la consola para detalles.", 'error');
                console.error("Detalle del Error de JSON:", error);
                console.error("Respuesta cruda del servidor:", data); // <-- ¡Revisa este output!
                limpiar();
                $("#btnGuardar").prop("disabled", false);
                return;
            }
            // FIN: Manejo de error de JSON robusto

            if (data.status) {
                bootboxAlert(data.mensaje, 'success');
                mostrarform(false);
                // 🛠️ DEBUG y RECARGA FORZADA: Recarga la tabla después de guardar/editar.
                console.log("DEBUG: Ejecutando recarga de tabla después de guardar/editar...");
                tabla.ajax.reload(null, false);
            } else {
                bootboxAlert(data.mensaje, 'error');
            }
            limpiar();
            $("#btnGuardar").prop("disabled", false);
        },
        error: function (e) {
            bootboxAlert("Error de conexión al guardar: " + e.responseText, 'error');
            $("#btnGuardar").prop("disabled", false);
        }
    });
}

/**
 * Desactiva un usuario después de una confirmación con SweetAlert2
 * @param {string} idusuario - ID del usuario a desactivar
 */
function desactivar(idusuario) {
    Swal.fire({
        title: 'Confirmar Desactivación',
        text: "¿Está seguro de desactivar este usuario?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, ¡Desactivar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // RUTA UNIFICADA
            $.post("../../app/Controllers/UsuarioController.php?op=desactivar", {
                idusuario: idusuario
            },
                function (e) {

                    if (e.status) {
                        Swal.fire(' ¡Desactivado!',
                            'El usuario ha sido marcado como INACTIVO.',
                            'success');
                        tabla.ajax.reload(null, false);

                    } else {
                        Swal.fire('Error',
                            e.mensaje, 'error'
                        );
                    }
                }).fail(function (jqXHR) {
                    Swal.fire(
                        'Error de Conexión',
                        "Error al intentar desactivar el usuario. Por favor, revise la consola.",
                        'error'
                    );
                    console.error("Detalle del error: ", jqXHR.responseText);
                });
        }
    });
}

/**
 * Activa un usuario.
 * @param {number} idusuario - ID del usuario a activar.
 */
function activar(idusuario) {
    Swal.fire({
        title: 'Confirmar Activación',
        text: "¿Está seguro de activar este usuario?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, ¡Activar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // RUTA UNIFICADA
            $.post("../../app/Controllers/UsuarioController.php?op=activar", {
                idusuario: idusuario
            }, function (e) {

                // En usuario.js, dentro de la función activar/desactivar:
                if (e.status) {
                    // Si recibe {"status":true}, muestra el mensaje de ÉXITO (fijo en JS)
                    Swal.fire(' ¡Activado!',
                        'El usuario ha sido marcado como ACTIVO.',
                        'success');
                    tabla.ajax.reload(null, false);
                } else {
                    // Si recibe {"status":false}, muestra el mensaje de ERROR (fijo en JS)
                    Swal.fire('Error', 'Ocurrió un error en la base de datos.', 'error');
                }

            }).fail(function (jqXHR) {
                Swal.fire(
                    'Error de Conexión',
                    "Error al intentar activar el usuario. Por favor, revise la consola.",
                    'error'
                );
                console.error("Detalle del error: ", jqXHR.responseText);
            });
        }
    });
}

/**
 * Elimina Físicamente un usuario.
 * @param {number} idusuario - ID del usuario a eliminar.
 */
function eliminar(idusuario) {
    Swal.fire({
        title: '¡ATENCIÓN! ⚠️',
        text: "¿Está seguro de ELIMINAR PERMANENTEMENTE este usuario? Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, ¡Eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // RUTA UNIFICADA
            $.post("../../app/Controllers/UsuarioController.php?op=eliminar", {
                idusuario: idusuario
            }, function (e) {
                // INICIO: Manejo de error de JSON robusto
                try {
                    e = JSON.parse(e);
                } catch (error) {
                    Swal.fire('Error de Formato', 'La respuesta del servidor no es JSON válida. Revise la consola.', 'error');
                    console.error("Respuesta cruda de 'eliminar':", e);
                    console.error("Error de parseo:", error);
                    return;
                }
                // FIN: Manejo de error de JSON robusto

                if (e.status) {
                    Swal.fire(
                        '¡Eliminado!',
                        e.mensaje,
                        'success'
                    );
                    // 🛠️ DEBUG y RECARGA FORZADA: Recarga la tabla después de eliminar
                    console.log("DEBUG: Ejecutando recarga de tabla después de eliminar...");
                    tabla.ajax.reload(null, false);
                } else {
                    Swal.fire(
                        'Error',
                        e.mensaje,
                        'error'
                    );
                }
            }).fail(function (jqXHR) {
                Swal.fire(
                    'Error de Conexión',
                    "Error al intentar eliminar el usuario. Por favor, revise la consola.",
                    'error'
                );
                console.error("Detalle del error: ", jqXHR.responseText);
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelado',
                'El usuario no ha sido eliminado.',
                'error'
            );
        }
    });
}

/**
 * Muestra una vista previa de la imagen seleccionada.
 */
function mostrar_vista_previa(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#imagenmuestra").attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        // Usar un placeholder si no hay imagen
        $("#imagenmuestra").attr(
            "src",
            "https://placehold.co/50x50/cccccc/000000?text=IMG"
        );
    }
}


// Inicializar al cargar la página
init();