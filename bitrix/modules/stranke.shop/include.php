<?

CModule::AddAutoloadClasses(
    'stranke.shop',
    array(
        'phpQuery' => 'lib/phpQuery.php',
        'Stranke\Shop\App' => 'classes/app.php',
        'Stranke\Shop\Config' => 'classes/config.php',
        'Stranke\Shop\Footer' => 'classes/footer.php',
        'Stranke\Shop\Header' => 'classes/header.php',
        'Stranke\Shop\IblockPropertyColor' => 'classes/iblockpropertycolor.php',
        'Stranke\Shop\OpenGraph' => 'classes/opengraph.php',
        'Stranke\Shop\Reviews' => 'classes/reviews.php',
        'Stranke\Shop\SectionProduct' => 'classes/sectionproduct.php',
        'Stranke\Shop\Settings' => 'classes/settings.php',
        'Stranke\Shop\Seo' => 'classes/seo.php',
        'Stranke\Shop\Usecases\CalculateRating' => 'classes/usecases/SettingsHelper.php',
        'Stranke\Shop\Usecases\EventHandler' => 'classes/usecases/SettingsHelper.php',
        'Stranke\Shop\SettingsHelper' => 'classes/SettingsHelper.php',

    )
);


require_once('functions.php');

//global $MedaiCallsSetting;
//if (file_exists(__DIR__ . '/Centrifugo/CentrifugoApi/autoload.php')) {
//    require_once('Centrifugo/CentrifugoApi/autoload.php');
//}
//if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/pwa/load.php')) {
//    require_once($_SERVER['DOCUMENT_ROOT'] . '/pwa/load.php');
//}
