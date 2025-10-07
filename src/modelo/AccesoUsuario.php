<?php
// Incluir el archivo de conexión. 
// ASUME que este archivo define una instancia de mysqli llamada $conexion.
require_once '../config/Conexion.php'; 

class AccesoUsuario {

    private $conexion; // Almacenará el objeto de conexión MySQLi

    // Constructor: Se ejecuta al crear el objeto $usuario en el controlador AJAX
    public function __construct() {
        // Accedemos a la variable de conexión global definida en Conexion.php
        global $conexion; 
        $this->conexion = $conexion; 
        
        // Es buena práctica verificar la conexión inmediatamente
        if ($this->conexion->connect_error) {
            // Detener la ejecución si la conexión falla
            die("Error de Conexión (MySQLi): " . $this->conexion->connect_error);
        }
    }

    // =========================================================
    // 1. MÉTODO DE VERIFICACIÓN (CRÍTICO PARA EL LOGIN)
    // =========================================================
    
    /**
     * Busca el registro de un usuario por su login.
     * Retorna el objeto de resultado para obtener el hash de la clave.
     * @param string $login El nombre de usuario a buscar.
     * @return object|false Objeto de resultado de MySQLi o false si hay error.
     */
    public function verifica($login) {
        
        // La consulta debe traer la columna 'clave' (que contiene el hash)
        $sql = "SELECT idusuario, nombre, imagen, login, clave, condicion 
                FROM usuario 
                WHERE login = ?";

        // --- Sentencia Preparada (Prevención de Inyección SQL) ---
        
        // 1. Preparar la consulta
        $stmt = $this->conexion->prepare($sql);
        
        if ($stmt === false) {
            // Lanzar una excepción si la consulta es sintácticamente incorrecta
            error_log("Error al preparar verifica: " . $this->conexion->error);
            return false;
        }

        // 2. Vincular parámetros: "s" indica que $login es un string
        $stmt->bind_param("s", $login);
        
        // 3. Ejecutar la consulta
        $stmt->execute();
        
        // 4. Devolver el resultado para que el controlador AJAX pueda usar fetch_object()
        return $stmt->get_result(); 
    }
    
    // =========================================================
    // 2. MÉTODO DE INSERCIÓN (Para guardar usuarios nuevos de forma segura)
    // =========================================================

    /**
     * Inserta un nuevo usuario, aplicando Hashing a la contraseña.
     * ESTE MÉTODO DEBE USARSE AL REGISTRAR NUEVOS USUARIOS.
     */
    public function insertar($nombre, $login, $clave_texto_plano) {
        
        // CRÍTICO: Aplicar password_hash() para almacenar el hash seguro
        $clave_hash = password_hash($clave_texto_plano, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuario (nombre, login, clave, condicion) 
                VALUES (?, ?, ?, 1)";
                
        $stmt = $this->conexion->prepare($sql);
        
        if ($stmt === false) {
             error_log("Error al preparar INSERT: " . $this->conexion->error);
             return false;
        }
        
        // "sssi" indica 3 strings (nombre, login, clave_hash) y 1 integer (condicion)
        $condicion = 1;
        $stmt->bind_param("sssi", $nombre, $login, $clave_hash, $condicion);
        
        // Devolvemos true/false según si la ejecución fue exitosa
        return $stmt->execute();
    }
    
    // NOTA: Otros métodos CRUD (editar, desactivar, listar) irían aquí
    // Dentro de class AccesoUsuario en AccesoUsuario.php
/************************************************************************************ */
    /**
     * Registra el intento de login fallido y verifica si el usuario o IP deben ser bloqueados.
     * Retorna TRUE si está bloqueado, FALSE si puede continuar el login.
     * @param string $login El nombre de usuario que intentó acceder.
     * @return boolean
     */
    public function verificarBloqueo($login) {
        
        // --- CONFIGURACIÓN DE LÍMITES ---
        $limite_intentos = 5;      // Número máximo de fallos permitidos.
        $tiempo_bloqueo_min = 15;  // Ventana de tiempo en minutos (15 minutos).
        
        // 1. OBTENER LA IP DEL CLIENTE (Mejor práctica para obtener la IP real)
        $ip_address = $_SERVER['REMOTE_ADDR']; 
        
        // Si estás detrás de un proxy/CDN como Cloudflare, debes usar:
        // $ip_address = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

        // ----------------------------------------------------------------------
        // 2. REGISTRO DEL FALLO (Insertar el intento fallido en la tabla log_intentos) 
        // ----------------------------------------------------------------------
        
        $sql_insert = "INSERT INTO log_intentos (ip_address, login_fallido, timestamp_fallo, estado) 
                       VALUES (?, ?, NOW(), 'fallo')";
        
        $stmt_insert = $this->conexion->prepare($sql_insert);
        
        if ($stmt_insert === false) {
            error_log("Error al preparar INSERT de fallo: " . $this->conexion->error);
            return false; // Permite el acceso por si el log de fallos está roto
        }
        
        $stmt_insert->bind_param("ss", $ip_address, $login);
        $stmt_insert->execute();

        // ----------------------------------------------------------------------
        // 3. VERIFICACIÓN DE BLOQUEO POR LOGIN (Usuario)
        // ----------------------------------------------------------------------

        $sql_check_login = "SELECT COUNT(*) AS total FROM log_intentos 
                            WHERE login_fallido = ? 
                            AND timestamp_fallo > DATE_SUB(NOW(), INTERVAL ? MINUTE)";
                            
        $stmt_login = $this->conexion->prepare($sql_check_login);
        $stmt_login->bind_param("si", $login, $tiempo_bloqueo_min); // "s" string, "i" integer
        $stmt_login->execute();
        
        $result_login = $stmt_login->get_result()->fetch_assoc();

        if ($result_login['total'] >= $limite_intentos) {
            // Bloqueo por Usuario
            return [    'status' => 'error',
                        'code' => 429,
                        'message' => "Has superado el límite de intentos fallidos para este usuario. Espera " . $tiempo_bloqueo_min . " minutos."
                    ];
        } 
        
        // ----------------------------------------------------------------------
        // 4. VERIFICACIÓN DE BLOQUEO POR IP
        // ----------------------------------------------------------------------
        
        $sql_check_ip = "SELECT COUNT(*) AS total FROM log_intentos 
                         WHERE ip_address = ? 
                         AND timestamp_fallo > DATE_SUB(NOW(), INTERVAL ? MINUTE)";
                         
        $stmt_ip = $this->conexion->prepare($sql_check_ip);
        $stmt_ip->bind_param("si", $ip_address, $tiempo_bloqueo_min); // "s" string, "i" integer
        $stmt_ip->execute();
        
        $result_ip = $stmt_ip->get_result()->fetch_assoc();

        if ($result_ip['total'] >= $limite_intentos) {
            //objeto estructurado para bloqueo de IP
            return [
                'status' => 'error',
                'code' => 429,
                'message' => "Se ha detectado demasiada actividad fallida desde tu conexión (IP) y Has superado el límite de intentos fallidos desde tu IP. Espera " . $tiempo_bloqueo_min . " minutos."
            ]; 
        }
        
        // ----------------------------------------------------------------------
        // 5. NO BLOQUEADO (Limpieza opcional)
        // ----------------------------------------------------------------------

        // Opcional: Podrías añadir lógica aquí para limpiar registros muy viejos de la tabla
        
            
        return [
            'status' => 'ok',
            'code' => 200,
            'message' => "Acceso permitido."
        ];

    }


}
?>