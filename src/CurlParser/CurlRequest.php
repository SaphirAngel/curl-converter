<?php

namespace CurlConverter\CurlParser;

use Psr\Http\Message\ServerRequestInterface;

class CurlRequest
{
    /** @var CurlUrl[] */
    private array $urls = [];
    private array $queryParams = [];

    private array $cookies = [];

    private CurlHeaders $headers;
    private array $options = [];

    private CurlData $data;

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

    public function getCookies()
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
}
