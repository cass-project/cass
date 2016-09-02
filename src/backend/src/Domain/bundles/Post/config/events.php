<?php
namespace CASS\Domain\Bundles\Post;

use CASS\Domain\Bundles\Post\Events\LinkAttachmentsEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array {
    return [
        LinkAttachmentsEvents::class,
    ];
};