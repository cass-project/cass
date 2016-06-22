<?php
namespace Domain\Community;

use DI\Container;
use Domain\Collection\Events\CollectionThemesEQEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter, Container $container)
{
    $cte = $container->get(CollectionThemesEQEvents::class); /** @var CollectionThemesEQEvents $cte */
    $cte->bindEvents();
};