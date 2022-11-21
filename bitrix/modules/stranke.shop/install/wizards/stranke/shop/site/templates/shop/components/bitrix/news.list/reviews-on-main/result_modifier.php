<?/*
$usersIds = array();
$usersIdsStr = "";
foreach( $arResult["ITEMS"] as $arItem ){
    if( !empty($arItem["PROPERTIES"]["USER"]["VALUE"])  && !in_array($arItem["PROPERTIES"]["USER"]["VALUE"], $usersIds)){
        $usersIds[] = $arItem["PROPERTIES"]["USER"]["VALUE"];
        $usersIdsStr .= $arItem["PROPERTIES"]["USER"]["VALUE"]."|";
    }
}

$dbUsers = $USER->GetList( ($by="id"), ($order="asc"), array("ID" => $usersIdsStr));
while( $arUser = $dbUsers->GetNext() ){
    $arResult["USERS"][$arUser["ID"]] = $arUser;
}*/
