<?php

namespace CurlConverter\CurlParser;

use CurlConverter\CurlParser\OptionProcessor\AbstractOptionProcessor;

class CurlStringOption extends CurlOption
{
    private ?AbstractOptionProcessor $optionProcessor;

    public function __construct(
        string                   $rawOptionName,
        string                   $name,
        string                   $type,
        bool                     $expand = true,
        bool                     $canBeList = false,
        ?string                  $removedVersion = null,
        ?AbstractOptionProcessor $optionProcessor = null
    ) {
        parent::__construct($rawOptionName, $name, $type, $expand, $canBeList, $removedVersion);
        $this->optionProcessor = $optionProcessor;
    }

    public function getProcessedValue(mixed $rawValue = null): mixed
    {
        if (empty($this->optionProcessor)) {
            return $rawValue;
        }

        return $this->optionProcessor->parse($rawValue);
    }

    public function applyToRequest(array $request, mixed $rawValue = null): array
    {
        $request[$this->getName()] = $this->getProcessedValue($rawValue);
        return $request;
    }
}
