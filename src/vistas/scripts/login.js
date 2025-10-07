 // Función Auto-Ejecutable (IIFE) para aislar el código
(function($) {

    $(document).ready(function() {

        $('#frmAcceso').on('submit', function(e) {

            // 1. Prevenir el envío estándar del formulario
            e.preventDefault();

            // 2. Capturar datos con los nuevos nombres del formulario
            let loginAcceso = $('#loginacc').val().trim();
            let claveAcceso = $('#claveacc').val().trim();

            // 3. Validación rápida en el cliente
            if (!loginAcceso || !claveAcceso) {
                bootbox.alert("Por favor, ingresa tu usuario y contraseña.");
                return;
            }



            //***************************************************************************** */
            // 4. Petición AJAX POST (Usamos $.ajax para manejar el error 429 correctamente)
            $.ajax({
                url: "../ajax/accesoUsuario.php?op=verificar",
                type: "POST", // Especificamos el método POST
                data: { 
                    login: loginAcceso,
                    password: claveAcceso
                },
                // Le decimos a jQuery que espere JSON. Esto no cambia el manejo del error 429,
                // pero es buena práctica para respuestas 200.
                dataType: "json" 
            })
            .done(function(response) {
                // ESTA FUNCIÓN SE EJECUTA SOLO SI EL CÓDIGO HTTP ES 200 (Éxito o Fallo de Credencial sin Bloqueo)
                
                if (response.success) { 
                    // Login Exitoso
                    $(location).attr("href", "../vistas/dashboard.php");
                } else {
                    // Maneja fallos de credenciales (ej. "Usuario y/o Contraseña incorrectos")
                    bootbox.alert(response.mensaje || "Usuario y/o Password incorrectos.");
                    
                    // Limpiar campos y devolver el foco al usuario
                    $('#loginacc').val("").focus(); 
                    $('#claveacc').val("");
                }
            })
            .fail(function(xhr, status, error) {
                // 💡 ESTA FUNCIÓN SE EJECUTA CUANDO HAY UN CÓDIGO HTTP DE ERROR (429, 404, 500)
                
                // Verificamos si es el código de límite de intentos excedido (429)
                if (xhr.status === 429) {
                    try {
                        // Leemos el JSON que el Controlador nos envió
                        var response = JSON.parse(xhr.responseText);
                        
                        // Usamos el mensaje específico (Bloqueo por Usuario o por IP)
                        bootbox.alert(response.mensaje); 
                        
                        // Limpiar campos y devolver el foco al usuario
                        $('#loginacc').val("").focus(); 
                        $('#claveacc').val("");
                        
                    } catch (e) {
                        // Fallo al parsear el JSON 
                        console.error("Error al leer JSON 429:", e);
                        bootbox.alert("Error: Límite de intentos excedido. Intenta de nuevo más tarde.");
                    }
                } else {
                    // Manejo de otros errores (404, 500, etc.)
                    console.error("Error en la solicitud AJAX:", status, error);
                    bootbox.alert("Error en la conexión con el servidor (código: " + xhr.status + ").");
                }
            });




            
        });
    });

})(jQuery);