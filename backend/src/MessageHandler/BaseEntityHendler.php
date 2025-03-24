<?php

namespace App\MessageHandler;

use Doctrine\ORM\EntityManagerInterface;

class BaseEntityHendler
{

    public function __construct(readonly protected EntityManagerInterface $entityManager)
    {
    }
}