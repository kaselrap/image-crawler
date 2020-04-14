<?php

namespace Crawler\Crawlers;

use Crawler\Crawler;
use DOMElement;
use DOMNode;
use DOMNodeList;

abstract class CrawlerDetector implements CrawlerDetectorInterface
{
    /**
     * @var DOMNodeList
     */
    private DOMNodeList $list;

    /**
     * @var string
     */
    private Crawler $crawler;

    public function __construct(Crawler $crawler, DOMNodeList $list)
    {
        $this->crawler = $crawler;
        $this->list = $list;
    }

    public function parse(): void
    {
        foreach ($this->list as $node) {
            $this->build($node);
        }
    }

    /**
     * @return Crawler
     */
    public function getCrawler(): Crawler
    {
        return $this->crawler;
    }

    abstract public function build(DOMElement $node): void;
}
