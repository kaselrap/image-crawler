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
            if (extension_loaded('http')) {
                $this->buildUrl();
            } else {
                $this->generate();
            }
        }

        return $this;
    }
}
