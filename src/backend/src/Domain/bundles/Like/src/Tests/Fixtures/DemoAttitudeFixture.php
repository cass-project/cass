<?php

namespace CASS\Domain\Bundles\Like\Tests\Fixtures;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Service\LikeCommunityService;
use CASS\Domain\Bundles\Like\Service\LikeProfileService;
use CASS\Domain\Bundles\Like\Service\LikeThemeService;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use ZEA2\Platform\Bundles\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Zend\Expressive\Application;


class DemoAttitudeFixture implements Fixture
{

    private $attitudes;

    public function getProfileAttitude(string $type= 'like', int $id = 1 ){
        return $this->attitudes[$type][$id-1];
    }

    public function up(Application $app, EntityManager $em){
        // Profile
        $likeProfileService = $app->getContainer()->get(LikeProfileService::class);

        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();

        $profileLike = AttitudeFactory::profileAttitudeFactory($profile);
        $profileLike->setResource($profile);

        $this->attitudes['like'][] = $likeProfileService->addLike($profile, $profileLike);

        // Theme
        $likeThemeService = $app->getContainer()->get(LikeThemeService::class);
        $theme = SampleThemesFixture::getTheme(1);


        $themeLike = AttitudeFactory::profileAttitudeFactory($profile);
        $themeLike
            ->setResource($theme);
        $this->attitudes['like'][] = $likeThemeService->addLike($theme, $themeLike);

        // Community
        $likeCommunityService =  $app->getContainer()->get(LikeCommunityService::class);
        $community = SampleCommunitiesFixture::getCommunity(2);
        $communityLike = AttitudeFactory::profileAttitudeFactory($profile);
        $communityLike->setResource($community);

        $this->attitudes['like'][] = $likeCommunityService->addLike($community, $communityLike);
    }
}