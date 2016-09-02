<?php
namespace CASS\Domain\Community;

use DI\Container;
use CASS\Domain\Community\Events\DashboardCommunityCollectionEvents;
use CASS\Domain\Community\Events\LinkCollectionEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        LinkCollectionEvents::class,
        DashboardCommunityCollectionEvents::class,
    ];
};