<?php

namespace CurlConverter\CurlParser;

class CurlData
{
    private array $rawDataList = [];

    public function addRawData(string $rawData): void
    {
        $this->rawDataList[] = $rawData;
    }

    public function withData(): bool
    {
        return count($this->rawDataList) > 0;
    }

    public function getParsedData(CurlRequest $request): mixed
    {
        if (empty($this->rawDataList)) {
            return null;
        }

        $jointedRawData = implode('&', $this->rawDataList);
        $requestContentType = $request->getHeaders()->getContentType() ?? 'application/x-www-form-urlencoded';
        echo $requestContentType;
        if ($requestContentType === 'application/json') {
            $parsedData = json_decode($jointedRawData, true);
        } elseif ($requestContentType === 'application/x-www-form-urlencoded') {
            parse_str($jointedRawData, $parsedData);
        } else {
            $parsedData = null;
        }

        return $parsedData ?? $jointedRawData;
    }
}
