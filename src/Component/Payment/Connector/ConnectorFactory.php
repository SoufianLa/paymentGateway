<?php

namespace App\Component\Payment\Connector;

use App\ErrorHandler\Exception\ApiException;
use App\Service\Payment\Contract\IConnector;
use App\Service\Payment\Contract\IConnectorFactory;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\HttpFoundation\Response;


final class ConnectorFactory implements IConnectorFactory
{
    public function __construct(
        #[AutowireIterator('connector')]
        private iterable $connectors
    ) {
    }

    public function getConnector(string $code): IConnector
    {
        /** @var IConnector $connectors */
        foreach ($this->connectors as $connector) {
            if ($connector->supportCode($code)) {
                return $connector;
            }
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, 'Payment connector not found');
    }


}