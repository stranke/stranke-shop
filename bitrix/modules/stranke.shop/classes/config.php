<?php

namespace Stranke\Shop;

class Config
{
    const IBLOCK_CATALOG = 'catalog_products_' . SITE_ID;
    const IBLOCK_OFFERS = 'catalog_offers_' . SITE_ID;
    const IBLOCK_REVIEWS = 'content_reviews_' . SITE_ID;
    const IBLOCK_ADVANTAGES = 'content_advantages_' . SITE_ID;
    const IBLOCK_SLIDER = 'content_slider_' . SITE_ID;
    const IBLOCK_DISCOUNTS = 'content_discounts_' . SITE_ID;

    private static $instance;

    public $isMainPage = false;
    public $iblockId = null;
    public $element = null;
    public $properties = [];
    public $elementId = null;

    public $telegram = '';
    public $whatsapp = '';
    public $viber = '';
    public $vk = '';
    public $fb = '';
    public $insta = '';
    public $youtube = '';
    public $ya_dzen = '';

    public $app_store_link = '';
    public $google_play_link = '';
    public $app_gallery_link = '';

    public $information = '';
    public $textFooter = '';
    public $textFooterOriginal = '';
    public $logo = '';

    public $gtm = '';
    public $ym = '';
    public $otherCode = '';

    public $ymTargetSuccessOrder = ''; // TARGET_SUCCESS_ORDER

    public $isShowSliderOnMain = false;
    public $isShowAdvantagesOnMain = false;
    public $isShowMenuOnMain = false;
    public $isShowBestsellersOnMain = false;
    public $isShowReviewsListOnMain = false;
    public $isShowReLinkOnMain = false;

    public $phones = [];
    public $address = [];

    public $addressLocality = [];

    public $iblockIdCatalog;
    public $iblockIdOffers;
    public $iblockIdReviews;
    public $iblockIdAdvantages;
    public $iblockIdSlider;
    public $iblockIdDiscounts = null;

    public $colorDiscountShield = '#4f55fd';
    public $colorShildNew = '#2659e2';
    public $colorShildHit = '#b127e2';

    public $targets = [];

    public $openGraphImage = '';

    public $basketTerms = '';

    public $organizationName = '';


    public static function getInstance(): Config
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        \Bitrix\Main\Loader::includeModule('iblock');

        $this->views = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/stranke.shop/views';
        $this->isMainPage = $this->getCurUri() === SITE_DIR || $this->getCurUri() === SITE_DIR . 'amp/';

        $arFilter = ['TYPE' => 'services', 'SITE_ID' => SITE_ID];
        $arIblock = \CIBlock::GetList([], $arFilter)->Fetch();
        $this->iblockId = $arIblock['ID'];

        $arFilter = ['IBLOCK_ID' => $this->iblockId];
        $oElement = \CIBlockElement::GetList([], $arFilter)->GetNextElement();
        if (empty($oElement)) return;

        $this->element = $oElement->GetFields();
        $this->elementId = $this->element['ID'];
        $this->properties = $oElement->GetProperties();

        $this->phones = $this->properties["PHONES"]["VALUE"];
        $this->address = $this->properties["ADDRESS"]["VALUE"];
        $this->addressLocality = $this->properties["addressLocality"]["VALUE"];

        $this->telegram = $this->properties["SOCIAL_TELEGRAM"]["VALUE"];
        $this->whatsapp = $this->properties["SOCIAL_WHATSAPP"]["VALUE"];
        $this->viber = $this->properties["SOCIAL_VIBER"]["VALUE"];
        $this->vk = $this->properties["SOCIAL_WEBS_VK"]["VALUE"];
        $this->fb = $this->properties["SOCIAL_WEBS_FB"]["VALUE"];
        $this->insta = $this->properties["SOCIAL_WEBS_INSTA"]["VALUE"];
        $this->youtube = $this->properties["SOCIAL_YOUTUBE"]["VALUE"];
        $this->ya_dzen = $this->properties["SOCIAL_YANDEX_DZEN"]["VALUE"];

        $this->app_store_link = $this->properties["APP_STORE_LINK"]["VALUE"];
        $this->google_play_link = $this->properties["GOOGLE_PLAY_LINK"]["VALUE"];
        $this->app_gallery_link = $this->properties["APP_GALLERY_LINK"]["VALUE"];

