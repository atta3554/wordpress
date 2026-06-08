import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

class SwiperSlider {
  constructor() {
    const slider = document.querySelector(".legacy-events-swiper");
    if (!slider) {
      return;
    }

    Swiper.use([Navigation, Pagination]);
    const slideCount = slider.querySelectorAll(".swiper-slide").length;

    new Swiper(slider, {
      loop: slideCount > 1,
      spaceBetween: 100,
      direction: "horizontal",
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }
}

export default SwiperSlider;
