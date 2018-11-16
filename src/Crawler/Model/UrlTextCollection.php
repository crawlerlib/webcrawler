<?php

namespace Crawler\Model;

/**
 * Class UrlTextCollection
 */
class UrlTextCollection
{
    /**
     * @var UrlText[]
     */
    private $urlTexts = [];

    /**
     * @param $url
     * @param $text
     */
    public function add($url, $text)
    {
        $this->urlTexts[] = new UrlText($url, $text);
    }

    /**
     * @return UrlText[]
     */
    public function getUrlTexts()
    {
        return $this->urlTexts;
    }

    /**
     * @return array
     */
    public function getCSVHeader()
    {
        return ['URL', 'Text'];
    }

    /**
     * Creates an array that can be output to a CSV
     *
     * @return array
     */
    public function toCSV()
    {
        return array_map(function (UrlText $urlText) {
            return $urlText->toCSV();
        }, $this->urlTexts);
    }
}