        if (!empty($this->properties["BASKET_TERMS"]["VALUE"])) {
            $this->basketTerms = $this->properties["BASKET_TERMS"]["VALUE"]['TEXT'];
        }

        if (!empty($this->properties["LOGO"]["VALUE"])) {
            $logoFileId = $this->properties["LOGO"]["VALUE"];
            $logoImg = \CFile::ResizeImageGet($logoFileId, [], 2);
            $this->logo = $logoImg['src'];
        } else {
            $this->logo = '';
        }

        if (!empty($this->properties["LOGO"]["VALUE"])) {
            $logoFileId = $this->properties["LOGO"]["VALUE"];
            $logoImg = \CFile::ResizeImageGet($logoFileId, [], 2);
            $this->logo = $logoImg['src'];
        } else {
            $this->logo = '';
        }

        if (!empty($this->properties["INFORMATION"]["VALUE"]['TEXT'])) {
            $this->information = $this->properties["INFORMATION"]["~VALUE"]['TEXT'];
            $this->informationOriginal = $this->properties["INFORMATION"]["VALUE"]['TEXT'];
        }

        if (!empty($this->properties["TEXT_FOOTER"]["VALUE"]['TEXT'])) {
            $this->textFooter = $this->properties["TEXT_FOOTER"]["~VALUE"]['TEXT'];
            $this->textFooterOriginal = $this->properties["TEXT_FOOTER"]["VALUE"]['TEXT'];
        }

        if (!empty($this->properties["GOOGLE_TAG_MANAGER"]["VALUE"]['TEXT'])) {
            $this->gtm = $this->properties["GOOGLE_TAG_MANAGER"]["VALUE"]['TEXT'];
        }

        if (!empty($this->properties["YANDEX_METRIKA"]["VALUE"]['TEXT'])) {
            $this->ym = $this->properties["YANDEX_METRIKA"]["VALUE"]['TEXT'];
        }

        if (!empty($this->properties["TARGET_SUCCESS_ORDER"]["VALUE"])) {
            $this->ymTargetSuccessOrder = $this->properties["TARGET_SUCCESS_ORDER"]["VALUE"];
        }

        if (!empty($this->properties["OTHER_CODE"]["VALUE"]['TEXT'])) {
            $this->otherCode = $this->properties["OTHER_CODE"]["VALUE"]['TEXT'];
        }

        $this->isShowSliderOnMain = $this->properties['MAIN_SHOW_SLIDER']['VALUE'] === 'Y';
        $this->isShowMenuOnMain = $this->properties['MAIN_SHOW_MENU']['VALUE'] === 'Y';
        $this->isShowAdvantagesOnMain = $this->properties['MAIN_SHOW_ADVENTAGES']['VALUE'] === 'Y';
        $this->isShowBestsellersOnMain = $this->properties['MAIN_SHOW_BESTSELLERS']['VALUE'] === 'Y';
        $this->isShowReviewsListOnMain = $this->properties['MAIN_SHOW_REVIEWS']['VALUE'] === 'Y';
        $this->isShowReLinkOnMain = $this->properties['MAIN_SHOW_RELINKS']['VALUE'] === 'Y';

        if (!empty($this->properties["COLOR_DISCOUNT_SHIELD"]["VALUE"])) {
            $this->colorDiscountShield = $this->properties["COLOR_DISCOUNT_SHIELD"]["VALUE"];
        }

        if (!empty($this->properties["COLOR_SHILD_NEW"]["VALUE"])) {
            $this->colorShildNew = $this->properties["COLOR_SHILD_NEW"]["VALUE"];
        } else if (!empty($this->properties["COLOR_SHILD_NEW"]["DEFAULT_VALUE"])) {
            $this->colorShildNew = $this->properties["COLOR_SHILD_NEW"]["DEFAULT_VALUE"];
        }

        if (!empty($this->properties["COLOR_SHILD_HIT"]["VALUE"])) {
            $this->colorShildHit = $this->properties["COLOR_SHILD_HIT"]["VALUE"];
        } else if (!empty($this->properties["COLOR_SHILD_HIT"]["DEFAULT_VALUE"])) {
            $this->colorShildHit = $this->properties["COLOR_SHILD_HIT"]["DEFAULT_VALUE"];
        }

        if (!empty($this->properties["organizationName"]["VALUE"])) {
            $this->organizationName = $this->properties["organizationName"]["VALUE"];
        }

        $this->setConstants();
        $this->initAnalitycs();

