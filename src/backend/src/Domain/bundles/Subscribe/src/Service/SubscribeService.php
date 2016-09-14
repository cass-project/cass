<?php
namespace CASS\Domain\Bundles\Subscribe\Service;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Repository\SubscribeRepository;
use CASS\Domain\Bundles\Theme\Entity\Theme;

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

    public function unSubscribeTheme(Profile $profile, Theme $theme){
        return $this->subscribeRepository->unSubscribeTheme($profile, $theme);
    }

    public function listSubscribedThemes(Profile $profile): array
    {
        return $this->subscribeRepository->findBy([
            'profile_id' => $profile->getId(),
            'type'       => Subscribe::TYPE_THEME
        ]);
    }

    public function subscribeProfile(Profile $profile1, Profile $profile2, $options): Subscribe
    {
        return $this->subscribeRepository->subscribeProfile($profile1, $profile2, $options);
    }

    public function UnSubscribeProfile(Profile $profile1, Profile $profile2){
        return $this->subscribeRepository->unSubscribeProfile($profile1, $profile2);
    }

    public function listSubscribedProfiles(Profile $profile){
        return $this->subscribeRepository->findBy([
            'profile_id' => $profile->getId(),
            'type'       => Subscribe::TYPE_PROFILE
        ]);
    }

    public function subscribeCollection(Profile $profile, Collection $collection, $options): Subscribe
    {
        return $this->subscribeRepository->subscribeCollection($profile, $collection, $options);
    }

    public function unSubscribeCollection(Profile $profile, Collection $collection){
        return $this->subscribeRepository->unSubscribeCollection($profile, $collection);
    }

    public function listSubscribedCollections(Profile $profile): array
    {
        return $this->subscribeRepository->findBy([
            'profile_id' => $profile->getId(),
            'type'       => Subscribe::TYPE_COLLECTION
        ]);
    }

    public function subscribeCommunity(Profile $profile, Community $community, $options = null): Subscribe
    {
        return $this->subscribeRepository->subscribeCommunity($profile, $community, $options);
    }

    public function unSubscribeCommunity(Profile $profile, Community $community){
        return $this->subscribeRepository->unSubscribeCommunity($profile, $community);
    }

    public function listSubscribedCommunities(Profile $profile){
        return $this->subscribeRepository->findBy([
            'profile_id' => $profile->getId(),
            'type'       => Subscribe::TYPE_COMMUNITY
        ]);
    }

    public function getSubscribe(int $id):Subscribe
    {
        return $this->subscribeRepository->getSubscribeById($id);
    }
}