<?php
namespace CASS\Chat\Bundles\Contact\Service;

use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Repository\SubscribeRepository;
use CASS\Util\Seek;

class SubscribeProfileContactService implements IContactService
{

    /**
     * @var SubscribeRepository
     */
    private $subscribeRepository;

    public function __construct(SubscribeRepository $subscribeRepository)
    {
        $this->subscribeRepository = $subscribeRepository;
    }

    public function getContacts(Profile $profile, Seek $seek): array
    {

        $subsribes = $this->subscribeRepository->findBy([
            'profileId' => $profile->getId(),
            'subscribeType' => Subscribe::TYPE_PROFILE
        ]);

        $contacts = array_map(function(Subscribe $subsribe){
            return $subsribe->getProfileId();
        }, $subsribes);


        return $contacts;
    }

}