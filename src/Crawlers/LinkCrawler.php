<?php

namespace Crawler\Crawlers;

use Crawler\Services\UrlService\HrefService;
use DOMElement;

class LinkCrawler extends CrawlerDetector
{
    public function build(DOMElement $node): void
    {
        $hrefService = new HrefService($this->getCrawler()->getHost(), $node->getAttribute('href'));
        $hrefService->build();
        $this->getCrawler()->run($hrefService->getHref(), false);
    }
}
