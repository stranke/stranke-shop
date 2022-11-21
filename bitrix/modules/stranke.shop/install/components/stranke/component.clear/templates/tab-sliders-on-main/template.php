<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div class="wrapper ">
    <div class="slider-tabs">
        <div class="slider-tabs__title-list">
            <? //slider-tabs__title_selected?>
            <? if ($arResult['POPULAR']) { ?>
                <div class="slider-tabs__title" data="popular"><?=GetMessage('CT_PRODUCT_ON_MAIN_TAB_1')?></div>
                <div class="slider-tabs__title-separator">/</div>
            <? } ?>
            <div class="slider-tabs__title" data="hit"><?=GetMessage('CT_PRODUCT_ON_MAIN_TAB_2')?></div>
            <div class="slider-tabs__title-separator">/</div>
            <? if ($arResult['NEW']) { ?>
                <div class="slider-tabs__title" data="new"><?=GetMessage('CT_PRODUCT_ON_MAIN_TAB_3')?></div>
            <? } ?>
        </div>
        <div class="slider-tabs__tabs-list">
            <? if ($arResult['POPULAR']) { ?>
                <div class="slider-tabs__tab" data="popular">
                    <div id="product_popular-goods" class="swiper">
                        <div class="swiper-wrapper">
                            <? foreach ($arResult['POPULAR'] as $arItem) { ?>
                                <div class="swiper-slide">
                                    <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/product-list/product-on-main.php'; ?>
                                </div>
                            <? } ?>
                        </div>
                        <div class="swiper-button-prev">
                            <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 1L2 7L9 13" stroke="" stroke-width="2.04511"/>
                            </svg>
                        </div>
                        <div class="swiper-button-next">
                            <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L8 7L1 13" stroke="" stroke-width="2.04511"/>
                            </svg>
                        </div>
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            <? } ?>
            <? if (1) { ?>
                <div class="slider-tabs__tab" data="hit">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:sale.bestsellers",
                        "on-main",
                        array(
                            "LINE_ELEMENT_COUNT" => "10",
                            "TEMPLATE_THEME" => "blue",
                            "BY" => "AMOUNT",
                            "PERIOD" => "180",
                            "FILTER" => array(
                                0 => "N",
                                1 => "P",
                                2 => "F",
                            ),
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "86400",
                            "AJAX_MODE" => "N",
                            "DETAIL_URL" => "",
                            "BASKET_URL" => "/personal/basket.php",
                            "ACTION_VARIABLE" => "action",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "DISPLAY_COMPARE" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "N",
                            "PRICE_CODE" => array(
                                0 => "BASE",
                            ),
                            "SHOW_PRICE_COUNT" => "1",
                            "PRODUCT_SUBSCRIPTION" => "N",
                            "PRICE_VAT_INCLUDE" => "Y",
                            "USE_PRODUCT_QUANTITY" => "N",
                            "SHOW_NAME" => "Y",
                            "SHOW_IMAGE" => "Y",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "PAGE_ELEMENT_COUNT" => "10",
                            "SHOW_PRODUCTS_3" => "Y",
                            "PROPERTY_CODE_3" => array(
                                0 => "MANUFACTURER",
                                1 => "MATERIAL",
                            ),
                            "CART_PROPERTIES_3" => array(
                                0 => "CORNER",
                            ),
                            "ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
                            "LABEL_PROP_3" => "SPECIALOFFER",
                            "PROPERTY_CODE_4" => array(
                                0 => "COLOR",
                            ),
                            "CART_PROPERTIES_4" => "",
                            "OFFER_TREE_PROPS_4" => array(
                                0 => "-",
                            ),
                            "HIDE_NOT_AVAILABLE" => "Y",
                            "CONVERT_CURRENCY" => "Y",
                            "CURRENCY_ID" => "RUB",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "COMPONENT_TEMPLATE" => "items_slider",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                            "SHOW_PRODUCTS_5" => "Y",
                            "PROPERTY_CODE_5" => array(
                                0 => "",
                                1 => "",
                            ),
                            "CART_PROPERTIES_5" => array(
                                0 => "",
                                1 => "",
                            ),
                            "ADDITIONAL_PICT_PROP_5" => "MORE_PHOTO",
                            "LABEL_PROP_5" => "-",
                            "PROPERTY_CODE_6" => array(
                                0 => "",
                                1 => "",
                            ),
                            "CART_PROPERTIES_6" => array(
                                0 => "",
                                1 => "",
                            ),
                            "ADDITIONAL_PICT_PROP_6" => "MORE_PHOTO",
                            "OFFER_TREE_PROPS_6" => array(),
                            "SHOW_PRODUCTS_9" => "N",
                            "PROPERTY_CODE_9" => array(),
                            "CART_PROPERTIES_9" => array(),
                            "ADDITIONAL_PICT_PROP_9" => "WORK_STEPS",
                            "LABEL_PROP_9" => "-",
                            "SHOW_PRODUCTS_48" => "N",
                            "PROPERTY_CODE_48" => array(),
                            "CART_PROPERTIES_48" => array(),
                            "ADDITIONAL_PICT_PROP_48" => "FILES",
                            "LABEL_PROP_48" => "-",
                            "SHOW_PRODUCTS_59" => "N",
                            "PROPERTY_CODE_59" => array(),
                            "CART_PROPERTIES_59" => array(),
                            "ADDITIONAL_PICT_PROP_59" => "MORE_PHOTO",
                            "LABEL_PROP_59" => "-",
                            "PROPERTY_CODE_49" => array(
                                0 => "",
                                1 => "",
                            ),
                            "CART_PROPERTIES_49" => array(
                                0 => "",
                                1 => "",
                            ),
                            "ADDITIONAL_PICT_PROP_49" => "FILES",
                            "OFFER_TREE_PROPS_49" => "",
                            "PROPERTY_CODE_60" => array(
                                0 => "",
                                1 => "",
                            ),
                            "CART_PROPERTIES_60" => array(
                                0 => "",
                                1 => "",
                            ),
                            "ADDITIONAL_PICT_PROP_60" => "MORE_PHOTO",
                            "OFFER_TREE_PROPS_60" => ""
                        ),
                        false
                    ); ?>
                </div>
            <? } ?>
            <? if ($arResult['NEW']) { ?>
                <div class="slider-tabs__tab" data="new">
                    <div id="product_new-goods" class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($arResult['NEW'] as $arItem) { ?>
                                <div class="swiper-slide">
                                    <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/product-list/product-on-main.php'; ?>
                                </div>
                            <? } ?>
                        </div>
                        <div class="swiper-button-prev">
                            <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 1L2 7L9 13" stroke="" stroke-width="2.04511"/>
                            </svg>
                        </div>
                        <div class="swiper-button-next">
                            <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L8 7L1 13" stroke="" stroke-width="2.04511"/>
                            </svg>
                        </div>
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</div>
<script>
    function load_swiper_slider() {
        if (typeof Swiper == 'undefined') {
            setTimeout(function () {
                load_swiper_slider();
            }, 200)
            return;
        }
        var swiper_product_hit_goods = new Swiper('#product_hit-goods', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,
            slidesPerView: 5,
            spaceBetween: 20,
            breakpoints: {
                380: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25
                },
                1400: {
                    slidesPerView: 5,
                    spaceBetween: 25
                }
            },
            // If we need pagination
            pagination: {
                el: '#product_hit-goods .swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '#product_hit-goods .swiper-button-next',
                prevEl: '#product_hit-goods .swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '#product_hit-goods .swiper-scrollbar',
                draggable: true,
            },
        });
        var swiper_product_popular_goods = new Swiper('#product_popular-goods', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,
            slidesPerView: 5,
            spaceBetween: 20,
            breakpoints: {
                380: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25
                },
                1400: {
                    slidesPerView: 5,
                    spaceBetween: 25
                }
            },
            // If we need pagination
            pagination: {
                el: '#product_popular-goods .swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '#product_popular-goods .swiper-button-next',
                prevEl: '#product_popular-goods .swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '#product_popular-goods .swiper-scrollbar',
                draggable: true,
            },
        });
        var swiper_product_new_goods = new Swiper('#product_new-goods', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,
            slidesPerView: 5,
            spaceBetween: 20,
            breakpoints: {
                // when window width is >= 320px
                380: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25
                },
                1400: {
                    slidesPerView: 5,
                    spaceBetween: 25
                }
            },
            // If we need pagination
            pagination: {
                el: '#product_new-goods .swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '#product_new-goods .swiper-button-next',
                prevEl: '#product_new-goods .swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '#product_new-goods .swiper-scrollbar',
                draggable: true,
            },
        });

    }

    function select_tab($tabsTitleList, $tabsList, $activeTabIndex = 0) {
        $tabsTitleList.each(function ($index) {
            if ($index !== $activeTabIndex) {
                deactivate_tab($tabsTitleList[$index], $tabsList[$index])
            } else {
                activate_tab($tabsTitleList[$index], $tabsList[$index])
            }
        })
    }

    function deactivate_tab($tabsTitle, $tab) {
        if ($tabsTitle.classList.contains("_selected")) {
            $tabsTitle.classList.remove("_selected");
        }
        if ($tab.classList.contains("_selected")) {
            $tab.classList.remove("_selected");
        }
    }

    function activate_tab($tabsTitle, $tab) {
        if (!$tabsTitle.classList.contains("_selected")) {
            $tabsTitle.classList.add("_selected");
        }
        if (!$tab.classList.contains("_selected")) {
            $tab.classList.add("_selected");
        }
    }

    function get_tab_index($tabsTitleList, $attrData) {
        let $index = false;
        $tabsTitleList.each(function (index) {
            if ($attrData === $(this).attr('data')) {
                $index = index;
            }
        })
        return $index;
    }

    $(window).on('load', function () {
        load_swiper_slider();
        let $tabsTitleList = $('.slider-tabs__title'),
            $tabsList = $('.slider-tabs__tab'),
            $indexCode;
        select_tab($tabsTitleList, $tabsList);
        $tabsTitleList.on('click', function () {
            let $activeTabIndex = get_tab_index($tabsTitleList, $(this).attr('data'));
            select_tab($tabsTitleList, $tabsList, $activeTabIndex)

        })
    });
</script>
