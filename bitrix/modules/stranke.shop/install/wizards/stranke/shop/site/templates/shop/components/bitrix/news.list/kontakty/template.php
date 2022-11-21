<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>

<!-- контейнер с нижним блоком -->
<div class="contacts__dop-info">

  <div class="contacts__dop-info-item-list">

    <?$i = 0;?>

    <? foreach ($arResult['ITEMS'] as $item) { ?>

      <div class="contacts__dop-info-item">

        <?
          $img = CFile::ResizeImageGet(
              $item['PREVIEW_PICTURE']['ID'],
              array("width"=>392, "height"=>392),
              BX_RESIZE_IMAGE_EXACT
          );
        ?>

        <? if ($i !== 1) {?>

          <div class="contacts__dop-info-item-photo" style="background-image: url(<?=$img['src']?>)">

          </div>

          <div class="contacts__dop-info-item-info">

            <div class="contacts__dop-info-item-info-helper"></div><!--
            --><div class="contacts__dop-info-item-info-content">
             <div class="contacts__dop-info-item-name">
               <?=$item['NAME']?>
             </div>

             <div class="contacts__dop-info-item-description">
               <?=$item['PREVIEW_TEXT']?>
             </div>

              <div class="contacts__dop-info-item-btn-container">

                <a href="<?=$item['PROPERTIES']['BTN_LINK']['VALUE']?>" class="contacts__dop-info-item-btn">
                  <?=$item['PROPERTIES']['BTN_NAME']['VALUE']?>
                </a>

              </div>

            </div>

          </div>

        <? } else { ?>

          <div class="contacts__dop-info-item-info">

            <div class="contacts__dop-info-item-info-helper"></div><!--
            --><div class="contacts__dop-info-item-info-content">
              <div class="contacts__dop-info-item-name">
                <?=$item['NAME']?>
              </div>

              <div class="contacts__dop-info-item-description">
                <?=$item['PREVIEW_TEXT']?>
              </div>

              <div class="contacts__dop-info-item-btn-container">

                <a href="<?=$item['PROPERTIES']['BTN_LINK']['VALUE']?>" class="contacts__dop-info-item-btn">
                  <?=$item['PROPERTIES']['BTN_NAME']['VALUE']?>
                </a>

              </div>

            </div>

          </div>

          <div class="contacts__dop-info-item-photo" style="background-image: url(<?=$img['src']?>)">

          </div>

        <? } ?>

      </div>

      <?$i++;?>

    <? } ?>

  </div>

</div>


