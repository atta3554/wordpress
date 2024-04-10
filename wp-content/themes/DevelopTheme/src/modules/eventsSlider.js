import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// init Swiper:
class SwiperSlider {
    constructor() {

        Swiper.use([Navigation]);
        Swiper.use([Pagination]);
        const swiper = new Swiper('.swiper', {
            // Optional parameters

            direction: 'vertical',
            loop: true,
            spaceBetween: 100,
          
            // If we need pagination
            pagination: {
              el: '.swiper-pagination',
            },
            
            direction: 'horizontal',
            
            // Navigation arrows
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
          
            // And if we need scrollbar
            scrollbar: {
              el: '.swiper-scrollbar',
            },
          });
    }
}

export default SwiperSlider;