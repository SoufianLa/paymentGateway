<?php

namespace App\Tests\Functionnal\Controller;


use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;
use App\Service\Payment\Contract\IPaymentGateway;
use App\Service\Util\Contract\IResponder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PaymentProcessorEndpointTest extends WebTestCase
{
    public function testPayment(): void
    {
        $client = static::createClient();

        // Mock the gateway and responder services
        $gatewayMock = $this->createMock(IPaymentGateway::class);
        $responderMock = $this->createMock(IResponder::class);

        // Get the container and replace the actual services with mocks
        $container = $client->getContainer();
        $container->set(IPaymentGateway::class, $gatewayMock);
        $container->set(IResponder::class, $responderMock);

        // Configure the gateway mock to initialize and process the transaction
        $gatewayMock->expects($this->once())
            ->method('init')
            ->with('aci');


        $transactionDTO = new TransactionDTO(
            "10", "EUR", "4200000000000000",
            "05", "2034", "111"
        );
        $responseDTO = new ResponseDTO(
            "char_y11p9qECWqWf9RnHqZyukXrv",
            "2024-06-28T17:48:21+00:00",
            "10.00",
            "EUR",
            "420000"
        );
        $jsonResponse = '{"transaction":"char_y11p9qECWqWf9RnHqZyukXrv","date":"2024-06-28T17:48:21+00:00","amount":"10.00","currency:"EUR","cardBin":"420000"}';
        $gatewayMock->expects($this->once())
            ->method('process')
            ->with($this->isInstanceOf(TransactionDTO::class))
            ->willReturn($responseDTO);

        // Configure the responder mock to render the response
        $responderMock->expects($this->once())
            ->method('render')
            ->with($responseDTO)
            ->willReturn(new Response($jsonResponse, Response::HTTP_OK, ['content-type' => 'application/json']));

        // Make a request to the endpoint
        $client->request(
            'POST',
            '/api/payment/aci',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($transactionDTO->toArray()) // Convert the DTO to JSON
        );

        // Assert the response status code and content type
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertSame($jsonResponse, $client->getResponse()->getContent());


    }
}
