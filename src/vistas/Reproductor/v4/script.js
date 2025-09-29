 const video = document.getElementById('modern-video');
const playPauseBtn = document.getElementById('play-pause-btn');
const playPauseIcon = playPauseBtn.querySelector('i');
const rewindBtn = document.getElementById('rewind-btn');
const forwardBtn = document.getElementById('forward-btn');
const progressBar = document.getElementById('progress-bar');
const muteBtn = document.getElementById('mute-btn');
const muteIcon = muteBtn.querySelector('i');
const volumeSlider = document.getElementById('volume-slider');
const fullscreenBtn = document.getElementById('fullscreen-btn');
const videoContainer = document.querySelector('.video-container');

// Funcionalidad de reproducir y pausar
playPauseBtn.addEventListener('click', () => {
    if (video.paused || video.ended) {
        video.play();
        playPauseIcon.classList.remove('bi-play-fill');
        playPauseIcon.classList.add('bi-pause-fill');
    } else {
        video.pause();
        playPauseIcon.classList.remove('bi-pause-fill');
        playPauseIcon.classList.add('bi-play-fill');
    }
});

// Funcionalidad de retroceder 10 segundos
rewindBtn.addEventListener('click', () => {
    video.currentTime -= 10;
});

// Funcionalidad de avanzar 10 segundos
forwardBtn.addEventListener('click', () => {
    video.currentTime += 10;
});

// Actualizar la barra de progreso
video.addEventListener('timeupdate', () => {
    progressBar.value = (video.currentTime / video.duration) * 100;
});

// Controlar el video al mover la barra de progreso
progressBar.addEventListener('input', () => {
    video.currentTime = (progressBar.value / 100) * video.duration;
});

// Funcionalidad de silenciar
muteBtn.addEventListener('click', () => {
    video.muted = !video.muted;
    muteIcon.classList.toggle('bi-volume-up-fill', !video.muted);
    muteIcon.classList.toggle('bi-volume-mute-fill', video.muted);
    volumeSlider.value = video.muted ? 0 : video.volume * 100;
});

// Controlar el volumen
volumeSlider.addEventListener('input', () => {
    video.volume = volumeSlider.value / 100;
    muteIcon.classList.toggle('bi-volume-up-fill', video.volume > 0);
    muteIcon.classList.toggle('bi-volume-mute-fill', video.volume === 0);
});

// Funcionalidad de pantalla completa
fullscreenBtn.addEventListener('click', () => {
    if (document.fullscreenElement) {
        document.exitFullscreen();
    } else {
        videoContainer.requestFullscreen();
    }
});

// Detectar el final del video para resetear el icono
video.addEventListener('ended', () => {
    playPauseIcon.classList.remove('bi-pause-fill');
    playPauseIcon.classList.add('bi-play-fill');
});
