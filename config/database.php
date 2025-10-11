<?php
// config/database.php

return [
    // Parámetros de la Base de Datos
    'host' => 'localhost',
    'dbname' => 'db_videos',
    'user' => 'root',
    'pass' => '',  // ¡Idealmente cargado desde .env!
    'port' => '3306',
    // Configuración general de la app (puedes mover esto a config/app.php)
    'app_nombre' => 'Mantenedor-Videos',
    'encode' => 'utf8',
];