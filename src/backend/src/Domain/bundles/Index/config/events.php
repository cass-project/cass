<?php
namespace Domain\Index;

use Domain\Index\Events\CollectionEvents;
use Domain\Index\Events\CommunityEvents;
use Domain\Index\Events\PostEvents;
use Domain\Index\Events\ProfileEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        CollectionEvents::class,
        CommunityEvents::class,
        ProfileEvents::class,
        PostEvents::class,
    ];
};