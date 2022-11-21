<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css')) {
  $APPLICATION->SetAdditionalCSS($this->GetFolder() . '/themes/' . $arParams["MENU_THEME"] . '/colors.css');
}

CJSCore::Init();

?>
<div class="main-nav-bar__item-list">
<? foreach ($arResult["ALL_ITEMS"] as $arItem) { ?>
  <? if ($APPLICATION->GetCurPage(false) === $arItem["LINK"]) {?>
    <span data-href="<?= $arItem["LINK"]?>" class="main-nav-bar__item main-nav-bar__item_current">
      <?= $arItem["TEXT"]?>
    </span>
  <? } else { ?>
    <a href="<?= $arItem["LINK"]?>" class="main-nav-bar__item" itemprop="url">
      <span itemprop="name"><?= $arItem["TEXT"]?></span>
    </a>
  <? } ?>
<? } ?>
</div>


