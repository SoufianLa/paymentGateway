<?php

namespace App\Service\Payment;

use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;
use App\Service\Payment\Contract\IConnector;
use App\Service\Payment\Contract\IConnectorFactory;
use App\Service\Payment\Contract\IPaymentGateway;

class PaymentGateway implements IPaymentGateway
{
    public function __construct(readonly private IConnectorFactory $connectorFactory){

    }
    private IConnector $connector;

    public function init(string $connectorCode): void
    {
        $connector = $this->connectorFactory->getConnector($connectorCode);
        $this->connector = $connector;
    }


    public function process(TransactionDTO $transactionDTO): ResponseDTO
    {

        return $this->connector->process($transactionDTO);
    }

}