<?php

namespace CurlConverter\CurlParser\OptionProcessor;

class UrlProcessor extends AbstractOptionProcessor
{
    private function parseAuthData(array $parsedUrl, array &$report): void
    {
        if (!isset($parsedUrl['user'])) {
            return;
        }

        $report['auth'] = [
            'username' => $parsedUrl['user']
        ];
        $report['auth_type'] = "basic";

        if (isset($parsedUrl['pass'])) {
            $report['auth']['password'] = $parsedUrl['pass'];
        }
    }

    private function parseQuery(array $parsedUrl, array &$report): void
    {
        if (empty($parsedUrl['query'])) {
            return;
        }

        $report['raw_url'] .= '?' . $parsedUrl['query'];
        parse_str($parsedUrl['query'], $queries);
        $report['queries'] = $queries;
    }

    private function parseFragment(array $parsedUrl, array &$report): void
    {
        if (empty($parsedUrl['fragment'])) {
            return;
        }

        $report['raw_url'] .= '#' . $parsedUrl['fragment'];
        parse_str($parsedUrl['fragment'], $fragments);
        $report['fragments'] = $fragments;
    }

    public function parse(string $valueToParse): array
    {
        $parsedUrl = parse_url($valueToParse);

        $url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        $rawUrl = $url;

        $report = [
            'url'     => $url,
            'raw_url' => $rawUrl
        ];

        $this->parseAuthData($parsedUrl, $report);
        $this->parseQuery($parsedUrl, $report);
        $this->parseFragment($parsedUrl, $report);

        return $report;
    }
}
