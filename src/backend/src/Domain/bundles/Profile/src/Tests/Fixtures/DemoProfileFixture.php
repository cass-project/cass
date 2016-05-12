<?php
namespace Domain\Profile\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Entity\ProfileImage;
use Zend\Expressive\Application;

class DemoProfileFixture implements Fixture
{
    /** @var Profile */
    private static $profile;

    const DEFAULTS = [
        'gender' => Profile::GENDER_MALE
    ];
    
    public function up(Application $app, EntityManager $em) {
        self::$profile = DemoAccountFixture::getAccount()->getProfiles()->first();
    }

    public static function getProfile(): Profile {
        return self::$profile;
    }
}