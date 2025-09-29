/**
 * Formatea un tiempo dado en segundos a la cadena "m:ss".
 * @param {number} timeInSeconds - El tiempo total en segundos.
 * @returns {string} El tiempo formateado (ej. "3:05").
 */
const formatTime = (timeInSeconds) => {
  if (isNaN(timeInSeconds) || timeInSeconds < 0) return "0:00";
  const totalSeconds = Math.floor(timeInSeconds);
  const minutes = Math.floor(totalSeconds / 60);
  const seconds = totalSeconds % 60;
  // Usamos padStart para asegurar dos dígitos en segundos (05, 10, etc.)
  const formattedSeconds = String(seconds).padStart(2, "0");
  return `${minutes}:${formattedSeconds}`;
};

/**
 * Clase para gestionar la lógica del reproductor de video personalizado.
 */
class MediaPlayer {
  /**
   * @param {string} containerId - El ID del contenedor principal del reproductor.
   */
  constructor(containerId) {
    // ------------------------------------
    // 1. Inicialización y Elementos del DOM
    // ------------------------------------
    this.$playerContainer = document.getElementById(containerId);

    if (!this.$playerContainer) {
      console.error(
        `Error: No se encontró el contenedor con ID: ${containerId}.`
      );
      return;
    }

    this.$video = this.$playerContainer.querySelector("#video-player");
    if (!this.$video) {
      console.error(
        `Error: No se encontró el elemento #video-player dentro de ${containerId}.`
      );
      return;
    }

    // Mapeo de elementos
    this.$playPauseBtn = this.$playerContainer.querySelector("#play-pause-btn");
    this.$playPauseIcon =
      this.$playerContainer.querySelector("#play-pause-icon");
    this.$progressBar = this.$playerContainer.querySelector("#progress-bar");
    this.$fullscreenBtn =
      this.$playerContainer.querySelector("#fullscreen-btn");
    this.$fullscreenIcon =
      this.$playerContainer.querySelector("#fullscreen-icon");
    this.$timeDisplay = this.$playerContainer.querySelector("#time-display");
    this.$durationDisplay =
      this.$playerContainer.querySelector("#duration-display");
    this.$volumeBtn = this.$playerContainer.querySelector("#volume-btn");
    this.$volumeIcon = this.$playerContainer.querySelector("#volume-icon");
    this.$volumeSlider = this.$playerContainer.querySelector("#volume-slider");
    this.$rewindBtn = this.$playerContainer.querySelector("#rewind-btn");
    this.$forwardBtn = this.$playerContainer.querySelector("#forward-btn");
    this.$videoFeedback =
      this.$playerContainer.querySelector("#video-feedback");

    // ------------------------------------
    // 2. Propiedades de Estado
    // ------------------------------------
    this.INACTIVITY_TIME = 3000;
    this.SEEK_STEP = 10;
    this.controlTimeout = null;
    this.lastVolume = 1;
    this.isUpdatingProgress = false;

    this.init();
  }

  // ----------------------------------------------------
  // ## Métodos Auxiliares
  // ----------------------------------------------------

  /** Alterna entre los íconos de Play y Pause. */
  updatePlayPauseIcon() {
    this.$playPauseIcon.className = this.$video.paused
      ? "bi bi-play-fill"
      : "bi bi-pause-fill";
    this.$playPauseBtn.setAttribute(
      "aria-label",
      this.$video.paused ? "Reproducir" : "Pausar"
    );
  }

  /** Alterna entre los íconos de volumen (mute, bajo, alto). */
  updateVolumeIcon() {
    if (this.$video.muted || this.$video.volume === 0) {
      this.$volumeIcon.className = "bi bi-volume-mute-fill";
      this.$volumeBtn.setAttribute("aria-label", "Activar sonido");
    } else if (this.$video.volume < 0.5) {
      this.$volumeIcon.className = "bi bi-volume-down-fill";
      this.$volumeBtn.setAttribute("aria-label", "Silenciar sonido");
    } else {
      this.$volumeIcon.className = "bi bi-volume-up-fill";
      this.$volumeBtn.setAttribute("aria-label", "Silenciar sonido");
    }
  }

