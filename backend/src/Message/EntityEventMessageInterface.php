<?php

namespace App\Message;

use App\Entity\EntityDispatchingInterface;

interface EntityEventMessageInterface
{

    public function getEntity(): EntityDispatchingInterface;

}