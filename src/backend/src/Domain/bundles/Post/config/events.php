<?php
namespace CASS\Domain\Post;

use CASS\Domain\Post\Events\LinkAttachmentsEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array {
    return [
        LinkAttachmentsEvents::class,
    ];
};