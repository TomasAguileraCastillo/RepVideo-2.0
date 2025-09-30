<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Reproductor CAMPUS Virtual - HEP</title>
    <link rel="icon" type="image/x-icon" href="../../src/Public/img/maxtechnology.ico" />
    <!--Estilos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!--Estilos Datatable bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
    <!--Estilos iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <!--Estilos iconos font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!--Estilos propios -->
    <link rel="stylesheet" href="../../src/Public/css/estilo.css" />

    <link href="https://vjs.zencdn.net/7.2/video-js.min.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.2/video.min.js"></script>
    <!--<link rel="stylesheet" href="css/video-js.css">-->
    <script src="js/video.js"></script>
    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">-->
    <link rel="stylesheet" href="css/estilos.css" />

    <script>
    window.oncontextmenu = function() {
        return false;
    };
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="mantenedor.php">
                <img src="../../src/Public/img/" width="20" height="40" class="d-inline-block align-text-top" alt="" />
            </a>
            <a class="navbar-brand" href="mantenedor.php">Administración de Archivos de Videos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav"></div>
            </div>
        </div>
    </nav>

    <header>
        <h1 class="titulo">Videos Campus Virtual - HEP</h1>
    </header>
    <main>
        <div class="contenedor">
            <video class="fm-video video-js vjs-16-9 vjs-big-play-centered" data-setup="{}" controls id="fm-video">
                <source src="../../files/<?php echo $_GET["videos"];?>" type="video/mp4">
            </video>

            <!--

            <video  class="object-fit-none" 
                    autoplay
                    class="fm-video video-js vjs-16-9 vjs-big-play-centered" 
                    data-setup="{}">
                    <source src="../../src/files/ " type="video/mp4">
            </video>
            
            <video  id="videoPlayer" 
                    class="video-js"
                    controls
                    preload="auto"
                    width="640"
                    height="264"
                    poster="https://via.placeholder.com/800x450.png?text=Video+Poster"
                    data-setup="{}" >
                    <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4" />

                    <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that
                    <a    href="https://videojs.com/html5-video-support/" 
                            target="_blank"> supports HTML5 video </a
                    >
                    </p>
            </video>
            -->

            <article>
                <h2>Recuerde Repasar los contenidos, del curso</h2>
                <p>
                    Este contenido estara disponible solo hasta la fecha de termino
                    indicada, para este curso.
                </p>
                <br />
                <p>
                    si tiene alguna duda o problemas con la plataforma de reproduccion,
                    favor contactar al equipo de UDO.
                </p>

                <!--<a class="btn btn-primary" href="../" onclick="cerrarse()">
            <i class="bi bi-arrow-return-left"></i> Volver
          </a>-->
            </article>
        </div>
    </main>

    <script>
    var reproductor = videojs("fm-video", {
        fluid: true,
    });

    function cerrarse() {
        window.close();
    }
    </script>
</body>

</html>