<?php
namespace Domain\Feed;

use Domain\Feed\Events\CollectionEvents;
use Domain\Feed\Events\CommunityEvents;
use Domain\Feed\Events\PostEvents;
use Domain\Feed\Events\ProfileEvents;

use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        ProfileEvents::class,
        CollectionEvents::class,
        CommunityEvents::class,
        PostEvents::class,
    ];
};