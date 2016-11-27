<?php
namespace CASS\Domain\Bundles\Subscribe\Service;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Repository\SubscribeRepository;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Util\Seek;

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
        $criteria = [
            'profileId' => $profile->getId(),
            'subscribeId' => $subscribe->getId(),
            'subscribeType' => Subscribe::TYPE_THEME
        ];

        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedThemes(Profile $profile, Seek $seek): array
    {
        return $this->subscribeRepository->findBy(
            [
                'profileId' => $profile->getId(),
                'subscribeType' => Subscribe::TYPE_THEME,
            ],
            ['id' => 'DESC'],
            $seek->getLimit(),
            $seek->getOffset()
        );
    }

    public function subscribeProfile(Profile $profile, Profile $subscribe, $options = null): Subscribe
    {
        return $this->subscribeRepository->subscribeProfile($profile, $subscribe, $options);
    }

    public function unSubscribeProfile(Profile $profile, Profile $subscribe)
    {
        $criteria = [
            'profileId' => $profile->getId(),
            'subscribeId' => $subscribe->getId(),
            'subscribeType' => Subscribe::TYPE_PROFILE
        ];

        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedProfiles(Profile $profile, Seek $seek){
        return $this->subscribeRepository->findBy(
            [
                'profileId' => $profile->getId(),
                'subscribeType' => Subscribe::TYPE_PROFILE
            ],
            ['id' => 'DESC'],
            $seek->getLimit(),
            $seek->getOffset()
        );
    }

    public function subscribeCollection(Profile $profile, Collection $collection, $options = null): Subscribe
    {
        return $this->subscribeRepository->subscribeCollection($profile, $collection, $options);
    }

    public function unSubscribeCollection(Profile $profile, Collection $collection)
    {
        $criteria = [
            'profileId' => $profile->getId(),
            'subscribeId' => $collection->getId(),
            'subscribeType' => Subscribe::TYPE_COLLECTION
        ];

        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedCollections(Profile $profile, Seek $seek): array
    {
        return $this->subscribeRepository->findBy(
            [
                'profileId' => $profile->getId(),
                'subscribeType' => Subscribe::TYPE_COLLECTION
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
        $criteria = [
            'profileId' => $profile->getId(),
            'subscribeId' => $community->getId(),
            'subscribeType' => Subscribe::TYPE_COMMUNITY
        ];

        return $this->subscribeRepository->unSubscribeByCriteria($criteria);
    }

    public function listSubscribedCommunities(Profile $profile, Seek $seek): array
    {
        return $this->subscribeRepository->findBy(
            [
                'profileId' => $profile->getId(),
                'subscribeType'       => Subscribe::TYPE_COMMUNITY
            ],
            ['id' => 'DESC'],
            $seek->getLimit(),
            $seek->getOffset()
        );
    }

    public function hasSubscribe(int $targetProfileId, int $subscribeType, int $subscribeId): bool
    {
        return $this->subscribeRepository->hasSubscribe($targetProfileId, $subscribeType, $subscribeId);
    }

    public function listWhoSubscribedToTheme(int $themeId): array
    {
        return $this->subscribeRepository->listWhoSubscribedToTheme($themeId);
    }

    public function listWhoSubscribedToProfile(int $profileId): array
    {
        return $this->subscribeRepository->listWhoSubscribedToProfile($profileId);
    }

    public function listWhoSubscribedToCollection(int $collectionId): array
    {
        return $this->subscribeRepository->listWhoSubscribedToCollection($collectionId);
    }

    public function listWhoSubscribedToCommunity(int $communityId): array
    {
        return $this->subscribeRepository->listWhoSubscribedToCommunity($communityId);
    }
}