<?php

namespace Crawler\Interfaces;

/**
 * Interface PageInterface
 *
 * @package Crawler\Interfaces
 */
interface PageInterface
{
    /**
     * @param string $page
     * @param bool $isParent
     *
     * @return bool
     */
    public function addPage(string $page, bool $isParent = false): bool;

    /**
     * @return array
     */
    public function getPages(): array;
}
