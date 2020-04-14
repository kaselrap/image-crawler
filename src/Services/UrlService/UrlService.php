<?php

namespace Crawler\Services\UrlService;

/**
 * Class UrlService
 *
 * @package Crawler\Services
 */
abstract class UrlService
{
    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $src;

    /**
     * @var string
     */
    protected string $href;

    /**
     * @var array
     */
    protected array $parts = [];

    /**
     * @var string|null
     */
    protected string $path = '';

    /**
     * @var string
     */
    protected string $host = '';

    /**
     * UrlService constructor.
     *
     * @param string $url
     * @param string $src
     */
    public function __construct(string $url, string $src)
    {
        $this->url = $url;
        $this->src = $src;
        $this->href = '';
    }

    /**
     * @return UrlService
     */
    abstract public function build(): self;

    /**
     * @return array
     */
    public function getParseUrl(): array
    {
        if (! $this->parts) {
            $this->parts = parse_url($this->url);
        }

        return $this->parts;
    }

    /**
     * @param string $part
     *
     * @return UrlService
     */
    public function addPartToHref(string $part = ''): self
    {
        $this->href .= $part;

        return $this;
    }

    /**
     * @param string $src
     *
     * @return UrlService
     */
    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        $parts = $this->getParseUrl();
        if (! $this->host) {
            $this->host = implode('', [
                $parts['scheme'],
                '://',
                $parts['host'],
            ]);
        }

        return $this->host;
    }

    /**
     * @return bool
     */
    protected function checkHttpExists(): bool
    {
        return mb_strpos($this->src, 'http') !== 0;
    }

    /**
     * @return UrlService
     */
    protected function buildUrl(): self
    {
        $this->setSrc(
            http_build_url(
                $this->url,
                [
                    'path' => $this->buildPath(),
                ]
            )
        );

        return $this;
    }

    /**
     * @return string
     */
    protected function buildPath(): string
    {
        if (! $this->path) {
            $this->path = implode('', [
                '/',
                trim($this->getSrcWithoutHost(), '/')
            ]);
        }

        return $this->path;
    }

    /**
     * @return UrlService
     */
    protected function generateHost(): self
    {
        $this->addPartToHref(
            $this->getHost()
        );

        return $this;
    }

    /**
     * @return UrlService
     */
    protected function generatePort(): self
    {
        $parts = $this->getParseUrl();
        if (isset($parts['port'])) {
            $this->addPartToHref(':')
                ->addPartToHref($parts['port']);
        }

        return $this;
    }

    /**
     * @return UrlService
     */
    protected function generatePath(): self
    {
        $parts = $this->getParseUrl();
        if (isset($parts['path'])) {
            $this
                ->addPartToHref($parts['path']);
        }
        $this->addPartToHref($this->buildPath());

        return $this;
    }

    /**
     * @param bool $withPath
     *
     * @return UrlService
     */
    protected function generate(bool $withPath = true): self
    {
        $this->generateHost();
        $this->generatePort();
        if ($withPath) {
            $this->generatePath();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSrcWithoutHost(): string
    {
        $host = $this->getHost();
        if (mb_strpos($this->src, $host) !== false) {
            return str_replace($host, '', $this->src);
        }

        return $this->src;
    }
}
