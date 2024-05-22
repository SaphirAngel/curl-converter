<?php

use CurlConverter\CurlParser\Parser;
use CurlConverter\Psr7RequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;

include_once dirname(__DIR__) . '/vendor/autoload.php';

$parser = new Parser();
$curlCommand = "curl 'https://en.wikipedia.org/?test=ok&bonjour[]=a&bonjour[]=b&bonjour[]=c#flag' -H 'Content-Type: mon_header' -m 32";

$psr17Factory = new Psr17Factory();
$requestCreator = new Psr7RequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);

$parsedCurlCommand = $parser->parse($curlCommand);

