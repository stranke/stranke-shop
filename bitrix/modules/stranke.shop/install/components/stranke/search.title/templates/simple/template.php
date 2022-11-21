<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
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

use \Stranke\Base\Url;

$this->setFrameMode(true);
?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if (strlen($INPUT_ID) <= 0) {
    $INPUT_ID = "title-search-input";
}
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if (strlen($CONTAINER_ID) <= 0) {
    $CONTAINER_ID = "title-search";
}
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);
CModule::IncludeModule("iblock");
if ($arParams["SHOW_INPUT"] !== "N"):
    ?>

    <div id="<? echo $CONTAINER_ID ?>">
        <form action="<? echo $arResult["FORM_ACTION"] ?>" class="central-block-search-form js-centralBlockSearchForm">
            <input aria-label="поиск" class="search_field" id="<?= $INPUT_ID ?>" type="text" name="q" value="" size="40" maxlength="50" autocomplete="off" placeholder=""/>

            <div class="central-block-search__btn js-headerSearchBtn">
                <div class="search-btn__icon">
                    <canvas width="19" height="19"></canvas>
                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3861 16.8221L13.2581 11.6921C14.1756 10.4378 14.6663 8.92211 14.6581 7.36807C14.6497 5.41913 13.8728 3.55219 12.4961 2.17267C11.1194 0.793143 9.25404 0.0124314 7.30512 7.09404e-05C6.34378 -0.00417491 5.39114 0.182208 4.50229 0.548441C3.61343 0.914675 2.80601 1.45349 2.1267 2.13373C1.44739 2.81397 0.909675 3.62214 0.544658 4.51149C0.17964 5.40084 -0.00543926 6.35374 0.000121692 7.31507C0.00825925 9.26504 0.78574 11.133 2.16356 12.5129C3.54138 13.8927 5.40816 14.673 7.35812 14.6841C8.91911 14.6909 10.4405 14.1928 11.6951 13.2641H11.7001L16.8231 18.3901C16.9247 18.4975 17.0468 18.5835 17.1822 18.6429C17.3176 18.7023 17.4636 18.7339 17.6114 18.736C17.7593 18.738 17.906 18.7104 18.043 18.6547C18.18 18.599 18.3044 18.5165 18.409 18.4119C18.5135 18.3073 18.596 18.1828 18.6515 18.0458C18.7071 17.9088 18.7347 17.762 18.7325 17.6142C18.7304 17.4663 18.6987 17.3204 18.6392 17.185C18.5797 17.0497 18.4936 16.9276 18.3861 16.8261V16.8221ZM7.35312 13.2151C5.79334 13.2061 4.30009 12.5821 3.19779 11.4785C2.0955 10.3749 1.47321 8.88086 1.46612 7.32107C1.46175 6.55198 1.60987 5.78965 1.9019 5.07815C2.19393 4.36665 2.62408 3.72008 3.1675 3.17583C3.71092 2.63157 4.35682 2.20042 5.06787 1.9073C5.77893 1.61417 6.54103 1.46489 7.31012 1.46807C8.8706 1.47623 10.3648 2.10008 11.4677 3.20399C12.5707 4.30789 13.1933 5.80259 13.2001 7.36307C13.2044 8.13208 13.0561 8.8943 12.7641 9.60568C12.472 10.3171 12.0418 10.9635 11.4984 11.5077C10.955 12.0518 10.3091 12.4829 9.59814 12.7759C8.88715 13.069 8.12513 13.2183 7.35612 13.2151H7.35312Z" fill="#C0C0C0"/>
                    </svg>
                    <? /*<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3861 16.8221L13.2581 11.6921C14.1756 10.4378 14.6663 8.92211 14.6581 7.36807C14.6497 5.41913 13.8728 3.55219 12.4961 2.17267C11.1194 0.793143 9.25404 0.0124314 7.30512 7.09404e-05C6.34378 -0.00417491 5.39114 0.182208 4.50229 0.548441C3.61343 0.914675 2.80601 1.45349 2.1267 2.13373C1.44739 2.81397 0.909675 3.62214 0.544658 4.51149C0.17964 5.40084 -0.00543925 6.35374 0.000121692 7.31507C0.00825925 9.26504 0.78574 11.133 2.16356 12.5129C3.54138 13.8927 5.40816 14.673 7.35812 14.6841C8.91911 14.6909 10.4405 14.1928 11.6951 13.2641H11.7001L16.8231 18.3901C16.9247 18.4975 17.0468 18.5835 17.1822 18.6429C17.3176 18.7023 17.4636 18.7339 17.6114 18.736C17.7593 18.738 17.906 18.7104 18.043 18.6547C18.18 18.599 18.3044 18.5165 18.409 18.4119C18.5135 18.3073 18.596 18.1828 18.6515 18.0458C18.7071 17.9088 18.7347 17.762 18.7325 17.6142C18.7304 17.4663 18.6987 17.3204 18.6392 17.185C18.5797 17.0497 18.4936 16.9276 18.3861 16.8261V16.8221ZM7.35312 13.2151C5.79334 13.2061 4.30009 12.5821 3.19779 11.4785C2.0955 10.3749 1.47321 8.88086 1.46612 7.32107C1.46175 6.55198 1.60987 5.78965 1.9019 5.07815C2.19393 4.36665 2.62408 3.72008 3.1675 3.17583C3.71092 2.63157 4.35682 2.20042 5.06787 1.9073C5.77893 1.61417 6.54103 1.46489 7.31012 1.46807C8.8706 1.47623 10.3648 2.10008 11.4677 3.20399C12.5707 4.30789 13.1933 5.80259 13.2001 7.36307C13.2044 8.13208 13.0561 8.8943 12.7641 9.60568C12.472 10.3171 12.0418 10.9635 11.4984 11.5077C10.955 12.0518 10.3091 12.4829 9.59814 12.7759C8.88715 13.069 8.12513 13.2183 7.35612 13.2151H7.35312Z" fill="#C0C0C0"/>
                    </svg>*/
                    ?>
                </div>
            </div>
            <div class="placeholder"><?= GetMessage('CT_BST_SEARCH_BUTTON'); ?>
            </div>
        </form>
    </div>

