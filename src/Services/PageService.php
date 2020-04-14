<?php

namespace Crawler\Services;

use Crawler\Interfaces\PageInterface;
use Crawler\Patterns\Singleton;
use Crawler\Services\UrlService\HrefService;

class PageService extends Singleton implements PageInterface
{
    /**
     * @var array
     */
    private array $pages = [];

    /**
     * @param string $page
     * @param bool $isParent
     *
     * @return bool
     */
    public function addPage(string $page, bool $isParent = false): bool
    {
        if (! $this->checkPageExists($page, $isParent)) {
            if ($isParent) {
                $this->pages['parent'] = $page;
            }
            $this->pages[] = $page;

            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getPages(): array
    {
        return $this->pages;
    }

    /**
     * @param string $page
     *
     * @return bool
     */
    private function checkPageExists(string $page): bool
    {
        if (isset($this->pages['parent'])) {
            $host = (new HrefService($this->pages['parent'], $page))->getHost();
            $foundHostInPage = strpos($page, $host);
            if (is_int($foundHostInPage) && in_array($page, $this->pages, true)) {
                return true;
            }
        }

        return in_array($page, $this->pages, true);
    }
}
