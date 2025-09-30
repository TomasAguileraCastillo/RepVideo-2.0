<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Video Player CAMPVS-HEP</title>

    <head>
        <link rel="icon" type="img/png" sizes="32x32" href="img/pino1.png" />

        <link rel="shortcut icon" type="image/x-icon" href="img/pino.ico" />

        <link rel="apple-touch-icon" sizes="180x180" href="img/pino1.png" />

        <link rel="manifest" href="/site.webmanifest" />

        <title>Título de tu Sitio</title>
    </head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="style.css" />

    <script>
    window.oncontextmenu = function() {
        return false;
    };
    </script>
</head>

<body class="bg-dark text-light">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">
                    <img src="img/pino.jpg" alt="Logotipo de CAMVS HEP" height="30"
                        class="d-inline-block align-text-top me-2" />
                    CAMPVS HEP Video Player
                </a>
            </div>
        </nav>
    </header>

    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-md-12">
                <div class="player-container" id="player-container" aria-label="Reproductor de video personalizado">
                    <div id="watermark">CAMPVS - HEP &copy; 2025</div>

                    <div id="video-feedback" class="video-feedback"></div>

                    <div class="ratio ratio-16x9">
                        <video id="video-player" class="video" poster="imagen_de_tu_video.jpg" tabindex="0"
                            preload="auto">
                            <source src="../../../files/<?php echo $_GET["videos"];?>" type="video/mp4" />
                            Tu navegador no soporta el tag de video.
                        </video>
                    </div>

                    <div class="controls-overlay" role="toolbar" aria-label="Controles de reproducción">
                        <div class="main-controls-top">
                            <button id="rewind-btn" class="control-btn big-icon" aria-label="Retroceder 10 segundos">
                                <i class="bi bi-chevron-double-left"></i>
                            </button>

                            <button id="play-pause-btn" class="control-btn big-icon" aria-label="Alternar reproducción"
                                aria-pressed="false">
                                <i id="play-pause-icon" class="bi bi-play-fill"></i>
                            </button>

                            <button id="forward-btn" class="control-btn big-icon" aria-label="Avanzar 10 segundos">
                                <i class="bi bi-chevron-double-right"></i>
                            </button>
                        </div>

                        <div class="controls-container">
                            <time id="time-display" class="text-white small" aria-label="Tiempo actual">0:00</time>

                            <div class="progress-bar-container">
                                <input type="range" id="progress-bar" class="progress-bar" min="0" max="0" value="0"
                                    step="0.1" aria-label="Barra de reproducción del video" aria-valuemin="0"
                                    aria-valuemax="100" aria-valuenow="0" />
                            </div>

                            <time id="duration-display" class="text-white small" aria-label="Duración total">0:00</time>

                            <div class="volume-group">
                                <button id="volume-btn" class="control-btn" aria-label="Alternar silencio del sonido">
                                    <i id="volume-icon" class="bi bi-volume-up-fill"></i>
                                </button>
                                <input type="range" id="volume-slider" min="0" max="1" step="0.1" value="1"
                                    aria-label="Control de volumen" />
                            </div>

                            <button id="fullscreen-btn" class="control-btn" aria-label="Alternar pantalla completa">
                                <i id="fullscreen-icon" class="bi bi-fullscreen"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="p-3 bg-dark h-100">
                    <h4>Recuerde Repasar los contenidos, del Curso</h4>
                    <p>
                        Este contenido estara disponible solo hasta la fecha de termino
                        indicada, para este curso, si tiene alguna duda o problemas con la
                        plataforma de reproduccion, favor contactar al equipo de UDPO HEP.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white-50 mt-5 border-top border-secondary py-3">
        <div class="container-fluid text-center small">
            <p class="mb-1">
                &copy; <span id="current-year">2025</span> CAMPVS HEP. derechos
                reservados.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>