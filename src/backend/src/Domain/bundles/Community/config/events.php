<?php
namespace Domain\Community;

use Application\Exception\PermissionsDeniedException;
use DI\Container;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Service\CollectionService;
use Domain\Community\Service\CommunityService;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $emitter, Container $container)
{
    $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */
    $communityService = $container->get(CommunityService::class); /** @var CommunityService $communityService */
    $collectionService = $container->get(CollectionService::class); /** @var CollectionService $collectionService */

    $collectionEvents = $collectionService->getEventEmitter();

    $collectionEvents->on(CollectionService::EVENT_ACCESS, function(Collection $collection) use ($currentAccountService, $collectionService, $communityService)
    {
        if($collection->getOwnerType() === 'community') {
            $community = $communityService->getCommunityById((int) $collection->getOwnerId());

            if($community->getMetadata()['creatorAccountId'] !== $currentAccountService->getCurrentAccount()->getId()) {
                throw new PermissionsDeniedException('You\'re not a community owner');
            }
        }
    });

    $collectionEvents->on(CollectionService::EVENT_CREATED, function(Collection $collection) use ($collectionService, $communityService)
    {
        if($collection->getOwnerType() === 'community') {
            $communityService->linkCollection((int) $collection->getOwnerId(), $collection->getId());
        }
    });

    $collectionEvents->on(CollectionService::EVENT_DELETE, function(Collection $collection) use ($collectionService, $communityService)
    {
        if($collection->getOwnerType() === 'community') {
            $communityService->unlinkCollection((int) $collection->getOwnerId(), $collection->getId());
        }
    });
};