        $this->initOpenGraphImage();
    }

    private function getCurUri()
    {
        $arUrl = parse_url($_SERVER['REQUEST_URI']);
        return str_replace('index.php', '', $arUrl['path']);
    }

    public function insertGtm()
    {
        if (empty($this->gtm)) return;
        echo $this->gtm;
    }

    public function insertYM()
    {
        if (empty($this->ym)) return;
        echo $this->ym;
    }

    public function insertOtherCode()
    {
        if (empty($this->otherCode)) return;
        echo $this->otherCode;
    }

    public function insertSettingsLink()
    {
        ?>
        <a href="<?= SITE_DIR ?>settings/" class="admin-settings-btn">
            <?= GetMessage('ST_SETTING_BTN'); ?>
        </a>
        <?
    }

    private function setConstants()
    {
        $arFilter = [];
        if (!ADMIN_SECTION) {
            $arFilter = ['SITE_ID' => SITE_ID];
        }
        $dbIblocks = \CIBlock::GetList([], $arFilter);
        while ($arIblock = $dbIblocks->Fetch()) {
            switch ($arIblock['CODE']) {
                case self::IBLOCK_CATALOG:
                    define('ST_IBLOCK_CATALOG_ID', $arIblock['ID']);
                    $this->iblockIdCatalog = $arIblock['ID'];
                    break;
                case self::IBLOCK_OFFERS:
                    define('ST_IBLOCK_OFFERS_ID', $arIblock['ID']);
                    $this->iblockIdOffers = $arIblock['ID'];
                    break;
                case self::IBLOCK_REVIEWS:
                    define('ST_IBLOCK_REVIEWS_ID', $arIblock['ID']);
                    $this->iblockIdReviews = $arIblock['ID'];
                    break;
                case self::IBLOCK_ADVANTAGES:
                    define('ST_IBLOCK_ADVANTAGES_ID', $arIblock['ID']);
                    $this->iblockIdAdvantages = $arIblock['ID'];
                    break;
                case self::IBLOCK_SLIDER:
                    define('ST_IBLOCK_SLIDER_ID', $arIblock['ID']);
                    $this->iblockIdSlider = $arIblock['ID'];
                    break;
                case self::IBLOCK_DISCOUNTS:
                    define('ST_IBLOCK_DISCOUNTS_ID', $arIblock['ID']);
                    $this->iblockIdDiscounts = $arIblock['ID'];
                    break;
                default:
            }
        }
    }

    private function initAnalitycs()
    {
        if (!empty($this->properties['TARGET_ADD_TO_BASKET']['VALUE'])) {
            $this->targets['ADD_TO_BASKET'] = $this->properties['TARGET_ADD_TO_BASKET']['VALUE'];
        }

        if (!empty($this->properties['TARGET_SUCCESS_ORDER']['VALUE'])) {
            $this->targets['SUCCESS_ORDER'] = $this->properties['TARGET_SUCCESS_ORDER']['VALUE'];
        }
    }

    public function getJs()
    {
        $data = [
            'targets' => $this->targets,
        ];

        return \Bitrix\Main\Web\Json::encode($data);
    }

    public function getCatalogIblocks()
    {
        $catalogIblocks = [];

        $arFilter = [];
        if (!ADMIN_SECTION) {
            $arFilter = ['SITE_ID' => SITE_ID];
        } else {
            $arFilter = ['CODE' => [
                str_replace('_' . SITE_ID, '_%', self::IBLOCK_CATALOG),
                str_replace('_' . SITE_ID, '_%', self::IBLOCK_OFFERS)
            ]];
        }
        $dbIblocks = \CIBlock::GetList([], $arFilter);
        while ($arIblock = $dbIblocks->Fetch()) {
            if (!ADMIN_SECTION) {
                switch ($arIblock['CODE']) {
                    case self::IBLOCK_CATALOG:
                    case self::IBLOCK_OFFERS:
                        $catalogIblocks[] = $arIblock['ID'];
                        break;
                }
            } else {
                $catalogIblocks[] = $arIblock['ID'];
            }
        }

        return $catalogIblocks;
    }

    private function initOpenGraphImage()
    {
        if (empty($this->properties['OPEN_GRAPH_IMAGE']['VALUE'])) return;

        $arImage = \CFile::GetFileArray($this->properties['OPEN_GRAPH_IMAGE']['VALUE']);
        $this->openGraphImage = $arImage['SRC'];
    }
}
