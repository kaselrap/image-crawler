<?php

namespace Crawler\Services;

class ImageService
{
    /**
     * @var string
     */
    private string $src;

    /**
     * @var string
     */
    private string $url;

    /**
     * ImageService constructor.
     *
     * @param string $url
     * @param string $src
     */
    public function __construct(string $url, string $src)
    {
        $this->url = $url;
        $this->src = $src;
    }

    public function copy()
    {
        $name = $this->parse();
        $url = parse_url($this->url);
        $dir = $_SERVER["DOCUMENT_ROOT"] . 'images/' . $url['host'] . '/';
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $filename = $dir . $name;
        if (!file_exists($filename)) {
            copy(
                $this->getSrc(),
                $filename
            );
        }
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        if (is_int(strpos($this->src, 'http')) || is_int(strpos($this->src, $this->url))) {
            return $this->src;
        }

        return implode('/', [
            rtrim($this->url, '/'),
            ltrim($this->src, '/')
        ]);
    }

    /**
     * @return string
     */
    private function parse(): string
    {
        $pathInfo = pathinfo($this->src);
        $filename = $pathInfo['filename'] ?? time();
        $baseName = $pathInfo['basename'];
        $extension = 'jpg';
        preg_match('/\.(jpg|jpeg|gif|png|svg)(\?.*)?$/', $baseName, $matches);
        if (isset($matches[1])) {
            $extension = $matches[1];
        }

        return $filename . '.'.  $extension;
    }
}
