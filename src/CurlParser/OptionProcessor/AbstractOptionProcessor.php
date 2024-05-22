<?php

namespace CurlConverter\CurlParser\OptionProcessor;

abstract class AbstractOptionProcessor
{
    abstract public function parse(string $valueToParse): mixed;
}
