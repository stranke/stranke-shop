<?
$colorMain = $GLOBALS["OPTIONS"]["COLOR_MAIN"];
$colorMain_nonhash = str_replace('#', '', $colorMain);
$colorTopMenu = $GLOBALS["OPTIONS"]["COLOR_TOP_MENU"];
$colorBannerBg = $GLOBALS['OPTIONS']['ALERT_BANNER']['BG_COLOR'];

?>
<style>
    :root {
        --color-main: <?=$colorMain?>;
        --color-main-hover: <?=$colorMain?>cc;
        --color-main-hover-bleck: <?=$colorMain?>10;
        --color-link: <?=$colorMain?>;
        --color-link-hover: <?=$colorMain?>;
        --color-top-menu: <?=$colorTopMenu?>;
        --color-banner-bg: <?=$colorBannerBg?>;
        --color-banner-text: <?=$colorBannerText?>;
        --color-discount-shild-bg: <?=$app->config->colorDiscountShield?>;
        --color-shild-new-bg: <?=$app->config->colorShildNew?>;
        --color-shild-hit-bg: <?=$app->config->colorShildHit?>;
    }

    .cart_link:hover,
    .cart_link.have_items,
    .bx-pagination.bx-blue .bx-pagination-container ul li.bx-active span,
    .item-checkbox-list .item-checkbox-list__item-checkbox_checked,
    .item-price .bx-ui-slider-track-container .bx-ui-slider-track .bx-ui-slider-range,
    .item-price .bx-ui-slider-track-container .bx-ui-slider-track .bx-ui-slider-handle,
    .products-settings .products-settings__bottom .products-settings__apply-btn,
    .slider-tabs .swiper.swiper-container-horizontal > .swiper-scrollbar .swiper-scrollbar-drag,
    .products__item-buybtn,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__item-list .header-mobile-menu__item.header-mobile-menu__submenu-container_show,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__item-list .header-mobile-menu__item:hover,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__item-list .header-mobile-menu__item.header-mobile-menu__submenu-container_show,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__item-list .header-mobile-menu__item_catalog,
    .bg_main {
        color: #fff;
        background-color: var(--color-main);
    }

    .products-settings .products-settings__bottom .products-settings__apply-btn:hover,
    .bg_main:focus,
    .bg_main:hover {
        color: #fff;
        background: var(--color-main-hover);
    }

    .btn.btn-border {
        color: var(--color-main);
        border: 2px solid var(--color-main);
    }

    .btn.btn-border:hover {
        color: var(--color-main-hover);
        border: 2px solid var(--color-main-hover);
        background: var(--color-main-hover-bleck);
    }

    .cart_link:hover svg path,
    .cart_link.have_items svg path {
        stroke: #fff;
    }

    body .swiper-button-prev {
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%2027%2044'%3E%3Cpath%20d%3D'M0%2C22L22%2C0l2.1%2C2.1L4.2%2C22l19.9%2C19.9L22%2C44L0%2C22L0%2C22L0%2C22z'%20fill%3D'%23<?=$colorMain_nonhash?>'%2F%3E%3C%2Fsvg%3E");
    }

    body .swiper-button-next {
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%2027%2044'%3E%3Cpath%20d%3D'M27%2C22L27%2C22L5%2C44l-2.1-2.1L22.8%2C22L2.9%2C2.1L5%2C0L27%2C22L27%2C22z'%20fill%3D'%23<?=$colorMain_nonhash?>'%2F%3E%3C%2Fsvg%3E");
    }

    .catalog-element .product__nav-bar .product__nav-bar-element.product__nav-bar-element_active {
        border-bottom: 2px solid<?=$colorMain?>;
    }

    body a:hover,
    .subsection-page .subsection-page__products-top .subsection-page__products-sort-panel .subsection-page__products-sort a[selected],
    .slider-tabs__title._selected,
    .products-on-main .products-on-main__all-products-btn span,
    .bx-breadcrumb .bx-breadcrumb-item a:hover,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__request-call-specialist-btn,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__user-block .header-mobile-menu__user-cabinet .header-mobile-menu__user-cabinet-entrance a:hover,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__user-block .header-mobile-menu__user-cabinet .header-mobile-menu__user-cabinet-title,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__user-block .header-mobile-menu__user-photo .header-mobile-menu__no-user-photo .fas,
    .header-mobile-menu__phone-list-element,
    .header-mobile-menu__submenu-container a.header-mobile-menu__submenu-back-btn,
    .header-mobile-menu__submenu-container .header-mobile-menu__submenu-item-list .header-mobile-menu__submenu-item a:hover,
    .color_main {
        color: <?=$colorMain?>;
    }

    .header-mobile-menu__submenu-container_main .header-mobile-menu__request-call-specialist-btn {
        border: 2px solid<?=$colorMain?>;
    }

    .cart_link:hover,
    .cart_link.have_items,
    .item-checkbox-list .item-checkbox-list__item-checkbox_checked .item-checkbox-list__item-checkbox-icon,
    .isMobile .item-checkbox-list .item-checkbox-list__item-checkbox_checked {
        border: 1px solid<?=$colorMain?>;
    }

    .header-mobile-menu__submenu-container_main .header-mobile-menu__request-call-specialist-btn svg {
        fill: <?=$colorMain?>;
    }

    .item-checkbox-list .item-checkbox-list__item-checkbox .item-checkbox-list__item-checkbox-icon svg path {
        stroke: <?=$colorMain?>;
    }

    .header-mobile-menu__submenu-container_main .header-mobile-menu__item-list .header-mobile-menu__item:hover path,
    .header-mobile-menu__submenu-container_main .header-mobile-menu__item-list .header-mobile-menu__item.header-mobile-menu__submenu-container_show path {
        fill: #fff;
    }

    .alert-banner {
        background-color: <?=$colorBannerBg?>;
        background-color: var(--color-banner-text);
    }

    .mark-list__item_discount {
        background-color: <?=$app->config->colorDiscountShield?>;
        background-color: var(--color-discount-shild-bg);
    }

    .mark-list__item_discount:before {
        border-color: transparent transparent transparent<?=$app->config->colorDiscountShield?>;
        border-color: transparent transparent transparent var(--color-discount-shild-bg);
    }

    .mark-list__item_new {
        background-color: <?=$app->config->colorShildNew?>;
        background-color: var(--color-shild-new-bg);
    }

    .mark-list__item_new:before {
        border-color: transparent transparent transparent<?=$app->config->colorShildNew?>;
        border-color: transparent transparent transparent var(--color-shild-new-bg);
    }

    .mark-list__item_hit {
        background-color: <?=$app->config->colorShildHit?>;
        background-color: var(--color-shild-hit-bg);
    }

    .mark-list__item_hit:before {
        border-color: transparent transparent transparent<?=$app->config->colorShildHit?>;
        border-color: transparent transparent transparent var(--color-shild-hit-bg);
    }

    .no_img {
        background: #FBFBFB;
    }
</style>
