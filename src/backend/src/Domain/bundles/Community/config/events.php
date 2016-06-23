<?php
namespace Domain\Community;

use DI\Container;
use Domain\Community\Events\DashboardCommunityCollectionEvents;
use Domain\Community\Events\LinkCollectionEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter, Container $container)
{
    $lce = $container->get(LinkCollectionEvents::class); /** @var LinkCollectionEvents $lce */
    $lce->bindEvents();

    $dcce = $container->get(DashboardCommunityCollectionEvents::class); /** @var DashboardCommunityCollectionEvents $dcce */
    $dcce->bindEvents();
};