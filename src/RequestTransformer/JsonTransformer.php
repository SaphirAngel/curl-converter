<?php

namespace CurlConverter\RequestTransformer;

use CurlConverter\CurlParser\CurlRequest;

class JsonTransformer
{
    public function transform(CurlRequest $request): false|string
    {
        $jsonData = [
            "url"     => $request->getUrls()[0]->getUrl(),
            "raw_url" => $request->getUrls()[0]->getRawUrl(),
            "method"  => $request->getMethod()
        ];

        if ($request->getHeaders()->count() > 0) {
            $jsonData['headers'] = $request->getHeaders();
        }

        if (count($request->getCookies()) > 0) {
            $jsonData['cookies'] = $request->getCookies();
        }

        $parsedData = $request->getData()->getParsedData($request);
        if (!empty($parsedData)) {
            $jsonData['data'] = $parsedData;
        }

        return json_encode($jsonData);
    }
}
