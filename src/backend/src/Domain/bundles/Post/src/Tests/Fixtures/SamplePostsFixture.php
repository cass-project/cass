<?php
namespace Domain\Post\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Post\Entity\Post;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\Service\PostService;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
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
        $postService = $app->getContainer()->get(PostService::class);

        for($i = 0; $i < 10; $i++)
        {
            self::$posts[$i] = $postService->createPost(new CreatePostParameters(
                DemoProfileFixture::getProfile()->getId(),
                SampleCollectionsFixture::getProfileCollection(1)->getId(),
                'Demo post content',
                [],
                []
            ));
        }
    }
}