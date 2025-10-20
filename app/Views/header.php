<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdn.datatables.net">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Panel de administración de cursos y videos para UDOP - HEP.">
    <meta name="author" content="UDOP - HEP Team">

    <link rel="icon" type="image/x-icon" href="../../public/assets/img/icons/favicon.png">
    <title>Admin - UDOP - HEP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<style>
/*/* Paleta con Tonos de Azul y Verde (Sin Blanco, Rojo, Gris, Morado, Beige) */

/* Azul Marino Oscuro (Acciones principales, Confianza) */
.btn-health-marine-primary {
    color: #fff;
    background-color: #003366;
    /* Azul Marino Profundo */
    border-color: #003366;
}

.btn-health-marine-primary:hover {

    background-color: #001a33;
    border-color: #000d1a;
    color: #fff;
}

/* Azul Cian (Advertencia / Bloquear. Notorio y asociado a la limpieza) */
.btn-health-cyan-alert {
    color: #fff;
    /*color: #003366;*/
    /* Texto en color principal para buen contraste */
    background-color: #4dd0e1;
    /* Cian Brillante */
    border-color: #4dd0e1;
}

.btn-health-cyan-alert:hover {
    color: #fff;
    background-color: #26c6da;
    border-color: #00bcd4;
}



/* Verde Azulado (Éxito/Confirmación, Higiene) */
.btn-health-teal-success {
    color: #fff;
    background-color: #008080;
    /* Verde Azulado (Teal) */
    border-color: #008080;
}

.btn-health-teal-success:hover {
    color: #fff;
    background-color: #005f5f;
    border-color: #004c4c;
}

/* Verde Oscuro (Secundario/Eliminar. Estabilidad, usado en cirugía.) */
.btn-health-deep-secondary {
    color: #fff;
    background-color: #1b5e20;
    /* Verde Bosque Oscuro */
    border-color: #1b5e20;
}

.btn-health-deep-secondary:hover {
    color: #fff;
    background-color: #003300;
    border-color: #165316ff;
}
</style>
<style>
/* -------------------------------------------------------------------------- */
/* INICIO: ESTILOS MODERNOS Y OPTIMIZADOS PARA SALUD (AdminLTE Overrides) */
/* -------------------------------------------------------------------------- */

:root {
    --health-primary: #004c99;
    /* Azul profesional profundo (Header, Active Links) */
    --health-secondary: #28a745;
    /* Verde (Éxito, badges) */
    --health-light: #f4f6f9;
    /* Gris muy claro/casi blanco para el cuerpo */
    --sidebar-bg: #ffffff;
    /* Fondo del Sidebar */
}

/* 1. Navbar: Fondo azul profundo, borde verde */
.bg-health-primary {
    background-color: var(--health-primary) !important;
    color: #ffffff !important;
}

.main-header {
    border-bottom: 3px solid var(--health-secondary);
    /* Borde verde para modernizar */
}

.navbar-dark .nav-link,
.navbar-dark .navbar-brand {
    color: #ffffff !important;
    /* Aseguramos el color del texto */
}

.navbar-dark .nav-link:hover {
    color: #cccccc !important;
}

/* 2. Sidebar: Fondo blanco/claro, texto oscuro */
.main-sidebar {
    background-color: var(--sidebar-bg) !important;
}

.sidebar-light .nav-link {
    color: #343a40 !important;
    /* Texto oscuro para sidebar claro */
    transition: background-color 0.3s;
}

/* Enlaces del menú (hover y active) */
.sidebar-light .nav-link.active,
.sidebar-light .nav-link:hover {
    background-color: #e9ecef !important;
    /* Gris suave al pasar el mouse */
    color: var(--health-primary) !important;
    /* Azul primario en hover/active */
}

/* Enlaces secundarios (submenús) */
.sidebar-light .nav-treeview>.nav-item>.nav-link {
    color: #6c757d !important;
    /* Texto más suave para submenús */
}

.sidebar-light .nav-treeview>.nav-item>.nav-link:hover {
    color: var(--health-primary) !important;
}

/* Logo de la marca */
.sidebar-light .brand-link {
    border-bottom: 1px solid #ddd;
}

.sidebar-light .brand-text {
    color: var(--health-primary);
    /* Texto de marca en azul */
    font-weight: 700 !important;
}

/* Ajuste para el fondo general del cuerpo (AdminLTE wrapper) */
.content-wrapper {
    background-color: var(--health-light) !important;
}

