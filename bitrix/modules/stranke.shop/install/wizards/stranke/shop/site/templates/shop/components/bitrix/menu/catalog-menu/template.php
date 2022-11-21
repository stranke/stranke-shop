<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CJSCore::Init();
?>
<div class="catalog-nav-bar">
  <div class="catalog-nav-bar__item-list" id="catalog-nav-bar__item-list-id">
    <? foreach ($arResult as $arItem) { ?>
        <?if($arItem["SELECTED"]):?>
            <span data-href="<?=$arItem["LINK"]?>" class="catalog-nav-bar__item active" itemprop="url">
                <span itemprop="name"><?=$arItem["TEXT"]?></span>
            </span>
        <?else:?>
            <a href="<?=$arItem["LINK"]?>" class="catalog-nav-bar__item" itemprop="url">
                <span itemprop="name"><?=$arItem["TEXT"]?></span>
            </a>
        <?endif?>

    <? } ?>
      <div id="desktop-long-menu-container"><div class="desktop-long-menu"></div></div>
  </span>

    <style>

        #desktop-long-menu-container {
            display: none;
            position: fixed;
            top: 34px;
            right: 15px;
            cursor: pointer;
            width: 10px;
            height: 40px;
        }

        .desktop-long-menu {
            position: fixed;
            top: 40px;
            right: 15px;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background-color: white;
            box-shadow: 0px 6px 0px white, 0px 12px 0px white
        }

        #desktop-long-menu-container:hover > div.desktop-long-menu {
            width: 4px;
            height: 4px;
        }

        #long_menu {
            position: fixed;
            right: 0;
            top: 71px;
            background: #e74c3c;
        }
    </style>
</div>
