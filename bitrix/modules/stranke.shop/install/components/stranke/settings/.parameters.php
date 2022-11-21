<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BND_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
		),

        'SHOW_TITLE' => [
            'PARENT' => 'BASE',
            'NAME' => GetMessage('ST_SETTINGS_PARAM_SHOW_TITLE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
            'REFRESH' => 'Y',
        ],
	),
);

if ($arCurrentValues['SHOW_TITLE'] === 'Y') {
    $arComponentParameters['PARAMETERS']['TITLE'] = [
        "PARENT" => "BASE",
        "NAME" => GetMessage('ST_SETTINGS_PARAM_TITLE'),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage('ST_SETTINGS_PARAM_TITLE_DEFAULT'),
    ];
}
