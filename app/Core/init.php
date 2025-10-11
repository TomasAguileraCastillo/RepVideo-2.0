<?php
// config/init.php

// =========================================================
// 1. CARGA DEL AUTOLOADER DE COMPOSER
// =========================================================
// Esto permite que todos los namespaces funcionen (App\Core\, App\Models\, etc.)
// Usamos el camino relativo desde 'config/' hacia 'vendor/autoload.php'
require __DIR__ . '/../vendor/autoload.php';

// =========================================================
// 2. INICIALIZACIÓN DEL SISTEMA (BASE DE DATOS)
// =========================================================

// Importamos la CLASE DE CONEXIÓN REAL usando su namespace
use App\Core\Conexion;

// Creamos una variable global para almacenar la única instancia de la conexión.
// Aunque usar globales no es la práctica más moderna, es simple y funciona.
// Más tarde, podemos inyectar esto en un Contenedor de Dependencias.
global $db;

// Al llamar a getInstancia(), tu clase Conexion (Singleton) se conecta
// a la DB UNA SOLA VEZ y almacena esa instancia en $db.
$db = Conexion::getInstancia();

// Aquí podrías añadir otras inicializaciones:
// - session_start();
// - Definición de rutas, etc.

?>