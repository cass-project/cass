<?php
namespace Domain\Community;

use DI\Container;
use Domain\Profile\Events\LinkCollectionEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter, Container $container)
{
    $lce = $container->get(LinkCollectionEvents::class); /** @var LinkCollectionEvents $lce */
    $lce->bindEvents();
};