<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reproductor Tipo HBO Max</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Enlace a tu archivo CSS personalizado -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-dark text-light">

    <div class="container-fluid my-5">
        <div class="row">
            <!-- Columna para el reproductor de video (3/4 de la pantalla) -->
            <div class="col-md-9">
                <div class="player-container">
                    <div class="ratio ratio-16x9">
                        <video id="video-player" class="video" poster="imagen_de_tu_video.jpg">
                            <!-- Sustituye el src por la ruta de tu video -->
                            <source src="../../../files/videos_cursos/PROA_2025_Mod_2.2._Antimicrobiano_Según_Sitio_De_Infección1A.mp4" type="video/mp4">
                            Tu navegador no soporta el tag de video.
                        </video>
                    </div>

                    <!-- Controles flotantes, visibles al pasar el ratón -->
                    <div class="controls-overlay">
                        <div class="controls-container">
                            <!-- Botón de reproducir/pausar -->
                            <button id="play-pause-btn" class="control-btn"><i class="fas fa-play"></i></button>
                            
                            <!-- Barra de progreso personalizada -->
                            <div class="progress-bar-container">
                                <input type="range" id="progress-bar" class="progress-bar" min="0" max="100" value="0" step="0.1">
                            </div>
                            
                            <!-- Botón de pantalla completa -->
                            <button id="fullscreen-btn" class="control-btn"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna para el contenido relacionado (1/4 de la pantalla) -->
            <div class="col-md-3">
                <div class="p-3 bg-light h-100">
                    <h4>Contenido Relacionado</h4>
                    <p>Aquí puedes añadir la descripción del video, episodios sugeridos o comentarios.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Enlace a tu archivo JavaScript personalizado -->
    <script src="scripts.js"></script>
</body>
</html>
