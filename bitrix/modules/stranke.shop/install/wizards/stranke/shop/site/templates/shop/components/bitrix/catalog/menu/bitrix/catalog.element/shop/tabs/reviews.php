<?
/**
 * @var array $arParams
 * @var array $templateFolder
 */


$this->setFrameMode(true);
$this->addExternalCss($templateFolder . '/css/reviews.css');
$this->addExternalJs(SITE_TEMPLATE_PATH . "/js/modal-block.js");
$reviews = \Stranke\Shop\Reviews::getInstance();


$arReviewSection = CIBlockSection::GetList(
    array(),
    array("IBLOCK_ID" => $reviews->iblockId, 'NAME' => $arResult['ID'])
)->Fetch();

$rows = [];
if (!empty($arReviewSection['ID'])) {
    $propIdUserName = $reviews->propIdUserName;
    $propIdRating = $reviews->propIdRating;

    $sectionId = $arReviewSection['ID'];
    $sql = "
        SELECT
        ELEMENT.NAME as reviewName,
        ELEMENT.PREVIEW_TEXT as review,
        ELEMENT.DETAIL_TEXT as answer,
        ELEMENT.DATE_CREATE as dateTimecreate,
        ELEMENT.ACTIVE_FROM as dateActive,
        ELEMENT.TIMESTAMP_X as dateTimeModify,
        ELEMENT.ACTIVE as active,
        PROPERTIE_NAME.VALUE as userName,
        USER.PERSONAL_PHOTO as photoId,
        ELEMENT.DETAIL_PICTURE as AnswerPhotoId,
        PROPERTIES.VALUE as rate,
        PROPERTY_USER.VALUE as user_id
        
        FROM b_iblock_element AS ELEMENT
            LEFT JOIN (
                SELECT * FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = (
                    SELECT ID FROM b_iblock_property WHERE CODE = 'USER_BIND'
                    )
                ) AS PROPERTY_USER
            ON ELEMENT.ID = PROPERTY_USER.IBLOCK_ELEMENT_ID
            
            LEFT JOIN b_user AS USER
            ON PROPERTY_USER.VALUE = USER.ID
                
            LEFT JOIN (SELECT * FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = $propIdUserName) AS PROPERTIE_NAME
            ON ELEMENT.ID = PROPERTIE_NAME.IBLOCK_ELEMENT_ID
                
            LEFT JOIN (SELECT * FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = $propIdRating) AS PROPERTIES
            ON ELEMENT.ID = PROPERTIES.IBLOCK_ELEMENT_ID
        
        WHERE ELEMENT.ID IN (SELECT IBLOCK_ELEMENT_ID FROM b_iblock_section_element WHERE IBLOCK_SECTION_ID = $sectionId)
        AND ELEMENT.ACTIVE = 'Y'
        ORDER BY ELEMENT.DATE_CREATE DESC
        ";

    $rows = $DB->Query($sql);
}

$className = 'reviews reviews_product';
if ($rows && !$rows->SelectedRowsCount()) {
    $className .= ' reviews_empty';
}
?>

<?
$arOrder = [];
$arFilter = array(
    'NAME' => $arResult['ID'],
    'IBLOCK_ID' => $reviews->iblockId,
);
$arSelect = array(
    'IBLOCK_ID', 'ID', 'NAME', 'UF_*'
);
$arSection = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect)->GetNext();
?>

