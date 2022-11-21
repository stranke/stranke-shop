<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/lib/dropzone.js");
  
$this->addExternalCss("https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css");
$this->addExternalJS("https://cdn.jsdelivr.net/npm/flatpickr");
$this->addExternalJS("https://npmcdn.com/flatpickr/dist/l10n/ru.js");

global $USER;
$ID = $USER->GetID();
$arUser = $USER->GetByID($ID)->Fetch();

$rsFile = CFile::GetByID($arUser["PERSONAL_PHOTO"]);
$arFile = $rsFile->Fetch();
$arFile["SRC"] = CFile::GetPath($arUser["PERSONAL_PHOTO"]);


function showSubscribe(&$arResult){
  echo '<h3 class="lk-h3">' . GetMessage('ST_PROFILE_MANAGE_SUBSCRIBE') . '</h3>';
  $subscribeDisabled = '';
  if(empty(trim($arResult["arUser"]["EMAIL"]))) {
    $subscribeDisabled = 'disabled';
    echo '<div class="lk-profile__error" style="color: red">' . GetMessage('ST_PROFILE_MANAGE_SUBSCRIBE_EMPTY_EMAIL') . '</div>';
  }
  echo '<div class="lk-profile__subscription">';

  foreach ($arResult["RUBRICS"] as $rubric){
     $ckecked = '';
     if(intval($rubric["CHECKED"]) === 1){
       $ckecked = 'checked';
     }
     echo  '   <label class="lk-profile__subscription-field">';
     echo  '     <input type="checkbox" name="SENDER_SUBSCRIBE_RUB_ID[]"' .
                   'value="'.$rubric["ID"].'" '.$ckecked.' '.$subscribeDisabled.'>';

     echo   '    <span></span>';
     echo   '    <div>'.$rubric["NAME"].'</div>';
     echo   ' </label>';
  }

  echo '    </div>';
}
?>

<div class="bx_profile">
  
  <?
    if(!empty($arResult["strProfileError"])){
      ShowError($arResult["strProfileError"]);
    }
  ?>

  <div class="lk-profile">
    <h2 class="lk-h2"><?=GetMessage('ST_PROFILE_PHOTO')?></h2>

    <div class="lk-profile__photo-block">
      <form id="add-photo-form" name="add-photo-form" action="<?=SITE_DIR?>ajax/lk/set_photo.php" class="dz-clickable lk-profile__add-photo-form">
        <div class="dz-default dz-message">
            <span><?=GetMessage('ST_PROFILE_PHOTO_ADD')?></span>
        </div>
  
        <? if(!empty($arFile["SRC"])){ ?>
          <div class="dz-preview dz-foto-stub">
            <div class="dz-image">
              <img src="<?=$arFile["SRC"]?>" alt="">
            </div>
          </div>
        <? } ?>

        <div class="lk-profile__add-photo-btn"></div>
      </form>
  
      <? if(!empty($arFile["SRC"])) { ?>
        <div class="lk-profile__del-photo-btn"><?=GetMessage('ST_PROFILE_PHOTO_DEL')?></div>
      <? } ?>
      
    </div>

    <div class="lk-profile__main-form">

      <form id="lk-profile-main-form-personal" method="post" class="<?=($arUser["UF_USER_TYPE"] == 2)?'lk-profile__hidden':''?>" name="form-personal" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form">
        <?=str_replace('id="sessid"',"", $arResult["BX_SESSION_CHECK"]);?>
        <input type="hidden" name="UF_USER_TYPE" value="2">
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
        <input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
        <div class="main-profile-block-shown" id="user_div_reg">

          <div class="form-block form-block__2">
            <h2 class="lk-h2"><?=GetMessage('ST_PROFILE_PERSONAL_DATA')?></h2>
  
            <? if (!in_array(LANGUAGE_ID,array('ru', 'ua'))) { ?>
                <div class="lk-profile__field">
                  <span class="lk-profile__field-title" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></span>
                  <div class="col-sm-12">
                    <input class="lk-profile__field-input" type="text" name="TITLE" maxlength="50" value="<?=$arResult["arUser"]["TITLE"]?>" />
                  </div>
                </div>

            <? } ?>
  
            <div class="lk-profile__field">
              <span class="lk-profile__field-title"><?=Loc::getMessage('NAME')?></span>
              <div class="col-sm-12">
                <input class="lk-profile__field-input" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
              </div>
            </div>

            <div class="lk-profile__field">
              <span class="lk-profile__field-title"><?=Loc::getMessage('EMAIL')?></span>
              <div class="col-sm-12">
                <input class="lk-profile__field-input" type="text" name="EMAIL" maxlength="50" value="<?=$arResult["arUser"]["EMAIL"]?>" />
              </div>
            </div>

            <div class="lk-profile__field">
              <span class="lk-profile__field-title"><?=Loc::getMessage('WORK_PHONE')?></span>
              <div class="col-sm-12">
                <input id="phone-input" class="lk-profile__field-input" type="text" name="PERSONAL_PHONE" maxlength="50" placeholder="+7 (   )     -   -   " value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
              </div>
            </div>

<!--            <div class="lk-profile__field">-->
<!--              <span class="lk-profile__field-title">--><?//=Loc::getMessage('PERSONAL_CITY')?><!--</span>-->
<!--              <div class="col-sm-12">-->
<!--                <input class="lk-profile__field-input" type="text" name="PERSONAL_CITY" maxlength="50" value="--><?//=$arResult["arUser"]["PERSONAL_CITY"]?><!--" />-->
<!--              </div>-->
<!--            </div>-->

  
          </div>

        </div>
  
        <?
          if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '')
          {
            ?>
            <div class="form-block form-block__3">

              <h2 class="lk-h2"><?=GetMessage('ST_PROFILE_CHANGE_PASSWORD')?></h2>

              <div class="lk-profile__field">
                <span class="lk-profile__field-title"><?=Loc::getMessage('OLD_PASSWORD_REQ')?><span class="red"> *</span></span>
                <div class="col-sm-12">
                  <input class="lk-profile__field-input " type="password" name="OLD_PASSWORD" maxlength="50" value="" autocomplete="off"/>
                </div>
              </div>

              <div class="lk-profile__field">
                <span class="lk-profile__field-title"><?=Loc::getMessage('NEW_PASSWORD_REQ')?><span class="red"> *</span></span>
                <div class="col-sm-12">
                  <input class="lk-profile__field-input bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off"/>
                </div>
              </div>

              <div class="lk-profile__field">
                <span class="lk-profile__field-title">
                  <?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?><span class="red"> *</span>
                </span>
                <div class="col-sm-12">
                  <input class="lk-profile__field-input" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
                </div>
              </div>

            </div>
            <?
          }
        ?>
        <div class="lk-profile__field lk-profile__field_big">
          <input type="submit" name="save" class="btn btn-themes btn-default btn-md main-profile-submit lk-profile__submit" value="<?=GetMessage('SAVE')?>">
        </div>
      </form>

    </div>

  </div>

</div>

<script type="text/javascript">
    <?if ($arResult['DATA_SAVED'] == 'Y'):?>
        window.showpopup = "changed";
    <?endif?>

    BX.message({
      ST_PROFILE_PHOTO_DEL: '<?=GetMessage('ST_PROFILE_PHOTO_DEL')?>',
      ST_PROFILE_MANAGE_DATA_CHANGED: '<?=GetMessage('ST_PROFILE_MANAGE_DATA_CHANGED')?>',
    });
</script>