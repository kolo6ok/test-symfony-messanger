<?php

namespace App\Controller;

use App\Message\EntityEventMessageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Exception\ExceptionInterface;

trait DispatchAndResponse
{

    /**
     * @throws ExceptionInterface
     */
    protected function dispatchAndResponse(EntityEventMessageInterface $message, ?array $additionData = null): JsonResponse
    {
        $this->messageBus->dispatch($message);
        return new JsonResponse($additionData, 202);
    }

}