<? if (!empty($arSection)) { ?>
<?
$sectionCommentCountLabel = '';
$sectionCommentCount = $arSection['UF_RATING_COUNT'];
?>
<? if ($sectionCommentCount >= 5 && $sectionCommentCount <= 20) {
    $sectionCommentCountLabel = GetMessage('ST_REVIEWS');
} else {
    $sectionCommentCount = $sectionCommentCount % 10;
    if ($sectionCommentCount === 1) {
        $sectionCommentCountLabel = GetMessage('ST_REVIEW');
    } else if ($sectionCommentCount >= 2 && $sectionCommentCount <= 4) {
        $sectionCommentCountLabel = GetMessage('ST_REVIEW_S');
    } else {
        $sectionCommentCountLabel = GetMessage('ST_REVIEWS');
    }
} ?>
<div class="<?= $className ?>">
    <div class="reviews__main-container catalog_element">

        <? if ($arSection['UF_RATING_COUNT'] > 0) { ?>

            <div class="reviews__rating-common mobile">
                <? $APPLICATION->IncludeComponent(
                    'stranke:rating.common',
                    '',
                    [
                        'TITLE' => GetMessage('ST_REVIEWS_PRODUCT'),
                        'VALUE' => $arSection['UF_RATING'],
                        'COUNT' => $arSection['UF_RATING_COUNT'],
                        'LINK' => $link,
                    ],
                    $component,
                    ['HIDE_ICONS' => 'Y']
                ); ?>
            </div>

            <h2 class="reviews__title h2"><?= GetMessage('ST_REVIEWS_PRODUCT') ?></h2>

            <div class="reviews__general-rating-block"
                 itemprop="aggregateRating"
                 itemscope
                 itemtype="http://schema.org/AggregateRating">

                <!--        <div class="reviews__general-rating-text">-->
                <!--            --><? //=GetMessage('ST_PRODUCT_DETAIL_BOTTOM_COMMON_RATING')?><!-- (<span itemprop="reviewCount">--><? //=$arSection['UF_RATING_COUNT']?><!--</span>--><? //=' '.$sectionCommentCountLabel?><!--)-->
                <!--        </div>-->

                <div class="reviews__general-rating">

                    <?
                    $count = 1;
                    $rate = round($arSection['UF_RATING']);
                    ?>
                    <!--          <div style="display: none" itemprop="ratingValue">--><? //=$arSection['UF_RATING']?><!--</div>-->

                    <meta itemprop="ratingValue" content="<?= $arSection['UF_RATING'] ?>"/>
                    <meta itemprop="reviewCount" content="<?= $arSection['UF_RATING_COUNT'] ?>"/>
                    <meta itemprop="bestRating" content="5"/>
                    <meta itemprop="worstRating" content="1"/>
                    <!--          --><? //
                    //          while ($count <= 5) {
                    //            if ($rate >= $count) { ?>
                    <!--              <i class="fa fa-star good"></i>-->
                    <!--            --><? // } else { ?>
                    <!--              <i class="fa fa-star bad"></i>-->
                    <!--            --><? // }
                    //            $count = $count + 1;
                    //          }
                    //          ?>

                </div>

            </div>
        <? } ?>
        <? } ?>

        <? if ($rows) {
            $reviews = array();
            $photos = array();
            ?>

            <? while ($row = $rows->GetNext()) { ?>
                <? $reviews[] = $row; ?>

                <? if (!in_array($row['photoId'], array_keys($photos))) { ?>
                    <? $photos[$row['photoId']] = CFile::ResizeImageGet($row['photoId'], array("width" => 48, "height" => 48), 2); ?>
                <? } ?>

                <? $photos['moderator'] = CFile::ResizeImageGet($GLOBALS["OPTIONS"]["LOGO"], array("width" => 48, "height" => 48), 1); ?>

            <? } ?>
        <? } ?>

        <? // Только три отзыва в описании
        $link = '';
        if ($arParams['TYPE'] !== 'reviews' && count($reviews) > 3) {
            $link = $arResult["DETAIL_PAGE_URL"] . 'reviews/';
        } ?>

        <div class="reviews__top">

            <div class="reviews__rating-common">
                <? $APPLICATION->IncludeComponent(
                    'stranke:rating.common',
                    '',
                    [
                        'TITLE' => GetMessage('ST_REVIEWS_PRODUCT'),
                        'VALUE' => $arSection['UF_RATING'],
                        'COUNT' => $arSection['UF_RATING_COUNT'],
                        'LINK' => $link,
                    ],
                    $component,
                    ['HIDE_ICONS' => 'Y']
                ); ?>
            </div>
            <? $frame = $this->createFrame()->begin(""); ?>
            <div class="reviews__form"></div>

            <script>
                getProductReviewForm($('.reviews__form'), <?=$arResult['ID']?>);
            </script>
            <? $frame->end(); ?>
        </div>

        <?

        if (!empty($arReviewSection['ID'])) { ?>
            <? if ($rows) { ?>
                <div class="reviews-list">
                    <? $cnt = 0; ?>

                    <? foreach ($reviews as $review) { ?>

                        <? // Только три отзыва в описании
                        if ($arParams['TYPE'] !== 'reviews' && $cnt > 2 && count($reviews) > 3) {
                            break;
                        } ?>
                        <?
                        $img = $photos[$review['photoId']];
                        $imgModerator = $photos['moderator'];

                        $review["dateTimeCreate"] = FormatDate('d.m.Y', MakeTimeStamp($review["dateTimeCreate"], "YYYY-MM-DD HH:MI:SS"));
                        $review["dateTimeModify"] = FormatDate('d.m.Y', MakeTimeStamp($review["dateTimeModify"], "YYYY-MM-DD HH:MI:SS"));
                        $review["dateActive"] = FormatDate('d.m.Y', MakeTimeStamp($review["dateActive"], "YYYY-MM-DD HH:MI:SS"));
                        $dateActiveJSON = FormatDate('Y-m-d', MakeTimeStamp($review["dateActive"], "YYYY-MM-DD HH:MI:SS"));
                        ?>
                        <? if ($review['active'] == 'Y') { ?>

                            <div class="reviews-list__item" id="bx_3218110189_19029">
                                <meta itemprop="author" content="<?= $review['userName'] ?>">
                                <meta itemprop="name" content="<?= $review['userName'] . ', ' . $review["dateActive"] ?>">
                                <meta itemprop="datePublished" content="<?= $dateActiveJSON ?>">
                                <meta itemprop="description" content="<?= $review["review"] ?>">

                                <div class="reviews-list__item-header">
                                    <div class="reviews-list__item-avatar">

                                        <? if (!empty($img["src"])) { ?>
                                            <img src="<?= $img["src"] ?>" alt="user-photo">
                                        <? } else { ?>
                                            <? $firstLetter = strtoupper(mb_substr($review['userName'], 0, 1, 'UTF-8')); ?>
                                            <span><?= $firstLetter ?></span>
                                            <span></span>
                                        <? } ?>
                                    </div>

                                    <div class="reviews-list__item-info">
                                        <div class="reviews-list__item-name"><?= $review['userName'] . ' ,' ?></div>
                                        <div class="reviews-list__item-date"><?= $review["dateActive"] ?></div>

                                        <div class="reviews-list__item-rating">
                                            <?
                                            $count = 0;
                                            $rate = $review['rate'];

                                            while ($count < 5) {
                                                if ($rate > $count) { ?>
                                                    <i class="star star_active"></i>
                                                <? } else { ?>
                                                    <i class="star"></i>
                                                <? }
                                                $count = $count + 1;
                                            } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="reviews-list__item-text"><?= $review["review"] ?></div>

                                <? if (!empty($review['answer'])): ?>
                                    <div class="reviews-list__item-answer">
                                        <div class="reviews-list__item-header">
                                            <div class="reviews-list__item-avatar">
                                                <? if (empty($imgModerator['src'])): ?>

                                                <? else: ?>
                                                    <img src="<?= $imgModerator['src'] ?>" alt="user-photo">
                                                <? endif ?>
                                            </div>

                                            <div class="reviews-list__item-info">
                                                <div class="reviews-list__item-name"><?= GetMessage('ST_PRODUCT_DETAIL_BOTTOM_ADMIN') ?>,</div>

                                                <div class="reviews-list__item-date"><?= $review["dateTimeModify"] ?></div>
                                            </div>
                                        </div>

                                        <div class="reviews-list__item-text"><?= $review["answer"] ?></div>
                                    </div>
                                <? endif ?>

                                <script type="application/ld+json"></script>
                            </div>

                            <? $cnt++;
                        } ?>
                    <? } ?>
                </div>
            <? } ?>
        <? } ?>
    </div>
