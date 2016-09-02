<?php
namespace CASS\Domain\Bundles\Community;

use CASS\Domain\Bundles\Collection\Events\CollectionThemesEQEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array
{
    return [
        CollectionThemesEQEvents::class
    ];
};