<?php

namespace CurlConverter\CurlParser;

use Exception;
use JsonSerializable;

class CurlRequest implements JsonSerializable
{
    /** @var CurlUrl[] */
    private array $urls = [];
    private array $queryParams = [];

    private array $cookies = [];

    private CurlHeaders $headers;
    private array $options = [];

    private CurlData $data;

    /**
     * @throws Exception
     */
    public static function fromJson(array $rawCurlRequest): CurlRequest
    {
        $curlRequest = new self();
        foreach ($rawCurlRequest['urls'] as $rawUrl) {
            $curlRequest->urls[] = CurlUrl::fromJson($rawUrl);
        }

        $curlRequest->headers = CurlHeaders::fromJson($rawCurlRequest['headers'] ?? []);
        $curlRequest->data = CurlData::fromJson($rawCurlRequest['data'] ?? []);

        $curlRequest->queryParams = $rawCurlRequest['query_params'] ?? [];
        $curlRequest->cookies = $rawCurlRequest['cookies'] ?? [];
        $curlRequest->options = $rawCurlRequest['options'] ?? [];

        return $curlRequest;
    }

    public function __construct()
    {
        $this->headers = new CurlHeaders();
        $this->data = new CurlData();
    }

    public function addUrl(CurlUrl $url): void
    {
        $this->urls[] = $url;
    }

    public function addCookie(string $cookieName, string $cookieValue): void
    {
        $this->cookies[$cookieName] = $cookieValue;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getHeaders(): CurlHeaders
    {
        return $this->headers;
    }

    public function setOption(string $optionName, mixed $optionValue): void
    {
        $this->options[$optionName] = $optionValue;
    }

    public function getOption(string $optionName): mixed
    {
        return $this->options[$optionName] ?? null;
    }

    public function getData(): CurlData
    {
        return $this->data;
    }

    public function getMethod(): string
    {
        if ($this->options['method']) {
            $method = $this->options['method'];
        } elseif ($this->data->withData()) {
            $method = 'post';
        } else {
            $method = 'get';
        }

        return $method;
    }

    public function jsonSerialize(): array
    {
        return [
            'urls'        => $this->urls,
            'queryParams' => $this->queryParams,
            'cookies'     => $this->cookies,
            'headers'     => $this->headers,
            'data'        => $this->data,
            'options'     => $this->options
        ];
    }
}