<? endif ?>
<script>
    BX.ready(function () {
        <? if(0):?>
        var arr = JSON.parse('<? echo addslashes(json_encode($arResult['ANIMATE_REPLACE'])) ?>');
        var place = $('#<? echo $CONTAINER_ID ?> .placeholder');

        async function animate_place() {
            for (var i in arr) {
                await set_place(arr[i])
            }
        }

        async function set_place(str) {
            place.text('')
            for (var i in str) {
                place.text(place.text() + str[i])
                await new Promise(res => setTimeout(res, 100))
            }
            await new Promise(res => setTimeout(res, 1000))
            for (var i in str) {
                place.text(place.text().substr(0, place.text().length - 1))
                await new Promise(res => setTimeout(res, 60))
            }
            await new Promise(res => setTimeout(res, 1000))
            place.html('<?= GetMessage('CT_BST_SEARCH_BUTTON_PLACE'); ?> <span class="color_main"><?= $arResult['ANIMATE_REPLACE_PRODUCT']; ?></span>')
            await new Promise(res => setTimeout(res, 2000))
            return true
        }

        setTimeout(function () {
            animate_place()
        }, 2000)

        <? endif ?>
        new JCTitleSearch({
            'AJAX_PAGE': '<? echo CUtil::JSEscape(POST_FORM_ACTION_URI) ?>',
            'CONTAINER_ID': '<? echo $CONTAINER_ID ?>',
            'INPUT_ID': '<? echo $INPUT_ID ?>',
            'MIN_QUERY_LEN': 2
        });

        window.searchTitle = window.searchTitle ? window.searchTitle : []
        window.searchTitle['<? echo $CONTAINER_ID ?>'] = new SearchTitle($('#<? echo $CONTAINER_ID ?> form'));
    });
</script>
