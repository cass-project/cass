<?php
namespace CASS\Domain\ProfileCommunities;

use CASS\Domain\ProfileCommunities\Events\CommunityEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        CommunityEvents::class
    ];
};