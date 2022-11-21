<?php
namespace Stranke\Shop;


class OpenGraph
{
    private $bx = null;

    public function __construct()
    {
        $this->bx = $GLOBALS['APPLICATION'];

        $this->setUrl($this->getDefaultUrl());
        $this->setType('webpage');
        $this->setImage($this->getDefaultImage());
    }

    public function show()
    {
        $this->showUrl();
        $this->showType();
        $this->showTitle();
        $this->showImage();
        $this->showDescription();
    }

    public function showUrl()
    {
        $this->bx->ShowMeta('og:url');
    }

    public function setUrl($value)
    {
        $this->bx->SetPageProperty('og:url', $value);
    }

    public function showType()
    {
        $this->bx->ShowMeta('og:type');
    }

    public function setType($value)
    {
        $this->bx->SetPageProperty('og:type', $value);
    }

    public function showTitle()
    {
        $this->bx->ShowMeta('title', 'og:title');
    }

    public function showDescription()
    {
        $this->bx->ShowMeta('description', 'og:description');
    }

    public function setImage($value)
    {
        $this->bx->SetPageProperty('og:image', $value);
    }

    public function showImage()
    {
        $this->bx->ShowMeta('og:image');
    }

    private function getDefaultUrl()
    {
        $protocol = $this->getProtocol();
        $path = $this->getPath();

        return $protocol . $_SERVER['SERVER_NAME'] . $path;
    }

    private function getProtocol()
    {
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return 'https://';
        }

        if ($_SERVER['SERVER_PORT'] == 443) {
            return 'https://';
        }

        return 'http';
    }

    private function getPath()
    {
        return str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
    }

    private function getDefaultImage()
    {
        $protocol = $this->getProtocol();
        return $protocol . $_SERVER['SERVER_NAME'] . Config::getInstance()->openGraphImage;
    }
}
