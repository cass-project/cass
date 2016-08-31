<?php
namespace Domain\Profile\Tests\Fixtures;

use CASS\Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Zend\Expressive\Application;

class DemoProfileFixture implements Fixture
{
    /** @var Profile */
    private static $profile;

    const DEFAULTS = [
        'gender' => Profile\Gender\GenderMale::STRING_CODE
    ];

    public function up(Application $app, EntityManager $em)
    {
        self::$profile = DemoAccountFixture::getAccount()->getProfiles()->first();
    }

    public static function getProfile(): Profile
    {
        return self::$profile;
    }
}