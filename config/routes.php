<?php
// config/routes.php

// Define un array que mapea la ruta (URL) a un controlador y método
return [
    // RUTA BÁSICA (Página de inicio)
    '/' => [
        'controller' => 'HomeController',
        'method' => 'index'
    ],
    // RUTA PARA VER UN PERFIL DE USUARIO ESPECÍFICO
    // {id} indica un parámetro dinámico que se capturará
    '/user/profile/{id}' => [
        'controller' => 'UserController',
        'method' => 'showProfile'
    ],
    // RUTA PARA UN FORMULARIO DE INICIO DE SESIÓN
    '/auth/login' => [
        'controller' => 'AuthController',
        'method' => 'showLogin'
    ],
    // RUTA PARA MANEJAR UN ENVÍO POST (Por ejemplo, login)
    'POST /auth/login' => [
        'controller' => 'AuthController',
        'method' => 'authenticate'
    ],
    // RUTA SIMPLE DE INFORMACIÓN
    '/products/list' => [
        'controller' => 'ProductController',
        'method' => 'listAll'
    ],
    // RUTA DE ERROR 404
    '404' => [
        'controller' => 'ErrorController',
        'method' => 'notFound'
    ]
];