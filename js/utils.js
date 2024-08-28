var ui_words = new Array();
var functionLCompleted = false;

// Array donde almacenaremos las palabras
var ui_words = [];

// Función para cargar y procesar el archivo JSON
function cargarJSON(url) {
  return fetch(url)
    .then(function (response) {
      // Verificar si la solicitud fue exitosa
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      // Parsear el JSON y devolverlo
      return response.json();
    })
    .then(function (data) {
      // Procesar cada palabra y agregarla a ui_words
      data.forEach(function (palabra) {
        ui_words.push({ row: palabra.row, es: palabra.es, fr: palabra.fr });
      });
      // Marcar la finalización de la función
      functionLCompleted = true;
    })
    .catch(function (error) {
      console.error("There was a problem with the fetch operation:", error);
    });
}

function findUiWord(row, lang) {
  if (functionLCompleted) {
    var value = ui_words[row][lang];
    return value;
  } else {
    setTimeout(function () {
      findUiWord(row, lang);
    }, 10);
  }
}
// Función para obtener las películas favoritas desde LocalStorage
function getFavoriteMovies() {
  // Intenta obtener el arreglo de películas favoritas desde LocalStorage
  const favorites = localStorage.getItem("favoriteMovies");
  // Si no hay nada guardado, devuelve un arreglo vacío
  let favoritesJSON = favorites ? JSON.parse(favorites) : [];
  if (document.querySelector(`.swiperHomeApp`)) {
    favoritesJSON.forEach((favorite) => {
      document
        .querySelector(
          `.swiperHomeApp .swiper-slide[data-movieid="${favorite.id}"]`
        )
        .classList.add("isFavorite");
    });
  }
  return favoritesJSON;
}

// Función para guardar el arreglo de películas favoritas en LocalStorage
function saveFavoriteMovies(favoriteMovies) {
  // Convierte el arreglo de películas a una cadena JSON y guárdalo en LocalStorage
  localStorage.setItem("favoriteMovies", JSON.stringify(favoriteMovies));
}

// Función para agregar una película a las favoritas
function addMovieToFavorites(movie) {
  // Obtiene las películas favoritas actuales
  const favoriteMovies = getFavoriteMovies();
  // Verifica si la película ya está en la lista de favoritas
  const movieExists = favoriteMovies.some(
    (favMovie) => favMovie.id === movie.id
  );
  if (!movieExists) {
    // Si la película no está en la lista, la agrega
    favoriteMovies.push(movie);
    // Guarda el nuevo arreglo de películas favoritas en LocalStorage
    saveFavoriteMovies(favoriteMovies);
    console.log("Película agregada a favoritos:", movie);
       // Muestra la notificación toast
       showToast("Película agregada a favoritos");
  } else {
    console.log("La película ya está en la lista de favoritos.");
  }
}
// Función para mostrar una notificación tipo toast
function showToast(message) {
  const toastContainer = document.getElementById('toast-container');
  const toast = document.createElement('div');
  toast.textContent = message;
  toast.style.backgroundColor = '#037a19';
  toast.style.color = '#fff';
  toast.style.padding = '10px 20px';
  toast.style.marginTop = '10px';
  toast.style.borderRadius = '5px';
  toast.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';
  toast.style.opacity = '0';
  toast.style.transition = 'opacity 0.5s';
  toastContainer.appendChild(toast);

  // Forzar el reflujo para que la transición de opacidad funcione
  window.getComputedStyle(toast).opacity;
  toast.style.opacity = '1';

  // Eliminar el toast después de 3 segundos
  setTimeout(() => {
    toast.style.opacity = '0';
    toast.addEventListener('transitionend', () => {
      toast.remove();
    });
  }, 3000);
}

