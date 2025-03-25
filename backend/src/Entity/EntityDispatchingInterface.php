<?php

namespace App\Entity;

interface EntityDispatchingInterface
{

    public function fillFromEntity(EntityDispatchingInterface $entity): void;

    public function getTitle(): string;
}