<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reproductor Moderno con Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-dark text-light">




<div class="container py-5">
    <div class="row">
        <div class="col-md-9">
            <div class="video-container rounded-3 overflow-hidden shadow-lg position-relative">
                <video id="modern-video" class="w-100" src="../../../files/videos_cursos/PROA_2025_Mod_2.2._Antimicrobiano_Según_Sitio_De_Infección1A.mp4" poster="ruta/a/tu/portada.jpg"></video>
                <div class="video-controls-container d-flex flex-column justify-content-end p-4">
                    <div class="progress-bar-container w-100 mb-3">
                        <input type="range" id="progress-bar" class="form-range" value="0" min="0" max="100" step="0.1">
                    </div>
                    <div class="video-controls d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-2">
                            <!-- Botón de retroceder 10 segundos -->
                            <button id="rewind-btn" class="btn btn-outline-light rounded-circle control-btn">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                            <button id="play-pause-btn" class="btn btn-outline-light rounded-circle control-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <!-- Botón de avanzar 10 segundos -->
                            <button id="forward-btn" class="btn btn-outline-light rounded-circle control-btn">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                            <button id="mute-btn" class="btn btn-outline-light rounded-circle control-btn">
                                <i class="bi bi-volume-up-fill"></i>
                            </button>
                            <input type="range" id="volume-slider" class="form-range" value="100" min="0" max="100" step="1">
                        </div>
                        <button id="fullscreen-btn" class="btn btn-outline-light rounded-circle control-btn">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
