<?php

namespace App\MessageHandler;

use App\Message\EntityCreate;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EntityCreateHandler
{
    public function __invoke(EntityCreate $message): void
    {
        $entity = $message->getEntity();
        $a = 1;
    }
}
