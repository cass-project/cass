<?php
namespace Application\AMQP;

use Application\Bundle\GenericBundle;

class AMQPBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}