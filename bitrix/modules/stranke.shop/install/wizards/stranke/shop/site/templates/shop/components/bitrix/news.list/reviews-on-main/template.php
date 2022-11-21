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
include_once $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/localbusiness.php";

use \Stranke\Shop\Seo;

$this->setFrameMode(true);
$this->addExternalJs(SITE_TEMPLATE_PATH . "/js/modal-block.js");
?>

<? if (!empty($arResult["ITEMS"])): ?>
    <div class="reviews-on-main">
        <h2 class="reviews-on-main__title h1"><?=GetMessage('ST_REVIEWS_MAIN_TITLE')?></h2>

        <div class="reviews-on-main__list">
            <?
            $arOrder = [];
            $arFilter = ['ID' => $arParams['PARENT_SECTION'], 'IBLOCK_ID' => $arParams['IBLOCK_ID']];
            $arSelect = ['IBLOCK_ID', 'ID', 'NAME', 'UF_*'];
            $arSection = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect)->GetNext();
            ?>

            <div class="reviews-list">
                <?if (!empty($arSection)):?>
                    <div class="reviews-list__item reviews-list__item_common-rating">
                        <?$APPLICATION->IncludeComponent(
                            'stranke:rating.common', '',
                            [
                                'VALUE' => $arSection['UF_RATING'],
                                'COUNT' => $arSection['UF_RATING_COUNT'],
                                'LINK' => '/otzyvy/'
                            ],
                            $component,
                            ['HIDE_ICONS' => 'Y']
                        );?>
                    </div>
                <?endif?>

                <?
                $photos['moderator'] = CFile::ResizeImageGet($GLOBALS["OPTIONS"]["LOGO"], array("width" => 64, "height" => 64), 3);
                ?>

                <?foreach ($arResult["ITEMS"] as $arItem):?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    $userID = $arItem['PROPERTIES']['USER_BIND']['VALUE'];
                    $arUser = CUser::GetByID($userID)->Fetch();
                    $photoID = $arUser['PERSONAL_PHOTO'];
                    $img = CFile::ResizeImageGet($photoID, array("width" => 48, "height" => 48), 2);
                    $dateActiveJSON = FormatDate('Y-m-d', MakeTimeStamp($review["dateActive"], "YYYY-MM-DD HH:MI:SS"));
                    $metaName = $arItem["PROPERTIES"]["USER_NAME"]["VALUE"] . ' ' . $dateActiveJSON;
                    ?>
                    <div class="reviews-list__item" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                        <div class="reviews-list__item-header">
                            <div class="reviews-list__item-avatar">
                                <?if (!empty($img["src"])):?>
                                    <img src="<?= $img["src"] ?>" alt="user-photo">
                                <?else:?>
                                    <?
                                    if (!empty($arItem["PROPERTIES"]["USER_NAME"]["VALUE"])) {
                                        $userName = $arItem["PROPERTIES"]["USER_NAME"]["VALUE"];
                                    } else {
                                        $userName = $arUser['LOGIN'];
                                    }
                                    ?>
                                    <span><?= strtoupper(mb_substr($userName, 0,1, 'UTF-8')); ?></span>
                                <?endif?>
                            </div>

                            <div class="reviews-list__item-info">
                                <div class="reviews-list__item-name"><?=$userName?>,</div>

                                <div class="reviews-list__item-date">
                                    <?
                                    $date = explode(" ", $arItem["ACTIVE_FROM"]);
                                    echo $date[0];
                                    ?>
                                </div>

                                <?if (!empty($arItem["PROPERTIES"]["MARKER"]["VALUE"])):?>
                                    <div class="reviews-list__item-rating">
                                        <?
                                        $count = 0;
                                        $rate = $arItem["PROPERTIES"]["MARKER"]["VALUE"];

                                        while ($count < 5) {
                                            echo $rate > $count ? '<i class="star star_active"></i>' : '<i class="star"></i>';
                                            $count = $count + 1;
                                        }
                                        ?>
                                    </div>
                                <?endif?>
                            </div>
                        </div>

                        <div class="reviews-list__item-text"><?=$arItem["~PREVIEW_TEXT"]?></div>

                        <?if (!empty($arItem["~DETAIL_TEXT"])):?>
                            <div class="reviews-list__item-answer">
                                <?
                                $imgModerator = CFile::ResizeImageGet($GLOBALS["OPTIONS"]["LOGO"], array("width" => 48, "height" => 48), 3);
                                ?>
                                <div class="reviews-list__item-header">
                                    <div class="reviews-list__item-avatar">
                                        <?if (!empty($imgModerator['src'])):?>
                                            <img src="<?= $imgModerator['src'] ?>" alt="user-photo">
                                        <?else:?>
                                            <i class="fas fa-user"></i>
                                        <?endif?>
                                    </div>

                                    <div class="reviews-list__item-info">
                                        <div class="reviews-list__item-name"><?=GetMessage('ST_REVIEWS_MAIN_ADMINISTRATION')?>,</div>

                                        <div class="reviews-list__item-date">
                                            <?= FormatDate('d.m.Y', MakeTimeStamp($arItem['TIMESTAMP_X'], "YYYY-MM-DD HH:MI:SS")); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="reviews-list__item-text"><?=$arItem["~DETAIL_TEXT"]?></div>
                            </div>
                        <?endif?>

                        <?if ($arItem["PROPERTIES"]["MARKER"]["VALUE"] > 0):?>
                            <?
                            $ldJson = [
                                "@context" => "http://schema.org/",
                                "@type" => "Review",
                                "itemReviewed" => [
                                    "@type" => "LocalBusiness",
                                    "url" => $url,
                                    "name" => $name,
                                    "contactPoint" => $contactPoint,
                                    "address" => $address,
                                    "image" => $logo,
                                    "telephone" => $phone
                                ],
                                "reviewRating" => [
                                    "@type" => "Rating",
                                    "ratingValue" => $arItem["PROPERTIES"]["MARKER"]["VALUE"],
                                    "bestRating" => "5"
                                ],
                                "name" => $metaName,
                                "author" => [
                                    "@type" => "Person",
                                    "name" => $arItem["PROPERTIES"]["USER_NAME"]["VALUE"]
                                ],
                                "reviewBody" => $arItem["PREVIEW_TEXT"],
                                "publisher" => [
                                    "@type" => "Organization",
                                    "name" => $GLOBALS['JSON+LD']['ORG_NAME']['VALUE']
                                ]
                            ];
                            ?>
                            <script type="application/ld+json"><?= Seo::ldJson($ldJson); ?></script>
                        <?endif?>
                    </div>
                <?endforeach?>
            </div>
        </div>
    </div>
<?endif?>
