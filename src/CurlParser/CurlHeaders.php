<?php

namespace CurlConverter\CurlParser;

class CurlHeaders implements \JsonSerializable
{
    private const DEFAULT_CONTENT_TYPE = 'application/x-www-form-urlencoded';

    private array $semiColonSeparatedHeader = ["Cookie", "Content-Type", "Prefer"];
    private array $commaSeparatedHeader = [
        "A-IM",
        "Accept",
        "Accept-Charset",
        "Accept-Encoding",
        "Accept-Language",
        "Access-Control-Request-Headers",
        "Cache-Control",
        "Connection",
        "Content-Encoding",
        "Expect",
        "Forwarded",
        "If-Match",
        "If-None-Match",
        "Range",
        "TE",
        "Trailer",
        "Transfer-Encoding",
        "Upgrade",
        "Via",
        "Warning"
    ];

    private array $headers = [];
    private array $lowerCaseHeaderName = [];

    public function addHeader(string $headerName, string $headerValue): void
    {
        if (empty($this->headers[$headerName])) {
            $this->lowerCaseHeaderName[strtolower($headerName)] = $headerName;
        }
        $this->headers[$headerName][] = $headerValue;
    }

    public function setHeaderIfMissing(string $headerName, string $headerValue): void
    {
        if ($this->existsHeader($headerName)) {
            return;
        }

        $this->headers[$headerName][0] = $headerValue;
        $this->lowerCaseHeaderName[strtolower($headerName)] = $headerName;
    }

    public function getContentType(): string
    {
        if (!$this->existsHeader("Content-Type")) {
            return self::DEFAULT_CONTENT_TYPE;
        }

        $contentTypeDetails = explode(";", $this->headers["Content-Type"][0]);
        return trim($contentTypeDetails[0]);
    }

    public function deleteHeader(string $headerName): void
    {
        $lowerHeaderName = strtolower($headerName);
        $existingHeaderName = $this->lowerCaseHeaderName[$lowerHeaderName] ?? null;
        if (!$existingHeaderName) {
            return;
        }

        unset($this->headers[$existingHeaderName]);
        unset($this->lowerCaseHeaderName[$lowerHeaderName]);
    }

    public function existsHeader(string $headerName): bool
    {
        $lowerHeaderName = strtolower($headerName);
        return isset($this->lowerCaseHeaderName[$lowerHeaderName]);
    }

    public function getHeaderValue(string $headerName): ?string
    {
        $exisingHeaderName = $this->getExistingHeaderName($headerName);
        if (!$exisingHeaderName) {
            return null;
        }

        return $this->headers[$exisingHeaderName][0];
    }

    public function getExistingHeaderName(string $headerName): ?string
    {
        $lowerHeaderName = strtolower($headerName);
        return $this->lowerCaseHeaderName[$lowerHeaderName] ?? null;
    }


    public function count(): int
    {
        return count($this->headers);
    }

    public function jsonSerialize(): mixed
    {
        $formatedHeaderValues = [];
        foreach ($this->headers as $headerName => $headerValue) {
            if (in_array($headerName, $this->semiColonSeparatedHeader)) {
                $separator = "; ";
            } elseif (in_array($headerName, $this->commaSeparatedHeader)) {
                $separator = ", ";
            } else {
                $separator = null;
            }

            if ($separator) {
                $formatedHeaderValues[$headerName] = implode($separator, $headerValue);
            } else {
                $formatedHeaderValues[$headerName] = end($headerValue);
            }
        }

        return $formatedHeaderValues;
    }

}
