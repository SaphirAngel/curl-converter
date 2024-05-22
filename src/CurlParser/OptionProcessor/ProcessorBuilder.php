<?php

namespace CurlConverter\CurlParser\OptionProcessor;

class ProcessorBuilder
{
    private static array $processorInstances;

    public static function getProcessorByClassName(string $className): AbstractOptionProcessor
    {
       if (empty(self::$processorInstances[$className])) {
            self::$processorInstances[$className] = new $className();
        }

        return self::$processorInstances[$className];
    }
}
