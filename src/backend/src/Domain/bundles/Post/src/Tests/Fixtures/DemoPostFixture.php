<?php
namespace Domain\Post\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Post\Entity\Post;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\Service\PostService;
use Zend\Expressive\Application;

class DemoPostFixture implements Fixture
{
    /** @var Post */
    static private $post;

    static public function getPost() {
        return self::$post;
    }

    public function up(Application $app, EntityManager $em) {
        $postService = $app->getContainer()->get(PostService::class);

        /** @var Post post */
        self::$post = $postService->createPost(
            new CreatePostParameters(
                DemoAccountFixture::getAccount()->getCurrentProfile()->getId(),
                DemoCollectionFixture::getCollection()->getId(),
                'string', [], []
            )
        );
    }
}