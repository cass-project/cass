<?php
namespace Domain\Feed\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Feed\Service\EntityRouterService;
use Domain\Post\Entity\Post;
use Domain\Post\Service\PostService;
use Evenement\EventEmitterInterface;

final class PostEvents implements EventsBootstrapInterface
{
    /** @var PostService */
    private $postService;
    
    /** @var EntityRouterService */
    private $entityRouterService;
    
    /** @var FeedSourceFactory */
    private $sourceFactory;

    public function __construct(
        PostService $postService,
        EntityRouterService $entityRouterService,
        FeedSourceFactory $sourceFactory
    ) {
        $this->postService = $postService;
        $this->entityRouterService = $entityRouterService;
        $this->sourceFactory = $sourceFactory;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $ps = $this->postService;
        $er = $this->entityRouterService;
        $sc = $this->sourceFactory;
        
        $ps->getEventEmitter()->on(PostService::EVENT_CREATE, function(Post $post) use ($er, $ps, $sc) {
            $er->upsert($post, [
                $sc->getProfileSource($post->getAuthorProfile()->getId()),
                $sc->getCollectionSource($post->getCollection()->getId()),
                $sc->getPublicDiscussionsSource(),
                $sc->getPublicContentSource(),
            ]);
        });

        $ps->getEventEmitter()->on(PostService::EVENT_UPDATE, function(Post $post) use ($er, $ps, $sc) {
            $er->upsert($post, [
                $sc->getProfileSource($post->getAuthorProfile()->getId()),
                $sc->getCollectionSource($post->getCollection()->getId()),
                $sc->getPublicDiscussionsSource(),
                $sc->getPublicContentSource(),
            ]);
        });

        $ps->getEventEmitter()->on(PostService::EVENT_DELETE, function(Post $post) use ($er, $ps, $sc) {
            $er->delete($post, [
                $sc->getProfileSource($post->getAuthorProfile()->getId()),
                $sc->getCollectionSource($post->getCollection()->getId()),
                $sc->getPublicDiscussionsSource(),
                $sc->getPublicContentSource(),
            ]);
        });
    }
}