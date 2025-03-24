<?php

namespace App\MessageHandler;

use App\Message\EntityCreate;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EntityCreateHandler extends BaseEntityHendler
{
    public function __invoke(EntityCreate $message): void
    {
        $entity = $message->getEntity();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
