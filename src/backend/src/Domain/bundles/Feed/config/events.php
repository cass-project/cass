<?php
namespace Domain\Feed;

use Domain\Feed\Events\CollectionEvents;
use Domain\Feed\Events\ProfileEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        ProfileEvents::class,
        CollectionEvents::class,
    ];
};