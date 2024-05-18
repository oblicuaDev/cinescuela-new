let isFullScreen = false;
let videoPlaying = false;
let videoEnd = false;
let idContent;
let loadingVideo = false;
let timeBuffer = 0;
let recommends = [];
let prevUrl = null;
let videoData;
let previousUrl = null;
let currentUrl = null;
let duration = document.getElementById("duration");
let fullscreenButton = document.getElementById("fullscreenButton");
let fullscreenIcons;
let playButton = document.getElementById("playButton");
let playbackAnimation = document.getElementById("playbackAnimation");
let progressBar = document.getElementById("progress-bar");
let seek = document.getElementById("seek");
let seekTooltip = document.getElementById("seek-tooltip");
let timeElapsed = document.getElementById("time-elapsed");
let videoContainer;
let videoControls = document.getElementById("video-controls");
let volume = document.getElementById("volume");
let volumeButton = document.getElementById("volumeButton");
let volumeHigh = document.getElementById("volume-high");
let volumeLow = document.getElementById("volume-low");
let volumeMute = document.getElementById("volume-mute");
let playbackIcons;

function initializeVideo() {
  const videoDuration = Math.round(videoEl.duration);
  seek.setAttribute("max", videoDuration);
  progressBar.setAttribute("max", videoDuration);
  const time = formatTime(videoDuration);
  duration.innerText = `${time.minutes}:${time.seconds}`;
  duration.setAttribute("datetime", `${time.minutes}m ${time.seconds}s`);
}

