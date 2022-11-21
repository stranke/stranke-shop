<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<?
$this->setFrameMode(true);
?>
<? if (!empty($arResult)) { ?>
    <? if ($arParams['NO_SHOW_LIST'] != 'Y'): ?>
        <div class="header-mobile-menu__item-list">

            <? $isFst = false; ?>
            <? $n = 0; ?>
            <? foreach ($arResult["MAIN"] as $key => $arItem) { ?>
                <? $classItem = "header-mobile-menu__item"; ?>
                <? if ($isFst) {
                    $classItem .= " header-mobile-menu__item_catalog";
                    $isFst = false;
                }
                if ($arItem['PARAMS']['DETAIL_PICTURE']) {
                    $classItem .= " has_icon";
                }
                if ($arParams['NO_SHOW_SUB'] == 'Y' && $n == 0) {
                    $classItem .= " header-mobile-menu__submenu-container_show";
                }
                ?>
                <? if ($arItem["IS_PARENT"]) { ?>
                    <div class="<?= $classItem ?>" data-name="<?= $arItem["PARENT_CODE"] ?>">

                        <?= $arItem["TEXT"] ?>

                        <div class="header-mobile-menu__item-chevron">
                            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.4911 0.156107L0.160949 0.483828C0.0586551 0.586571 0.00121773 0.72565 0.00121773 0.870633C0.00121773 1.01562 0.0586551 1.1547 0.160949 1.25744L3.90231 4.99636L0.159731 8.73894C0.0574374 8.84169 1.21542e-08 8.98077 1.04253e-08 9.12575C8.69642e-09 9.27073 0.0574374 9.40981 0.159731 9.51256L0.487447 9.84028C0.59019 9.94257 0.729267 10 0.87425 10C1.01923 10 1.15832 9.94257 1.26106 9.84028L5.73218 5.385C5.83939 5.284 5.90243 5.14479 5.90761 4.99758C5.90212 4.85081 5.8391 4.71208 5.73218 4.61139L1.27324 0.159762C1.16931 0.0573855 1.02927 1.2274e-08 0.883387 1.05343e-08C0.7375 8.7946e-09 0.597468 0.0573855 0.493535 0.159762L0.4911 0.156107Z" fill="#383838"/>
                            </svg>
                        </div>

                    </div>

                <? } else { ?>

                    <a href="<?= $arItem["LINK"] ?>" class="<?= $classItem ?>">
                        <?= $arItem["TEXT"] ?>
                    </a>

                <? } ?>

                <? $n++; ?>
            <? } ?>

        </div>
    <? endif; ?>
    <? if ($arParams['NO_SHOW_SUB'] != 'Y'): ?>
        <? $n = 0; ?>
        <? foreach ($arResult['CARDS'] as $key => $arMenuItems) { ?>
            <?
            $classItem = '';
            if ($arParams['NO_SHOW_LIST'] == 'Y' && $n == 0) {
                $classItem .= " header-mobile-menu__submenu-container_show";
            }
            ?>
            <div class="header-mobile-menu__submenu-container<?= $classItem ?>" data-name="<?= $key ?>">
                <? if ($arParams['NO_SHOW_LIST'] == 'Y'): ?>
                    <? $menuItem = $arMenuItems[0]["PARENT"] ?>
                    <a href="<?= $menuItem["LINK"] ?>" class="header-mobile-menu__submenu-back-btn js-headerMobileSubmenuBackBtn">

                        <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.4171 9.84389L5.74725 9.51617C5.84955 9.41343 5.90699 9.27435 5.90699 9.12937C5.90699 8.98438 5.84955 8.8453 5.74725 8.74256L2.00589 5.00364L5.74847 1.26106C5.85077 1.15831 5.9082 1.01923 5.9082 0.87425C5.9082 0.729267 5.85077 0.590186 5.74847 0.487443L5.42076 0.159724C5.31801 0.0574304 5.17894 8.69642e-09 5.03395 1.04253e-08C4.88897 1.21542e-08 4.74988 0.0574304 4.64714 0.159724L0.176028 4.615C0.0688086 4.716 0.00576979 4.85521 0.000597537 5.00242C0.00608641 5.14919 0.0690995 5.28792 0.176028 5.38861L4.63496 9.84024C4.7389 9.94261 4.87893 10 5.02482 10C5.1707 10 5.31074 9.94261 5.41467 9.84024L5.4171 9.84389Z" fill="#383838"/>
                        </svg>
                        <span><?= $menuItem["TEXT"] ?></span>

                    </a>
                <? else: ?>
                    <div class="header-mobile-menu__submenu-back-btn js-headerMobileSubmenuBackBtn">

                        <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.4171 9.84389L5.74725 9.51617C5.84955 9.41343 5.90699 9.27435 5.90699 9.12937C5.90699 8.98438 5.84955 8.8453 5.74725 8.74256L2.00589 5.00364L5.74847 1.26106C5.85077 1.15831 5.9082 1.01923 5.9082 0.87425C5.9082 0.729267 5.85077 0.590186 5.74847 0.487443L5.42076 0.159724C5.31801 0.0574304 5.17894 8.69642e-09 5.03395 1.04253e-08C4.88897 1.21542e-08 4.74988 0.0574304 4.64714 0.159724L0.176028 4.615C0.0688086 4.716 0.00576979 4.85521 0.000597537 5.00242C0.00608641 5.14919 0.0690995 5.28792 0.176028 5.38861L4.63496 9.84024C4.7389 9.94261 4.87893 10 5.02482 10C5.1707 10 5.31074 9.94261 5.41467 9.84024L5.4171 9.84389Z" fill="#383838"/>
                        </svg>
                        <span><?= $arMenuItems[0]["PARENT_TEXT"] ?></span>

                    </div>
                <? endif; ?>
                <div class="header-mobile-menu__submenu-item-list">

                    <? foreach ($arMenuItems as $menuItem) { ?>
                        <? if ($menuItem["UP_LEVEL"] == 'Y')
                            echo '<div depth_level="2">' ?>
                        <div class="header-mobile-menu__submenu-item" depth_level="<?= $menuItem["DEPTH_LEVEL"] ?>">
                          <? if ($APPLICATION->GetCurPAge(false) == $menuItem["LINK"]) { ?>
                            <span><?= $menuItem["TEXT"] ?></span>
                          <? } else { ?>
                            <a href="<?= $menuItem["LINK"] ?>"><?= $menuItem["TEXT"] ?></a>
                          <? } ?>

                        </div>
                        <? if ($menuItem["DOWN_LEVEL"] == 'Y')
                            echo '</div>' ?>
                    <? } ?>

                </div>

            </div>
            <? $n++; ?>
        <? } ?>
    <? endif; ?>

<? } ?>
