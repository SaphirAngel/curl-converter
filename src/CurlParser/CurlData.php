<?php

namespace CurlConverter\CurlParser;

use JsonSerializable;

class CurlData implements JsonSerializable
{
    private array $rawDataList = [];

    public static function fromJson(array $rawCurlData): CurlData
    {
        $curlData = new self();
        $curlData->rawDataList = $rawCurlData;
        return $curlData;
    }

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

    public function jsonSerialize(): array
    {
        return $this->rawDataList;
    }
}
