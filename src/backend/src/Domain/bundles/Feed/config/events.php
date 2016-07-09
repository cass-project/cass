<?php
namespace Domain\Feed;

use Domain\Feed\Events\PostEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        PostEvents::class,
    ];
};