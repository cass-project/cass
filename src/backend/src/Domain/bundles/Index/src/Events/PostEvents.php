<?php
namespace CASS\Domain\Bundles\Index\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Bundles\Index\Service\IndexService;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\Service\PostService;
use Evenement\EventEmitterInterface;

final class PostEvents implements EventsBootstrapInterface
{
    /** @var PostService */
    private $postService;

    /** @var IndexService */
    private $indexService;

    public function __construct(PostService $postService, IndexService $indexService)
    {
        $this->postService = $postService;
        $this->indexService = $indexService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $ps = $this->postService;
        $is = $this->indexService;

        $ps->getEventEmitter()->on(PostService::EVENT_CREATE, function(Post $post) use ($ps, $is) {
            $is->indexEntity($post);
        });

        $ps->getEventEmitter()->on(PostService::EVENT_UPDATE, function(Post $post) use ($ps, $is) {
            $is->indexEntity($post);
        });

        $ps->getEventEmitter()->on(PostService::EVENT_DELETE, function(Post $post) use ($ps, $is) {
            $is->excludeEntity($post);
        });
    }
}