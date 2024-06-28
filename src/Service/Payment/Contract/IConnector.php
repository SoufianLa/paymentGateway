<?php

namespace App\Service\Payment\Contract;

use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;


#[AutoconfigureTag(name: "connector")]
interface IConnector
{
    public function process(TransactionDTO $transactionDTO): ResponseDTO;
    public function supportCode(string $code) : bool;

}