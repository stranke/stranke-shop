<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) 
	LocalRedirect($backurl);

$APPLICATION->SetTitle("Авторизация");
?>



  <div class="page-container">



    <? if ($_SESSION['USER_REG'] == 'Y') {?>

      <p>Вы зарегистрированы и успешно авторизовались.</p>

      <script>
        yaCounter23330674.reachGoal('USER_REG');
      </script>

      <? $_SESSION['USER_REG'] = "N"?>

    <? } ?>
    <p>Вы успешно авторизовались.</p>
    <p>
      <a href="<?=SITE_DIR?>">Вернуться на главную страницу</a>
    </p>

    <script>
      yaCounter23330674.reachGoal('USER_AUTH');
    </script>

  </div>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>