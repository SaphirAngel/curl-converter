<?php

namespace CurlConverter;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class Psr7RequestCreator
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

    public function getRequestFromParsedCommand(array $parsedCommand): ServerRequestInterface
    {
        $method = $parsedCommand['method'];
        $uri = $this->getUriFromParsedCommand($parsedCommand);
        $protocolVersion = $this->getProtocolVersionFromParsedCommand($parsedCommand);

        $serverRequest = $this->serverRequestFactory->createServerRequest($method, $uri);
        foreach ($parsedCommand['header'] as $headerName => $headerValue) {
            $serverRequest = $serverRequest->withAddedHeader($headerName, $headerValue);
        }

        return $serverRequest
            ->withProtocolVersion($protocolVersion)
            ->withCookieParams($parsedCommand['cookies'] ?? [])
            ->withQueryParams($parsedCommand['queries'] ?? []);
    }

    public function getProtocolVersionFromParsedCommand(array $parsedCommand): string
    {
        if (isset($parsedCommand['http1.0'])) {
            $httpVersion = '1.0';
        } elseif (isset($parsedCommand['http1.1'])) {
            $httpVersion = '1.1';
        } elseif (isset($parsedCommand['http2'])) {
            $httpVersion = '2';
        } elseif (isset($parsedCommand['http2-prior-knowledge'])) {
            $httpVersion = '2';
        } elseif (isset($parsedCommand['http3'])) {
            $httpVersion = '3';
        } else {
            $httpVersion = '1.1';
        }

        return $httpVersion;
    }

    public function getUriFromParsedCommand(array $parsedCommand): UriInterface
    {
        $uri = $this->uriFactory->createUri($parsedCommand['raw_url']);

        if (isset($parsedCommand['auth'])) {
            $uri = $uri->withUserInfo(
                $parsedCommand['auth']['username'],
                $parsedCommand['auth']['password'] ?? null
            );
        }

        return $uri;
    }
}
