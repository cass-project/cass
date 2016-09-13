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

    public function listSubscribedThemes(Profile $profile){

    }

    public function subscribeProfile(Profile $profile1, Profile $profile2){

    }

    public function unSubscribeProfile(Profile $profile1, Profile $profile2){

    }

    public function listSubscribedProfiles(Profile $profile){

    }

    public function subscribeCollection(Profile $profile, Collection $collection){

    }

    public function unSubscribeCollection(Profile $profile, Collection $collection){

    }

    public function listSubscribedCollections(Profile $profile){

    }

    public function subscribeCommunity(Profile $profile, Community $community){

    }

    public function unSubscribeCommunity(Profile $profile, Community $community){

    }

    public function listSubscribedCommunities(Profile $profile){

    }

    public function getSubscribe(int $id):Subscribe
    {
        return $this->subscribeRepository->getSubscribeById($id);
    }
}