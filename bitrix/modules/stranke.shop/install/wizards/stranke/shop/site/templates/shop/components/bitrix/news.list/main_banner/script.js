$(window).on("load", function () {
    function load_swiper() {
        if (typeof Swiper == 'undefined') {
            setTimeout(function () {
                load_swiper();
            }, 200)
            return;
        }

        var swiperSliderOnMain = new Swiper('#main_banner', {
            init: true,
            speed: 800,
            spaceBetween: 0,
            // Navigation arrows
            navigation: {
                nextEl: '#main_banner .swiper-button-next',
                prevEl: '#main_banner .swiper-button-prev'
            },
            pagination: {
                el: '#slider-on-main .swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 4000,
            },
            loop: true,
        });
    }

    load_swiper()
})
