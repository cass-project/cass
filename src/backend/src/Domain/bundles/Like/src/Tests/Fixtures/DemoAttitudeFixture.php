<?php

namespace CASS\Domain\Bundles\Like\Tests\Fixtures;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Service\LikeCollectionService;
use CASS\Domain\Bundles\Like\Service\LikeCommunityService;
use CASS\Domain\Bundles\Like\Service\LikePostService;
use CASS\Domain\Bundles\Like\Service\LikeProfileService;
use CASS\Domain\Bundles\Like\Service\LikeThemeService;
use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use ZEA2\Platform\Bundles\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Zend\Expressive\Application;


class DemoAttitudeFixture implements Fixture
{

    private $attitudes;

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
        $themeLike->setResource($theme);
        $this->attitudes['like'][] = $likeThemeService->addLike($theme, $themeLike);

        // dislike
        $theme2 = SampleThemesFixture::getTheme(2);
        $themeLike = AttitudeFactory::profileAttitudeFactory($profile);
        $themeLike->setResource($theme2);
        $this->attitudes['dislike'][] = $likeThemeService->addDislike($theme2, $themeLike);

        // Community
        $likeCommunityService =  $app->getContainer()->get(LikeCommunityService::class);
        $community = SampleCommunitiesFixture::getCommunity(2);
        $communityLike = AttitudeFactory::profileAttitudeFactory($profile);
        $communityLike->setResource($community);

        $this->attitudes['like'][] = $likeCommunityService->addLike($community, $communityLike);

        // dislike
        $community2 = SampleCommunitiesFixture::getCommunity(1);
        $communityLike = AttitudeFactory::profileAttitudeFactory($profile);
        $communityLike->setResource($community2);

        $this->attitudes['dislike'][] = $likeCommunityService->addDislike($community2, $communityLike);

        // collection
        $likeCollectionService = $app->getContainer()->get(LikeCollectionService::class);
        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $collectionAttitude = AttitudeFactory::profileAttitudeFactory($profile);
        $collectionAttitude->setResource($collection);

        $this->attitudes['like'][] = $likeCollectionService->addLike($collection, $collectionAttitude);
        // Dislike
        $collection2 = SampleCollectionsFixture::getCommunityCollection(2);
        $collectionAttitude = AttitudeFactory::profileAttitudeFactory($profile);
        $collectionAttitude->setResource($collection2);

        $this->attitudes['dislike'][] = $likeCollectionService->addDislike($collection2, $collectionAttitude);

        // POST
        $likePostService = $app->getContainer()->get(LikePostService::class);
        $post = SamplePostsFixture::getPost(1);
        $postAttitude = AttitudeFactory::profileAttitudeFactory($profile);
        $postAttitude->setResource($post);

        $this->attitudes['like'][] = $likePostService->addLike($post, $postAttitude);
        // Dislike
        $post2 = SamplePostsFixture::getPost(2);
        $postAttitude = AttitudeFactory::profileAttitudeFactory($profile);
        $postAttitude->setResource($post2);

        $this->attitudes['dislike'][] = $likePostService->addDislike($post2, $postAttitude);
    }
}