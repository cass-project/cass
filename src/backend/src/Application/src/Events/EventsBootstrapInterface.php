<?php
namespace CASS\Application\Events;

use Evenement\EventEmitterInterface;

interface EventsBootstrapInterface
{
    public function up(EventEmitterInterface $globalEmitter);
}