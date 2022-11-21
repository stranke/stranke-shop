<?php
namespace Stranke\Shop;

class Header
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function render()
    {
        global $APPLICATION;

        if ($this->config->isMainPage) {
            include $this->config->views . '/header.php';
        }
    }
}
