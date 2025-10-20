 <?php
/**
 * Archivo de configuración para la conexión a la base de datos.
 * Obtiene las credenciales desde variables de entorno.
 * * CRÍTICO: Asegúrate de que tu librería para cargar el .env (como Dotenv)
 * se haya ejecutado ANTES de que este archivo sea requerido. Esto debe hacerse
 * en un archivo de inicio temprano, como init.php o index.php.
 */

return [
    // Servidor (se usa un valor por defecto si no se encuentra en el entorno)
    'host' => getenv('DB_HOST') ?: 'localhost',
    
    // Nombre de usuario de la base de datos
    'user' => getenv('DB_USER') ?: 'root',
    
    // Contraseña de la base de datos
    'pass' => getenv('DB_PASS') ?: '', 
    
    // Nombre de la base de datos (schema)
    'dbname' => getenv('DB_NAME') ?: 'db_videos',
    
    // Codificación de caracteres
    'encode' => getenv('DB_ENCODE') ?: 'utf8'
];
// Se omite la etiqueta de cierre para evitar problemas de salida (whitespace)