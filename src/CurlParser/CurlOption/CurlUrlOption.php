<?php

namespace CurlConverter\CurlParser\CurlOption;

use CurlConverter\CurlParser\CurlRequest;
use CurlConverter\CurlParser\CurlUrl;

class CurlUrlOption extends AbstractCurlOption
{

    private function parseAuthData(array $parsedUrl, CurlUrl $curlUrl): void
    {
        if (!isset($parsedUrl['user'])) {
            return;
        }

        $curlUrl->addBasicAuth($parsedUrl['user'], $parsedUrl['pass'] ?? null);
    }

    private function parseQuery(array $parsedUrl, CurlUrl $curlUrl): void
    {
        if (empty($parsedUrl['query'])) {
            return;
        }
        $newRawUrl = $curlUrl->getRawUrl() . '?' . $parsedUrl['query'];
        parse_str($parsedUrl['query'], $queryParams);
        $curlUrl->setQueryParams($queryParams);
        $curlUrl->setUrl($newRawUrl, $curlUrl->getUrl());
    }

    private function parseFragment(array $parsedUrl, CurlUrl $curlUrl): void
    {
        if (empty($parsedUrl['fragment'])) {
            return;
        }

        $newRawUrl = $curlUrl->getRawUrl() . '#' . $parsedUrl['fragment'];
        parse_str($parsedUrl['fragment'], $fragments);
        $curlUrl->setFragments($fragments);
        $curlUrl->setUrl($newRawUrl, $curlUrl->getUrl());
    }

    public function getProcessedValue(mixed $rawValue = null): CurlUrl
    {
        $parsedUrl = parse_url($rawValue);

        $url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        $rawUrl = $url;

        $curlUrl = new CurlUrl();
        $curlUrl->setUrl($rawUrl, $url);

        $this->parseAuthData($parsedUrl, $curlUrl);
        $this->parseQuery($parsedUrl, $curlUrl);
        $this->parseFragment($parsedUrl, $curlUrl);

        return $curlUrl;
    }

    public function applyToRequest(CurlRequest $request, mixed $rawValue = null): void
    {
        $request->addUrl($this->getProcessedValue($rawValue));
    }
}
