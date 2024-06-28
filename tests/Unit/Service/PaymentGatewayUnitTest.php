<?php

namespace App\Tests\Unit\Service;

use App\DTO\ResponseDTO;
use App\DTO\TransactionDTO;
use App\Service\Payment\Contract\IConnector;
use App\Service\Payment\Contract\IConnectorFactory;
use App\Service\Payment\Contract\IPaymentGateway;
use App\Service\Payment\PaymentGateway;
use PHPUnit\Framework\TestCase;

class PaymentGatewayUnitTest extends TestCase
{
    private IConnectorFactory $connectorFactoryMock;
    private IConnector $connectorMock;
    private IPaymentGateway $paymentGateway;

    protected function setUp(): void
    {
        // Create mocks for IConnectorFactory and IConnector
        $this->connectorFactoryMock = $this->createMock(IConnectorFactory::class);
        $this->connectorMock = $this->createMock(IConnector::class);

        // Create an instance of the PaymentGateway service with mocks injected
        $this->paymentGateway = new PaymentGateway($this->connectorFactoryMock);
    }

    public function testInit()
    {
        // Define expectations on the connector factory mock
        $this->connectorFactoryMock->expects($this->once())
            ->method('getConnector')
            ->with('test_connector_code')
            ->willReturn($this->connectorMock);

        // Call the init method with a test connector code
        $this->paymentGateway->init('test_connector_code');

        // Use reflection to access the private property $connector
        $reflectionClass = new \ReflectionClass($this->paymentGateway);
        $reflectionProperty = $reflectionClass->getProperty('connector');
        $reflectionProperty->setAccessible(true);
        $storedConnector = $reflectionProperty->getValue($this->paymentGateway);

        // Assert that the stored connector is the same as the mock connector
        $this->assertSame($this->connectorMock, $storedConnector);
    }

    public function testProcess()
    {
        // Define expectations on the connector factory mock
        $this->connectorFactoryMock->expects($this->once())
            ->method('getConnector')
            ->with('test_connector_code')
            ->willReturn($this->connectorMock);

        // Call the init method with a test connector code
        $this->paymentGateway->init('test_connector_code');

        $testTransactionDTO = new TransactionDTO(
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
        $this->connectorMock->expects($this->once())
            ->method('process')
            ->with($testTransactionDTO)
            ->willReturn($responseDTO);

        $result = $this->paymentGateway->process($testTransactionDTO);
        $this->assertSame($responseDTO, $result);

    }


}
