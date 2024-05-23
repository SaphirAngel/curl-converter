<?php

namespace CurlConverter\CurlParser\CurlOption;

class CurlStringOption extends AbstractCurlOption
{
    public function getProcessedValue(mixed $rawValue = null): mixed
    {
        return $rawValue;
    }
}
