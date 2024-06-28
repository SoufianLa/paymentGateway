<?php

namespace App\Component\Payment\Connector\Sandbox;

use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;
use App\Service\Payment\Contract\IConnector;

class SandboxConnector implements IConnector
{
    const CODE = 'sandbox';

    public function process(TransactionDTO $transactionDTO): ResponseDTO
    {
        return new ResponseDTO('sandboxId', '2024-06-28T17:48:21+00:00', '100', 'USD', 'Bin');
    }

    public function supportCode(string $code): bool
    {
        return $code === self::CODE;
    }
}