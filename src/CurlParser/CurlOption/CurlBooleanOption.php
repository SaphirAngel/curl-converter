<?php

namespace CurlConverter\CurlParser\CurlOption;

class CurlBooleanOption extends AbstractCurlOption
{
    public function getProcessedValue(mixed $rawValue = null): bool
    {
        if (str_starts_with($this->getRawOptionName(), 'no-disable-')) {
            return true;
        }

        if (
            str_starts_with($this->getRawOptionName(), 'disable-') ||
            str_starts_with($this->getRawOptionName(), 'no-')
        ) {
            return false;
        }

        return true;
    }
}
