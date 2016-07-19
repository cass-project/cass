<?php
namespace Domain\ProfileCommunities;

use Domain\ProfileCommunities\Events\CommunityEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        CommunityEvents::class
    ];
};