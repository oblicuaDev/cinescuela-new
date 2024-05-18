let edades, asignaturas, totems;
const toggleForms = () => {
  let login = document.querySelector("#login");
  let forgotForm = document.querySelector("#forgotForm");

  login.classList.toggle("active");
  forgotForm.classList.toggle("active");
};
if (document.querySelector("button.show")) {
  document.querySelector("button.show").addEventListener("click", () => {
    const passwordInput = document.querySelector(
      ".login main form .formcontent span input#password"
    );
    const type =
      passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
  });
}
const getCiclosInfo = async () => {
  const mainElement = document.querySelector("main");
  const swiperWrapper = document.querySelector(`#ciclomes .swiper-wrapper`);
  const cicloID = mainElement.dataset.ciclo_del_mes;

  if (cicloID) {
    let ciclo = getWithExpiry("cicloGuardado");

    if (!ciclo || ciclo.id != cicloID) {
      const responseCiclo = await fetch(`${lang}/g/getCiclos/?id=${cicloID}`);
      ciclo = await responseCiclo.json();
      setWithExpiry("cicloGuardado", ciclo, 7 * 24 * 60 * 60 * 1000); // 7 días en milisegundos
    }

    document.querySelector(
      "#ciclomes h3"
    ).innerHTML = `Ciclo del mes: ${ciclo.title.rendered}`;

    let movies = getWithExpiry("moviesGuardadas");

    if (!movies || ciclo.id != cicloID) {
      const response = await fetch(`${lang}/g/getMovies/`, {
        body: JSON.stringify(ciclo.acf.peliculas_del_ciclo.map(String)),
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });
      movies = await response.json();
      setWithExpiry("moviesGuardadas", movies, 7 * 24 * 60 * 60 * 1000); // 7 días en milisegundos
    }

    swiperWrapper.innerHTML = "";
    const windowWidth = window.innerWidth;

    movies.forEach((movie) => {
      let theme = false;

      const acomp =
        movie.related_cinescuela_ap?.[0] || movie.related_cinescuela_ap;
      if (acomp?.acf_fields?.presentaciones?.tema_light) {
        theme = acomp.acf_fields.presentaciones.tema_light;
      }

      const movieElement = document.createElement("div");
      movieElement.classList.add("swiper-slide");
      movieElement.innerHTML = `
        <a href="javascript:;" data-fancybox data-src="#dialog-content" data-temalight="${theme}">
          <img loading="lazy" class="lazyload" src="https://picsum.photos/20/20" data-src="${
            windowWidth > 768 ? movie.acf.imagen_pelicula : movie.acf.afiche
          }" alt="Logo Pelicula">
          ${
            movie.acf.logo_de_la_pelicula
              ? `<img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20" data-src="${movie.acf.logo_de_la_pelicula}" alt="Logo Pelicula">`
              : `<h2>${movie.title.rendered}</h2>`
          }
        </a>`;
      movieElement.addEventListener("click", () => getInfoMovie(movie));
      swiperWrapper.appendChild(movieElement);
    });

    lazyImages();
    fadeOut(preloader);
    getRandomAsignaturaAndTemaMovies();
  }
};
const getLoMasVisto = async () => {
  const mainElement = document.querySelector("main");
  const swiperWrapper = document.querySelector(`#lomasvisto .swiper-wrapper`);
  const peliculasDataset = mainElement.dataset.peliculas_en_lo_mas_visto;

  if (peliculasDataset) {
    let lomasvisto = peliculasDataset;
    let movies = getWithExpiry("lomasvistomovies");

    if (!movies) {
      const response = await fetch(`${lang}/g/getMovies/`, {
        body: JSON.stringify(lomasvisto.split(",")),
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });
      movies = await response.json();

      // Guardar las películas en localStorage con una expiración de una semana
      setWithExpiry("lomasvistomovies", movies, 7 * 24 * 60 * 60 * 1000); // 7 días en milisegundos
    }

    swiperWrapper.innerHTML = "";
    const windowWidth = window.innerWidth;

    movies.forEach((movie) => {
      let theme = false;

      const acomp =
        movie.related_cinescuela_ap?.[0] || movie.related_cinescuela_ap;
      if (acomp?.acf_fields?.presentaciones?.tema_light) {
        theme = acomp.acf_fields.presentaciones.tema_light;
      }

      const movieElement = document.createElement("div");
      movieElement.classList.add("swiper-slide");
      if (movie.acf) {
        console.log({
          afiche: movie.acf.afiche,
          acf: movie.acf,
          movie: movie,
        });
        movieElement.innerHTML = `
          <a href="javascript:;" data-fancybox data-src="#dialog-content" data-temalight="${theme}">
            <img loading="lazy" class="lazyload" src="https://picsum.photos/20/20" data-src="${movie.acf.afiche}" alt="Logo Pelicula">
          </a>`;
        movieElement.addEventListener("click", () => getInfoMovie(movie));
        swiperWrapper.appendChild(movieElement);
      }
    });

    lazyImages();
  }
};

const getRandomAsignaturaAndTemaMovies = async () => {
  try {
    let datagetAsignaturas = [];
    let datagetTemas = [];

    // Comprobar si los datos están en el localStorage
    if (
      localStorage.getItem("datagetAsignaturaIds") &&
      localStorage.getItem("datagetTemaIds")
    ) {
      datagetAsignaturas = JSON.parse(
        localStorage.getItem("datagetAsignaturaIds")
      );
      datagetTemas = JSON.parse(localStorage.getItem("datagetTemaIds"));
    } else {
      const [responsegetAsignaturas, responsegetTemas] = await Promise.all([
        fetch(`${lang}/g/getAsignaturas/`),
        fetch(`${lang}/g/getTemas/`),
      ]);

      [datagetAsignaturas, datagetTemas] = await Promise.all([
        responsegetAsignaturas.json(),
        responsegetTemas.json(),
      ]);

      // Guardar solo los IDs en localStorage
      localStorage.setItem(
        "datagetAsignaturaIds",
        JSON.stringify(
          datagetAsignaturas.map((asignatura) => ({
            id: asignatura.id,
            title: asignatura.title.rendered,
          }))
        )
      );
      localStorage.setItem(
        "datagetTemaIds",
        JSON.stringify(
          datagetTemas.map((tema) => ({
            id: tema.id,
            title: tema.title.rendered,
          }))
        )
      );
    }

    // Obtener dos IDs aleatorios de cada arreglo
    const randomAsignaturaIds = getRandomElements(datagetAsignaturas, 2);
    const randomTemaIds = getRandomElements(datagetTemas, 2);

    // Actualizar el contenido de los elementos del DOM
    document.querySelector("#asignatura-line1 h3").innerHTML =
      randomAsignaturaIds[0].title;
    document.querySelector("#tema-line1 h3").innerHTML = randomTemaIds[0].title;
    document.querySelector("#asignatura-line2 h3").innerHTML =
      randomAsignaturaIds[1].title;
    document.querySelector("#tema-line2 h3").innerHTML = randomTemaIds[1].title;

    // Hacer las solicitudes de películas a la vez
    const [
      responsegetAsignaturas1,
      responsegetTemas1,
      responsegetAsignaturas2,
      responsegetTemas2,
    ] = await Promise.all([
      fetch(`${lang}/g/getMoviesByAsignatura/`, {
        body: JSON.stringify(randomAsignaturaIds[0].id.toString()),
        method: "POST",
      }),
      fetch(`${lang}/g/getMoviesByTema/`, {
        body: JSON.stringify(randomTemaIds[0].id.toString()),
        method: "POST",
      }),
      fetch(`${lang}/g/getMoviesByAsignatura/`, {
        body: JSON.stringify(randomAsignaturaIds[1].id.toString()),
        method: "POST",
      }),
      fetch(`${lang}/g/getMoviesByTema/`, {
        body: JSON.stringify(randomTemaIds[1].id.toString()),
        method: "POST",
      }),
    ]);

    const procesarRespuesta = async (response, container) => {
      if (response.ok) {
        const movies = await response.json();
        const containerElement = document.querySelector(
          `${container} .swiper-wrapper`
        );
        containerElement.innerHTML = "";

        movies.forEach((movie, i) => {
          const theme =
            movie.related_cinescuela_ap?.[0]?.acf_fields?.presentaciones
              .tema_light || false;
          const videoLink = movie.acf.url_trailer; // Cambia este enlace según sea necesario

          const movieElement = document.createElement("div");
          movieElement.classList.add("swiper-slide");
          movieElement.innerHTML = `
            <a href="javascript:;" data-fancybox data-src="#dialog-content" data-temalight="${theme}">
              <img loading="lazy" class="lazyload" src="https://picsum.photos/20/20" data-src="${
                windowWidth > 768 ? movie.acf.imagen_pelicula : movie.acf.afiche
              }" alt="Logo Pelicula">
              ${
                movie.acf.logo_de_la_pelicula
                  ? `<img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20" data-src="${movie.acf.logo_de_la_pelicula}" alt="Logo Pelicula">`
                  : `<h2>${movie.title.rendered}</h2>`
              }
            </a>`;

          movieElement.addEventListener("click", () => getInfoMovie(movie));
          containerElement.appendChild(movieElement);
        });
      } else {
        console.error("Error en la solicitud:", response.status);
      }
    };

    // Procesa las respuestas de cada solicitud
    await Promise.all([
      procesarRespuesta(responsegetAsignaturas1, "#asignatura-line1"),
      procesarRespuesta(responsegetTemas1, "#tema-line1"),
      procesarRespuesta(responsegetAsignaturas2, "#asignatura-line2"),
      procesarRespuesta(responsegetTemas2, "#tema-line2"),
    ]);

    lazyImages();
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

// Función auxiliar para obtener elementos aleatorios
const getRandomElements = (arr, num) => {
  const shuffled = [...arr].sort(() => 0.5 - Math.random());
  return shuffled.slice(0, num);
};

const preloadImages = (images) => {
  images.forEach((imageSrc) => {
    const img = new Image();
    img.src = imageSrc;
  });
};

const getInfoMovie = (movie) => {
  let {
    id,
    title: { rendered: titleRendered },
    acf: {
      director_pelicula,
      pais_pelicula,
      duracion_en_minutos,
      imagen_pelicula,
      logo_de_la_pelicula,
      palabras_clave_de_esta_publicacion,
    },
  } = movie;
  // Precargar imágenes
  preloadImages([imagen_pelicula, logo_de_la_pelicula]);
  document.querySelector("#dialog-content .image img").dataset.src =
    imagen_pelicula;
  if (logo_de_la_pelicula) {
    document.querySelector("#dialog-content #logoPeli").style.display = "block";
    document.querySelector("#dialog-content #logoPeli").dataset.src =
      logo_de_la_pelicula;
    if (document.querySelector("#dialog-content .image h2")) {
      document.querySelector("#dialog-content .image h2").style.display =
        "none";
    }
  } else {
    document.querySelector(
      "#dialog-content .image"
    ).innerHTML += `<h2>${titleRendered}</h2>`;
    document.querySelector("#dialog-content #logoPeli").style.display = "none";
  }
  document.querySelector("#dialog-content .director").innerHTML =
    director_pelicula;
  document.querySelector("#dialog-content .country__date").innerHTML =
    pais_pelicula;
  document.querySelector("#dialog-content .time").innerHTML =
    duracion_en_minutos;
  document.querySelector("#dialog-content .tags").innerHTML =
    palabras_clave_de_esta_publicacion
      .split(",")
      .map((word) => `<li>${word}</li>`)
      .join("");

  document.querySelector(
    "#dialog-content .actions"
  ).innerHTML = `<a class="btn btn-primary" href="${lang}/pelicula/${get_alias(
    titleRendered
  )}-${id}">Reproducir película</a><a class="btn btn-secondary" href="${lang}/pelicula/${get_alias(
    titleRendered
  )}-${id}?activeTeaching=1">Activar Modo Pedagógico</a><span class="age">13+</span>`;

  lazyImages();
};
function acortarTextoEnriquecido(texto, longitudMaxima) {
  // Eliminar etiquetas HTML y espacios en blanco innecesarios
  let textoSinHTML = texto
    .replace(/<[^>]+>/g, "")
    .replace(/\s+/g, " ")
    .trim();

  // Verificar si el texto ya es más corto que la longitud máxima
  if (textoSinHTML.length <= longitudMaxima) {
    return textoSinHTML;
  }

  // Acortar el texto y agregar puntos suspensivos
  let textoAcortado = textoSinHTML.substring(0, longitudMaxima).trim() + "...";

  return textoAcortado;
}
const getAP = async () => {
  const idAPMovie = document.querySelector("main").dataset.movieid;
  if (idAPMovie) {
    const response = await fetch(`${lang}/g/getAP/?id=${idAPMovie}`);
    const data = await response.json();
    document.querySelector(
      ".notes"
    ).innerHTML = `<h2>Notas para el profesor</h2>${data.acf.notas_para_el_profesor}`;
    document.querySelector(".reconocimientos ul").innerHTML =
      data.acf.presentaciones.reconocimientos
        .split(`\n`)
        .map((reconocimiento) => {
          if (reconocimiento.trim() !== "") {
            return `<li>${reconocimiento}</li>`;
          } else {
            return ""; // Si el reconocimiento está vacío, no se crea <li>
          }
        })
        .join("");
    document.querySelector(".sectionpedago").innerHTML = `
      <a href="${lang}/acompanamiento-pedagogico/${get_alias(
      data.title.rendered
    )}-${idAPMovie}?tabactive=lenguaje"><span class="title">Lenguaje</span><div class="content"><img loading="lazy" class="lazyload" src="https://placehold.co/720x378/037A19/FFFFFF" data-src="${
      data.acf.seccion_pelicula.actividad_1.imagen
    }" alt="${
      data.acf.seccion_pelicula.actividad_1.titulo
    }"><p>${acortarTextoEnriquecido(
      data.acf.seccion_pelicula.actividad_1.descripcion,
      200
    )}</p><small>Ver más</small></div></a>
      <a href="${lang}/acompanamiento-pedagogico/${get_alias(
      data.title.rendered
    )}-${idAPMovie}?tabactive=contexto"><span class="title">Contexto</span><div class="content"><img loading="lazy" class="lazyload" src="https://placehold.co/720x378/037A19/FFFFFF" data-src="${
      data.acf.contexto.actividad_1.imagen
    }" alt="${
      data.acf.contexto.actividad_1.titulo
    }"><p>${acortarTextoEnriquecido(
      data.acf.contexto.actividad_1.descripcion,
      200
    )}</p><small>Ver más</small></div></a>`;
    getCulturaSociedad(data.id);
  }
  fadeOut(preloader);
  lazyImages();
};
async function getCulturaSociedad(id) {
  const response = await fetch(`${lang}/g/getCulturaSociedad/?id=${id}`);
  const culturaSociedad = await response.json();
  mostrarCulturaSociedad(culturaSociedad);
}
async function getEdades(id = "") {
  // Comprobar si las edades ya están en localStorage
  const edadesKey = `edades_${id}`;
  const edadesCache = localStorage.getItem(edadesKey);

  if (edadesCache) {
    // Si existe en localStorage, devolver los datos guardados
    return JSON.parse(edadesCache);
  } else {
    // Si no existe en localStorage, hacer la petición
    const response = await fetch(`${lang}/g/getEdades/?id=${id}`);
    const edades = await response.json();
    const formattedEdades = edades.response.map((edad) => ({
      id: edad.id,
      title: edad.title.rendered,
    }));

    // Guardar el resultado en localStorage
    localStorage.setItem(edadesKey, JSON.stringify(formattedEdades));

    return formattedEdades;
  }
}

async function getAsignaturas(id = "") {
  // Comprobar si las asignaturas ya están en localStorage
  const asignaturasKey = `asignaturas_${id}`;
  const asignaturasCache = localStorage.getItem(asignaturasKey);

  if (asignaturasCache) {
    // Si existe en localStorage, devolver los datos guardados
    return JSON.parse(asignaturasCache);
  } else {
    // Si no existe en localStorage, hacer la petición
    const response = await fetch(`${lang}/g/getAsignaturas/?id=${id}`);
    const asignaturas = await response.json();
    const formattedAsignaturas = asignaturas.map((asignatura) => ({
      id: asignatura.id,
      title: asignatura.title.rendered,
    }));

    // Guardar el resultado en localStorage
    localStorage.setItem(asignaturasKey, JSON.stringify(formattedAsignaturas));

    return formattedAsignaturas;
  }
}

// Función para mostrar los resultados en la interfaz
function mostrarCulturaSociedad(culturaSociedad) {
  let containerList = document.querySelector(".cards");
  containerList.innerHTML = "";
  culturaSociedad.forEach((cs) => {
    if (cs.acf.backgroundimgcs !== "") {
      figureHtml = `<img loading="lazy" class="lazyload" src="https://placehold.co/230x297/037A19/FFFFFF" data-src="${cs.acf.backgroundimgcs}" alt="${cs.title.rendered}" />`;
    } else {
      figureHtml = `<img loading="lazy" class="lazyload" src="https://placehold.co/230x297/037A19/FFFFFF" data-src="https://files.cinescuela.org/2024/03/cultura-sociedad-temporal.jpg" alt="${cs.title.rendered}" />`;
    }
    containerList.innerHTML += `<li><span class="i_list">${cs.title.rendered}</span>${figureHtml}</li>`;
  });
  lazyImages();
}
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
const addOptionsToFilters = (options = [{ id, title }], container, type) => {
  if (container) {
    options.forEach((option) => {
      container.innerHTML += `<li><a href="${lang}/buscar/${type}/${get_alias(
        option.title
      )}/${option.id}">${option.title}</a></li>`;
    });
  }
};
async function initializeFilters() {
  edades = await getEdades(); // Espera a que getEdades() se resuelva
  asignaturas = await getAsignaturas(); // Espera a que getEdades() se resuelva
  addOptionsToFilters(
    edades,
    document.querySelector("#clasificacion"),
    "clasificacion"
  );
  addOptionsToFilters(
    asignaturas,
    document.querySelector("#asignaturas"),
    "asignatura"
  );
}
document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("#openSearch")) {
    document.querySelector("#openSearch").addEventListener("click", () => {
      document.querySelectorAll("header .left nav a span").forEach((el, i) => {
        if (i > 0) {
          el.style.display = "none";
        }
      });
      document.querySelector(".search-comp").classList.toggle("active");
    });
  }
  if (windowWidth < 768 && document.querySelector(".home main .banner video")) {
    document
      .querySelector(".home main .banner video")
      .setAttribute(
        "poster",
        document.querySelector(".home main .banner video").dataset.postermobile
      );
  }
  initializeFilters();
  cargarJSON("../../data_static.json");
  Fancybox.bind("[data-fancybox]", {});
  getCiclosInfo();
  getLoMasVisto();
  getAP();
  lazyImages();
  getCiclos();
  getCicloMovies();
  getTotemsByMovie();
});

if (document.querySelector("body.search")) {
  document.querySelector(".search-comp").classList.add("active");
}

function changeTab(tabActive, event) {
  document.querySelector(`.tab.tab-active`).classList.remove("tab-active");
  document.querySelector(`#${tabActive}`).classList.add("tab-active");
  document
    .querySelector(".bottom-line .container nav button.active")
    .classList.remove("active");
  event.target.classList.add("active");
}

async function getCiclos(year = new Date().getFullYear()) {
  document
    .querySelectorAll(".ciclos section .filter-year button")
    .forEach((btn) => {
      if (btn.classList.contains("active")) {
        btn.classList.remove("active");
      }
      if (btn.innerText == year) {
        btn.classList.add("active");
      }
    });
  if (document.querySelector(".ciclos")) {
    document.querySelector(".ciclos-list").innerHTML = "";
    const response = await fetch(`${lang}/g/getCiclos/?year=${year}`);
    const ciclos = await response.json();
    ciclos.response.forEach((ciclo) => {
      let template = `<li><a href="${lang}/ciclos/${get_alias(
        ciclo.title.rendered
      )}-${ciclo.id}"><div class="image"><img data-src="${
        ciclo.acf.imagen_principal_el_ciclo
      }" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" alt="${
        ciclo.title.rendered
      }"></div><div class="info"><h2>${ciclo.title.rendered}</h2><small>${
        ciclo.acf.mes_del_ciclo
      } ${ciclo.acf.ano_del_ciclo}</small></div></a></li>`;
      document.querySelector(".ciclos-list").innerHTML += template;
    });
    lazyImages();
    document.querySelectorAll("a").forEach((links) => {
      if (
        !links.hasAttribute("target") &&
        !links.hasAttribute("data-fancybox")
      ) {
        links.addEventListener("click", () => {
          console.log("click");
          fadeIn(preloader);
        });
      }
    });
  }
  if (document.querySelector(".ciclo")) {
    document.querySelector(".ciclos-list").innerHTML = "";
    const response = await fetch(`${lang}/g/getCiclos/?year=${year}`);
    const ciclos = await response.json();
    let moreciclos = ciclos.response.filter(
      (ciclo) => ciclo.id != document.querySelector("main").dataset.cicloid
    );
    if (moreciclos.length > 0) {
      moreciclos.forEach((ciclo) => {
        let template = `<li><a href="${lang}/ciclos/${get_alias(
          ciclo.title.rendered
        )}-${ciclo.id}"><div class="image"><img data-src="${
          ciclo.acf.imagen_principal_el_ciclo
        }" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" alt="${
          ciclo.title.rendered
        }"></div><div class="info"><h2>${ciclo.title.rendered}</h2><small>${
          ciclo.acf.mes_del_ciclo
        } ${ciclo.acf.ano_del_ciclo}</small></div></a></li>`;
        document.querySelector(".ciclos-list").innerHTML += template;
      });
    } else {
      document.querySelector(".ciclosrel").style.display = "none";
    }
    lazyImages();
  }
}

async function getCicloMovies() {
  if (document.querySelector(".ciclo")) {
    let peliculas_del_ciclo = JSON.parse(
      document.querySelector("main").dataset.movies
    );
    const response = await fetch(`${lang}/g/getMovies/`, {
      body: JSON.stringify(peliculas_del_ciclo.map(String)),
      method: "POST",
    });
    movies = await response.json();
    document.querySelector(".movies").innerHTML = "";
    movies.forEach((movie) => {
      let theme = false;
      if (
        movie.related_cinescuela_ap ||
        movie.related_cinescuela_ap.length > 0
      ) {
        let acomp =
          movie.related_cinescuela_ap.length > 0
            ? movie.related_cinescuela_ap[0]
            : movie.related_cinescuela_ap;
        if (acomp.acf_fields) {
          theme = acomp.acf_fields.presentaciones.tema_light;
        }
      }
      let {
        id,
        title: { rendered: titleRendered },
        acf: { afiche },
      } = movie;
      const movieElement = document.createElement("li");
      let link = `${lang}/pelicula/${get_alias(titleRendered)}-${id}`;
      movieElement.classList.add("afiche-movie");
      movieElement.innerHTML = `<a href="javascript:;" data-fancybox data-src="#dialog-content" data-temalight="${theme}"><img data-src="${afiche}" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" /></a>`;
      movieElement.addEventListener("click", () => getInfoMovie(movie));

      document.querySelector(`.movies`).appendChild(movieElement);
    });
    lazyImages();
  }
}

const getTotemsByMovie = async () => {
  if (document.querySelector(".intern")) {
    const response = await fetch(`${lang}/g/getTotems/`, {
      body: JSON.stringify({
        movieid: document.querySelector("main").dataset.movieid,
      }),
      method: "POST",
    });
    let totemsResponse = await response.json();
    let totems = totemsResponse.response;

    // Obtener el elemento de la barra de progreso
    let progressBar = document.getElementById("progress-bar");

    totems.forEach((totem) => {
      // Calcular la posición del totem en píxeles
      let position =
        (totem.acf.tiempo / progressBar.max) * progressBar.offsetWidth;

      // Crear el elemento <a> del totem
      let totemElement = document.createElement("a");
      totemElement.href = totem.acf.link;
      totemElement.className = "single-totem";
      totemElement.setAttribute("speech-bubble", "");
      totemElement.setAttribute("pbottom", "");
      totemElement.setAttribute("aleft", "");
      totemElement.setAttribute("target", "_blank");

      // Crear la imagen del totem
      let imgElement = document.createElement("img");
      imgElement.src = totem.acf.imagen;
      imgElement.alt = totem.title.rendered;

      // Crear el párrafo del totem
      let pElement = document.createElement("p");
      pElement.textContent = totem.title.rendered;

      // Añadir la imagen y el párrafo al elemento <a>
      totemElement.appendChild(imgElement);
      totemElement.appendChild(pElement);

      // Establecer la posición del totem
      totemElement.style.left = `${position}px`;

      // Añadir el totem al contenedor de la línea de tiempo
      document.querySelector(".video-progress").appendChild(totemElement);
    });
  }
};
