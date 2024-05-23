<?php

namespace CurlConverter\CurlParser\CurlOption;


use CurlConverter\CurlParser\CurlRequest;

class CurlDataOption extends AbstractCurlOption
{
    public function getProcessedValue(mixed $rawValue = null): mixed
    {
        return $rawValue;
    }

    private function processJsonData(CurlRequest $request): void
    {
        $request->getHeaders()->setHeaderIfMissing("Content-Type", "application/json");
        $request->getHeaders()->setHeaderIfMissing("Accept", "application/json");
    }

    public function applyToRequest(CurlRequest $request, mixed $rawValue = null): void
    {
        if ($this->getName() === 'json') {
            $this->processJsonData($request);
        }

        $request->getData()->addRawData($rawValue);
    }
}
