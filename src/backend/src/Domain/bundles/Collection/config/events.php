<?php
namespace Domain\Community;

use Domain\Collection\Events\CollectionThemesEQEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        CollectionThemesEQEvents::class
    ];
};