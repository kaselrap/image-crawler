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
    public function run(string $url = '', bool $isParent = true);
}
