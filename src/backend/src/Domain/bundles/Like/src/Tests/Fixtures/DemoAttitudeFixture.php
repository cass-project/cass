<?php

namespace CASS\Domain\Bundles\Like\Tests\Fixtures;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Service\LikeProfileService;
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
        $likeProfileService = $app->getContainer()->get(LikeProfileService::class);

        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();

        $profileLike = Attitude::profileAttitudeFactory($profile);
        $profileLike->setResourceType(Attitude::RESOURCE_TYPE_PROFILE)
        ->setResourceId($profile->getId());

        $this->attitudes['like'][] = $likeProfileService->addLike($profile, $profileLike);
    }
}