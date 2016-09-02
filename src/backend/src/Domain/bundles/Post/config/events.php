<?php
namespace CASS\Domain\Bundles\Post;

use CASS\Domain\Bundles\Post\Events\LinkAttachmentsEvents;
use Evenement\EventEmitterInterface;

return function(): array {
    return [
        LinkAttachmentsEvents::class,
    ];
};