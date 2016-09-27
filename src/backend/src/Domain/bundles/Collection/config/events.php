<?php
namespace CASS\Domain\Bundles\Community;

use CASS\Domain\Bundles\Collection\Events\CollectionThemesEQEvents;

return function(): array
{
    return [
        CollectionThemesEQEvents::class
    ];
};