<?php
namespace CASS\Domain\Bundles\Index;

use CASS\Domain\Bundles\Index\Events\CollectionEvents;
use CASS\Domain\Bundles\Index\Events\CommunityEvents;
use CASS\Domain\Bundles\Index\Events\PostEvents;
use CASS\Domain\Bundles\Index\Events\ProfileEvents;
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