<?php
namespace CASS\Domain\Bundles\Subscribe\Service;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Repository\SubscribeRepository;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Util\Seek;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class SubscribeService
{
    protected $subscribeRepository;

    public function __construct(SubscribeRepository $subscribeRepository)
    {
       $this->subscribeRepository = $subscribeRepository;
    }

    public function subscribeTheme(Profile $profile, Theme $theme, $options = null): Subscribe
    {
        return $this->subscribeRepository->subscribeTheme($profile, $theme, $options);
    }

    public function unSubscribeTheme(Profile $profile, Theme $subscribe)
    {
        $criteria = ['profile_id' => $profile->getId(), 'subscribe_id' => $subscribe->getId(), 'type' => Subscribe::TYPE_THEME ];
        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedThemes(Profile $profile, Seek $seek): array
    {
        return $this->subscribeRepository->findBy(
            [
                'profile_id' => $profile->getId(),
                'type' => Subscribe::TYPE_THEME,
            ],
            ['id' => 'DESC'],
            $seek->getLimit(),
            $seek->getOffset()
        );
    }

    public function subscribeProfile(Profile $profile1, Profile $profile2, $options): Subscribe
    {
        return $this->subscribeRepository->subscribeProfile($profile1, $profile2, $options);
    }

    public function unSubscribeProfile(Profile $profile, Profile $subscribe)
    {
        $criteria = ['profile_id' => $profile->getId(), 'subscribe_id' => $subscribe->getId(), 'type' => Subscribe::TYPE_PROFILE ];
        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedProfiles(Profile $profile, Seek $seek){
        return $this->subscribeRepository->findBy(
            [
                'profile_id' => $profile->getId(),
                'type'       => Subscribe::TYPE_PROFILE
            ],
            ['id' => 'DESC'],
            $seek->getLimit(),
            $seek->getOffset()
        );
    }

    public function subscribeCollection(Profile $profile, Collection $collection, $options): Subscribe
    {
        return $this->subscribeRepository->subscribeCollection($profile, $collection, $options);
    }

    public function unSubscribeCollection(Profile $profile, Collection $collection)
    {
        $criteria = ['profile_id' => $profile->getId(), 'subscribe_id' => $collection->getId(), 'type' => Subscribe::TYPE_COLLECTION ];
        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedCollections(Profile $profile, Seek $seek): array
    {
        return $this->subscribeRepository->findBy(
            [
                'profile_id' => $profile->getId(),
                'type'       => Subscribe::TYPE_COLLECTION
            ],
            ['id' => 'DESC'],
            $seek->getLimit(),
            $seek->getOffset()
        );
    }

    public function subscribeCommunity(Profile $profile, Community $community, $options = null): Subscribe
    {
        return $this->subscribeRepository->subscribeCommunity($profile, $community, $options);
    }

    public function unSubscribeCommunity(Profile $profile, Community $community)
    {
        $criteria = ['profile_id' => $profile->getId(), 'subscribe_id' => $community->getId(), 'type' => Subscribe::TYPE_COMMUNITY ];
        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedCommunities(Profile $profile, Seek $seek): array
    {
        return $this->subscribeRepository->findBy(
            [
                'profile_id' => $profile->getId(),
                'type'       => Subscribe::TYPE_COMMUNITY
            ],
            ['id' => 'DESC'],
            $seek->getLimit(),
            $seek->getOffset()
        );
    }

    public function getSubscribe(int $id):Subscribe
    {
        return $this->subscribeRepository->getSubscribeById($id);
    }
}