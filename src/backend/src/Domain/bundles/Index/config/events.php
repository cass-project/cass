<?php
namespace CASS\Domain\Index;

use CASS\Domain\Index\Events\CollectionEvents;
use CASS\Domain\Index\Events\CommunityEvents;
use CASS\Domain\Index\Events\PostEvents;
use CASS\Domain\Index\Events\ProfileEvents;
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