if (document.querySelector(".videos")) {
  // Obtener el elemento del video
  const videoEl = document.querySelector("#videoEl");

  // Función para alternar la reproducción del video
  function togglePlay() {
    if (videoEl.paused) {
      videoEl.play();
    } else {
      videoEl.pause();
    }
  }

  function keyEvent(event) {
    const key = event.key;
    switch (key) {
      case " ":
        togglePlay();
        if (videoEl.paused) {
          showControls();
        } else {
          setTimeout(() => {
            hideControls();
          }, 2000);
        }
        break;
      case "k":
        togglePlay();
        if (videoEl.paused) {
          showControls();
        } else {
          setTimeout(() => {
            hideControls();
          }, 2000);
        }
        break;
      case "m":
        toggleMute();
        break;
      case "f":
        toggleFullScreen();
        break;
    }
  }

  function updatePlayButton() {
    if (videoEl) {
      if (videoEl.paused) {
        playButton.setAttribute("data-title", "Play (k)");
      } else {
        playButton.setAttribute("data-title", "Pause (k)");
      }
    }
  }

  function onResize(event) {
    innerWidth = event.target.innerWidth;
  }

  function updateTimeElapsed() {
    const time = formatTime(Math.round(videoEl.currentTime));
    timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
    timeElapsed.setAttribute("datetime", `${time.minutes}m ${time.seconds}s`);
    getBufferTime();
  }

  function updateProgress() {
    seek.value = Math.floor(videoEl.currentTime);
    progressBar.value = Math.floor(videoEl.currentTime);
    if (videoEl.currentTime === videoEl.duration) {
      videoEnd = true;
    }
    getBufferTime();
  }

  function updateSeekTooltip(event) {
    const skipTo = Math.round(
      (event.offsetX / event.target.clientWidth) *
        parseInt(seek.getAttribute("max"), 10)
    );
    seek.setAttribute("data-seek", skipTo);
    const t = formatTime(skipTo);
    seekTooltip.textContent = `${t.minutes}:${t.seconds}`;
    const rect = videoEl.getBoundingClientRect();
    seekTooltip.style.left = `${event.pageX - rect.left}px`;
    getBufferTime();
  }

  function skipAhead(event) {
    const skipTo = event.target.dataset.seek
      ? event.target.dataset.seek
      : event.target.value;
    videoEl.currentTime = skipTo;
    progressBar.value = skipTo;
    seek.value = skipTo;
  }

  function updateVolume() {
    if (videoEl.muted) {
      videoEl.muted = false;
    }
    videoEl.volume = volume.value;
  }

  function updateVolumeIcon() {
    volumeIcons.forEach((icon) => {
      icon.classList.add("hidden");
    });
    volumeButton.setAttribute("data-title", "Mute (m)");
    if (videoEl.muted || videoEl.volume === 0) {
      volumeMute.classList.remove("hidden");
      volumeButton.setAttribute("data-title", "Unmute (m)");
    } else if (videoEl.volume > 0 && videoEl.volume <= 0.5) {
      volumeLow.classList.remove("hidden");
    } else {
      volumeHigh.classList.remove("hidden");
    }
  }

  function toggleMute() {
    videoEl.muted = !videoEl.muted;
    if (videoEl.muted) {
      volume.setAttribute("data-volume", volume.value);
      volume.value = 0;
    } else {
      volume.value = volume.dataset.volume;
    }
  }

  function toggleFullScreen() {
    if (document.fullscreenElement) {
      document.exitFullscreen();
    } else {
      const doc = document.documentElement;
      doc.webkitRequestFullscreen();
    }
  }

  function updateFullscreenButton() {
    if (document.fullscreenElement) {
      fullscreenButton.setAttribute("data-title", "Exit full screen (f)");
      isFullScreen = !isFullScreen;
    } else {
      fullscreenButton.setAttribute("data-title", "Full screen (f)");
      isFullScreen = !isFullScreen;
    }
  }

  function hideControls() {
    if (videoEl.paused) {
      return;
    }
    videoControls.classList.add("hidden");
  }

  function showControls() {
    videoControls.classList.remove("hidden");
  }

  function createObjectURL(object) {
    return window.URL
      ? window.URL.createObjectURL(object)
      : window.webkitURL.createObjectURL(object);
  }

  function set_time() {}

  async function display(videoStream) {
    const video = document.getElementById("_video");
    const blob = await fetch(videoStream).then((r) => r.blob());
    const videoUrl = createObjectURL(blob);
    video.src = videoUrl;
  }

  function playingVideo() {
    loadingVideo = false;
    getBufferTime();
  }

  function waitingVideo() {
    loadingVideo = true;
    getBufferTime();
  }

  function getBufferTime() {
    let buffered = videoEl.buffered;
    if (!buffered || !buffered.length) {
      return;
    }
    buffered = getActiveTimeRange(buffered, videoEl.currentTime);
    let timeBufferPercentaje = (buffered[2] * 100) / videoEl.duration;
    timeBuffer = timeBufferPercentaje;
    document.querySelector(
      ".colorBuffer"
    ).style.width = `${timeBufferPercentaje}px`;
  }

  // Función de utilidad para obtener el rango de tiempo activo
  function getActiveTimeRange(range, time) {
    let len = range.length;
    let index = -1;
    let start = 0;
    let end = 0;
    for (let i = 0; i < len; i++) {
      if (time >= (start = range.start(i)) && time <= (end = range.end(i))) {
        index = i;
        break;
      }
    }
    return [index, start, end];
  }

  // Función de utilidad para formatear el tiempo
  function formatTime(timeInSeconds) {
    const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);
    return {
      minutes: result.substr(3, 2),
      seconds: result.substr(6, 2),
    };
  }

  // Manejadores de eventos
  window.addEventListener("keyup", keyEvent);
  window.addEventListener("resize", onResize);
}
const toggleMode = () => {
  document.querySelector("body").classList.toggle("teaching-mode");
  // Obtener todos los elementos con la clase ".theme-checkbox"
  const checkboxes = document.querySelectorAll(".theme-checkbox");
  // Iterar sobre cada elemento y cambiar su estado "checked"
  checkboxes.forEach((checkbox) => {
    checkbox.checked = document
      .querySelector("body")
      .classList.contains("teaching-mode");
  });
};
