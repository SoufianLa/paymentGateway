<?php

namespace App\ErrorHandler\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    public function __construct(int $statusCode, string $message, array $headers=[])
    {
        parent::__construct($statusCode, $message, null, $headers);
    }
}