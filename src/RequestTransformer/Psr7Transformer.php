<?php

namespace CurlConverter\RequestTransformer;

use CurlConverter\CurlParser\CurlRequest;
use CurlConverter\CurlParser\CurlUrl;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class Psr7Transformer
{
    private ServerRequestFactoryInterface $serverRequestFactory;
    private UriFactoryInterface $uriFactory;
    private UploadedFileFactoryInterface $uploadedFileFactory;
    private StreamFactoryInterface $streamFactory;

    public function __construct(
        ServerRequestFactoryInterface $serverRequestFactory,
        UriFactoryInterface           $uriFactory,
        UploadedFileFactoryInterface  $uploadedFileFactory,
        StreamFactoryInterface        $streamFactory
    ) {
        $this->serverRequestFactory = $serverRequestFactory;
        $this->uriFactory = $uriFactory;
        $this->uploadedFileFactory = $uploadedFileFactory;
        $this->streamFactory = $streamFactory;
    }

    public function getRequestFromParsedCommand(CurlRequest $curlRequest): ServerRequestInterface
    {
        $uri = $this->getUriFromCurlUrl($curlRequest->getUrls()[0]);
        $protocolVersion = $this->getProtocolVersionFromCurlRequest($curlRequest);

        $serverRequest = $this->serverRequestFactory->createServerRequest($curlRequest->getMethod(), $uri);
        foreach ($curlRequest->getHeaders() as $headerName => $headerValue) {
            $serverRequest = $serverRequest->withAddedHeader($headerName, $headerValue);
        }

        return $serverRequest
            ->withProtocolVersion($protocolVersion)
            ->withCookieParams($curlRequest->getCookies())
            ->withQueryParams($curlRequest->getUrls()[0]->getQueryParams());
    }

    public function getProtocolVersionFromCurlRequest(CurlRequest $curlRequest): string
    {
        if (!is_null($curlRequest->getOption('http1.0'))) {
            $httpVersion = '1.0';
        } elseif (!is_null($curlRequest->getOption('http1.1'))) {
            $httpVersion = '1.1';
        } elseif (!is_null($curlRequest->getOption('http2'))) {
            $httpVersion = '2';
        } elseif (!is_null($curlRequest->getOption('http2-prior-knowledge'))) {
            $httpVersion = '2';
        } elseif (!is_null($curlRequest->getOption('http3'))) {
            $httpVersion = '3';
        } else {
            $httpVersion = '1.1';
        }

        return $httpVersion;
    }

    public function getUriFromCurlUrl(CurlUrl $curlUrl): UriInterface
    {
        $uri = $this->uriFactory->createUri($curlUrl->getRawUrl());

        if ($curlUrl->getAuthType() === "basic") {
            $authCredential = $curlUrl->getAuthCredentials();
            $uri = $uri->withUserInfo(
                $authCredential['username'],
                $authCredential['password'] ?? null
            );
        }

        return $uri;
    }
}
