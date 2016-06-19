<?php
namespace Domain\Collection\Service;

use Application\Exception\ValidationException;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Community\Entity\Community;
use Domain\Profile\Entity\Profile\Greetings;

class CollectionValidatorsService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CurrentAccountService $currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }

    public function validateIsCollectionOwnedByProfile(Collection $collection, Profile $profile)
    {
        $result = $profile->getCollections()->hasCollection($collection->getId());

        if(! $result) {
            throw new ValidationException(sprintf('You are not an owner of collection `ID:%d`', $collection->getId()));
        }
    }

    public function validateIsCollectionOwnedByCommunity(Collection $collection, Community $community)
    {
        // TODO:: implements
        return true;
    }
}