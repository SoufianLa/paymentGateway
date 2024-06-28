<?php

namespace App\Component\Payment\Connector\ACI;

use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;
use App\ErrorHandler\Exception\ApiException;
use App\Service\Payment\Contract\IConnector;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class ACIConnector implements IConnector
{
    const CODE = 'aci';

    public function __construct(readonly private HttpClientInterface $aciClient)
    {

    }

    public function process(TransactionDTO $transactionDTO): ResponseDTO
    {
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" .$transactionDTO->getAmount().
            "&currency=EUR" .
            "&paymentBrand=VISA" .
            "&paymentType=DB" .
            "&card.number=4200000000000000" .
            "&card.holder=Jane Jones" .
            "&card.expiryMonth=05" .
            "&card.expiryYear=2034" .
            "&card.cvv=123";
        try{
            $result = $this->aciClient->request('POST','/v1/payments', [
                    "body" => $data,
                ]
            );

            return new ResponseDTO(
                $result->toArray()['id'],
                $result->toArray()['timestamp'],
                $result->toArray()['amount'],
                $result->toArray()['currency'],
                $result->toArray()['card']['bin']
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