</div>

<script>
    $(function () {
        var $stars = $(".reviews-form__rating-value .star");

        var $sendReview = $('.js-sendReview');
        var inputs = $('input[required]');
        var $checkbox = $('#checkbox');
        var checkboxLabel = $checkbox;

        window.$stars = $stars;

        function sendReview(e) {
            e.preventDefault();

            var $form = $sendReview.closest("form");

            var testValid = isValidForm();

            if (testValid) {

                var data = $form.serialize(),
                    success = function success(json) {
                        if (json.status === true) {
                            OpenModalMessage();
                            clearFields();
                        } else {
                            //  ����� ���� �� ������ �������� ������
                        }
                    };

                $.ajax({
                    url: "<?=SITE_DIR?>ajax/forms/new-product-review.php",
                    type: "post",
                    data: data,
                    dataType: "json",
                    success: success
                });
            }
        }

        var starHover = function () {
            var index = $stars.index(this) + 1;
            $stars.slice(0, index).addClass("star_active");
        };

        window.starHover = starHover;

        var starClick = function () {
            var index = $stars.index(this) + 1;
            $("#rating").val(index).trigger('change');
            starsMouseLeave();
        };

        window.starClick = starClick;

        var starsMouseLeave = function () {
            var rating = void 0;
            rating = $("#rating").val();
            $stars
                .slice(rating)
                .removeClass("star_active");
        };

        window.starsMouseLeave = starsMouseLeave;

        function isValidForm() {
            var testText = $('#msgReview').val();
            var testRate = $('#rating').val();
            var $errorCount = 0;

            if (testRate == 0) {
                $errorCount++;
                $('.reviews-form__rating').addClass('field-error');
            }


            if (inputs.length > 0) {
                inputs.each(function () {
                    var $input = $(this);

                    if (($input.val().length < 1) || ($input.hasClass('phone-mask') && $input.val().length < 18)) {
                        $errorCount++;
                        $input.closest('.reviews-form__input-container').addClass('field-error');
                    }

                    if ($input.attr('name') == 'email') {
                        var isValidEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($input.val());

                        if (!isValidEmail) {
                            $input.closest('.reviews-form__input-container').addClass('field-error');
                            $input.val('');
                            $input.attr('placeholder', '������������ email');
                            $errorCounter++;
                        }

                    }

                });
            }


            if (testText.length < 1) {
                $errorCount++;

                $('#msgReview').closest('.reviews-form__text').addClass('field-error');
            }

            if (checkboxLabel.length > 0 && !$checkbox.prop('checked')) {
                $errorCount++;
                $checkbox.closest('label').addClass('field-error');
            }

            return $errorCount === 0;
        }

        function removeError() {
            $(this).closest('.field-error').removeClass('field-error');
        }

        function clearFields() {
            $('.reviews-form__field-control').val('');
            $('#rating').val(0);
            $stars.removeClass('star_active');
            $checkbox.attr("checked", false);
        }

        /** add handlers **/

        $stars.hover(starHover).on("click", starClick);
        $stars.mouseleave(starsMouseLeave);

        $sendReview.on("click", sendReview);
        $('.reviews-form__field-control').on('click', removeError);
        $stars.on('click', removeError);
        $('label').on('click', function () {
            $(this).removeClass('field-error');
        })

        $('.reviews__form').on('loaded', function () {
            $stars = $(".reviews-form__rating-value .star");
            $stars.hover(starHover).on("click", starClick);
            $stars.mouseleave(starsMouseLeave);
        });
    });


    var $inputPhone = $('.phone-mask');

    $inputPhone.each(function (index, element) {

        vanillaTextMask.maskInput({
            inputElement: $inputPhone[index],
            mask: ['+', '7', ' ', '(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, '-', /\d/, /\d/],
        });
    });
</script>
