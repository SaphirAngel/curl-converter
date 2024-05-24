<?php

use CurlConverter\CurlParser\CurlBuilder;

include_once dirname(__DIR__) . '/vendor/autoload.php';

$parser = new CurlBuilder();
$curlCommand = <<<EOF
               curl 'http://fiddle.jshell.net/echo/html/' 
               -H 'Origin: http://fiddle.jshell.net'
               -H 'Accept-Encoding: gzip, deflate' 
               -H 'Accept-Language: en-US,en;q=0.8' 
               --cookie "USER_TOKEN=Yes; BONJOUR=ok" 
               --cookie "t2=bonour; BONJOUR=ok" 
               -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36' -H 'Content-Type: application/json; charset=UTF-8'
               -H 'Accept: */*' 
               -H 'Referer: http://fiddle.jshell.net/_display/' 
               -H 'X-Requested-With: XMLHttpRequest'
               -H 'Connection: keep-alive' 
               --json '{"test":"ok"}' 
               --data "ok=bonjour" 
               --compressed
               EOF;


$curlRequest = $parser->fromCurlCommand($curlCommand);
print_r($curlRequest);
$json = json_encode($curlRequest);
$newCurlRequest = $parser->fromJson(json_decode($json, true));




/*
$jsonTransformer = new JsonTransformer();
echo $jsonTransformer->transform($curlRequest);
*/
