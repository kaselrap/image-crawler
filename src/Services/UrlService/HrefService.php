<?php

namespace Crawler\Services\UrlService;

class HrefService extends UrlService
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
