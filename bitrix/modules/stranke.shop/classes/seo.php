<?php
namespace Stranke\Shop;

class Seo
{
    public static function ldJson($data)
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
