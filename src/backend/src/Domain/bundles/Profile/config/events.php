<?php
namespace Domain\Community;

use Domain\Profile\Events\LinkCollectionEvents;
use Domain\Profile\Events\ProfileDashboardCollectionEvents;
use Domain\Profile\Events\ProfileExpertInEQEvents;
use Domain\Profile\Events\ProfileInterestingInEQEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        LinkCollectionEvents::class,
        ProfileDashboardCollectionEvents::class,
        ProfileExpertInEQEvents::class,
        ProfileInterestingInEQEvents::class
    ];
};