<?php

namespace CurlConverter\CurlParser;

use Psr\Http\Message\ServerRequestInterface;

class CurlRequest
{
    private ServerRequestInterface $request;
    private array $curlOptions;

    public function __construct(
        ServerRequestInterface $request,
        array                  $curlOptions = []
    ) {
        $this->request = $request;
        $this->curlOptions = $curlOptions;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function getCurlOptions(): array
    {
        return $this->curlOptions;
    }
}
