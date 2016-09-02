<?php
namespace CASS\Domain\Bundles\ProfileCommunities;

use CASS\Domain\Bundles\ProfileCommunities\Events\CommunityEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        CommunityEvents::class
    ];
};