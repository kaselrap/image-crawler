<?php

namespace Crawler;

use Crawler\Crawlers\ImageCrawler;
use Crawler\Crawlers\LinkCrawler;
use Crawler\Interfaces\PageInterface;
use Crawler\Services\ImageService;
use Crawler\Services\UrlService\HrefService;
use Crawler\Services\UrlService\SrcService;
use DOMNodeList;

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
    public function run(string $url = '', bool $isParent = true)
    {
        if (empty($url)) {
            $url = $this->host;
        }

        if (! $this->pageService->addPage($url, $isParent)) {
            return;
        }

        $document = new \DOMDocument();
        @$document->loadHTMLFile($url);
        foreach ([
                     new ImageCrawler($this, $document->getElementsByTagName('img')),
                     new LinkCrawler($this, $document->getElementsByTagName('a'))
                 ] as $crawler) {
            $crawler->parse();
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
