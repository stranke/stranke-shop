<?
use Bitrix\Main\ModuleManager;

global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));


Class stranke_shop extends CModule
{
	var $MODULE_ID = "stranke.shop";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function stranke_shop()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("SCOM_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("SCOM_INSTALL_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("SPER_PARTNER");
		$this->PARTNER_URI = GetMessage("PARTNER_URI");
	}


	function InstallDB($install_wizard = true)
	{
        ModuleManager::registerModule($this->MODULE_ID);
		return true;
	}

	function UnInstallDB($arParams = Array())
	{
        ModuleManager::unRegisterModule($this->MODULE_ID);
		return true;
	}

	function InstallEvents()
	{
        $eventManager = \Bitrix\Main\EventManager::getInstance();

        $eventManager->registerEventHandler(
            'main', 'OnBeforeProlog',
            $this->MODULE_ID, '\\Stranke\\Shop\\eventhandler', "OnBeforeProlog"
        );
        $eventManager->registerEventHandler(
            'iblock', 'OnIBlockPropertyBuildList',
            $this->MODULE_ID,
            '\\Stranke\\Shop\\IblockPropertyColor', "GetUserTypeDescription"
        );

        $eventManager->registerEventHandler(
            'main', 'OnEndBufferContent',
            $this->MODULE_ID, '\\Stranke\\Shop\\eventhandler', "OnEndBufferContentHandler"
        );
        $eventManager->registerEventHandler(
            'iblock', 'OnBeforeIBlockUpdate',
            $this->MODULE_ID, '\\Stranke\\Shop\\eventhandler', "OnBeforeIBlockUpdateHandler"
        );

		return true;
	}

	function UnInstallEvents()
	{
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler(
            'main', 'OnBeforeProlog',
            $this->MODULE_ID, '\\Stranke\\Shop\\EventHandler', "OnBeforeProlog"
        );

        $eventManager->unRegisterEventHandler(
            'iblock', 'OnIBlockPropertyBuildList',
            $this->MODULE_ID,
            '\\Stranke\\Shop\\IblockPropertyColor', "GetUserTypeDescription"
        );


		return true;
	}

	function InstallFiles()
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/stranke.shop/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/stranke.shop/install/wizards/stranke/shop", $_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/stranke/shop", true, true);

		return true;
	}

	function InstallPublic()
	{
	}

	function UnInstallFiles()
	{
        DeleteDirFilesEx("/bitrix/components/stranke/contacts/");
        DeleteDirFilesEx("/bitrix/components/stranke/settings/");
        DeleteDirFilesEx("/bitrix/wizards/stranke/shop/");
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION, $step;

		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();

		return true;
	}

	function DoUninstall()
	{
		global $APPLICATION, $step;

        $this->UnInstallEvents();
		$this->UnInstallDB();
		$this->UnInstallFiles();

		return true;
	}
}
