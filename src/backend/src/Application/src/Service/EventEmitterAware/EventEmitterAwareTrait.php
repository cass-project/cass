<?php
namespace Application\Service\EventEmitterAware;

use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;

trait EventEmitterAwareTrait
{
    /** @var EventEmitterInterface */
    private $eventEmitter;

    public function getEventEmitter(): EventEmitterInterface
    {
        if($this->eventEmitter === null) {
            $this->eventEmitter = new EventEmitter();
        }

        return $this->eventEmitter;
    }
}