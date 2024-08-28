document.addEventListener("DOMContentLoaded", () => {
  const swiperHome = new Swiper(".swiperHome", {
    slidesPerView: "auto",
    pagination: {
      el: ".swiper-pagination",
      type: "bullets",
    },
    autoplay: {
      delay: 5000,
    },
  });
  const swiperHomeApp = new Swiper(".swiperHomeApp", {
    slidesPerView: "auto",
    pagination: {
      el: ".swiper-pagination",
      type: "bullets",
    },
    autoplay: {
      delay: 5000,
    },
  });
  const swiperCarousel = new Swiper(".swiperCarousel", {
    slidesPerView: "auto",
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
  const swiperTop = new Swiper(".swiperTop", {
    slidesPerView: "auto",
    spaceBetween: 50,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
  const swiper_actividades_complementarias = new Swiper(
    ".swiper-actividades_complementarias",
    {
      slidesPerView: 4,
      spaceBetween: 0,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    }
  );
});
