<?php
namespace CASS\Domain\Bundles\Community;

use CASS\Domain\Bundles\Profile\Events\LinkCollectionEvents;
use CASS\Domain\Bundles\Profile\Events\ProfileCardEvents;
use CASS\Domain\Bundles\Profile\Events\ProfileDashboardCollectionEvents;
use CASS\Domain\Bundles\Profile\Events\ProfileExpertInEQEvents;
use CASS\Domain\Bundles\Profile\Events\ProfileInterestingInEQEvents;

return function(): array
{
    return [
        LinkCollectionEvents::class,
        ProfileDashboardCollectionEvents::class,
        ProfileExpertInEQEvents::class,
        ProfileInterestingInEQEvents::class,
        ProfileCardEvents::class,
    ];
};