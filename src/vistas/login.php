<?php
// vistas/login.php

// Incluimos nuestro archivo de inicialización.
// La ruta es ../config/init.php
require __DIR__ . '/../config/init.php';

// A partir de aquí, la variable $db está disponible y lista para ser usada.
// ... (El resto del código de login.php) ...

// Ejemplo: Si necesitaras usar tu Modelo aquí:
// $usuarioDAO = new App\Models\UsuarioDAO($db); 

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../src/Public/img/icons/favicon.png">
    <title>Acceso UDOP - HEP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="../Public/css/stylelogin.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row g-2 align-items-center vh-100">

            <div class="col-md-6 animate__animated animate__fadeInLeft">
                <div class="text-center">
                    <div class="img-fluid">
                        <img src="../../src/Public/img/imglog1.JPG" width="60%" height="60%"
                            alt="Ilustración de Bienvenida">
                    </div>
                    <h1>Unos clics más para entrar a tu cuenta</h1>
                    <h4>Gestiona todos tus trabajos UDOP desde aquí</h4>
                </div>
            </div>

            <div class="col-md-6 animate__animated animate__fadeInRight border-start">
                <div class="text-center">
                    <h1 class="text-dark">Bienvenido a Sistema UDOP</h1>
                    <br><br><br>
                    <div class="row justify-content-around align-items-center">
                        <div class="col-auto">

                            <form class="g-3 needs-validation" method="post" id="frmAcceso">

                                <div class="col-md">
                                    <div class="input-group p-2">
                                        <span class="input-group-text">
                                            <i class="bi bi-person-square"></i>
                                        </span>
                                        <div class="form-floating flex-grow-1"> <input type="text" class="form-control"
                                                id="loginacc" name="login" placeholder="Usuario" autocomplete="off"
                                                required>
                                            <label for="loginacc">Usuario</label>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="col-md">
                                    <div class="input-group p-2">
                                        <span class="input-group-text">
                                            <i class="bi bi-key-fill"></i>
                                        </span>
                                        <div class="form-floating flex-grow-1"> <input type="password"
                                                class="form-control" id="claveacc" name="password"
                                                placeholder="Contraseña" autocomplete="off" required>
                                            <label for="claveacc">Contraseña</label>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div>
                                    <input type="submit" class="btn btn-primary" value="Acceder" id="acceder"
                                        name="acceder">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"
        integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" src="scripts/login.js"></script>

</body>

</html>