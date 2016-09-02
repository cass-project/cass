<?php
namespace CASS\Domain\Bundles\Post\Tests\Fixtures;

use ZEA2\Platform\Bundles\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\Parameters\CreatePostParameters;
use CASS\Domain\Bundles\Post\PostType\Types\DefaultPostType;
use CASS\Domain\Bundles\Post\Service\PostService;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use Zend\Expressive\Application;

class SamplePostsFixture implements Fixture
{
    /** @var Post[] */
    static private $posts = [];

    static public function getPost(int $index)
    {
        return self::$posts[$index];
    }

    public function up(Application $app, EntityManager $em)
    {
        $postService = $app->getContainer()->get(PostService::class); /** @var PostService $postService */

        for($i = 0; $i < 10; $i++) {
            self::$posts[$i] = $postService->createPost(new CreatePostParameters(
                DefaultPostType::CODE_INT,
                DemoAccountFixture::getAccount()->getCurrentProfile()->getId(),
                SampleCollectionsFixture::getProfileCollection(1)->getId(),
                'Demo Post Content',
                []
            ));
        }
    }
}