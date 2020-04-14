<?php

namespace Crawler;

interface CrawlerInterface
{
    /**
     * @param string $url
     * @param bool $isParent
     *
     * @return mixed
     */
    public function parse(string $url, bool $isParent = true);
}