  /**
   * Actualiza la barra de progreso (visual y tiempo) usando requestAnimationFrame
   * para optimizar el rendimiento.
   */
  updateProgressBar = () => {
    // Si el usuario está manipulando la barra de progreso, no la actualizamos automáticamente.
    if (document.activeElement === this.$progressBar) return;

    const duration = this.$video.duration || 0;
    const currentTime = this.$video.currentTime;

    const percent = (currentTime / duration) * 100;

    // Calcular el porcentaje de buffer (si hay datos disponibles)
    let bufferedPercent = 0;
    if (this.$video.buffered.length > 0) {
      const bufferedEnd = this.$video.buffered.end(
        this.$video.buffered.length - 1
      );
      bufferedPercent = (bufferedEnd / duration) * 100;
    }

    this.$progressBar.value = currentTime;
    this.$progressBar.setAttribute("aria-valuenow", Math.round(percent));

    // Actualización del fondo de la barra (progreso, buffer y vacío)
    this.$progressBar.style.background = `linear-gradient(to right, 
      #0087ff 0%, #0087ff ${percent}%, 
      rgba(255, 255, 255, 0.4) ${percent}%, 
      rgba(255, 255, 255, 0.4) ${bufferedPercent}%, 
      rgba(255, 255, 255, 0.2) ${bufferedPercent}%, 
      rgba(255, 255, 255, 0.2) 100%
    )`;

    this.$timeDisplay.textContent = formatTime(currentTime);
  };

  /** Implementación de throttling (limitación) para el evento timeupdate */
  throttledTimeUpdate = () => {
    if (!this.isUpdatingProgress) {
      this.isUpdatingProgress = true;
      window.requestAnimationFrame(() => {
        this.updateProgressBar();
        this.isUpdatingProgress = false;
      });
    }
  };

  // ----------------------------------------------------
  // ## Lógica de Controles y UX
  // ----------------------------------------------------

  /** Oculta el cursor y la capa de controles. */
  hideControls = () => {
    if (!this.$video.paused) {
      this.$playerContainer.classList.add("inactive");
    }
  };

  /** Muestra los controles y programa su auto-ocultamiento. */
  showControls = () => {
    this.$playerContainer.classList.remove("inactive");
    clearTimeout(this.controlTimeout);
    if (!this.$video.paused) {
      // Solo oculta si se está reproduciendo
      this.controlTimeout = setTimeout(this.hideControls, this.INACTIVITY_TIME);
    }
  };

  /** Muestra brevemente el feedback visual de salto. */
  applyFeedback = () => {
    this.$videoFeedback.classList.add("active");
    setTimeout(() => {
      this.$videoFeedback.classList.remove("active");
    }, 100);
  };

  /** Alterna entre los estados de reproducción y pausa. */
  togglePlayPause = () => {
    // Si está pausado o finalizado, llama a play(). De lo contrario, llama a pause().
    this.$video.paused || this.$video.ended
      ? this.$video.play()
      : this.$video.pause();
    this.showControls();
  };

  /** Activa o desactiva el modo de pantalla completa. */
  toggleFullscreen = () => {
    if (document.fullscreenElement) {
      document.exitFullscreen();
    } else {
      this.$playerContainer.requestFullscreen().catch((err) => {
        console.error(`Error al intentar pantalla completa: ${err.message}`);
      });
    }
    this.showControls();
  };

  /** Alterna el estado de silencio (mute) del video. */
  toggleMute = () => {
    if (this.$video.muted) {
      // Desmutear: restaurar al último volumen conocido (o 0.5 si lastVolume es 0)
      this.$video.muted = false;
      this.$video.volume = this.lastVolume > 0 ? this.lastVolume : 0.5;
    } else {
      // Mutear: guardar volumen y establecer mute
      this.lastVolume = this.$video.volume;
      this.$video.muted = true;
    }

    // Esto disparará 'volumechange', que actualiza el icono y el slider.
    this.showControls();
  };

  // ----------------------------------------------------
  // ## Inicialización y Event Listeners
  // ----------------------------------------------------

