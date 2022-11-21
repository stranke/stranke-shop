<div class="product__bottom-block">

  <div class="product__photo">

      <h2 class="product__subtitle h2">
        <?=$arProp['PHOTO']['NAME']?>
      </h2>

      <div class="product__photo-list">

        <? foreach ($arPhotoElementsID as $photoID) { ?>

          <div class="product__photo-element-container">

            <?
              $picOrigin = CFile::GetFileArray($photoID);
              $pic = CFile::ResizeImageGet(
                $photoID,
                array('width'=> 118, 'height'=>72),
                BX_RESIZE_IMAGE_EXACT
              );
            ?>

           <div class="product__photo-element js-photo-swipe-btn">
             <canvas width="2" height="1"></canvas>
             <img src="<?=$pic['src']?>"
                  alt=""
                  data-originalSrc="<?=$picOrigin["SRC"]?>"
                  data-originalWidth="<?=$picOrigin["WIDTH"]?>"
                  data-originalHeight="<?=$picOrigin["HEIGHT"]?>"
             >
           </div>

          </div>

        <? } ?>
      </div>

  </div>

</div>


