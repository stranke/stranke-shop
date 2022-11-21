<?php

namespace Stranke\Shop\Usecases;


use Stranke\Shop\Usecases\CalculateRating;
class EventHandler
{

    public static function init()
    {
        self::addCompatible('iblock', 'OnBeforeIBlockElementDelete');
    }

    public static function addCompatible($moduleName, $eventName)
    {
        if (method_exists(self::class, $eventName)) {
            $eventManager = EventManager::getInstance();
            $eventManager->addEventHandlerCompatible($moduleName, $eventName, [self::class, $eventName]);
        }
    }

    public function OnBeforeIBlockElementDelete($ID) {

        $res = CIBlockElement::GetByID($ID);
        if($arFields = $res->GetNext()) {

            $arIblockReviews = [];
            $dbResult = \CIBlock::GetList([], ['CODE' => 'content_reviews_%']);
            while ($arIblock = $dbResult->Fetch()) {
                $arIblockReviews[] = $arIblock['ID'];
            }

            if (in_array($arFields['IBLOCK_ID'], $arIblockReviews)) {
                file_put_contents('/tmp/bitrix.log', 'in_array : ' . $ID . PHP_EOL, FILE_APPEND);
                $usecase = new CalculateRating($ID, true);
                $usecase->execute();
            }
        }

    }
}
