var jshover = function () {

//----------//---------- HeaderCatalogMenu ----------//----------//

    var $headerCatalogMenuBtn = $(".js-headerCatalogMenuBtn");
    var $headerCatalogMenu = $(".js-headerCatalogMenu");
    var $headerCatalogSubmenuActiv;
    var $headerCatalogSubmenuActivBackBtn;
    var $headerCatalogZIndex = 100;
    var $headerCatalogMenuCloseBtn = $('.js-headerCatalogMenuCloseBtn');

    window.$headerCatalogSubmenuActiv = {$headerCatalogSubmenuActiv};

    $headerCatalogMenu.on('click', function (ev) {
        if ($(ev.target).closest('.header-mobile-menu').length < 1)
            headerCatalogMenuClose();
    });
    var header_Catalog_menu_request = 1;
    $headerCatalogMenuBtn.on('click', function () {
        $headerCatalogMenu.addClass("header-catalog__menu_show")
        $('body,html').addClass('menu_show');
    });

    function headerCatalogMenuClose() {
        $headerCatalogMenu.removeClass("header-catalog__menu_show");
        $('body,html').removeClass('menu_show');
    }

    $headerCatalogMenu.find(".header-mobile-menu__item").on('click', function () {
        $headerCatalogMenu.find('.header-mobile-menu__submenu-container_show').removeClass("header-mobile-menu__submenu-container_show")
        var $this = $(this);
        $this.addClass("header-mobile-menu__submenu-container_show")
        var $headerMobileSubmenuName = $this.data('name');
        $headerCatalogSubmenuActiv = $headerCatalogMenu.find('.header-mobile-menu__submenu-container[data-name ="' + $headerMobileSubmenuName + '"]');
        $headerCatalogSubmenuActiv.css({'min-height': $headerCatalogMenu.find('.header-mobile-menu__submenu-container_main').height() + 'px'})
        $headerCatalogSubmenuActiv.addClass("header-mobile-menu__submenu-container_show");
    });

    $headerCatalogMenu.find(".header-mobile-menu__item").on('mouseenter', function () {

        let $this = $(this);
        setTimeout(function () {
            if ($this.is(':hover')) {
                let $headerMobileSubmenuName = $this.data('name');
                $headerCatalogMenu.find('.header-mobile-menu__submenu-container_show').removeClass("header-mobile-menu__submenu-container_show");
                $this.addClass("header-mobile-menu__submenu-container_show");
                $headerCatalogSubmenuActiv = $headerCatalogMenu.find('.header-mobile-menu__submenu-container[data-name ="' + $headerMobileSubmenuName + '"]');
                $headerCatalogSubmenuActiv.css({'min-height': $headerCatalogMenu.find('.header-mobile-menu__submenu-container_main').height() + 'px'});
                $headerCatalogSubmenuActiv.addClass("header-mobile-menu__submenu-container_show");
            }
        }, 1000)

    });

    $headerCatalogMenuCloseBtn.on('click', function () {
        headerCatalogMenuClose();
    });

//----------//---------- HeaderMobileMenu ----------//----------//

    var $headerMobileMenuBtn = $(".js-headerMobileMenuBtn");
    var $headerMobileMenu = $(".js-headerMobileMenu");
    var $headerMobileSubmenuActiv;
    var $headerMobileSubmenuActivBackBtn;
    var $headerMobileZIndex = 100;
    var $headerMobileMenuCloseBtn = $('.js-headerMobileMenuCloseBtn');

    window.$headerMobileSubmenuActiv = {$headerMobileSubmenuActiv};

    var header_mobile_menu_request = 1;
    $headerMobileMenuBtn.on('click', function () {
        if (!$('.js-headerMobileMenu .header-mobile-menu__item-list').length && header_mobile_menu_request) {
            header_mobile_menu_request = 0;
            $.ajax({
                url: SITE_DIR + "ajax/header_mobile_menu.php",
                method: "GET",
                success: function (data) {
                    $('.js-headerMobileMenuContent').html(data);
                    setChoiseCityBox();
                    $headerMobileMenu.addClass("header-mobile__menu_show");
                    $('body,html').addClass('menu_show');

                    $(".js-headerMobileMenu .header-mobile-menu__item").on('click', function () {

                        var $this = $(this);
                        var $headerMobileSubmenuName = $this.data('name');
                        $headerMobileZIndex = $headerMobileZIndex + 1;
                        $headerMobileSubmenuActiv = $('.header-mobile-menu__submenu-container[data-name ="' + $headerMobileSubmenuName + '"]');
                        // $headerMobileSubmenuActiv.style.zIndex=$headerMobileZIndex;
                        $headerMobileSubmenuActiv.css({'min-height': $headerMobileMenu.find('.header-mobile-menu__submenu-container_main').height() + 'px'})
                        $headerMobileSubmenuActiv.addClass("header-mobile-menu__submenu-container_show");
                        $headerMobileMenu.addClass("submenu-container_show");
                        $headerMobileSubmenuActivBackBtn = $headerMobileSubmenuActiv.find('.js-headerMobileSubmenuBackBtn');
                        $headerMobileSubmenuActivBackBtn.on('click', function () {
                            $headerMobileSubmenuActiv.removeClass("header-mobile-menu__submenu-container_show");
                            $headerMobileMenu.removeClass("submenu-container_show");
                            $headerMobileZIndex = $headerMobileZIndex - 1;
                        });
                    });
                }
            });
        }
        $headerMobileMenu.addClass("header-mobile__menu_show")
        $('body,html').addClass('menu_show');
    });

    function headerMobileMenuClose() {
        $headerMobileMenu.removeClass("header-mobile__menu_show");
        $('body,html').removeClass('menu_show');
    }
    ;

    $headerMobileMenuCloseBtn.on('click', function () {
        headerMobileMenuClose();
    });

    function common__load_swipe() {
        if (typeof $headerMobileMenu.swipe == 'undefined') {
            setTimeout(function () {
                common__load_swipe();
            }, 200)
            return;
        }

        $headerMobileMenu.swipe({
            swipeLeft: function () {
                headerMobileMenuClose();
            },
            threshold: 25,
            excludedElements: ".central-block__search"
        });
    }

    common__load_swipe();


//----------//---------- HeaderSearch ----------//----------//

    $(".js-headerSearchBtn").on('click', function () {

        var $headerFoundItemsList = $(".js-headerFoundItemsList");
        var $headerSearchBtn = $(".js-headerSearchBtn");

        if ($headerFoundItemsList.hasClass("js-hidden")) {

            $headerFoundItemsList.removeClass("js-hidden");
            $headerFoundItemsList.slideDown(400);

        } else {

            $headerFoundItemsList.slideUp(400);
            $headerFoundItemsList.addClass("js-hidden");

        }
    });


//----------//---------- HeaderMobileSearch ----------//----------//

    var $headerMobileSearch = $('.header-mobile__search');
    var $headerMobileSearchInput = $headerMobileSearch.find('input');
    var $headerMobileSearchBtn = $('.header-mobile__search-btn');
    var $headerMobileSearchCloseBtn = $('.js-headerMobileSearchCloseBtn');

    $headerMobileSearchBtn.on('click', function () {

        $headerMobileSearch.addClass('header-mobile__search_show');

    });

    $headerMobileSearchCloseBtn.on('click', function () {

        $headerMobileSearch.removeClass('header-mobile__search_show');
        $headerMobileSearchInput.val('');

    });


//----------//---------- HeaderSubMenu ----------//----------//

    $(".js-headerSubmenuShowBtn").on('click', function () {

        var $this = $(this);
        var $stateIcon = $this.find(".js-headerSubmenuStateIcon");

        if ($stateIcon.hasClass("fa-chevron-down")) {

            $stateIcon.removeClass("fa-chevron-down");
            $stateIcon.addClass("fa-chevron-up");

        } else {

            $stateIcon.removeClass("fa-chevron-up");
            $stateIcon.addClass("fa-chevron-down");

        }

        $this.find(".js-headerSubmenu").toggleClass("header-bottom-menu__submenu_show");


    });

//----------//---------- HeaderCatalogSubmenu ----------//----------//

    var $mainBlackOut = $("#main-blackout");
    var $headerCatalogSection = $(".header-catalog__section");
    var $headerCatalogMenuWrapper = $(".header-catalog__menu-wrapper");

    $headerCatalogSection.mouseover(function () {

        $mainBlackOut.addClass("main-blackout_visible");

        $headerCatalogMenuWrapper.addClass("header-catalog__menu-wrapper_bottom-right-border");
    });

    $headerCatalogSection.mouseout(function () {

        $headerCatalogMenuWrapper.removeClass("header-catalog__menu-wrapper_bottom-right-border");
        $mainBlackOut.removeClass("main-blackout_visible");
    });


}

$(document).ready(() => {
    jshover();
});
