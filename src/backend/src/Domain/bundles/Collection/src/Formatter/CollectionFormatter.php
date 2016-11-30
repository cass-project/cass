<?php
namespace CASS\Domain\Bundles\Collection\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Like\Service\LikeCollectionService;
use CASS\Domain\Bundles\Like\Service\LikeService;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

final class CollectionFormatter
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var SubscribeService */
    private $subscribeService;

    /** @var LikeCollectionService  */
    private $likeCollectionService;

    /** @var CurrentIPServiceInterface  */
    private $currentIPService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        SubscribeService $subscribeService,
        LikeCollectionService $likeCollectionService,
        CurrentIPServiceInterface $currentIPService
    ){
        $this->currentAccountService = $currentAccountService;
        $this->subscribeService = $subscribeService;
        $this->likeCollectionService = $likeCollectionService;
        $this->currentIPService = $currentIPService;
    }

    public function formatMany(array $collections)
    {
        return array_map(function(Collection $collection) {
            return $this->formatOne($collection);
        }, $collections);
    }

    public function formatOne(Collection $collection)
    {
        $isSubscribedTo = $this->currentAccountService->isAvailable()
            ? $this->subscribeService->hasSubscribe(
                $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId(),
                Subscribe::TYPE_COLLECTION,
                $collection->getId())
            : false;

        $attitudeState = null;


        return array_merge($collection->toJSON(), [
            'subscribed' => $isSubscribedTo,
            'likes' => [
                'state' => $attitudeState,
                'likes' => $collection->getLikes(),
                'dislikes' => $collection->getDislikes()
            ]
        ]);
    }
}