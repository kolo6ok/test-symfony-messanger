<?php

namespace App\MessageHandler;

use App\Message\EntityCreate;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EntityCreateHandler extends BaseEntityHendler
{
    private \App\Entity\EntityDispatchingInterface $entity;

    public function __invoke(EntityCreate $message): void
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
        $title = sprintf('Create "%s" success!', $this->entity->getTitle());
        if ($this->errors) {
            $title = array_pop($this->errors);
        }

        return $title;
    }

}
