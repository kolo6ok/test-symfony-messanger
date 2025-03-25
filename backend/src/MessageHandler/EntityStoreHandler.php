<?php

namespace App\MessageHandler;

use App\Message\EntityStore;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EntityStoreHandler extends BaseEntityHendler
{

    private \App\Entity\EntityDispatchingInterface $entity;

    public function __invoke(EntityStore $message): void
    {
        $entity = $message->getEntity();
        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            $this->entityManager->refresh($entity);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }

        $this->entity = $entity;
        $this->sendViaWS();
    }

    protected function getTitle(): string
    {
        $title = sprintf('Update "%s" success!', $this->entity->getTitle());
        if ($this->errors) {
            $title = array_pop($this->errors);
        }

        return $title;
    }

}
