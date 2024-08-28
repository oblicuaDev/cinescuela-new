async function getMoviesMes() {
  if (document.querySelector(".home")) {
    let peliculas_del_mes = JSON.parse(
      document.querySelector("main").dataset.movies
    );
    let movies = getWithExpiry("moviesDelMes");

    if (!movies) {
      const response = await fetch(`${lang}/g/getMovies/`, {
        body: JSON.stringify(peliculas_del_mes.map(String)),
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });
      movies = await response.json();
      setWithExpiry("moviesDelMes", movies, 7 * 24 * 60 * 60 * 1000); // 7 días en milisegundos
    }
    if (window.innerWidth < 768) {
      // Configuración para Mobile
      document.querySelector(".home .peliculas-mes").innerHTML += `
        <!-- Slider main container -->
        <div class="swiper moviesSwiper">
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Aquí también puedes agregar las películas usando un loop -->
            ${movies
              .map(
                (movie) => `
              <div class="swiper-slide">
                <a href="${lang}/pelicula/${get_alias(movie.title.rendered)}-${
                  movie.id
                }">
                  <img loading="lazy" class="lazyload" src="https://picsum.photos/20/20" data-src="${
                    movie.acf.afiche
                  }" alt="Logo Pelicula">
                </a>
              </div>
            `
              )
              .join("")}
          </div>
          <!-- If we need pagination -->
          <div class="swiper-pagination"></div>
        </div>
      `;

      const swiper = new Swiper(".moviesSwiper", {
        slidesPerView: 1,
        pagination: {
          el: ".swiper-pagination",
        },
      });
    } else {
      movies.forEach((movie) => {
        let theme = false;

        const acomp =
          movie.related_cinescuela_ap?.[0] || movie.related_cinescuela_ap;
        if (acomp?.acf_fields?.presentaciones?.tema_light) {
          theme = acomp.acf_fields.presentaciones.tema_light;
        }
        let link = `${lang}/pelicula/${get_alias(movie.title.rendered)}-${
          movie.id
        }`;

        document.querySelector(".home .peliculas-mes").innerHTML += `
              <a href="${link}">
                <img loading="lazy" class="lazyload" src="https://picsum.photos/20/20" data-src="${movie.acf.afiche}" alt="Logo Pelicula">
              </a>`;
      });
    }

    lazyImages();

  
  }
}
const getCiclosInfo = async () => {
  const mainElement = document.querySelector("main");
  const cicloID = mainElement.dataset.ciclo;

  if (cicloID) {
    let ciclo = getWithExpiry("cicloGuardado");

    if (!ciclo || ciclo.id != cicloID) {
      const responseCiclo = await fetch(`${lang}/g/getCiclos/?id=${cicloID}`);
      ciclo = await responseCiclo.json();
      setWithExpiry("cicloGuardado", ciclo, 7 * 24 * 60 * 60 * 1000); // 7 días en milisegundos
    }
    document.querySelector(
      ".cicloHome .ciclo-mes"
    ).href = `${lang}/ciclos/${get_alias(ciclo.title.rendered)}-${ciclo.id}`;
    let template = `<img src="${ciclo.acf.imagen_principal_el_ciclo}" alt="${ciclo.title.rendered}"><div class="info"><h2>${ciclo.title.rendered}</h2><small>${ciclo.acf.mes_del_ciclo} ${ciclo.acf.ano_del_ciclo}</small>${ciclo.acf.descripcion_corta_del_ciclo}</div>`;
    document.querySelector(".cicloHome .ciclo-mes").innerHTML += template;
    lazyImages();
  }
};
async function getCiclos(year = new Date().getFullYear()) {
  if (document.querySelector(".ciclos-list")) {
    document.querySelector(
      ".ciclos-list"
    ).innerHTML = `<li class="skeleton"><a href="es/ciclos/el-buen-comer-22768"><div class="image"></div><div class="info"></div></a></li><li class="skeleton"><a href="es/ciclos/el-buen-comer-22768"><div class="image"></div><div class="info"></div></a></li>`;
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
      const response = await fetch(`${lang}/g/getCiclos/?year=${year}`);
      const ciclos = await response.json();
      document.querySelector(".ciclos-list").innerHTML = ``;

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
            fadeIn(preloader);
          });
        }
      });
    }
    if (document.querySelector(".ciclo")) {
      const response = await fetch(`${lang}/g/getCiclos/?year=${year}`);
      const ciclos = await response.json();
      document.querySelector(".ciclos-list").innerHTML = "";
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
}
async function getMovieCiclos() {
  let movieId = document.querySelector("main").dataset.movieid;
  if (movieId) {
    document.querySelector(
      ".ciclos-list"
    ).innerHTML = `<li class="skeleton"><a href="es/ciclos/el-buen-comer-22768"><div class="image"></div><div class="info"></div></a></li><li class="skeleton"><a href="es/ciclos/el-buen-comer-22768"><div class="image"></div><div class="info"></div></a></li>`;
    const response = await fetch(`${lang}/g/getCiclos/?movie=${movieId}`);
    const ciclos = await response.json();
    document.querySelector(".ciclos-list").innerHTML = "";
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
    let peliculas_del_ciclo = JSON.parse(document.querySelector("main").dataset.movies);
    const response = await fetch(`${lang}/g/getMovies/`, {
      body: JSON.stringify(peliculas_del_ciclo.map(String)),
      method: "POST",
    });
    let movies = await response.json();
    
    // Detectar si la pantalla es móvil
    const isMobile = window.innerWidth <= 768;

    // Limpiar el contenido actual
    document.querySelector(".movies").innerHTML = "";

    // Si estamos en móvil, creamos el contenedor de Swiper
    if (isMobile) {
      document.querySelector(".movies").outerHTML = `
        <div class="swiper moviesSwiper">
          <div class="swiper-wrapper">
            <!-- Los slides serán agregados dinámicamente aquí -->
          </div>
          <div class="swiper-pagination"></div>
        </div>
      `;
    }

    movies.forEach((movie) => {
      let theme = false;
      if (movie.related_cinescuela_ap || movie.related_cinescuela_ap.length > 0) {
        let acomp = movie.related_cinescuela_ap.length > 0
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
      let link = `${lang}/pelicula/${get_alias(titleRendered)}-${id}`;

      if (isMobile) {
        // Crear el slide para Swiper
        const slide = document.createElement("div");
        slide.classList.add("swiper-slide");
        slide.innerHTML = `<a href="${link}"><img data-src="${afiche}" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" /></a>`;
        slide.addEventListener("click", () => getInfoMovie(movie));
        document.querySelector(".moviesSwiper .swiper-wrapper").appendChild(slide);
      } else {
        // Crear el elemento de lista para pantallas más grandes
        const movieElement = document.createElement("li");
        movieElement.classList.add("afiche-movie");
        movieElement.innerHTML = `<a href="${link}"><img data-src="${afiche}" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" /></a>`;
        movieElement.addEventListener("click", () => getInfoMovie(movie));
        document.querySelector(".movies").appendChild(movieElement);
      }
    });

    // Inicializar Swiper solo si estamos en móvil
    if (isMobile) {
      const swiper = new Swiper('.moviesSwiper', {
        loop: true,
        slidesPerView: 1, // Puedes ajustar este valor según tus necesidades
        pagination: {
          el: '.swiper-pagination',
        }
      });
    }

    // Inicializar imágenes perezosas
    lazyImages();
  }
}

async function getMoviesRel() {
  if (document.querySelector(".movie")) {
    let peliculas = JSON.parse(document.querySelector("main").dataset.moviesrel);
    const response = await fetch(`${lang}/g/getMovies/`, {
      body: JSON.stringify(peliculas.map((pel) => pel.ID)),
      method: "POST",
    });
    let movies = await response.json();
    
    // Verificar si estamos en una pantalla móvil
    const isMobile = window.innerWidth <= 768;

    // Limpiar el contenido actual
    document.querySelector(".moviesRel ul").innerHTML = "";

    // Si estamos en móvil, creamos el contenedor de Swiper
    if (isMobile) {
      document.querySelector(".moviesRel ul").outerHTML = `
        <div class="swiper moviesSwiper">
          <div class="swiper-wrapper">
            <!-- Slides will be added here dynamically -->
          </div>
          <div class="swiper-pagination"></div>
        </div>
      `;
    }

    movies.forEach((movie) => {
      let theme = false;
      if (movie.related_cinescuela_ap || movie.related_cinescuela_ap.length > 0) {
        let acomp = movie.related_cinescuela_ap.length > 0
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
      let link = `${lang}/pelicula/${get_alias(titleRendered)}-${id}`;

      if (isMobile) {
        // Crear el slide para Swiper
        const slide = document.createElement("div");
        slide.classList.add("swiper-slide");
        slide.innerHTML = `<a href="${link}"><img data-src="${afiche}" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" /></a>`;
        slide.addEventListener("click", () => getInfoMovie(movie));
        document.querySelector(".moviesSwiper .swiper-wrapper").appendChild(slide);
      } else {
        // Crear el elemento de lista para desktop
        const movieElement = document.createElement("li");
        movieElement.classList.add("afiche-movie");
        movieElement.innerHTML = `<a href="${link}"><img data-src="${afiche}" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" /></a>`;
        movieElement.addEventListener("click", () => getInfoMovie(movie));
        document.querySelector(".moviesRel ul").appendChild(movieElement);
      }
    });

    // Inicializar Swiper solo si estamos en móvil
    if (isMobile) {
      const swiper = new Swiper('.moviesSwiper', {
        loop: true,
        slidesPerView: 1, // Puedes ajustar esto según tu diseño
        pagination: {
          el: '.swiper-pagination',
        }
      });
    }

    // Inicializar imágenes perezosas
    lazyImages();
  }
}

async function getNovedades() {
  if (document.querySelector(".novedades")) {
    let novedades = [];
    const response = await fetch(`${lang}/g/getNovedades/`);
    novedades = await response.json();
    novedades = novedades.response;

    document.querySelector(".novedades-list").innerHTML = "";
    novedades.forEach((post) => {
      let {
        id,
        title: { rendered },
        acf: { imagen, fecha_de_publicacion },
        categories_full,
      } = post;

      let nameCat = categories_full.map((category) => category.name);
      let idCat = categories_full.map((category) => category.id);
      let icon = ``;
      if (idCat != 10) {
        icon = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.125C6.20304 3.125 3.125 6.20304 3.125 10C3.125 13.797 6.20304 16.875 10 16.875C13.797 16.875 16.875 13.797 16.875 10C16.875 6.20304 13.797 3.125 10 3.125ZM1.875 10C1.875 5.51269 5.51269 1.875 10 1.875C14.4873 1.875 18.125 5.51269 18.125 10C18.125 14.4873 14.4873 18.125 10 18.125C5.51269 18.125 1.875 14.4873 1.875 10Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 7.5C2.30469 7.15482 2.58451 6.875 2.92969 6.875H17.0703C17.4155 6.875 17.6953 7.15482 17.6953 7.5C17.6953 7.84518 17.4155 8.125 17.0703 8.125H2.92969C2.58451 8.125 2.30469 7.84518 2.30469 7.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 12.5C2.30469 12.1548 2.58451 11.875 2.92969 11.875H17.0703C17.4155 11.875 17.6953 12.1548 17.6953 12.5C17.6953 12.8452 17.4155 13.125 17.0703 13.125H2.92969C2.58451 13.125 2.30469 12.8452 2.30469 12.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.36482 5.08638C7.83991 6.31204 7.5 8.04884 7.5 10C7.5 11.9512 7.83991 13.688 8.36482 14.9136C8.62775 15.5276 8.92479 15.9845 9.22279 16.2788C9.51811 16.5704 9.78004 16.6719 10 16.6719C10.22 16.6719 10.4819 16.5704 10.7772 16.2788C11.0752 15.9845 11.3722 15.5276 11.6352 14.9136C12.1601 13.688 12.5 11.9512 12.5 10C12.5 8.04884 12.1601 6.31204 11.6352 5.08638C11.3722 4.47243 11.0752 4.01555 10.7772 3.72123C10.4819 3.42957 10.22 3.32812 10 3.32812C9.78004 3.32812 9.51811 3.42957 9.22279 3.72123C8.92479 4.01555 8.62775 4.47243 8.36482 5.08638ZM8.34443 2.83186C8.79684 2.38505 9.35702 2.07812 10 2.07812C10.643 2.07812 11.2032 2.38505 11.6556 2.83186C12.1053 3.27604 12.4817 3.88775 12.7842 4.59428C13.3904 6.00957 13.75 7.92121 13.75 10C13.75 12.0788 13.3904 13.9904 12.7842 15.4057C12.4817 16.1122 12.1053 16.724 11.6556 17.1681C11.2032 17.615 10.643 17.9219 10 17.9219C9.35702 17.9219 8.79684 17.615 8.34443 17.1681C7.89469 16.724 7.51834 16.1122 7.21576 15.4057C6.60964 13.9904 6.25 12.0788 6.25 10C6.25 7.92121 6.60964 6.00957 7.21576 4.59428C7.51834 3.88775 7.89469 3.27604 8.34443 2.83186Z" fill="white"/></svg>`;
      } else {
        icon = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.25 14.375C16.5952 14.375 16.875 14.0952 16.875 13.75V5C16.875 4.65482 16.5952 4.375 16.25 4.375L3.75 4.375C3.40482 4.375 3.125 4.65482 3.125 5L3.125 13.75C3.125 14.0952 3.40482 14.375 3.75 14.375L16.25 14.375ZM18.125 13.75C18.125 14.7855 17.2855 15.625 16.25 15.625L3.75 15.625C2.71447 15.625 1.875 14.7855 1.875 13.75V5C1.875 3.96447 2.71447 3.125 3.75 3.125L16.25 3.125C17.2855 3.125 18.125 3.96447 18.125 5V13.75Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.875 17.5C6.875 17.1548 7.15482 16.875 7.5 16.875H12.5C12.8452 16.875 13.125 17.1548 13.125 17.5C13.125 17.8452 12.8452 18.125 12.5 18.125H7.5C7.15482 18.125 6.875 17.8452 6.875 17.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1.875 11.875C1.875 11.5298 2.15482 11.25 2.5 11.25H17.5C17.8452 11.25 18.125 11.5298 18.125 11.875C18.125 12.2202 17.8452 12.5 17.5 12.5H2.5C2.15482 12.5 1.875 12.2202 1.875 11.875Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10 14.375C10.3452 14.375 10.625 14.6548 10.625 15V17.5C10.625 17.8452 10.3452 18.125 10 18.125C9.65482 18.125 9.375 17.8452 9.375 17.5V15C9.375 14.6548 9.65482 14.375 10 14.375Z" fill="white"/></svg>`;
      }
      document.querySelector(`.novedades-list`).innerHTML += `
      <a href="${lang}/informacion/${get_alias(rendered)}-${id}">
      <div class="image">
      <img data-src="${imagen}" loading="lazy" class="lazyload" src="https://picsum.photos/20/20" />
      <div class="badge">
      ${icon}
      <span>${nameCat}</span>
      <span>${fecha_de_publicacion}</span>
      </div>
      </div>
      ${rendered}
      </a>`;
    });
    lazyImages();
  }
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
        movies.sort(
          (a, b) =>
            b.acf.acompanamiento_pedagogico_privado -
            a.acf.acompanamiento_pedagogico_privado
        );

        movies.forEach((movie) => {
          let theme = false;

          const acomp =
            movie.related_cinescuela_ap?.[0] || movie.related_cinescuela_ap;
          if (acomp?.acf_fields?.presentaciones?.tema_light) {
            theme = acomp.acf_fields.presentaciones.tema_light;
          }
          let link = `${lang}/pelicula/${get_alias(movie.title.rendered)}-${
            movie.id
          }`;
          let logo =
            movie.acf.logo_de_la_pelicula && movie.acf.logo_de_la_pelicula != ""
              ? `<img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20" data-src="${movie.acf.logo_de_la_pelicula}" alt="Logo Pelicula">`
              : `<span class="title-movie">${movie.title.rendered}</span>`;
          container.innerHTML += `<li ><a href="${link}" data-temalight="${theme}">
          ${
            movie.acf.acompanamiento_pedagogico_privado == false
              ? `   <div class="corner-ribbon"><span>Acceso libre</span></div>`
              : ""
          }
         
          <picture>
              <source media="(max-width: 1023px)" srcset="${movie.acf.afiche}">
              <img src="${movie.acf.imagen_pelicula}" alt="${
            movie.title.rendered
          }" id="logo">
          </picture>
          ${logo}</a></li>`;
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
function getMoreNews() {
  const container = document.querySelector(".novedadesPage .novedades-list");
  const sentinel = document.getElementById("sentinel");
  if (container) {
    let currentPage = 1;

    const loadMovies = async (page) => {
      try {
        const response = await fetch(`${lang}/g/getAllNovedades/?page=${page}`);
        const novedades = await response.json();

        novedades.forEach((novedad) => {
          let theme = false;

          const acomp =
            novedad.related_cinescuela_ap?.[0] || novedad.related_cinescuela_ap;
          if (acomp?.acf_fields?.presentaciones?.tema_light) {
            theme = acomp.acf_fields.presentaciones.tema_light;
          }
          let nameCat = novedad.categories_full.map(
            (category) => category.name
          );
          let idCat = novedad.categories_full.map((category) => category.id);
          let icon = ``;
          if (idCat != 10) {
            icon = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.125C6.20304 3.125 3.125 6.20304 3.125 10C3.125 13.797 6.20304 16.875 10 16.875C13.797 16.875 16.875 13.797 16.875 10C16.875 6.20304 13.797 3.125 10 3.125ZM1.875 10C1.875 5.51269 5.51269 1.875 10 1.875C14.4873 1.875 18.125 5.51269 18.125 10C18.125 14.4873 14.4873 18.125 10 18.125C5.51269 18.125 1.875 14.4873 1.875 10Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 7.5C2.30469 7.15482 2.58451 6.875 2.92969 6.875H17.0703C17.4155 6.875 17.6953 7.15482 17.6953 7.5C17.6953 7.84518 17.4155 8.125 17.0703 8.125H2.92969C2.58451 8.125 2.30469 7.84518 2.30469 7.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 12.5C2.30469 12.1548 2.58451 11.875 2.92969 11.875H17.0703C17.4155 11.875 17.6953 12.1548 17.6953 12.5C17.6953 12.8452 17.4155 13.125 17.0703 13.125H2.92969C2.58451 13.125 2.30469 12.8452 2.30469 12.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.36482 5.08638C7.83991 6.31204 7.5 8.04884 7.5 10C7.5 11.9512 7.83991 13.688 8.36482 14.9136C8.62775 15.5276 8.92479 15.9845 9.22279 16.2788C9.51811 16.5704 9.78004 16.6719 10 16.6719C10.22 16.6719 10.4819 16.5704 10.7772 16.2788C11.0752 15.9845 11.3722 15.5276 11.6352 14.9136C12.1601 13.688 12.5 11.9512 12.5 10C12.5 8.04884 12.1601 6.31204 11.6352 5.08638C11.3722 4.47243 11.0752 4.01555 10.7772 3.72123C10.4819 3.42957 10.22 3.32812 10 3.32812C9.78004 3.32812 9.51811 3.42957 9.22279 3.72123C8.92479 4.01555 8.62775 4.47243 8.36482 5.08638ZM8.34443 2.83186C8.79684 2.38505 9.35702 2.07812 10 2.07812C10.643 2.07812 11.2032 2.38505 11.6556 2.83186C12.1053 3.27604 12.4817 3.88775 12.7842 4.59428C13.3904 6.00957 13.75 7.92121 13.75 10C13.75 12.0788 13.3904 13.9904 12.7842 15.4057C12.4817 16.1122 12.1053 16.724 11.6556 17.1681C11.2032 17.615 10.643 17.9219 10 17.9219C9.35702 17.9219 8.79684 17.615 8.34443 17.1681C7.89469 16.724 7.51834 16.1122 7.21576 15.4057C6.60964 13.9904 6.25 12.0788 6.25 10C6.25 7.92121 6.60964 6.00957 7.21576 4.59428C7.51834 3.88775 7.89469 3.27604 8.34443 2.83186Z" fill="white"/></svg>`;
          } else {
            icon = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.25 14.375C16.5952 14.375 16.875 14.0952 16.875 13.75V5C16.875 4.65482 16.5952 4.375 16.25 4.375L3.75 4.375C3.40482 4.375 3.125 4.65482 3.125 5L3.125 13.75C3.125 14.0952 3.40482 14.375 3.75 14.375L16.25 14.375ZM18.125 13.75C18.125 14.7855 17.2855 15.625 16.25 15.625L3.75 15.625C2.71447 15.625 1.875 14.7855 1.875 13.75V5C1.875 3.96447 2.71447 3.125 3.75 3.125L16.25 3.125C17.2855 3.125 18.125 3.96447 18.125 5V13.75Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.875 17.5C6.875 17.1548 7.15482 16.875 7.5 16.875H12.5C12.8452 16.875 13.125 17.1548 13.125 17.5C13.125 17.8452 12.8452 18.125 12.5 18.125H7.5C7.15482 18.125 6.875 17.8452 6.875 17.5Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1.875 11.875C1.875 11.5298 2.15482 11.25 2.5 11.25H17.5C17.8452 11.25 18.125 11.5298 18.125 11.875C18.125 12.2202 17.8452 12.5 17.5 12.5H2.5C2.15482 12.5 1.875 12.2202 1.875 11.875Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10 14.375C10.3452 14.375 10.625 14.6548 10.625 15V17.5C10.625 17.8452 10.3452 18.125 10 18.125C9.65482 18.125 9.375 17.8452 9.375 17.5V15C9.375 14.6548 9.65482 14.375 10 14.375Z" fill="white"/></svg>`;
          }
          let link = `${lang}/informacion/${get_alias(
            novedad.title.rendered
          )}-${novedad.id}`;
          let logo =
            novedad.acf.logo_de_la_pelicula &&
            novedad.acf.logo_de_la_pelicula != ""
              ? `<img loading="lazy" class="lazyload movieLogo" src="https://picsum.photos/20/20" data-src="${movie.acf.logo_de_la_pelicula}" alt="Logo Pelicula">`
              : `<span class="title-movie">${novedad.title.rendered}</span>`;
          container.innerHTML += `<a href="${link}">
            <div class="image">
            <img data-src="${novedad.acf.imagen}" loading="lazy" class="lazyload" src="${novedad.acf.imagen}">
            <div class="badge">
            ${icon}
            <span>${nameCat}</span>
            <span>${novedad.acf.fecha_de_publicacion}</span>
            </div>
            </div>
           ${novedad.title.rendered}
            </a>`;
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

document.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector("#openSearch")) {
    document.querySelector("#openSearch").addEventListener("click", () => {
      document.querySelectorAll("header .left nav a span").forEach((el, i) => {
        if (i > 0) {
          el.style.display = "none";
        }
      });
      document.querySelector(".search-comp").classList.toggle("active");
      document.querySelector("#search-input").focus();
    });
  }
  if (document.querySelector(".cinescuela-page.novedades")) {
    document
      .querySelectorAll(".cinescuela-page.novedades main p a")
      .forEach((links) => {
        links.setAttribute("target", "_blank");
      });
  }
  getNovedades();
  getMoviesMes();
  getCiclosInfo();
  getCiclos(
    document.querySelector("main").dataset.cicloyear
      ? document.querySelector("main").dataset.cicloyear
      : new Date().getFullYear()
  );
  getMovieCiclos();
  getCicloMovies();
  getMoviesRel();
  getMoreMovies();
  getMoreNews();
  AOS.init({
    disable: "mobile",
  });
  fadeOut(preloader);
  lazyImages();
});
