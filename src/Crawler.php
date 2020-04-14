<?php

namespace Crawler;

use Crawler\Interfaces\PageInterface;
use Crawler\Services\ImageService;
use Crawler\Services\UrlService\HrefService;
use Crawler\Services\UrlService\SrcService;

/**
 * Class Crawler
 *
 * @package Crawler
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var PageInterface
     */
    private PageInterface $pageService;

    /**
     * @var string
     */
    private string $host;

    /**
     * @param PageInterface $pageService
     * @param $host
     */
    public function __construct(PageInterface $pageService, $host)
    {
        $this->pageService = $pageService;
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return (new HrefService($this->host, ''))->getHost();
    }

    /**
     * @param string $url
     * @param bool $isParent
     */
    public function parse(string $url, bool $isParent = true)
    {
        if (! $this->pageService->addPage($url, $isParent)) {
            return;
        }

        $document = new \DOMDocument();
        @$document ->loadHTMLFile($url);
        $links = $document->getElementsByTagName('a');
        $images = $document->getElementsByTagName('img');
        foreach ($images as $image) {
            if ($image->hasAttribute('src')) {
                $urlService = new SrcService($this->getHost(), $image->getAttribute('src'));
                (new ImageService($this->getHost(), $urlService->getSrcWithoutHost()))->copy();
            }
            if ($image->hasAttribute('data-src')) {
                $urlService = new SrcService($this->getHost(), $image->getAttribute('data-src'));
                (new ImageService($this->getHost(), $urlService->getSrcWithoutHost()))->copy();
            }
        }
        foreach ($links as $link) {
            $href = (new HrefService($this->getHost(), $link->getAttribute('href')))->build()->getHref();
            $this->parse($href, false);
        }
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->pageService->getPages();
    }
}
