<?php

namespace App\Service\Payment\Contract;

interface IConnectorFactory
{
    public function getConnector(string $code): IConnector;

}