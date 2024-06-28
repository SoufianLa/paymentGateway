<?php

namespace App\Controller\Api\Payment;

use App\DTO\TransactionDTO;
use App\Service\Payment\Contract\IPaymentGateway;
use App\Service\Util\Contract\IResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PaymentProcessorController extends AbstractController
{
    public function __construct(private readonly IResponder $responder,
    private readonly IPaymentGateway $gateway){

    }
    #[Route('/api/payment/{connector}', name: 'process_payment', methods: ['POST'])]
    public function __invoke(string $connector, #[MapRequestPayload()] TransactionDTO $transactionDTO): Response{
        $this->gateway->init($connector);
        $result = $this->gateway->process($transactionDTO);
        return $this->responder->render($result);
    }
}
