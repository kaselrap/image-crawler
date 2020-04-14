<?php

namespace Crawler\Services\UrlService;

/**
 * Class SrcService
 *
 * @package Crawler\UrlService\Services
 */
class SrcService extends UrlService
{
    /**
     * @return UrlService
     */
    public function build(): UrlService
    {
        if ($this->checkHttpExists()) {
            $this->generate();
        }

        return $this;
    }
}
