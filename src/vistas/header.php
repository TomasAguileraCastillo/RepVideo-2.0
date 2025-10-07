<!doctype html>
<html lang="es"> 
    <head>
        <meta charset="utf-8">
        
        <link rel="preconnect" href="https://cdn.jsdelivr.net">
        <link rel="preconnect" href="https://cdn.datatables.net">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Panel de administración de cursos y videos para UDOP - HEP.">
        <meta name="author" content="UDOP - HEP Team">
        
        <link rel="icon" type="image/x-icon" href="../../src/Public/img/icons/favicon.png">
        <title>Admin - UDOP - HEP</title>
        <!--css bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!--css admintle-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
        <!--Estilos Datatable bootstrap 5 -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
        <!--Estilos iconos  -->        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">        
    </head>
<style>
.brand-link:hover {
    color: #5a98db;
}
.fondo {
    background-color: #ffffe0;
}
</style>
<body>
    <body class="hold-transition sidebar-mini">
        <main>
            <div class="wrapper">
                <!-- Navbar -->
                <nav class="main-header navbar navbar-expand navbar-white navbar-light fondo">
                    <!-- Left navbar links -->
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

                    <!-- Right navbar links -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Navbar Search -->
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

                            <!-- Sidebar user panel (optional) -->
                            <div class="user-panel d-flex">
                                <div class="image">
                                    <img    src="../../src/Public/img/<?php echo htmlspecialchars($_SESSION['imagen']);?>"
                                            class="img-circle elevation-2" 
                                            alt="User Image">
                                 </div>
                                <div class="info">
                                    <a href="#" class="d-block">
                                        <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                         
                        <li class="nav-item">
                            <a class="nav-link" href="../ajax/accesoUsuario.php?op=salir" role="button" title="Cerrar Sesión">
                                <i class="bi bi-box-arrow-right"></i>
                            </a>
                        </li>

                         
                    </ul>
                </nav>
                <!-- /.navbar -->

                <!-- Main Sidebar Container(barra Lateral) -->
                <aside class="main-sidebar sidebar-menu elevation-4 fondo">
                    <!-- Brand Logo -->
                    <a href=" " class="brand-link">
                        <img src="../../src/Public/img/pino1.JPG" alt=" " class="brand-image img-circle elevation-3"
                            style="opacity: .8">
                        <span class="brand-text font-weight-dark text-justify">Admin-UDOP-HEP</span>
                    </a>

                    <!-- Sidebar -->
                    <div class="sidebar">
                        <br>
                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-speedometer2"></i>
                                        <p>
                                            Dashboard UDOP
                                             
                                            <i class="bi bi-chevron-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="dashboard.php" class="nav-link">
                                                <i class="bi bi-speedometer"></i>
                                                <p>Dashboard v1 - alpha</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-file-text-fill"></i>
                                        <p>
                                            Induccion
                                            <i class="bi bi-chevron-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                                <i class="bi bi-file-earmark-check"></i>
                                                <p>valida Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                                <i class="bi bi-card-checklist"></i>
                                                <p>Inscrip. Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-file-check-fill"></i>
                                        <p>
                                            Admin Selección
                                            <i class="bi bi-chevron-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                               <i class="bi bi-file-earmark-check"></i>
                                                <p>valida Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../../index.html" class="nav-link">
                                                <i class="bi bi-card-checklist"></i>
                                                <p>Inscrip. Inducc.</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-file-earmark-slides-fill"></i>
                                        <p>
                                            Videos-Cursos
                                            <i class="bi bi-chevron-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="mantenedorVideos.php" class="nav-link">
                                                <i class="bi bi-camera-video"></i>
                                                <p>Admin Videos - Cursos</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="mantenedorCursos.php" class="nav-link">
                                                <i class="bi bi-book"></i>
                                                <p>Admin Cursos - Video</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="Reproductor/video_player/" class="nav-link" target="_blank"
                                                rel="noreferrer noopener">
                                                <i class="bi bi-camera-reels"></i>
                                                <p>Reproductor de Video</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="bi bi-person-fill-gear"></i>
                                        <p>Admin. de Usuarios
                                            <i class="bi bi-chevron-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="usuarios.php" class="nav-link">
                                                <i class="bi bi-people"></i>
                                                <p>Usuarios</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="../widgets.html" class="nav-link">
                                        <i class="bi bi-mortarboard"></i>
                                        <p>Validar Doc.
                                            <span class="right badge badge-danger">Nuevo</span>
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="../widgets.html" class="nav-link">
                                        <i class="bi bi-chat-fill"></i>
                                        <p>Chat
                                            <span class="right badge badge-danger">Nuevo</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- /.sidebar-menu -->
                    </div>
                    <!-- /.sidebar -->
                </aside>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">