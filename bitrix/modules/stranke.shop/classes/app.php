<?php
namespace Stranke\Shop;

class App
{
    private static $instance;

    public $config = null;
    public $header = null;
    public $footer = null;
    public $opengraph = null;

    public static function getInstance(): App
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->config = Config::getInstance();
        $this->header = new Header($this->config);
        $this->footer = new Footer($this->config);
        $this->opengraph = new OpenGraph();
    }

    /**
     * Return template shop path for shop_amp template
     *
     * @return string
     */
    public static function getTemplatePath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'].str_replace('shop_amp', 'shop', SITE_TEMPLATE_PATH.'/');
    }
}
