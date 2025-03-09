<?php

namespace App\Exceptions;

use Exception;

class NYTimesAPIException extends Exception
{
    public function __construct(string $message, int $code, array $jsonResponse = [])
    {
        $message = sprintf("%s. Response: %s",
            $message,
            $this->parseResponsesFromNYTimes($jsonResponse)
        );
        parent::__construct($message, $code);
    }

    private function parseResponsesFromNYTimes(array $jsonResponse): string
    {
        if (!empty($jsonResponse['errors'])) {
            return join('. ', $jsonResponse['errors']);
        } elseif (!empty($jsonResponse['fault']['faultstring'])) {
            return $jsonResponse['fault']['faultstring'];
        } else {
            return 'No details available';
        }
    }
}
