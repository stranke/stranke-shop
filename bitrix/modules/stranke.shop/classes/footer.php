<?php
namespace Stranke\Shop;

class Footer
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function render()
    {
        global $APPLICATION;

        if ($this->config->isMainPage) {
            include $this->config->views . '/footer.php';
        }
    }
}
