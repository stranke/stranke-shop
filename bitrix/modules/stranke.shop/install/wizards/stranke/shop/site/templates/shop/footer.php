<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? global $app, $settings; ?>
<? $app->footer->render(); ?>
</main>
<footer id="footer" class="footer">
    <div class="wrapper">
        <div class="footer_content">
            <div class="footer_data footer_content_item">
                <div class="footer_logo header__logo">
                    <img src="<?= $app->config->logo ?>" alt="logo">
                </div>
                <div class="header__phones">
                    <? require 'includes/header/header_phone.php' ?>
                </div>
                <div class="header__phones-title">
                    <?= $app->config->properties['PHONETEXT_FOOTER']['VALUE'] ?>
                </div>
            </div>
            <div class="footer_catalog footer_content_item footer_content_item_with_menu">
                <div class="footer_item_header"><?= GetMessage('ST_FOOTER_BUYER') ?></div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "main-menu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MENU_THEME" => "site",
                        "ROOT_MENU_TYPE" => "buyer",
                        "USE_EXT" => "Y",
                        "COMPONENT_TEMPLATE" => "catalog-menu",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO"
                    ),
                    false
                ); ?>
            </div>
            <div class="footer_company footer_content_item footer_content_item_with_menu">
                <div class="footer_item_header"><?= GetMessage('ST_FOOTER_COMPANY') ?></div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "main-menu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_THEME" => "site",
                        "ROOT_MENU_TYPE" => "company",
                        "USE_EXT" => "Y",
                        "COMPONENT_TEMPLATE" => "main-menu",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO"
                    ),
                    false
                ); ?>

            </div>
            <? include 'includes/footer/social_links.php'; ?>
            <div class="footer_app_links footer_content_item">
                <? if ($app->config->app_store_link): ?>
                    <div><a target="_blank" href="<?= $app->config->app_store_link ?>">
                            <div class="app_links_apple links_item">
                                <?= $settings->app_links_icons['app_store_link']; ?>
                            </div>
                        </a></div>
                <? endif; ?>
                <? if ($app->config->google_play_link): ?>
                    <div><a target="_blank" href="<?= $app->config->google_play_link ?>">
                            <div class="app_links_google_play links_item">
                                <?= $settings->app_links_icons['google_play_link']; ?>
                            </div>
                        </a></div>
                <? endif; ?>
                <? if ($app->config->app_gallery_link): ?>
                    <div><a target="_blank" href="<?= $app->config->app_gallery_link ?>">
                            <div class="app_links_app_gallery links_item">
                                <?= $settings->app_links_icons['app_gallery_link']; ?>
                            </div>
                        </a></div>
                <? endif; ?>
            </div>
        </div>
        <div class="footer__bottom-container">
            <div class="footer__text"><?= $app->config->textFooter ?></div>

            <div class="stranke_link"><?= GetMessage('ST_FOOTER_DEV') ?>
                <a target="_blank" class="color_main" href="https://stranke.ru">Stranke.ru</a></div>
        </div>
    </div>

    <? include_once __DIR__ . "/includes/localbusiness.php"; ?>
    <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "LocalBusiness",
          "url": "<?= $url ?>",
          "name": "<?= $name ?>",
          "contactPoint": <?= $jsonContactPoint ?>,
          "address": <?= $jsonAddress ?>,
          "image": "<?= $logo ?>",
          "telephone": "<?= $phone ?>"
        }













    </script>
</footer>
<? //include 'includes/footer/alert-banner.php'?>
<?
if ($USER->isAdmin()) {
    $settings->insertSettingsLink();
} else {
    $settings->insertOtherCode();
}
?>

<script>
    window.referer = '<?=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''?>';


    let vh = window.innerHeight * 0.01;
    let mh = window.innerHeight - document.getElementById('footer').getBoundingClientRect().height - document.getElementById('header').getBoundingClientRect().height - parseInt(window.getComputedStyle(document.getElementById('footer')).marginTop);
    let vw = window.innerWidth * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    document.documentElement.style.setProperty('--vw', `${vw}px`);
    document.documentElement.style.setProperty('--mh', `${mh}px`);
    window.addEventListener("resize", function () {
        let vh = window.innerHeight * 0.01;
        let vw = window.innerWidth * 0.01;
        let mh = window.innerHeight - document.getElementById('footer').getBoundingClientRect().height - document.getElementById('header').getBoundingClientRect().height - parseInt(window.getComputedStyle(document.getElementById('footer')).marginTop);
        document.documentElement.style.setProperty('--vh', `${vh}px`);
        document.documentElement.style.setProperty('--vw', `${vw}px`);
        document.documentElement.style.setProperty('--vw', `${mh}px`);
    }, false);

    setTimeout(function () {

    }, 1000);
</script>

<? if (!$is_page_speed_agent) { ?>
    <script type='text/javascript'>
        window.addEventListener("load", () => {
            document.querySelectorAll('[data-lazy-load]').forEach(img => img.setAttribute('src', img.dataset.src));

            if ($('.swiper-wrapper').length) {
                var addStyle = document.createElement("link");
                addStyle.setAttribute("rel", "stylesheet");
                addStyle.setAttribute("type", "text/css");
                addStyle.setAttribute("href", '<?=SITE_TEMPLATE_PATH . "/styles/swiper.css"?>');

                document.getElementsByTagName("head")[0].appendChild(addStyle);
            }
        });
    </script>
    <script type='text/javascript'>
        function load_scripts() {
            if ($('.swiper-wrapper').length) {
                var script = document.createElement('script');
                script.src = '<?= SITE_TEMPLATE_PATH . "/js/swiper.min.js" ?>';
                script.type = 'text/javascript';
                document.getElementsByTagName('head')[0].appendChild(script);
            }

        }

        $(document).ready(function () {
            load_scripts();
        })
    </script>
    <? if (!$USER->IsAdmin()): ?>
        <script type='text/javascript'>
            function ready() {

            }

            window.addEventListener("load", ready);
        </script>
    <? endif ?>
<? } ?>
</body>
</html>
