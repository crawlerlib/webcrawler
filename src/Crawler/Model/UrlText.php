<?php

namespace Crawler\Model;

/**
 * Class Link
 */
class UrlText
{
    /**
     * @var string URL to find texts on
     */
    private $url;

    /**
     * @var array Texts on this url
     */
    private $text;

    /**
     * UrlTextCollection constructor.
     * @param $url
     * @param $text
     */
    public function __construct($url, $text)
    {
        $this->url = $url;
        $this->text = $text;
    }

    /**
     * Creates a CSV representation of this url-text pair
     *
     * @return array
     */
    public function toCSV()
    {
        return [$this->url, $this->text];
    }
}
