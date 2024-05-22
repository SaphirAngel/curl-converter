<?php

namespace Exception;

use Exception;

class CurlArgumentNotFound extends Exception
{
    public function __construct(string $rawArgumentName)
    {
        $message = "Not valid curl argument <$rawArgumentName>";
        parent::__construct($message);
    }
}
