<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;

abstract class AbstractPersonalFeedProcessor extends AbstractPostProcessor
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var SubscribeService */
    protected $subscriptionService;

    public function setCurrentAccountService(CurrentAccountService $currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }
    
    public function setSubscriptionService(SubscribeService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    protected function getCurrentProfileId(): int
    {
        return $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId();
    }
}