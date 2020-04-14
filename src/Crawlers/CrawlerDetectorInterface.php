<?php

namespace Crawler\Crawlers;

interface CrawlerDetectorInterface
{
    public function parse(): void;
}
