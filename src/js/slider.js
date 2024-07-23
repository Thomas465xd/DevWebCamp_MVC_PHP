import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

// import styles bundle
import 'swiper/css/bundle';

// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.addEventListener("DOMContentLoaded", function() {
    if(document.querySelector(".slider")) {
        const opciones = {
            slidesPerView: 1,
            spaceBetween: 30,
            FreeMode: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                1200: {
                    slidesPerView:4, 
                    spaceBetween: 40
                }, 
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20
                }
            }
            
        }

        Swiper.use([Navigation]);
        new Swiper(".slider", opciones);
    }
});