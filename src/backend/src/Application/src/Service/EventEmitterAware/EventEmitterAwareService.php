<?php
namespace Application\Service\EventEmitterAware;

use Evenement\EventEmitterInterface;

interface EventEmitterAwareService
{
    public function getEventEmitter(): EventEmitterInterface;
}