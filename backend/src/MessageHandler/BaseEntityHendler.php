<?php

namespace App\MessageHandler;

use Doctrine\ORM\EntityManagerInterface;

class BaseEntityHendler
{

    public function __construct(readonly private EntityManagerInterface $entityManager)
    {
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}