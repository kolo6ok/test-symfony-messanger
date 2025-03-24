<?php

namespace App\MessageHandler;

use App\Message\EntityStore;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EntityStoreHandler
{
    public function __invoke(EntityStore $message): void
    {
        // do something with your message
    }
}
