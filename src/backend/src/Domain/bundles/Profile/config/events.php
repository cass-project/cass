<?php
namespace Domain\Community;

use Application\Exception\PermissionsDeniedException;
use DI\Container;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Service\ProfileService;
use Evenement\EventEmitterInterface;

return function(EventEmitterInterface $emitter, Container $container)
{
    $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */
    $profileService = $container->get(ProfileService::class); /** @var ProfileService $collectionService */
    $collectionService = $container->get(CollectionService::class); /** @var CollectionService $collectionService */

    $collectionEvents = $collectionService->getEventEmitter();

    $collectionEvents->on(CollectionService::EVENT_ACCESS, function(Collection $collection) use ($currentAccountService, $collectionService, $profileService)
    {
        if($collection->getOwnerType() === 'profile') {
            $profile = $profileService->getProfileById((int) $collection->getOwnerId());

            if(! $currentAccountService->getCurrentAccount()->getProfiles()->contains($profile)) {
                throw new PermissionsDeniedException('You\'re not a profile owner');
            }
        }
    });

    $collectionEvents->on(CollectionService::EVENT_CREATED, function(Collection $collection) use ($collectionService, $profileService)
    {
        if($collection->getOwnerType() === 'profile') {
            $profileService->linkCollection((int) $collection->getOwnerId(), $collection->getId());
        }
    });

    $collectionEvents->on(CollectionService::EVENT_DELETE, function(Collection $collection) use ($collectionService, $profileService)
    {
        if($collection->getOwnerType() === 'profile') {
            $profileService->unlinkCollection((int) $collection->getOwnerId(), $collection->getId());
        }
    });
};