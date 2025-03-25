<?php

namespace App\MessageHandler;

use App\Message\EntityEventMessageInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class BaseEntityHendler
{

    protected array $errors = [];

    public function __construct(readonly protected EntityManagerInterface $entityManager)
    {
    }

    protected function sendViaWS()
    {
        $title = $this->getTitle();
        $context = $this->getContext();
    }

    abstract protected function getTitle(): string;

    protected function getContext(): array
    {
        return [
            'type' => empty($this->errors) ? 'success' : 'error',
        ];
    }
}