function lazyImages() {
  if ("loading" in HTMLImageElement.prototype) {
    const images = document.querySelectorAll("img.lazyload");
    images.forEach((img) => {
      if (img.dataset.src) {
        img.src = img.dataset.src;
      } else if (img.dataset.blobUrl) {
        img.src = img.dataset.blobUrl;
      }
    });
  } else {
    let script = document.createElement("script");
    script.async = true;
    script.src = "js/lazysizes.min.js";
    document.body.appendChild(script);

    // Si el navegador no es compatible con la carga diferida de imágenes, cargarlas como Blob URLs
    loadImagesAsBlobUrls();
  }
}
// Función para cargar imágenes como Blob URLs y actualizar el atributo data-src
async function loadImagesAsBlobUrls() {
  const images = document.querySelectorAll("img.lazyload");
  for (const img of images) {
    if (img.dataset.src) {
      const response = await fetch(img.dataset.src);
      const blob = await response.blob();
      const blobUrl = URL.createObjectURL(blob);
      img.src = blobUrl; // Cambiar src directamente a la URL de Blob
      img.dataset.blobUrl = blobUrl; // Mantener la URL de Blob en el dataset
      img.removeAttribute("data-src"); // Eliminar el atributo data-src
    }
  }
}
// Seleccionar el elemento con la clase ".preloader"
var preloader = document.querySelector(".preloader");
// Función para desvanecer gradualmente el elemento
function fadeOut(element) {
  var opacity = 1;
  var interval = 50; // intervalo de tiempo en milisegundos
  var duration = 500; // duración total del desvanecimiento en milisegundos

  // Función recursiva para ajustar la opacidad en cada paso del intervalo
  function decreaseOpacity() {
    opacity -= interval / duration;
    element.style.opacity = opacity;

    // Si la opacidad es mayor que 0, seguir desvaneciendo
    if (opacity > 0) {
      setTimeout(decreaseOpacity, interval);
    } else {
      // Si la opacidad llega a 0, ocultar el elemento
      element.style.display = "none";
    }
  }

  // Iniciar el desvanecimiento
  decreaseOpacity();
}
// Función para desvanecer gradualmente el elemento
function fadeIn(element) {
  var opacity = 0;
  var interval = 50; // intervalo de tiempo en milisegundos
  var duration = 500; // duración total del desvanecimiento en milisegundos

  // Mostrar el elemento antes de comenzar el desvanecimiento
  element.style.display = "block";

  // Función recursiva para ajustar la opacidad en cada paso del intervalo
  function increaseOpacity() {
    opacity += interval / duration;
    element.style.opacity = opacity;

    // Si la opacidad es menor que 1, seguir desvaneciendo
    if (opacity < 1) {
      setTimeout(increaseOpacity, interval);
    }
  }

  // Iniciar el desvanecimiento
  increaseOpacity();
}

function get_alias(str) {
  // Decodificar entidades HTML
  const textArea = document.createElement('textarea');
  textArea.innerHTML = str;
  str = textArea.value;

  // Reemplazar caracteres específicos con guiones o eliminarlos
  str = str.replace(/¡|!|\?|¢|£|¤|¥|¦|§|¨|©|ª|«|¬|®|¯|°|±|²|³|´|µ|¶|·|¸|¹|º|»|¼|½|¾|¿|×|÷|œ|Ÿ|ˆ|˜|–|—|‘|’|“|”|\+|–|&|\/|:|&#8211;/g, "-");
  str = str.replace(/'/g, ""); // Comillas simples
  str = str.replace(/"/g, ""); // Comillas dobles

  // Reemplazar caracteres acentuados por sus equivalentes sin acento
  const from = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿŒœ";
  const to = "aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuybyoe";
  str = str.replace(/./g, c => {
    const index = from.indexOf(c);
    return index === -1 ? c : to[index];
  });

  // Reemplazar espacios y algunos patrones específicos con guiones
  str = str.replace(/(\s| de | y | a )/gi, "-");

  // Eliminar caracteres adicionales no deseados
  str = str.replace(/[()]/g, "-");
  str = str.replace(/\./g, ""); // Eliminar punto
  str = str.replace(/--+/g, "-"); // Eliminar guiones consecutivos

  // Convertir a minúsculas
  str = str.toLowerCase();

  return str;
}

const setWithExpiry = (key, value, ttl) => {
  const now = new Date();

  // El valor `ttl` es el tiempo de vida en milisegundos (por ejemplo, una semana).
  const item = {
    value: value,
    expiry: now.getTime() + ttl,
  };

  localStorage.setItem(key, JSON.stringify(item));
};

const getWithExpiry = (key) => {
  const itemStr = localStorage.getItem(key);

  // Si el ítem no existe, devuelve null
  if (!itemStr) {
    return null;
  }

  const item = JSON.parse(itemStr);
  const now = new Date();

  // Compara la fecha de expiración con la fecha actual
  if (now.getTime() > item.expiry) {
    // Si el ítem expiró, bórralo del storage y devuelve null
    localStorage.removeItem(key);
    return null;
  }

  return item.value;
};

document.querySelectorAll("a").forEach((links) => {
  if (
    !links.hasAttribute("target") &&
    !links.hasAttribute("data-fancybox") &&
    links.href !== "javascript:;" &&
    !links.href.includes("#") &&
    !links.href.includes("https://")
  ) {
    links.addEventListener("click", () => {
      fadeIn(preloader);
    });
  }
});
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();

      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth",
      });
    });
  });
  cargarJSON("/data_static.json");
  getFavoriteMovies();
});

// Selecciona todos los elementos con la clase "c-hamburger"
var toggles = document.querySelectorAll(".c-hamburger");

// Itera sobre los elementos en reversa
for (var i = toggles.length - 1; i >= 0; i--) {
  var toggle = toggles[i];
  toggleHandler(toggle);
}

function toggleHandler(toggle) {
  toggle.addEventListener("click", function (e) {
    e.preventDefault();
    if (this.classList.contains("is-active")) {
      this.classList.remove("is-active");
      document.querySelectorAll(".open").forEach(function (element) {
        element.classList.remove("oppenned");
      });
    } else {
      this.classList.add("is-active");
      document.querySelectorAll(".open").forEach(function (element) {
        element.classList.add("oppenned");
      });
    }
  });
}
