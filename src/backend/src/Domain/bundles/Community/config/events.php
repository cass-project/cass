<?php
namespace Domain\Community;

use DI\Container;
use Domain\Community\Events\DashboardCommunityCollectionEvents;
use Domain\Community\Events\LinkCollectionEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        LinkCollectionEvents::class,
        DashboardCommunityCollectionEvents::class,
    ];
};