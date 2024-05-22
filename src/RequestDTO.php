<?php

namespace CurlConverter;

class RequestDTO
{
    public RequestUrlDTO $requestUrl;

    public ?bool $globoff;
    public ?bool $disallowUsernameInUrl;
    public ?bool $pathAsIs;


    public ?string $authType;
    public ?string $proxyAuthType;


    public array $headers = [];
    public array $proxyHeaders = [];
    public ?bool $refererAuto;

    public ?bool $compressed;
    public ?bool $transferEncoding;
}
