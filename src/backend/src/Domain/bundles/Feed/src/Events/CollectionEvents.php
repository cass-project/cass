<?php
namespace Domain\Feed\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Feed\Service\EntityRouterService;
use Domain\Post\Entity\Post;
use Domain\Post\Service\PostService;
use Evenement\EventEmitterInterface;

final class CollectionEvents implements EventsBootstrapInterface
{
    /** @var PostService */
    private $postService;
    
    /** @var EntityRouterService */
    private $entityRouterService;
    
    /** @var FeedSourceFactory */
    private $sourceFactory;
    
    public function up(EventEmitterInterface $globalEmitter)
    {
        $ps = $this->postService;
        $er = $this->entityRouterService;
        
        $ps->getEventEmitter()->on(PostService::EVENT_CREATE, function(Post $post) use ($er, $ps) {
            $er->create($post, [
                
            ]);
        });
    }
}