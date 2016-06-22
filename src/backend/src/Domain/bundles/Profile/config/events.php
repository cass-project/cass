<?php
namespace Domain\Community;

use DI\Container;
use Domain\Profile\Events\LinkCollectionEvents;
use Domain\Profile\Events\ProfileExpertInEQEvents;
use Domain\Profile\Events\ProfileInterestingInEQEvents;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $globalEmitter, Container $container)
{
    $lce = $container->get(LinkCollectionEvents::class); /** @var LinkCollectionEvents $lce */
    $lce->bindEvents();

    $peq_expert = $container->get(ProfileExpertInEQEvents::class); /** @var ProfileExpertInEQEvents $peq */
    $peq_expert->bindEvents();

    $peq_interesting = $container->get(ProfileInterestingInEQEvents::class); /** @var ProfileInterestingInEQEvents $peq */
    $peq_interesting->bindEvents();
};