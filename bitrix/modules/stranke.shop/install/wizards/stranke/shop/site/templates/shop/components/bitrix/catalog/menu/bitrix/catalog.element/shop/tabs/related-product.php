<? if (!empty($arResult['PROPERTIES']['RELATED_PRODUCTS']['VALUE'])) { ?>
<div class="page-container_detail-product products-related-block ">
  <h2><?=GetMessage('ST_PRODUCT_DETAIL_BOTTOM_RELATED')?></h2>
  <?
  $obRElements = CIBlockElement::GetList(
  array(),
  array('ID'=>$arResult['PROPERTIES']['RELATED_PRODUCTS']['VALUE'], 'IBLOCK_ID'=> $arParams['IBLOCK_ID']),
  false,
  false,
  array('ID', 'IBLOCK_ID','IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'OFFERS', 'PROPERTY_TIME')
  );

  function cmp1($a, $b)
  {
    return strcmp($a["SORT"], $b["SORT"]);
  }

  while ($resRElement = $obRElements->GetNextElement()) {
    $arElProps['fields'] = $resRElement->GetFields();
    $arElProps['props'] = $resRElement->GetProperties();

    $arRelElements[$arElProps['fields']['ID']] = $arElProps;

    $obOffers = CIBlockElement::GetList(
        array('SORT'=>'ASC'),
        array('IBLOCK_ID'=>6, 'PROPERTY_CML2_LINK'=>$arElProps['fields']['ID']),
        false,
        false,
        array('CATALOG_WEIGHT', 'ID', 'NAME')
    );
    $arOffers = array();
    while ($arOffer = $obOffers->GetNext()) {
      $arOffers[] = $arOffer;
    }

    $arRelElements[$arElProps['fields']['ID']]['OFFERS'] = $arOffers;

  }

  ?>

  <div class="products-related">
      <div class="products-related__item-list"><!--
      <? foreach ($arRelElements as $arItem) { ?>
          --><div class="products-related__item-container products-related__item-container_related ">
          <div class="products__item">
            <?
            $img = CFile::ResizeImageGet(
              $arItem['fields']['PREVIEW_PICTURE'],
              array('width' => 442, 'height' => 221),
              BX_RESIZE_IMAGE_PROPORTIONAL,
              true
            );

            if (empty($img['src'])) {
              $img = CFile::ResizeImageGet(
                $GLOBALS["OPTIONS"]["NO_PHOTO_PRODUCT_PREVIEW"],
                array('width' => 442, 'height' => 221),
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
              );
            }

            ?>
            <div class="products__item-img" data-href="<?= $arItem['fields']['DETAIL_PAGE_URL'] ?>">
              <canvas width="2" height="1"></canvas>
              <img src="<?= $img['src'] ?>"
                   alt="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_META_TITLE']?>"
                   title="<?=$arItem['IPROPERTY_VALUES']['ELEMENT_META_TITLE']?>"
              >

            </div>

            <div class="products__item-info">

              <div class="products__item-info-block-1">

                <div class="products__item-name">
                  <a href="<?= $arItem['fields']['DETAIL_PAGE_URL'] ?>">
                    <?= $arItem['fields']["NAME"] ?>
                  </a>
                </div>

                <div class="products__item-offer-list">


                  <? if ($arItem['IBLOCK_SECTION_ID'] != 394) {?>
                    <?$messure = 'гр.'?>
                  <? } else { ?>
                    <?$messure = 'мл.'?>
                  <? } ?>
                  <? if (is_array($arItem['OFFERS'])) { ?>
                    <? $i = 0; ?>

                    <?usort($arItem['OFFERS'], "cmp1");?>



                    <? foreach ($arItem['OFFERS'] as $arOffer) { ?>

                        <?
                        $price = CPrice::GetBasePrice($arOffer['ID']);
                        $price = explode('.', $price['PRICE']);
                        $price = $price[0]." р.";
                        ?>

                        <div class="products__item-offer <? if ($i == 0) { ?>products__item-offer_selected<? } ?>"
                             data-productid="<?= $arOffer['ID'] ?>"
                             role="offer"
                        >
                          <span class="products__item-offer-icon"></span>
                          <div class="products__item-offer-weight">
                              <span>
                                  <? if ($arOffer['CATALOG_WEIGHT'] !== '') { ?>
                                    <?=$arOffer['CATALOG_WEIGHT']." ".$messure?>
                                  <? } elseif ($arOffer['PROPERTIES']['VOLUME']['VALUE']) {?>
                                    <?=$arOffer['PROPERTIES']['VOLUME']['VALUE']?>
                                  <? } ?>
                              </span>
                          </div>

                          <div class="products__item-offer-price">
                            <span><?= $price ?></span>
                          </div>

                        </div>
                        <? $i++; ?>

                    <? } ?>
                    <? $i = 0; ?>
                  <? } else { ?>
                    <?
                    $price = CPrice::GetBasePrice($arItem['ID']);
                    $price = explode('.', $price['PRICE']);
                    $price = $price[0]." р.";
                    ?>
                    <div class="products__item-offer products__item-offer_selected"
                         data-productid="<?= $arItem['ID'] ?>">
                      <span class="products__item-offer-icon"></span>

                      <div class="products__item-offer-weight">
                        <? if (!empty($arItem['CATALOG_WEIGHT'])): ?>
                          <span>
                                    <?= $arItem['CATALOG_WEIGHT'] ?>
                                    <?= $messure ?>
                                </span>
                        <? endif ?>
                      </div>

                      <div class="products__item-offer-price">
                        <span><?= $arItem['MIN_PRICE']['PRINT_VALUE'] ?></span>
                      </div>
                    </div>
                  <? } ?>

                </div>

              </div>

              <div class="products__item-info-block-2">

                <div class="products__item-btn">

                  <div class="products__item-btn-text js-productBtn">
                    В заказ
                  </div>

                </div>

                <?
                $ingredients = $arItem['fields']['PREVIEW_TEXT'];
                $time = $arItem['props']['TIME']['VALUE'];
                ?>

                <div class="products__item-properties">
                  <? if (!empty($ingredients)) { ?>
                    <div class="products__item-consist-btn js-productTimeBtn">
                      <span>Состав</span>
                      <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="products__item-consist">
                      <span><?=$ingredients?></span>
                    </div>
                  <? } ?>
                  <? if (!empty($time)) { ?>
                    <div class="products__item-time">
                      <i class="far fa-clock"></i>
                      <span><?=$time?></span>
                    </div>

                    <div class="products__item-time">
                      <span><?= $time ?></span>
                    </div>
                  <? } ?>

                </div>

              </div>

            </div>

          </div>

        </div><!--

        <? } ?>

    --></div>

    </div>

</div>

  <script>

      $(document).ready(function () {
        function SetMaxHeightAdvantages() {

          var mainDivs = document.getElementsByClassName('products__item-info');
          var maxHeight = 0;

          for (var i = 0; i < mainDivs.length; ++i) {

            if (maxHeight < mainDivs[i].clientHeight) {
              maxHeight = mainDivs[i].clientHeight;
            }
          }

          for (var i = 0; i < mainDivs.length; ++i) {
            mainDivs[i].style.height = maxHeight + "px";
          }
        }

        SetMaxHeightAdvantages();
        $(window).resize(SetMaxHeightAdvantages);
      });
  </script>
<? } ?>