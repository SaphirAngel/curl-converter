<?php

namespace CurlConverter;

class RequestUrlDTO
{
    public string $originalUrl;
    public string $url;
    public string $method = 'GET';
    public ?array $auth = null;
}
