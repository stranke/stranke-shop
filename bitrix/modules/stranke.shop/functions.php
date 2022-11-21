<?
function decl($num, $arCurrency)
{
    $num = $num % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
        case 1:
            {
                return ($arCurrency[0]);
            }
        case 2:
        case 3:
        case 4:
            {
                return ($arCurrency[1]);
            }
        default:
            {
                return ($arCurrency[2]);
            }
    }
}
