document.addEventListener("DOMContentLoaded", () => {
  const swiperTop = new Swiper(".swiperHome", {
    slidesPerView: "auto",
    pagination: {
      el: ".swiper-pagination",
      type: "bullets",
    },
    autoplay: {
      delay: 5000,
    },
  });
});
