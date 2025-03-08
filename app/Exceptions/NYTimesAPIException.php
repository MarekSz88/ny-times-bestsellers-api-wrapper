<?php

namespace App\Exceptions;

use Exception;

class NYTimesAPIException extends Exception
{
    public function __construct(string $message, int $code, array $jsonResponse = [])
    {
        $message = sprintf("%s. Response: %s",
            $message,
            $jsonResponse['fault']['faultstring'] ?? 'No details available'
        );
        parent::__construct($message, $code);
    }
}
