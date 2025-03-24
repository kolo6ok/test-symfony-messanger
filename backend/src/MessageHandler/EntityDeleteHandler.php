<?php

namespace App\MessageHandler;

use App\Message\EntityDelete;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EntityDeleteHandler extends BaseEntityHendler
{
    public function __invoke(EntityDelete $message): void
    {
        // do something with your message
    }
}
