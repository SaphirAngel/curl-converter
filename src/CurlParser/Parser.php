<?php

namespace CurlConverter\CurlParser;

use CurlConverter\CurlParser\OptionProcessor\ProcessorBuilder;
use CurlConverter\CurlParser\OptionProcessor\UrlProcessor;
use Exception;
use Exception\CurlArgumentNotFound;

class Parser
{
    public function parse(string $curlCommand)
    {
        $commandArgs = \Clue\Arguments\split($curlCommand);
        array_shift($commandArgs);
        return $this->parseArgs($commandArgs);
    }

    /**
     * @throws CurlArgumentNotFound
     * @throws Exception
     */
    public function parseLongOption(array $commandArguments, int &$argumentPosition, array $argumentReports): array
    {
        $argumentName = substr($commandArguments[$argumentPosition], 2);
        $curlOption = CurlOptions::getDetails($argumentName);
        if (!$curlOption) {
            throw new CurlArgumentNotFound($argumentName);
        }

        if ($curlOption->getType() === 'string') {
            $rawOptionValue = $commandArguments[++$argumentPosition];
            $argumentReports = $this->addOptionToReport($curlOption, $argumentReports, $rawOptionValue);
        } elseif ($curlOption->getType() === 'bool') {
            $argumentReports = $this->addOptionToReport($curlOption, $argumentReports);
        }

        return $argumentReports;
    }

    /**
     * @throws Exception
     */
    public function parseShortOption(array $commandArguments, int &$argumentPosition, array $argumentReports): array
    {
        $argumentName = substr($commandArguments[$argumentPosition], 1);
        $argumentNameSize = strlen($argumentName);

        for (
            $argumentCharacterPosition = 0;
            $argumentCharacterPosition < $argumentNameSize;
            $argumentCharacterPosition++
        ) {
            $shortOptionName = substr($argumentName, $argumentCharacterPosition, 1);
            $curlOption = CurlOptions::getDetailsForShortOptionName($shortOptionName);

            if ($curlOption->getType() === 'string') {
                if ($argumentCharacterPosition == $argumentNameSize - 1) {
                    $rawOptionValue = $commandArguments[++$argumentPosition];
                } else {
                    $rawOptionValue = substr($argumentName, $argumentPosition + 1, $argumentNameSize);
                }

                $argumentReports = $this->addOptionToReport($curlOption, $argumentReports, $rawOptionValue);
                break;
            } elseif ($curlOption->getType() === 'bool') {
                $argumentReports = $this->addOptionToReport($curlOption, $argumentReports);
            }
        }

        return $argumentReports;
    }

    public function addOptionToReport(
        CurlOption $curlOption,
        array      $argumentReports,
        ?string    $rawOptionValue = null
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
    public function parseArgs(array $commandArguments)
    {
        $argumentReports = [
            'method' => 'GET'
        ];

        for ($argumentPosition = 0; $argumentPosition < count($commandArguments); $argumentPosition++) {
            $argument = $commandArguments[$argumentPosition];
            if (str_starts_with($argument, '--')) {
                $argumentReports = $this->parseLongOption($commandArguments, $argumentPosition, $argumentReports);
            } elseif (str_starts_with($argument, '-')) {
                $argumentReports = $this->parseShortOption($commandArguments, $argumentPosition, $argumentReports);
            } else {
                $urlProcessor = ProcessorBuilder::getProcessorByClassName(UrlProcessor::class);
                $argumentReports += $urlProcessor->parse($argument);
            }
        }

        return $argumentReports;
    }
}
