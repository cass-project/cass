<?php
namespace Domain\Post;

use Domain\Post\Events\LinkAttachmentsEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array {
    return [
        LinkAttachmentsEvents::class,
    ];
};