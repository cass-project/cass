<?php
namespace CASS\Domain\Bundles\Collection\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;

final class CollectionFormatter
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var SubscribeService */
    private $subscribeService;

    public function __construct(CurrentAccountService $currentAccountService, SubscribeService $subscribeService)
    {
        $this->currentAccountService = $currentAccountService;
        $this->subscribeService = $subscribeService;
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

        return array_merge($collection->toJSON(), [
            'subscribed' => $isSubscribedTo
        ]);
    }
}