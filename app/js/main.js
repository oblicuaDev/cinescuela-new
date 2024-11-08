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
    let ciclo;
    if (!ciclo || ciclo.id != cicloID) {
      const responseCiclo = await fetch(`${lang}/g/getCiclos/?id=${cicloID}`);
      ciclo = await responseCiclo.json();
      // setWithExpiry("cicloGuardado", ciclo, 7 * 24 * 60 * 60 * 1000); // 7 días en milisegundos
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
              : `<span class="title-movie">${movie.title.rendered}</span>`
          }
          ${
            movie.acf.preview_corto
              ? `<video class="hover-video"  loop preload="auto" poster="${movie.acf.miniatura_del_trailer}"><source src="${movie.acf.preview_corto}" type="video/mp4">Your browser does not support the video tag.</video>`
              : ``
          }
        </a>`;

      if (movie.acf.preview_corto && movie.acf.preview_corto != "") {
        let video = movieElement.querySelector(".hover-video");
        if (video) {
          movieElement.classList.add("has-video");
          video.addEventListener("canplaythrough", () => {
            movieElement.addEventListener("mouseenter", () => {
              video.volume = 0.04;
              video.play();
            });

            movieElement.addEventListener("mouseleave", () => {
              video.pause();
              video.currentTime = 0;
            });
          });
          // Preload the video by loading its data
          video.load();
        }
      }
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
    let movies;

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
      // setWithExpiry("lomasvistomovies", movies, 7 * 24 * 60 * 60 * 1000); // 7 días en milisegundos
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
            title: { rendered: asignatura.title.rendered },
          }))
        )
      );
      localStorage.setItem(
        "datagetTemaIds",
        JSON.stringify(
          datagetTemas.map((tema) => ({
            id: tema.id,
            title: { rendered: tema.title.rendered },
          }))
        )
      );
    }

    // Obtener dos IDs aleatorios de cada arreglo
    const randomAsignaturaIds = getRandomElements(datagetAsignaturas, 2);
    const randomTemaIds = getRandomElements(datagetTemas, 2);

    // Actualizar el contenido de los elementos del DOM
    document.querySelector("#asignatura-line1 h3").innerHTML =
      randomAsignaturaIds[0].title.rendered;
    document.querySelector("#tema-line1 h3").innerHTML =
      randomTemaIds[0].title.rendered;
    document.querySelector("#asignatura-line2 h3").innerHTML =
      randomAsignaturaIds[1].title.rendered;
    document.querySelector("#tema-line2 h3").innerHTML =
      randomTemaIds[1].title.rendered;

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

        // Contar las películas que cumplen con la condición
        const filteredMovies = movies.filter((movie) =>
          moviesProfileUser.includes(movie.id)
        );

        // Esconder el contenedor si el total es 0
        if (filteredMovies.length === 0) {
          containerElement.closest(container).style.display = "none";
          return;
        } else {
          containerElement.closest(container).style.display = "block";
        }

        // Añadir las películas al contenedor
        filteredMovies.forEach((movie, i) => {
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
                  : `<span class="title-movie">${movie.title.rendered}</span>`
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
    grupo_de_ed,
    title: { rendered: titleRendered },
    content: { rendered: contentRendered },
    acf: {
      director_pelicula,
      pais_pelicula,
      duracion_en_minutos,
      imagen_pelicula,
      logo_de_la_pelicula,
      palabras_clave_de_esta_publicacion,
      tiene_acompanamiento,
    },
  } = movie;
  console.log(movie);

  // Precargar imágenes
  document.querySelector("#dialog-content .sinopsis").innerHTML =
    contentRendered;
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
  if (document.querySelector(".ap.cinescuela-app")) {
    document.querySelector(
      "#dialog-content .actions"
    ).innerHTML = `<a class="btn btn-primary" href="${lang}/acompanamiento-pedagogico/${get_alias(
      titleRendered
    )}-${id}">Ir al acompañamiento</a>`;
  } else {
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
    )}-${id}">Reproducir película</a>
    `;
    if (tiene_acompanamiento) {
      document.querySelector(
        "#dialog-content .actions"
      ).innerHTML += `<a class="btn btn-secondary" href="${lang}/pelicula/${get_alias(
        titleRendered
      )}-${id}?activeTeaching=1">Activar Modo Pedagógico</a>`;
    }
    document.querySelector(
      "#dialog-content .actions"
    ).innerHTML += `<span class="age ${
      grupo_de_ed ? grupo_de_ed[0].forma : ``
    }">${grupo_de_ed ? grupo_de_ed[0].post_title : ``}</span>`;
    document
      .querySelector("#dialog-content .actions")
      .style.setProperty(
        "--form-color",
        grupo_de_ed ? grupo_de_ed[0].color : ``
      );
  }

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
    console.log(data);
    if (data) {
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
        data.slug
      )}-${idAPMovie}?tabactive=lenguaje"><span class="title">Lenguaje</span><div class="content"><img loading="lazy" class="lazyload" src="https://placehold.co/720x378/037A19/FFFFFF" data-src="${
        data.acf.seccion_pelicula.actividad_1.imagen
      }" alt="${
        data.acf.seccion_pelicula.actividad_1.titulo
      }"><p>${acortarTextoEnriquecido(
        data.acf.seccion_pelicula.actividad_1.descripcion,
        200
      )}</p><small>Ver más</small></div></a>
        <a href="${lang}/acompanamiento-pedagogico/${get_alias(
        data.slug
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
    const response = await fetch(`/${lang}/g/getEdades/?id=${id}`);
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
    const response = await fetch(`/${lang}/g/getAsignaturas/?id=${id}`);
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
const addOptionsToFilters = (options = [{ id, title }], container, type) => {
  if (container) {
    options.forEach((option) => {
      container.innerHTML += `<li><a href="${lang}/buscar/${type}/${get_alias(
        option.title
      )}/${
        option.id
      }" onclick="ga("send", "event", "Filtro películas", "click", ${
        option.title
      });">${option.title}</a></li>`;
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
function getMoreMovies() {
  const container = document.getElementById("movie-container");
  const sentinel = document.getElementById("sentinel");
  if (container) {
    let currentPage = 1;

    const loadMovies = async (page) => {
      try {
        const response = await fetch(`${lang}/g/getMovies/?page=${page}`);
        const movies = await response.json();

        movies.forEach((movie) => {
          let theme = false;

          const acomp =
            movie.related_cinescuela_ap?.[0] || movie.related_cinescuela_ap;
          if (acomp?.acf_fields?.presentaciones?.tema_light) {
            theme = acomp.acf_fields.presentaciones.tema_light;
          }

          let logo =
            movie.acf.logo_de_la_pelicula && movie.acf.logo_de_la_pelicula != ""
              ? `<img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20" data-src="${movie.acf.logo_de_la_pelicula}" alt="Logo Pelicula">`
              : `<span class="title-movie">${movie.title.rendered}</span>`;

          const listItem = document.createElement("li");
          listItem.addEventListener("click", () => getInfoMovie(movie));

          listItem.innerHTML = `
            <a href="javascript:;" data-fancybox="" data-src="#dialog-content" data-temalight="${theme}">
             ${
               movie.acf.acompanamiento_pedagogico_privado == false
                 ? `   <div class="corner-ribbon"><span>Acceso libre</span></div>`
                 : ""
             }
              <picture>
                <source media="(max-width: 1023px)" srcset="${
                  movie.acf.afiche
                }">
                <img src="${movie.acf.imagen_pelicula}" alt="${
            movie.title.rendered
          }" id="logo">
              </picture>
             ${logo}
            </a>
          `;

          container.appendChild(listItem);
        });

        lazyImages();
      } catch (error) {
        console.error("Error al cargar las películas:", error);
      }
    };

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            if (currentPage < totalPages) {
              currentPage++;
              loadMovies(currentPage);
            } else {
              document.querySelector(".loader").style.display = "none";
            }
          }
        });
      },
      {
        rootMargin: "0px",
        threshold: 1.0,
      }
    );

    observer.observe(sentinel);
  }
}
async function getFavoritesMovies() {
  const container = document.querySelector(".movies-list-favorites");
  const favorites = localStorage.getItem("favoriteMovies");
  let favoritesJSON = favorites ? JSON.parse(favorites) : [];
  if (favoritesJSON.length > 0) {
    document.querySelector(".emptyList").style.display = "none";
    if (container) {
      favoritesJSON.forEach((movie) => {
        let theme = false;

        const acomp =
          movie.related_cinescuela_ap?.[0] || movie.related_cinescuela_ap;
        if (acomp?.acf_fields?.presentaciones?.tema_light) {
          theme = acomp.acf_fields.presentaciones.tema_light;
        }

        let logo =
          movie.acf.logo_de_la_pelicula && movie.acf.logo_de_la_pelicula != ""
            ? `<img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20" data-src="${movie.acf.logo_de_la_pelicula}" alt="Logo Pelicula">`
            : `<span class="title-movie">${movie.title.rendered}</span>`;

        const listItem = document.createElement("li");
        listItem.addEventListener("click", () => getInfoMovie(movie));

        listItem.innerHTML = `
          <a href="javascript:;" data-fancybox="" data-src="#dialog-content" data-temalight="${theme}">
            <picture>
              <source media="(max-width: 1023px)" srcset="${movie.acf.afiche}">
              <img src="${movie.acf.imagen_pelicula}" alt="${movie.title.rendered}" id="logo">
            </picture>
            ${logo}
          </a>
        `;

        container.appendChild(listItem);
      });

      lazyImages();
    }
  }
}
document.addEventListener("DOMContentLoaded", function () {
  if (
    document.querySelector("#openSearch") ||
    document.querySelector("#openSearchMobile")
  ) {
    document.querySelector("#openSearch").addEventListener("click", () => {
      document.querySelectorAll("header .left nav a span").forEach((el, i) => {
        if (i > 0) {
          el.style.display = "none";
        }
      });
      document.querySelector(".search-comp").classList.toggle("active");
      document.querySelector("#search-input").focus();
    });
    document
      .querySelector("#openSearchMobile")
      .addEventListener("click", () => {
        document
          .querySelectorAll("header .left nav a span")
          .forEach((el, i) => {
            if (i > 0) {
              el.style.display = "none";
            }
          });
        document.querySelector(".search-comp").classList.toggle("active");
        document.querySelector("#search-input").focus();
      });
  }
  if (window.innerWidth < 768) {
    if (document.querySelector("#search")) {
      document
        .querySelector("#search")
        .addEventListener("click", () =>
          document.querySelector(".search-comp").classList.toggle("active")
        );
    }
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
  Fancybox.bind("[data-fancybox]", {});
  getCiclosInfo();
  getLoMasVisto();
  getAP();
  lazyImages();
  getCicloMovies();
  getTotemsByMovie();
  getMoreMovies();
  getFavoritesMovies();
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

async function obtenerAniosDisponibles() {
  // Verificar si los datos están en localStorage
  let aniosDisponibles = localStorage.getItem("aniosDisponibles");

  if (aniosDisponibles) {
    return JSON.parse(aniosDisponibles);
  }

  // Seleccionar solo el primer conjunto de botones dentro de la clase 'filter-year'
  const botonesAnios = document.querySelectorAll(
    ".filter-year:first-of-type button"
  );
  const aniosPromises = [];

  botonesAnios.forEach((btn) => {
    const year = btn.innerText;
    aniosPromises.push(
      fetch(`${lang}/g/getCiclos/?year=${year}`).then((response) =>
        response.json()
      )
    );
  });

  const resultados = await Promise.all(aniosPromises);

  aniosDisponibles = resultados
    .map((ciclos, index) => {
      if (ciclos.response.length > 0) {
        return parseInt(botonesAnios[index].innerText);
      }
      return null;
    })
    .filter((year) => year !== null);

  // Guardar los años disponibles en localStorage
  localStorage.setItem("aniosDisponibles", JSON.stringify(aniosDisponibles));
  return aniosDisponibles;
}

async function actualizarBotonesAnios() {
  const aniosDisponibles = await obtenerAniosDisponibles();
  const botones = document.querySelectorAll(".filter-year button");

  botones.forEach((btn) => {
    if (!aniosDisponibles.includes(parseInt(btn.innerText))) {
      btn.style.display = "none";
    } else {
      btn.style.display = "inline-block";
    }
  });
}

// Cache para almacenar las respuestas de ciclos por año
const cacheCiclos = {};

async function getCiclos(year = new Date().getFullYear()) {
  // Activar el botón correspondiente
  const botonesAnios = document.querySelectorAll(".filter-year button");
  botonesAnios.forEach((btn) => {
    btn.classList.toggle("active", btn.innerText == year);
  });

  // Verificar si el contenedor "ciclos" está presente en la página
  if (document.querySelector(".ciclos")) {
    document.querySelector(
      ".ciclos-list"
    ).innerHTML = `<li class="skeleton"><a href=""><div class="image"></div><div class="info"></div></a></li><li class="skeleton"><a href=""><div class="image"></div><div class="info"></div></a></li><li class="skeleton"><a href=""><div class="image"></div><div class="info"></div></a></li><li class="skeleton"><a href=""><div class="image"></div><div class="info"></div></a></li>`;

    // Verificar en la caché antes de hacer la solicitud
    if (!cacheCiclos[year]) {
      const response = await fetch(`${lang}/g/getCiclos/?year=${year}`);
      const ciclos = await response.json();
      cacheCiclos[year] = ciclos; // Guardar la respuesta en la caché
    }

    const ciclos = cacheCiclos[year]; // Obtener los ciclos desde la caché
    const ciclosList = document.querySelector(".ciclos-list");
    document.querySelector(".ciclos-list").innerHTML = "";
    // Añadir ciclos a la lista
    ciclos.response.forEach((ciclo) => {
      let template = `
        <li>
          <a href="${lang}/ciclos/${get_alias(ciclo.title.rendered)}-${
        ciclo.id
      }" onClick="ga('send', 'event', 'Ciclos', 'click','${
        ciclo.title.rendered
      }')">
            <div class="image">
              <img data-src="${
                ciclo.acf.imagen_principal_el_ciclo
              }" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" alt="${
        ciclo.title.rendered
      }">
            </div>
            <div class="info">
              <h2>${ciclo.title.rendered}</h2>
              <small>${ciclo.acf.mes_del_ciclo} ${
        ciclo.acf.ano_del_ciclo
      }</small>
            </div>
          </a>
        </li>`;
      ciclosList.innerHTML += template;
    });

    lazyImages();
    document.querySelectorAll("a").forEach((links) => {
      if (
        !links.hasAttribute("target") &&
        !links.hasAttribute("data-fancybox")
      ) {
        links.addEventListener("click", () => {
          fadeIn(preloader);
        });
      }
    });
  }

  // Verificar si el contenedor "ciclo" está presente en la página
  if (document.querySelector(".ciclo")) {
    document.querySelector(".ciclos-list").innerHTML = "";

    // Verificar en la caché antes de hacer la solicitud
    if (!cacheCiclos[year]) {
      const response = await fetch(`${lang}/g/getCiclos/?year=${year}`);
      const ciclos = await response.json();
      cacheCiclos[year] = ciclos; // Guardar la respuesta en la caché
    }

    const ciclos = cacheCiclos[year]; // Obtener los ciclos desde la caché
    const moreciclos = ciclos.response.filter(
      (ciclo) => ciclo.id != document.querySelector("main").dataset.cicloid
    );

    if (moreciclos.length > 0) {
      moreciclos.forEach((ciclo) => {
        let template = `
          <li>
            <a href="${lang}/ciclos/${get_alias(ciclo.title.rendered)}-${
          ciclo.id
        }" onClick="ga('send', 'event', 'Ciclos', 'click','${
          ciclo.title.rendered
        }')">
              <div class="image">
                <img data-src="${
                  ciclo.acf.imagen_principal_el_ciclo
                }" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" alt="${
          ciclo.title.rendered
        }">
              </div>
              <div class="info">
                <h2>${ciclo.title.rendered}</h2>
                <small>${ciclo.acf.mes_del_ciclo} ${
          ciclo.acf.ano_del_ciclo
        }</small>
              </div>
            </a>
          </li>`;
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
const video = document.querySelector(
  ".intern.cinescuela-app .video-container video"
);
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
    let progressBar = document.getElementById("progress-bar");

    totems.forEach((totem) => {
      let position =
        (totem.acf.tiempo / progressBar.max) * progressBar.offsetWidth;

      let totemElement = document.createElement("a");
      totemElement.href = totem.acf.link;
      totemElement.className = "single-totem";
      totemElement.setAttribute("speech-bubble", "");
      totemElement.setAttribute("pbottom", "");
      totemElement.setAttribute("aleft", "");
      totemElement.setAttribute("target", "_blank");
      totemElement.setAttribute("id", `totem-${totem.id}`);

      let imgElement = document.createElement("img");
      imgElement.src = totem.acf.imagen;
      imgElement.alt = totem.title.rendered;

      let pElement = document.createElement("p");
      pElement.textContent = totem.title.rendered;

      totemElement.appendChild(imgElement);
      totemElement.appendChild(pElement);

      const totemMark = document.createElement("div");
      totemMark.classList.add("totem-mark");
      totemMark.title = totem.title.rendered;
      totemMark.dataset.totemid = `totem-${totem.id}`;
      totemMark.style.left = `${position}px`;
      document.querySelector(".video-progress").appendChild(totemMark);
      totemMark.appendChild(totemElement);

      totemMark.addEventListener("mouseenter", () => {
        totemMark.querySelector(".single-totem").classList.add("active");
      });

      totemMark
        .querySelector(".single-totem")
        .addEventListener("mouseleave", () => {
          totemMark.querySelector(".single-totem").classList.remove("active");
        });
    });

    video.addEventListener("timeupdate", updateProgress);

    function updateProgress() {
      updateActiveTotems();
    }

    function updateActiveTotems() {
      totems.forEach((totem) => {
        let totemElement = document.getElementById(`totem-${totem.id}`);
        if (
          video.currentTime >= totem.acf.tiempo &&
          video.currentTime < parseInt(totem.acf.tiempo) + 10
        ) {
          totemElement.classList.add("active");
          document.querySelector(".video-controls").classList.remove("hidden");
          setTimeout(() => {
            document.querySelector(".video-controls").classList.add("hidden");
          }, 10000);
        } else {
          totemElement.classList.remove("active");
        }
      });
    }
  }
};
let activeTotemstest = false;
function activeTotems() {
  document.querySelector("#active-totems").classList.toggle("active");
  document.querySelector("#active-totems").dataset.title = activeTotemstest
    ? "Desactivar Totems"
    : "Activar Totems";
  document.querySelector(".video-controls").classList.toggle("activeTotems");
  activeTotemstest = !activeTotemstest;
}

const modal = document.getElementById("tourModal");
const closeBtn = document.querySelector(".close");
const tourContent = document.getElementById("tourContent");
let currentStep = 0;

function replaceUrl(url) {
  // Obtenemos la parte de la URL después del dominio
  const urlObj = new URL(url);
  let path = urlObj.pathname;

  // Quitamos '/wp-content/uploads/' del path
  path = path.replace("/wp-content/uploads/", "/");

  // Reemplazamos la parte de la URL con 'files.cinescuela.org'
  const newUrl = "https://files.cinescuela.org" + path;

  return newUrl;
}
// Orden ascendente: false antes que true
steps.sort((a, b) => a.acf.orden_para_mostrar - b.acf.orden_para_mostrar);
function renderStep(index) {
  const step = steps[index];
  tourContent.innerHTML = `
            <div class="tour-step">
            ${
              step.acf.media
                ? `<div class="tour-media">
              ${
                step.acf.media.type == "video"
                  ? ` <video autoplay muted loop src="${replaceUrl(
                      step.acf.media.url
                    )}">
                <source
                    src="${replaceUrl(step.acf.media.url)}"
                    type="video/mp4">
            </video>`
                  : ""
              }</div>`
                : ""
            }
                <h2>${step.title.rendered}</h2>
                ${step.content.rendered}
                <div class="actions">
                ${
                  currentStep > 0
                    ? '<button id="prev" class="btn btn-secondary">Atrás</button>'
                    : ""
                }
                ${
                  currentStep <= steps.length - 1
                    ? `<button id="next" class="btn btn-primary">${
                        currentStep == steps.length - 1
                          ? "FInalizar"
                          : "Siguiente"
                      }</button>`
                    : ""
                }
                </div>
            </div>
        `;

  if (currentStep > 0) {
    document.getElementById("prev").addEventListener("click", function () {
      currentStep--;
      renderStep(currentStep);
    });
  }

  if (currentStep <= steps.length - 1) {
    document.getElementById("next").addEventListener("click", function () {
      if (currentStep == steps.length - 1) {
        closeModal();
      } else {
        currentStep++;
        renderStep(currentStep);
      }
    });
  }
}

function showModal() {
  modal.style.display = "flex";
  renderStep(currentStep);
}

function closeModal() {
  modal.style.display = "none";
  localStorage.setItem("tourComplete", true);
}

closeBtn.addEventListener("click", closeModal);

if (
  !localStorage.getItem("tourComplete") &&
  document.querySelector(".home.cinescuela-app")
) {
  showModal();
}

const modalBuzon = document.getElementById("buzonModal");
const closeBtnBuzon = document.querySelector("#buzonModal .close");
function closeModalBuzon() {
  modalBuzon.style.display = "none";
}
function openbs() {
  modalBuzon.style.display = "flex";
  closeBtnBuzon.addEventListener("click", closeModalBuzon);
}

const modalSugerencia = document.getElementById("wordsModal");
const closeBtnModalSugerencia = document.querySelector("#wordsModal .close");
function closeModalSugerencia() {
  modalSugerencia.style.display = "none";
}
function openModalSugerencia(type) {
  modalSugerencia.style.display = "flex";
  closeBtnModalSugerencia.addEventListener("click", closeModalSugerencia);
  // Keyword
  // Actividad complementaria
  // Recurso de cultura y sociedad
  document.querySelector("#type").value = type;
}

// Llamar a getCiclos cuando la página se carga con el año actual o el año activo si está disponible
document.addEventListener("DOMContentLoaded", async () => {
  if (document.querySelector(".ciclos")) {
    await actualizarBotonesAnios();
  }
  const activeYearButton = document.querySelector(".filter-year button.active");
  const year = activeYearButton
    ? activeYearButton.innerText
    : new Date().getFullYear();
  getCiclos(year);
});
