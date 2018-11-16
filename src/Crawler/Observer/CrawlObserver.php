<?php

namespace Crawler\Observer;

use Crawler\Model\UrlTextCollection;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObserver as BaseCrawlObserver;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Class CrawlObserver
 */
class CrawlObserver extends BaseCrawlObserver
{
    /**
     * @var UrlTextCollection
     */
    private $texts;

    /**
     * @var array List of blacklisted HTML tags
     */
    private $tagsBlacklist = [
        'script',
    ];

    /**
     * CrawlObserver constructor.
     */
    public function __construct()
    {
        $this->texts = new UrlTextCollection();
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    )
    {
        if ($response->getHeader('Content-Type')[0] !== 'text/html') { // Only further crawl HTML pages
            return;
        }
        $doc = new \DOMDocument();
        $mock = new \DOMDocument();
        @$doc->loadHTML($response->getBody()->getContents());
        $body = $doc->getElementsByTagName('body')->item(0);
        /** @var \DOMElement|\DOMText $child */
        foreach ($body->childNodes as $child) {
            $mock->appendChild($mock->importNode($child, true));
        }

        foreach ($this->tagsBlacklist as $tag) {
            foreach (iterator_to_array($mock->getElementsByTagName($tag)) as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        $body = $this->normalizeBodyText($mock->saveHTML());

        $this->texts->add(
            $url->getPath(),
            $body
        );
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    )
    {
        // noop
    }

    /**
     * @return UrlTextCollection
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * Normalizes the body and makes it machine readable
     *
     * @param $body
     * @return mixed|null|string|string[]
     */
    private function normalizeBodyText($body)
    {
        $body = strip_tags($body);
        $body = str_replace('&nbsp;', ' ', $body);
        $body = html_entity_decode($body);
        $body = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $body);
        $body = preg_replace('~[\?"]([a-zA-Z0-9\.,\(\)]+)[\?"]~', '"$1"', $body);
        $body = preg_replace('~\s+~', ' ', $body);

        $body = trim($body);

        return $body;
    }
}
