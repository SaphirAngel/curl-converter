<?php

namespace CurlConverter\CurlParser\OptionProcessor;

use http\Header\Parser;

class HeaderProcessor extends AbstractOptionProcessor
{
    private Parser $headerParser;

    public function __construct()
    {
        $this->headerParser = new Parser();
    }

    public function parse(string $valueToParse): mixed
    {
        $this->headerParser->parse($valueToParse, Parser::CLEANUP, $parsedHeader);
        return $parsedHeader;
    }
}
