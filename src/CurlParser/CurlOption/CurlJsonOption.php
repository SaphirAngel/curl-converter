<?php

namespace CurlConverter\CurlParser\CurlOption;

use CurlConverter\CurlParser\CurlRequest;

class CurlJsonOption extends AbstractCurlOption
{
    public function getProcessedValue(mixed $rawValue = null): mixed
    {
        return $rawValue;
    }

    public function applyToRequest(CurlRequest $request, mixed $rawValue = null): void
    {
        $request->getHeaders()->setHeaderIfMissing("Content-Type", "application/json");
        $request->getHeaders()->setHeaderIfMissing("Accept", "application/json");
        $request->getData()->addRawData($rawValue);
    }
}
