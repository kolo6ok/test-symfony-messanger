<?php

namespace App\Message;

use App\Entity\EntityDispatchingInterface;

class BaseEntityMessage implements EntityEventMessageInterface
{

    public function __construct(readonly protected EntityDispatchingInterface $entity)
    {
    }

    public function getEntity(): EntityDispatchingInterface
    {
        return $this->entity;
    }

}