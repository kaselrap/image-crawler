<?php

namespace Crawler\Crawlers;

use Crawler\Services\ImageService;
use Crawler\Services\UrlService\SrcService;
use DOMElement;

class ImageCrawler extends CrawlerDetector
{
    public function build(DOMElement $node): void
    {
        $this->parseByAttribute($node, 'src');
        $this->parseByAttribute($node, 'data-src');
    }

    private function parseByAttribute(DOMElement $node, string $attr): void
    {
        if ($node->hasAttribute($attr)) {
            $urlService = new SrcService($this->getCrawler()->getHost(), $node->getAttribute($attr));
            $imageService = new ImageService($this->getCrawler()->getHost(), $urlService->getSrcWithoutHost());
            $imageService->copy();
        }
    }
}
