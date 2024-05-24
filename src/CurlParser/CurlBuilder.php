<?php

namespace CurlConverter\CurlParser;

use CurlConverter\CurlParser\CurlOption\AbstractCurlOption;
use CurlConverter\CurlParser\CurlOption\CurlOptionBuilder;
use Exception;
use Exception\CurlArgumentNotFound;

class CurlBuilder
{
    /**
     * @throws CurlArgumentNotFound
     */
    public function fromCurlCommand(string $curlCommand, CurlRequest $curlRequest = null): CurlRequest
    {
        if (is_null($curlRequest)) {
            $curlRequest = new CurlRequest();
        }

        $commandArgs = \Clue\Arguments\split($curlCommand);
        array_shift($commandArgs);
        $this->applyArgsToRequest($commandArgs, $curlRequest);

        return $curlRequest;
    }

    /**
     * @throws Exception
     */
    public function fromJson(array $rawCurlRequest): CurlRequest
    {
        return CurlRequest::fromJson($rawCurlRequest);
    }

    /**
     * @throws CurlArgumentNotFound
     * @throws Exception
     */
    public function parseLongOption(array $commandArguments, int &$argumentPosition, CurlRequest $curlRequest): void
    {
        $argumentName = substr($commandArguments[$argumentPosition], 2);
        $curlOption = CurlOptionBuilder::getOption($argumentName);
        if (!$curlOption) {
            throw new CurlArgumentNotFound($argumentName);
        }

        if ($curlOption->getType() === 'string') {
            $rawOptionValue = $commandArguments[++$argumentPosition];
            $curlOption->applyToRequest($curlRequest, $rawOptionValue);
        } elseif ($curlOption->getType() === 'bool') {
            $curlOption->applyToRequest($curlRequest);
        }
    }

    /**
     * @throws Exception
     */
    public function parseShortOption(array $commandArguments, int &$argumentPosition, CurlRequest $curlRequest): void
    {
        $argumentName = substr($commandArguments[$argumentPosition], 1);
        $argumentNameSize = strlen($argumentName);

        for (
            $argumentCharacterPosition = 0;
            $argumentCharacterPosition < $argumentNameSize;
            $argumentCharacterPosition++
        ) {
            $shortOptionName = substr($argumentName, $argumentCharacterPosition, 1);
            $curlOption = CurlOptionBuilder::getDetailsForShortOptionName($shortOptionName);

            if ($curlOption->getType() === 'string') {
                if ($argumentCharacterPosition == $argumentNameSize - 1) {
                    $rawOptionValue = $commandArguments[++$argumentPosition];
                } else {
                    $rawOptionValue = substr($argumentName, $argumentPosition + 1, $argumentNameSize);
                }

                $curlOption->applyToRequest($curlRequest, $rawOptionValue);
                break;
            } elseif ($curlOption->getType() === 'bool') {
                $curlOption->applyToRequest($curlRequest);
            }
        }
    }

    public function addOptionToReport(
        AbstractCurlOption $curlOption,
        array              $argumentReports,
        ?string            $rawOptionValue = null
    ): array {
        if (!is_null($rawOptionValue)) {
            $processedValue = $curlOption->getProcessedValue($rawOptionValue);
        } else {
            $processedValue = $curlOption->getProcessedValue();
        }

        if ($curlOption->canBeList()) {
            $argumentReports[$curlOption->getName()] = array_merge(
                $argumentReports[$curlOption->getName()] ?? [],
                $processedValue
            );
        } else {
            $argumentReports[$curlOption->getName()] = $processedValue;
        }

        return $argumentReports;
    }

    /**
     * @throws CurlArgumentNotFound
     * @throws Exception
     */
    public function applyArgsToRequest(array $commandArguments, CurlRequest $curlRequest): void
    {
        for ($argumentPosition = 0; $argumentPosition < count($commandArguments); $argumentPosition++) {
            $argument = $commandArguments[$argumentPosition];
            if (str_starts_with($argument, '--')) {
                $this->parseLongOption($commandArguments, $argumentPosition, $curlRequest);
            } elseif (str_starts_with($argument, '-')) {
                $this->parseShortOption($commandArguments, $argumentPosition, $curlRequest);
            } else {
                $curlOption = CurlOptionBuilder::getOption("url");
                $curlOption->applyToRequest($curlRequest, $argument);
            }
        }
    }
}
