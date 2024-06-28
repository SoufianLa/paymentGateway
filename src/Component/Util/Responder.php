<?php

namespace App\Component\Util;

use App\Service\Util\Contract\IResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class Responder implements IResponder
{
    public function __construct(readonly private SerializerInterface $serializer)
    {
    }

    public function render($data, $statusCode = Response::HTTP_OK, $groups = [],
        $headers =  ["Content-Type" => "application/json"]): Response
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups($groups)
            ->toArray();

        return new Response(
            $this->serializer->serialize($data, 'json', $context),
            $statusCode,
            $headers
        );
    }
}