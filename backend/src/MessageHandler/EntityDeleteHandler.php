<?php

namespace App\MessageHandler;

use App\Message\EntityDelete;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EntityDeleteHandler extends BaseEntityHendler
{
    public function __invoke(EntityDelete $message): void
    {
        try {
            $this->entityManager->remove($message->getEntity());
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        $this->sendViaWS();
    }

    protected function getTitle(): string
    {
        $title = 'Delete success!';
        if ($this->errors) {
            $title = array_pop($this->errors);
        }

        return $title;
    }

}
