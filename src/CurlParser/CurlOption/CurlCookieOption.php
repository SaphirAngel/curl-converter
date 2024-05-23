<?php

namespace CurlConverter\CurlParser\CurlOption;

use CurlConverter\CurlParser\CurlRequest;
use http\Cookie;

class CurlCookieOption extends AbstractCurlOption
{
    public function getProcessedValue(mixed $rawValue = null): array
    {
        $cookieEntity = new Cookie($rawValue);
        return $cookieEntity->getCookies();
    }

    public function applyToRequest(CurlRequest $request, mixed $rawValue = null): void
    {
        $cookies = $this->getProcessedValue($rawValue);
        foreach ($cookies as $cookieName => $cookieValue) {
            $request->addCookie($cookieName, $cookieValue);
        }

        if (!empty($cookies)) {
            $request->getHeaders()->addHeader('Cookie', $rawValue);
        }
    }
}
