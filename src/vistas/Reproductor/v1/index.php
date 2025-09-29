<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">


<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="video-container mb-4">
                <video id="videoPlayer" poster="https://via.placeholder.com/800x450.png?text=Video+Poster">
                    <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="custom-controls">
                    <button class="btn btn-light btn-sm" id="playPauseBtn"><i class="bi bi-play-fill"></i></button>
                    <input type="range" class="form-range" id="progressBar" min="0" max="100" step="1" value="0">
                    <button class="btn btn-light btn-sm" id="muteBtn"><i class="bi bi-volume-up-fill"></i></button>
                    <button class="btn btn-light btn-sm" id="fullscreenBtn"><i class="bi bi-fullscreen"></i></button>
                </div>
            </div>
            <h2 class="mb-3">Video Title</h2>
            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam euismod, nisi vel
                consectetur interdum, nisl nunc egestas nunc, vitae tincidunt nisl nunc euismod nunc.</p>
        </div>
        <div class="col-lg-4">
            <h3 class="mb-3">Playlist</h3>
            <ul class="list-group">
                <li class="list-group-item playlist-item active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Video 1</h5>
                        <small>3:45</small>
                    </div>
                    <p class="mb-1">Short description of video 1.</p>
                </li>
                <li class="list-group-item playlist-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Video 2</h5>
                        <small>2:30</small>
                    </div>
                    <p class="mb-1">Short description of video 2.</p>
                </li>
                <li class="list-group-item playlist-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Video 3</h5>
                        <small>4:10</small>
                    </div>
                    <p class="mb-1">Short description of video 3.</p>
                </li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const video = document.getElementById('videoPlayer');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const progressBar = document.getElementById('progressBar');
        const muteBtn = document.getElementById('muteBtn');
        const fullscreenBtn = document.getElementById('fullscreenBtn');

        playPauseBtn.addEventListener('click', () => {
            if (video.paused) {
                video.play();
                playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
            } else {
                video.pause();
                playPauseBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
            }
        });

        video.addEventListener('timeupdate', () => {
            const progress = (video.currentTime / video.duration) * 100;
            progressBar.value = progress;
        });

        progressBar.addEventListener('input', () => {
            const time = (progressBar.value / 100) * video.duration;
            video.currentTime = time;
        });

        muteBtn.addEventListener('click', () => {
            video.muted = !video.muted;
            muteBtn.innerHTML = video.muted ? '<i class="bi bi-volume-mute-fill"></i>' : '<i class="bi bi-volume-up-fill"></i>';
        });

        fullscreenBtn.addEventListener('click', () => {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            } else if (video.mozRequestFullScreen) {
                video.mozRequestFullScreen();
            } else if (video.webkitRequestFullscreen) {
                video.webkitRequestFullscreen();
            } else if (video.msRequestFullscreen) {
                video.msRequestFullscreen();
            }
        });
</script>











        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
