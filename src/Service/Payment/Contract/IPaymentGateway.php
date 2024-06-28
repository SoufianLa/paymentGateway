<?php

namespace App\Service\Payment\Contract;

use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;

interface IPaymentGateway
{
    public function init(string $connectorCode): void;
    public function process(TransactionDTO $transactionDTO): ResponseDTO;


}