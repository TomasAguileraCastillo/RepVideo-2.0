<?php
// config/init.php
// =========================================================
// 1. CARGA DEL AUTOLOADER DE COMPOSER
// =========================================================
// Esto permite que todos los namespaces funcionen (App\Core\, App\Models\, etc.)
require __DIR__ . '/../../vendor/autoload.php';

// =========================================================
// 1.5. CARGA DE VARIABLES DE ENTORNO (.ENV)
// =========================================================
// * CRÍTICO: Debes tener instalado 'vlucas/phpdotenv' via Composer.
use Dotenv\Dotenv;

try {
    // La carpeta raíz del proyecto es dos niveles arriba de 'config/'
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->safeLoad();  // Usamos safeLoad para no fallar si el archivo .env no existe
} catch (\Exception $e) {
    // Si la carga falla por alguna razón (ej. problemas de permisos),
    // registramos el error en lugar de imprimirlo, lo que corrompería el JSON.
    error_log('Error al cargar el archivo .env: ' . $e->getMessage());
}

// =========================================================
// 2. INICIALIZACIÓN DEL SISTEMA (BASE DE DATOS)
// =========================================================
// Importamos la CLASE DE CONEXIÓN REAL usando su namespace
use App\Core\Conexion;

// Creamos una variable global para almacenar la única instancia de la conexión.
global $db;

// Al llamar a getInstancia(), tu clase Conexion (Singleton) se conecta
// a la DB UNA SOLA VEZ y almacena esa instancia en $db.
$db = Conexion::getInstancia();

// Aquí podrías añadir otras inicializaciones:
// - session_start();
// - Definición de rutas, etc.

// El cierre de la etiqueta PHP ha sido omitido intencionalmente
// para prevenir cualquier salida accidental de espacios o saltos de línea.