<?php
namespace CASS\Domain\Bundles\ProfileCommunities;

use CASS\Domain\Bundles\ProfileCommunities\Events\CommunityEvents;
use Evenement\EventEmitterInterface;

return function(): array
{
    return [
        CommunityEvents::class
    ];
};