<?php

namespace CurlConverter\CurlParser;

class CurlUrl implements \JsonSerializable
{
    private string $url;
    private string $rawUrl;
    private ?array $fragments = null;
    private array $queryParams = [];
    private ?array $authCredentials = null;
    private ?string $authType = null;

    public function setUrl(string $rawUrl, string $url): void
    {
        $this->rawUrl = $rawUrl;
        $this->url = $url;
    }

    public function getRawUrl(): string
    {
        return $this->rawUrl;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setQueryParams(array $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    public function setFragments(array $fragments): void
    {
        $this->fragments = $fragments;
    }

    public function addBasicAuth(string $username, ?string $password = null): void
    {
        $this->authType = 'basic';
        $this->authCredentials = [
            'username' => $username
        ];
        if (!is_null($password)) {
            $this->authCredentials['password'] = $password;
        }
    }

    public function getAuthType(): ?string
    {
        return $this->authType;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getAuthCredentials(): array
    {
        return $this->authCredentials;
    }

    public function jsonSerialize(): array
    {
        return [
            'url'              => $this->url,
            'raw_url'          => $this->rawUrl,
            'fragments'        => $this->fragments,
            'query_params'     => $this->queryParams,
            'auth_credentials' => $this->authCredentials,
            'auth_type'        => $this->authType
        ];
    }
}