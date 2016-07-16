<?php
namespace Domain\PostAttachment;

use Domain\PostAttachment\Events\PostEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter): array {
    return [
        PostEvents::class,
    ];
};