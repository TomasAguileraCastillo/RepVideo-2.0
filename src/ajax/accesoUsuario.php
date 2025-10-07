<?php
// 💡 NOTA: Desactiva el 'display_errors' a 0 en el servidor de producción.
ini_set('display_errors', 0);
error_reporting(E_ALL);

// 1. GESTIÓN DE SALIDA Y SESIÓN
ob_start();
if (strlen(session_id()) < 1) {
    session_start();
}

// 2. INCLUSIÓN DE MODELO Y OBJETOS
require_once "../modelo/AccesoUsuario.php";
$usuario = new AccesoUsuario(); 

ob_clean(); // Limpia cualquier output inesperado antes de cabeceras/JSON

// 3. CONFIGURACIÓN Y PREPARACIÓN DE RESPUESTA
date_default_timezone_set('America/Santiago');
header('Content-Type: application/json');

// 4. OBTENCIÓN DE DATOS Y SANITIZACIÓN
// Aplicar trim() y limpiar caracteres especiales (opcional para login, crítico para otros campos)
$loginac = isset($_POST['login']) ? trim($_POST['login']) : '';
$clave_ingresada = isset($_POST['password']) ? $_POST['password'] : ''; 

// Inicialización de la respuesta JSON
$respuesta = ["success" => false, "mensaje" => ""];

// 5. LÓGICA DEL CONTROLADOR
switch ($_GET["op"]) {
    case 'verificar':
        // --- VALIDACIONES PREVIAS ---
        if (empty($loginac) || empty($clave_ingresada)) {
            $respuesta["mensaje"] = "Por favor, complete todos los campos.";
            break; // Sale del switch y va a la respuesta final
        }
        
        // 1. OBTENER REGISTRO DEL USUARIO (Asume que verifica usa prepared statements)
        $rspta = $usuario->verifica($loginac); 
        $fetch = $rspta->fetch_object();

        // AÑADE ESTO TEMPORALMENTE para debug
if (isset($fetch)) {
    // Si el usuario se encontró, muestra el login y el hash almacenado
    error_log("DEBUG: Usuario encontrado: " . $fetch->login . " | Hash en BD (CLAVE): " . $fetch->clave);
} else {
    // Si el usuario NO se encontró
    error_log("DEBUG: Usuario NO encontrado para login: " . $loginac);
}


        $bloqueo_status = null;
        
        if ($fetch) {
            
            // A. Verificar estado de la cuenta
            if ($fetch->condicion == 0) {
                $respuesta["mensaje"] = "Su cuenta está inactiva. Contacte al administrador.";
            } 
            // B. VERIFICACIÓN DE CLAVE (HASHING SEGURO)
            elseif (password_verify($clave_ingresada, $fetch->clave)) {
                
                // 2. ACCESO CONCEDIDO: CREACIÓN DE SESIÓN SEGURA
                session_regenerate_id(true); // Previene Fijación de Sesión
                
                // Guardamos los datos de sesión (Aplicar htmlspecialchars() si $fetch->nombre/imagen pudiera contener scripts)
                $_SESSION['idusuario'] = $fetch->idusuario;
                $_SESSION['nombre'] = htmlspecialchars($fetch->nombre); // Recomendado
                $_SESSION['imagen'] = htmlspecialchars($fetch->imagen); // Recomendado
                $_SESSION['login'] = htmlspecialchars($fetch->login);   // Recomendado
                
                $respuesta["success"] = true;
                $respuesta["mensaje"] = "Acceso concedido.";
                
                // Opcional: Llamar a método para reiniciar el contador de fallos
                // $usuario->limpiarIntentosExitosos($fetch->login); 

            } else {
                // 3. CLAVE INCORRECTA: Registrar FALLO
                $respuesta["mensaje"] = "Usuario y/o Contraseña incorrectos.";
                // 🚨 LLAMAR AL BLOQUEADOR: Esto registra el intento fallido y devuelve el estado
                $bloqueo_status = $usuario->verificarBloqueo($loginac); 
            }

        } else {
            // 4. USUARIO NO ENCONTRADO: Registrar FALLO
            $respuesta["mensaje"] = "Usuario y/o Contraseña incorrectos.";
            // 🚨 LLAMAR AL BLOQUEADOR: Registrar intento fallido (por IP)
            $bloqueo_status = $usuario->verificarBloqueo($loginac); 
        }
        
        // 5. MANEJO DE RESPUESTA DE BLOQUEO (SOBRESCRIBE la respuesta estándar si hay bloqueo)
        if (isset($bloqueo_status) && $bloqueo_status['status'] === 'error' && isset($bloqueo_status['code'])) {
            
            // Si el Modelo devuelve un código 429, lo enviamos al JS
            if ($bloqueo_status['code'] === 429) {
                http_response_code(429); // Envía la cabecera 429
            }
            // El mensaje de error de bloqueo siempre debe sobrescribir el mensaje genérico
            $respuesta["success"] = false;
            $respuesta["mensaje"] = $bloqueo_status['message'];
        }
        
        // El break envía la respuesta JSON
        break;

    case 'salir':
        // Limpiar y destruir la sesión de forma segura
        session_unset();
        session_destroy();
        // Redirección simple (no retorna JSON)
        header("Location: ../index.php"); 
        exit();
        break;
        
    default:
        // Manejar operaciones no válidas
        http_response_code(400); // Bad Request
        $respuesta = ["success" => false, "mensaje" => "Operación no válida."];
}

// 6. RESPUESTA FINAL
echo json_encode($respuesta);

ob_end_flush();
?>