<?php
namespace CASS\Domain\Community;

use CASS\Domain\Profile\Events\LinkCollectionEvents;
use CASS\Domain\Profile\Events\ProfileDashboardCollectionEvents;
use CASS\Domain\Profile\Events\ProfileExpertInEQEvents;
use CASS\Domain\Profile\Events\ProfileInterestingInEQEvents;
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