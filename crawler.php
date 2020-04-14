<?php

if (!isset($argv[1])) {
    throw new Exception('First argument with site url required.');
}

if (filter_var($argv[1], FILTER_VALIDATE_URL) === FALSE) {
    throw new Exception('First argument is not valid url.');
}

require './vendor/autoload.php';

$pageService = new \Crawler\Services\PageService();
$crawler = new \Crawler\Crawler($pageService, $argv[1]);
$crawler->run();
