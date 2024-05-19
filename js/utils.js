// Función para obtener las películas favoritas desde LocalStorage
function getFavoriteMovies() {
  // Intenta obtener el arreglo de películas favoritas desde LocalStorage
  const favorites = localStorage.getItem("favoriteMovies");
  // Si no hay nada guardado, devuelve un arreglo vacío
  return favorites ? JSON.parse(favorites) : [];
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
  } else {
    console.log("La película ya está en la lista de favoritos.");
  }
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
  str = str.replace(/¡/g, "&#161;", str); //Signo de exclamación abierta.&iexcl;
  str = str.replace(/¢/g, "-", str); //Signo de centavo.&cent;
  str = str.replace(/£/g, "-", str); //Signo de libra esterlina.&pound;
  str = str.replace(/¤/g, "-", str); //Signo monetario.&curren;
  str = str.replace(/¥/g, "-", str); //Signo del yen.&yen;
  str = str.replace(/¦/g, "-", str); //Barra vertical partida.&brvbar;
  str = str.replace(/§/g, "-", str); //Signo de sección.&sect;
  str = str.replace(/¨/g, "-", str); //Diéresis.&uml;
  str = str.replace(/©/g, "-", str); //Signo de derecho de copia.&copy;
  str = str.replace(/ª/g, "-", str); //Indicador ordinal femenino.&ordf;
  str = str.replace(/«/g, "-", str); //Signo de comillas francesas de apertura.&laquo;
  str = str.replace(/¬/g, "-", str); //Signo de negación.&not;
  str = str.replace(/®/g, "-", str); //Signo de marca registrada.&reg;
  str = str.replace(/¯/g, "&-", str); //Macrón.&macr;
  str = str.replace(/°/g, "-", str); //Signo de grado.&deg;
  str = str.replace(/±/g, "-", str); //Signo de más-menos.&plusmn;
  str = str.replace(/²/g, "-", str); //Superíndice dos.&sup2;
  str = str.replace(/³/g, "-", str); //Superíndice tres.&sup3;
  str = str.replace(/´/g, "-", str); //Acento agudo.&acute;
  str = str.replace(/µ/g, "-", str); //Signo de micro.&micro;
  str = str.replace(/¶/g, "-", str); //Signo de calderón.&para;
  str = str.replace(/·/g, "-", str); //Punto centrado.&middot;
  str = str.replace(/¸/g, "-", str); //Cedilla.&cedil;
  str = str.replace(/¹/g, "-", str); //Superíndice 1.&sup1;
  str = str.replace(/º/g, "-", str); //Indicador ordinal masculino.&ordm;
  str = str.replace(/»/g, "-", str); //Signo de comillas francesas de cierre.&raquo;
  str = str.replace(/¼/g, "-", str); //Fracción vulgar de un cuarto.&frac14;
  str = str.replace(/½/g, "-", str); //Fracción vulgar de un medio.&frac12;
  str = str.replace(/¾/g, "-", str); //Fracción vulgar de tres cuartos.&frac34;
  str = str.replace(/¿/g, "-", str); //Signo de interrogación abierta.&iquest;
  str = str.replace(/×/g, "-", str); //Signo de multiplicación.&times;
  str = str.replace(/÷/g, "-", str); //Signo de división.&divide;
  str = str.replace(/À/g, "a", str); //A mayúscula con acento grave.&Agrave;
  str = str.replace(/Á/g, "a", str); //A mayúscula con acento agudo.&Aacute;
  str = str.replace(/Â/g, "a", str); //A mayúscula con circunflejo.&Acirc;
  str = str.replace(/Ã/g, "a", str); //A mayúscula con tilde.&Atilde;
  str = str.replace(/Ä/g, "a", str); //A mayúscula con diéresis.&Auml;
  str = str.replace(/Å/g, "a", str); //A mayúscula con círculo encima.&Aring;
  str = str.replace(/Æ/g, "a", str); //AE mayúscula.&AElig;
  str = str.replace(/Ç/g, "c", str); //C mayúscula con cedilla.&Ccedil;
  str = str.replace(/È/g, "e", str); //E mayúscula con acento grave.&Egrave;
  str = str.replace(/É/g, "e", str); //E mayúscula con acento agudo.&Eacute;
  str = str.replace(/Ê/g, "e", str); //E mayúscula con circunflejo.&Ecirc;
  str = str.replace(/Ë/g, "e", str); //E mayúscula con diéresis.&Euml;
  str = str.replace(/Ì/g, "i", str); //I mayúscula con acento grave.&Igrave;
  str = str.replace(/Í/g, "i", str); //I mayúscula con acento agudo.&Iacute;
  str = str.replace(/Î/g, "i", str); //I mayúscula con circunflejo.&Icirc;
  str = str.replace(/Ï/g, "i", str); //I mayúscula con diéresis.&Iuml;
  str = str.replace(/Ð/g, "d", str); //ETH mayúscula.&ETH;
  str = str.replace(/Ñ/g, "n", str); //N mayúscula con tilde.&Ntilde;
  str = str.replace(/Ò/g, "o", str); //O mayúscula con acento grave.&Ograve;
  str = str.replace(/Ó/g, "o", str); //O mayúscula con acento agudo.&Oacute;
  str = str.replace(/Ô/g, "o", str); //O mayúscula con circunflejo.&Ocirc;
  str = str.replace(/Õ/g, "o", str); //O mayúscula con tilde.&Otilde;
  str = str.replace(/Ö/g, "o", str); //O mayúscula con diéresis.&Ouml;
  str = str.replace(/Ø/g, "o", str); //O mayúscula con barra inclinada.&Oslash;
  str = str.replace(/Ù/g, "u", str); //U mayúscula con acento grave.&Ugrave;
  str = str.replace(/Ú/g, "u", str); //U mayúscula con acento agudo.&Uacute;
  str = str.replace(/Û/g, "u", str); //U mayúscula con circunflejo.&Ucirc;
  str = str.replace(/Ü/g, "u", str); //U mayúscula con diéresis.&Uuml;
  str = str.replace(/Ý/g, "y", str); //Y mayúscula con acento agudo.&Yacute;
  str = str.replace(/Þ/g, "b", str); //Thorn mayúscula.&THORN;
  str = str.replace(/ß/g, "b", str); //S aguda alemana.&szlig;
  str = str.replace(/à/g, "a", str); //a minúscula con acento grave.&agrave;
  str = str.replace(/á/g, "a", str); //a minúscula con acento agudo.&aacute;
  str = str.replace(/â/g, "a", str); //a minúscula con circunflejo.&acirc;
  str = str.replace(/ã/g, "a", str); //a minúscula con tilde.&atilde;
  str = str.replace(/ä/g, "a", str); //a minúscula con diéresis.&auml;
  str = str.replace(/å/g, "a", str); //a minúscula con círculo encima.&aring;
  str = str.replace(/æ/g, "a", str); //ae minúscula.&aelig;
  str = str.replace(/ç/g, "a", str); //c minúscula con cedilla.&ccedil;
  str = str.replace(/è/g, "e", str); //e minúscula con acento grave.&egrave;
  str = str.replace(/é/g, "e", str); //e minúscula con acento agudo.&eacute;
  str = str.replace(/ê/g, "e", str); //e minúscula con circunflejo.&ecirc;
  str = str.replace(/ë/g, "e", str); //e minúscula con diéresis.&euml;
  str = str.replace(/ì/g, "i", str); //i minúscula con acento grave.&igrave;
  str = str.replace(/í/g, "i", str); //i minúscula con acento agudo.&iacute;
  str = str.replace(/î/g, "i", str); //i minúscula con circunflejo.&icirc;
  str = str.replace(/ï/g, "i", str); //i minúscula con diéresis.&iuml;
  str = str.replace(/ð/g, "i", str); //eth minúscula.&eth;
  str = str.replace(/ñ/g, "n", str); //n minúscula con tilde.&ntilde;
  str = str.replace(/ò/g, "o", str); //o minúscula con acento grave.&ograve;
  str = str.replace(/ó/g, "o", str); //o minúscula con acento agudo.&oacute;
  str = str.replace(/ô/g, "o", str); //o minúscula con circunflejo.&ocirc;
  str = str.replace(/õ/g, "o", str); //o minúscula con tilde.&otilde;
  str = str.replace(/ö/g, "o", str); //o minúscula con diéresis.&ouml;
  str = str.replace(/ø/g, "o", str); //o minúscula con barra inclinada.&oslash;
  str = str.replace(/ù/g, "o", str); //u minúscula con acento grave.&ugrave;
  str = str.replace(/ú/g, "u", str); //u minúscula con acento agudo.&uacute;
  str = str.replace(/û/g, "u", str); //u minúscula con circunflejo.&ucirc;
  str = str.replace(/ü/g, "u", str); //u minúscula con diéresis.&uuml;
  str = str.replace(/ý/g, "y", str); //y minúscula con acento agudo.&yacute;
  str = str.replace(/þ/g, "b", str); //thorn minúscula.&thorn;
  str = str.replace(/ÿ/g, "y", str); //y minúscula con diéresis.&yuml;
  str = str.replace(/Œ/g, "d", str); //OE Mayúscula.&OElig;
  str = str.replace(/œ/g, "-", str); //oe minúscula.&oelig;
  str = str.replace(/Ÿ/g, "-", str); //Y mayúscula con diéresis.&Yuml;
  str = str.replace(/ˆ/g, "-", str); //Acento circunflejo.&circ;
  str = str.replace(/˜/g, "-", str); //Tilde.&tilde;
  str = str.replace(/–/g, "-", str); //Guiún corto.&ndash;
  str = str.replace(/—/g, "-", str); //Guiún largo.&mdash;
  str = str.replace(/'/g, "-", str); //Comilla simple izquierda.&lsquo;
  str = str.replace(/'/g, "-", str); //Comilla simple derecha.&rsquo;
  str = str.replace(/,/g, "-", str); //Comilla simple inferior.&sbquo;
  str = str.replace(/"/g, "-", str); //Comillas doble derecha.&rdquo;
  str = str.replace(/"/g, "-", str); //Comillas doble inferior.&bdquo;
  str = str.replace(/†/g, "-", str); //Daga.&dagger;
  str = str.replace(/‡/g, "-", str); //Daga doble.&Dagger;
  str = str.replace(/…/g, "-", str); //Elipsis horizontal.&hellip;
  str = str.replace(/‰/g, "-", str); //Signo de por mil.&permil;
  str = str.replace(/‹/g, "-", str); //Signo izquierdo de una cita.&lsaquo;
  str = str.replace(/›/g, "-", str); //Signo derecho de una cita.&rsaquo;
  str = str.replace(/€/g, "-", str); //Euro.&euro;
  str = str.replace(/™/g, "-", str); //Marca registrada.&trade;
  str = str.replace(/ & /g, "-", str); //Marca registrada.&trade;
  str = str.replace(/\(/g, "-", str);
  str = str.replace(/\)/g, "-", str);
  str = str.replace(/�/g, "-", str);
  str = str.replace(/\//g, "-", str);
  str = str.replace(/ /g, "-", str); //Espacios
  str = str.replace(/  /g, "p", str); //Espacios
  str = str.replace(/\./g, "", str); //Punto
  str = str.replace(/–/g, "-"); // Replace en-dash
  str = str.replace(/—/g, "-"); // Replace em-dash
  str = str.replace(/-/g, "-"); // Replace hyphen

  //Mayusculas
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
  if (!links.hasAttribute("target") && !links.hasAttribute("data-fancybox")) {
    links.addEventListener("click", () => {
      console.log("click");
      fadeIn(preloader);
    });
  }
});