  /** Inicializa todos los valores y registra los listeners. */
  init() {
    // --- Valores Iniciales ---
    this.$video.volume = parseFloat(this.$volumeSlider.value);
    this.lastVolume = this.$video.volume;
    this.updateVolumeIcon();
    this.updatePlayPauseIcon();
    this.hideControls();

    // --- Eventos del Reproductor ---

    // 1. Metadata: Establece duración inicial y el máximo de la barra
    this.$video.addEventListener("loadedmetadata", () => {
      this.$progressBar.max = this.$video.duration;
      this.$durationDisplay.textContent = formatTime(this.$video.duration);
      this.$timeDisplay.textContent = formatTime(this.$video.currentTime);
      this.updateProgressBar();
    });

    // 2. Tiempo (Throttled): Actualiza la barra de progreso y el tiempo actual
    this.$video.addEventListener("timeupdate", this.throttledTimeUpdate);

    // 3. Play/Pause
    this.$video.addEventListener("play", () => {
      this.updatePlayPauseIcon();
      this.showControls();
    });
    this.$video.addEventListener("pause", () => {
      this.updatePlayPauseIcon();
      this.showControls();
      clearTimeout(this.controlTimeout); // No ocultar controles si está pausado
    });

    // 4. Volumen: Sincroniza íconos y el slider cuando el volumen cambia (mute o slider)
    this.$video.addEventListener("volumechange", () => {
      this.updateVolumeIcon();
      // Sincronizar el slider visualmente (el video es la fuente de verdad)
      this.$volumeSlider.value = this.$video.muted ? 0 : this.$video.volume;
      this.$volumeSlider.style.background = `linear-gradient(to right, #0087ff 0%, #0087ff ${
        this.$volumeSlider.value * 100
      }%, rgba(255, 255, 255, 0.4) ${
        this.$volumeSlider.value * 100
      }%, rgba(255, 255, 255, 0.2) 100%)`;
    });

    // --- Eventos de UI del Usuario ---

    // 5. Control de la Interfaz (Mouse/Inactividad)
    this.$playerContainer.addEventListener("mousemove", this.showControls);
    this.$playerContainer.addEventListener("mouseleave", this.hideControls);
    this.$playerContainer.addEventListener("mouseenter", this.showControls);

    // 6. Clicks y Doble Clicks
    this.$video.addEventListener("click", this.togglePlayPause);
    this.$video.addEventListener("dblclick", this.toggleFullscreen);

    // 7. Controles principales (Play/Pause, Fullscreen)
    this.$playPauseBtn.addEventListener("click", this.togglePlayPause);
    this.$fullscreenBtn.addEventListener("click", this.toggleFullscreen);

    // 8. Controles de salto (Skip)
    this.$rewindBtn.addEventListener("click", () => {
      this.$video.currentTime -= this.SEEK_STEP;
      this.applyFeedback();
      this.showControls();
    });
    this.$forwardBtn.addEventListener("click", () => {
      this.$video.currentTime += this.SEEK_STEP;
      this.applyFeedback();
      this.showControls();
    });

    // 9. Control de la barra de progreso (Seek)
    this.$progressBar.addEventListener("input", () => {
      this.$video.currentTime = this.$progressBar.value;
      this.updateProgressBar(); // Actualiza la barra inmediatamente al arrastrar
      this.showControls();
    });

    // 10. Control de Volumen (Slider)
    this.$volumeSlider.addEventListener("input", () => {
      const newVolume = parseFloat(this.$volumeSlider.value);
      this.$video.volume = newVolume;

      // Actualizar estado mute
      if (newVolume > 0 && this.$video.muted) {
        this.$video.muted = false; // Desmutear si el usuario mueve el slider a > 0
      } else if (newVolume === 0 && !this.$video.muted) {
        this.$video.muted = true; // Mutear si el usuario arrastra a 0
      }
      this.showControls();
    });

    // 11. Botón de silencio
    this.$volumeBtn.addEventListener("click", this.toggleMute);

    // 12. Fullscreen (cambio de estado nativo)
    document.addEventListener("fullscreenchange", () => {
      const isFullscreen = !!document.fullscreenElement;
      this.$fullscreenIcon.className = isFullscreen
        ? "bi bi-fullscreen-exit"
        : "bi bi-fullscreen";
      this.$fullscreenBtn.setAttribute(
        "aria-label",
        isFullscreen
          ? "Salir de pantalla completa"
          : "Entrar a pantalla completa"
      );
      this.showControls();
    });

    // 13. Atajos de teclado
    document.addEventListener("keydown", this.handleKeydown);
  }

  /** Maneja los atajos de teclado para controlar el reproductor. */
  handleKeydown = (e) => {
    // Evitar que los atajos interfieran con inputs o sliders
    if (
      document.activeElement.tagName === "INPUT" ||
      document.activeElement.tagName === "TEXTAREA"
    ) {
      return;
    }

    this.showControls();

    switch (e.key) {
      case " ":
        e.preventDefault();
        this.togglePlayPause();
        break;
      case "f":
      case "F":
        this.toggleFullscreen();
        break;
      case "m":
      case "M":
        this.toggleMute();
        break;
      case "ArrowRight":
        e.preventDefault();
        this.$video.currentTime += this.SEEK_STEP;
        this.applyFeedback();
        break;
      case "ArrowLeft":
        e.preventDefault();
        this.$video.currentTime -= this.SEEK_STEP;
        this.applyFeedback();
        break;
    }
  };
} // Fin de la clase MediaPlayer

// Inicia el reproductor al cargar el DOM
document.addEventListener("DOMContentLoaded", () => {
  new MediaPlayer("player-container");
});
