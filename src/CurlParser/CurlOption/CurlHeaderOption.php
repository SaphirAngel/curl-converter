<?php

namespace CurlConverter\CurlParser\CurlOption;

use CurlConverter\CurlParser\CurlRequest;
use http\Cookie;
use http\Header\Parser;

class CurlHeaderOption extends AbstractCurlOption
{

    private Parser $headerParser;

    public function __construct(
        string  $rawOptionName,
        string  $name,
        string  $type,
        bool    $expand = true,
        bool    $canBeList = false,
        ?string $removedVersion = null,
        ?string $internalName = null
    ) {
        parent::__construct($rawOptionName, $name, $type, $expand, $canBeList, $removedVersion, $internalName);
        $this->headerParser = new Parser();
    }

    public function getProcessedValue(mixed $rawValue = null): mixed
    {
        $this->headerParser->parse($rawValue, Parser::CLEANUP, $parsedHeader);

        return $parsedHeader;
    }

    public function applyToRequest(CurlRequest $request, mixed $rawValue = null): void
    {
        $parsedHeader = $this->getProcessedValue($rawValue);
        foreach ($parsedHeader as $headerName => $headerValue) {
            if (strtolower($headerName) === 'cookie') {
                $cookieEntity = new Cookie($headerValue);
                foreach ($cookieEntity->getCookies() as $cookieName => $cookieValue) {
                    $request->addCookie($cookieName, $cookieValue);
                }
            }

            $request->getHeaders()->addHeader($headerName, $headerValue);
        }
    }
}