/* -------------------------------------------------------------------------- */
/* FIN: ESTILOS MODERNOS Y OPTIMIZADOS PARA SALUD */
/* -------------------------------------------------------------------------- */
</style>

<body>

    <body class="hold-transition sidebar-mini">
        <main>
            <div class="wrapper">
                <nav class="main-header navbar navbar-expand navbar-dark bg-health-primary">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                                <i class="bi bi-list"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="" class="nav-link">Inicio</a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="#" class="nav-link">Contacto</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                                <i class="bi bi-search"></i>
                            </a>
                            <div class="navbar-search-block">
                                <form class="form-inline">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-navbar" type="search"
                                            placeholder="Search" aria-label="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-navbar" type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                                <i class="bi bi-x"></i>
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </a>
                        </li>
                        <li>

                            <div class="user-panel d-flex">
                                <div class="image">
                                </div>
                                <div class="info">
                                    <a href="#" class="d-block">
                                        <?php // echo htmlspecialchars($_SESSION['nombre']); ?>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../ajax/accesoUsuario.php?op=salir" role="button"
                                title="Cerrar Sesión">
                                <i class="bi bi-box-arrow-right"></i>
                            </a>
                        </li>


                    </ul>
                </nav>
                <aside class="main-sidebar sidebar-light elevation-4">
                    <a href=" " class="brand-link">
                        <img src="../../public/assets/img/pino1.JPG" alt=" " class="brand-image img-circle elevation-3"
                            style="opacity: .8">
                        <span class="brand-text font-weight-dark text-justify">Admin-UDOP-HEP</span>
                    </a>

                    <div class="sidebar">
                        <br>
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-speedometer2"></i>
                                        <p>
                                            Dashboard UDOP

                                            <i class="bi bi-chevron-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="dashboard.php" class="nav-link">
                                                <i class="bi bi-speedometer nav-icon"></i>
                                                <p>Dashboard v1 - alpha</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-file-text-fill nav-icon"></i>
                                        <p>
                                            Induccion
                                            <i class="bi bi-chevron-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                                <i class="bi bi-file-earmark-check nav-icon"></i>
                                                <p>valida Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                                <i class="bi bi-card-checklist nav-icon"></i>
                                                <p>Inscrip. Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-file-check-fill nav-icon"></i>
                                        <p>
                                            Admin Selección
                                            <i class="bi bi-chevron-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                                <i class="bi bi-file-earmark-check nav-icon"></i>
                                                <p>valida Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                                <i class="bi bi-card-checklist nav-icon"></i>
                                                <p>Inscrip. Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-file-earmark-slides-fill nav-icon"></i>
                                        <p>
                                            Videos-Cursos
                                            <i class="bi bi-chevron-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="mantenedorVideos.php" class="nav-link">
                                                <i class="bi bi-camera-video nav-icon"></i>
                                                <p>Admin Videos - Cursos</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="mantenedorCursos.php" class="nav-link">
                                                <i class="bi bi-book nav-icon"></i>
                                                <p>Admin Cursos - Video</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="Reproductor/video_player/" class="nav-link" target="_blank"
                                                rel="noreferrer noopener">
                                                <i class="bi bi-camera-reels nav-icon"></i>
                                                <p>Reproductor de Video</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-person-fill-gear nav-icon"></i>
                                        <p>Admin. de Usuarios
                                            <i class="bi bi-chevron-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="gestionUsuarioB.php" class="nav-link">
                                                <i class="bi bi-people nav-icon"></i>
                                                <p>Usuarios</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-file-earmark-ruled-fill"></i>
                                        <p>Doctos de Solicitud
                                            <i class="bi bi-chevron-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="gestionUsuarioB.php" class="nav-link">
                                                <i class="bi bi-journal-text"></i>
                                                <p>gestion de solicitudes </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="gestionUsuarioB.php" class="nav-link">
                                                <i class="bi bi-tablet"></i>
                                                <p>Solicitud de Tablet</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="gestionUsuarioB.php" class="nav-link">
                                                <i class="bi bi-card-checklist"></i>
                                                <p>Solicitud de Equip.</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="../widgets.html" class="nav-link">
                                        <i class="bi bi-mortarboard nav-icon"></i>
                                        <p>Validar Doc.
                                            <span class="right badge badge-success"
                                                style="background-color: var(--health-primary) !important;">Nuevo</span>
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="../widgets.html" class="nav-link">
                                        <i class="bi bi-chat-fill nav-icon"></i>
                                        <p>Chat
                                            <span class="right badge badge-success"
                                                style="background-color: var(--health-primary) !important;">Nuevo</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <div class="content-wrapper">