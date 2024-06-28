<?php

namespace App\Component\Payment\Connector\Shift4;

use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;
use App\ErrorHandler\Exception\ApiException;
use App\Service\Payment\Contract\IConnector;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Shift4Connector implements IConnector
{
    const CODE = 'shift4';

    public function __construct(readonly private HttpClientInterface $shift4Client)
    {

    }
    public function process(TransactionDTO $transactionDTO): ResponseDTO
    {
        try{
            $result = $this->shift4Client->request('POST','/charges', [
                    "body" => [
                        "amount" => $transactionDTO->getAmount(),
                        "currency" => $transactionDTO->getCurrency(),
                        /* hardcoded for testing purposes */
                        "customerId" => "cust_MY20U98gmrY3XJv0c6MWa2gj",
                        "card" => "card_5xiWjhnWC8hsygYO3HiwDWvF",
                        "description" => "from api",
                    ],
                ]
            );

            return new ResponseDTO(
                $result->toArray()['id'],
                $result->toArray()['created'], $result->toArray()['amount'],
                $result->toArray()['currency'], $result->toArray()['card']['first6']
            );

        }catch (ClientExceptionInterface $ex){
            throw new ApiException($ex->getCode(), $ex->getMessage());
        }
    }

    public function supportCode(string $code): bool
    {
        return $code === self::CODE;
    }
}