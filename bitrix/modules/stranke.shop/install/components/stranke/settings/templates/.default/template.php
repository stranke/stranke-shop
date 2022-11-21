<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$this->addExternalCss($templateFolder . '/lib/pickr/pickr.min.css');
$this->addExternalJs($templateFolder . '/lib/pickr/pickr.es5.min.js');

$this->addExternalCss($templateFolder . '/lib/switchery/switchery.css');
$this->addExternalJs($templateFolder . '/lib/switchery/switchery.js');

$PROP = $arResult['SETTINGS']['PROP'];
?>
<div class="settings">
    <div class="left_col">
        <div class="logo">
            <img src="<?= SITE_TEMPLATE_PATH ?>/img/Stranke_Logo.svg"/>
        </div>
        <div class="settings__tabs">
            <div class="settings__tab settings__tab_active" data-tab="main"><?= GetMessage('ST_SETTINGS_TAB_1') ?></div>
            <div class="settings__tab" data-tab="auth"><?= GetMessage('ST_SETTINGS_TAB_2') ?></div>
<!--            <div class="settings__tab" data-tab="banner">--><?//= GetMessage('ST_SETTINGS_TAB_3') ?><!--</div>-->
<!--            <div class="settings__tab" data-tab="actions">--><?//= GetMessage('ST_SETTINGS_TAB_4') ?><!--</div>-->
            <div class="settings__tab" data-tab="contacts"><?= GetMessage('ST_SETTINGS_TAB_5') ?></div>
            <div class="settings__tab" data-tab="footer"><?= GetMessage('ST_SETTINGS_TAB_6') ?></div>
            <div class="settings__tab" data-tab="analytics"><?= GetMessage('ST_SETTINGS_TAB_7') ?></div>
        </div>
    </div>
    <div class="right_col">
        <div class="wrapper">
            <form class="settings__form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="saveSettings" value="Y">
                <div class="settings__tab-content settings__tab-content_active" data-tab="main">
                    <h1><?= GetMessage('ST_SETTINGS_TAB_1') ?></h1>
                    <? include 'tabs/main.php' ?>
                </div>
                <div class="settings__tab-content" data-tab="auth">
                    <h1><?= GetMessage('ST_SETTINGS_TAB_2') ?></h1>
                    <? include 'tabs/auth.php' ?>
                </div>
<!--                <div class="settings__tab-content" data-tab="banner">-->
<!--                    <h1>--><?//= GetMessage('ST_SETTINGS_TAB_3') ?><!--</h1>-->
<!--                    --><?// include 'tabs/banner.php' ?>
<!--                </div>-->
<!--                <div class="settings__tab-content" data-tab="actions">-->
<!--                    <h1>--><?//= GetMessage('ST_SETTINGS_TAB_4') ?><!--</h1>-->
<!--                    --><?// include 'tabs/actions.php' ?>
<!--                </div>-->
                <div class="settings__tab-content" data-tab="contacts">
                    <h1><?= GetMessage('ST_SETTINGS_TAB_5') ?></h1>
                    <? include 'tabs/contacts.php' ?>
                </div>
                <div class="settings__tab-content" data-tab="footer">
                    <h1><?= GetMessage('ST_SETTINGS_TAB_6') ?></h1>
                    <? include 'tabs/footer.php' ?>
                </div>
                <? /*<div class="settings__tab-content" data-tab="index">
                    <? $component->render('MAIN_SHOW_SLIDER'); ?>
                    <? $component->render('MAIN_SHOW_ADVENTAGES'); ?>
                    <? $component->render('MAIN_SHOW_MENU'); ?>
                    <? $component->render('MAIN_SHOW_BESTSELLERS'); ?>
                    <? $component->render('MAIN_SHOW_REVIEWS'); ?>
                    <? $component->render('MAIN_SHOW_RELINKS'); ?>
                </div>*/ ?>
                <div class="settings__tab-content" data-tab="analytics">
                    <h1><?= GetMessage('ST_SETTINGS_TAB_7') ?></h1>
                    <? include 'tabs/analytics.php' ?>
                </div>


                <div class="settings__buttons">
                    <button class="btn bg_main"><?= GetMessage('ST_SETTINGS_SAVE') ?></button>
                </div>
            </form>
        </div>
    </div>
    <script>
        BX.message({
            ST_SETTINGS_SELECT: '<?=GetMessage('ST_SETTINGS_SELECT')?>',
        })
    </script>
</div>






