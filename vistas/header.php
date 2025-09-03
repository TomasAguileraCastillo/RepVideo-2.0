<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../../public/img/icons/favicon.png">
    <title>Admin - UDOP - HEP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--Estilos Datatable bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <!--Estilos iconos font awesome 

	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--css admintle-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  </head>

  <style>
    .brand-link:hover {
  color: #5a98db;
}




    .fondo{
     background-color:#ffffe0 ; 
     
    }
  </style>

  <body>
  <body class="hold-transition sidebar-mini">
  <main>
  <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light fondo" >
              <!-- Left navbar links -->
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a  class="nav-link" data-widget="pushmenu" 
                      href="#" role="button">
                      <i class="fas fa-bars"></i>
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
                    <i class="fas fa-search"></i>
                  </a>
                  <div class="navbar-search-block">
                    <form class="form-inline">
                      <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                          <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                          </button>
                          <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                            <i class="fas fa-times"></i>
                          </button>
                         
                        </div>
                      </div>
                    </form>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                  </a>
                </li>
                <li>

                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel d-flex">
                      <div class="image">
                        <img  src="../public/img/avatar.jpg" 
                              class="img-circle elevation-2" alt="User Image">
                      </div>
                      <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                      </div>
                    </div>
                </li>
  


                <li class="nav-item">
                  <a class="nav-link" data-widget="" href="#" role="button">
                    <i class="fa-solid fa-right-from-bracket"></i>
                  </a>
                </li>
              </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container(barra Lateral) -->
            <aside class="main-sidebar sidebar-menu elevation-4 fondo"  >
              <!-- Brand Logo -->
              <a href=" " class="brand-link">
                <img src="../public/img/pino1.JPG" alt=" " class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-dark text-justify">Admin-UDOP-HEP</span>
              </a>

              <!-- Sidebar -->
              <div class="sidebar">
                <br>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="fa-solid fa-gauge"></i>
                        <p>
                          Dashboard UDOP
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../../index.html" class="nav-link">
                            <i class="fa-solid fa-chart-line"></i>
                            <p>Dashboard v1</p>
                          </a>
                        </li>                      
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="fa-solid fa-book-open-reader"></i>
                        <p>
                          Induccion 
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../../index.html" class="nav-link">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <p>valida Inducc.</p>
                          </a>
                        </li>                      
                      </ul>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../../index.html" class="nav-link">
                            <i class="fa-solid fa-file-signature"></i>
                            <p>Inscrip. Inducc.</p>
                          </a>
                        </li>                      
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="fa-solid fa-file-circle-check"></i>
                        <p>
                          Admin Selección 
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../../index.html" class="nav-link">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <p>valida Inducc.</p>
                          </a>
                        </li>                      
                      </ul>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../../index.html" class="nav-link">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <p>Inscrip. Inducc.</p>
                          </a>
                        </li>                      
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="fa-solid fa-file-video"></i>
                        <p>
                          Videos-Cursos
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../../index.html" class="nav-link">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <p>Agrega Curso</p>
                          </a>
                        </li>                      
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="fa-solid fa-file-video"></i>
                        <p>
                          Administracion de Usuarios
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../../index.html" class="nav-link">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <p>Agrega Usuario</p>
                          </a>
                        </li>                      
                      </ul>
                    </li>
                   
                    <li class="nav-item">
                      <a href="../widgets.html" class="nav-link">
                        <i class="fa-solid fa-file-circle-exclamation"></i>
                        <p>Validar Doc.
                          <span class="right badge badge-danger">Nuevo</span>
                        </p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="../widgets.html" class="nav-link">
                        <i class="fa-solid fa-comments"></i>
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